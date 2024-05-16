FROM php:8.3-fpm-alpine

RUN apk add --update --no-cache \
    icu-dev

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./config.ini /usr/local/etc/php/conf.d/config.ini
RUN chmod 775 /usr/local/etc/php/conf.d/config.ini

WORKDIR /var/www/app
