<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contactpersoon;
use App\Models\Verkoper;
use App\Models\ContactPerVerkoper;
use Throwable;

class ContactpersoonController extends Controller
{
    /**
     * Display a listing of contact persons.
     */
    public function index()
    {
        try {
            $contactpersonen = Contactpersoon::where('Isactief', true)->get();
            $verkopers = Verkoper::where('Isactief', true)->get();

            return view('contactpersonen.index', compact('contactpersonen', 'verkopers'))
                ->with('success', 'Gegevens succesvol geladen.');
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $verkopers = Verkoper::where('Isactief', true)->get();
        return view('contactpersonen.create', compact('verkopers'));
    }

    /**
     * Store contact person information.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:50',
            'emailadres' => 'required|email|max:255',
            'verkoper_id' => 'nullable|exists:verkopers,Id',
        ]);

        try {
            $contactpersoon = Contactpersoon::create([
                'Naam' => $validated['naam'],
                'Telefoonnummer' => $validated['telefoonnummer'],
                'E-mailadres' => $validated['emailadres'],
                'Isactief' => true,
                'Opmerking' => 'Aangemaakt via contactbeheer',
            ]);

            if (!empty($validated['verkoper_id'])) {
                ContactPerVerkoper::create([
                    'VerkoperId' => $validated['verkoper_id'],
                    'ContactpersoonId' => $contactpersoon->Id,
                    'Isactief' => true,
                    'Opmerking' => 'Verkoper gekoppeld',
                ]);
            }

            return redirect()->route('contactpersonen.index')->with('success', 'Gegevens succesvol opgeslagen.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'De gegevens konden niet worden opgeslagen.');
        }
    }

    /**
     * Delete contact person.
     */
    public function destroy($id)
    {
        try {
            $contactpersoon = Contactpersoon::find($id);

            if (!$contactpersoon) {
                return redirect()->route('contactpersonen.index')->with('error', 'De gevraagde gegevens konden niet worden gevonden.');
            }

            $contactpersoon->delete();

            return redirect()->route('contactpersonen.index')->with('success', 'Gegevens succesvol verwijderd.');
        } catch (Throwable $e) {
            return redirect()->route('contactpersonen.index')->with('error', 'De gegevens konden niet worden verwijderd.');
        }
    }
}
