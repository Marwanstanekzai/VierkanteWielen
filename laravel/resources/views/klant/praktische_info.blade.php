@extends('layouts.klant')

@section('content')
<div class="info-container">
    <div class="page-header">
        <h1 class="page-title">PRAKTISCHE INFORMATIE</h1>
        <p class="page-subtitle">Sneakerness Rotterdam / Van Nellefabriek</p>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <h2>📍 Locatie & Adres</h2>
            <p><strong>Van Nellefabriek Rotterdam</strong></p>
            <p>Van Nelleweg 1, 3044 BC Rotterdam</p>
            <p>De Van Nellefabriek is uitstekend bereikbaar via de A13/A20 en openbaar vervoer.</p>
        </div>

        <div class="info-card">
            <h2>🚗 Parkeren & OV</h2>
            <p>Er is ruime parkeergelegenheid op het terrein van de Van Nellefabriek.</p>
            <p>Vanaf Rotterdam Centraal rijdt er elke 10 minuten een rechtstreekse shuttlebus naar het evenementterrein.</p>
        </div>

        <div class="info-card">
            <h2>🕒 Openingstijden</h2>
            <p><strong>Zaterdag 25 Mei 2026:</strong> 10:00 - 18:00 uur</p>
            <p><strong>Zondag 26 Mei 2026:</strong> 10:00 - 17:00 uur</p>
            <p>Vroege vogels met Early Bird tickets krijgen om 10:00 uur al toegang.</p>
        </div>

        <div class="info-card">
            <h2>💳 Betalen & Kassa</h2>
            <p>Pin only op het terrein voor food & drinks. Verkopers accepteren zowel cash als pin / Tikkie.</p>
            <p>Er is een bewaakte garderobe en locker-service aanwezig.</p>
        </div>
    </div>
</div>

<style>
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .info-card {
        background-color: #12141a;
        border: 1px solid #1f232d;
        border-radius: 16px;
        padding: 30px;
    }

    .info-card h2 {
        font-size: 18px;
        font-weight: 800;
        color: #ff3b30;
        margin-bottom: 14px;
    }

    .info-card p {
        font-size: 14px;
        color: #a0a5b5;
        margin-bottom: 10px;
        line-height: 1.6;
    }
</style>
@endsection
