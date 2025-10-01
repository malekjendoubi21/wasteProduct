@extends('layouts.backoffice')

@section('title', ' - Détails de la Catégorie')
@section('page-title', 'Détails de la Catégorie')
@section('page-subtitle', 'Informations détaillées de la catégorie')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">{{ $categorie->label }}</h1>
            <p class="dashboard-subtitle">Détails de la catégorie et produits associés</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la liste</span>
            </a>
            <a href="{{ route('categories.edit', $categorie) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                <span>Modifier</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Informations de la catégorie -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informations</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-group">
                            <label>ID</label>
                            <p>{{ $categorie->id }}</p>
                        </div>
                        
                        <div class="info-group">
                            <label>Libellé</label>
                            <p>{{ $categorie->label }}</p>
                        </div>
                        
                        <div class="info-group">
                            <label>Nombre de produits</label>
                            <p>
                                <span class="badge bg-info">{{ $categorie->produits->count() }} produits</span>
                            </p>
                        </div>
                        
                        <div class="info-group">
                            <label>Date de création</label>
                            <p>{{ $categorie->date_creation_formattee }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des produits -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produits de cette catégorie</h3>
                        <div class="card-actions">
                            <a href="{{ route('products.create') }}?categorie_id={{ $categorie->id }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i>
                                Ajouter un produit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($categorie->produits->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prix</th>
                                            <th>Stock</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categorie->produits as $product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($product->image)
                                                            <img src="{{ $product->image_url }}" alt="{{ $product->nom }}" 
                                                                 class="avatar-sm me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                                        @else
                                                            <div class="avatar-sm bg-secondary me-2">
                                                                <i class="fas fa-box"></i>
                                                            </div>
                                                        @endif
                                                        <span>{{ Str::limit($product->nom, 30) }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $product->prix_formatte }}</td>
                                                <td>
                                                    @if($product->stock > 0)
                                                        <span class="badge bg-success">{{ $product->stock }}</span>
                                                    @else
                                                        <span class="badge bg-danger">Rupture</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @switch($product->type)
                                                        @case('recyclé')
                                                            <span class="badge bg-success">Recyclé</span>
                                                            @break
                                                        @case('alimentaire')
                                                            <span class="badge bg-info">Alimentaire</span>
                                                            @break
                                                        @case('non_recyclé')
                                                            <span class="badge bg-warning">Non recyclé</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state text-center py-4">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h5>Aucun produit dans cette catégorie</h5>
                                <p class="text-muted">Commencez par ajouter des produits à cette catégorie</p>
                                <a href="{{ route('products.create') }}?categorie_id={{ $categorie->id }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Ajouter un produit
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection