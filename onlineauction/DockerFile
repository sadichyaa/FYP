FROM php:8.2-apache

RUN a2enmod rewrite

COPY onlineauction/ /var/www/html/

RUN docker-php-ext-install mysqli pdo pdo_mysql

EXPOSE 80