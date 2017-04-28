#!/bin/sh

php -S ${HOSTNAME}:8084 -t /var/www/public &
php -S ${HOSTNAME}:8085 -t /var/www/public
