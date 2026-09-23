<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organisators', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Naam');
            $table->string('Gebruikersnaam')->unique();
            $table->string('Wachtwoord');
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('bezoekers', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Naam');
            $table->string('E-mailadres');
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('evenements', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Naam');
            $table->date('Datum');
            $table->string('Locatie');
            $table->integer('AantalTicketsPerTijdslot')->default(100);
            $table->integer('BeschikbareStands')->default(50);
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('prijs', function (Blueprint $table) {
            $table->id('Id');
            $table->date('Datum');
            $table->string('Tijdslot');
            $table->decimal('Tarief', 8, 2);
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('BezoekerId')->constrained('bezoekers', 'Id')->onDelete('cascade');
            $table->foreignId('EvenementId')->constrained('evenements', 'Id')->onDelete('cascade');
            $table->foreignId('PrijsId')->nullable()->constrained('prijs', 'Id')->onDelete('set null');
            $table->integer('AantalTickets')->default(1);
            $table->date('Datum');
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('verkopers', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Naam');
            $table->string('SpecialeStatus')->default('Normaal');
            $table->string('VerkooptSoort');
            $table->string('StandType');
            $table->integer('Dagen')->default(1);
            $table->string('Logo')->nullable();
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('stands', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('VerkoperId')->nullable()->constrained('verkopers', 'Id')->onDelete('set null');
            $table->string('StandType');
            $table->decimal('Prijs', 8, 2);
            $table->string('VerhuurdStatus')->default('Beschikbaar');
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('contactpersoons', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Naam');
            $table->string('Telefoonnummer');
            $table->string('E-mailadres');
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('contact_per_verkopers', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('VerkoperId')->constrained('verkopers', 'Id')->onDelete('cascade');
            $table->foreignId('ContactpersoonId')->constrained('contactpersoons', 'Id')->onDelete('cascade');
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_per_verkopers');
        Schema::dropIfExists('contactpersoons');
        Schema::dropIfExists('stands');
        Schema::dropIfExists('verkopers');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('prijs');
        Schema::dropIfExists('evenements');
        Schema::dropIfExists('bezoekers');
        Schema::dropIfExists('organisators');
    }
};
