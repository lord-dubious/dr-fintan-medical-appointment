#!/bin/bash

# =============================================================================
# Dr. Fintan Medical Appointment System - Deployment Script
# =============================================================================
# This script automates the deployment process for the medical appointment system
# Usage: ./deploy.sh [environment]
# Example: ./deploy.sh production
# =============================================================================

set -e  # Exit on any error

# Configuration
ENVIRONMENT=${1:-production}
PROJECT_DIR=$(pwd)
LOG_FILE="$PROJECT_DIR/deployment.log"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Logging function
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1" | tee -a "$LOG_FILE"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1" | tee -a "$LOG_FILE"
    exit 1
}

warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1" | tee -a "$LOG_FILE"
}

info() {
    echo -e "${BLUE}[INFO]${NC} $1" | tee -a "$LOG_FILE"
}

# Check if running as root
check_permissions() {
    if [[ $EUID -eq 0 ]]; then
        warning "Running as root. Consider using a non-root user for security."
    fi
}

# Check system requirements
check_requirements() {
    log "Checking system requirements..."
    
    # Check PHP version
    if ! command -v php &> /dev/null; then
        error "PHP is not installed"
    fi
    
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    if [[ $(echo "$PHP_VERSION 8.1" | awk '{print ($1 >= $2)}') -eq 0 ]]; then
        error "PHP 8.1 or higher is required. Current version: $PHP_VERSION"
    fi
    
    # Check Composer
    if ! command -v composer &> /dev/null; then
        error "Composer is not installed"
    fi
    
    # Check Node.js
    if ! command -v node &> /dev/null; then
        error "Node.js is not installed"
    fi
    
    # Check database connection
    if [[ -f .env ]]; then
        php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connection successful';" || error "Database connection failed"
    fi
    
    log "System requirements check passed"
}

# Backup current deployment
backup_current() {
    if [[ "$ENVIRONMENT" == "production" ]]; then
        log "Creating backup of current deployment..."
        
        BACKUP_DIR="backups/$(date +'%Y%m%d_%H%M%S')"
        mkdir -p "$BACKUP_DIR"
        
        # Backup database
        if [[ -f .env ]]; then
            DB_NAME=$(grep DB_DATABASE .env | cut -d '=' -f2)
            DB_USER=$(grep DB_USERNAME .env | cut -d '=' -f2)
            DB_PASS=$(grep DB_PASSWORD .env | cut -d '=' -f2)
            
            if [[ -n "$DB_NAME" && -n "$DB_USER" ]]; then
                mysqldump -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_DIR/database.sql"
                log "Database backup created: $BACKUP_DIR/database.sql"
            fi
        fi
        
        # Backup storage directory
        if [[ -d storage/app ]]; then
            cp -r storage/app "$BACKUP_DIR/"
            log "Storage backup created: $BACKUP_DIR/app"
        fi
        
        # Backup .env file
        if [[ -f .env ]]; then
            cp .env "$BACKUP_DIR/"
            log "Environment file backup created: $BACKUP_DIR/.env"
        fi
    fi
}

# Install/Update dependencies
install_dependencies() {
    log "Installing/updating dependencies..."
    
    # PHP dependencies
    if [[ "$ENVIRONMENT" == "production" ]]; then
        composer install --no-dev --optimize-autoloader
    else
        composer install
    fi
    
    # Node.js dependencies
    npm ci
    
    log "Dependencies installed successfully"
}

# Environment setup
setup_environment() {
    log "Setting up environment..."
    
    # Copy .env.example if .env doesn't exist
    if [[ ! -f .env ]]; then
        cp .env.example .env
        warning ".env file created from .env.example. Please configure it before continuing."
        info "Edit .env file with your configuration and run this script again."
        exit 1
    fi
    
    # Generate app key if not set
    if ! grep -q "APP_KEY=base64:" .env; then
        php artisan key:generate
        log "Application key generated"
    fi
    
    log "Environment setup completed"
}

