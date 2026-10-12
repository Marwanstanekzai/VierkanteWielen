@extends('layouts.klant')

@section('content')
<div class="ticket-buy-wrapper">
    <div class="page-header">
        <h1 class="page-title">TICKETS BESTELLEN</h1>
        <p class="page-subtitle">Sneakerness Rotterdam 2026 / Van Nellefabriek</p>
    </div>

    <div class="buy-grid">
        <!-- FORMULIER -->
        <div class="form-card">
            <h2>Kies uw Tickets</h2>
            <form action="{{ route('klant.tickets.store') }}" method="POST" id="ticketForm">
                @csrf

                <div class="form-group">
                    <label for="evenement_id" class="form-label">1. Kies Evenement / Dag</label>
                    <select name="evenement_id" id="evenement_id" class="form-control" required onchange="updatePriceOptions()">
                        <option value="">-- Selecteer evenement --</option>
                        @foreach ($evenementen as $evenement)
                            <option value="{{ $evenement->Id }}" {{ (old('evenement_id', $selectedEvenementId) == $evenement->Id) ? 'selected' : '' }}>
                                {{ $evenement->Naam }} ({{ \Carbon\Carbon::parse($evenement->Datum)->format('d-m-Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="prijs_id" class="form-label">2. Kies Tijdslot & Entreetarief</label>
                    <select name="prijs_id" id="prijs_id" class="form-control" required onchange="calculateTotal()">
                        <option value="">-- Selecteer eerst een evenement --</option>
                        @foreach ($prijzen as $prijs)
                            <option value="{{ $prijs->Id }}" data-tarief="{{ $prijs->Tarief }}" data-datum="{{ $prijs->Datum }}">
                                {{ $prijs->Tijdslot }} - €{{ number_format($prijs->Tarief, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="naam" class="form-label">3. Uw Naam</label>
                        <input type="text" name="naam" id="naam" class="form-control" value="{{ old('naam', auth()->check() ? auth()->user()->name : '') }}" required placeholder="Volledige naam">
                    </div>

                    <div class="form-group half">
                        <label for="email" class="form-label">4. Uw E-mailadres</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" required placeholder="uw@email.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="aantal_tickets" class="form-label">5. Aantal Tickets</label>
                    <select name="aantal_tickets" id="aantal_tickets" class="form-control" required onchange="calculateTotal()">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ old('aantal_tickets') == $i ? 'selected' : '' }}>{{ $i }} ticket{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>

                <div class="summary-box">
                    <div class="summary-line">
                        <span>Aantal tickets:</span>
                        <strong id="summaryCount">1</strong>
                    </div>
                    <div class="summary-line">
                        <span>Prijs per ticket:</span>
                        <strong id="summaryPrice">€0,00</strong>
                    </div>
                    <div class="summary-line total">
                        <span>Totaalprijs:</span>
                        <strong id="summaryTotal" style="color: #ff3b30; font-size: 22px;">€0,00</strong>
                    </div>
                </div>

                <button type="submit" class="btn-buy-submit" id="submitBtn">
                    <span>BEVESTIG AANKOOP</span>
                </button>
            </form>
        </div>

        <!-- INFO ZIJBALK -->
        <div class="info-sidebar">
            <div class="side-card">
                <h3>🎟️ Belangrijke Informatie</h3>
                <p>• Elk ticket is gekoppeld aan een specifiek tijdslot om de beursvloer comfortabel te houden.</p>
                <p>• Na aankoop ontvangt u direct een bevestiging met uw unieke ticketnummer op het opgegeven e-mailadres.</p>
                <p>• Kinderen tot 12 jaar hebben gratis toegang onder begeleiding van een volwassene.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function calculateTotal() {
        const prijsSelect = document.getElementById('prijs_id');
        const countSelect = document.getElementById('aantal_tickets');
        const selectedOption = prijsSelect.options[prijsSelect.selectedIndex];

        const tarief = selectedOption ? parseFloat(selectedOption.getAttribute('data-tarief')) || 0 : 0;
        const count = parseInt(countSelect.value) || 1;
        const total = tarief * count;

        document.getElementById('summaryCount').textContent = count;
        document.getElementById('summaryPrice').textContent = '€' + tarief.toFixed(2).replace('.', ',');
        document.getElementById('summaryTotal').textContent = '€' + total.toFixed(2).replace('.', ',');
    }

    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();

        const form = document.getElementById('ticketForm');
        if (form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('submitBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.style.opacity = '0.7';
                    btn.innerHTML = '<span>BEZIG MET VERWERKEN...</span>';
                }
            });
        }
    });
</script>

<style>
    .buy-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    .form-card {
        background-color: #12141a;
        border: 1px solid #1f232d;
        border-radius: 16px;
        padding: 36px;
    }

    .form-card h2 {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 24px;
        border-bottom: 1px solid #1f232d;
        padding-bottom: 12px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-group.half {
        flex: 1;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #a0a5b5;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        background-color: #0b0c10;
        border: 1px solid #2b303e;
        border-radius: 8px;
        color: #ffffff;
        font-size: 15px;
        outline: none;
    }

    .form-control:focus {
        border-color: #ff3b30;
    }

    .summary-box {
        background-color: #0b0c10;
        border: 1px solid #2b303e;
        border-radius: 10px;
        padding: 20px;
        margin: 24px 0;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #a0a5b5;
        margin-bottom: 8px;
    }

    .summary-line.total {
        border-top: 1px solid #1f232d;
        padding-top: 12px;
        margin-top: 12px;
        font-size: 16px;
        color: #ffffff;
    }

    .btn-buy-submit {
        width: 100%;
        background-color: #ff3b30;
        color: #ffffff;
        border: none;
        padding: 16px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-buy-submit:hover {
        background-color: #e03126;
    }

    .side-card {
        background-color: #12141a;
        border: 1px solid #1f232d;
        border-radius: 16px;
        padding: 24px;
    }

    .side-card h3 {
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 14px;
        color: #ff3b30;
    }

    .side-card p {
        font-size: 13px;
        color: #a0a5b5;
        margin-bottom: 12px;
        line-height: 1.5;
    }

    @media (max-width: 800px) {
        .buy-grid {
            grid-template-columns: 1fr;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>
@endsection
