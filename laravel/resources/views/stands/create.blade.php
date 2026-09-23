@extends('layouts.app')

@section('content')
<div class="form-page">
    <div class="page-header">
        <h1>Stand Instellen / Toevoegen</h1>
        <p>Stel een nieuwe stand in of koppel een bestaande verkoper.</p>
    </div>

    <div class="card form-card">
        <form action="{{ route('stands.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="stand_type">Stand Type *</label>
                <select id="stand_type" name="stand_type" class="form-control" required>
                    <option value="AA+">AA+ (Premium Hoofdingang)</option>
                    <option value="AA">AA (Centrale Hal)</option>
                    <option value="A">A (Standaard Beursstand)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="prijs">Huurprijs (€) *</label>
                <input type="number" step="0.01" id="prijs" name="prijs" class="form-control" value="{{ old('prijs', 550.00) }}" required>
            </div>

            <div class="form-group">
                <label for="verhuurd_status">Status *</label>
                <select id="verhuurd_status" name="verhuurd_status" class="form-control" required>
                    <option value="Beschikbaar">Beschikbaar</option>
                    <option value="Verhuurd">Verhuurd</option>
                    <option value="Gereserveerd">Gereserveerd</option>
                </select>
            </div>

            <div class="form-group">
                <label for="verkoopster_id">Wijs toe aan Verkoper (Optioneel)</label>
                <select id="verkoopster_id" name="verkoopster_id" class="form-control">
                    <option value="">-- Geen verkoper toegewezen --</option>
                    @foreach($verkopers as $vk)
                        <option value="{{ $vk->Id }}">{{ $vk->Naam }} ({{ $vk->StandType }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Stand Opslaan</button>
                <a href="{{ route('stands.index') }}" class="btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection
