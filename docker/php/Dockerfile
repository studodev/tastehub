FROM php:8.4-fpm-alpine

RUN apk add --update --no-cache \
    icu-dev \
    icu-data-full \
    libpng-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    imagemagick-dev \
    $PHPIZE_DEPS

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install intl

RUN pecl install imagick
RUN docker-php-ext-enable imagick

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./config.ini /usr/local/etc/php/conf.d/config.ini
RUN chmod 775 /usr/local/etc/php/conf.d/config.ini

WORKDIR /var/www/app
