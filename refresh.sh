#!/bin/bash

echo "🚀 Update to latest files"

# 1. Get the latest metadata from the remote repository
git fetch --all

# 2. Force the local files to match the 'main' branch exactly
# WARNING: This deletes any uncommitted changes on the server
git reset --hard origin/main

# 3. (Optional) Clean up untracked files or directories 
# that were deleted in the repo but remain on the server
git clean -fd


# 1. Clear Laravel Application Cache
echo "🧹 Clearing Laravel components..."
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan optimize:clear

#2. Restart Services
echo "🔄 Restarting services..."
docker compose restart

echo "✅ Restart complete!"