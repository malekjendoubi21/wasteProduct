@extends('layouts.app')

@section('title', $evenement->titre)

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h1>{{ $evenement->titre }}</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="lead"><strong>Description :</strong> {{ $evenement->description }}</p>
                        <p class="text-muted"><strong>Date :</strong> {{ $evenement->date_debut }} → {{ $evenement->date_fin }}</p>
                        <p class="text-muted"><strong>Lieu :</strong> {{ $evenement->lieu }}</p>
                        <form action="{{ route('evenements.participate', $evenement->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @auth
                                <button type="submit" class="btn btn-success btn-sm">Participer</button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Connectez-vous pour participer</a>
                            @endauth
                        </form>
                        <a href="{{ route('evenements.listes') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
                    </div>
                    <div class="col-md-4">
                        @if ($evenement->image)
                            <img src="{{ asset($evenement->image) }}" alt="{{ $evenement->titre }}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                        @else
                            <p class="text-center text-muted">Aucune image disponible</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

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