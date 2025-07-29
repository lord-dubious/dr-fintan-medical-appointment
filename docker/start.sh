#!/bin/bash

# Wait for database to be ready
echo "Waiting for database connection..."
echo "Database Host: ${DB_HOST}"
echo "Database Name: ${DB_DATABASE}"

# Test database connection with timeout
TIMEOUT=300  # 5 minutes timeout
ELAPSED=0
until php /var/www/html/artisan migrate:status > /dev/null 2>&1; do
    if [ $ELAPSED -ge $TIMEOUT ]; then
        echo "Database connection timeout after ${TIMEOUT} seconds"
        echo "Please check your database environment variables:"
        echo "DB_HOST=${DB_HOST}"
        echo "DB_PORT=${DB_PORT}"
        echo "DB_DATABASE=${DB_DATABASE}"
        echo "DB_USERNAME=${DB_USERNAME}"
        exit 1
    fi
    echo "Database not ready, waiting... (${ELAPSED}s/${TIMEOUT}s)"
    sleep 5
    ELAPSED=$((ELAPSED + 5))
done

echo "Database connection successful!"

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