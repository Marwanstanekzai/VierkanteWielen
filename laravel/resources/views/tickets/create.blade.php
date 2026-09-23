@extends('layouts.app')

@section('content')
<div class="form-page">
    <div class="page-header">
        <h1>Ticket Kopen - Sneakerness Rotterdam</h1>
        <p>Kies je gewenste dag, tijdslot en aantal toegangskaarten.</p>
    </div>

    <div class="card form-card">
        <form action="{{ route('tickets.store') }}" method="POST" id="ticketForm">
            @csrf

            <div class="form-group">
                <label for="naam">Volledige Naam *</label>
                <input type="text" id="naam" name="naam" class="form-control" value="{{ old('naam') }}" required placeholder="Bijv. Jan de Vries">
            </div>

            <div class="form-group">
                <label for="email">E-mailadres *</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="bijv. jan@example.com">
            </div>

            <div class="form-group">
                <label for="evenement_id">Selecteer Evenement / Dag *</label>
                <select id="evenement_id" name="evenement_id" class="form-control" required>
                    <option value="">-- Kies een evenement --</option>
                    @foreach($evenementen as $event)
                        <option value="{{ $event->Id }}" {{ old('evenement_id') == $event->Id ? 'selected' : '' }}>
                            {{ $event->Naam }} ({{ $event->Datum }} - {{ $event->Locatie }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="prijs_id">Selecteer Tijdslot & Prijsklasse *</label>
                <select id="prijs_id" name="prijs_id" class="form-control" required>
                    <option value="">-- Kies een tijdslot --</option>
                    @foreach($prijzen as $prijs)
                        <option value="{{ $prijs->Id }}" {{ old('prijs_id') == $prijs->Id ? 'selected' : '' }}>
                            {{ $prijs->Tijdslot }} — €{{ number_format($prijs->Tarief, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="aantal_tickets">Aantal Tickets *</label>
                <input type="number" id="aantal_tickets" name="aantal_tickets" class="form-control" value="{{ old('aantal_tickets', 1) }}" min="1" max="10" required>
            </div>

            <div class="form-group">
                <label for="datum">Datum van Bezoek *</label>
                <input type="date" id="datum" name="datum" class="form-control" value="{{ old('datum', date('Y-m-d')) }}" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Bestelling Plaatsen</button>
                <a href="{{ route('tickets.index') }}" class="btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Client-side validatie
    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const aantal = document.getElementById('aantal_tickets').value;
        
        if (!email.includes('@')) {
            alert('Vul een geldig e-mailadres in.');
            e.preventDefault();
            return false;
        }
        if (aantal < 1 || aantal > 10) {
            alert('Aantal tickets moet tussen 1 en 10 liggen.');
            e.preventDefault();
            return false;
        }
    });
</script>
@endsection
