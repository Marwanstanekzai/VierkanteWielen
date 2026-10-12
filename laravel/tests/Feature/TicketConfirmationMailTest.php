<?php

namespace Tests\Feature;

use App\Mail\TicketPurchasedMail;
use App\Models\Bezoeker;
use App\Models\Evenement;
use App\Models\Prijs;
use App\Models\Ticket;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TicketConfirmationMailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * 1. Succesvolle ticketkoop: aankoop opgeslagen, e-mail verstuurd en succesmelding.
     */
    public function test_succesvolle_ticketkoop_slaat_op_en_verstuurt_bevestigingsmail(): void
    {
        Mail::fake();

        $event = Evenement::first();
        $prijs = Prijs::first();

        $response = $this->post(route('klant.tickets.store'), [
            'naam' => 'Nieuwe Klant',
            'email' => 'nieuwe.klant@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
        ]);

        $ticket = Ticket::orderBy('Id', 'desc')->first();

        $this->assertNotNull($ticket);
        $this->assertDatabaseHas('tickets', [
            'Id' => $ticket->Id,
            'AantalTickets' => 2,
            'EvenementId' => $event->Id,
            'PrijsId' => $prijs->Id,
        ]);
        $this->assertDatabaseHas('bezoekers', [
            'E-mailadres' => 'nieuwe.klant@example.com',
            'Naam' => 'Nieuwe Klant',
        ]);

        // E-mail verzonden naar het juiste e-mailadres
        Mail::assertSent(TicketPurchasedMail::class, function ($mail) use ($ticket) {
            return $mail->hasTo('nieuwe.klant@example.com') &&
                   $mail->ticket->Id === $ticket->Id;
        });

        // Redirect naar bevestiging met mailSent = true
        $response->assertRedirect(route('klant.tickets.bevestiging', ['id' => $ticket->Id]));
        $response->assertSessionHas('mailSent', true);

        // Volg redirect en controleer succesmelding
        $followResponse = $this->get(route('klant.tickets.bevestiging', ['id' => $ticket->Id]));
        $followResponse->assertStatus(200);
        $followResponse->assertSee('AANKOOP BEVESTIGD');
        $followResponse->assertSee('SNK-2026-T'.$ticket->Id);
        $followResponse->assertSee('Een bevestigingsmail is succesvol verzonden');
    }

    /**
     * 2. Inhoud van de bevestigingsmail: bevat alle vereiste klant- en ticketgegevens.
     */
    public function test_bevestigingsmail_bevat_alle_vereiste_klant_en_ticketgegevens(): void
    {
        $event = Evenement::first();
        $prijs = Prijs::first();
        $bezoeker = Bezoeker::create([
            'Naam' => 'Sophie MailTest',
            'E-mailadres' => 'sophie.mailtest@example.com',
            'Isactief' => true,
        ]);

        $ticket = Ticket::create([
            'BezoekerId' => $bezoeker->Id,
            'EvenementId' => $event->Id,
            'PrijsId' => $prijs->Id,
            'AantalTickets' => 3,
            'Datum' => $prijs->Datum ?? $event->Datum,
            'Isactief' => true,
            'Opmerking' => 'Test ticket',
        ]);

        $mailable = new TicketPurchasedMail($ticket);

        // Controleer exact onderwerp
        $mailable->assertHasSubject('Bevestiging van je Sneakerness Rotterdam-ticketaankoop');

        $rendered = $mailable->render();

        // 1. Begroeting met de naam van de klant
        $this->assertStringContainsString('Beste Sophie MailTest', $rendered);

        // 2. Bericht dat de aankoop succesvol is afgerond
        $this->assertStringContainsString('succesvol afgerond', $rendered);

        // 3. Uniek bestelnummer of ticketnummer
        $this->assertStringContainsString('SNK-2026-T'.$ticket->Id, $rendered);

        // 4. Naam van het evenement
        $this->assertStringContainsString($event->Naam, $rendered);

        // 5. Datum van het evenement
        $this->assertStringContainsString(Carbon::parse($ticket->Datum)->format('d-m-Y'), $rendered);

        // 6. Gekozen tijdslot
        $this->assertStringContainsString($prijs->Tijdslot, $rendered);

        // 7. Aantal gekochte tickets
        $this->assertStringContainsString('3', $rendered);

        // 8. Prijs per ticket
        $this->assertStringContainsString(number_format($prijs->Tarief, 2, ',', '.'), $rendered);

        // 9. Totaalbedrag (3 * tarief)
        $expectedTotal = number_format($prijs->Tarief * 3, 2, ',', '.');
        $this->assertStringContainsString($expectedTotal, $rendered);

        // 10. Het e-mailadres waarop de bestelling is geplaatst
        $this->assertStringContainsString('sophie.mailtest@example.com', $rendered);

        // 11. Afsluiting
        $this->assertStringContainsString('Bedankt voor je aankoop en tot ziens bij Sneakerness Rotterdam!', $rendered);
    }

    /**
     * 3. Mislukte aankoop (validatiefout of overboeking): verstuurt GEEN e-mail.
     */
    public function test_mislukte_aankoop_verstuurt_geen_bevestigingsmail(): void
    {
        Mail::fake();

        $event = Evenement::first();
        $prijs = Prijs::first();

        // Scenario A: Validatiefout (ongeldig e-mailadres)
        $invalidResponse = $this->post(route('klant.tickets.store'), [
            'naam' => 'Foutief Persoon',
            'email' => 'dit-is-geen-geldig-email',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
        ]);

        $invalidResponse->assertSessionHasErrors('email');
        Mail::assertNothingSent();

        // Scenario B: Overboeking (aantal tickets groter dan capaciteit)
        $event->update(['AantalTicketsPerTijdslot' => 1]);

        $overboekingResponse = $this->post(route('klant.tickets.store'), [
            'naam' => 'Overboeker',
            'email' => 'overboeker@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 5,
        ]);

        $overboekingResponse->assertSessionHas('error');
        Mail::assertNothingSent();

        // Geen tickets aangemaakt voor de overboeker
        $this->assertDatabaseMissing('bezoekers', [
            'E-mailadres' => 'overboeker@example.com',
        ]);
    }

    /**
     * 4. Niet-beschikbare mailserver: vangt fout veilig op, logt fout en toont geen technische details.
     */
    public function test_niet_beschikbare_mailserver_vangt_fout_veilig_op_en_logt(): void
    {
        Log::spy();

        // Simuleer een offline/onbereikbare mailserver door een exception op te gooien bij Mail::send
        Mail::shouldReceive('to')
            ->once()
            ->andReturnSelf();
        Mail::shouldReceive('send')
            ->once()
            ->andThrow(new Exception('Connection refused: SMTP host mail.sneakerness.nl is unreachable on port 587'));

        $event = Evenement::first();
        $prijs = Prijs::first();

        $initialTicketCount = Ticket::count();

        $response = $this->post(route('klant.tickets.store'), [
            'naam' => 'Klant Mailserver Offline',
            'email' => 'offline.klant@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
        ]);

        // 1. Ticket aankoop is wel degelijk opgeslagen in de database
        $this->assertEquals($initialTicketCount + 1, Ticket::count());
        $ticket = Ticket::orderBy('Id', 'desc')->first();
        $this->assertEquals('offline.klant@example.com', $ticket->bezoeker->{'E-mailadres'});

        // 2. Fout is veilig gelogd
        Log::shouldHaveReceived('error')
            ->withArgs(function ($message, $context = []) {
                return str_contains($message, 'Fout bij verzenden van ticket bevestigingsmail')
                    && isset($context['ticket_id']);
            });

        // 3. Klant wordt netjes geredirect zonder technische foutmelding
        $response->assertRedirect(route('klant.tickets.bevestiging', ['id' => $ticket->Id]));
        $response->assertSessionHas('mailSent', false);

        // 4. Bevestigingspagina toont GEEN technische details maar vriendelijke melding
        $confResponse = $this->withSession(['mailSent' => false])->get(route('klant.tickets.bevestiging', ['id' => $ticket->Id]));
        $confResponse->assertStatus(200);
        $confResponse->assertDontSee('Connection refused');
        $confResponse->assertDontSee('SMTP host');
        $confResponse->assertDontSee('port 587');
        $confResponse->assertDontSee('Een bevestigingsmail is succesvol verzonden');
        $confResponse->assertSee('bevestigingsmail niet verzonden');
        $confResponse->assertSee('U hoeft geen nieuwe tickets te bestellen');
    }

    /**
     * 5. Voorkomen van dubbele aankoop bij opnieuw proberen na een mailfout.
     */
    public function test_opnieuw_proberen_na_mailfout_maakt_geen_onbedoeld_dubbel_ticket_aan(): void
    {
        Mail::fake();

        $event = Evenement::first();
        $prijs = Prijs::first();

        // Eerste aankoop poging
        $this->post(route('klant.tickets.store'), [
            'naam' => 'Klant Retry',
            'email' => 'klant.retry@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 1,
        ]);

        $ticketCountAfterFirst = Ticket::whereHas('bezoeker', function ($q) {
            $q->where('E-mailadres', 'klant.retry@example.com');
        })->count();

        $this->assertEquals(1, $ticketCountAfterFirst);

        // Klant probeert opnieuw te bestellen binnen korte tijd (bijv. omdat mail niet binnenkwam of dubbelklik)
        $this->post(route('klant.tickets.store'), [
            'naam' => 'Klant Retry',
            'email' => 'klant.retry@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 1,
        ]);

        // Aantal tickets mag niet verdubbelen
        $ticketCountAfterSecond = Ticket::whereHas('bezoeker', function ($q) {
            $q->where('E-mailadres', 'klant.retry@example.com');
        })->count();

        $this->assertEquals(1, $ticketCountAfterSecond);
    }

    /**
     * 6. Voorkom dubbele e-mails bij dezelfde aankoop.
     */
    public function test_voorkom_dubbele_emails_bij_dezelfde_aankoop(): void
    {
        Mail::fake();

        $event = Evenement::first();
        $prijs = Prijs::first();

        // Eerste aankoop
        $this->post(route('klant.tickets.store'), [
            'naam' => 'Klant Duplicaat Check',
            'email' => 'duplicaat.check@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
        ]);

        Mail::assertSent(TicketPurchasedMail::class, 1);

        // Tweede aanroep voor dezelfde aankoop
        $this->post(route('klant.tickets.store'), [
            'naam' => 'Klant Duplicaat Check',
            'email' => 'duplicaat.check@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
        ]);

        // Mag niet nogmaals verzonden zijn
        Mail::assertSent(TicketPurchasedMail::class, 1);
    }

    /**
     * 7. Resend functionaliteit: klant kan bevestigingsmail opnieuw triggeren vanaf de bevestigingspagina.
     */
    public function test_bevestigingsmail_kan_opnieuw_verzonden_worden(): void
    {
        Mail::fake();

        $event = Evenement::first();
        $prijs = Prijs::first();
        $bezoeker = Bezoeker::create([
            'Naam' => 'Rick Test',
            'E-mailadres' => 'rick.test@example.com',
            'Isactief' => true,
        ]);

        $ticket = Ticket::create([
            'BezoekerId' => $bezoeker->Id,
            'EvenementId' => $event->Id,
            'PrijsId' => $prijs->Id,
            'AantalTickets' => 1,
            'Datum' => $event->Datum,
            'Isactief' => true,
        ]);

        $response = $this->post(route('klant.tickets.resend', ['id' => $ticket->Id]));

        $response->assertRedirect(route('klant.tickets.bevestiging', ['id' => $ticket->Id]));
        $response->assertSessionHas('mailSent', true);

        Mail::assertSent(TicketPurchasedMail::class, function ($mail) use ($ticket) {
            return $mail->hasTo('rick.test@example.com') && $mail->ticket->Id === $ticket->Id;
        });
    }
}
