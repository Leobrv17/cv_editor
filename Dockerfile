FROM php:7.4-apache
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . /var/www/html/
WORKDIR /var/www/html
RUN composer install
RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql
COPY src/ /var/www/html/
