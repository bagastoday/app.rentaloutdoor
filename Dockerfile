# ============================================
# Dockerfile - Laravel 11 + PHP 8.2-FPM + Nginx
# Target: Render.com Web Service, DB: Supabase PostgreSQL
# ============================================
FROM php:8.2-fpm-bookworm

# --- Install system deps + PHP extensions (termasuk pdo_pgsql untuk Supabase) ---
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libzip-dev libpng-dev libonig-dev libxml2-dev nginx \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip gd mbstring xml bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# --- Install Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# --- Copy source & install dependencies ---
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

# --- Build frontend assets (Tailwind/Breeze) ---
RUN apt-get update && apt-get install -y nodejs npm \
    && npm install && npm run build \
    && apt-get remove -y nodejs npm && apt-get autoremove -y

# --- Permissions ---
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# --- Nginx config ---
COPY docker/nginx.conf /etc/nginx/sites-available/default

# --- Entrypoint: migrate lalu jalankan php-fpm + nginx ---
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8080
CMD ["/entrypoint.sh"]
