<?php

namespace App\Http\Controllers;

use App\Models\Contactpersoon;
use App\Models\ContactPerVerkoper;
use App\Models\Verkoper;
use Illuminate\Http\Request;
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
     * Show create form (User Story 5).
     */
    public function create()
    {
        $verkopers = Verkoper::where('Isactief', true)->get();

        return view('contactpersonen.create', compact('verkopers'));
    }

    /**
     * Store contact person information (User Story 5).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:50',
            'emailadres' => 'required|email|max:255',
            'opmerking' => 'nullable|string',
            'verkoper_id' => 'nullable|exists:verkopers,Id',
        ], [
            'naam.required' => 'Vul alstublieft de naam van de contactpersoon in.',
            'telefoonnummer.required' => 'Vul alstublieft het telefoonnummer in.',
            'emailadres.required' => 'Vul alstublieft het e-mailadres in.',
            'emailadres.email' => 'Vul alstublieft een geldig e-mailadres in.',
        ]);

        try {
            $contactpersoon = Contactpersoon::create([
                'Naam' => $validated['naam'],
                'Telefoonnummer' => $validated['telefoonnummer'],
                'E-mailadres' => $validated['emailadres'],
                'Isactief' => true,
                'Opmerking' => $validated['opmerking'] ?? 'Aangemaakt via contactbeheer',
            ]);

            if (! empty($validated['verkoper_id'])) {
                ContactPerVerkoper::create([
                    'VerkoperId' => $validated['verkoper_id'],
                    'ContactpersoonId' => $contactpersoon->Id,
                    'Isactief' => true,
                    'Opmerking' => 'Verkoper gekoppeld bij aanmaken',
                ]);
            }

            return redirect()->route('contactpersonen.index')->with('success', 'Contactpersoon succesvol opgeslagen.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'De gegevens konden niet worden opgeslagen.');
        }
    }

    /**
     * Show koppelen form (User Story 6: Contactpersoon aan verkoper koppelen).
     */
    public function showKoppelenForm()
    {
        try {
            $verkopers = Verkoper::where('Isactief', true)->orderBy('Naam', 'asc')->get();
            $contactpersonen = Contactpersoon::where('Isactief', true)->orderBy('Naam', 'asc')->get();

            return view('contactpersonen.koppelen', compact('verkopers', 'contactpersonen'));
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Store contact per verkoper koppeling (User Story 6).
     */
    public function storeKoppeling(Request $request)
    {
        $validated = $request->validate([
            'verkoper_id' => 'required|exists:verkopers,Id',
            'contactpersoon_id' => 'required|exists:contactpersoons,Id',
            'opmerking' => 'nullable|string',
        ], [
            'verkoper_id.required' => 'Selecteer een verkoper.',
            'contactpersoon_id.required' => 'Selecteer een contactpersoon.',
        ]);

        try {
            // Controleer op bestaande dubbele actieve koppeling
            $bestaandeKoppeling = ContactPerVerkoper::where('VerkoperId', $validated['verkoper_id'])
                ->where('ContactpersoonId', $validated['contactpersoon_id'])
                ->where('Isactief', true)
                ->first();

            if ($bestaandeKoppeling) {
                return redirect()->back()->withInput()->with('error', 'Deze contactpersoon is al gekoppeld aan de geselecteerde verkoper.');
            }

            ContactPerVerkoper::create([
                'VerkoperId' => $validated['verkoper_id'],
                'ContactpersoonId' => $validated['contactpersoon_id'],
                'Isactief' => true,
                'Opmerking' => $validated['opmerking'] ?? 'Koppeling verkoper-contactpersoon',
            ]);

            return redirect()->route('verkopers.index')->with('success', 'Contactpersoon succesvol gekoppeld aan verkoper.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'De koppeling kon niet worden opgeslagen.');
        }
    }

    /**
     * Delete contact person.
     */
    public function destroy($id)
    {
        try {
            $contactpersoon = Contactpersoon::find($id);

            if (! $contactpersoon) {
                return redirect()->route('contactpersonen.index')->with('error', 'De gevraagde gegevens konden niet worden gevonden.');
            }

            $contactpersoon->delete();

            return redirect()->route('contactpersonen.index')->with('success', 'Gegevens succesvol verwijderd.');
        } catch (Throwable $e) {
            return redirect()->route('contactpersonen.index')->with('error', 'De gegevens konden niet worden verwijderd.');
        }
    }
}
