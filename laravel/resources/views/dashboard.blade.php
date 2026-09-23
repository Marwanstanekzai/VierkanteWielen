@extends('layouts.app')

@section('content')
<div class="dashboard-page">
    <div class="page-header">
        <h1>Dashboard Sneakerness Rotterdam</h1>
        <p>Overzicht van evenementen, recente ticketverkopen en verhuurde stands.</p>
    </div>

    <div class="stats-overview">
        <div class="stat-card">
            <span class="stat-icon">📅</span>
            <div>
                <h3>Evenementen</h3>
                <strong class="stat-number">{{ count($evenementen ?? []) }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">🏪</span>
            <div>
                <h3>Actieve Verkopers</h3>
                <strong class="stat-number">{{ count($verkopers ?? []) }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">🎟️</span>
            <div>
                <h3>Recente Reserveringen</h3>
                <strong class="stat-number">{{ count($recenteTickets ?? []) }}</strong>
            </div>
        </div>
    </div>

    <div class="dashboard-sections">
        <div class="card">
            <h2>Aankomende Evenementen</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Datum</th>
                        <th>Locatie</th>
                        <th>Capaciteit/Tijdslot</th>
                        <th>Stands Beschikbaar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evenementen as $event)
                        <tr>
                            <td><strong>{{ $event->Naam }}</strong></td>
                            <td>{{ $event->Datum }}</td>
                            <td>{{ $event->Locatie }}</td>
                            <td>{{ $event->AantalTicketsPerTijdslot }} tickets</td>
                            <td>{{ $event->BeschikbareStands }} stands</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Geen evenementen gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>Recente Ticket Boekingen</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Bezoeker</th>
                        <th>E-mail</th>
                        <th>Evenement</th>
                        <th>Aantal</th>
                        <th>Datum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recenteTickets as $ticket)
                        <tr>
                            <td>{{ $ticket->bezoeker->Naam ?? 'Onbekend' }}</td>
                            <td>{{ $ticket->bezoeker->{'E-mailadres'} ?? '-' }}</td>
                            <td>{{ $ticket->evenement->Naam ?? '-' }}</td>
                            <td><span class="badge">{{ $ticket->AantalTickets }}</span></td>
                            <td>{{ $ticket->Datum }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Geen recente boekingen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
