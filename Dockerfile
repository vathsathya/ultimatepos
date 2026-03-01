# --- STAGE 1: Build Base (PHP Extensions) ---
FROM php:8.3-fpm-alpine AS base

# Install core runtime dependencies (needed in final image)
RUN apk add --no-cache \
    libpng libjpeg-turbo freetype oniguruma libxml2 libzip icu-dev

# Install build dependencies, compile extensions, then remove build-deps in ONE layer
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS linux-headers libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev libxml2-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd intl zip opcache \
    && pecl install redis && docker-php-ext-enable redis \
    && apk del .build-deps

# --- STAGE 2: Composer Build ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./

# ADD THIS FLAG: --ignore-platform-reqs
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist \
    --no-autoloader

# --- STAGE 3: Final Production Image ---
FROM base
ARG USER_ID=1002
ARG GROUP_ID=1002

WORKDIR /var/www

# 1. Handle user permissions without keeping 'shadow' in the image
RUN apk add --no-cache shadow && \
    usermod -u ${USER_ID} www-data && \
    groupmod -g ${GROUP_ID} www-data && \
    apk del shadow

# 2. Copy optimized configurations
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# 3. Copy vendor from the 'vendor' stage
COPY --from=vendor /app/vendor /var/www/vendor

# 4. Copy application code
COPY --chown=www-data:www-data . /var/www

# 5. Final Autoload Optimization (Uses the composer binary from the official image briefly)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload --optimize --no-dev && rm /usr/bin/composer

# 6. Set permissions
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

USER www-data
EXPOSE 9000
CMD ["php-fpm"]