FROM dunglas/frankenphp:latest

RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache 

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Expose port untuk FrankenPHP
EXPOSE 80 443 774 7772
