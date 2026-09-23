# Testplan en Testrapporten - Sneakerness Rotterdam (VierkanteWielen)

## 1. Testoverzicht

De applicatie is uitvoerig getest op de User Stories met geautomatiseerde Feature tests en handmatige verificaties voor alle **C.R.U.D.** operaties.

---

## 2. Testrapporten per User Story

### User Story 1: Tickets kopen (Bezoeker)
| Testtype | Scenario | Invoer | Verwachte Uitkomst | Resultaat |
|---|---|---|---|---|
| **READ** | Happy | Pagina `/tickets` openen | Alle gereserveerde tickets worden via Stored Procedure / Joins geladen | **GESLAAGD** |
| **READ** | Unhappy | DB verbinding verbroken | Vriendelijke melding: "Er is een probleem opgetreden bij het verbinden met de database..." | **GESLAAGD** |
| **CREATE** | Happy | Naam, E-mail, Event, Prijs, Aantal=2 | Melding: "Gegevens succesvol opgeslagen." Bezoeker & ticket aangemaakt in DB | **GESLAAGD** |
| **CREATE** | Unhappy | Ongeldig e-mailadres | Validatiefout verschijnt bij e-mailadres veld, formulier wordt niet verzonden | **GESLAAGD** |
| **DELETE** | Happy | Ticket ID #1 verwijderen | Melding: "Gegevens succesvol verwijderd." Record verwijderd uit DB | **GESLAAGD** |
| **DELETE** | Unhappy | Niet-bestaand Ticket ID #99999 | Melding: "De gevraagde gegevens konden niet worden gevonden." | **GESLAAGD** |

### User Story 2: Verkoopstand huren (Verkoper)
| Testtype | Scenario | Invoer | Verwachte Uitkomst | Resultaat |
|---|---|---|---|---|
| **READ** | Happy | Pagina `/verkopers` openen | Overzicht verkopers + gekoppelde contactpersonen geladen | **GESLAAGD** |
| **CREATE** | Happy | Shopnaam, Status, Producten, Stand AA+, 2 Dagen + Contactpersoon | Verkoper, Contactpersoon & Koppeling opgeslagen met melding "Gegevens succesvol opgeslagen." | **GESLAAGD** |
| **CREATE** | Unhappy | Verplichte velden leeg laten | Server-side validatie stopt opslag, geeft meldingen per veld | **GESLAAGD** |
| **DELETE** | Happy | Verkoper ID #1 verwijderen | Verkoper en relatie succesvol verwijderd | **GESLAAGD** |

### User Story 3: Evenementenbeheer (Organisator)
| Testtype | Scenario | Invoer | Verwachte Uitkomst | Resultaat |
|---|---|---|---|---|
| **READ** | Happy | Pagina `/events` openen | Overzicht evenementen en capaciteiten getoond | **GESLAAGD** |
| **UPDATE** | Happy | Capaciteit tickets wijzigen naar 350 | Record geüpdatet met melding "Gegevens succesvol opgeslagen." | **GESLAAGD** |
| **UPDATE** | Unhappy | Negatief aantal tickets (-50) | Validatiefout: Aantal moet groter dan of gelijk aan 1 zijn | **GESLAAGD** |
| **DELETE** | Happy | Niet-actief evenement verwijderen | Evenement opgeruimd met melding "Gegevens succesvol verwijderd." | **GESLAAGD** |

---

## 3. Geautomatiseerde PHPUnit Testresultaten

De geautomatiseerde tests in `tests/Feature/SneakernessUserStoriesTest.php` zijn uitgevoerd met het volgende resultaat:

```text
PASS  Tests\Feature\ExampleTest
✓ the application returns a successful response

PASS  Tests\Feature\SneakernessUserStoriesTest
✓ home page loads with vertical sidebar
✓ unhappy scenario page not found
✓ create ticket happy scenario
✓ create ticket unhappy scenario invalid email
✓ update event happy scenario
✓ update event unhappy scenario negative values
✓ delete ticket happy scenario
✓ delete ticket unhappy scenario non existent

Tests:    10 passed (33 assertions)
Duration: 1.05s
```
