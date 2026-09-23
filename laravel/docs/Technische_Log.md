# Technische Log - Sneakerness Rotterdam (VierkanteWielen)

Dit technische logboek geeft inzicht in de architectuurbeslissingen, Stored Procedure keuzes, Try/Catch afhandeling en beveiligingsmaatregelen van de Laravel-applicatie.

---

## 1. Architectuur & MVC Structuur
- **Framework**: Laravel 11.x (PHP 8.2+)
- **Database Engine**: MySQL / MariaDB (InnoDB engine met 3NF normalisatie).
- **Layout & CSS**: Blade templating met een **verticale sidebar** aan de linkerkant (Desktop) en responsive flex/grid layouts voor mobiele schermen.
- **Routing**: `routes/web.php` gekoppeld aan specifieke resource controllers.

---

## 2. Stored Procedures & Joins
Om te voldoen aan de eisen rond SQL Stored Procedures en Relaties zijn de volgende Stored Procedures en Joins gerealiseerd:

1. **`sp_GetTicketsWithDetails`**:
   - Voert een 4-tabel `INNER JOIN` / `LEFT JOIN` uit tussen `tickets`, `bezoekers`, `evenements` en `prijs`.
   - Wordt rechtstreeks aangeroepen in `TicketController::index()`.
2. **`sp_GetStandsWithVerkopers`**:
   - Voert een `LEFT JOIN` uit tussen `stands` en `verkopers`.
   - Wordt rechtstreeks aangeroepen in `StandController::index()`.
3. **`sp_GetContactenPerVerkoper`**:
   - Voert een `INNER JOIN` uit tussen `contact_per_verkopers`, `verkopers` en `contactpersoons`.
   - Wordt rechtstreeks aangeroepen in `VerkoperController::index()`.

---

## 3. Foutafhandeling & Try/Catch Strategie
Conform de eisen voor Happy en Unhappy Scenarios:
- Alle database interacties zijn omsloten door `try { ... } catch (Throwable $e) { ... }` blokken.
- **Happy Scenario**: Na een geslaagde opslag, wijziging of verwijdering wordt een duidelijke melding gegeven (bijv. `"Gegevens succesvol opgeslagen."`, `"Gegevens succesvol verwijderd."`).
- **Unhappy Scenario**: Als er een uitzondering optreedt (zoals database onbereikbaar of foutieve data):
  - De fout wordt opgevangen.
  - Een schone, gebruiksvriendelijke melding wordt getoond (bijv. `"Er is een probleem opgetreden bij het verbinden met de database. Probeer het later opnieuw."` of `"De gegevens konden niet worden opgeslagen."`).
  - Gevoelige technische stacktraces, SQL error-codes of server paden worden **nooit** getoond aan de eindgebruiker.

---

## 4. Validatie & Beveiliging
- **Client-side validatie**: HTML5 `required`, `type="email"`, `min`, `max` en JavaScript submit-checks.
- **Server-side validatie**: Laravel `$request->validate([...])` op alle POST/PUT formulieren.
- **Database validatie**: Datatype constraints (`DECIMAL`, `DATE`, `INTEGER`), Foreign Keys met `ON DELETE CASCADE` of `SET NULL` en NOT NULL checks.
- **Security**:
  - CSRF-beveiliging via `@csrf` tokens in alle Blade formulieren.
  - SQL Injection preventie via Eloquent Prepared Statements en Parameterized Stored Procedures.
  - Wachtwoorden van Organisatoren gehasht via `Hash::make()` (BCrypt).
