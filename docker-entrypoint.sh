#!/bin/sh
set -e

cd /var/www/html

# Copy .env if missing
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Generate key if missing
if ! grep -q "APP_KEY=" .env || [ -z "$(grep APP_KEY .env | cut -d= -f2)" ]; then
  php artisan key:generate --ansi || true
fi

# Ensure sqlite database exists
mkdir -p database
touch database/database.sqlite

# Install composer dependencies (allow failures on first build)
composer install --no-interaction || true

# Run migrations & seeders
php artisan migrate --force || true
php artisan db:seed --force || true

# Install node deps and build assets
if [ -f package.json ]; then
  npm install || true
  npm run build || true
fi

# Serve application
php artisan serve --host=0.0.0.0 --port=8000
