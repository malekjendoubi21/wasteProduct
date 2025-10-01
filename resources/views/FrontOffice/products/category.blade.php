@extends('layouts.app')

@section('title', ' - ' . $categorie->label)

@section('content')
    <!-- Hero Section -->
    <section class="hero-section-small">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title">{{ $categorie->label }}</h1>
                <p class="hero-subtitle">Découvrez tous nos produits dans cette catégorie</p>
                
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('produits.index') }}">Produits</a></li>
                        <li class="breadcrumb-item active">{{ $categorie->label }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section py-5">
        <div class="container">
            <!-- Filtres -->
            <div class="filters-section mb-5">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('produits.category', $categorie) }}" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Rechercher dans {{ $categorie->label }}</label>
                                <div class="search-input-group">
                                    <i class="fas fa-search"></i>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                           class="form-control" placeholder="Nom du produit...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select">
                                    <option value="">Tous les types</option>
                                    @foreach($types as $value => $label)
                                        <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filtrer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Navigation des catégories -->
            <div class="categories-navigation mb-4">
                <h5 class="mb-3">Autres catégories:</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('produits.index') }}" class="btn btn-outline-primary btn-sm">
                        Toutes les catégories
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('produits.category', $cat) }}" 
                           class="btn {{ $cat->id == $categorie->id ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                            {{ $cat->label }} 
                            <span class="badge bg-light text-dark ms-1">{{ $cat->produits_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Informations sur la catégorie -->
            <div class="category-info mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3>Produits dans "{{ $categorie->label }}"</h3>
                        <p class="text-muted mb-0">
                            {{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} trouvé{{ $products->total() > 1 ? 's' : '' }}
                            @if(request()->hasAny(['search', 'type']))
                                avec les filtres appliqués
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        @if(request()->hasAny(['search', 'type']))
                            <a href="{{ route('produits.category', $categorie) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times"></i> Effacer les filtres
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Résultats -->
            <div class="products-results">
                @if($products->count() > 0)
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="product-card animate-fade-in">
                                    <div class="product-image">
                                        @if($product->image)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->nom }}" 
                                                 class="img-fluid">
                                        @else
                                            <div class="product-placeholder">
                                                <i class="fas fa-image"></i>
                                                <span>Aucune image</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Badge type -->
                                        <div class="product-badge">
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
                                        </div>

                                        <!-- Stock badge -->
                                        @if($product->stock <= 5)
                                            <div class="stock-badge">
                                                @if($product->stock == 0)
                                                    <span class="badge bg-danger">Rupture</span>
                                                @else
                                                    <span class="badge bg-warning">Stock faible</span>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="product-overlay">
                                            <a href="{{ route('produits.show', $product) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> Voir détails
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="product-info">
                                        <h5 class="product-title">
                                            <a href="{{ route('produits.show', $product) }}">{{ $product->nom }}</a>
                                        </h5>
                                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                                        <div class="product-footer">
                                            <div class="product-price">
                                                <span class="price">{{ $product->prix_formatte }}</span>
                                            </div>
                                            <div class="product-stock">
                                                @if($product->stock > 0)
                                                    <span class="stock-available">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                        {{ $product->stock }} en stock
                                                    </span>
                                                @else
                                                    <span class="stock-unavailable">
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                        Rupture de stock
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <!-- État vide -->
                    <div class="empty-state text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-4"></i>
                        <h3>Aucun produit trouvé</h3>
                        <p class="text-muted mb-4">
                            @if(request()->hasAny(['search', 'type']))
                                Aucun produit ne correspond à vos critères de recherche dans la catégorie "{{ $categorie->label }}".
                            @else
                                Il n'y a actuellement aucun produit dans la catégorie "{{ $categorie->label }}".
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'type']))
                            <a href="{{ route('produits.category', $categorie) }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Voir tous les produits de cette catégorie
                            </a>
                        @else
                            <a href="{{ route('produits.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Voir tous les produits
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section bg-primary text-white py-5">
        <div class="container text-center">
            <h2 class="mb-3">Vous avez des produits de type "{{ $categorie->label }}" à recycler ?</h2>
            <p class="lead mb-4">Rejoignez notre communauté et donnez une seconde vie à vos objets</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                <i class="fas fa-user-plus"></i> Nous rejoindre
            </a>
        </div>
    </section>
@endsection

@push('styles')
<style>
.hero-section-small {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 100px 0 60px;
    position: relative;
    overflow: hidden;
}

.hero-section-small .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
}

.hero-section-small .hero-content {
    position: relative;
    z-index: 2;
}

.hero-section-small .hero-title {
    font-size: 3rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
}

.hero-section-small .hero-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
}

.breadcrumb {
    background: none;
    padding: 0;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.search-input-group {
    position: relative;
}

.search-input-group i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 5;
}

.search-input-group .form-control {
    padding-left: 45px;
}

.category-info {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.product-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #6c757d;
}

.product-placeholder i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 2;
}

.stock-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-info {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.product-title a {
    color: #333;
    text-decoration: none;
}

.product-title a:hover {
    color: #667eea;
}

.product-description {
    color: #6c757d;
    font-size: 0.9rem;
    flex: 1;
    margin-bottom: 1rem;
}

.product-footer {
    margin-top: auto;
}

.product-price .price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #28a745;
}

.product-stock {
    margin-top: 0.5rem;
    font-size: 0.85rem;
}

.stock-available {
    color: #28a745;
}

.stock-unavailable {
    color: #dc3545;
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.empty-state {
    background: white;
    border-radius: 15px;
    padding: 3rem;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
@endpush