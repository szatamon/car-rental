FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    default-mysql-client \
    git \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-scripts

RUN composer require symfony/maker-bundle --dev --no-scripts

EXPOSE 9000