@extends('layouts.backoffice')

@section('title', ' - Véhicule #'.$vehicule->id)

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content"><h1 class="dashboard-title">Véhicule #{{ $vehicule->id }}</h1></div>
    <div class="dashboard-header-actions">
        <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning">Modifier</a>
        <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
<div class="card"><div class="card-body">
<p><strong>Immatriculation:</strong> {{ $vehicule->immatriculation }}</p>
<p><strong>Type:</strong> {{ $vehicule->type }}</p>
<p><strong>Capacité:</strong> {{ $vehicule->capacite }}</p>
<h5 class="mt-4">Trajets</h5>
<ul class="list-group">
@forelse($vehicule->trajets as $t)
<li class="list-group-item">#{{ $t->id }} - {{ $t->point_depart }} ➜ {{ $t->point_arrivee }} ({{ optional($t->date)->format('Y-m-d') }})</li>
@empty
<li class="list-group-item">Aucun trajet</li>
@endforelse
</ul>
</div></div>
@endsection
