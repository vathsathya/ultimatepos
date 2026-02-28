FROM nginx:alpine
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY public /var/www/public
# Create the storage symlink exactly as artisan storage:link would
RUN rm -rf /var/www/public/storage && ln -s /var/www/storage/app/public /var/www/public/storage
