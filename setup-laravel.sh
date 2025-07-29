#!/bin/bash

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
until docker-compose exec mysql mysql -h mysql -u laravel -psecret -e "SELECT 1" > /dev/null 2>&1; do
  sleep 1
done

# Créer un répertoire temporaire pour installer Laravel
echo "Creating temporary directory for Laravel installation..."
docker-compose exec app mkdir -p /tmp/laravel-temp

# Install Laravel using Composer dans un répertoire temporaire
echo "Installing Laravel 12..."
docker-compose exec app composer create-project laravel/laravel:^12.0 /tmp/laravel-temp --prefer-dist

# Copier les fichiers Laravel vers le répertoire de travail
echo "Copying Laravel files to working directory..."
docker-compose exec app sh -c "cp -r /tmp/laravel-temp/. /var/www/html/ && rm -rf /tmp/laravel-temp"

# Configure .env file
echo "Configuring environment variables..."
docker-compose exec app cp .env.example .env
docker-compose exec app sed -i "s/DB_HOST=127.0.0.1/DB_HOST=mysql/g" .env
docker-compose exec app sed -i "s/DB_DATABASE=laravel/DB_DATABASE=laravel/g" .env
docker-compose exec app sed -i "s/DB_USERNAME=root/DB_USERNAME=laravel/g" .env
docker-compose exec app sed -i "s/DB_PASSWORD=/DB_PASSWORD=secret/g" .env

# Generate application key
echo "Generating application key..."
docker-compose exec app php artisan key:generate

# Set proper permissions
echo "Setting proper permissions..."
docker-compose exec app chown -R www:www /var/www/html/storage
docker-compose exec app chown -R www:www /var/www/html/bootstrap/cache

# Run migrations
echo "Running database migrations..."
docker-compose exec app php artisan migrate

echo "Laravel 12 installation complete! Access your application at http://localhost:8000"
