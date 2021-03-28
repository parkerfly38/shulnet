FROM php:7.4-apache

LABEL Maintainer="Brian Kresge <brian.kresge@gmail.com>"

ENV XDEBUG_PORT 9003

RUN apt-get update && apt-get install -y \
        cron \
        libmcrypt-dev \
        libcurl4-openssl-dev \
        libbz2-dev \
        libwebp-dev \
        libjpeg62-turbo-dev \
		libpng-dev \
        libxpm-dev \
        libfreetype6-dev \
        vim \
        wget \
        unzip \
        git \
        nano \
    && docker-php-ext-install -j$(nproc) curl \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install calendar


#RUN docker-php-ext-configure gd --with-gd --with-webp-dir --with-jpeg-dir \
#    --with-png-dir --with-zlib-dir --with-xpm-dir --with-freetype-dir \
#    --enable-gd-native-ttf

RUN docker-php-ext-configure gd --enable-gd --with-jpeg --with-xpm --with-webp --with-freetype

RUN docker-php-ext-install gd \
    && docker-php-ext-enable gd

RUN a2enmod rewrite

RUN wget http://xdebug.org/files/xdebug-3.0.3.tgz

RUN tar -xvzf xdebug-3.0.3.tgz

RUN cd xdebug-3.0.3 && phpize && ./configure && make && cp modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/xdebug.so

COPY . /var/www/html
WORKDIR /var/www/html

RUN chmod 777 admin/sd-system \
    && chmod 777 admin/sd-system/attachments \
    && chmod 777 admin/sd-system/exports \
    && chmod 777 custom/sessions \
    && chmod 777 custom/qrcodes \
    && chmod 777 custom/uploads

EXPOSE 8000

COPY php5.ini /usr/local/etc/php/php.ini

RUN chmod 777 /usr/local/etc/php/php.ini