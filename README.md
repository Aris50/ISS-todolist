# ISS Todo List Application

O aplicație simplă de listă de sarcini (todo list) dezvoltată cu PHP și MySQL.

## Caracteristici

- Adăugare sarcini noi
- Marcare sarcini ca completate
- Ștergere sarcini
- Interfață modernă și responsive
- Pop-up de confirmare elegant pentru ștergere

## Cerințe

- PHP 7.0 sau mai nou
- MySQL 5.7 sau mai nou
- Server web (Apache, Nginx, etc.)

## Instalare

1. Clonează repository-ul:
```bash
git clone https://github.com/Aris50/ISS-todolist.git
```

2. Creează baza de date MySQL:
```sql
CREATE DATABASE todo_app;

USE todo_app;

CREATE TABLE todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task TEXT NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. Configurează conexiunea la baza de date:
   - Editează fișierul `config/database.php`
   - Actualizează credențialele pentru baza de date

4. Pornește serverul web și accesează aplicația

## Structură proiect

```
ISS-todolist/
├── config/
│   └── database.php
├── index.php
└── README.md
```

## Contribuții

Contribuțiile sunt binevenite! Te rog să creezi un pull request pentru orice modificare.

## Licență

MIT 