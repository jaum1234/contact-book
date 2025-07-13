FROM php:8.2-fpm AS base

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    supervisor \
    nginx \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    gd \
    mbstring \
    exif \
    pcntl \
    bcmath \
    sockets 

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

FROM composer:2.2 AS composer_stage
COPY --from=composer /usr/bin/composer /usr/bin/composer

FROM base AS vendor

COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

COPY database/ database/
COPY composer.json composer.lock ./

RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

FROM base AS app

WORKDIR /var/www/html

COPY --from=vendor /var/www/html/vendor/ /var/www/html/vendor/
COPY . .

RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]