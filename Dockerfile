FROM php:8.3-fpm

ENV TZ="America/Mexico_City"
ENV PUPPETEER_CACHE_DIR="/usr/local/share/puppeteer_cache"

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip tzdata \
    libzip-dev \
    fonts-liberation \
    libnss3 \
    libxss1 \
    libasound2 \
    libatk-bridge2.0-0 \
    libgtk-3-0 \
    libgbm1 \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN npx puppeteer browsers install chrome-headless-shell && \
    mkdir -p /usr/local/bin && \
    ln -s $(find $PUPPETEER_CACHE_DIR -name chrome-headless-shell -type f | head -n 1) /usr/local/bin/chrome-php && \
    chown -R www-data:www-data $PUPPETEER_CACHE_DIR && \
    chmod -R 755 $PUPPETEER_CACHE_DIR && \
    chmod +x /usr/local/bin/chrome-php

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
CMD ["php-fpm"]