♟️ Chess Puzzle Trainer
Laravel aplikacija za unos, upravljanje i rješavanje šahovskih zagonetki.

🔧 Tehnologije
PHP 8.x

Laravel 10.x

MySQL

Blade Templates

Bootstrap 5

Chessboard.js + Chess.js za prikaz i validaciju poteza

🚀 Pokretanje projekta
Slijedite ove korake za pokretanje projekta na vašem lokalnom stroju:

Kloniraj repozitorij

git clone https://github.com/ivanabramusic/Chess-puzzle-trainer.git
cd Chess-puzzle-trainer

Instaliraj ovisnosti

composer install
npm install && npm run dev

Kopiraj .env datoteku i generiraj ključ

cp .env.example .env
php artisan key:generate

Postavi bazu podataka
U .env datoteci unesi podatke za svoju MySQL bazu:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chess_db # <--- Ovdje unesite naziv vaše baze podataka
DB_USERNAME=root     # <--- Ovdje unesite korisničko ime za bazu podataka
DB_PASSWORD=         # <--- Ovdje unesite lozinku za bazu podataka

Migriraj tablice i pokreni aplikaciju

php artisan migrate
php artisan serve

Pokreni aplikaciju
Otvori http://localhost:8000 u svom pregledniku.
