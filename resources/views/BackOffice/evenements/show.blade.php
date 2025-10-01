@extends('layouts.backoffice')

@section('title', ' - Détail de l\'événement')

@section('content')
<div class="dashboard-header">
    <h1 class="dashboard-title">{{ $evenement->titre }}</h1>
    <p class="dashboard-subtitle">Événement créé par {{ $evenement->user->name }}</p>
</div>

<div class="dashboard-content">
    <div class="card">
        <div class="card-body">
            <p><strong>Description :</strong> {{ $evenement->description }}</p>
            <p><strong>Date début :</strong> {{ $evenement->date_debut }}</p>
            <p><strong>Date fin :</strong> {{ $evenement->date_fin }}</p>
            <p><strong>Lieu :</strong> {{ $evenement->lieu }}</p>
            <p><strong>Status :</strong> {{ ucfirst($evenement->status) }}</p>
            @if($evenement->image)
                <p><strong>Image :</strong></p>
                <img src="{{ asset($evenement->image) }}" alt="{{ $evenement->titre }}" width="150">
            @endif
        </div>
    </div>
</div>
@endsection
