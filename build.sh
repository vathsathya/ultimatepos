#!/bin/bash
set -e


# 1. Starting UltimatePOS
echo "🚀 Clean up and start building containers..."
docker compose down --volumes
docker compose up -d --build


# 3. Flush Redis (The Engine)
# This ensures that queues and sessions stored in Redis are reset
if docker compose ps | grep -q "pos_redis"; then
    echo "⚡ Flushing Redis cache..."
    docker compose exec redis redis-cli flushall
else
    echo "⚠️ Redis container not found, skipping flush."
fi



# 4. Running database migrations and seeding...
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

echo "🌱 Running database migrations and seeding..."
# 2. Clear Laravel Application Cache
echo "🧹 Clearing Laravel components..."
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan migrate:fresh --seed --force

echo "🎉 Deployment complete!"