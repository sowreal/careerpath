# Use the official PHP image with Apache
FROM php:8.1-apache

# Install dependencies for PHP extensions
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql

# Enable Apache mod_rewrite for pretty URLs
RUN a2enmod rewrite

# Copy your project files to the Docker image
COPY . /var/www/html

# Set permissions for the project files
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
