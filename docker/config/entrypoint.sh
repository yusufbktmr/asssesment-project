#!/bin/sh

# Hata durumunda script'in çalışmasını durdur
set -e
sleep 5
php artisan config:cache
php artisan config:clear
php artisan cache:clear
composer install
composer dumpautoload
sleep 5
php artisan migrate:fresh
php artisan db:seed --force
exec "$@"



