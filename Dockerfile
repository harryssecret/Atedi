FROM composer/composer:2-bin AS composer

FROM caddy:latest


WORKDIR /app

COPY . .