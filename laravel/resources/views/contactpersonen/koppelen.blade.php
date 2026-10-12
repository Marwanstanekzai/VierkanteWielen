@extends('layouts.app')

@section('content')
<div class="form-page">
    <div class="page-header">
        <h1>Contactpersoon aan Verkoper Koppelen</h1>
        <p>Koppel een bestaande contactpersoon aan een bestaande verkoper in het systeem.</p>
    </div>

    <div class="card form-card">
        <form action="{{ route('contactpersonen.koppelen.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="verkoper_id">1. Selecteer Verkoper *</label>
                <select id="verkoper_id" name="verkoper_id" class="form-control" required onchange="updateDetails()">
                    <option value="">-- Selecteer verkoper --</option>
                    @foreach($verkopers as $vk)
                        <option value="{{ $vk->Id }}" data-standtype="{{ $vk->StandType }}" data-status="{{ $vk->SpecialeStatus }}" data-soort="{{ $vk->VerkooptSoort }}">
                            {{ $vk->Naam }} (Standtype: {{ $vk->StandType }} - {{ $vk->SpecialeStatus }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="contactpersoon_id">2. Selecteer Contactpersoon *</label>
                <select id="contactpersoon_id" name="contactpersoon_id" class="form-control" required onchange="updateDetails()">
                    <option value="">-- Selecteer contactpersoon --</option>
                    @foreach($contactpersonen as $cp)
                        <option value="{{ $cp->Id }}" data-email="{{ $cp->{'E-mailadres'} }}" data-tel="{{ $cp->Telefoonnummer }}">
                            {{ $cp->Naam }} ({{ $cp->{'E-mailadres'} }} | {{ $cp->Telefoonnummer }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="opmerking">Opmerking (Optioneel)</label>
                <textarea id="opmerking" name="opmerking" class="form-control" rows="3" placeholder="bijv. Primair contactpersoon voor evenement 2026">{{ old('opmerking') }}</textarea>
            </div>

            <div class="summary-card" id="detailsPreview" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 16px; margin: 20px 0; color: #333333;">
                <h4 style="margin-bottom: 10px; color: #111111;">Details Selectie</h4>
                <p><strong>Geselecteerde Verkoper:</strong> <span id="verkoperInfo">Nog geen verkoper geselecteerd</span></p>
                <p><strong>Geselecteerde Contactpersoon:</strong> <span id="contactInfo">Nog geen contactpersoon geselecteerd</span></p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Koppeling Opslaan</button>
                <a href="{{ route('verkopers.index') }}" class="btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>

<script>
    function updateDetails() {
        const verkoperSelect = document.getElementById('verkoper_id');
        const contactSelect = document.getElementById('contactpersoon_id');

        const vOption = verkoperSelect.options[verkoperSelect.selectedIndex];
        const cOption = contactSelect.options[contactSelect.selectedIndex];

        if (vOption && vOption.value) {
            document.getElementById('verkoperInfo').textContent = vOption.text + ' — Verkoopt: ' + vOption.getAttribute('data-soort');
        } else {
            document.getElementById('verkoperInfo').textContent = 'Nog geen verkoper geselecteerd';
        }

        if (cOption && cOption.value) {
            document.getElementById('contactInfo').textContent = cOption.text;
        } else {
            document.getElementById('contactInfo').textContent = 'Nog geen contactpersoon geselecteerd';
        }
    }
</script>
@endsection
