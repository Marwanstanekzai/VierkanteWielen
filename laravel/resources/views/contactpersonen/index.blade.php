@extends('layouts.app')

@section('content')
<div class="contact-page">
    <div class="page-header">
        <div>
            <h1>Contactpersonen Overzicht</h1>
            <p>Overzicht van contactpersonen van verkopers en bezoekers.</p>
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
