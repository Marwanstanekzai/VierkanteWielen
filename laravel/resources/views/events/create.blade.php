@extends('layouts.app')

@section('content')
<div class="form-page">
    <div class="page-header">
        <h1>Evenement & Capaciteit Instellen</h1>
        <p>Voer de gegevens in voor het instellen van een nieuw evenement en de bijbehorende capaciteiten.</p>
    </div>

    <div class="card form-card">
        <form action="{{ route('events.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="naam">Evenement Naam *</label>
                <input type="text" id="naam" name="naam" class="form-control" value="{{ old('naam') }}" required placeholder="Bijv. Sneakerness Rotterdam 2026">
            </div>

            <div class="form-group">
                <label for="datum">Datum *</label>
                <input type="date" id="datum" name="datum" class="form-control" value="{{ old('datum', '2026-05-25') }}" required>
            </div>

            <div class="form-group">
                <label for="locatie">Locatie *</label>
                <input type="text" id="locatie" name="locatie" class="form-control" value="{{ old('locatie', 'Van Nellefabriek Rotterdam') }}" required>
            </div>

            <div class="form-group">
                <label for="aantal_tickets_per_tijdslot">Aantal Beschikbare Tickets per Entreetijd *</label>
                <input type="number" id="aantal_tickets_per_tijdslot" name="aantal_tickets_per_tijdslot" class="form-control" value="{{ old('aantal_tickets_per_tijdslot', 250) }}" min="1" required>
            </div>

            <div class="form-group">
                <label for="beschikbare_stands">Aantal Beschikbare Stands *</label>
                <input type="number" id="beschikbare_stands" name="beschikbare_stands" class="form-control" value="{{ old('beschikbare_stands', 100) }}" min="1" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Evenement Instellen</button>
                <a href="{{ route('events.index') }}" class="btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection
