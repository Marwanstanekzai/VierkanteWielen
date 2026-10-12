<?php

namespace Tests\Feature;

use App\Models\Contactpersoon;
use App\Models\Evenement;
use App\Models\Prijs;
use App\Models\Stand;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Verkoper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SneakernessUserStoriesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * 1. Public Customer Home Page Loads correctly.
     */
    public function test_customer_home_page_loads()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('SNEAKERNESS');
        $response->assertSee('ROTTERDAM');
        $response->assertSee('DE HEILIGE GRAILS VAN HET DECENNIUM');
        $response->assertSee('SNEAKERNESS X ARTIST EDITION');
    }

    /**
     * 2. Login Flow: Admin Login redirects to Admin Dashboard.
     */
    public function test_admin_login_redirects_to_dashboard()
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->post(route('login.post'), [
            'login' => $admin->username ?? $admin->email,
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    /**
     * 3. Login Flow: Customer Login redirects to Customer Home.
     */
    public function test_customer_login_redirects_to_home()
    {
        $klant = User::where('role', 'klant')->first();

        $response = $this->post(route('login.post'), [
            'login' => $klant->email,
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($klant);
    }

    /**
     * 4. Route Protection: Unauthenticated user is redirected when trying to access admin dashboard.
     */
    public function test_unauthenticated_user_cannot_access_dashboard()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    /**
     * 5. User Story 1: Admin Ticket Toevoegen.
     */
    public function test_admin_can_add_ticket()
    {
        $admin = User::where('role', 'admin')->first();
        $event = Evenement::first();
        $prijs = Prijs::first();

        $response = $this->actingAs($admin)->post(route('tickets.store'), [
            'naam' => 'Admin Bestelde Bezoeker',
            'email' => 'admin.bezoeker@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
            'datum' => '2026-05-25',
        ]);

        $response->assertRedirect(route('tickets.index'));
        $this->assertDatabaseHas('tickets', [
            'AantalTickets' => 2,
        ]);
    }

    /**
     * 6. User Story 2 & 3: Klant Ticket Kopen & Bevestiging.
     */
    public function test_klant_can_buy_ticket()
    {
        $event = Evenement::first();
        $prijs = Prijs::first();

        $response = $this->post(route('klant.tickets.store'), [
            'naam' => 'Klant Koper',
            'email' => 'klant.koper@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 2,
        ]);

        $ticket = Ticket::orderBy('Id', 'desc')->first();
        $response->assertRedirect(route('klant.tickets.bevestiging', ['id' => $ticket->Id]));

        $this->assertDatabaseHas('bezoekers', [
            'E-mailadres' => 'klant.koper@example.com',
        ]);
    }

    /**
     * 7. User Story 2 Unhappy Scenario: Overbooking prevents buying more than capacity.
     */
    public function test_klant_cannot_buy_tickets_over_capacity()
    {
        $event = Evenement::first();
        $prijs = Prijs::first();

        // Reduce capacity for test
        $event->update(['AantalTicketsPerTijdslot' => 2]);

        $response = $this->post(route('klant.tickets.store'), [
            'naam' => 'Overboeker',
            'email' => 'overboeker@example.com',
            'evenement_id' => $event->Id,
            'prijs_id' => $prijs->Id,
            'aantal_tickets' => 5,
        ]);

        $response->assertSessionHas('error');
    }

    /**
     * 8. User Story 4: Verkoper toevoegen (Admin).
     */
    public function test_admin_can_add_seller()
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('verkopers.store'), [
            'naam' => 'Nieuwe Shop Rotterdam',
            'speciale_status' => 'Goud Partner',
            'verkoopt_soort' => 'Limited Sneakers',
            'stand_type' => 'AA+',
            'dagen' => 2,
            'contact_naam' => 'Contact Manager',
            'contact_telefoon' => '+31611223344',
            'contact_email' => 'manager@nieuweboutique.nl',
        ]);

        $response->assertRedirect(route('verkopers.index'));
        $this->assertDatabaseHas('verkopers', [
            'Naam' => 'Nieuwe Shop Rotterdam',
        ]);
    }

    /**
     * 9. User Story 5: Contactpersoon toevoegen (Admin).
     */
    public function test_admin_can_add_contact_person()
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('contactpersonen.store'), [
            'naam' => 'Janine Contact',
            'telefoonnummer' => '+31699887766',
            'emailadres' => 'janine@contact.nl',
        ]);

        $response->assertRedirect(route('contactpersonen.index'));
        $this->assertDatabaseHas('contactpersoons', [
            'Naam' => 'Janine Contact',
        ]);
    }

    /**
     * 10. User Story 6: Contactpersoon aan verkoper koppelen (Admin).
     */
    public function test_admin_can_link_contact_to_seller()
    {
        $admin = User::where('role', 'admin')->first();
        $verkoper = Verkoper::first();
        $contact = Contactpersoon::create([
            'Naam' => 'Nieuw Los Contact',
            'Telefoonnummer' => '+31612341234',
            'E-mailadres' => 'los@contact.nl',
            'Isactief' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('contactpersonen.koppelen.store'), [
            'verkoper_id' => $verkoper->Id,
            'contactpersoon_id' => $contact->Id,
        ]);

        $response->assertRedirect(route('verkopers.index'));
        $this->assertDatabaseHas('contact_per_verkopers', [
            'VerkoperId' => $verkoper->Id,
            'ContactpersoonId' => $contact->Id,
        ]);
    }

    /**
     * 11. User Story 7: Stand toevoegen (Admin).
     */
    public function test_admin_can_add_stand()
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('stands.store'), [
            'stand_type' => 'AA',
            'prijs' => 850.00,
            'verhuurd_status' => 'Beschikbaar',
        ]);

        $response->assertRedirect(route('stands.index'));
        $this->assertDatabaseHas('stands', [
            'StandType' => 'AA',
            'Prijs' => 850.00,
        ]);
    }

    /**
     * 12. User Story 8: Stand reserveren (Klant).
     */
    public function test_klant_can_reserve_stand()
    {
        $event = Evenement::first();
        // Stand met status Beschikbaar bepalen
        $stand = Stand::where('VerhuurdStatus', 'Beschikbaar')->first();

        $response = $this->post(route('klant.stands.store'), [
            'evenement_id' => $event->Id,
            'stand_type' => $stand->StandType,
            'dagen' => 2,
            'shop_naam' => 'Reserverende Verkoper',
            'verkoopt_soort' => 'Urban Streetwear',
            'contact_naam' => 'Contactpersoon Reservering',
            'contact_telefoon' => '+31655443322',
            'contact_email' => 'reservering@shop.nl',
        ]);

        $response->assertRedirect(route('klant.stands.reserveren'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('verkopers', [
            'Naam' => 'Reserverende Verkoper',
        ]);
    }

    /**
     * 13. User Story 9: Event toevoegen (Admin).
     */
    public function test_admin_can_add_event()
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('events.store'), [
            'naam' => 'Sneakerness Rotterdam Autumn 2026',
            'datum' => '2026-10-25',
            'locatie' => 'Van Nellefabriek Rotterdam',
            'aantal_tickets_per_tijdslot' => 300,
            'beschikbare_stands' => 80,
        ]);

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('evenements', [
            'Naam' => 'Sneakerness Rotterdam Autumn 2026',
        ]);
    }
}
