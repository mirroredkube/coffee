# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
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
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/resources/views \
    && chown -R appuser:appuser storage bootstrap/cache resources/views \
    && chmod -R 775 storage bootstrap/cache resources/views

# Install Laravel dependencies
RUN composer install

# Optimize Laravel application
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
