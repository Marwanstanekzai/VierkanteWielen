<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\Bezoeker;
use App\Models\Evenement;
use App\Models\Prijs;
use Throwable;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets using Joins and/or Stored Procedures.
     */
    public function index()
    {
        try {
            // Probeer eerst de Stored Procedure sp_GetTicketsWithDetails aan te roepen
            $driver = DB::getDriverName();
            if ($driver === 'mysql' || $driver === 'mariadb') {
                $tickets = DB::select('CALL sp_GetTicketsWithDetails()');
            } else {
                // Fallback met expliciete Joins (Ticket + Bezoeker + Evenement + Prijs)
                $tickets = DB::table('tickets')
                    ->join('bezoekers', 'tickets.BezoekerId', '=', 'bezoekers.Id')
                    ->join('evenements', 'tickets.EvenementId', '=', 'evenements.Id')
                    ->leftJoin('prijs', 'tickets.PrijsId', '=', 'prijs.Id')
                    ->where('tickets.Isactief', '=', 1)
                    ->select(
                        'tickets.Id AS TicketId',
                        'bezoekers.Naam AS BezoekerNaam',
                        'bezoekers.E-mailadres AS BezoekerEmail',
                        'evenements.Naam AS EvenementNaam',
                        'evenements.Locatie AS EvenementLocatie',
                        'prijs.Tijdslot AS Tijdslot',
                        'prijs.Tarief AS Tarief',
                        'tickets.AantalTickets',
                        'tickets.Datum',
                        'tickets.Isactief'
                    )
                    ->orderBy('tickets.Id', 'desc')
                    ->get();
            }

            $evenementen = Evenement::where('Isactief', true)->get();
            $prijzen = Prijs::where('Isactief', true)->get();

            return view('tickets.index', compact('tickets', 'evenementen', 'prijzen'))
                ->with('success', 'Gegevens succesvol geladen.');
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Show form to buy a ticket.
     */
    public function create()
    {
        try {
            $evenementen = Evenement::where('Isactief', true)->get();
            $prijzen = Prijs::where('Isactief', true)->get();

            return view('tickets.create', compact('evenementen', 'prijzen'));
        } catch (Throwable $e) {
            return redirect()->route('tickets.index')->with('error', 'De gevraagde gegevens konden niet worden gevonden.');
        }
    }

    /**
     * Store a newly created ticket (Ticket kopen user story).
     */
    public function store(Request $request)
    {
        // Server-side validatie
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'evenement_id' => 'required|exists:evenements,Id',
            'prijs_id' => 'required|exists:prijs,Id',
            'aantal_tickets' => 'required|integer|min:1|max:10',
            'datum' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            // Zoek of maak bezoeker
            $bezoeker = Bezoeker::firstOrCreate(
                ['E-mailadres' => $validated['email']],
                ['Naam' => $validated['naam'], 'Isactief' => true, 'Opmerking' => 'Ticket koper via website']
            );

            // Maak nieuw ticket
            Ticket::create([
                'BezoekerId' => $bezoeker->Id,
                'EvenementId' => $validated['evenement_id'],
                'PrijsId' => $validated['prijs_id'],
                'AantalTickets' => $validated['aantal_tickets'],
                'Datum' => $validated['datum'],
                'Isactief' => true,
                'Opmerking' => 'Ticket aangeschaft via webformulier',
            ]);

            DB::commit();

            return redirect()->route('tickets.index')->with('success', 'Gegevens succesvol opgeslagen.');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'De gegevens konden niet worden opgeslagen.');
        }
    }

    /**
     * Delete a ticket (C.R.D. Delete).
     */
    public function destroy($id)
    {
        try {
            $ticket = Ticket::find($id);

            if (!$ticket) {
                return redirect()->route('tickets.index')->with('error', 'De gevraagde gegevens konden niet worden gevonden.');
            }

            // Soft delete by setting Isactief to false or delete record
            $ticket->delete();

            return redirect()->route('tickets.index')->with('success', 'Gegevens succesvol verwijderd.');
        } catch (Throwable $e) {
            return redirect()->route('tickets.index')->with('error', 'De gegevens konden niet worden verwijderd.');
        }
    }
}
