@extends('layouts.backoffice')

@section('title', ' - Modifier Trajet #'.$trajet->id)

@section('content')
<div class="dashboard-header"><div class="dashboard-header-content"><h1 class="dashboard-title">Modifier Trajet #{{ $trajet->id }}</h1></div></div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('trajets.update', $trajet) }}">
@csrf
@method('PUT')
<div class="row g-3">
    <div class="col-md-3"><label class="form-label">Date</label><input type="date" name="date" class="form-control" value="{{ optional($trajet->date)->format('Y-m-d') }}" required></div>
    <div class="col-md-3"><label class="form-label">Point départ</label><input type="text" name="point_depart" class="form-control" value="{{ $trajet->point_depart }}" required></div>
    <div class="col-md-3"><label class="form-label">Point arrivée</label><input type="text" name="point_arrivee" class="form-control" value="{{ $trajet->point_arrivee }}" required></div>
    <div class="col-md-3"><label class="form-label">Véhicule</label>
        <select name="id_vehicule" class="form-select" required>
            @foreach($vehicules as $v)
                <option value="{{ $v->id }}" {{ $trajet->id_vehicule == $v->id ? 'selected' : '' }}>{{ $v->immatriculation }} ({{ $v->type }})</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-4"><button class="btn btn-primary" type="submit">Enregistrer</button> <a href="{{ route('trajets.show', $trajet) }}" class="btn btn-secondary">Annuler</a></div>
</form>
</div></div>
@endsection
