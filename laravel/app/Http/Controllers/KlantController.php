<?php

namespace App\Http\Controllers;

use App\Mail\TicketPurchasedMail;
use App\Models\Bezoeker;
use App\Models\Contactpersoon;
use App\Models\ContactPerVerkoper;
use App\Models\Evenement;
use App\Models\Prijs;
use App\Models\Stand;
use App\Models\Ticket;
use App\Models\Verkoper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class KlantController extends Controller
{
    /**
     * Programma overzichtspagina voor klanten.
     */
    public function programma()
    {
        try {
            $evenementen = Evenement::where('Isactief', true)->orderBy('Datum', 'asc')->get();

            return view('klant.programma', compact('evenementen'));
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Praktische informatie pagina.
     */
    public function praktischeInfo()
    {
        return view('klant.praktische_info');
    }

    /**
     * Toon ticket koopformulier voor klanten.
     */
    public function showBuyTicketForm(Request $request)
    {
        try {
            $evenementen = Evenement::where('Isactief', true)->get();
            $prijzen = Prijs::where('Isactief', true)->get();
            $selectedEvenementId = $request->query('evenement_id');

            return view('klant.tickets.kopen', compact('evenementen', 'prijzen', 'selectedEvenementId'));
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Verwerk ticket aankoop door klant (User Story 2 & 3).
     */
    public function storeTicketPurchase(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'evenement_id' => 'required|exists:evenements,Id',
            'prijs_id' => 'required|exists:prijs,Id',
            'aantal_tickets' => 'required|integer|min:1|max:10',
        ], [
            'naam.required' => 'Vul alstublieft uw naam in.',
            'email.required' => 'Vul alstublieft een geldig e-mailadres in.',
            'email.email' => 'Vul alstublieft een geldig e-mailadres in.',
            'evenement_id.required' => 'Selecteer een evenement.',
            'prijs_id.required' => 'Selecteer een tijdslot.',
            'aantal_tickets.required' => 'Selecteer het aantal tickets.',
            'aantal_tickets.min' => 'Minimaal 1 ticket verplicht.',
        ]);

        try {
            $evenement = Evenement::findOrFail($validated['evenement_id']);
            $prijs = Prijs::findOrFail($validated['prijs_id']);

            // Server-side controle van beschikbaarheid en capaciteit
            $verkochteTickets = Ticket::where('EvenementId', $evenement->Id)
                ->where('PrijsId', $prijs->Id)
                ->where('Isactief', true)
                ->sum('AantalTickets');

            $beschikbaar = $evenement->AantalTicketsPerTijdslot - $verkochteTickets;

            if ($validated['aantal_tickets'] > $beschikbaar) {
                $foutmelding = $beschikbaar > 0
                    ? "Er zijn voor dit tijdslot nog maar {$beschikbaar} ticket(s) beschikbaar."
                    : 'Dit tijdslot is helaas volledig uitverkocht.';

                return redirect()->back()->withInput()->with('error', $foutmelding);
            }

            DB::beginTransaction();

            // Zoek of maak bezoeker
            $bezoeker = Bezoeker::firstOrCreate(
                ['E-mailadres' => $validated['email']],
                ['Naam' => $validated['naam'], 'Isactief' => true, 'Opmerking' => 'Aangeschaft via Klantwebsite']
            );

            // Voorkom dubbele aankoop bij opnieuw proberen of snelle dubbelklik
            $existingTicket = Ticket::where('BezoekerId', $bezoeker->Id)
                ->where('EvenementId', $evenement->Id)
                ->where('PrijsId', $prijs->Id)
                ->where('AantalTickets', $validated['aantal_tickets'])
                ->where('Datumaangemaakt', '>=', now()->subMinutes(2))
                ->latest('Id')
                ->first();

            if ($existingTicket) {
                $ticket = $existingTicket;
            } else {
                $ticket = Ticket::create([
                    'BezoekerId' => $bezoeker->Id,
                    'EvenementId' => $evenement->Id,
                    'PrijsId' => $prijs->Id,
                    'AantalTickets' => $validated['aantal_tickets'],
                    'Datum' => $prijs->Datum ?? $evenement->Datum,
                    'Isactief' => true,
                    'Opmerking' => 'Online aankoop via klantwebsite',
                ]);
            }

            DB::commit();

            // Verstuur bevestigingsmail (voorkom dubbele e-mails bij dezelfde aankoop)
            $mailSent = false;
            $alreadySent = str_contains($ticket->Opmerking ?? '', 'Bevestigingsmail verzonden');

            if ($alreadySent) {
                $mailSent = true;
            } else {
                try {
                    Mail::to($bezoeker->{'E-mailadres'})->send(new TicketPurchasedMail($ticket));
                    $ticket->update([
                        'Opmerking' => trim(($ticket->Opmerking ?? '').' | Bevestigingsmail verzonden'),
                    ]);
                    $mailSent = true;
                } catch (Throwable $mailError) {
                    // Log e-mailfout veilig met context zonder technische details aan de klant te tonen
                    Log::error('Fout bij verzenden van ticket bevestigingsmail: '.$mailError->getMessage(), [
                        'ticket_id' => $ticket->Id,
                        'email' => $bezoeker->{'E-mailadres'},
                        'exception' => $mailError,
                    ]);
                    $mailSent = false;
                }
            }

            return redirect()->route('klant.tickets.bevestiging', ['id' => $ticket->Id])
                ->with('mailSent', $mailSent);

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Fout bij verwerken van ticketaankoop in database: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Toon aankoopbevestiging (User Story 3).
     */
    public function showTicketConfirmation($id)
    {
        try {
            $ticket = Ticket::with(['bezoeker', 'evenement', 'prijs'])->findOrFail($id);

            return view('klant.tickets.bevestiging', compact('ticket'));
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Probeer de bevestigingsmail voor een ticket opnieuw te verzenden.
     */
    public function resendTicketMail($id)
    {
        try {
            $ticket = Ticket::with(['bezoeker', 'evenement', 'prijs'])->findOrFail($id);
            $bezoeker = $ticket->bezoeker;

            if (! $bezoeker || empty($bezoeker->{'E-mailadres'})) {
                return redirect()->route('klant.tickets.bevestiging', ['id' => $ticket->Id])
                    ->with('mailSent', false)
                    ->with('error', 'Geen geldig e-mailadres gekoppeld aan dit ticket.');
            }

            try {
                Mail::to($bezoeker->{'E-mailadres'})->send(new TicketPurchasedMail($ticket));
                if (! str_contains($ticket->Opmerking ?? '', 'Bevestigingsmail verzonden')) {
                    $ticket->update([
                        'Opmerking' => trim(($ticket->Opmerking ?? '').' | Bevestigingsmail verzonden'),
                    ]);
                }

                return redirect()->route('klant.tickets.bevestiging', ['id' => $ticket->Id])
                    ->with('mailSent', true)
                    ->with('success', 'De bevestigingsmail is alsnog succesvol verzonden naar '.$bezoeker->{'E-mailadres'});
            } catch (Throwable $mailError) {
                Log::error('Fout bij opnieuw verzenden van ticket bevestigingsmail: '.$mailError->getMessage(), [
                    'ticket_id' => $ticket->Id,
                    'email' => $bezoeker->{'E-mailadres'},
                    'exception' => $mailError,
                ]);

                return redirect()->route('klant.tickets.bevestiging', ['id' => $ticket->Id])
                    ->with('mailSent', false)
                    ->with('error', 'De e-mailserver is momenteel niet beschikbaar. Probeer het later opnieuw.');
            }
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Toon reserveringsformulier voor stands (User Story 8).
     */
    public function showReserveStandForm()
    {
        try {
            $evenementen = Evenement::where('Isactief', true)->get();
            $beschikbareStandTypes = Stand::where('Isactief', true)
                ->where('VerhuurdStatus', 'Beschikbaar')
                ->select('StandType', DB::raw('count(*) as count'), DB::raw('min(Prijs) as min_prijs'))
                ->groupBy('StandType')
                ->get();

            return view('klant.stands.reserveren', compact('evenementen', 'beschikbareStandTypes'));
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Verwerk stand reservering (User Story 8).
     */
    public function storeStandReservation(Request $request)
    {
        $validated = $request->validate([
            'evenement_id' => 'required|exists:evenements,Id',
            'stand_type' => 'required|in:AA+,AA,A',
            'dagen' => 'required|integer|in:1,2',
            'shop_naam' => 'required|string|max:255',
            'verkoopt_soort' => 'required|string|max:255',
            'contact_naam' => 'required|string|max:255',
            'contact_telefoon' => 'required|string|max:50',
            'contact_email' => 'required|email|max:255',
        ], [
            'evenement_id.required' => 'Selecteer een evenement.',
            'stand_type.required' => 'Selecteer een standtype.',
            'shop_naam.required' => 'Vul de naam van uw shop in.',
            'verkoopt_soort.required' => 'Vul in welk soort producten u verkoopt.',
            'contact_naam.required' => 'Vul de naam van de contactpersoon in.',
            'contact_telefoon.required' => 'Vul een geldig telefoonnummer in.',
            'contact_email.required' => 'Vul een geldig e-mailadres in.',
        ]);

        try {
            // Controleer beschikbaarheid van standtype
            $stand = Stand::where('StandType', $validated['stand_type'])
                ->where('VerhuurdStatus', 'Beschikbaar')
                ->where('Isactief', true)
                ->first();

            if (! $stand) {
                return redirect()->back()->withInput()->with('error', "Er is momenteel geen stand van het type {$validated['stand_type']} beschikbaar voor reservering.");
            }

            DB::beginTransaction();

            // Maak verkoper aan
            $verkoper = Verkoper::create([
                'Naam' => $validated['shop_naam'],
                'SpecialeStatus' => 'Normaal',
                'VerkooptSoort' => $validated['verkoopt_soort'],
                'StandType' => $validated['stand_type'],
                'Dagen' => $validated['dagen'],
                'Logo' => 'default_logo.png',
                'Isactief' => true,
                'Opmerking' => 'Reservering via website',
            ]);

            // Maak contactpersoon aan
            $contact = Contactpersoon::create([
                'Naam' => $validated['contact_naam'],
                'Telefoonnummer' => $validated['contact_telefoon'],
                'E-mailadres' => $validated['contact_email'],
                'Isactief' => true,
                'Opmerking' => 'Contact voor standreservering '.$verkoper->Naam,
            ]);

            // Koppel contact aan verkoper
            ContactPerVerkoper::create([
                'VerkoperId' => $verkoper->Id,
                'ContactpersoonId' => $contact->Id,
                'Isactief' => true,
                'Opmerking' => 'Koppeling bij standreservering',
            ]);

            // Wijs stand toe aan verkoper
            $stand->update([
                'VerkoperId' => $verkoper->Id,
                'VerhuurdStatus' => 'Gereserveerd',
                'Opmerking' => 'Gereserveerd via online formulier door '.$verkoper->Naam,
            ]);

            DB::commit();

            return redirect()->route('klant.stands.reserveren')
                ->with('success', "Gefeliciteerd! Uw reservering voor een Stand Type {$stand->StandType} is succesvol verwerkt (Reserveringsnummer: ST-{$stand->Id}).");

        } catch (Throwable $e) {
            DB::rollBack();

            return response()->view('errors.db_error', [], 500);
        }
    }
}
