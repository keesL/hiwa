FROM php:7.4-apache

RUN apt-get  update
RUN apt-get install -qq libpq-dev
RUN docker-php-ext-install pgsql

#COPY etc/hiwa.conf /etc/nginx/conf.d/default.conf
RUN rm -f /etc/apache2/sites-enabled/*
COPY etc/00-hiwa.conf /etc/apache2/sites-enabled
COPY static/style.css /var/www/hiwa/
COPY static/hiwa.png /var/www/hiwa/uploads/
COPY php/* /var/www/hiwa/

RUN chown www-data:www-data /var/www/hiwa/uploads
RUN chmod ug+rwx /var/www/hiwa/uploads
