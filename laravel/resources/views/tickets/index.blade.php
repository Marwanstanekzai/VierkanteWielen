@extends('layouts.app')

@section('content')
<div class="tickets-page">
    <div class="page-header">
        <div>
            <h1>Tickets Overzicht</h1>
            <p>Overzicht van verkochte en gereserveerde tickets voor Sneakerness Rotterdam.</p>
        </div>
    </div>

    <div class="card">
        <h2>Verkochte Tickets</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bezoeker Naam</th>
                    <th>E-mailadres</th>
                    <th>Evenement</th>
                    <th>Tijdslot</th>
                    <th>Tarief</th>
                    <th>Aantal</th>
                    <th>Datum</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                    <tr>
                        <td>#{{ $t->TicketId }}</td>
                        <td><strong>{{ $t->BezoekerNaam }}</strong></td>
                        <td>{{ $t->BezoekerEmail }}</td>
                        <td>{{ $t->EvenementNaam }}</td>
                        <td><span class="badge badge-info">{{ $t->Tijdslot ?? 'Standaard' }}</span></td>
                        <td>€{{ number_format($t->Tarief ?? 0, 2) }}</td>
                        <td><strong>{{ $t->AantalTickets }}</strong></td>
                        <td>{{ $t->Datum }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Geen tickets gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
