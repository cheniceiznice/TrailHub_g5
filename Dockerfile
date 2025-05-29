# Use the official PHP-Apache image
FROM php:8.2-apache

# Enable Apache mod_rewrite (optional, for .htaccess and pretty URLs)
RUN a2enmod rewrite

# Copy project files to Apache root directory
COPY . /var/www/html/

# Set permissions (optional but helpful)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
