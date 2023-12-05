FROM php:7.4-apache

# Activer le module rewrite d'Apache
RUN a2enmod rewrite

# Installer les dépendances nécessaires pour les extensions PHP
RUN apt-get update && \
    apt-get install -y libzip-dev zip && \
    docker-php-ext-install pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier composer.json et composer.lock, puis exécuter Composer
COPY composer.json composer.lock /var/www/html/
RUN composer install --no-interaction

# Copier les fichiers de l'application
COPY src/ /var/www/html/
