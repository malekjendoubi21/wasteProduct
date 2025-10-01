@extends('layouts.backoffice')

@section('title', ' - Livraison #'.$livraison->id)

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <h1 class="dashboard-title">Livraison #{{ $livraison->id }}</h1>
    </div>
    <div class="dashboard-header-actions">
        <a href="{{ route('livraisons.edit', $livraison) }}" class="btn btn-warning">Modifier</a>
        <a href="{{ route('livraisons.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <p><strong>Commande:</strong> #{{ $livraison->id_commande }}</p>
        <p><strong>Adresse:</strong> {{ $livraison->adresse_livraison }}</p>
        <p><strong>Statut:</strong> {{ $livraison->statut }}</p>
        <p><strong>Date:</strong> {{ optional($livraison->date_livraison)->format('Y-m-d') }}</p>
        <p><strong>Trajet:</strong> {{ optional($livraison->trajet)->id }} (Véhicule: {{ optional(optional($livraison->trajet)->vehicule)->immatriculation }})</p>
        <p><strong>Employé:</strong> {{ optional($livraison->employe)->name }}</p>
    </div>
</div>
@endsection
