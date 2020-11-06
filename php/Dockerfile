FROM php:7-fpm

RUN apt-get update
RUN apt-get install -qq apt-utils
RUN apt-get install -qq libpq-dev
RUN docker-php-ext-install pgsql
COPY php/ /var/www/hiwa/
