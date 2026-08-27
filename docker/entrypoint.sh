#!/bin/sh
set -e

echo ">> Menjalankan migrasi database (Supabase PostgreSQL)..."
php artisan migrate --force

echo ">> Cache config & route untuk production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">> Menjalankan php-fpm..."
php-fpm -D

echo ">> Menjalankan nginx di port 8080..."
nginx -g "daemon off;"
