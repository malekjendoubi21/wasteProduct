@extends('layouts.backoffice')

@section('title', ' - Modifier le Produit')
@section('page-title', 'Modifier le Produit')
@section('page-subtitle', 'Modifier les informations du produit')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Modifier le Produit</h1>
            <p class="dashboard-subtitle">Modifier "{{ $product->nom }}"</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la liste</span>
            </a>
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-info">
                <i class="fas fa-eye"></i>
                <span>Voir</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informations du produit</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nom" class="form-label">Nom du produit <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                               id="nom" name="nom" value="{{ old('nom', $product->nom) }}" 
                                               placeholder="Ex: Bouteille en plastique recyclé" required>
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="4" 
                                                  placeholder="Décrivez le produit..." required>{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prix_base" class="form-label">Prix (€) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" min="0" class="form-control @error('prix_base') is-invalid @enderror" 
                                               id="prix_base" name="prix_base" value="{{ old('prix_base', $product->prix_base) }}" 
                                               placeholder="0.00" required>
                                        @error('prix_base')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                        <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" 
                                               id="stock" name="stock" value="{{ old('stock', $product->stock) }}" 
                                               placeholder="0" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="">Sélectionnez un type</option>
                                            @foreach($types as $value => $label)
                                                <option value="{{ $value }}" {{ old('type', $product->type) == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                        <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id" name="categorie_id" required>
                                            <option value="">Sélectionnez une catégorie</option>
                                            @foreach($categories as $categorie)
                                                <option value="{{ $categorie->id }}" {{ old('categorie_id', $product->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                                    {{ $categorie->label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categorie_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image" class="form-label">Image du produit</label>
                                        @if($product->image)
                                            <div class="current-image mb-2">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->nom }}" 
                                                     style="max-width: 150px; height: auto; border-radius: 8px;">
                                                <p class="text-muted small">Image actuelle</p>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Formats acceptés: JPEG, PNG, JPG, GIF. Taille max: 2MB. Laissez vide pour conserver l'image actuelle.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i>
                                    Mettre à jour
                                </button>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i>
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection