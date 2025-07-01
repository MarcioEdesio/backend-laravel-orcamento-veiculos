#!/bin/sh

php artisan key:generate || true

php artisan migrate --force || true

php-fpm -D
