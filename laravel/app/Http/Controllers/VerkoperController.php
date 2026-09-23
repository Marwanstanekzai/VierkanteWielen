<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Verkoper;
use App\Models\Contactpersoon;
use App\Models\ContactPerVerkoper;
use Throwable;

class VerkoperController extends Controller
{
    /**
     * Display a listing of sellers and their contact persons using Joins/Stored Procedures.
     */
    public function index()
    {
        try {
            $driver = DB::getDriverName();
            if ($driver === 'mysql' || $driver === 'mariadb') {
                $contactPerVerkoper = DB::select('CALL sp_GetContactenPerVerkoper()');
            } else {
                $contactPerVerkoper = DB::table('contact_per_verkopers')
                    ->join('verkopers', 'contact_per_verkopers.VerkoperId', '=', 'verkopers.Id')
                    ->join('contactpersoons', 'contact_per_verkopers.ContactpersoonId', '=', 'contactpersoons.Id')
                    ->where('contact_per_verkopers.Isactief', '=', 1)
                    ->select(
                        'contact_per_verkopers.Id AS RelatieId',
                        'verkopers.Naam AS VerkoperNaam',
                        'verkopers.StandType',
                        'contactpersoons.Naam AS ContactNaam',
                        'contactpersoons.Telefoonnummer',
                        'contactpersoons.E-mailadres AS ContactEmail',
                        'contact_per_verkopers.Isactief'
                    )
                    ->orderBy('verkopers.Naam', 'asc')
                    ->get();
            }

            $verkopers = Verkoper::where('Isactief', true)->get();

            return view('verkopers.index', compact('verkopers', 'contactPerVerkoper'))
                ->with('success', 'Gegevens succesvol geladen.');
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Show form to add a seller.
     */
    public function create()
    {
        return view('verkopers.create');
    }

    /**
     * Store a seller and contact person.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'speciale_status' => 'required|string|max:100',
            'verkoopt_soort' => 'required|string|max:255',
            'stand_type' => 'required|in:AA+,AA,A',
            'dagen' => 'required|integer|in:1,2',
            'contact_naam' => 'required|string|max:255',
            'contact_telefoon' => 'required|string|max:50',
            'contact_email' => 'required|email|max:255',
        ]);

        try {
            DB::beginTransaction();

            $verkoper = Verkoper::create([
                'Naam' => $validated['naam'],
                'SpecialeStatus' => $validated['speciale_status'],
                'VerkooptSoort' => $validated['verkoopt_soort'],
                'StandType' => $validated['stand_type'],
                'Dagen' => $validated['dagen'],
                'Logo' => 'default_logo.png',
                'Isactief' => true,
                'Opmerking' => 'Aangemaakt via verkoper registratie',
            ]);

            $contactpersoon = Contactpersoon::create([
                'Naam' => $validated['contact_naam'],
                'Telefoonnummer' => $validated['contact_telefoon'],
                'E-mailadres' => $validated['contact_email'],
                'Isactief' => true,
                'Opmerking' => 'Contactpersoon voor verkoper ' . $verkoper->Naam,
            ]);

            ContactPerVerkoper::create([
                'VerkoperId' => $verkoper->Id,
                'ContactpersoonId' => $contactpersoon->Id,
                'Isactief' => true,
                'Opmerking' => 'Koppeling verkoper-contact',
            ]);

            DB::commit();

            return redirect()->route('verkopers.index')->with('success', 'Gegevens succesvol opgeslagen.');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'De gegevens konden niet worden opgeslagen.');
        }
    }

    /**
     * Delete a seller.
     */
    public function destroy($id)
    {
        try {
            $verkoper = Verkoper::find($id);

            if (!$verkoper) {
                return redirect()->route('verkopers.index')->with('error', 'De gevraagde gegevens konden niet worden gevonden.');
            }

            $verkoper->delete();

            return redirect()->route('verkopers.index')->with('success', 'Gegevens succesvol verwijderd.');
        } catch (Throwable $e) {
            return redirect()->route('verkopers.index')->with('error', 'De gegevens konden niet worden verwijderd.');
        }
    }
}
