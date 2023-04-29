FROM php:8.1-apache

WORKDIR /var/www/html

COPY . /var/www/html

RUN apt-get update \
    && apt-get install -y zip unzip \
    && docker-php-ext-install pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
