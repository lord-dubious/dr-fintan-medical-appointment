# DEPLOY.md - Deployment Playbook (Laravel)

## Pre-Deployment Checklist

### Code Readiness
- [ ] All automated tests (PHPUnit, frontend tests) passing in CI/CD.
- [ ] Code review approved and merged to the deployment branch.
- [ ] No critical errors or warnings in application logs.
- [ ] Database migrations are reviewed and ready to be applied.
- [ ] Environment variables for the target environment are configured.
- [ ] Frontend assets are compiled and optimized for production.
- [ ] Documentation updated for any new features or changes.

### Communication
- [ ] Team notified of deployment window and potential downtime.
- [ ] Relevant stakeholders (e.g., customer support, product team) informed.
- [ ] Status page updated to reflect deployment (if applicable).
- [ ] Rollback plan reviewed and understood by the deployment team.

### Environment Checks
- [ ] Target server resources (CPU, Memory, Disk space) are adequate.
- [ ] Database server is healthy and accessible.
- [ ] External services (Daily.co, Paystack, email service) are operational.
- [ ] Latest code pulled and dependencies installed on the deployment server.
- [ ] Backup of the current production database is completed and verified.

## Deployment Steps

### Option 1: Standard Laravel Deployment
(Assumes a server with Nginx/Apache, PHP-FPM, Composer, Node.js, and Git setup)

```bash
# 1. SSH into your deployment server
ssh user@your-server-ip
cd /var/www/your-laravel-app

# 2. Put application in maintenance mode (optional but recommended for zero-downtime)
php artisan down

# 3. Pull the latest code from your repository
git pull origin main # or your deployment branch

# 4. Install/update PHP dependencies (excluding dev dependencies)
composer install --no-dev --optimize-autoloader

# 5. Run database migrations
php artisan migrate --force

# 6. Clear and cache configuration, routes, and views
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Install/update Node.js dependencies and build frontend assets
npm install
npm run build

# 8. Link storage to public (if not already linked or recreated)
php artisan storage:link

# 9. Clear application cache
php artisan cache:clear

# 10. Bring application out of maintenance mode
php artisan up

# 11. Restart PHP-FPM (e.g., for Nginx/Apache)
sudo service php8.1-fpm restart # Adjust PHP version as needed

# 12. Verify deployment
curl http://localhost/health # Or access your application URL
```

## Post-Deployment Verification

### Health Checks
- Access key application URLs (e.g., login page, dashboard).
- Verify API endpoints are responsive (`/api/video-consultation/create-room`).
- Check database connectivity by performing a simple data retrieval.
- Confirm external service integrations (Daily.co, Paystack) are functional.

### Monitoring Checklist
- [ ] Application logs are clear of new errors (`storage/logs/laravel.log`).
- [ ] Server metrics (CPU, Memory, Disk I/O) are stable.
- [ ] Error rates and response times are within acceptable limits.
- [ ] User feedback channels are monitored for immediate issues.

### Smoke Tests
- User registration and login flow.
- Doctor/Patient dashboard access.
- Appointment booking and payment process.
- Video consultation room creation and joining.

## Rollback Procedures

### Immediate Rollback
(If a critical issue is detected immediately after deployment)

```bash
# 1. Put application in maintenance mode
php artisan down

# 2. Revert code to the previous stable commit
git reset --hard HEAD~1 # Or git checkout <previous-commit-hash>

# 3. Rollback any problematic database migrations (use with extreme caution)
php artisan migrate:rollback

# 4. Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 5. Bring application out of maintenance mode
php artisan up

# 6. Restart PHP-FPM
sudo service php8.1-fpm restart

# 7. Notify team of rollback
```

### Database Rollback
- Only rollback migrations if you are certain of no data loss or if a backup is readily available.
- Always have a recent database backup before performing any migration rollbacks on production.

## Troubleshooting

### Common Deployment Issues

#### Application 500 Error
- Check `storage/logs/laravel.log` for error details.
- Verify file permissions (`storage/`, `bootstrap/cache/`).
- Ensure `.env` is correctly configured and `php artisan config:cache` was run.

#### Frontend Assets Not Loading
- Check `public/build/assets/` directory exists and contains compiled assets.
- Verify `npm run build` completed successfully.
- Clear browser cache.

#### Database Connection Refused
- Check database credentials in `.env`.
- Ensure database server is running and accessible from the application server.

## Deployment Schedule

### Regular Deployments
- **Production**: Weekly, during low traffic hours (e.g., Tuesday/Thursday, 2 AM - 4 AM local time).
- **Staging**: Daily, after successful CI/CD builds.
- **Hotfixes**: As needed (follow immediate rollback procedure if critical).

### Deployment Windows
- Preferred: During lowest user activity.
- Avoid: Peak hours, Friday afternoons, weekends, holidays.

### Notification Timeline
- **T-24h**: Initial deployment announcement to team/stakeholders.
- **T-2h**: Final reminder before deployment begins.
- **T-0**: Deployment starts.
- **T+30m**: Deployment completion notification.

## Contact Information

### Escalation Path
1. On-call Developer/DevOps Engineer
2. Team Lead
3. CTO

### External Contacts
- Hosting Provider Support
- CDN Support
- DNS Provider Support

## Keywords <!-- #keywords -->
- deployment
- laravel
- playbook
- ci/cd
- production
- staging
- rollback
- maintenance
