FROM php:8.2

WORKDIR /var/www/html

RUN apt update && \
    apt upgrade -y && \
    apt install -y ca-certificates cron curl git tar unzip libpng-dev libxml2-dev libzip-dev libpq-dev && \
    apt clean && \
    docker-php-ext-configure zip && \
    docker-php-ext-install bcmath gd pdo_mysql zip pdo_pgsql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "* * * * * /usr/local/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1" >> /var/spool/cron/crontabs/root

EXPOSE 8010
EXPOSE 9003
