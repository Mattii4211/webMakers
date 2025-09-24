#!/bin/bash
set -e

trap 'echo "ERROR ENCOUNTERED! Stopping and removing containers..."; docker-compose down; exit 1;' ERR

echo "=== STARTING DOCKER CONTAINERS ==="
docker-compose up -d --build

echo "=== INSTALLING COMPOSER DEPENDENCIES ==="
docker-compose exec php composer install --no-interaction --no-scripts

echo "=== REQUIRE DOCTRINE PACKAGES ==="
docker-compose exec php composer require doctrine/orm:^2.20 doctrine/doctrine-bundle:^2.16 doctrine/migrations:^3.9 doctrine/doctrine-migrations-bundle:^3.4 --no-interaction --no-scripts

echo "=== DUMPING AUTOLOAD ==="
docker-compose exec php composer dump-autoload

echo "=== CLEARING CACHE ==="
docker-compose exec php php bin/console cache:clear

echo "=== CREATING DATABASE IF NOT EXISTS ==="
docker-compose exec php php bin/console doctrine:database:create --if-not-exists

echo "=== GENERATE MIGRATIONS IF THEY DO NOT EXIST ==="
docker-compose exec php php bin/console make:migration || true

echo "=== RUNNING DOCTRINE MIGRATIONS ==="
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction || true

echo "=== PROJECT READY! ==="
echo "Access your app at http://localhost:8080"
echo "To stop the containers, run: docker-compose down"
echo "To view logs, run: docker-compose logs -f"