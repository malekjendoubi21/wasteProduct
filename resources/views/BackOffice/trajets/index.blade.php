@extends('layouts.backoffice')

@section('title', ' - Trajets')

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content"><h1 class="dashboard-title">Trajets</h1></div>
    <div class="dashboard-header-actions"><a href="{{ route('trajets.create') }}" class="btn btn-primary">Nouveau</a></div>
</div>
<div class="card"><div class="card-body">
    <table class="table">
        <thead><tr><th>ID</th><th>Date</th><th>Départ</th><th>Arrivée</th><th>Véhicule</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($trajets as $trj)
            <tr>
                <td>{{ $trj->id }}</td>
                <td>{{ optional($trj->date)->format('Y-m-d') }}</td>
                <td>{{ $trj->point_depart }}</td>
                <td>{{ $trj->point_arrivee }}</td>
                <td>{{ optional($trj->vehicule)->immatriculation }}</td>
                <td>
                    <a href="{{ route('trajets.show', $trj) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                    <a href="{{ route('trajets.edit', $trj) }}" class="btn btn-sm btn-outline-warning">Modifier</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Aucun trajet</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($trajets->hasPages())
        <div class="d-flex justify-content-center mt-4">{{ $trajets->links() }}</div>
    @endif
</div></div>
@endsection
