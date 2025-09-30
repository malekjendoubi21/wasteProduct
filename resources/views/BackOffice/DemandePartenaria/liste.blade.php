@extends('layouts.backoffice')

@section('title', ' - Demandes Partenariat')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Demandes de Partenariat</h1>
            <p class="dashboard-subtitle">Gérez les demandes de partenariat soumises par les organisations</p>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Toutes les demandes</h3>
                <div class="card-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Rechercher une demande..." class="search-input">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom Organisation</th>
                                <th>Type</th>
                                <th>Secteur</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Adresse</th>
                                <th>Logo</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($demandes as $demande)
                                <tr>
                                    <td>{{ $demande->id }}</td>
                                    <td>{{ $demande->nom_organisation }}</td>
                                    <td>{{ $demande->type_organisation }}</td>
                                    <td>{{ $demande->secteur_activite }}</td>
                                    <td>{{ $demande->email_contact }}</td>
                                    <td>{{ $demande->telephone_contact }}</td>
                                    <td>{{ $demande->adresse }}</td>
                                    <td>
                                        @if($demande->logo)
                                            @php
                                                // Supprime le préfixe 'storage/' si présent pour éviter la duplication
                                                $logoPath = str_replace('storage/', '', $demande->logo);
                                            @endphp
                                            <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo" width="50" 
                                                 onerror="this.src='{{ asset('images/default-logo.png') }}'; this.alt='Logo par défaut';">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($demande->statut == 'en_attente')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($demande->statut == 'accepte')
                                            <span class="badge bg-success">Accepté</span>
                                        @else
                                            <span class="badge bg-danger">Refusé</span>
                                        @endif
                                    </td>
                                    <td>{{ $demande->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('demande.show', $demande->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                        <form action="{{ route('demande.updateStatus', $demande->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="statut" value="accepte" class="btn btn-sm btn-outline-success">Accepter</button>
                                            <button type="submit" name="statut" value="refuse" class="btn btn-sm btn-outline-danger">Refuser</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($demandes->isEmpty())
                        <p class="text-center mt-4">Aucune demande de partenariat pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection