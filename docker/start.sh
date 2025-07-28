#!/bin/bash

# Wait for database to be ready
echo "Waiting for database connection..."
until php /var/www/html/artisan migrate:status > /dev/null 2>&1; do
    echo "Database not ready, waiting..."
    sleep 5
done

# Run migrations
echo "Running database migrations..."
php /var/www/html/artisan migrate --force

# Seed essential data
echo "Seeding essential data..."
php /var/www/html/artisan db:seed --class=SiteSettingsSeeder --force
php /var/www/html/artisan db:seed --class=HomePageContentSeeder --force
php /var/www/html/artisan db:seed --class=AboutPageContentSeeder --force
php /var/www/html/artisan db:seed --class=ContactPageContentSeeder --force
php /var/www/html/artisan db:seed --class=UserSeeder --force
php /var/www/html/artisan db:seed --class=DoctorSeeder --force
php /var/www/html/artisan db:seed --class=DoctorScheduleSeeder --force

# Clear and cache configuration
echo "Optimizing application..."
php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache

# Create storage link
php /var/www/html/artisan storage:link

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Start supervisor
echo "Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf