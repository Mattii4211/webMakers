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

## Komenda CLI
Generowanie ostrzeżeń:
```bash
docker-compose exec php bin/console app:warnings:generate
```

## Architektura
- **Finance**: Contractor, Invoice, Budget
- **Core**: Warning
- Warstwy: Domain (encje, interfejsy repozytoriów), Application (use-case), Infrastructure (Doctrine, CLI).

## Fixtures
Dodane przykładowe dane: 1 kontrahent, 1 budżet z ujemnym saldem, 1 faktura przeterminowana.
