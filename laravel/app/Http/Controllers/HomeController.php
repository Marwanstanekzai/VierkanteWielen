<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Evenement;
use App\Models\Ticket;
use App\Models\Stand;
use App\Models\Verkoper;
use App\Models\Contactpersoon;
use Throwable;

class HomeController extends Controller
{
    /**
     * Toon de Homepagina van Sneakerness Rotterdam met de verticale sidebar.
     */
    public function index()
    {
        try {
            $totaalEvenementen = Evenement::where('Isactief', true)->count();
            $totaalTickets = Ticket::where('Isactief', true)->sum('AantalTickets');
            $totaalVerkopers = Verkoper::where('Isactief', true)->count();
            $totaalStands = Stand::where('Isactief', true)->count();
            $beschikbareStands = Stand::where('Isactief', true)->where('VerhuurdStatus', 'Beschikbaar')->count();
            $totaalContacten = Contactpersoon::where('Isactief', true)->count();

            return view('home', compact(
                'totaalEvenementen',
                'totaalTickets',
                'totaalVerkopers',
                'totaalStands',
                'beschikbareStands',
                'totaalContacten'
            ));
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Dashboard overzicht view.
     */
    public function dashboard()
    {
        try {
            $evenementen = Evenement::where('Isactief', true)->get();
            $recenteTickets = Ticket::with(['bezoeker', 'evenement', 'prijs'])
                ->where('Isactief', true)
                ->orderBy('Id', 'desc')
                ->take(5)
                ->get();
            $verkopers = Verkoper::where('Isactief', true)->get();

            return view('dashboard', compact('evenementen', 'recenteTickets', 'verkopers'));
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }
}
