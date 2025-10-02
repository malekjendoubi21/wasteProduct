@extends('layouts.backoffice')

@section('title', ' - Événements')

@section('content')
<div class="dashboard-header">
    <h1 class="dashboard-title">Liste des événements</h1>
    <p class="dashboard-subtitle">Tous les événements créés par les utilisateurs</p>
</div>

<div class="dashboard-content">
    <a href="{{ route('evenements.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Créer un événement
    </a>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Créé par</th>
                    <th>Status</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evenements as $evenement)
                <tr>
                    <td>{{ $evenement->id }}</td>
                    <td>{{ $evenement->titre }}</td>
                    <td>{{ $evenement->user->name }}</td>
                    <td>
                        @if($evenement->status == 'en_attente')
                            <span class="badge bg-warning">En attente</span>
                        @elseif($evenement->status == 'accepte')
                            <span class="badge bg-success">Accepté</span>
                        @else
                            <span class="badge bg-danger">Refusé</span>
                        @endif
                    </td>
                    <td>{{ $evenement->date_debut }}</td>
                    <td>{{ $evenement->date_fin }}</td>
                    <td>
                        @if($evenement->image)
                            <img src="{{ asset($evenement->image) }}" alt="{{ $evenement->titre }}" width="150">
                        @endif
                    </td>
                    <td>
                    <a href="{{ route('evenements.show', $evenement) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('evenements.edit', $evenement) }}" class="btn btn-warning btn-sm">Modifier</a>

                    <form action="{{ route('evenements.destroy', $evenement) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet événement ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
