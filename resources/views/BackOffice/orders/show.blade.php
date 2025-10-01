@extends('layouts.backoffice')

@section('title', ' - Détail Commande #'.$commande->id)

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <h1 class="dashboard-title">Commande #{{ $commande->id }}</h1>
        <p class="dashboard-subtitle">Client: {{ optional($commande->utilisateur)->name }}</p>
    </div>
    <div class="dashboard-header-actions">
        <a href="{{ route('orders.edit', $commande) }}" class="btn btn-warning">Modifier</a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>

<div class="dashboard-content">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informations</h3></div>
                <div class="card-body">
                    <p><strong>Date:</strong> {{ optional($commande->date)->format('Y-m-d H:i') }}</p>
                    <p><strong>Montant:</strong> {{ number_format($commande->montant, 2, ',', ' ') }} €</p>
                    <p><strong>Produit:</strong> {{ optional($commande->product)->nom }}<br>
                    <strong>Quantité:</strong> {{ $commande->quantity }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Livraisons</h3></div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($commande->livraisons as $liv)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div><strong>{{ $liv->statut }}</strong> - {{ $liv->adresse_livraison }}</div>
                                    <small>Date: {{ optional($liv->date_livraison)->format('Y-m-d') }} | Trajet: {{ optional($liv->trajet)->id }} | Véhicule: {{ optional(optional($liv->trajet)->vehicule)->immatriculation }}</small>
                                </div>
                                <a href="{{ route('livraisons.show', $liv) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                            </li>
                        @empty
                            <li class="list-group-item">Aucune livraison</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
