#!/usr/bin/env bash

cd ${PROJECT_PATH}

# Backend
mysql -u "${DB_USERNAME}" -p"${DB_PASSWORD}" -e "create database \`${DB_DATABASE}\`"
composer create-project
php artisan migrate --seed

# Front-end
npm install
gulp
