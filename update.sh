# 1. Go to your project directory
cd /var/www/your-project

# 2. Get the latest metadata from the remote repository
git fetch --all

# 3. Force the local files to match the 'main' branch exactly
# WARNING: This deletes any uncommitted changes on the server
git reset --hard origin/main

# 4. (Optional) Clean up untracked files or directories 
# that were deleted in the repo but remain on the server
git clean -fd