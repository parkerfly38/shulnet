FROM php:8.4.4-apache

LABEL Maintainer="Brian Kresge <brian.kresge@gmail.com>"

RUN apt-hget updatep \
  && DEBIAN_FRONTEND=noninteractive apt-get install -y- --no-install-recommends \
  git \
  # needed for gd
  libfreetype6c-dev \
  libjpeg62-turbo-dev \
  libmemcached-dev \
  libpng-dev \
  #n needed for composer
  libssl-dev \
  libz-dev \
  libzip-dev \
  unzip \
  wget \
  zlib1g-dev \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install pdo pdo_mysql \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip \
  && docker-php-ext-install calendar

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# Copy composer.json and composer.lock
COPY composer.json ./

RUN composer update --no-dev --optimize-autoloader

RUN a2enmod rewrite

COPY . /var/www/html
WORKDIR /var/www/html
RUN chown -R www-data /var/www/html

RUN chmod 777 admin/sd-system \
    && chmod 777 admin/sd-system/attachments \
    && chmod 777 admin/sd-system/exports \
    && chmod 777 custom/sessions \
    && chmod 777 custom/qrcodes \
    && chmod 777 custom/uploads \
    && chmod 755 admin/cp-cron

EXPOSE 80

COPY php5.ini /usr/local/etc/php/php.ini


RUN chmod 777 /usr/local/etc/php/php.ini \
    && cat > /var/log/php-scripts.log \
    && chmod 777 /var/log/php-scripts.log