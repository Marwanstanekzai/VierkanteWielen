@extends('layouts.app')

@section('content')
<div class="form-page">
    <div class="page-header">
        <h1>Contactpersoon Toevoegen</h1>
        <p>Voer de gegevens in van een nieuwe contactpersoon.</p>
    </div>

    <div class="card form-card">
        <form action="{{ route('contactpersonen.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="naam">Volledige Naam *</label>
                <input type="text" id="naam" name="naam" class="form-control" value="{{ old('naam') }}" required placeholder="Bijv. Lisa van den Berg">
            </div>

            <div class="form-group">
                <label for="telefoonnummer">Telefoonnummer *</label>
                <input type="text" id="telefoonnummer" name="telefoonnummer" class="form-control" value="{{ old('telefoonnummer') }}" required placeholder="+31687654321">
            </div>

            <div class="form-group">
                <label for="emailadres">E-mailadres *</label>
                <input type="email" id="emailadres" name="emailadres" class="form-control" value="{{ old('emailadres') }}" required placeholder="lisa@example.com">
            </div>

            <div class="form-group">
                <label for="verkoper_id">Koppel optioneel aan Verkoper</label>
                <select id="verkoper_id" name="verkoper_id" class="form-control">
                    <option value="">-- Geen verkoper koppeling --</option>
                    @foreach($verkopers as $vk)
                        <option value="{{ $vk->Id }}">{{ $vk->Naam }} ({{ $vk->StandType }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Contactpersoon Opslaan</button>
                <a href="{{ route('contactpersonen.index') }}" class="btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection
