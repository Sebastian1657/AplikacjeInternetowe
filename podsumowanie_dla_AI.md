# 🦁 Projekt: System Zarządzania ZOO (Laravel)

**Data ostatniej aktualizacji:** 17.01.2026
**Repozytorium:** `sebastian1657/aplikacjeinternetowe`
**Branch:** `main` (folder: `Miler_Sebastian_21277_Aplikacje_Internetowe`)

---

## 1. Główne Założenia Projektowe

System opiera się na zasadzie: **"Deterministyczna Struktura, Losowe Instancje"**.
Oznacza to, że infrastruktura (wybiegi), biologia (gatunki) i zasady żywienia (diety) są stałe i logiczne, natomiast konkretne zwierzęta (imiona, wiek) oraz grafik pracy są generowane losowo.

### A. Hierarchia Biologiczna
1.  **Species (Gatunek):** Nadrzędna kategoria (np. *Kotowate*, *Słoniowate*).
2.  **Subspecies (Podgatunek):** Konkretny typ zwierzęcia (np. *Tygrys Syberyjski*, *Słoń Afrykański*).
    * Posiada nazwę polską (`common_name`) i łacińską (`scientific_name`).
3.  **Animal (Zwierzę):** Konkretny osobnik (np. samica "Berta", ur. 2015).

### B. Infrastruktura (Enclosures)
Wybiegi są ściśle zdefiniowane i przypisane do konkretnych gatunków w `DatabaseSeeder`.
Typy wybiegów (enum/string):
* `open_air` (Słonie, Żyrafy, Niedźwiedzie, Pandy)
* `indoor_cage` (Małpy, Surykatki)
* `aviary` (Papugi, Tukany, Gołębie)
* `aquarium` (Ryby, Rafa)
* `pool_enclosure` (Foki, Nerpy)
* `cooled_enclosure` (Pingwiny)

### C. System Żywienia (Strict Diet System)
* **Food (Produkt):** Konkretny produkt (np. *Wołowina*, *Siano*) z przypisaną jednostką (`kg`, `szt`, `g`).
* **DietPlan (Dieta):** Nazwany plan żywieniowy (np. *Dieta Mięsna - standard*).
* **Relacja:** `DietPlan` <-> `Food` (Many-to-Many).
* **Kluczowe:** Tabela łącząca `diet_food` zawiera kolumnę **`amount` (decimal 6,2)**, określającą dokładną ilość produktu w danej diecie.

---

## 2. Struktura Bazy Danych i Modele

### Kluczowe Modele i Wymagania
1.  **`User`**:
    * Pola: `name`, `last_name`, `email`, `password`, `role_id`.
    * Wymaga: `role_id` i `last_name` w tablicy `$fillable`.
2.  **`Animal`**:
    * Relacje: `belongsTo` -> `DietPlan`, `Enclosure`, `Subspecies`.
3.  **`Food`**:
    * Tabela: `foods` (domyślna w Laravelu).
    * **Uwaga:** Należy upewnić się, że model nie ma błędnego wpisu `protected $table = 'food';`.
4.  **`Care`**:
    * Grafik pracy.
    * Wymaga: `use HasFactory;` w modelu, aby działał Seeder.
    * Pola: `user_id`, `animal_id`, `care_date`, `shift` (int: 1, 2, 3).

### Role (RBAC)
Role są tworzone na sztywno z ID:
1.  `admin`
2.  `manager`
3.  `supervisor` (Kierownik)
4.  `employee` (Pracownik)

---

## 3. Strategia Seedowania (DatabaseSeeder.php)

To serce projektu. Seeder działa w trybie "Create & Attach", a nie "Random Factory" dla struktur logicznych.

**Kolejność wykonywania:**
1.  **Role:** `firstOrCreate` (Admin, Manager, Supervisor, Employee).
2.  **Użytkownicy:** Konta testowe na sztywno + 10 losowych pracowników.
3.  **Jedzenie (`$foodList`):**
    * Tworzone z tablicy asocjacyjnej (Nazwa => Jednostka).
    * Obiekty zapisywane są do tablicy `$foods` w pamięci, aby później pobierać ich ID.
4.  **Diety (`$dietsConfig`):**
    * Tworzone `DietPlan`.
    * Składniki przypisywane przez `attach()` z użyciem ID z tablicy `$foods`.
    * Gotowe diety zapisywane do `$dietModels`.
5.  **Mapa ZOO (`$zooMap`):**
    * Pętla iterująca po konfiguracji ZOO.
    * Tworzy: `Enclosure`, `Species`.
    * Dla każdego podgatunku: tworzy `Subspecies` (z nazwą łacińską).
    * **Generuje zwierzęta:** Używa `Animal::factory()` **tylko** do cech fizycznych (imię, płeć, wiek).
    * **Przypisanie:** ID wybiegu, podgatunku i diety jest narzucane "na sztywno" z konfiguracji mapy.
6.  **Grafik (Care):** Losowe przydzielenie pracowników do istniejących zwierząt.

---

## 4. Stan Fabryk (Factories)

* **`AnimalFactory.php`**: **CZYSTA.** Generuje tylko `name`, `sex`, `birth_date`. Nie może zawierać wywołań innych fabryk (np. `Subspecies::factory()`).
* **`CareFactory.php`**: Generuje `care_date` i `shift`.
* **`UserFactory.php`**: Standardowa, uwzględnia `last_name`.
* **`FoodFactory.php`**: Istnieje pomocniczo.
* **USUNIĘTE/NIEUŻYWANE:** `SpeciesFactory`, `SubspeciesFactory`, `EnclosureFactory`, `DietPlanFactory` (zastąpione logiką w Seederze).

---

## 5. Rozwiązane Problemy (Troubleshooting)

1.  **Błąd `no such table: food`**: Model `Food` próbował łączyć się z tabelą w liczbie pojedynczej. Poprawiono na domyślną konwencję Laravela (`foods`).
2.  **Ilości jedzenia (Integer vs Decimal)**: Migracja `diet_food` została zaktualizowana, aby kolumna `amount` była typu `decimal(6,2)`. Pozwala to na podawanie ułamkowych wartości (np. 0.5 kg).
3.  **Składnia Seedera**: Naprawiono błędy z "wiszącymi przecinkami" i błędnym odwoływaniem się do tablicy konfiguracyjnej zamiast do modeli Eloquent.
4.  **Brak Traitów**: Dodano `HasFactory` do modelu `Care`.

---

## 6. Komendy Uruchomieniowe

Aby zresetować bazę i wgrać pełną strukturę ZOO:

```bash
php artisan migrate:fresh --seed