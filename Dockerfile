# Use the official PHP-Apache image
FROM php:8.2-apache

# Enable Apache mod_rewrite (for Laravel's pretty URLs)
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all project files
COPY . .

# Install Laravel dependencies (includes vendor/)
RUN composer install --no-dev --optimize-autoloader

# Set correct file permissions for Apache
RUN chown -R www-data:www-data /var/www/html \
 && find /var/www/html -type f -exec chmod 644 {} \; \
 && find /var/www/html -type d -exec chmod 755 {} \;

# Update Apache to serve from /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Allow access to the public directory
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Generate Laravel application key
RUN php artisan key:generate

# Expose port 80
EXPOSE 80

# Start Apache in the foreground so Render can keep the container running
CMD ["apache2-foreground"]