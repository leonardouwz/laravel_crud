#!/bin/bash
set -e

echo "=== Medical App Setup (Refactored) ==="

LARAVEL_DIR="/var/www/medical-app"
APP_DIR="/app"

cd "$LARAVEL_DIR"

# 1. Fresh Installation if needed
if [ ! -f "artisan" ]; then
    echo "Directory empty. Installing Laravel..."
    # Composer create-project requires empty dir, so we clean again just in case
    rm -rf ./* ./.* 2>/dev/null || true
    composer create-project laravel/laravel . --prefer-dist --no-interaction --no-scripts
fi

# 2. Setup .env from scratch for Docker
echo "Configuring .env..."
cat > .env <<EOF
APP_NAME=MedicalApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8100

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=medical_db
DB_USERNAME=laravel
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF

# 3. Key generation
php artisan key:generate --force

# 4. Sync custom files from /app to /var/www/medical-app
echo "Syncing custom models, migrations, and resources..."
cp -r $APP_DIR/app/Models/. ./app/Models/ 2>/dev/null || true
cp -r $APP_DIR/database/migrations/. ./database/migrations/ 2>/dev/null || true
cp -r $APP_DIR/database/seeders/. ./database/seeders/ 2>/dev/null || true
cp -r $APP_DIR/app/Filament/. ./app/Filament/ 2>/dev/null || true
cp -r $APP_DIR/app/Console/. ./app/Console/ 2>/dev/null || true
cp -r $APP_DIR/app/Providers/. ./app/Providers/ 2>/dev/null || true

# 5. Dependencies
echo "Installing/Updating dependencies..."
composer require filament/filament:"^3.2" --no-interaction --no-audit || true
composer install --no-interaction

# 6. Wait for DB and Migrate
echo "Waiting for database (db:3306)..."
until php artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1; do
    echo "DB not ready - waiting..."
    sleep 3
done

echo "Running migrations and seeders..."
php artisan migrate:fresh --seed --force

# 7. Final config
echo "Finalizing setup..."
php artisan storage:link || true

# 8. Start Server (Using PHP internal server for better Docker stability)
echo "Starting Medical App on port 8100..."
php -S 0.0.0.0:8100 -t public
