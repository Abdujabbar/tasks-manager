FROM php:7.2-stretch

RUN  apt-get update -y \
      && apt-get install -y \
        libxml2-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
      && apt-get clean -y \
    && docker-php-ext-install \
        soap \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo_mysql

EXPOSE 8000