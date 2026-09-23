<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evenement;
use Throwable;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        try {
            $evenementen = Evenement::where('Isactief', true)->get();

            return view('events.index', compact('evenementen'))
                ->with('success', 'Gegevens succesvol geladen.');
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Show form to create event.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a new event (Instellen aantal tickets per entreetijd & aantal stands).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'datum' => 'required|date',
            'locatie' => 'required|string|max:255',
            'aantal_tickets_per_tijdslot' => 'required|integer|min:1',
            'beschikbare_stands' => 'required|integer|min:1',
        ]);

        try {
            Evenement::create([
                'Naam' => $validated['naam'],
                'Datum' => $validated['datum'],
                'Locatie' => $validated['locatie'],
                'AantalTicketsPerTijdslot' => $validated['aantal_tickets_per_tijdslot'],
                'BeschikbareStands' => $validated['beschikbare_stands'],
                'Isactief' => true,
                'Opmerking' => 'Evenement ingesteld door Organisator',
            ]);

            return redirect()->route('events.index')->with('success', 'Gegevens succesvol opgeslagen.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'De gegevens konden niet worden opgeslagen.');
        }
    }

    /**
     * Update an event (Wijzigen aantal tickets per entreetijd & aantal stands).
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'aantal_tickets_per_tijdslot' => 'required|integer|min:1',
            'beschikbare_stands' => 'required|integer|min:1',
        ]);

        try {
            $evenement = Evenement::find($id);

            if (!$evenement) {
                return redirect()->route('events.index')->with('error', 'De gevraagde gegevens konden niet worden gevonden.');
            }

            $evenement->update([
                'AantalTicketsPerTijdslot' => $validated['aantal_tickets_per_tijdslot'],
                'BeschikbareStands' => $validated['beschikbare_stands'],
            ]);

            return redirect()->route('events.index')->with('success', 'Gegevens succesvol opgeslagen.');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'De gegevens konden niet worden opgeslagen.');
        }
    }

    /**
     * Delete an event (Verwijderen niet-actieve events/capaciteit opruimen).
     */
    public function destroy($id)
    {
        try {
            $evenement = Evenement::find($id);

            if (!$evenement) {
                return redirect()->route('events.index')->with('error', 'De gevraagde gegevens konden niet worden gevonden.');
            }

            $evenement->delete();

            return redirect()->route('events.index')->with('success', 'Gegevens succesvol verwijderd.');
        } catch (Throwable $e) {
            return redirect()->route('events.index')->with('error', 'De gegevens konden niet worden verwijderd.');
        }
    }
}
