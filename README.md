# Project Documentation

## Requirements

- Docker
- Docker Compose

## Build the Project

To build the project, follow these steps:

1. Navigate to the project directory.
2. Run the following command to build the Docker containers:

   ```bash
   docker-compose build --force-rm --no-cache

   docker-compose up --build -d

3. To run migrations from the car-rental-php Docker container, execute:

   ```bash
   composer install
   
   php bin/console doctrine:migrations:migrate

4. To load fixtures from the car-rental-php Docker container, execute:

   ```bash
   php bin/console doctrine:fixtures:load

## Access the Project
The project is available at: http://localhost:8080

## Static Code Analysis

To perform static code analysis, run the following command from the car-rental-php Docker container:

   ```bash
  vendor/bin/phpstan
   ```
## Run Tests

To run tests, execute the following command from the car-rental-php Docker container:

   ```bash
  vendor/bin/phpunit
   ```
