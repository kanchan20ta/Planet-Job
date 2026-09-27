# syntax=docker/dockerfile:1

FROM php:8.3-fpm AS base

# ---- System dependencies ----
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libwebp-dev \
    libicu-dev \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# ---- PHP extensions required by Laravel 12 ----
# Configure GD with jpeg/freetype/webp support
RUN docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache \
        curl \
        xml \
        dom

# Redis extension (commonly used with Laravel queues/cache)
RUN pecl install redis && docker-php-ext-enable redis

# ---- Composer ----
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---- PHP configuration ----
RUN { \
        echo 'memory_limit=512M'; \
        echo 'upload_max_filesize=64M'; \
        echo 'post_max_size=64M'; \
        echo 'max_execution_time=300'; \
    } > /usr/local/etc/php/conf.d/laravel.ini

# ---- OPcache configuration (production performance) ----
RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=10000'; \
        echo 'opcache.revalidate_freq=0'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'opcache.save_comments=1'; \
        echo 'opcache.jit=1255'; \
        echo 'opcache.jit_buffer_size=64M'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

WORKDIR /var/www/html

# ---- Application code ----
# Copy composer files first to leverage Docker layer caching
COPY composer.json composer.lock ./

# Install dependencies without running scripts (artisan isn't available yet)
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction

# Copy the rest of the application
COPY . .

# Generate optimized autoloader and run composer scripts now that artisan exists
RUN composer dump-autoload --optimize \
    && composer run-script post-autoload-dump --no-interaction || true

# ---- Permissions ----
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
