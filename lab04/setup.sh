#!/bin/bash
set -e

echo "=== Medical App Setup ==="

LARAVEL_DIR="/var/www/medical-app"
APP_DIR="/app"

cd "$LARAVEL_DIR"

# 1. Fresh Installation if needed
if [ ! -f "artisan" ]; then
    echo "Directory empty. Installing Laravel..."
    rm -rf ./* ./.* 2>/dev/null || true
    composer create-project laravel/laravel . --prefer-dist --no-interaction --no-scripts
fi

# 2. Setup .env desde cero para Docker
echo "Configuring .env..."
cat > .env <<EOF
APP_NAME=MedicalApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

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

# 3. Generacion de clave
php artisan key:generate --force

# 4. Instalar Filament PRIMERO (antes de copiar archivos que dependen de él)
echo "Installing Filament..."
composer require filament/filament:"^3.2" --no-interaction --no-audit || true
composer install --no-interaction

# 5. Sincronizar archivos personalizados DESPUES de instalar dependencias
echo "Syncing custom models, migrations, and resources..."
cp -r $APP_DIR/app/Models/. ./app/Models/ 2>/dev/null || true
cp -r $APP_DIR/database/migrations/. ./database/migrations/ 2>/dev/null || true
cp -r $APP_DIR/database/seeders/. ./database/seeders/ 2>/dev/null || true
cp -r $APP_DIR/app/Filament/. ./app/Filament/ 2>/dev/null || true
cp -r $APP_DIR/app/Console/. ./app/Console/ 2>/dev/null || true
cp -r $APP_DIR/app/Providers/. ./app/Providers/ 2>/dev/null || true

# 6. CORRECCION CLAVE: Registrar AdminPanelProvider en bootstrap/providers.php
# Sin esto, Filament no registra la ruta /admin y el panel no existe para Laravel
echo "Registering AdminPanelProvider in bootstrap/providers.php..."
cat > bootstrap/providers.php <<'PROVIDERS'
<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
];
PROVIDERS

# 7. Ejecutar autoload dump para que Laravel reconozca las nuevas clases
composer dump-autoload --no-interaction

# 8. Esperar DB y migrar
echo "Waiting for database (db:3306)..."
until php artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1; do
    echo "DB not ready - waiting..."
    sleep 3
done

echo "Running migrations and seeders..."
php artisan migrate:fresh --seed --force

# 9. Crear usuario admin (password: 1234)
echo "Creating admin user..."
php artisan make:admin-user admin@medical.com 1234

# 10. Configuracion final
echo "Finalizing setup..."
php artisan storage:link || true
php artisan config:clear || true
php artisan route:clear || true

# 11. Iniciar servidor en puerto 8000
echo "Starting Medical App on port 8000..."
echo "Access: http://localhost:8000/admin"
echo "User:   admin@medical.com"
echo "Pass:   1234"
php -S 0.0.0.0:8000 -t public