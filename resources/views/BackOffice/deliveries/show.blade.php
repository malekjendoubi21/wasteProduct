@extends('layouts.backoffice')

@section('title', ' - Livraison')

@section('content')
<div class="dashboard-header">
  <div class="dashboard-header-content">
    <h1 class="dashboard-title">Livraison #{{ $livraison->id }}</h1>
  </div>
</div>
<div class="dashboard-content">
  <div class="card">
    <div class="card-body">
      <div class="mb-2"><strong>Commande:</strong> #{{ $livraison->commande_id }}</div>
      <div class="mb-2"><strong>Adresse:</strong> {{ $livraison->adresse_livraison }}</div>
      <div class="mb-2"><strong>Date:</strong> {{ optional($livraison->date_livraison ?? $livraison->created_at)->format('Y-m-d H:i') }}</div>
      <div class="mb-2"><strong>Statut:</strong> {{ $livraison->statut }}</div>
      <div class="mb-2"><strong>Trajet:</strong> {{ optional($livraison->trajet)->point_depart }} → {{ optional($livraison->trajet)->point_arrivee }}</div>
      <div class="mb-4"><strong>Employé:</strong> {{ optional($livraison->employe)->name ?? '—' }}</div>
      <a class="btn btn-primary" href="{{ route('livraisons.edit', $livraison) }}">Editer</a>
      <a class="btn" href="{{ route('livraisons.index') }}">Retour</a>
    </div>
  </div>
</div>
@endsection
