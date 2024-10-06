#!/bin/sh
chmod -R 777 /var/www/html/storage \
    && chmod -R 666 $(find /var/www/html/storage -type f) \
    && chmod -R 777 /var/www/html/bootstrap/cache \
    && chmod -R 666 $(find /var/www/html/bootstrap/cache -type f) \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && composer update
