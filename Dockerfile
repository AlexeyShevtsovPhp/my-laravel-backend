FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    imagemagick \
    libmagickwand-dev \
    libpq-dev \
    autoconf \
    gcc \
    g++ \
    make \
    linux-headers-amd64 \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

#RUN apt-get update && apt-get install -y iputils-ping netcat

RUN docker-php-ext-install pdo_mysql intl bcmath opcache pdo pdo_pgsql gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN pecl install imagick \
    && docker-php-ext-enable imagick

RUN touch file.txt

