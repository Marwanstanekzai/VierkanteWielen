<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactpersoonController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VerkoperController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Openbare Klantwebsite Routes
|--------------------------------------------------------------------------
*/

// Homepagina klantwebsite (Geen admin-sidebar, eigen layout)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Programma en Informatie
Route::get('/programma', [KlantController::class, 'programma'])->name('programma');
Route::get('/praktische-info', [KlantController::class, 'praktischeInfo'])->name('praktische-info');

// Klant Ticket Koopflow (User Story 2 & 3)
Route::get('/klant/tickets/kopen', [KlantController::class, 'showBuyTicketForm'])->name('klant.tickets.create');
Route::post('/klant/tickets/kopen', [KlantController::class, 'storeTicketPurchase'])->name('klant.tickets.store');
Route::get('/klant/tickets/bevestiging/{id}', [KlantController::class, 'showTicketConfirmation'])->name('klant.tickets.bevestiging');
Route::post('/klant/tickets/bevestiging/{id}/opnieuw-versturen', [KlantController::class, 'resendTicketMail'])->name('klant.tickets.resend');

// Klant / Verkoper Stand Reserveringsflow (User Story 8)
Route::get('/klant/stands/reserveren', [KlantController::class, 'showReserveStandForm'])->name('klant.stands.reserveren');
Route::post('/klant/stands/reserveren', [KlantController::class, 'storeStandReservation'])->name('klant.stands.store');

/*
|--------------------------------------------------------------------------
| Authenticatie Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin / Organisator Beheeromgeving (Beveiligd met Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Tickets Beheer
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/admin/tickets/toevoegen', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/admin/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::delete('/admin/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    // Verkopers Beheer (User Story 4)
    Route::get('/verkopers', [VerkoperController::class, 'index'])->name('verkopers.index');
    Route::get('/admin/verkopers/toevoegen', [VerkoperController::class, 'create'])->name('verkopers.create');
    Route::post('/admin/verkopers', [VerkoperController::class, 'store'])->name('verkopers.store');
    Route::delete('/admin/verkopers/{id}', [VerkoperController::class, 'destroy'])->name('verkopers.destroy');

    // Contactpersonen Beheer & Koppelen (User Story 5 & 6)
    Route::get('/contactpersonen', [ContactpersoonController::class, 'index'])->name('contactpersonen.index');
    Route::get('/admin/contactpersonen/toevoegen', [ContactpersoonController::class, 'create'])->name('contactpersonen.create');
    Route::post('/admin/contactpersonen', [ContactpersoonController::class, 'store'])->name('contactpersonen.store');
    Route::get('/admin/contact-koppelen', [ContactpersoonController::class, 'showKoppelenForm'])->name('contactpersonen.koppelen.form');
    Route::post('/admin/contact-koppelen', [ContactpersoonController::class, 'storeKoppeling'])->name('contactpersonen.koppelen.store');
    Route::delete('/admin/contactpersonen/{id}', [ContactpersoonController::class, 'destroy'])->name('contactpersonen.destroy');

    // Stands Beheer (User Story 7)
    Route::get('/stands', [StandController::class, 'index'])->name('stands.index');
    Route::get('/admin/stands/toevoegen', [StandController::class, 'create'])->name('stands.create');
    Route::post('/admin/stands', [StandController::class, 'store'])->name('stands.store');
    Route::delete('/admin/stands/{id}', [StandController::class, 'destroy'])->name('stands.destroy');

    // Events Beheer (User Story 9)
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/admin/events/toevoegen', [EventController::class, 'create'])->name('events.create');
    Route::post('/admin/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/admin/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/admin/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

});
