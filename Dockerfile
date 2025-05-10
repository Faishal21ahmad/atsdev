# install php 8.4
FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y ca-certificates \
    update-ca-certificates nano git unzip libzip-dev libonig-dev libxml2-dev libssl-dev \
    libpng-dev libjpeg-dev libfreetype6-dev nginx curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip exif pcntl bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy aplikasi Laravel
COPY apps .

# Install PHP dependencies and generate key
RUN composer install --no-dev --optimize-autoloader

# Copy konfigurasi Nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Expose port yang diperlukan
EXPOSE 80 443 7774 884 9000 3306

# Start Nginx dan PHP-FPM
CMD service nginx start && php-fpm