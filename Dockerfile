FROM php:8.3-fpm-alpine

# 1. Setup Environment
ARG USER_ID=1000
ARG GROUP_ID=1000
WORKDIR /var/www

# 2. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Install System Deps & PHP Extensions
RUN apk update && apk add --no-cache \
    git curl libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev \
    libxml2-dev zip unzip libzip-dev icu-dev shadow linux-headers zlib-dev tzdata $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd intl zip opcache \
    && mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/6.0.2.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip-1 \
    && docker-php-ext-install redis \
    && groupmod -g ${GROUP_ID} www-data || true \
    && usermod -u ${USER_ID} www-data || true \
    && apk del $PHPIZE_DEPS linux-headers && rm -rf /var/cache/apk/*

# 4. Install PHP Dependencies (Pure Production)
COPY composer.json composer.lock /var/www/
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --no-interaction --no-plugins --no-scripts --prefer-dist --no-autoloader

# 5. Copy App & Configs
COPY --chown=www-data:www-data . /var/www
COPY --chown=www-data:www-data docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY --chown=www-data:www-data docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# 6. Final Prep: The "Clean Room" Approach
# - Fix Git ownership
# - Delete local dev cache
# - Generate PRODUCTION ONLY autoloader
RUN git config --global --add safe.directory /var/www \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && rm -f bootstrap/cache/config.php bootstrap/cache/packages.php \
    && composer dump-autoload --optimize --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache

USER www-data
EXPOSE 9000
CMD ["php-fpm"]