# Database operations
setup_database() {
    log "Setting up database..."
    
    # Run migrations
    if [[ "$ENVIRONMENT" == "production" ]]; then
        php artisan migrate --force
    else
        php artisan migrate
    fi
    
    # Seed database if needed (only for fresh installations)
    if [[ "$1" == "--seed" ]]; then
        php artisan db:seed
        log "Database seeded with initial data"
    fi
    
    log "Database setup completed"
}

# Storage and permissions
setup_storage() {
    log "Setting up storage and permissions..."
    
    # Create storage link
    php artisan storage:link
    
    # Set permissions
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
    
    # Create necessary directories
    mkdir -p storage/app/public/uploads
    mkdir -p storage/app/public/profiles
    mkdir -p storage/logs
    
    log "Storage setup completed"
}

# Build frontend assets
build_assets() {
    log "Building frontend assets..."
    
    if [[ "$ENVIRONMENT" == "production" ]]; then
        npm run build
    else
        npm run dev
    fi
    
    log "Frontend assets built successfully"
}

# Cache optimization
optimize_cache() {
    log "Optimizing cache..."
    
    # Clear all caches
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    
    # Optimize for production
    if [[ "$ENVIRONMENT" == "production" ]]; then
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        php artisan event:cache
    fi
    
    log "Cache optimization completed"
}

# Setup queue worker (production only)
setup_queue_worker() {
    if [[ "$ENVIRONMENT" == "production" ]]; then
        log "Setting up queue worker..."
        
        # Create supervisor configuration
        SUPERVISOR_CONF="/etc/supervisor/conf.d/laravel-worker.conf"
        
        if [[ ! -f "$SUPERVISOR_CONF" ]]; then
            cat > /tmp/laravel-worker.conf << EOF
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php $PROJECT_DIR/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=$PROJECT_DIR/storage/logs/worker.log
stopwaitsecs=3600
EOF
            
            info "Supervisor configuration created at /tmp/laravel-worker.conf"
            info "Please move it to /etc/supervisor/conf.d/ and restart supervisor:"
            info "sudo mv /tmp/laravel-worker.conf /etc/supervisor/conf.d/"
            info "sudo supervisorctl reread && sudo supervisorctl update"
        fi
    fi
}

# Health check
health_check() {
    log "Performing health check..."
    
    # Check if application is accessible
    if command -v curl &> /dev/null; then
        if curl -f -s http://localhost > /dev/null; then
            log "Application is accessible"
        else
            warning "Application may not be accessible via HTTP"
        fi
    fi
    
    # Check Daily.co configuration
    if grep -q "DAILY_API_KEY=" .env && grep -q "DAILY_DOMAIN=" .env; then
        log "Daily.co configuration found"
    else
        warning "Daily.co configuration missing. Video calls will not work."
    fi
    
    # Check Paystack configuration
    if grep -q "PAYSTACK_PUBLIC_KEY=" .env && grep -q "PAYSTACK_SECRET_KEY=" .env; then
        log "Paystack configuration found"
    else
        warning "Paystack configuration missing. Payments will not work."
    fi
    
    log "Health check completed"
}

# Main deployment function
main() {
    log "Starting deployment for environment: $ENVIRONMENT"
    
    check_permissions
    check_requirements
    backup_current
    install_dependencies
    setup_environment
    setup_database "$2"
    setup_storage
    build_assets
    optimize_cache
    setup_queue_worker
    health_check
    
    log "Deployment completed successfully!"
    info "Application is ready at: $(grep APP_URL .env | cut -d '=' -f2)"
    
    if [[ "$ENVIRONMENT" == "production" ]]; then
        info "Don't forget to:"
        info "1. Configure your web server (Apache/Nginx)"
        info "2. Set up SSL certificate"
        info "3. Configure supervisor for queue workers"
        info "4. Set up regular backups"
    fi
}

# Script usage
usage() {
    echo "Usage: $0 [environment] [options]"
    echo "Environments: production, staging, development"
    echo "Options:"
    echo "  --seed    Seed the database with initial data"
    echo "  --help    Show this help message"
}

# Parse arguments
case "$1" in
    --help)
        usage
        exit 0
        ;;
    *)
        main "$@"
        ;;
esac
