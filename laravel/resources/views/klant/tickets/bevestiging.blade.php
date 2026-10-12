@extends('layouts.klant')

@section('content')
<div class="confirmation-wrapper">
    <div class="confirmation-card">
        <div class="success-icon">🎉</div>
        <h1 class="conf-title">AANKOOP BEVESTIGD</h1>
        <p class="conf-subtitle">Bedankt voor uw bestelling! U bent klaar voor Sneakerness Rotterdam 2026.</p>

        @php
            $isMailSent = session('mailSent') === true || (is_null(session('mailSent')) && str_contains($ticket->Opmerking ?? '', 'Bevestigingsmail verzonden'));
            $isMailFailed = session('mailSent') === false;
        @endphp

        @if ($isMailSent)
            <div class="alert alert-success" style="margin-top: 20px;">
                📧 Een bevestigingsmail is succesvol verzonden naar <strong>{{ $ticket->bezoeker->{'E-mailadres'} ?? '' }}</strong>.
            </div>
        @elseif ($isMailFailed)
            <div class="alert alert-warning" style="margin-top: 20px; background-color: rgba(255, 149, 0, 0.15); border: 1px solid #ff9500; color: #ffb020; text-align: left;">
                <div style="font-weight: 800; margin-bottom: 6px;">⚠️ Let op: bevestigingsmail niet verzonden</div>
                <div>Uw ticketaankoop is succesvol opgeslagen in ons systeem. De bevestigingsmail kon momenteel echter niet worden verzonden door een storing bij de e-mailserver. U hoeft geen nieuwe tickets te bestellen. Bewaar dit besteloverzicht of print uw ticket af als geldig aankoopbewijs.</div>
                <form action="{{ route('klant.tickets.resend', ['id' => $ticket->Id]) }}" method="POST" style="margin-top: 14px;">
                    @csrf
                    <button type="submit" class="btn-resend-mail">
                        🔄 Bevestigingsmail opnieuw proberen te verzenden
                    </button>
                </form>
            </div>
        @endif

        <div class="ticket-details-box">
            <h2>Besteloverzicht</h2>
            <div class="detail-row">
                <span>Bevestigingsnummer:</span>
                <strong>SNK-2026-T{{ $ticket->Id }}</strong>
            </div>
            <div class="detail-row">
                <span>Naam koper:</span>
                <strong>{{ $ticket->bezoeker->Naam ?? 'Bezoeker' }}</strong>
            </div>
            <div class="detail-row">
                <span>E-mailadres:</span>
                <strong>{{ $ticket->bezoeker->{'E-mailadres'} ?? '-' }}</strong>
            </div>
            <div class="detail-row">
                <span>Evenement:</span>
                <strong>{{ $ticket->evenement->Naam ?? 'Sneakerness Rotterdam' }}</strong>
            </div>
            <div class="detail-row">
                <span>Datum:</span>
                <strong>{{ \Carbon\Carbon::parse($ticket->Datum)->format('d-m-Y') }}</strong>
            </div>
            <div class="detail-row">
                <span>Tijdslot & Tarief:</span>
                <strong>{{ $ticket->prijs->Tijdslot ?? 'Regulier' }} (€{{ number_format($ticket->prijs->Tarief ?? 0, 2, ',', '.') }})</strong>
            </div>
            <div class="detail-row">
                <span>Aantal tickets:</span>
                <strong>{{ $ticket->AantalTickets }}</strong>
            </div>
            <div class="detail-row total">
                <span>Totaalbedrag:</span>
                <strong style="color: #ff3b30; font-size: 20px;">€{{ number_format(($ticket->prijs->Tarief ?? 0) * $ticket->AantalTickets, 2, ',', '.') }}</strong>
            </div>
        </div>

        <div class="conf-actions">
            <a href="{{ route('home') }}" class="btn-conf-home">TERUG NAAR HOME</a>
            <a href="javascript:window.print()" class="btn-conf-print">🖨️ TICKET AFDRUKKEN</a>
        </div>
    </div>
</div>

<style>
    .confirmation-wrapper {
        max-width: 680px;
        margin: 20px auto;
    }

    .confirmation-card {
        background-color: #12141a;
        border: 1px solid #1f232d;
        border-radius: 20px;
        padding: 40px;
        text-align: center;
    }

    .success-icon {
        font-size: 54px;
        margin-bottom: 16px;
    }

    .conf-title {
        font-size: 32px;
        font-weight: 900;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .conf-subtitle {
        font-size: 15px;
        color: #a0a5b5;
        margin-bottom: 24px;
    }

    .ticket-details-box {
        background-color: #0b0c10;
        border: 1px solid #2b303e;
        border-radius: 12px;
        padding: 24px;
        margin: 30px 0;
        text-align: left;
    }

    .ticket-details-box h2 {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 16px;
        border-bottom: 1px solid #1f232d;
        padding-bottom: 8px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #a0a5b5;
        margin-bottom: 10px;
    }

    .detail-row strong {
        color: #ffffff;
    }

    .detail-row.total {
        border-top: 1px solid #1f232d;
        padding-top: 12px;
        margin-top: 12px;
    }

    .conf-actions {
        display: flex;
        gap: 16px;
        justify-content: center;
    }

    .btn-conf-home {
        background-color: #ff3b30;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 800;
        text-decoration: none;
        text-transform: uppercase;
    }

    .btn-conf-print {
        background-color: #1f232d;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 800;
        text-decoration: none;
        text-transform: uppercase;
        border: 1px solid #2e3340;
    }

    .btn-resend-mail {
        background-color: #ff9500;
        color: #0b0c10;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 13px;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-resend-mail:hover {
        background-color: #e08500;
    }
</style>
@endsection
