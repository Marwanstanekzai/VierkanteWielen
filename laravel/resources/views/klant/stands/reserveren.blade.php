@extends('layouts.klant')

@section('content')
<div class="stand-reserve-wrapper">
    <div class="page-header">
        <h1 class="page-title">STAND RESERVEREN VOOR VERKOPERS</h1>
        <p class="page-subtitle">Sneakerness Rotterdam 2026 / Van Nellefabriek</p>
    </div>

    <div class="reserve-grid">
        <!-- FORMULIER -->
        <div class="form-card">
            <h2>Vul uw Verkoper- & Standgegevens in</h2>

            <form action="{{ route('klant.stands.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="evenement_id" class="form-label">1. Kies Evenement</label>
                    <select name="evenement_id" id="evenement_id" class="form-control" required>
                        <option value="">-- Selecteer evenement --</option>
                        @foreach ($evenementen as $evenement)
                            <option value="{{ $evenement->Id }}" {{ old('evenement_id') == $evenement->Id ? 'selected' : '' }}>
                                {{ $evenement->Naam }} ({{ \Carbon\Carbon::parse($evenement->Datum)->format('d-m-Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="stand_type" class="form-label">2. Kies Stand Type</label>
                        <select name="stand_type" id="stand_type" class="form-control" required>
                            <option value="">-- Selecteer type --</option>
                            <option value="AA+" {{ old('stand_type') == 'AA+' ? 'selected' : '' }}>Stand Type AA+ (Hoofdingang - Maximaal zicht)</option>
                            <option value="AA" {{ old('stand_type') == 'AA' ? 'selected' : '' }}>Stand Type AA (Centrale Hal)</option>
                            <option value="A" {{ old('stand_type') == 'A' ? 'selected' : '' }}>Stand Type A (Exhibition Zone)</option>
                        </select>
                    </div>

                    <div class="form-group half">
                        <label for="dagen" class="form-label">3. Huurperiode (Dagen)</label>
                        <select name="dagen" id="dagen" class="form-control" required>
                            <option value="2" {{ old('dagen', '2') == '2' ? 'selected' : '' }}>2 Dagen (Volledig Weekend: Zaterdag & Zondag)</option>
                            <option value="1" {{ old('dagen') == '1' ? 'selected' : '' }}>1 Dag (Alleen Zaterdag)</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="shop_naam" class="form-label">4. Shop / Bedrijfsnaam</label>
                        <input type="text" name="shop_naam" id="shop_naam" class="form-control" value="{{ old('shop_naam') }}" required placeholder="bijv. Grail Store Rotterdam">
                    </div>

                    <div class="form-group half">
                        <label for="verkoopt_soort" class="form-label">5. Soort Artikelen / Merken</label>
                        <input type="text" name="verkoopt_soort" id="verkoopt_soort" class="form-control" value="{{ old('verkoopt_soort') }}" required placeholder="bijv. Vintage Apparel & Retros">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="contact_naam" class="form-label">6. Naam Contactpersoon</label>
                        <input type="text" name="contact_naam" id="contact_naam" class="form-control" value="{{ old('contact_naam') }}" required placeholder="Naam vertegenwoordiger">
                    </div>

                    <div class="form-group half">
                        <label for="contact_telefoon" class="form-label">7. Telefoonnummer</label>
                        <input type="text" name="contact_telefoon" id="contact_telefoon" class="form-control" value="{{ old('contact_telefoon') }}" required placeholder="+31612345678">
                    </div>
                </div>

                <div class="form-group">
                    <label for="contact_email" class="form-label">8. E-mailadres Contactpersoon</label>
                    <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email') }}" required placeholder="contact@uwshop.nl">
                </div>

                <button type="submit" class="btn-reserve-submit">
                    <span>BEVESTIG STAND RESERVERING</span>
                </button>
            </form>
        </div>

        <!-- ZIJBALK MET STANDTYPES OVERZICHT -->
        <div class="info-sidebar">
            <div class="side-card">
                <h3>🎪 Beschikbare Standtypes & Tarieven</h3>

                <div class="stand-type-item">
                    <strong>Type AA+</strong>
                    <p>Primair zicht bij de hoofdingang. Inclusief elektra, verlichting en 4 crew passes.</p>
                </div>

                <div class="stand-type-item">
                    <strong>Type AA</strong>
                    <p>Centrale beurshal met hoge bezoekersstroom. Inclusief elektra en 3 crew passes.</p>
                </div>

                <div class="stand-type-item">
                    <strong>Type A</strong>
                    <p>Gezellige beurszone voor vintage, art & customizing. Inclusief 2 crew passes.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .reserve-grid {
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

    .btn-reserve-submit {
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
        margin-top: 10px;
        transition: background-color 0.2s;
    }

    .btn-reserve-submit:hover {
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
        margin-bottom: 18px;
        color: #ff3b30;
    }

    .stand-type-item {
        border-bottom: 1px solid #1f232d;
        padding-bottom: 14px;
        margin-bottom: 14px;
    }

    .stand-type-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .stand-type-item strong {
        font-size: 15px;
        color: #ffffff;
        display: block;
        margin-bottom: 4px;
    }

    .stand-type-item p {
        font-size: 13px;
        color: #a0a5b5;
        line-height: 1.4;
    }

    @media (max-width: 800px) {
        .reserve-grid {
            grid-template-columns: 1fr;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>
@endsection
