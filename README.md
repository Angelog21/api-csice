----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x/installation)

Clone the repository

    git clone https://github.com/Angelog21/api-csice.git

Switch to the repo folder

    cd api-csice

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Create docker containers 

    docker-compose up

Execute docker bash of the cointainer

    docker exec -it [COINTAINER_ID_api-csice] /bin/bash

Install composer dependencies

    composer install

Run the database migrations with the seeds data (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

You can now access the server at http://localhost:8050