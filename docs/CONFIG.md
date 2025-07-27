# CONFIG.md

## Environment Variables

Laravel uses `.env` files to manage environment-specific configurations. A `.env.example` file is provided as a template.

### Required Variables
```dotenv
APP_NAME="Dr. Fintan Medical Appointment"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

DAILY_API_KEY=your_daily_co_api_key
DAILY_DOMAIN=your_daily_co_domain

PAYSTACK_PUBLIC_KEY=your_paystack_public_key
PAYSTACK_SECRET_KEY=your_paystack_secret_key
PAYSTACK_PAYMENT_URL=https://api.paystack.co
```

### Optional Variables
(Any other application-specific variables not listed above can be added here.)

## Configuration Files

Laravel's main configuration is stored in the `config/` directory. These files return arrays of configuration values that can be accessed using the `config()` helper function.

### Key Configuration Files
- `config/app.php`: General application settings (name, timezone, service providers, aliases).
- `config/database.php`: Database connection settings.
- `config/mail.php`: Mail driver settings.
- `config/services.php`: Credentials for various external services (e.g., Daily.co, Paystack).

### Example Access
```php
// Accessing an environment variable
$appDebug = env('APP_DEBUG');

// Accessing a config value
$appName = config('app.name');
$dbConnection = config('database.default');

// Accessing a service credential
$dailyApiKey = config('services.daily.key');
```

## Feature Flags

Feature flags can be implemented using environment variables or dedicated configuration entries. For example, a feature can be enabled/disabled by setting a boolean in the `.env` file.

### Example
```dotenv
ENABLE_NEW_DASHBOARD=true
```

```php
// In controller or view
if (env('ENABLE_NEW_DASHBOARD')) {
    // Show new dashboard
} else {
    // Show old dashboard
}
```

## Security Configuration

Laravel handles many security aspects by default. Key configurations are in `config/app.php`, `config/auth.php`, and `config/session.php`.

### CORS Settings
Configured in `config/cors.php` (if `barryvdh/laravel-cors` package is used) or directly in middleware.

### Rate Limiting
Defined in `app/Providers/RouteServiceProvider.php` and applied to routes using middleware (e.g., `throttle:api`).

## Performance Tuning

Laravel provides commands to cache configuration, routes, and views for performance.

### Cache Configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database Pool
Managed by the database driver, typically configured in `config/database.php`.

## Common Configuration Patterns

### Loading Environment Variables
Laravel automatically loads `.env` variables. It's recommended to use `env()` helper for direct access and `config()` helper for values defined in `config/` files.

### Configuration by Environment
Laravel loads `config/app.php` based on `APP_ENV`. You can create environment-specific config files (e.g., `config/services.staging.php`) or use conditional logic within config files.

## Keywords <!-- #keywords -->
- configuration
- environment variables
- laravel
- .env
- settings
- feature flags
- security