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

# Set DocumentRoot to /var/www/html/careerpath
RUN sed -i 's|/var/www/html|/var/www/html/careerpath|g' /etc/apache2/sites-available/000-default.conf

# Copy your project files to the Docker image
COPY . /var/www/html/careerpath

# Set permissions for the project files
RUN chown -R www-data:www-data /var/www/html/careerpath && chmod -R 755 /var/www/html/careerpath

# Expose port 80
EXPOSE 80
