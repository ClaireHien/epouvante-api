FROM php:8.2-fpm-alpine

# Installation des dépendances système et extensions PHP
RUN apk add --no-cache libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip

WORKDIR /var/www

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie du code
COPY . .

# Installation des dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissions pour Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]