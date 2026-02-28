#!/bin/bash
set -e


#1 Remove vendor folder & storage cache
echo "🧹 Removing vendor folder & storage cache..."
docker compose exec app rm -f bootstrap/cache/config.php 
docker compose exec app rm -f bootstrap/cache/packages.php
docker compose exec app rm -rf storage/framework/cache/*
docker compose exec app rm -rf storage/framework/sessions/*
docker compose exec app rm -rf storage/framework/views/*
docker compose exec app rm -rf storage/framework/testing/*
docker compose exec app rm -rf storage/framework/views/*
docker compose exec app rm -rf vendor   

# 2. Stop containers
docker compose stop
docker compose down --volumes

# 3. Flush Redis (The Engine)
# This ensures that queues and sessions stored in Redis are reset
if docker compose ps | grep -q "pos_redis"; then
    echo "⚡ Flushing Redis cache..."
    docker compose exec redis redis-cli flushall
else
    echo "⚠️ Redis container not found, skipping flush."
fi


# 4. Starting UltimatePOS
echo "🚀 Clean up and start building containers..."
docker compose up -d --build

# 5. Install composer dependencies
echo "🌱 Installing composer dependencies..."
docker compose exec app composer install --prefer-dist --no-interaction --optimize-autoloader --ignore-platform-reqs --no-dev


# 6. Link storage
echo "🔗 Linking storage..."
docker compose exec app php artisan storage:link




# 7. Running database migrations and seeding...
echo "⏳ Waiting for MySQL to be ready..."

# Retry loop: Try to run a simple 'select 1' via artisan
# If it fails, wait 2 seconds and try again.
MAX_RETRIES=30
COUNT=0

until docker compose exec app php artisan db:monitor --databases=mysql > /dev/null 2>&1; do
    if [ $COUNT -eq $MAX_RETRIES ]; then
        echo "❌ Error: MySQL took too long to start. Exiting."
        exit 1
    fi

    echo "  ...MySQL is still initializing ($((COUNT+1))/$MAX_RETRIES)..."
    sleep 2
    COUNT=$((COUNT+1))
done

echo "✅ MySQL is ready!"


# 8. Clear Laravel Application Cache
echo "🧹 Clearing Laravel components..."
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan optimize:clear

# 9. Migration and Seed data
echo "🌱 Running database migrations and seeding..."
docker compose exec app php artisan migrate:fresh --seed --force

# 10. Done
echo "🎉 Deployment complete!"