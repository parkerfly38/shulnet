FROM parkerfly38/shulnet:shulnet-apache

LABEL Maintainer="Brian Kresge <brian.kresge@gmail.com>"

ENV XDEBUG_PORT 9003


RUN a2enmod rewrite

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