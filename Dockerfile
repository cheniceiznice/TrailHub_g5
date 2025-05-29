# Use the official PHP-Apache image with PHP 8.2
FROM php:8.2-apache

# Enable Apache mod_rewrite 
RUN a2enmod rewrite

# Install Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory to Apache's document root
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Install Laravel PHP dependencies 
RUN composer install --no-dev --optimize-autoloader

# Set proper file and folder permissions for Apache and Laravel
RUN chown -R www-data:www-data /var/www/html \
 && find /var/www/html -type f -exec chmod 644 {} \; \
 && find /var/www/html -type d -exec chmod 755 {} \;

# Change Apache's root directory to Laravel's /public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Allow Apache to access the public directory and follow .htaccess rules
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Generate Laravel application key (required for app to boot)
RUN php artisan key:generate

# Expose port 80 to Render (required for HTTP traffic)
EXPOSE 80

# Start Apache in the foreground 
CMD ["apache2-foreground"]