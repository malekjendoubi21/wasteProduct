@extends('layouts.backoffice')

@section('title', ' - Détail de l\'événement')

@section('content')
<div class="container-fluid py-4">
    <!-- Dashboard Header -->
    <div class="dashboard-header text-center mb-5">
        <h1 class="dashboard-title text-primary fw-bold">{{ $evenement->titre }}</h1>
        <p class="dashboard-subtitle text-muted">Événement créé par <span class="text-dark fw-medium">{{ $evenement->user->name }}</span></p>
    </div>

    <!-- Event Details Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <h3 class="card-title mb-0">Détails de l'Événement</h3>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-8">
                    <p class="mb-3"><strong class="text-primary">Description :</strong> {{ $evenement->description }}</p>
                    <p class="mb-3"><strong class="text-primary">Date début :</strong> {{ $evenement->date_debut }}</p>
                    <p class="mb-3"><strong class="text-primary">Date fin :</strong> {{ $evenement->date_fin }}</p>
                    <p class="mb-3"><strong class="text-primary">Lieu :</strong> {{ $evenement->lieu }}</p>
                    <p class="mb-0"><strong class="text-primary">Status :</strong> <span class="badge bg-{{ $evenement->status === 'accepte' ? 'success' : 'warning' }}">{{ ucfirst($evenement->status) }}</span></p>
                </div>
                <div class="col-md-4 text-center">
                    @if($evenement->image)
                        <div class="card bg-light p-3">
                            <p class="text-primary mb-2"><strong>Image :</strong></p>
                            <img src="{{ asset($evenement->image) }}" alt="{{ $evenement->titre }}" class="img-fluid rounded shadow-sm" style="max-height: 200px; object-fit: cover;">
                        </div>
                    @else
                        <div class="card bg-light p-3">
                            <p class="text-muted">Aucune image disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-secondary text-white">
            <h3 class="card-title mb-0">Participants</h3>
        </div>
        <div class="card-body p-4">
            @if ($evenement->participations->isEmpty())
                <p class="text-muted text-center">Aucun participant pour cet événement.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Date de Participation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evenement->participations as $participation)
                                <tr>
                                    <td>{{ $participation->user->name ?? 'Utilisateur inconnu' }}</td>
                                    <td>{{ $participation->participated_at?->format('d/m/Y H:i') ?? 'Date inconnue' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection