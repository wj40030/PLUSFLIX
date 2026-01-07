# PLUSFLIX - Aplikacja MVC

Projekt PLUSFLIX to aplikacja internetowa zbudowana w architekturze **MVC** (Model-View-Controller) w języku PHP.

## Wymagania
- Środowisko serwerowe (np. XAMPP, Apache).
- PHP 8.x lub nowszy.
- MySQL/MariaDB.

## Instalacja i Pierwsze Kroki

### 1. Przygotowanie Bazy Danych
1. Uruchom serwer baz danych.
2. Otwórz narzędzie do zarządzania bazą (np. phpMyAdmin).
3. Utwórz nową bazę danych (np. o nazwie `plusflix`).
4. Zaimportuj plik `sql/setup.sql` znajdujący się w folderze projektu.

### 2. Konfiguracja Aplikacji
Otwórz plik `config/config.php` i dostosuj stałe:
- `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`: Dane do Twojej bazy danych.
- `URLROOT`: Bazowy adres URL projektu (np. `http://localhost`).
- `SITENAME`: Nazwa Twojego projektu.

### 3. Uruchomienie
Umieść projekt w folderze publicznym swojego serwera. Aplikacja powinna być dostępna pod adresem zdefiniowanym w `URLROOT`.

## Rozbudowa aplikacji

### Dodawanie nowej podstrony
1. **Kontroler**: W pliku `app/Controllers/Pages.php` dodaj nową metodę, np. `public function kontakt()`.
2. **Widok**: W folderze `app/Views/pages/` stwórz plik `kontakt.php`.
3. **Logika**: W metodzie kontrolera przygotuj dane w tablicy `$data` i wywołaj `$this->view('pages/kontakt', $data);`.
4. **URL**: Twoja strona będzie dostępna pod adresem `URLROOT/kontakt`.

### Praca z Bazą Danych (Modele)
1. **Tabela**: Dodaj nową tabelę w bazie danych.
2. **Model**: Stwórz nową klasę w `app/Models/` (np. `Katalog.php`), która będzie wykonywać zapytania do bazy.
3. **Użycie**: W konstruktorze kontrolera załaduj model: `$this->katalogModel = $this->model('Katalog');`.

### Zarządzanie Wyglądem (CSS)
- **Style Globalne**: Edytuj `public/css/style.css`. Są one ładowane na każdej stronie.
- **Style Dedykowane**: 
    1. Stwórz plik `.css` w `public/css/`.
    2. W kontrolerze przekaż nazwę pliku w tablicy `$data`: `'css' => 'nazwa_pliku'`.
    3. Nagłówek automatycznie dołączy ten arkusz tylko dla tej konkretnej podstrony.

## Struktura Projektu
- `app/` - Logika aplikacji (Kontrolery, Modele, Widoki).
- `config/` - Pliki konfiguracyjne.
- `core/` - Silnik frameworka.
- `public/` - Pliki publiczne (index.php, CSS, obrazy).
- `sql/` - Skrypty bazy danych.
