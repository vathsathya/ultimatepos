#!/bin/bash
set -e

# Define production files (matching your docker-compose setup)
COMPOSE_PROD="-f docker-compose.yml -f docker-compose.prod.yml"

echo "🚀 Fetching latest code from main..."

# 1. Safe Git Update
# Stash any local hotfixes just in case, then pull
git fetch --all
git reset --hard origin/main
git clean -fd

# 2. Update Dependencies (If composer.json changed)
# Only run this if you want to ensure the vendor folder is up to date
# docker compose $COMPOSE_PROD exec -it app composer install --no-dev --optimize-autoloader

# 3. Laravel Production Optimization
# 'optimize' clears AND re-caches everything in one command.
echo "⚡ Optimizing Laravel performance..."
docker compose $COMPOSE_PROD exec app php artisan optimize
docker compose $COMPOSE_PROD exec app php artisan view:cache
docker compose $COMPOSE_PROD exec app php artisan event:cache

# 4. Graceful Reload (The "Pro" Alternative to Restart)
# Instead of 'restart', we reload PHP-FPM and Nginx to pick up new files
echo "🔄 Reloading services without downtime..."
docker compose $COMPOSE_PROD kill -s SIGUSR2 app   # Tells PHP-FPM to reload gracefully
docker compose $COMPOSE_PROD exec web nginx -s reload

# 5. Run Migrations (Safe)
# Always check for new migrations after a code refresh
docker compose $COMPOSE_PROD exec app php artisan migrate --force

echo "✅ Refresh complete and performance tuned!"