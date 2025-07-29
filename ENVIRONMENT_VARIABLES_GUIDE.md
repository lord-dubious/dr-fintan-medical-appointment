# Environment Variables Configuration Guide

## Overview
This guide provides the complete list of environment variables needed for the Dr. Fintan Medical Platform deployment on Render with a remote database.

## Required Environment Variables

### 🗄️ Database Configuration (Aiven MySQL)
Set these to connect to your Aiven MySQL database:

```bash
DB_CONNECTION=mysql
DB_URL=mysql://username:password@your-host.aivencloud.com:port/database?ssl-mode=REQUIRED
DB_HOST=your-mysql-host.aivencloud.com
DB_PORT=22786
DB_DATABASE=your_database_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_secure_password
```

**Note**: Your setup uses Aiven Cloud MySQL with SSL required

### 🚀 Application Configuration
```bash
APP_NAME="Medical_Appointment"
APP_ENV=production
APP_KEY=base64:your-generated-app-key-here
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://your-app-name.onrender.com
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file
PHP_CLI_SERVER_WORKERS=4
BCRYPT_ROUNDS=12
```

### 📧 Mail Configuration
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@drfintan.com
MAIL_FROM_NAME="Dr. Fintan Medical Platform"
```

**Popular SMTP providers:**
- **Gmail**: `smtp.gmail.com:587`
- **SendGrid**: `smtp.sendgrid.net:587`
- **Mailgun**: `smtp.mailgun.org:587`
- **Amazon SES**: `email-smtp.us-east-1.amazonaws.com:587`

### 🔔 Notification API
```bash
NOTIFICATION_API_CLIENT_ID=your-notification-client-id
NOTIFICATION_API_CLIENT_SECRET=your-notification-client-secret
```

### 📹 Daily.co Video Calls
```bash
DAILY_API_KEY=your-daily-api-key-here
DAILY_DOMAIN=your-subdomain.daily.co
```

### 💳 Paystack Payment
```bash
PAYSTACK_PUBLIC_KEY=pk_test_your-paystack-public-key
PAYSTACK_SECRET_KEY=sk_test_your-paystack-secret-key
PAYSTACK_CALLBACK_URL="https://your-app-name.onrender.com/appointment/payment/callback"
```

### 🔴 Redis Configuration (Aiven Redis)
```bash
REDIS_CLIENT=predis
REDIS_URL=rediss://default:password@your-redis-host.aivencloud.com:port
REDIS_HOST=your-redis-host.aivencloud.com
REDIS_PASSWORD=your_redis_password
REDIS_PORT=22787
REDIS_SCHEME=tls
```

### ☁️ Cloudflare R2 Storage
```bash
CLOUDFLARE_R2_ACCOUNT_ID=your-cloudflare-account-id
CLOUDFLARE_R2_ACCESS_KEY_ID=your-r2-access-key-id
CLOUDFLARE_R2_SECRET_ACCESS_KEY=your-r2-secret-access-key
CLOUDFLARE_R2_BUCKET_NAME=your-bucket-name
CLOUDFLARE_R2_ENDPOINT=https://your-account-id.r2.cloudflarestorage.com
```

### 🗂️ Session, Cache & Queue Configuration
```bash
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
CACHE_STORE=redis
QUEUE_CONNECTION=redis
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
```

### 🔔 Push Notifications (VAPID)
```bash
VAPID_PUBLIC_KEY=your-vapid-public-key
VAPID_PRIVATE_KEY=your-vapid-private-key
```

### 🔒 Security Configuration
```bash
BCRYPT_ROUNDS=12
SANCTUM_STATEFUL_DOMAINS=your-app-name.onrender.com
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### 📊 Logging & Storage
```bash
LOG_CHANNEL=stderr
LOG_LEVEL=info
FILESYSTEM_DISK=public
```

## Setting Environment Variables in Render

### Method 1: Render Dashboard
1. Go to your service in Render Dashboard
2. Click on "Environment" tab
3. Add each variable with "Add Environment Variable"
4. Set sensitive variables to "Secret" (they won't be visible after saving)

### Method 2: Render Blueprint (render.yaml)
Variables marked with `sync: false` must be set in the dashboard:

```yaml
envVars:
  - key: DB_HOST
    sync: false  # Set this in dashboard
  - key: DB_PASSWORD
    sync: false  # Set this in dashboard (as secret)
```

## Environment Variable Security

### 🔒 Mark as Secret
These variables should be marked as "Secret" in Render:
- `DB_PASSWORD`
- `MAIL_PASSWORD`
- `NOTIFICATION_API_CLIENT_SECRET`
- `DAILY_API_KEY`
- `PAYSTACK_SECRET_KEY`
- `VAPID_PRIVATE_KEY`
- `APP_KEY`

### 🔓 Safe to be Visible
These can remain visible:
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `MAIL_HOST`
- `MAIL_PORT`
- `APP_URL`
- `PAYSTACK_PUBLIC_KEY`
- `VAPID_PUBLIC_KEY`

## Database Setup Requirements

### Remote Database Preparation
1. **Create Database**: Ensure your remote database exists
2. **User Permissions**: Database user needs full permissions (CREATE, ALTER, DROP, INSERT, UPDATE, DELETE, SELECT)
3. **Connection Limits**: Ensure sufficient connection limits for web + queue workers
4. **SSL/TLS**: Configure if required by your database provider

### Required Database Features
- **MySQL 8.0+** or **MariaDB 10.3+**
- **InnoDB Storage Engine**
- **UTF8MB4 Character Set**
- **Timezone Support**

## Testing Environment Variables

### Local Testing
Create a `.env` file with the same variables for local testing:

```bash
# Copy .env.example to .env
cp .env.example .env

# Edit .env with your values
# Test connection
php artisan migrate:status
```

### Production Verification
After deployment, check the logs for:
- ✅ "Database connection successful!"
- ✅ "Running database migrations..."
- ✅ "Seeding essential data..."
- ✅ "Starting services..."

## Common Issues & Solutions

### Database Connection Failed
```bash
# Check these variables:
DB_HOST=correct-host
DB_PORT=3306
DB_DATABASE=existing-database-name
DB_USERNAME=valid-username
DB_PASSWORD=correct-password
```

### Mail Sending Failed
```bash
# For Gmail, use App Password:
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-character-app-password
```

### Queue Jobs Not Processing
```bash
# Ensure database queue table exists:
QUEUE_CONNECTION=database
# Check supervisor logs in container
```

### Session Issues
```bash
# Ensure session table exists:
SESSION_DRIVER=database
# Check APP_KEY is set correctly
```

## Deployment Checklist

### Before Deployment
- [ ] Remote database created and accessible
- [ ] All environment variables prepared
- [ ] SMTP credentials tested
- [ ] API keys obtained (Daily.co, Paystack, etc.)

### After Deployment
- [ ] Check deployment logs for errors
- [ ] Verify database connection
- [ ] Test user registration/login
- [ ] Test appointment booking
- [ ] Test email sending
- [ ] Verify queue processing
- [ ] Check cron jobs execution

## Support

If you encounter issues:
1. Check Render deployment logs
2. Verify all environment variables are set
3. Test database connection independently
4. Check API key validity
5. Review Docker container logs

This configuration ensures your Dr. Fintan Medical Platform works seamlessly with any remote database provider while maintaining security and performance.