FROM php:8.2.9-apache

LABEL Maintainer="Brian Kresge <brian.kresge@gmail.com>"

ENV XDEBUG_PORT 9003

RUN apt-get update -y && apt-get install -y libpng-dev

RUN apt-get update && \
    apt-get install -y zlib1g-dev

RUN docker-php-ext-install gd
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install calendar

# DEBUG ONLY
RUN yes | pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \docker-php-ext-configure zip \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


RUN a2enmod rewrite

COPY . /var/www/html
WORKDIR /var/www/html

RUN chmod -R 777 /var/www/html \
    && chmod -R 777 /var/www/html/admin/sd-system \
    && chmod -R 777 /var/www/html/admin/sd-system/attachments \
    && chmod -R 777 /var/www/html/admin/sd-system/exports \
    && chmod -R 777 /var/www/html/custom/sessions \
    && chmod -R 777 /var/www/html/custom/qrcodes \
    && chmod -R 777 /var/www/html/custom/uploads

EXPOSE 8000

COPY php5.ini /usr/local/etc/php/php.ini

RUN chmod 777 /usr/local/etc/php/php.ini