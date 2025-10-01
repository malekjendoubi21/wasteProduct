@extends('layouts.backoffice')

@section('title', ' - Créer une Catégorie')
@section('page-title', 'Créer une Catégorie')
@section('page-subtitle', 'Ajouter une nouvelle catégorie de produit')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Nouvelle Catégorie</h1>
            <p class="dashboard-subtitle">Créer une nouvelle catégorie de produit</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la liste</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informations de la catégorie</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('categories.store') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="label" class="form-label">Libellé <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                               id="label" name="label" value="{{ old('label') }}" 
                                               placeholder="Ex: Électronique, Alimentation, etc." required>
                                        @error('label')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Le nom de la catégorie doit être unique</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    Créer la catégorie
                                </button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
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