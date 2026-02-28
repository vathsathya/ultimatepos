#!/bin/bash

echo "🚀 Starting UltimatePOS Deep Cache Clean..."

# 1. Clear Laravel Application Cache
echo "🧹 Clearing Laravel components..."
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan optimize:clear

# 2. Flush ONLY the cache database (DB 1) — preserve sessions (DB 0) and queues (DB 0)
# redis-cli FLUSHALL would destroy sessions and log everyone out → CSRF token mismatch errors
if docker compose ps | grep -q "pos_redis"; then
    echo "⚡ Flushing Redis cache database (DB 1 only)..."
    docker compose exec redis redis-cli -n 1 FLUSHDB
    echo "✅ Redis cache flushed. Sessions and queues preserved."
else
    echo "⚠️ Redis container not found, skipping flush."
fi

# 3. Restart Docker (only stateless services — keep DB running to avoid health-check delays)
echo "🔄 Restarting Docker containers..."
docker compose down web app redis worker
docker compose up -d web app redis worker

# 4. Wait for app to be healthy before declaring success
echo "⏳ Waiting for app to be ready..."
sleep 5
docker compose ps

echo "✅ Restart complete!"