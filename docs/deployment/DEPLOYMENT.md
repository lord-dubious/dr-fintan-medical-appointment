# Dr. Fintan Medical Appointment System - Render Deployment Guide

This guide will help you deploy the Dr. Fintan Medical Appointment System to Render.

## Prerequisites

Before deploying, ensure you have:

1. A Render account (https://render.com)
2. A GitHub repository with your code
3. External database (MySQL/PostgreSQL) - Render or external provider
4. External Redis instance - Render or external provider
5. Daily.co API credentials
6. Paystack API credentials (production keys)
7. SMTP email service credentials

## Step 1: Prepare External Services

### Database Setup
1. Create a MySQL or PostgreSQL database on Render or external provider
2. Note down the connection details (host, port, database name, username, password)
3. Ensure the database is accessible from Render

### Redis Setup
1. Create a Redis instance on Render or external provider
2. Note down the connection details (host, port, password)
3. Ensure Redis is accessible from Render

## Step 2: Deploy to Render

### Option A: Using render.yaml (Recommended)

1. **Fork/Clone Repository**
   ```bash
   git clone your-repository-url
   cd medical_Appointment
   ```

2. **Push to GitHub**
   - Ensure all deployment files are committed:
     - `render.yaml`
     - `deploy.sh`
     - `tailwind.config.js`
     - Database migrations for jobs and failed_jobs
     - `.env.production.example`

3. **Create Render Service**
   - Go to Render Dashboard
   - Click "New" → "Blueprint"
   - Connect your GitHub repository
   - Render will automatically detect `render.yaml`

### Option B: Manual Setup

1. **Create Web Service**
   - Go to Render Dashboard
   - Click "New" → "Web Service"
   - Connect your GitHub repository
   - Configure:
     - **Environment**: PHP
     - **Build Command**: `./deploy.sh`
     - **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

2. **Create Background Worker**
   - Click "New" → "Background Worker"
   - Connect same repository
   - Configure:
     - **Environment**: PHP
     - **Build Command**: `composer install --no-dev --optimize-autoloader && npm ci && npm run build`
     - **Start Command**: `php artisan queue:work redis --sleep=3 --tries=3`

## Step 3: Configure Environment Variables

In your Render service settings, add these environment variables:

### Required Variables
```bash
APP_NAME="Dr. Fintan Medical Appointment System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
LOG_CHANNEL=stderr
LOG_LEVEL=info

# Database (from your external database)
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Redis (from your external Redis)
REDIS_HOST=your-redis-host
REDIS_PASSWORD=your_redis_password
REDIS_PORT=6379
REDIS_SCHEME=tls

# Session, Cache, Queue
SESSION_DRIVER=redis
CACHE_STORE=redis
QUEUE_CONNECTION=redis

# Daily.co (REQUIRED)
DAILY_API_KEY=your_daily_api_key
DAILY_DOMAIN=your-subdomain.daily.co

# Paystack (Production keys)
PAYSTACK_PUBLIC_KEY=pk_live_your_paystack_public_key
PAYSTACK_SECRET_KEY=sk_live_your_paystack_secret_key

# Email
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your_email_username
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
```

### Generate APP_KEY
Run this locally and add to environment variables:
```bash
php artisan key:generate --show
```

## Step 4: Connect External Services

### Database Connection
1. In Render dashboard, go to your web service
2. Go to "Environment" tab
3. Add database connection variables
4. Or use `DATABASE_URL` if your provider supports it

### Redis Connection
1. Add Redis connection variables
2. Or use `REDIS_URL` if your provider supports it

## Step 5: Deploy and Test

1. **Trigger Deployment**
   - Push changes to your GitHub repository
   - Render will automatically deploy

2. **Monitor Deployment**
   - Check build logs in Render dashboard
   - Ensure all steps complete successfully

3. **Test Application**
   - Visit your app URL: `https://your-app-name.onrender.com`
   - Test health check: `https://your-app-name.onrender.com/health-check`
   - Test Redis: `https://your-app-name.onrender.com/test-redis`
   - Test Daily.co: `https://your-app-name.onrender.com/test-daily`

## Step 6: Post-Deployment Setup

### Initial Admin Setup
1. Access your application
2. Register the first admin user
3. Configure site settings through admin panel

### Database Seeding
The deployment script automatically runs:
- Database migrations
- Essential seeders (site settings, page content)

### File Storage
- Local storage is configured by default
- For production, consider AWS S3 or similar cloud storage

## Troubleshooting

### Common Issues

1. **Build Failures**
   - Check PHP version compatibility
   - Ensure all dependencies are in composer.json
   - Verify Node.js version for asset compilation

2. **Database Connection Issues**
   - Verify database credentials
   - Check database host accessibility
   - Ensure database exists and user has proper permissions

3. **Redis Connection Issues**
   - Verify Redis credentials
   - Check Redis host accessibility
   - Ensure Redis instance is running

4. **Asset Compilation Issues**
   - Check TailwindCSS configuration
   - Verify Vite build process
   - Ensure all frontend dependencies are installed

5. **Queue Worker Issues**
   - Verify Redis connection for queue worker
   - Check worker service logs
   - Ensure queue worker service is running

### Debug Commands

Run these in Render shell or locally:

```bash
# Check database connection
php artisan tinker --execute="DB::connection()->getPdo();"

# Check Redis connection
php artisan tinker --execute="Cache::put('test', 'working'); echo Cache::get('test');"

# Check Daily.co configuration
curl -H "Authorization: Bearer YOUR_DAILY_API_KEY" https://api.daily.co/v1/

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Security Considerations

1. **Environment Variables**
   - Never commit `.env` files
   - Use production API keys
   - Enable HTTPS (automatic on Render)

2. **Database Security**
   - Use strong database passwords
   - Restrict database access to Render IPs
   - Enable SSL for database connections

3. **Application Security**
   - Set `APP_DEBUG=false` in production
   - Use secure session configuration
   - Enable CSRF protection (already configured)

## Monitoring and Maintenance

1. **Health Checks**
   - Monitor `/health-check` endpoint
   - Set up uptime monitoring

2. **Logs**
   - Monitor application logs in Render dashboard
   - Set up log aggregation if needed

3. **Backups**
   - Regular database backups
   - File storage backups

4. **Updates**
   - Regular security updates
   - Monitor Laravel security advisories

## Support

For deployment issues:
1. Check Render documentation
2. Review application logs
3. Test individual components (database, Redis, Daily.co)
4. Verify environment variable configuration

---

**Note**: This deployment guide assumes you're using the provided `render.yaml` and deployment scripts. Adjust configurations based on your specific requirements.
