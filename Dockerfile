FROM php:8.2-fpm

# Çalışma dizini
WORKDIR /var/www/php

# Gerekli bağımlılıkları yükleyelim
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Composer yükleyelim
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel için gerekli izinleri verelim
COPY . /var/www/php
COPY ./docker/config/entrypoint.sh /opt/entrypoint.sh
COPY ./docker/config/nginx/php-fpm-healthcheck /opt/php-fpm-healthcheck

RUN chown -R www-data:www-data /var/www/php
RUN chmod -R 777 /var/www/php/storage /var/www/php/bootstrap/cache /opt/*.sh /opt/php-fpm-healthcheck

USER root
# Varsayılan komut
CMD ["php-fpm"]
ENTRYPOINT ["/opt/entrypoint.sh"]
