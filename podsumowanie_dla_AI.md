# 🦁 Projekt: System Zarządzania ZOO (Laravel)

**Data ostatniej aktualizacji:** 21.01.2026
**Repozytorium:** `sebastian1657/aplikacjeinternetowe`
**Status:** Development (Funkcjonalny MVP)

---

## 1. Architektura i Główne Założenia

System realizuje koncepcję: **"Deterministyczna Struktura, Losowe Instancje"**.
Infrastruktura (mapa), taksonomia (biologia) i dietetyka są stałe, natomiast populacja zwierząt i grafiki pracy są generowane dynamicznie.

### A. Hierarchia Biologiczna
1.  **Species (Gatunek):** Kategoria ogólna (np. *Niedźwiedziowate*, *Fokowate*).
2.  **Subspecies (Podgatunek):** Konkretny typ zwierzęcia widoczny dla odwiedzających.
    * Atrybuty: `common_name` (Polska nazwa), `scientific_name` (Łacina).
    * Relacja: Przypisany do konkretnego gatunku.
3.  **Animal (Zwierzę):** Instancja podgatunku.
    * Generowane losowo przez Factory (imię, płeć, data urodzenia).

### B. Infrastruktura (Enclosures)
Wybiegi są zdefiniowane "na sztywno" w Seederze. Każdy ma określoną pojemność (`capacity`) i typ.
**Typy wybiegów:**
* `open_air` (np. Sawanna Słoni, Wybieg Żyraf)
* `indoor_cage` (np. Małpi Gaj, Pustynia)
* `aviary` (np. Papugarnia, Dżungla Tukanów)
* `aquarium` (np. Oceanarium, Rafa Koralowa)
* `pool_enclosure` (np. Basen Fok, Zatoka Nerp)
* `cooled_enclosure` (np. Wybieg lodowy - Pingwiny)

### C. System Żywienia (Strict Diet System)
Model oparty na precyzyjnych dawkach pokarmowych.
* **Food:** Produkty (np. *Wołowina, Siano, Bambus, Larwy mącznika*) z jednostkami (`kg`, `szt`, `g`).
* **DietPlan:** Nazwane plany żywieniowe (np. *Dieta słoni*, *Dieta owadożerców*).
* **Relacja `diet_food`:** Określa dokładną ilość (`amount`) danego produktu w diecie.

---

## 2. Struktura Bazy Danych i Modele

### Kluczowe Encje
1.  **`User` (Użytkownicy):**
    * Role systemowe: `admin`, `manager`, `supervisor`, `employee`.
    * **Nowość:** Relacja `specializations` (Many-to-Many z `Species`) – pozwala określić, w jakich gatunkach specjalizuje się pracownik.
    * Helpery: `isEmployee()`, `isManager()`, `todaySchedule()`.
2.  **`Care` (Grafik):**
    * Przypisanie pracownika do **podgatunku** (`subspecies_id`) na konkretną datę i zmianę (1, 2, 3).
3.  **`Ticket` (Logika w Kontrolerze):**
    * System nie posiada tabeli biletów w bazie (staneless checkout), generuje PDF w locie.
    * Typy biletów: Normalny, Ulgowy, Dziecko, Senior, Niepełnosprawny, Grupowy (>10 osób).

---

## 3. Strategia Seedowania (DatabaseSeeder.php)

Seeder buduje pełną strukturę ZOO od zera w następującej kolejności:

1.  **Role:** Tworzenie 4 sztywnych ról.
2.  **Użytkownicy Kluczowi:**
    * Admin Systemowy (`admin@zoo.pl`)
    * Jan Manager (`manager@zoo.pl`)
    * Krzysztof Kierownik (`kierownik@zoo.pl`)
3.  **Personel:** Generowanie 10 losowych pracowników (Factory).
4.  **Magazyn Żywności (`$foodList`):** Utworzenie 17 bazowych produktów (od mięsa po banany).
5.  **Diety (`$diets`):**
    * Zdefiniowanie 10 planów żywieniowych (np. `carnivore`, `bamboo`, `exotic_birds`).
    * Przypisanie składników do diet z dokładnymi wagami.
6.  **Mapa ZOO i Populacja (`$zooMap`):**
    * Iteracja po konfiguracji wybiegów.
    * Tworzenie `Enclosure`.
    * Tworzenie/Pobieranie `Species`.
    * Tworzenie `Subspecies` (z nazwą łacińską).
    * **Zaludnianie:** Dla każdego podgatunku losowana jest liczba zwierząt (od 2 do `capacity` wybiegu) i przypisywana odpowiednia dieta.
7.  **Grafik Pracy:**
    * Generowanie grafiku na **7 dni do przodu**.
    * Dla każdego gatunku system losuje liczbę zmian (1-3) do obsadzenia.
    * Losowy pracownik jest przypisywany do dyżuru.

---

## 4. Funkcjonalności Modułowe

### A. Strefa Gościa (Publiczna)
* **Interaktywna Mapa:**
    * Frontend pobiera dane o wybiegach.
    * Kliknięcie w wybieg ładuje modal (AJAX) ze zdjęciami i listą zwierząt.
    * System ścieżek zdjęć: `photos/{slug_podgatunku}.jpg`.
* **System Biletowy:**
    * Wybór biletów i walidacja (np. minimum 10 osób dla grupy).
    * Generowanie biletu w formacie PDF (`barryvdh/laravel-dompdf`).
* **Mieszkańcy:** Lista podgatunków z paginacją i licznikiem osobników.

### B. Panel Pracownika (`/grafik`)
* Widok miesięczny kalendarza.
* Podgląd swoich dyżurów.
* Nawigacja między miesiącami.

### C. Panel Managera (`/zarzadzanie-grafikiem`)
* Widok tygodniowy z podziałem na pracowników.
* Interfejs typu "Siatka" (Pracownik x Dzień Tygodnia).
* **Edycja:** Możliwość przypisywania zmian i podgatunków (AJAX request do `saveDayData`).
* Transakcyjne zapisywanie zmian w bazie danych.

### D. Panel Supervisora (`/kierownik`)
* Zarządzanie kadrami (CRUD Pracowników).
* Blokada edycji/usuwania kont innych kierowników.

---

## 6. Do Zrobienia (ToDo)
[x] Migracja bazy danych (SQLite -> MySQL/PostgreSQL w produkcji).

[x] Logika biletów PDF.

[x] Zarządzanie grafikiem (Manager).

[ ] Implementacja panelu zarządzania specjalizacjami pracowników.

[ ] Dostępność (Accessibility) - alty dla obrazków zwierząt.
