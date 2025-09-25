# Symfony DDD Skeleton

## Wymagania
- Docker + Docker Compose
- PHP 8.2+ (lokalnie, jeśli bez Dockera)
- Composer

## Uruchomienie projektu
```bash
Windows:
bash docker-start.sh

Linux/MacOS:
./docker-start.sh

```

## Wypełnienie bazy:
```bash
docker-compose exec php php bin/console doctrine:fixtures:load --env=dev
```

## Komenda CLI
Generowanie ostrzeżeń:
```bash
docker-compose exec php bin/console app:warnings:generate
```
