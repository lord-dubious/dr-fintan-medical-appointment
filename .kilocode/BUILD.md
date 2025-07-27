# BUILD.md

## Prerequisites
- PHP >= 8.1
- Composer (PHP dependency manager)
- Node.js & npm (for frontend assets)
- Laravel Valet, Laragon, or Docker for local development environment (optional but recommended)

## Build Commands

### Development
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Compile frontend assets for development and watch for changes
npm run dev
```

### Production
```bash
# Compile frontend assets for production
npm run build

# Optimize Laravel application (clear cache, optimize config, etc.)
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database Operations
```bash
# Run database migrations
php artisan migrate

# Rollback the last migration
php artisan migrate:rollback

# Seed the database (for demo data)
php artisan db:seed
```

### Testing
```bash
# Run all PHPUnit tests
php artisan test

# Run specific PHPUnit test file
php artisan test --filter UserTest

# Run tests with coverage (if configured)
php artisan test --coverage
```

### Linting & Formatting
(Laravel projects often use tools like Laravel Pint for PHP code style. Frontend linting depends on specific JS/CSS frameworks.)

## CI/CD Pipeline
(Typically involves running Composer install, npm install & build, php artisan migrate, and then deploying the application. Specific steps depend on the CI/CD provider like GitHub Actions, GitLab CI, Jenkins, etc.)

## Deployment

### Staging / Production
1. **Pull latest code**: `git pull origin main` (or relevant branch)
2. **Install PHP dependencies**: `composer install --no-dev --optimize-autoloader`
3. **Run database migrations**: `php artisan migrate --force`
4. **Compile frontend assets**: `npm run build`
5. **Optimize Laravel**: `php artisan optimize --force`
6. **Link storage**: `php artisan storage:link` (if not already linked)
7. **Restart web server / PHP-FPM** (e.g., `sudo service nginx restart`, `sudo service php8.1-fpm restart`)

## Rollback Procedures
1. **Revert code**: `git revert <commit-hash>` or deploy previous release.
2. **Rollback database**: `php artisan migrate:rollback` (use with caution, ensure data integrity).
3. **Clear caches**: `php artisan cache:clear`, `php artisan view:clear`, `php artisan config:clear`.

## Troubleshooting

### Common Issues
**Issue**: Composer dependencies not installing.
**Solution**: Check `composer.json` for syntax errors, ensure PHP version compatibility, clear Composer cache (`composer clear-cache`).

**Issue**: Frontend assets not compiling.
**Solution**: Check `package.json` scripts, ensure Node.js and npm are installed correctly, clear npm cache (`npm cache clean --force`).

**Issue**: Database migration errors.
**Solution**: Verify database credentials in `.env`, ensure database server is running, check migration file syntax.

## Keywords <!-- #keywords -->
- build
- deployment
- laravel
- composer
- npm
- testing
- ci/cd
