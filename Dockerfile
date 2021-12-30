FROM php:apache-buster

RUN apt-get -y update \
    && a2enmod rewrite


