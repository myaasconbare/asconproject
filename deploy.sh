#!/bin/bash
echo "Starting auto-deploy..."

cd /home/asconunited/htdocs/asconunited.com || exit

# Get latest version from GitHub
git fetch origin main
git reset --hard origin/main

# Run Laravel commands
composer install --no-dev -o
php artisan migrate --force
php artisan optimize:clear

echo "Deployment completed on $(date)" >> /home/asconunited/htdocs/asconunited.com/deploy.log
echo "✅ Deployment done."

