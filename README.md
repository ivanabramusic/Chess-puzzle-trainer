# ♟️ Chess Puzzle Trainer

**Laravel aplikacija za unos, upravljanje i rješavanje šahovskih zagonetki.**

---

## 🔧 Tehnologije

- PHP 8.x  
- Laravel 10.x  
- MySQL  
- Blade Templates  
- Bootstrap 5  
- Chessboard.js + Chess.js za prikaz i validaciju poteza

---

## 🚀 Pokretanje projekta

Slijedite ove korake za pokretanje projekta na vašem lokalnom stroju:

1. **Kloniraj repozitorij**  
   ```bash
   git clone https://github.com/ivanabramusic/Chess-puzzle-trainer.git
   cd Chess-puzzle-trainer

2. **Instaliraj PHP ovisnosti**
    ```bash
    composer install
   
3. **Instaliraj JavaScript ovisnosti (uključujući chess.js i chessboardjs)**
    ```bash
    npm install
    npm install chess.js @chrisoakman/chessboardjs

4. **Pokreni izgradnju frontenda**
    ```bash
    npm run dev

5. **Kopiraj .env datoteku i generiraj aplikacijski ključ**
    ```bash
    cp .env.example .env
    php artisan key:generate

6. **Postavi bazu podataka**
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=chess_db       # <-- ovdje unesite naziv baze podataka
    DB_USERNAME=root           # <-- korisničko ime za bazu
    DB_PASSWORD=
    
7. **Migriraj tablice**
    ```bash
    php artisan migrate
    
8. **Pokreni Laravel development server**
   ```bash
   php artisan serve

9. **Otvori aplikaciju**
    U pregledniku posjeti: http://localhost:8000

