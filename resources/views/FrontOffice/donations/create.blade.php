@extends('layouts.app')

@section('title', 'Faire un don - ' . $product->nom)

@section('content')
    <div class="container">
        <h1>Faire un don pour : {{ $product->nom }}</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('donations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="form-group">
                <label for="association_id">Sélectionner une association</label>
                <select name="association_id" id="association_id" class="form-control" required>
                    <option value="">Choisir une association</option>
                    @if ($associations->isNotEmpty())
                        @foreach ($associations as $association)
                            <option value="{{ $association->id }}">{{ $association->name }}</option>
                        @endforeach
                    @else
                        <option value="" disabled>Aucune association disponible</option>
                    @endif
                </select>
                @error('association_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Quantité (Stock disponible : {{ $product->stock }})</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1"
                    max="{{ $product->stock }}" required>
                @error('quantity')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description (optionnel)</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Confirmer le don</button>
            <a href="{{ route('produits.show', $product) }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
