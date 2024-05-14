# Use an official PHP runtime as a parent image
FROM php:8.3-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        zlib1g-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libxml2-dev \
        libxslt-dev \
        nano \
        default-mysql-client

# Install PHP extensions
RUN docker-php-ext-configure intl && \
    docker-php-ext-install intl pdo pdo_mysql zip gd soap xsl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Composer files for dependency resolution
COPY composer.json composer.lock ./

# Install Symfony dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . .

# Set permissions
RUN chown -R www-data:www-data .

# Expose port 9000 to communicate with Nginx or other web server
EXPOSE 9000

