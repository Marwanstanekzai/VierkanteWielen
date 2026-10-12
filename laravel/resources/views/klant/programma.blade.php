@extends('layouts.klant')

@section('content')
<div class="programma-container">
    <div class="page-header">
        <h1 class="page-title">PROGRAMMA & EVENEMENTEN</h1>
        <p class="page-subtitle">Sneakerness Rotterdam 2026 / Van Nellefabriek</p>
    </div>

    <div class="events-list">
        @forelse ($evenementen as $event)
            <div class="event-card">
                <div class="event-date-badge">
                    <span class="day">{{ \Carbon\Carbon::parse($event->Datum)->format('d') }}</span>
                    <span class="month">{{ \Carbon\Carbon::parse($event->Datum)->translatedFormat('M Y') }}</span>
                </div>
                <div class="event-details">
                    <h2>{{ $event->Naam }}</h2>
                    <p class="event-location">📍 {{ $event->Locatie }}</p>
                    <p class="event-desc">{{ $event->Opmerking ?? 'Beleef de beste sneaker convention van Nederland.' }}</p>
                    <div class="event-meta">
                        <span>🎟️ Tickets per tijdslot: {{ $event->AantalTicketsPerTijdslot }}</span>
                        <span>🎪 Beschikbare stands: {{ $event->BeschikbareStands }}</span>
                    </div>
                </div>
                <div class="event-action">
                    <a href="{{ route('klant.tickets.create') }}?evenement_id={{ $event->Id }}" class="btn-event-ticket">KOOP TICKETS</a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Geen actieve evenementen gevonden op dit moment.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .page-header {
        margin-bottom: 40px;
        text-align: center;
    }

    .page-title {
        font-size: 36px;
        font-weight: 900;
        letter-spacing: 1px;
    }

    .page-subtitle {
        font-size: 15px;
        color: #ff3b30;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-top: 6px;
    }

    .events-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .event-card {
        background-color: #12141a;
        border: 1px solid #1f232d;
        border-radius: 16px;
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 30px;
        transition: border-color 0.2s;
    }

    .event-card:hover {
        border-color: #ff3b30;
    }

    .event-date-badge {
        background-color: #ff3b30;
        color: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        text-align: center;
        min-width: 90px;
    }

    .event-date-badge .day {
        font-size: 28px;
        font-weight: 900;
        display: block;
        line-height: 1;
    }

    .event-date-badge .month {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        margin-top: 4px;
    }

    .event-details {
        flex: 1;
    }

    .event-details h2 {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .event-location {
        font-size: 14px;
        color: #a0a5b5;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .event-desc {
        font-size: 14px;
        color: #707585;
        margin-bottom: 12px;
    }

    .event-meta {
        display: flex;
        gap: 20px;
        font-size: 13px;
        color: #a0a5b5;
        font-weight: 600;
    }

    .btn-event-ticket {
        background-color: #ff3b30;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 800;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
        transition: background-color 0.2s;
    }

    .btn-event-ticket:hover {
        background-color: #e03126;
    }
</style>
@endsection
