FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip

WORKDIR /var/www

CMD ["php-fpm"]