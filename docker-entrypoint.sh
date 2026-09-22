#!/bin/bash
set -e

# Create an empty .env file if it doesn't exist so key:generate doesn't crash
if [ ! -f .env ]; then
    touch .env
fi

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi


# Run migrations
php artisan migrate --force

# Seed database (only if users table is empty)
php artisan db:seed --force 2>/dev/null || true

# Cache config for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
