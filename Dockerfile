FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/

COPY . .

RUN composer install --optimize-autoloader --no-scripts

RUN composer require symfony/maker-bundle --dev --no-scripts

RUN composer require nelmio/api-doc-bundle --no-scripts

EXPOSE 9000
