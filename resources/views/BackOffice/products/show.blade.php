@extends('layouts.backoffice')

@section('title', 'Détail produit')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('produits.index') }}" class="btn">← Retour</a>
    </div>
    <div class="card">
        <div class="card-body">
            <h2 class="h3 mb-2">{{ $produit->nom }}</h2>
            <p class="text-muted">Catégorie: {{ optional($produit->categorie)->libelle }} | Type: {{ $produit->type }}</p>
            @if($produit->image_url)
                <div class="mt-2">
                    <img src="{{ $produit->image_url }}" alt="{{ $produit->nom }}" style="max-height:240px">
                </div>
            @endif
            <p class="mt-4">{{ $produit->description }}</p>
            <div class="mt-4">Prix de base: <strong>{{ number_format($produit->prix_base, 2) }} DT</strong></div>
            <div>Stock: <strong>{{ $produit->stock }}</strong></div>
        </div>
    </div>
</div>
@endsection
