FROM php:8-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk update && apk add --no-cache supervisor

RUN mkdir -p "/etc/supervisor/logs"

COPY ./dockerfiles/supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]
