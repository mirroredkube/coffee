# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Create a non-root user and group
RUN groupadd -g 1000 appuser && \
    useradd -r -u 1000 -g appuser -m appuser

# Switch to root user to install Composer
USER root

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Switch back to the non-root user
USER appuser

# Copy the local code to the container
COPY --chown=appuser:appuser . .

# Ensure necessary paths exist, and set permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R appuser:appuser storage bootstrap/cache resources/views \
    && chmod -R 775 storage bootstrap/cache resources/views

# Create required directories for Nginx
RUN mkdir -p /var/lib/nginx /var/lib/nginx/body \
    && chown -R www-data:www-data /var/lib/nginx    

# Install Laravel dependencies
RUN composer install

# Optimize Laravel application
RUN php artisan config:cache \
    && php artisan route:cache 

# Configure Nginx
COPY ./nginx.conf /etc/nginx/nginx.conf

# Expose port 80 for Nginx
EXPOSE 80

# Start both Nginx and PHP-FPM using supervisord
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
