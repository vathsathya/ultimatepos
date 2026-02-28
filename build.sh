#!/bin/bash
set -e


#1 Remove vendor folder & storage cache
echo "🧹 Removing vendor folder & storage cache..."
rm -f bootstrap/cache/config.php 
rm -f bootstrap/cache/packages.php
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
rm -rf storage/framework/testing/*
rm -rf storage/framework/views/*
rm -rf vendor

# 2. Flush Redis (The Engine)
# This ensures that queues and sessions stored in Redis are reset
if docker compose ps | grep -q "pos_redis"; then
    echo "⚡ Flushing Redis cache..."
    docker compose exec redis redis-cli flushall
else
    echo "⚠️ Redis container not found, skipping flush."
fi


# 3. Stop containers
docker compose stop
docker compose down --volumes


# 4. Starting UltimatePOS
echo "🚀 Clean up and start building containers..."
export USER_ID=$(id -u)
export GROUP_ID=$(id -g)
docker compose build --build-arg USER_ID=${USER_ID} --build-arg GROUP_ID=${GROUP_ID}
USER_ID=${USER_ID} GROUP_ID=${GROUP_ID} docker compose up -d

# 5. Running database migrations and seeding...
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

# 6. Clear Laravel Caches (requires Redis alive)
echo "🧹 Clearing Laravel caches..."
docker compose exec app php artisan optimize:clear

# 7. Migration and Seed data
echo "🌱 Running database migrations and seeding..."
docker compose exec app php artisan migrate:fresh --seed --force

# 10. Done
echo "🎉 Deployment complete!"