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
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    padding: 100px 0 60px;
    position: relative;
    overflow: hidden;
}

.hero-section-small::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
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
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.hero-section-small .hero-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
}

.breadcrumb {
    background: none;
    padding: 0;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-item a:hover {
    color: white;
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
    color: #22c55e;
    z-index: 5;
}

.search-input-group .form-control {
    padding-left: 45px;
    border: 2px solid rgba(34, 197, 94, 0.2);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.search-input-group .form-control:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.25);
}

.filters-section .card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(34, 197, 94, 0.1);
}

.filters-section .form-select {
    border: 2px solid rgba(34, 197, 94, 0.2);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.filters-section .form-select:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.25);
}

.filters-section .btn-primary {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none;
    border-radius: 12px;
    padding: 0.7rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.filters-section .btn-primary:hover {
    background: linear-gradient(135deg, #16a34a, #15803d);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
}

.categories-navigation .btn {
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.categories-navigation .btn-primary {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none;
    color: white;
}

.categories-navigation .btn-outline-primary {
    border-color: #22c55e;
    color: #22c55e;
    background: transparent;
}

.categories-navigation .btn-outline-primary:hover {
    background: #22c55e;
    color: white;
    transform: translateY(-2px);
}

.category-info {
    background: linear-gradient(135deg, #ffffff, #f8fafc);
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(34, 197, 94, 0.1);
}

.category-info h3 {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.category-info .text-muted {
    color: #6b7280 !important;
}

.btn-outline-secondary {
    border-color: #22c55e;
    color: #22c55e;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #22c55e;
    border-color: #22c55e;
    color: white;
}

/* Modern Product Cards */
.product-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: 1px solid rgba(34, 197, 94, 0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    border-color: rgba(34, 197, 94, 0.2);
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
}

.product-placeholder i {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    opacity: 0.8;
}

.product-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 2;
}

.product-badge .badge {
    backdrop-filter: blur(10px);
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.4rem 0.8rem;
}

.badge.bg-success {
    background: rgba(16, 185, 129, 0.9) !important;
}

.badge.bg-info {
    background: rgba(6, 182, 212, 0.9) !important;
}

.badge.bg-warning {
    background: rgba(245, 158, 11, 0.9) !important;
}

.badge.bg-danger {
    background: rgba(239, 68, 68, 0.9) !important;
}

.stock-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 2;
}

.stock-badge .badge {
    backdrop-filter: blur(10px);
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.3rem 0.6rem;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(34, 197, 94, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(5px);
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-overlay .btn {
    backdrop-filter: blur(10px);
    border: 2px solid white;
    color: white;
    font-weight: 600;
    border-radius: 12px;
    padding: 0.7rem 1.5rem;
    transition: all 0.2s ease;
}

.product-overlay .btn:hover {
    background: white;
    color: #22c55e;
}

.product-info {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 0.8rem;
    line-height: 1.3;
}

.product-title a {
    color: #1f2937;
    text-decoration: none;
    transition: color 0.2s ease;
}

.product-title a:hover {
    color: #22c55e;
}

.product-description {
    color: #6b7280;
    font-size: 0.95rem;
    line-height: 1.6;
    flex: 1;
    margin-bottom: 1rem;
}

.product-footer {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #f3f4f6;
}

.product-price .price {
    font-size: 1.4rem;
    font-weight: 700;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.product-stock {
    margin-top: 0.5rem;
    font-size: 0.85rem;
}

.stock-available {
    color: #22c55e;
    font-weight: 500;
}

.stock-unavailable {
    color: #ef4444;
    font-weight: 500;
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
    background: linear-gradient(135deg, #ffffff, #f8fafc);
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(34, 197, 94, 0.1);
}

.empty-state i {
    color: #22c55e;
    opacity: 0.7;
}

.empty-state h3 {
    color: #1f2937;
    margin-bottom: 1rem;
}

.empty-state .btn-primary {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none;
    border-radius: 12px;
    padding: 0.8rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.empty-state .btn-primary:hover {
    background: linear-gradient(135deg, #16a34a, #15803d);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
}

.cta-section {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.cta-section .container {
    position: relative;
    z-index: 1;
}

.cta-section h2 {
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.cta-section .btn-light {
    background: white;
    color: #22c55e;
    border: none;
    border-radius: 12px;
    padding: 0.8rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.cta-section .btn-light:hover {
    background: #f8fafc;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section-small .hero-title {
        font-size: 2.5rem;
    }
    
    .categories-navigation .btn {
        margin-bottom: 0.5rem;
        width: 100%;
    }
    
    .category-info {
        padding: 1.5rem;
    }
    
    .product-card {
        margin-bottom: 1.5rem;
    }
}
</style>
@endpush