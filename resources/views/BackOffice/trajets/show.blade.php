@extends('layouts.backoffice')

@section('title', ' - Trajet #'.$trajet->id)

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content"><h1 class="dashboard-title">Trajet #{{ $trajet->id }}</h1></div>
    <div class="dashboard-header-actions">
        <a href="{{ route('trajets.edit', $trajet) }}" class="btn btn-warning">Modifier</a>
        <a href="{{ route('trajets.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
<div class="card"><div class="card-body">
<p><strong>Date:</strong> {{ optional($trajet->date)->format('Y-m-d') }}</p>
<p><strong>Départ:</strong> {{ $trajet->point_depart }}</p>
<p><strong>Arrivée:</strong> {{ $trajet->point_arrivee }}</p>
<p><strong>Véhicule:</strong> {{ optional($trajet->vehicule)->immatriculation }} ({{ optional($trajet->vehicule)->type }})</p>
<h5 class="mt-4">Livraisons liées</h5>
<ul class="list-group">
@forelse($trajet->livraisons as $liv)
<li class="list-group-item">#{{ $liv->id }} - {{ $liv->adresse_livraison }} ({{ $liv->statut }})</li>
@empty
<li class="list-group-item">Aucune livraison</li>
@endforelse
</ul>
</div></div>
@endsection
