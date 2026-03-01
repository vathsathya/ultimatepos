# 1. Get the latest metadata from the remote repository
git fetch --all

# 2. Force the local files to match the 'main' branch exactly
# WARNING: This deletes any uncommitted changes on the server
git reset --hard origin/main

# 3. (Optional) Clean up untracked files or directories 
# that were deleted in the repo but remain on the server
git clean -fd


#!/bin/bash

echo "🚀 Starting UltimatePOS Deep Cache Clean..."

# 4. Clear Laravel Application Cache
echo "🧹 Clearing Laravel components..."

docker compose exec app composer install --no-interaction --no-plugins --no-scripts --no-autoloader

# Run update as requested by user (updates composer.lock and vendor)
docker compose exec app composer update --no-interaction --no-plugins --no-scripts


# 5. Restart Docker (only stateless services — keep DB running to avoid health-check delays)
echo "🔄 Restarting Docker containers..."
docker compose restart web app redis worker
# 6. Wait for app to be healthy before declaring success
echo "⏳ Waiting for app to be ready..."
sleep 5
docker compose ps

echo "✅ Restart complete!"