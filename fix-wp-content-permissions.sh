#!/usr/bin/env sh
set -eu

HOST_UID="$(id -u)"
WORDPRESS_GROUP_ID="${WORDPRESS_GROUP_ID:-33}"

docker compose exec -T -u root wordpress sh -c "
  chown -R ${HOST_UID}:${WORDPRESS_GROUP_ID} /var/www/html/wp-content &&
  find /var/www/html/wp-content -type d -exec chmod 2775 {} + &&
  find /var/www/html/wp-content -type f -exec chmod 664 {} +
"
