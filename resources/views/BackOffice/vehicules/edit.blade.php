@extends('layouts.backoffice')

@section('title', ' - Modifier Véhicule #'.$vehicule->id)

@section('content')
<div class="dashboard-header"><div class="dashboard-header-content"><h1 class="dashboard-title">Modifier Véhicule #{{ $vehicule->id }}</h1></div></div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('vehicules.update', $vehicule) }}">
@csrf
@method('PUT')
<div class="row g-3">
    <div class="col-md-4"><label class="form-label">Immatriculation</label><input type="text" name="immatriculation" value="{{ $vehicule->immatriculation }}" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Type</label><input type="text" name="type" value="{{ $vehicule->type }}" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Capacité</label><input type="number" min="1" name="capacite" value="{{ $vehicule->capacite }}" class="form-control" required></div>
</div>
<div class="mt-4"><button class="btn btn-primary" type="submit">Enregistrer</button> <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-secondary">Annuler</a></div>
</form>
</div></div>
@endsection
