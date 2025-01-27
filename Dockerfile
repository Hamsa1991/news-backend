# Use the official PHP image with Apache
FROM php:8.2-apache

WORKDIR /var/www/html

# Install required dependencies
RUN a2enmod rewrite
RUN apt-get update && apt-get -y install gcc mono-mcs && rm -rf /var/lib/apt/lists/*
RUN apt-get update -y && apt-get install -y libicu-dev libmariadb-dev unzip zip zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev default-libmysqlclient-dev gcc
RUN apt-get -y update; apt-get -y install curl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP extensions
RUN docker-php-ext-install gettext intl pdo_mysql gd
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd

# Change ownership of the /var/www/html directory
RUN chown -R www-data:www-data /var/www/html
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf
