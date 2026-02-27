#!/bin/bash

echo "🚀 Starting UltimatePOS Deep Cache Clean..."

# 1. Clear Laravel Application Cache
echo "🧹 Clearing Laravel components..."
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan optimize:clear

# 2. Flush Redis (The Engine)
# This ensures that queues and sessions stored in Redis are reset
if docker compose ps | grep -q "pos_redis"; then
    echo "⚡ Flushing Redis cache..."
    docker compose exec redis redis-cli flushall
else
    echo "⚠️ Redis container not found, skipping flush."
fi

# 3. Restart Docker
echo "🔄 Restarting Docker containers..."
docker compose down web app redis worker
docker compose up -d web app redis worker

echo "✅ All Restarting Docker containers...!"