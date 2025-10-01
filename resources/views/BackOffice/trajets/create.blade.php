@extends('layouts.backoffice')

@section('title', ' - Nouveau Trajet')

@section('content')
<div class="dashboard-header"><div class="dashboard-header-content"><h1 class="dashboard-title">Nouveau Trajet</h1></div></div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('trajets.store') }}">
@csrf
<div class="row g-3">
    <div class="col-md-3"><label class="form-label">Date</label><input type="date" name="date" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">Point départ</label><input type="text" name="point_depart" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">Point arrivée</label><input type="text" name="point_arrivee" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">Véhicule</label>
        <select name="id_vehicule" class="form-select" required>
            @foreach($vehicules as $v)
                <option value="{{ $v->id }}">{{ $v->immatriculation }} ({{ $v->type }})</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-4"><button class="btn btn-primary" type="submit">Enregistrer</button> <a href="{{ route('trajets.index') }}" class="btn btn-secondary">Annuler</a></div>
</form>
</div></div>
@endsection
