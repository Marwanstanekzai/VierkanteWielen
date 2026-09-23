<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Evenement;
use App\Models\Prijs;
use App\Models\Bezoeker;
use App\Models\Ticket;
use App\Models\Verkoper;
use App\Models\Stand;
use App\Models\Contactpersoon;

class SneakernessUserStoriesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * READ: Happy Scenario - Homepagina en Sidebar laden succesvol.
     */
    public function test_home_page_loads_with_vertical_sidebar()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('SNEAKERNESS');
        $response->assertSee('Dashboard');
        $response->assertSee('Tickets');
        $response->assertSee('Verkopers');
        $response->assertSee('Contactpersonen');
        $response->assertSee('Stands');
        $response->assertSee('Events');
    }

    /**
     * READ: Unhappy Scenario - Foutmelding op niet-bestaande pagina.
     */
    public function test_unhappy_scenario_page_not_found()
    {
        $response = $this->get('/niet-bestaande-pagina');

        $response->assertStatus(404);
    }

    /**
     * CREATE: Happy Scenario - Ticket Kopen.
     */
    public function test_create_ticket_happy_scenario()
    {
        $event = Evenement::first();
        $prijs = Prijs::first();

        $response = $this->post(route('tickets.store'), [
            'naam' => 'Test Bezoeker',
            'email' => 'test.bezoeker@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
            'datum' => '2026-05-25',
        ]);

        $response->assertRedirect(route('tickets.index'));
        $response->assertSessionHas('success', 'Gegevens succesvol opgeslagen.');

        $this->assertDatabaseHas('bezoekers', [
            'E-mailadres' => 'test.bezoeker@example.com',
        ]);
    }

    /**
     * CREATE: Unhappy Scenario - Ticket Kopen met ongeldige invoer.
     */
    public function test_create_ticket_unhappy_scenario_invalid_email()
    {
        $event = Evenement::first();
        $prijs = Prijs::first();

        $response = $this->from(route('tickets.create'))->post(route('tickets.store'), [
            'naam' => 'Test Bezoeker',
            'email' => 'ongeldig-email-formaat',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
            'datum' => '2026-05-25',
        ]);

        $response->assertRedirect(route('tickets.create'));
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * UPDATE: Happy Scenario - Event capaciteit en stands bijwerken.
     */
    public function test_update_event_happy_scenario()
    {
        $event = Evenement::first();

        $response = $this->put(route('events.update', $event->Id), [
            'aantal_tickets_per_tijdslot' => 350,
            'beschikbare_stands' => 120,
        ]);

        $response->assertRedirect(route('events.index'));
        $response->assertSessionHas('success', 'Gegevens succesvol opgeslagen.');

        $this->assertDatabaseHas('evenements', [
            'Id' => $event->Id,
            'AantalTicketsPerTijdslot' => 350,
            'BeschikbareStands' => 120,
        ]);
    }

    /**
     * UPDATE: Unhappy Scenario - Event bijwerken met negatieve waarden.
     */
    public function test_update_event_unhappy_scenario_negative_values()
    {
        $event = Evenement::first();

        $response = $this->put(route('events.update', $event->Id), [
            'aantal_tickets_per_tijdslot' => -10,
            'beschikbare_stands' => 0,
        ]);

        $response->assertSessionHasErrors(['aantal_tickets_per_tijdslot', 'beschikbare_stands']);
    }

    /**
     * DELETE: Happy Scenario - Ticket verwijderen.
     */
    public function test_delete_ticket_happy_scenario()
    {
        $ticket = Ticket::first();

        $response = $this->delete(route('tickets.destroy', $ticket->Id));

        $response->assertRedirect(route('tickets.index'));
        $response->assertSessionHas('success', 'Gegevens succesvol verwijderd.');

        $this->assertDatabaseMissing('tickets', [
            'Id' => $ticket->Id,
        ]);
    }

    /**
     * DELETE: Unhappy Scenario - Verwijderen niet-bestaande entiteit.
     */
    public function test_delete_ticket_unhappy_scenario_non_existent()
    {
        $response = $this->delete(route('tickets.destroy', 99999));

        $response->assertRedirect(route('tickets.index'));
        $response->assertSessionHas('error', 'De gevraagde gegevens konden niet worden gevonden.');
    }
}
