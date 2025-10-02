@extends('layouts.app')

@section('title', ' - Modifier Événement')

@section('content')
<div class="container py-5">
    <h2>Modifier l'Événement</h2>

    <form action="{{ route('evenements.update', $evenement) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre', $evenement->titre) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $evenement->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date Début</label>
            <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ old('date_debut', $evenement->date_debut) }}" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date Fin</label>
            <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ old('date_fin', $evenement->date_fin) }}" required>
        </div>

        <div class="mb-3">
            <label for="lieu" class="form-label">Lieu</label>
            <input type="text" name="lieu" id="lieu" class="form-control" value="{{ old('lieu', $evenement->lieu) }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (optionnelle)</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($evenement->image)
                <p class="mt-2">Image actuelle :</p>
                <img src="{{ asset($evenement->image) }}" alt="Image Événement" style="max-width: 200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-warning">Mettre à jour</button>
    </form>
</div>
@endsection
