<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run Stored Procedures creation on MySQL or MariaDB connection driver
        $driver = DB::getDriverName();
        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::unprepared("
                DROP PROCEDURE IF EXISTS sp_GetTicketsWithDetails;
                CREATE PROCEDURE sp_GetTicketsWithDetails()
                BEGIN
                    SELECT 
                        t.Id AS TicketId,
                        b.Naam AS BezoekerNaam,
                        b.`E-mailadres` AS BezoekerEmail,
                        e.Naam AS EvenementNaam,
                        e.Locatie AS EvenementLocatie,
                        p.Tijdslot AS Tijdslot,
                        p.Tarief AS Tarief,
                        t.AantalTickets,
                        t.Datum,
                        t.Isactief
                    FROM tickets t
                    INNER JOIN bezoekers b ON t.BezoekerId = b.Id
                    INNER JOIN evenements e ON t.EvenementId = e.Id
                    LEFT JOIN prijs p ON t.PrijsId = p.Id
                    WHERE t.Isactief = 1
                    ORDER BY t.Id DESC;
                END;
            ");

            DB::unprepared("
                DROP PROCEDURE IF EXISTS sp_GetStandsWithVerkopers;
                CREATE PROCEDURE sp_GetStandsWithVerkopers()
                BEGIN
                    SELECT 
                        s.Id AS StandId,
                        s.StandType,
                        s.Prijs,
                        s.VerhuurdStatus,
                        v.Naam AS VerkoperNaam,
                        v.SpecialeStatus,
                        v.VerkooptSoort,
                        s.Isactief
                    FROM stands s
                    LEFT JOIN verkopers v ON s.VerkoperId = v.Id
                    WHERE s.Isactief = 1
                    ORDER BY s.Id ASC;
                END;
            ");

            DB::unprepared("
                DROP PROCEDURE IF EXISTS sp_GetContactenPerVerkoper;
                CREATE PROCEDURE sp_GetContactenPerVerkoper()
                BEGIN
                    SELECT 
                        cpv.Id AS RelatieId,
                        v.Naam AS VerkoperNaam,
                        v.StandType,
                        cp.Naam AS ContactNaam,
                        cp.Telefoonnummer,
                        cp.`E-mailadres` AS ContactEmail,
                        cpv.Isactief
                    FROM contact_per_verkopers cpv
                    INNER JOIN verkopers v ON cpv.VerkoperId = v.Id
                    INNER JOIN contactpersoons cp ON cpv.ContactpersoonId = cp.Id
                    WHERE cpv.Isactief = 1
                    ORDER BY v.Naam ASC;
                END;
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::unprepared("DROP PROCEDURE IF EXISTS sp_GetTicketsWithDetails;");
            DB::unprepared("DROP PROCEDURE IF EXISTS sp_GetStandsWithVerkopers;");
            DB::unprepared("DROP PROCEDURE IF EXISTS sp_GetContactenPerVerkoper;");
        }
    }
};
