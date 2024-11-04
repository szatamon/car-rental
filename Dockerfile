# Użycie obrazu PHP z FPM
FROM php:8.2-fpm

# Instalacja wymaganych zależności systemowych
RUN apt-get update && apt-get install -y \
    libpq-dev \
    default-mysql-client \
    git \
    && docker-php-ext-install pdo pdo_mysql

# Dodanie Composer z osobnego obrazu
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ustawienie katalogu roboczego
WORKDIR /var/www/

# Skopiowanie plików projektu do obrazu
COPY . .

# Instalacja zależności projektu
RUN composer install --optimize-autoloader --no-scripts

# Instalacja paczek developerskich (opcjonalnie)
RUN composer require symfony/maker-bundle --dev --no-scripts

# Instalacja NelmioApiDocBundle
RUN composer require nelmio/api-doc-bundle --no-scripts

# Otwieranie portu 9000
EXPOSE 9000
