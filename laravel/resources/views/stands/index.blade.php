@extends('layouts.app')

@section('content')
<div class="stands-page">
    <div class="page-header">
        <div>
            <h1>Stands Overzicht</h1>
            <p>Overzicht van alle beschikbare en verhuurde beursstands op Sneakerness.</p>
        </div>
    </div>

    <div class="card">
        <h2>Stands Overzicht</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Stand ID</th>
                    <th>Stand Type</th>
                    <th>Huurprijs</th>
                    <th>Verhuurd Status</th>
                    <th>Toegewezen Verkoper</th>
                    <th>Verkoop Soort</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stands as $st)
                    <tr>
                        <td>#{{ $st->StandId }}</td>
                        <td><span class="badge badge-info">{{ $st->StandType }}</span></td>
                        <td>€{{ number_format($st->Prijs, 2) }}</td>
                        <td>
                            @if($st->VerhuurdStatus === 'Verhuurd')
                                <span class="badge badge-danger">Verhuurd</span>
                            @elseif($st->VerhuurdStatus === 'Beschikbaar')
                                <span class="badge badge-success">Beschikbaar</span>
                            @else
                                <span class="badge badge-warning">{{ $st->VerhuurdStatus }}</span>
                            @endif
                        </td>
                        <td><strong>{{ $st->VerkoperNaam ?? 'Nog niet toegewezen' }}</strong></td>
                        <td>{{ $st->VerkooptSoort ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Geen stands gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
