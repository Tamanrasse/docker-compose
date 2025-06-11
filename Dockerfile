FROM php:8.2-fpm

# Installer dépendances système + Node.js
RUN apt-get update && apt-get install -y \
    curl git unzip zip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g vite

# Installer extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

