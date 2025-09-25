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


## Uwagi:

* Generowanie zamkniętych ostrzeżeń można oprzeć na eventach.
* Namespace i rozkład katalogów też zapewne można ulepszyć. 
* Sam zapis ostrzeżenia można by przerobić na SQL i ON DUPLICATE KEY, zapewne przy większej ilość można by się pokusić o zapis paczkami lub użyć CQRS 
* Jak coś nie tak z branchami to pewnie przez przyzwyczajenia :D, ale zasadniczo są main i feature 
* Trzeba by dopisać testy jednak w ~3h to raczej średnio wykonalne 
* Z racji małej ilości danych to przeglądanie całych tabel jest ok (zapewne należałooby ustalić które rekordy faktycznie potrzebujemy sprawdzać) ale przy większej ilość Eventy lub CQRS wydają się lepszym podejściem 