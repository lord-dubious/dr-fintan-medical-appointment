#!/bin/bash

# Dr. Fintan Medical Appointment System - Render Deployment Script
# This script handles the deployment process for Render

set -e  # Exit on any error

echo "🚀 Starting deployment for Dr. Fintan Medical Appointment System..."

# Check if we're in production environment
if [ "$APP_ENV" != "production" ]; then
    echo "⚠️  Warning: APP_ENV is not set to production"
fi

echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

echo "📦 Installing Node.js dependencies..."
npm ci --only=production

echo "🏗️  Building frontend assets..."
npm run build

echo "🔑 Generating application key..."
php artisan key:generate --force

echo "🗄️  Running database migrations..."
php artisan migrate --force

echo "🌱 Seeding database (if needed)..."
php artisan db:seed --force --class=SiteSettingsSeeder
php artisan db:seed --force --class=HomePageContentSeeder
php artisan db:seed --force --class=AboutPageContentSeeder
php artisan db:seed --force --class=ContactPageContentSeeder

echo "🔗 Creating storage link..."
php artisan storage:link

echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "📁 Setting proper permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "🧹 Clearing old caches..."
php artisan cache:clear
php artisan config:clear

echo "✅ Deployment completed successfully!"

# Health check
echo "🏥 Running health check..."
php artisan tinker --execute="
try {
    \$db = DB::connection()->getPdo();
    echo 'Database: Connected' . PHP_EOL;
} catch (Exception \$e) {
    echo 'Database: Failed - ' . \$e->getMessage() . PHP_EOL;
    exit(1);
}

try {
    Cache::put('deployment_test', 'success', 60);
    \$test = Cache::get('deployment_test');
    echo 'Cache: ' . (\$test === 'success' ? 'Working' : 'Failed') . PHP_EOL;
} catch (Exception \$e) {
    echo 'Cache: Failed - ' . \$e->getMessage() . PHP_EOL;
}

try {
    \$daily_key = env('DAILY_API_KEY');
    \$daily_domain = env('DAILY_DOMAIN');
    echo 'Daily.co: ' . (\$daily_key && \$daily_domain ? 'Configured' : 'Missing Config') . PHP_EOL;
} catch (Exception \$e) {
    echo 'Daily.co: Error - ' . \$e->getMessage() . PHP_EOL;
}
"

echo "🎉 Dr. Fintan Medical Appointment System is ready!"