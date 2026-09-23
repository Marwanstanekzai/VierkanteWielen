@extends('layouts.app')

@section('content')
<div class="verkopers-page">
    <div class="page-header">
        <div>
            <h1>Verkopers Overzicht</h1>
            <p>Overzicht van geregistreerde verkopers en hun gekoppelde contactpersonen.</p>
        </div>
    </div>

    <div class="card">
        <h2>Geregistreerde Verkopers</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Verkoper / Shop Naam</th>
                    <th>Speciale Status</th>
                    <th>Verkoopt Soort</th>
                    <th>StandType</th>
                    <th>Dagen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($verkopers as $vk)
                    <tr>
                        <td>#{{ $vk->Id }}</td>
                        <td><strong>{{ $vk->Naam }}</strong></td>
                        <td><span class="badge badge-warning">{{ $vk->SpecialeStatus }}</span></td>
                        <td>{{ $vk->VerkooptSoort }}</td>
                        <td><span class="badge badge-info">{{ $vk->StandType }}</span></td>
                        <td>{{ $vk->Dagen }} dag(en)</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Geen verkopers gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card margin-top">
        <h2>Contactpersonen per Verkoper (Via Stored Procedure / Joins)</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Relatie ID</th>
                    <th>Verkoper Naam</th>
                    <th>StandType</th>
                    <th>Contactpersoon</th>
                    <th>Telefoonnummer</th>
                    <th>E-mailadres</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contactPerVerkoper as $cpv)
                    <tr>
                        <td>#{{ $cpv->RelatieId }}</td>
                        <td><strong>{{ $cpv->VerkoperNaam }}</strong></td>
                        <td><span class="badge badge-info">{{ $cpv->StandType }}</span></td>
                        <td>{{ $cpv->ContactNaam }}</td>
                        <td>{{ $cpv->Telefoonnummer }}</td>
                        <td>{{ $cpv->ContactEmail }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Geen gekoppelde contactpersonen gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
