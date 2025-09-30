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
* Jak ręcznie zmienimy kwotę FV a wcześniej istniało ostrzeżenie i po zmianie kwoty nie łapie się w próg 15000 osrzeżenie nie znika, ale tutaj wprowadziłbym osobny mechanizm do zamykania.


## Treść zadania:
WebMakers - zadanie rekrutacyjne PHP Symfony Developer
Cel
Zaprojektuj i zbuduj od podstaw małą aplikację w Symfony w architekturze DDD, która:
● utrzymuje proste modele finansowe,
● generuje ostrzeżenia według określonych reguł,
● udostępnia komendę CLI do ich wyliczania.

Stos technologiczny (wymagany)
● PHP 8.2+
● Symfony 6.4+ lub 7.x
● Doctrine ORM
● Relacyjna baza danych
● Composer
● (Opcjonalnie) Docker/Docker Compose

Zakres domeny i model danych
Moduł: Finance
Contractor (kontrahent) — powinien zawierać:
● identyfikator,
● nazwę podmiotu,
● znaczniki czasu dla utworzenia, aktualizacji i opcjonalnego miękkiego usunięcia.

Invoice (faktura) — powinna zawierać:
● identyfikator,
● unikalny numer,
● powiązanie z kontrahentem,
● kwotę,

● informację, czy została opłacona,
● termin płatności,
● znaczniki czasu dla utworzenia, aktualizacji i opcjonalnego miękkiego usunięcia.

Budget (budżet) — powinien zawierać:
● identyfikator,
● nazwę,
● bieżący stan/Saldo,
● znaczniki czasu dla utworzenia, aktualizacji i opcjonalnego miękkiego usunięcia.

Moduł: Core
Warning (ostrzeżenie) — powinno zawierać:
● identyfikator,
● odniesienie do obiektu, którego dotyczy (rodzaj obiektu oraz jego identyfikator),
● rodzaj ostrzeżenia (kategoria),
● znaczniki czasu dla utworzenia, aktualizacji i opcjonalnego miękkiego usunięcia.

Reguły generowania ostrzeżeń
Dla każdego typu obiektu sprawdź niezależne warunki:
● Contractor — dodaj ostrzeżenie, gdy suma nieopłaconych i po terminie faktur
powiązanych z danym kontrahentem przekracza 15 000 (waluta bez znaczenia).
Rodzaj ostrzeżenia: „przekroczona suma zaległości kontrahenta”.
● Invoice — dodaj ostrzeżenie, gdy faktura jest przeterminowana (nieopłacona, a termin
płatności minął).
Rodzaj ostrzeżenia: „faktura przeterminowana”.
● Budget — dodaj ostrzeżenie, gdy bieżący stan budżetu jest ujemny.
Rodzaj ostrzeżenia: „budżet poniżej zera”.

Komenda CLI
Udostępnij komendę, np.:
bin/console app:warnings:generate
Wymagania:
● Komenda nie zawiera logiki domenowej — jedynie orkiestruje uruchomienie osobnych
generatorów dla każdego typu obiektu (wspólny interfejs dla generatorów).
● Wynik działania w konsoli: zwięzły raport liczby dodanych, podtrzymanych i zamkniętych
ostrzeżeń dla każdego rodzaju.

Architektura i konwencje
● Zastosuj DDD light: osobne moduły (Core, Finance) oraz warstwy: domena, aplikacja
(use-case’y), infrastruktura (repozytoria, persystencja, CLI).
● Repozytoria jako interfejsy w domenie; implementacje w infrastrukturze.
● Encje domenowe mogą zawierać logikę, ale zachowaj rozsądek.
● Migracje muszą odtwarzać kompletny schemat.
● Dodaj fixtures ułatwiające start (kilku kontrahentów, budżetów i faktur — w tym
przypadki przeterminowane i nieprzeterminowane).

Co masz dostarczyć (deliverables)
● Publiczne repozytorium z czytelną historią commitów.
● README z:
○ wymaganiami wstępnymi,
○ instrukcją uruchomienia lokalnie (z Dockerem lub bez),
○ sposobem uruchomienia migracji i fixtures,
○ sposobem uruchomienia komendy app:warnings:generate,
○ krótkim opisem architektury i decyzji projektowych,
○ ewentualnymi założeniami/upraszczaniami.
● Gałąź funkcjonalna (np. feature/warnings) oraz PR/MR do main (może być
self-PR).
● Schemat bazy odtworzony migracjami; brak ukrytej „magii”.
● Kod zgodny ze standardami (PSR-12) z podstawową analizą statyczną.
