<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VerkoperController;
use App\Http\Controllers\ContactpersoonController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\EventController;

// Home pagina
Route::get('/', [HomeController::class, 'index'])->name('home');

// Sidebar Navigatie Items (Exacte volgorde: Dashboard, Tickets, Verkopers, Contactpersonen, Stands, Events)
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

// Tickets
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/kopen', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

// Verkopers
Route::get('/verkopers', [VerkoperController::class, 'index'])->name('verkopers.index');
Route::get('/verkopers/huren', [VerkoperController::class, 'create'])->name('verkopers.create');
Route::post('/verkopers', [VerkoperController::class, 'store'])->name('verkopers.store');
Route::delete('/verkopers/{id}', [VerkoperController::class, 'destroy'])->name('verkopers.destroy');

// Contactpersonen
Route::get('/contactpersonen', [ContactpersoonController::class, 'index'])->name('contactpersonen.index');
Route::get('/contactpersonen/toevoegen', [ContactpersoonController::class, 'create'])->name('contactpersonen.create');
Route::post('/contactpersonen', [ContactpersoonController::class, 'store'])->name('contactpersonen.store');
Route::delete('/contactpersonen/{id}', [ContactpersoonController::class, 'destroy'])->name('contactpersonen.destroy');

// Stands
Route::get('/stands', [StandController::class, 'index'])->name('stands.index');
Route::get('/stands/toevoegen', [StandController::class, 'create'])->name('stands.create');
Route::post('/stands', [StandController::class, 'store'])->name('stands.store');
Route::delete('/stands/{id}', [StandController::class, 'destroy'])->name('stands.destroy');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/instellen', [EventController::class, 'create'])->name('events.create');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
