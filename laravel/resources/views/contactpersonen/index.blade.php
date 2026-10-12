@extends('layouts.app')

@section('content')
<div class="contact-page">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Contactpersonen Overzicht</h1>
            <p>Overzicht van contactpersonen van verkopers en bezoekers.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('contactpersonen.create') }}" class="btn-primary" style="text-decoration: none; padding: 10px 18px; font-weight: bold; display: inline-block;">+ Contactpersoon Toevoegen</a>
            <a href="{{ route('contactpersonen.koppelen.form') }}" class="btn-secondary" style="text-decoration: none; padding: 10px 18px; font-weight: bold; display: inline-block;">🔗 Contact Koppelen</a>
        </div>
    </div>

    <div class="card">
        <h2>Alle Contactpersonen</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Telefoonnummer</th>
                    <th>E-mailadres</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contactpersonen as $cp)
                    <tr>
                        <td>#{{ $cp->Id }}</td>
                        <td><strong>{{ $cp->Naam }}</strong></td>
                        <td>{{ $cp->Telefoonnummer }}</td>
                        <td>{{ $cp->{'E-mailadres'} }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Geen contactpersonen gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
