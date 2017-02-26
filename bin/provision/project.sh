#!/usr/bin/env bash

cd ${PROJECT_PATH}

mysql -u "${DB_USERNAME}" -p"${DB_PASSWORD}" -e "create database \`${DB_DATABASE}\`"
composer install
npm install
php artisan key:generate
php artisan migrate --seed
gulp
