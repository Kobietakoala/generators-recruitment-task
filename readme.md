# Uruchomienie projektu
1. `.env.example` należy zmienić na `.env` oraz uzupełnić dane do połączenia z bazą
2. W katalogu głównym należy wykonać komendę `composer install`
3. Nastepnie migracje `php bin/console doctrine:migrations:migrate`
4. Aplikacje należy uruchomić za pomocą komendy `symfony server:start`

# GeneratorFixtures - narzędzie do wypełnienia danych na 2019 rok
Wywołanie
```
php bin/console doctrine:fixtures:load
```

# Endpointy
W pliku `/endpoints/insomia.json` zostawiłam export stworzonych przeze mnie enpointów. <br/>
Domyślny host od symfony `127.0.0.1:8000`


generator_id - ID generatora <br/>
power - moc w kW <br/>
time - czas pomiaru

### Utworzenie nowego wpisu dla generatora

```
POST /api/generators/create
{
	"generator_id": int,
	"power": int
}
```
np.
```
POST /api/generators/create
{
	"generator_id": 2,
	"power": 212
}
```
### Pobranie ostatniej wartości generatora
```
GET api/generators/{generator_id}
```

### Pobranie listy pomiarów generatora w przedziale od/do
Lista jest zwracana od najnowszego do najstarszgo rekordu. <br>
date_from, date_to muszą być datą w postaci `YYYY-mm-dd` <br>
page jest opcjonalnym parametrem, domyślnie wyświetla pierwszą strone
```
GET api/generators/{generator_id}/{date_from}/{date_to}/{page}
```
np. Dane pierwszego generatora z dnia 2019-01-01, strona 5
```
GET api/generators/1/2019-01-01/2019-01-01/5
```



# Tabela Generator 
|   Generator  	|          	|
|:------------:	|:--------:	|
|      id      	|    PK    	|
| generator_id 	| smallint 	|
|     power    	|  integer 	|
|     time     	|   float  	|

Pole generator_id zawiera ID generatora. <br/>
Pole power przechowuje moc generatora w kW. <br/>
Pole time przechowuje microtime czasu zapisu. <br/>

Chciałaym zwrócić tu uwagę na fakt, że dane tabeli nigdy nie są aktualizowane, tylko dodawane są nowe rekordy. Dlatego rekordy zawierające aktualne dane znajdują się zawsze na końcu tabeli.

# Dzienny raport
Dzienny raport możemy wowołać za pomocą komendy 
```
php bin/console app:daily-report
```

Domyślne wywołanie jest ustawione na aktualny dzień. Raport generowany jest do pdf na podstawie `templates/pdf/report.html.twig` jako tabela i zapisywany w folderze `public/`.

