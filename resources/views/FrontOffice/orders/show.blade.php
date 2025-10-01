@extends('layouts.app')

@section('title', ' - Commande #'.$commande->id)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Commande #{{ $commande->id }}</h1>
        <a href="{{ route('front.orders.index') }}" class="btn btn-secondary">Retour</a>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card"><div class="card-body">
                <div class="mb-2"><strong>Date:</strong> {{ optional($commande->date)->format('Y-m-d H:i') }}</div>
                <div class="mb-2"><strong>Montant:</strong> <span class="badge bg-success">{{ number_format($commande->montant, 2, ',', ' ') }} €</span></div>
                <div class="mb-2"><strong>Produit:</strong> {{ optional($commande->product)->nom }}</div>
                <div class="mb-2"><strong>Quantité:</strong> {{ $commande->quantity }}</div>
            </div></div>
        </div>
        <div class="col-md-6">
            <div class="card"><div class="card-body">
                <h5>Livraisons</h5>
                <ul class="list-group">
                    @forelse($commande->livraisons as $liv)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span>{{ $liv->adresse_livraison }} - <span class="badge bg-info">{{ $liv->statut }}</span></span>
                                <small>{{ optional($liv->date_livraison)->format('Y-m-d') }}</small>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">Aucune livraison</li>
                    @endforelse
                </ul>
            </div></div>
        </div>
    </div>
</div>
@endsection
