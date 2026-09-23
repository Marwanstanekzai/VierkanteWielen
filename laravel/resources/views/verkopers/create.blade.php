@extends('layouts.app')

@section('content')
<div class="form-page">
    <div class="page-header">
        <h1>Stand Huren / Verkoper Registreren</h1>
        <p>Kies een standtype (AA+, AA, A), het aantal dagen en voer je contactgegevens in.</p>
    </div>

    <div class="card form-card">
        <form action="{{ route('verkopers.store') }}" method="POST" id="verkoperForm">
            @csrf

            <h3>Verkoper Informatie</h3>
            <div class="form-group">
                <label for="naam">Shop / Verkoper Naam *</label>
                <input type="text" id="naam" name="naam" class="form-control" value="{{ old('naam') }}" required placeholder="Bijv. Kicks & Collectors HQ">
            </div>

            <div class="form-group">
                <label for="speciale_status">Speciale Status *</label>
                <select id="speciale_status" name="speciale_status" class="form-control" required>
                    <option value="Normaal">Normaal</option>
                    <option value="Goud Partner">Goud Partner</option>
                    <option value="Zilver Partner">Zilver Partner</option>
                    <option value="Brons Partner">Brons Partner</option>
                    <option value="Artist Edition">Artist Edition</option>
                </select>
            </div>

            <div class="form-group">
                <label for="verkoopt_soort">Soort Producten *</label>
                <input type="text" id="verkoopt_soort" name="verkoopt_soort" class="form-control" value="{{ old('verkoopt_soort') }}" required placeholder="Bijv. Deadstock Nike Dunks, Supreme Vintage">
            </div>

            <div class="form-group">
                <label for="stand_type">Stand Type *</label>
                <select id="stand_type" name="stand_type" class="form-control" required>
                    <option value="AA+">AA+ (€1.250,- premium locatie)</option>
                    <option value="AA">AA (€850,- centrale hal)</option>
                    <option value="A">A (€550,- standaard stand)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dagen">Aantal Dagen Huren *</label>
                <select id="dagen" name="dagen" class="form-control" required>
                    <option value="1">1 Dag (Zaterdag of Zondag)</option>
                    <option value="2">2 Dagen (Volledig Weekend)</option>
                </select>
            </div>

            <h3 class="margin-top">Contactpersoon Informatie</h3>
            <div class="form-group">
                <label for="contact_naam">Naam Contactpersoon *</label>
                <input type="text" id="contact_naam" name="contact_naam" class="form-control" value="{{ old('contact_naam') }}" required placeholder="Bijv. Michael Johnson">
            </div>

            <div class="form-group">
                <label for="contact_telefoon">Telefoonnummer *</label>
                <input type="text" id="contact_telefoon" name="contact_telefoon" class="form-control" value="{{ old('contact_telefoon') }}" required placeholder="+31612345678">
            </div>

            <div class="form-group">
                <label for="contact_email">E-mailadres Contactpersoon *</label>
                <input type="email" id="contact_email" name="contact_email" class="form-control" value="{{ old('contact_email') }}" required placeholder="m.johnson@example.com">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Stand Reservering Verzenden</button>
                <a href="{{ route('verkopers.index') }}" class="btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection
