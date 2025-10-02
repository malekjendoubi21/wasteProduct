@extends('layouts.app')

@section('title', 'Liste des Événements')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4" style="color: #2c3e50;">Liste des Événements</h1>

        @if ($evenements->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                Aucun événement disponible pour le moment.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($evenements as $event)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $event->titre }}</h5>
                                <p class="card-text"><strong>Date :</strong> {{ $event->date_debut }} → {{ $event->date_fin }}</p>
                                <p class="card-text"><strong>Lieu :</strong> {{ $event->lieu }}</p>
                                @if ($event->image)
                                    <img src="{{ asset($event->image) }}" alt="{{ $event->titre }}" class="img-fluid rounded mb-2" style="max-height: 150px; object-fit: cover;">
                                @endif
                                <form action="{{ route('evenements.participate', $event->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @auth
                                        <button type="submit" class="btn btn-success btn-sm">Participer</button>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Connectez-vous pour participer</a>
                                    @endauth
                                </form>
                                <a href="{{ route('evenements.show', $event->id) }}" class="btn btn-outline-primary btn-sm mt-2">Voir les détails</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endsection