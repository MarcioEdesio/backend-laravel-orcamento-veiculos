FROM richarvey/nginx-php-fpm:3.1.6

COPY . /var/www/html

RUN apk update && \
    apk add --no-cache bash git && \
    composer install --no-dev --optimize-autoloader

EXPOSE 80

CMD ["/start.sh"]
