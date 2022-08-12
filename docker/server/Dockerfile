FROM php:8.0-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y git unzip zip

WORKDIR /var/www/html

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_mysql bcmath zip intl opcache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer

ENV ACCEPT_EULA="Y"

RUN apt-get update && \
    apt-get install -y gnupg
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
# RUN curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list
RUN curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list > /etc/apt/sources.list.d/mssql-release.list 
RUN apt-get update -y
RUN apt-get install -y --no-install-recommends msodbcsql17 
RUN apt-get install -y unixodbc-dev
    
  RUN pecl install sqlsrv-5.10.1
  RUN pecl install pdo_sqlsrv-5.10.1
  RUN docker-php-ext-enable sqlsrv