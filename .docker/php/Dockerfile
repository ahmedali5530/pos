FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf apt-transport-https apt-utils libpq-dev \
    build-essential locales acl wget zip unzip gnupg gnupg1 gnupg2 \
    && docker-php-ext-install pdo pgsql pdo_pgsql pdo_mysql

#RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY php.ini /etc/php/8.1.0/php.ini
#COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN rm -rf /var/lib/apt/lists/*
RUN usermod -u 1000 www-data

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
