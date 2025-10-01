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
                <p><strong>Date:</strong> {{ optional($commande->date)->format('Y-m-d H:i') }}</p>
                <p><strong>Montant:</strong> {{ number_format($commande->montant, 2, ',', ' ') }} €</p>
                <p><strong>Produit:</strong> {{ optional($commande->product)->nom }}</p>
                <p><strong>Quantité:</strong> {{ $commande->quantity }}</p>
            </div></div>
        </div>
        <div class="col-md-6">
            <div class="card"><div class="card-body">
                <h5>Livraisons</h5>
                <ul class="list-group">
                    @forelse($commande->livraisons as $liv)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span>{{ $liv->adresse_livraison }} - {{ $liv->statut }}</span>
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
