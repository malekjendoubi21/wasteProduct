@extends('layouts.backoffice')

@section('title', ' - Gestion des Livraisons')

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <h1 class="dashboard-title">Gestion des Livraisons</h1>
        <p class="dashboard-subtitle">Suivre les livraisons des commandes</p>
    </div>
    <div class="dashboard-header-actions">
        <a href="{{ route('livraisons.create') }}" class="btn btn-primary">Nouvelle Livraison</a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Commande</th>
                        <th>Adresse</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Employé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($livraisons as $liv)
                        <tr>
                            <td>{{ $liv->id }}</td>
                            <td>#{{ $liv->id_commande }}</td>
                            <td>{{ $liv->adresse_livraison }}</td>
                            <td><span class="badge bg-info">{{ $liv->statut }}</span></td>
                            <td>{{ optional($liv->date_livraison)->format('Y-m-d') }}</td>
                            <td>{{ optional($liv->employe)->name }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('livraisons.show', $liv) }}" class="btn btn-sm btn-outline-success" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('livraisons.edit', $liv) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('livraisons.destroy', $liv) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette livraison ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Aucune livraison</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($livraisons->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $livraisons->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
