FROM php:7.4.11-fpm-alpine3.12

RUN docker-php-ext-install pdo pdo_mysql



# mysql server name 
# docker.for.win.localhost
# host.docker.internal

# docker run -it -p 8888:8888 --rm --name atedi -v .:/var/www/Atedi php:7.4.11-fpm sh


CMD [ "php", "-S 0.0.0.0:8888 -t public" ]

EXPOSE 8888
