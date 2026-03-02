#!/bin/bash
set -e

# Define production files
COMPOSE_PROD="-f docker-compose.yml -f docker-compose.prod.yml"

echo "🚀 Starting Production Deployment..."

# 1. Build and Start (No 'down' to avoid data loss and high downtime)
docker compose $COMPOSE_PROD up -d --build

# 2. Wait for App Health
echo "⏳ Waiting for 'app' to be healthy..."


MAX_RETRIES=30
COUNT=0
while [ "$COUNT" -lt "$MAX_RETRIES" ]; do
    STATUS=$(docker inspect --format='{{.State.Health.Status}}' $(docker compose ps -q app) 2>/dev/null || echo "starting")
    
    if [ "$STATUS" == "healthy" ]; then
        echo "✅ App is healthy!"
        break
    fi
    
    echo "Current status: $STATUS... (Attempt $((COUNT+1))/$MAX_RETRIES)"
    sleep 2
    COUNT=$((COUNT+1))
done

if [ "$STATUS" != "healthy" ]; then
    echo "❌ Error: App failed to start."
    docker compose $COMPOSE_PROD logs app --tail=20
    exit 1
fi

# 3. Laravel Tasks
echo "🔄 Running migrations and optimization..."
docker compose $COMPOSE_PROD exec app php artisan migrate --force
docker compose $COMPOSE_PROD exec app php artisan module:publish
docker compose $COMPOSE_PROD exec app php artisan optimize

# 4. Clean up old images (Safe)
docker image prune -f

echo "🎉 Deployment complete with Cloudflare Tunnel!"