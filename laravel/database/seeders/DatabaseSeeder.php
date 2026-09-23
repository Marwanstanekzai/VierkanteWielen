<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Organisator (min 5 rows)
        DB::table('organisators')->insert([
            [
                'Naam' => 'Sneakerness HQ Rotterdam',
                'Gebruikersnaam' => 'admin_rotterdam',
                'Wachtwoord' => Hash::make('Secret123!'),
                'Isactief' => true,
                'Opmerking' => 'Hoofdorganisator Van Nellefabriek',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Marwan Stanekzai',
                'Gebruikersnaam' => 'marwan_admin',
                'Wachtwoord' => Hash::make('Secret123!'),
                'Isactief' => true,
                'Opmerking' => 'Event Manager Sneakerness',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Event Crew Coordinator',
                'Gebruikersnaam' => 'crew_lead',
                'Wachtwoord' => Hash::make('Secret123!'),
                'Isactief' => true,
                'Opmerking' => 'Vrijwilligers & Logistiek',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Ticketing Admin',
                'Gebruikersnaam' => 'ticket_admin',
                'Wachtwoord' => Hash::make('Secret123!'),
                'Isactief' => true,
                'Opmerking' => 'Beheer kassa en toegangscontrole',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Stand Manager',
                'Gebruikersnaam' => 'stand_admin',
                'Wachtwoord' => Hash::make('Secret123!'),
                'Isactief' => true,
                'Opmerking' => 'Verkoper en stand toewijzing',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);

        // 2. Bezoeker (min 5 rows)
        DB::table('bezoekers')->insert([
            [
                'Naam' => 'Jan de Vries',
                'E-mailadres' => 'jan.devries@example.com',
                'Isactief' => true,
                'Opmerking' => 'Regular VIP Ticket koper',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Sophie Jansen',
                'E-mailadres' => 'sophie.jansen@example.com',
                'Isactief' => true,
                'Opmerking' => 'Sneaker collector Nike Dunks',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Lars Bakken',
                'E-mailadres' => 'lars.bakken@example.com',
                'Isactief' => true,
                'Opmerking' => 'Bezoeker dag 1 en 2',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Emma Mulder',
                'E-mailadres' => 'emma.mulder@example.com',
                'Isactief' => true,
                'Opmerking' => 'Streetwear enthusiast',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Daan Visser',
                'E-mailadres' => 'daan.visser@example.com',
                'Isactief' => true,
                'Opmerking' => 'Afgehaald bij kassa',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);

        // 3. Evenement (min 5 rows)
        DB::table('evenements')->insert([
            [
                'Naam' => 'Sneakerness Rotterdam 2026',
                'Datum' => '2026-05-25',
                'Locatie' => 'Van Nellefabriek Rotterdam',
                'AantalTicketsPerTijdslot' => 250,
                'BeschikbareStands' => 100,
                'Isactief' => true,
                'Opmerking' => 'Hoofdevenement Meieditie Dag 1',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Sneakerness Rotterdam 2026 - Dag 2',
                'Datum' => '2026-05-26',
                'Locatie' => 'Van Nellefabriek Rotterdam',
                'AantalTicketsPerTijdslot' => 250,
                'BeschikbareStands' => 100,
                'Isactief' => true,
                'Opmerking' => 'Hoofdevenement Meieditie Dag 2',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Sneakerness VIP Night Pre-party',
                'Datum' => '2026-05-24',
                'Locatie' => 'Van Nellefabriek Rotterdam VIP Lounge',
                'AantalTicketsPerTijdslot' => 50,
                'BeschikbareStands' => 10,
                'Isactief' => true,
                'Opmerking' => 'Exclusieve pre-sale en meet & greet',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Sneakerness Amsterdam Winter Edition',
                'Datum' => '2026-11-15',
                'Locatie' => 'Kromhouthal Amsterdam',
                'AantalTicketsPerTijdslot' => 200,
                'BeschikbareStands' => 80,
                'Isactief' => true,
                'Opmerking' => 'Wintereditie voorbereiding',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Sneakerness Paris Summer Edition',
                'Datum' => '2026-09-10',
                'Locatie' => 'Grande Halle de la Villette',
                'AantalTicketsPerTijdslot' => 300,
                'BeschikbareStands' => 120,
                'Isactief' => true,
                'Opmerking' => 'Internationale tourstop',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);

        // 4. Prijs (min 5 rows)
        DB::table('prijs')->insert([
            [
                'Datum' => '2026-05-25',
                'Tijdslot' => '10:00 - 12:00 Early Bird',
                'Tarief' => 25.00,
                'Isactief' => true,
                'Opmerking' => 'Vroege toegang dag 1',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Datum' => '2026-05-25',
                'Tijdslot' => '12:00 - 15:00 Regular',
                'Tarief' => 18.50,
                'Isactief' => true,
                'Opmerking' => 'Middag tijdslot dag 1',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Datum' => '2026-05-25',
                'Tijdslot' => '15:00 - 18:00 Late Entry',
                'Tarief' => 15.00,
                'Isactief' => true,
                'Opmerking' => 'Namiddag tijdslot dag 1',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Datum' => '2026-05-26',
                'Tijdslot' => '10:00 - 13:00 Sunday Morning',
                'Tarief' => 20.00,
                'Isactief' => true,
                'Opmerking' => 'Ochtend tijdslot dag 2',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Datum' => '2026-05-26',
                'Tijdslot' => '13:00 - 17:00 Sunday Afternoon',
                'Tarief' => 17.50,
                'Isactief' => true,
                'Opmerking' => 'Middag tijdslot dag 2',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);

        // 5. Verkoper (min 5 rows)
        DB::table('verkopers')->insert([
            [
                'Naam' => 'Kicks & Collectors HQ',
                'SpecialeStatus' => 'Goud Partner',
                'VerkooptSoort' => 'Exclusieve Nike Dunk SB Retros & Samples',
                'StandType' => 'AA+',
                'Dagen' => 2,
                'Logo' => 'kicks_hq_logo.png',
                'Isactief' => true,
                'Opmerking' => 'Grote internationale reseller uit London',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Grail Store Rotterdam',
                'SpecialeStatus' => 'Zilver Partner',
                'VerkooptSoort' => 'Deadstock Jordans & Vintage Apparel',
                'StandType' => 'AA',
                'Dagen' => 2,
                'Logo' => 'grail_rotterdam.png',
                'Isactief' => true,
                'Opmerking' => 'Lokale sneaker boutique centrum Rotterdam',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'SoleSupplier Amsterdam',
                'SpecialeStatus' => 'Brons Partner',
                'VerkooptSoort' => 'Yeezy, Travis Scott & Rare Collaborations',
                'StandType' => 'AA',
                'Dagen' => 1,
                'Logo' => 'solesupplier.png',
                'Isactief' => true,
                'Opmerking' => 'Alleen aanwezig op zaterdag 25 Mei',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Streetwear Vintage NL',
                'SpecialeStatus' => 'Normaal',
                'VerkooptSoort' => 'Vintage Supreme, Stussy & Palace Clothing',
                'StandType' => 'A',
                'Dagen' => 2,
                'Logo' => 'vintage_nl.png',
                'Isactief' => true,
                'Opmerking' => 'Specialist in 90s streetwear',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Custom Kicks Lab',
                'SpecialeStatus' => 'Artist Edition',
                'VerkooptSoort' => 'Handpainted Custom Sneakers & Art',
                'StandType' => 'A',
                'Dagen' => 2,
                'Logo' => 'custom_lab.png',
                'Isactief' => true,
                'Opmerking' => 'Live sneaker customization showcase',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);

        // 6. Ticket (min 5 rows)
        DB::table('tickets')->insert([
            [
                'BezoekerId' => 1,
                'EvenementId' => 1,
                'PrijsId' => 1,
                'AantalTickets' => 2,
                'Datum' => '2026-05-25',
                'Isactief' => true,
                'Opmerking' => 'Reservering via website',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'BezoekerId' => 2,
                'EvenementId' => 1,
                'PrijsId' => 2,
                'AantalTickets' => 1,
                'Datum' => '2026-05-25',
                'Isactief' => true,
                'Opmerking' => 'Betaling ontvangen',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'BezoekerId' => 3,
                'EvenementId' => 2,
                'PrijsId' => 4,
                'AantalTickets' => 3,
                'Datum' => '2026-05-26',
                'Isactief' => true,
                'Opmerking' => 'Groepsboeking dag 2',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'BezoekerId' => 4,
                'EvenementId' => 1,
                'PrijsId' => 3,
                'AantalTickets' => 1,
                'Datum' => '2026-05-25',
                'Isactief' => true,
                'Opmerking' => 'Late entry ticket',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'BezoekerId' => 5,
                'EvenementId' => 2,
                'PrijsId' => 5,
                'AantalTickets' => 2,
                'Datum' => '2026-05-26',
                'Isactief' => true,
                'Opmerking' => 'Afgehaald bij registratiedesk',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);

        // 7. Stand (min 5 rows)
        DB::table('stands')->insert([
            [
                'VerkoperId' => 1,
                'StandType' => 'AA+',
                'Prijs' => 1250.00,
                'VerhuurdStatus' => 'Verhuurd',
                'Isactief' => true,
                'Opmerking' => 'Stand A-01 bij hoofdingang',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'VerkoperId' => 2,
                'StandType' => 'AA',
                'Prijs' => 850.00,
                'VerhuurdStatus' => 'Verhuurd',
                'Isactief' => true,
                'Opmerking' => 'Stand B-12 in de centrale hal',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'VerkoperId' => 3,
                'StandType' => 'AA',
                'Prijs' => 850.00,
                'VerhuurdStatus' => 'Verhuurd',
                'Isactief' => true,
                'Opmerking' => 'Stand B-14 centrale hal',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'VerkoperId' => 4,
                'StandType' => 'A',
                'Prijs' => 550.00,
                'VerhuurdStatus' => 'Verhuurd',
                'Isactief' => true,
                'Opmerking' => 'Stand C-05 vintage zone',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'VerkoperId' => 5,
                'StandType' => 'A',
                'Prijs' => 550.00,
                'VerhuurdStatus' => 'Beschikbaar',
                'Isactief' => true,
                'Opmerking' => 'Stand C-06 artist zone',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);

        // 8. Contactpersoon (min 5 rows)
        DB::table('contactpersoons')->insert([
            [
                'Naam' => 'Michael Johnson',
                'Telefoonnummer' => '+31612345678',
                'E-mailadres' => 'm.johnson@kicks-hq.com',
                'Isactief' => true,
                'Opmerking' => 'Contactpersoon Kicks & Collectors',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Lisa van den Berg',
                'Telefoonnummer' => '+31687654321',
                'E-mailadres' => 'lisa@grailstore.nl',
                'Isactief' => true,
                'Opmerking' => 'Filiaalmanager Grail Store Rotterdam',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Kevin Smit',
                'Telefoonnummer' => '+31623456789',
                'E-mailadres' => 'kevin@solesupplier.nl',
                'Isactief' => true,
                'Opmerking' => 'Eigenaar SoleSupplier',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Chantal Blom',
                'Telefoonnummer' => '+31634567890',
                'E-mailadres' => 'chantal@vintagenl.com',
                'Isactief' => true,
                'Opmerking' => 'Sales Representative Vintage NL',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'Naam' => 'Rick de Jong',
                'Telefoonnummer' => '+31645678901',
                'E-mailadres' => 'rick@customkicks.nl',
                'Isactief' => true,
                'Opmerking' => 'Lead Artist Custom Kicks Lab',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);

        // 9. ContactPerVerkoper (min 5 rows)
        DB::table('contact_per_verkopers')->insert([
            [
                'VerkoperId' => 1,
                'ContactpersoonId' => 1,
                'Isactief' => true,
                'Opmerking' => 'Primair contact Kicks & Collectors',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'VerkoperId' => 2,
                'ContactpersoonId' => 2,
                'Isactief' => true,
                'Opmerking' => 'Primair contact Grail Store Rotterdam',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'VerkoperId' => 3,
                'ContactpersoonId' => 3,
                'Isactief' => true,
                'Opmerking' => 'Primair contact SoleSupplier',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'VerkoperId' => 4,
                'ContactpersoonId' => 4,
                'Isactief' => true,
                'Opmerking' => 'Primair contact Streetwear Vintage NL',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
            [
                'VerkoperId' => 5,
                'ContactpersoonId' => 5,
                'Isactief' => true,
                'Opmerking' => 'Primair contact Custom Kicks Lab',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ],
        ]);
    }
}
