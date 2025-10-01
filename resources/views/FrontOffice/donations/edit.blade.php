@extends('layouts.app')

@section('title', 'Modifier le don - ' . $donation->items->first()->product->nom ?? 'Don')

@section('content')
    <div class="container">
        <h1>Modifier le don pour : {{ $donation->items->first()->product->nom ?? 'Produit' }}</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('donations.update', $donation) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="donation_id" value="{{ $donation->id }}">

            <div class="form-group">
                <label for="association_id">Sélectionner une association</label>
                <select name="association_id" id="association_id" class="form-control" required>
                    <option value="">Choisir une association</option>
                    @if ($associations->isNotEmpty())
                        @foreach ($associations as $association)
                            <option value="{{ $association->id }}" {{ $association->id == $donation->association_id ? 'selected' : '' }}>
                                {{ $association->name }}
                            </option>
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
                <label for="quantity">Quantité (Stock disponible : {{ $donation->items->first()->product->stock + $donation->items->first()->quantity ?? 0 }})</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity', $donation->items->first()->quantity ?? 1) }}" required>
                @error('quantity')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description (optionnel)</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $donation->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning">Modifier le don</button>
            <a href="{{ route('donations.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection