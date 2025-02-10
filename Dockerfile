# Use the official PHP image with Apache
FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable mod_rewrite for .htaccess support
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy all files from the project directory to the container
COPY . /var/www/html

# Expose port 80 (default for Apache)
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
