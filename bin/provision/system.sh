#!/usr/bin/env bash

# Update
sudo apt update
sudo apt upgrade -y

# Locale
sudo apt install -y software-properties-common language-pack-en zip unzip
echo "LC_ALL=en_US.UTF-8" | sudo tee /etc/default/locale
sudo update-locale LANG=en_US.UTF-8

# Timezone
echo 'UTC' | sudo tee /etc/timezone
sudo dpkg-reconfigure -f noninteractive tzdata

# Apache2
sudo apt install -y apache2
sudo a2enmod rewrite

# MySQL
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password ${DB_PASSWORD}"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password ${DB_PASSWORD}"

sudo apt install -y mysql-server

# PHP
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
sudo apt install -y php7.1 php-mbstring php-xml php-mysql composer

# JS
sudo -E "${PROVISION_PATH}/setup_nodejs6.sh"
sudo apt install -y nodejs build-essential
sudo npm install -y --global gulp-cli

# Folders permissions
sudo chmod -R 777 "${PROJECT_PATH}/storage"

# Refresh / Reload
sudo service apache2 restart
sudo service mysql restart
sudo apt autoremove