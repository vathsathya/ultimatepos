FROM php:8.3-fpm-alpine

# 1. Setup Environment
ARG USER_ID=1002
ARG GROUP_ID=1002
WORKDIR /var/www

# 2. Install Composer FIRST (Fixed your previous order)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Install System Deps (Consolidated for size)
RUN apk update && apk add --no-cache \
    git curl libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev \
    libxml2-dev zip unzip libzip-dev icu-dev shadow linux-headers $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd intl zip opcache \
    && pecl install redis && docker-php-ext-enable redis \
    && usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data \
    && apk del $PHPIZE_DEPS linux-headers && rm -rf /var/cache/apk/*

# 4. Install PHP Dependencies (Explicit Paths)
COPY composer.json composer.lock /var/www/
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist --no-autoloader

# 5. Copy App & Configs with Permissions (Optimized Layer)
COPY --chown=www-data:www-data . /var/www
COPY --chown=www-data:www-data docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY --chown=www-data:www-data docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# 6. Critical Fix: Generate the missing autoload.php
RUN composer dump-autoload --optimize --no-dev

USER www-data
EXPOSE 9000
CMD ["php-fpm"]