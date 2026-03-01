FROM php:8.3-fpm-alpine

ARG USER_ID=1002
ARG GROUP_ID=1002

# Set working directory
WORKDIR /var/www

# Install system dependencies in a single layer to optimize image size
RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    icu-dev \
    # Configure and install PHP extensions
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    opcache \
    # Install Redis extension via github tarball to bypass PECL network timeouts
    && apk add --no-cache pcre-dev $PHPIZE_DEPS linux-headers \
    && mkdir -p /usr/src/php/ext/redis \
    && curl -fsSL https://github.com/phpredis/phpredis/archive/refs/tags/6.0.2.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip-components=1 \
    && docker-php-ext-install redis \
    && apk del pcre-dev $PHPIZE_DEPS linux-headers \
    # Clean up apk cache to reduce image size
    && rm -rf /var/cache/apk/*

# Copy Composer from the official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy custom OPcache configuration
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Copy tuned PHP-FPM pool configuration
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Add shadow to modify the www-data UID/GID to match the host user, enabling seamless volume writes
RUN apk add --no-cache shadow \
    && usermod -u ${USER_ID} www-data \
    && groupmod -g ${GROUP_ID} www-data

# Copy existing application directory contents
COPY . /var/www

# Fix permissions for the mapped user correctly
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]