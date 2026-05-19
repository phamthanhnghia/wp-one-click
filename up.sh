#!/usr/bin/env sh
set -eu

docker compose up -d
./fix-wp-content-permissions.sh
