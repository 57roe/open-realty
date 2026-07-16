FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd zip mbstring curl mysqli pdo_mysql \
    && a2enmod rewrite expires headers

WORKDIR /var/www/html

RUN git clone --depth 1 https://gitlab.com/appsbytherealryanbonham/open-realty.git . \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80
