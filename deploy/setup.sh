#!/bin/bash

# 000form.com Deployment Script for Digital Ocean Ubuntu 24.04
# Run as root or with sudo

set -e

echo "==================================="
echo "000form.com Deployment Script"
echo "==================================="

# Configuration
APP_DIR="/var/www/000form"
APP_USER="www-data"
DOMAIN="000form.com"

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

print_status() {
    echo -e "${GREEN}[+]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[!]${NC} $1"
}

# Update system
print_status "Updating system packages..."
apt update && apt upgrade -y

# Install required packages
print_status "Installing required packages..."
apt install -y \
    nginx \
    php8.2-fpm \
    php8.2-cli \
    php8.2-common \
    php8.2-pgsql \
    php8.2-curl \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-zip \
    php8.2-bcmath \
    php8.2-intl \
    php8.2-gd \
    postgresql-client \
    git \
    unzip \
    certbot \
    python3-certbot-nginx \
    supervisor

# Install Composer
print_status "Installing Composer..."
if [ ! -f /usr/local/bin/composer ]; then
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi

# Create application directory
print_status "Setting up application directory..."
mkdir -p $APP_DIR
cd $APP_DIR

# Clone or copy application files
print_status "Copying application files..."
# Note: In production, you would git clone from your repo
# git clone https://github.com/yourusername/000form.git .

# Set permissions
print_status "Setting permissions..."
chown -R $APP_USER:$APP_USER $APP_DIR
chmod -R 755 $APP_DIR
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache

# Install PHP dependencies
print_status "Installing PHP dependencies..."
cd $APP_DIR
sudo -u $APP_USER composer install --no-dev --optimize-autoloader

# Setup environment
print_status "Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
    print_warning "Please edit .env file with your configuration!"
fi

# Run migrations
print_status "Running database migrations..."
php artisan migrate --force

# Cache configuration
print_status "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Setup Nginx
print_status "Configuring Nginx..."
cp deploy/nginx.conf /etc/nginx/sites-available/$DOMAIN
ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Add rate limiting to nginx.conf
if ! grep -q "limit_req_zone" /etc/nginx/nginx.conf; then
    sed -i '/http {/a \    limit_req_zone $binary_remote_addr zone=submissions:10m rate=10r/s;' /etc/nginx/nginx.conf
fi

nginx -t && systemctl reload nginx

# Setup SSL with Let's Encrypt
print_status "Setting up SSL certificate..."
certbot --nginx -d $DOMAIN -d www.$DOMAIN --non-interactive --agree-tos --email admin@$DOMAIN || print_warning "SSL setup failed - you may need to run certbot manually"

# Setup Queue Worker with Supervisor
print_status "Setting up queue worker..."
cat > /etc/supervisor/conf.d/000form-worker.conf << EOF
[program:000form-worker]
process_name=%(program_name)s_%(process_num)02d
command=php $APP_DIR/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=$APP_USER
numprocs=2
redirect_stderr=true
stdout_logfile=$APP_DIR/storage/logs/worker.log
stopwaitsecs=3600
EOF

supervisorctl reread
supervisorctl update
supervisorctl start 000form-worker:*

# Setup Cron for Laravel Scheduler
print_status "Setting up cron job..."
(crontab -u $APP_USER -l 2>/dev/null; echo "* * * * * cd $APP_DIR && php artisan schedule:run >> /dev/null 2>&1") | crontab -u $APP_USER -

# Restart services
print_status "Restarting services..."
systemctl restart php8.2-fpm
systemctl restart nginx

echo ""
echo "==================================="
echo -e "${GREEN}Deployment Complete!${NC}"
echo "==================================="
echo ""
echo "Next steps:"
echo "1. Edit $APP_DIR/.env with your configuration"
echo "2. Configure your Supabase connection"
echo "3. Set up your mail server settings"
echo "4. Run: php artisan migrate"
echo "5. Visit https://$DOMAIN"
echo ""
print_warning "Don't forget to configure your firewall (ufw)!"
echo "  ufw allow 22"
echo "  ufw allow 80"
echo "  ufw allow 443"
echo "  ufw enable"
