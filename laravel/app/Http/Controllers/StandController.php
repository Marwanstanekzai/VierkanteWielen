<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stand;
use App\Models\Verkoper;
use Throwable;

class StandController extends Controller
{
    /**
     * Display a listing of stands with seller details using Stored Procedure / Joins.
     */
    public function index()
    {
        try {
            $driver = DB::getDriverName();
            if ($driver === 'mysql' || $driver === 'mariadb') {
                $stands = DB::select('CALL sp_GetStandsWithVerkopers()');
            } else {
                $stands = DB::table('stands')
                    ->leftJoin('verkopers', 'stands.VerkoperId', '=', 'verkopers.Id')
                    ->where('stands.Isactief', '=', 1)
                    ->select(
                        'stands.Id AS StandId',
                        'stands.StandType',
                        'stands.Prijs',
                        'stands.VerhuurdStatus',
                        'verkopers.Naam AS VerkoperNaam',
                        'verkopers.SpecialeStatus',
                        'verkopers.VerkooptSoort',
                        'stands.Isactief'
                    )
                    ->orderBy('stands.Id', 'asc')
                    ->get();
            }

            $verkopers = Verkoper::where('Isactief', true)->get();

            return view('stands.index', compact('stands', 'verkopers'))
                ->with('success', 'Gegevens succesvol geladen.');
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Show creation form for renting or creating a stand.
     */
    public function create()
    {
        $verkopers = Verkoper::where('Isactief', true)->get();
        return view('stands.create', compact('verkopers'));
    }

    /**
     * Store new stand or rent stand for verkoper.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stand_type' => 'required|in:AA+,AA,A',
            'prijs' => 'required|numeric|min:0',
            'verkoopster_id' => 'nullable|exists:verkopers,Id',
            'verhuurd_status' => 'required|in:Beschikbaar,Verhuurd,Gereserveerd',
        ]);

        try {
            Stand::create([
                'VerkoperId' => $validated['verkoopster_id'] ?? null,
                'StandType' => $validated['stand_type'],
                'Prijs' => $validated['prijs'],
                'VerhuurdStatus' => $validated['verhuurd_status'],
                'Isactief' => true,
                'Opmerking' => 'Stand toegevoegd of bijgewerkt via beheersscherm',
            ]);

            return redirect()->route('stands.index')->with('success', 'Gegevens succesvol opgeslagen.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'De gegevens konden niet worden opgeslagen.');
        }
    }

    /**
     * Delete stand (Organisator story: niet actieve stands opruimen).
     */
    public function destroy($id)
    {
        try {
            $stand = Stand::find($id);

            if (!$stand) {
                return redirect()->route('stands.index')->with('error', 'De gevraagde gegevens konden niet worden gevonden.');
            }

            $stand->delete();

            return redirect()->route('stands.index')->with('success', 'Gegevens succesvol verwijderd.');
        } catch (Throwable $e) {
            return redirect()->route('stands.index')->with('error', 'De gegevens konden niet worden verwijderd.');
        }
    }
}
