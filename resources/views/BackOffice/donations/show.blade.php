@extends('layouts.backoffice')

@section('title', 'Détails du don #' . $donation->id . ' - Admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Détails du don #{{ $donation->id }}</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informations générales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Date :</strong> {{ $donation->formatted_date }}</p>
                        <p><strong>Donateur :</strong> {{ $donation->user->name }}</p>
                        <p><strong>Association :</strong> {{ $donation->association->name }}</p>
                        <p><strong>Statut :</strong>
                            <span class="badge bg-{{ $donation->status === \App\Models\Donation::STATUS_PENDING ? 'warning' : ($donation->status === \App\Models\Donation::STATUS_ACCEPTED ? 'success' : 'info') }}">
                                {{ $donation->status_label }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        @if ($donation->description)
                            <p><strong>Description :</strong> {{ $donation->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Produits donnés</h5>
            </div>
            <div class="card-body">
                @if ($donation->items->isEmpty())
                    <p class="text-center">Aucun produit dans ce don.</p>
                @else
                    <div class="row">
                        @foreach ($donation->items as $item)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        @php
                                            \Illuminate\Support\Facades\Log::debug('Show: Product image path', [
                                                'product_id' => $item->product->id,
                                                'image' => $item->product->image ?? 'No image'
                                            ]);
                                        @endphp
                                        @if ($item->product->image && \Illuminate\Support\Facades\Storage::exists('public/' . $item->product->image))
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                 alt="{{ $item->product->nom }}"
                                                 class="img-fluid rounded mb-2"
                                                 style="max-height: 200px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/placeholder.jpg') }}"
                                                 alt="Placeholder"
                                                 class="img-fluid rounded mb-2"
                                                 style="max-height: 200px; object-fit: cover;">
                                        @endif
                                        <h6 class="card-title">{{ $item->product->nom }}</h6>
                                        <p class="card-text">Quantité : {{ $item->quantity }}</p>
                                        <p class="card-text text-muted">Stock actuel : {{ $item->product->stock }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>
    </div>
@endsection