FROM php:7.4-fpm

ARG APCU_VERSION=5.1.18

RUN apt-get update && apt-get install -y \
    build-essential \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    unzip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    git \
    curl \
    wget \
    zsh

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
        bcmath \
        mbstring \
        pcntl \
        intl \
        zip \
        gd \
        opcache \
        sockets

RUN docker-php-ext-enable \
    bcmath \
    mbstring \
    pcntl \
    intl \
    zip \
    gd \
    opcache \
    sockets

RUN pecl install \
        apcu-${APCU_VERSION} \
        xdebug \
    && docker-php-ext-enable \
        apcu \
        xdebug


RUN apt-get install -y software-properties-common && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www

WORKDIR /var/www

# 0 - root id
ARG PUID=0
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# User configuration
RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data root

RUN chown -R root:www-data /var/www

# Postgresql configuration
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip exif pcntl

EXPOSE 8080

CMD ["php-fpm"]
