#!/bin/bash
set -e

echo "=== Medical App Setup ==="

LARAVEL_DIR="/var/www/medical-app"
APP_DIR="/app"

cd "$LARAVEL_DIR"

if [ ! -f "artisan" ]; then
    echo "Creating Laravel project..."
    composer create-project laravel/laravel "$LARAVEL_DIR" --prefer-dist --no-interaction --no-scripts
fi

echo "Installing dependencies..."
composer install --no-interaction --no-dev --optimize-autoloader || true

echo "Copying custom files..."
cp -r "$APP_DIR/app/Models" "$LARAVEL_DIR/app/" 2>/dev/null || true
cp -r "$APP_DIR/database/migrations" "$LARAVEL_DIR/database/" 2>/dev/null || true
cp -r "$APP_DIR/database/seeders" "$LARAVEL_DIR/database/" 2>/dev/null || true
cp -r "$APP_DIR/app/Filament" "$LARAVEL_DIR/app/" 2>/dev/null || true
cp -r "$APP_DIR/app/Console" "$LARAVEL_DIR/app/" 2>/dev/null || true
cp -r "$APP_DIR/app/Providers" "$LARAVEL_DIR/app/" 2>/dev/null || true
cp "$APP_DIR/medical-app/.env.example" "$LARAVEL_DIR/.env.example" 2>/dev/null || true

echo "Installing Filament..."
composer require filament/filament:^3.2 --no-interaction || true

echo "Configuring Filament..."
php artisan filament:install --panels --no-interaction <<EOF
admin
EOF

echo "Setting up environment..."
cp .env.example .env 2>/dev/null || true
php artisan key:generate --no-interaction

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force --no-interaction

echo "Creating admin user..."
php artisan tinker --execute="use App\Models\User; \$user = App\Models\User::where('email', 'admin@medical.com')->first(); if (!\$user) { App\Models\User::create(['name' => 'Admin', 'email' => 'admin@medical.com', 'password' => bcrypt('1234')]); echo 'Admin user created'; }" || true

echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=8100