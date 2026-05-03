FROM php:8.3-fpm

ENV TZ="America/Mexico_City"

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip tzdata \
    libzip-dev \
    zip \
    unzip \
    chromium \
    fonts-liberation \
    libnss3 \
    libxss1 \
    libasound2 \
    libatk-bridge2.0-0 \
    libgtk-3-0 \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN npx puppeteer browsers install chrome-headless-shell && \
    mkdir -p /usr/local/share/chrome-php && \
    cp -r /root/.cache/puppeteer/chrome-headless-shell/linux-*/chrome-headless-shell-linux64/* /usr/local/share/chrome-php/ && \
    chmod -R 777 /usr/local/share/chrome-php

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Instalamos Puppeteer globalmente para que Browsershot lo encuentre
RUN npm install -g puppeteer

RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
CMD ["php-fpm"]