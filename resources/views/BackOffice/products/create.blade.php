@extends('layouts.backoffice')

@section('title', 'Créer un produit')

@section('content')
<div class="container">
    <h1 class="h2 mb-4">Nouveau produit</h1>
    <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" class="form-control @error('nom') is-invalid @enderror" required>
                    @error('nom')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-control form-select @error('categorie_id') is-invalid @enderror" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" @selected(old('categorie_id')==$id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('categorie_id')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="form-label">Prix de base</label>
                    <input type="number" step="0.01" name="prix_base" value="{{ old('prix_base') }}" class="form-control @error('prix_base') is-invalid @enderror" required>
                    @error('prix_base')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock',0) }}" class="form-control @error('stock') is-invalid @enderror" required>
                    @error('stock')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control form-select @error('type') is-invalid @enderror" required>
                        <option value="recycle" @selected(old('type')==='recycle')>Recyclé</option>
                        <option value="non_recycle" @selected(old('type')==='non_recycle')>Non Recyclé</option>
                    </select>
                    @error('type')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control form-textarea @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                    @error('image')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
