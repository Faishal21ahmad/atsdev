# Gunakan image PHP-FPM resmi
FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nano git unzip libzip-dev libonig-dev libxml2-dev libssl-dev \
    libpng-dev libjpeg-dev libfreetype6-dev nginx curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip exif pcntl bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy aplikasi Laravel
COPY apps .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions untuk storage dan cache Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy konfigurasi Nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Expose port yang diperlukan
EXPOSE 80 443 7774 884 9000

# Jalankan Nginx dan PHP-FPM
CMD service nginx start && php-fpm






















# FROM dunglas/frankenphp:latest

# # Set working directory
# WORKDIR /var/www/html

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     libzip-dev \
#     libonig-dev \
#     libxml2-dev \
#     libssl-dev \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j$(nproc) gd pdo_mysql zip exif pcntl bcmath

# # Copy composer.lock and composer.json
# COPY apps/composer.* ./

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Copy the rest of the application
# COPY apps .

# # Copy SSL certificates
# COPY ./ssl /etc/ssl/certs

# # Install PHP dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Set permissions
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Expose port 80 and 443
# EXPOSE 80
# EXPOSE 443
# EXPOSE 7774
# EXPOSE 884

# FROM dunglas/frankenphp:latest
# RUN install-php-extensions \
#     pdo_mysql \
#     gd \
#     intl \
#     zip \
#     opcache 
# Install Composer
# COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
# Expose port untuk FrankenPHP
# EXPOSE 80 443 774 7772
