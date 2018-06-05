FROM php:5.6-fpm-alpine

RUN apk update && apk upgrade && apk add bash git

# Install PHP extensions
ADD install-php.sh /usr/sbin/install-php.sh
RUN /usr/sbin/install-php.sh

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN echo "localhost localhost.localdomain" >> /etc/hosts