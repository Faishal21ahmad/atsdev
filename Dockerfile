FROM dunglas/frankenphp:latest

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev \
    libpq-dev libonig-dev libzip-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Copy aplikasi Laravel
COPY ./apps /app

# Install dependencies Laravel
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# # Copy konfigurasi FrankenPHP
# COPY ./frankenphp/Caddyfile /etc/caddy/Caddyfile
# COPY ./frankenphp/cert.pem /etc/ssl/private/cert.pem
# COPY ./frankenphp/key.pem /etc/ssl/private/key.pem

# Expose port
EXPOSE 80 443 774 7772 9000

# Start FrankenPHP
# CMD ["frankenphp","--tls", "/etc/ssl/private/cert.pem", "/etc/ssl/private/key.pem"]