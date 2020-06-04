FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    zlib1g-dev \
    libzip-dev

RUN docker-php-ext-install ctype
RUN docker-php-ext-install iconv
RUN docker-php-ext-install json
RUN docker-php-ext-install sockets
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql

RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install xdebug-2.9.5 && docker-php-ext-enable xdebug

COPY docker/notifier/php/configs/* /usr/local/etc/php/conf.d

COPY . /var/www/html/

WORKDIR /var/www/html/

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer
RUN composer install

CMD /usr/local/bin/php /var/www/html/bin/console telegram:handleUpdates