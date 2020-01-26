FROM php:7.4-fpm

# Update & upgrade
RUN apt-get update -y && apt-get upgrade -y

# Install git & zip & unzip (for composer?)
RUN apt-get install -y git zip unzip

# Install composer and move to bin
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php && php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /app
