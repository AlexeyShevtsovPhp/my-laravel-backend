FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    imagemagick \
    libmagickwand-dev \
    libpq-dev \
    pkg-config \
    libcurl4-openssl-dev \
    libssl-dev \
    libonig-dev \
    git \
    linux-headers-amd64 \
    $PHPIZE_DEPS \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql intl bcmath opcache pdo pdo_pgsql gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug imagick \
    && docker-php-ext-enable xdebug imagick

RUN touch file.txt
