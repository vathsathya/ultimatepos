#!/bin/bash
set -e

# Define production files
COMPOSE_PROD="-f docker-compose.yml -f docker-compose.prod.yml"

echo "🚀 Starting Production Deployment..."

# 1. Detect Local IDs to prevent Permission Denied errors
CURRENT_UID=$(id -u)
CURRENT_GID=$(id -g)
echo "👤 Building with User ID: $CURRENT_UID and Group ID: $CURRENT_GID"

# 2. Build and Start 
# Passing --build-arg via the 'build' command or 'up'
docker compose $COMPOSE_PROD build \
    --build-arg USER_ID=$CURRENT_UID \
    --build-arg GROUP_ID=$CURRENT_GID

# Start the services
docker compose $COMPOSE_PROD up -d --remove-orphans

# 3. Wait for App Health
echo "⏳ Waiting for 'app' to be healthy..."

MAX_RETRIES=30
COUNT=0
while [ "$COUNT" -lt "$MAX_RETRIES" ]; do
    # Get the container ID first to avoid errors if it's restarting
    CONTAINER_ID=$(docker compose $COMPOSE_PROD ps -q app)
    
    if [ -z "$CONTAINER_ID" ]; then
        STATUS="starting"
    else
        STATUS=$(docker inspect --format='{{.State.Health.Status}}' "$CONTAINER_ID" 2>/dev/null || echo "starting")
    fi
    
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
    docker compose $COMPOSE_PROD logs app --tail=50
    exit 1
fi

# 4. Laravel Tasks
echo "🔄 Running migrations and optimization..."
# We use 'exec -u www-data' to ensure the tasks run as the correct user
docker compose $COMPOSE_PROD exec -u www-data app php artisan migrate --force
docker compose $COMPOSE_PROD exec -u www-data app php artisan module:publish
docker compose $COMPOSE_PROD exec -u www-data app php artisan optimize

# 5. Clean up (Safe)
echo "🧹 Cleaning up old images and cache..."
docker image prune -f

echo "🎉 Deployment complete!"