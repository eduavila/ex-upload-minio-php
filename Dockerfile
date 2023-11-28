# Set master image
FROM php:7.2-apache

# Install Composer
RUN apt-get update -y && \
    apt-get install git libxml2-dev libzip-dev zlib1g-dev -y && docker-php-ext-install xml && docker-php-ext-install zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
     