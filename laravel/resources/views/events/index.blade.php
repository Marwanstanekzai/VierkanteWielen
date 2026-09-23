@extends('layouts.app')

@section('content')
<div class="events-page">
    <div class="page-header">
        <div>
            <h1>Evenementen Overzicht</h1>
            <p>Overzicht van evenementen, locaties en beschikbare capaciteiten.</p>
        </div>
    </div>

    <div class="card">
        <h2>Ingestelde Evenementen & Capaciteiten</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Evenement Naam</th>
                    <th>Datum</th>
                    <th>Locatie</th>
                    <th>Tickets / Tijdslot</th>
                    <th>Beschikbare Stands</th>
                </tr>
            </thead>
            <tbody>
                @forelse($evenementen as $ev)
                    <tr>
                        <td>#{{ $ev->Id }}</td>
                        <td><strong>{{ $ev->Naam }}</strong></td>
                        <td>{{ $ev->Datum }}</td>
                        <td>{{ $ev->Locatie }}</td>
                        <td>{{ $ev->AantalTicketsPerTijdslot }} tickets</td>
                        <td>{{ $ev->BeschikbareStands }} stands</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Geen evenementen ingesteld.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
