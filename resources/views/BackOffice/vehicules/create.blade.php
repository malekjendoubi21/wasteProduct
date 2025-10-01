@extends('layouts.backoffice')

@section('title', ' - Nouveau Véhicule')

@section('content')
<div class="dashboard-header"><div class="dashboard-header-content"><h1 class="dashboard-title">Nouveau Véhicule</h1></div></div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('vehicules.store') }}">
@csrf
<div class="row g-3">
    <div class="col-md-4"><label class="form-label">Immatriculation</label><input type="text" name="immatriculation" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Type</label><input type="text" name="type" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Capacité</label><input type="number" min="1" name="capacite" class="form-control" required></div>
</div>
<div class="mt-4"><button class="btn btn-primary" type="submit">Enregistrer</button> <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">Annuler</a></div>
</form>
</div></div>
@endsection
