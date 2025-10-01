@extends('layouts.app')

@section('title', ' - Nos Produits')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section-small">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title">Nos Produits</h1>
                <p class="hero-subtitle">Découvrez notre sélection de produits recyclés et durables</p>
                
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item active">Produits</li>
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
                        <form method="GET" action="{{ route('produits.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Rechercher</label>
                                <div class="search-input-group">
                                    <i class="fas fa-search"></i>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                           class="form-control" placeholder="Nom du produit...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Catégorie</label>
                                <select name="categorie_id" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->label }} ({{ $categorie->produits_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
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

            <!-- Catégories rapides -->
            <div class="categories-quick-filter mb-4">
                <h5 class="mb-3">Filtrer par catégorie:</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('produits.index') }}" 
                       class="btn {{ !request('categorie_id') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                        Toutes
                    </a>
                    @foreach($categories as $categorie)
                        <a href="{{ route('produits.category', $categorie) }}" 
                           class="btn {{ request('categorie_id') == $categorie->id ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                            {{ $categorie->label }} 
                            <span class="badge bg-light text-dark ms-1">{{ $categorie->produits_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Résultats -->
            <div class="products-results">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>
                        @if(request()->hasAny(['search', 'categorie_id', 'type']))
                            Résultats de recherche 
                            @if(request('search'))
                                pour "{{ request('search') }}"
                            @endif
                        @else
                            Tous nos produits
                        @endif
                        <span class="text-muted">({{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }})</span>
                    </h4>
                    
                    @if(request()->hasAny(['search', 'categorie_id', 'type']))
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times"></i> Effacer les filtres
                        </a>
                    @endif
                </div>

                @if($products->count() > 0)
                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-item">
                                <div class="product-card-modern">
                                    <!-- Image Container -->
                                    <div class="product-image-container">
                                        @if($product->image)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->nom }}" 
                                                 class="product-img">
                                        @else
                                            <div class="product-placeholder-modern">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Badges Container -->
                                        <div class="badges-container">
                                            <!-- Type Badge -->
                                            <div class="type-badge">
                                                @switch($product->type)
                                                    @case('recyclé')
                                                        <span class="badge-eco">♻️ Recyclé</span>
                                                        @break
                                                    @case('alimentaire')
                                                        <span class="badge-food">🍃 Bio</span>
                                                        @break
                                                    @case('non_recyclé')
                                                        <span class="badge-regular">📦 Standard</span>
                                                        @break
                                                @endswitch
                                            </div>
                                            
                                            <!-- Stock Status -->
                                            @if($product->stock == 0)
                                                <div class="stock-status out-of-stock">
                                                    <span>Épuisé</span>
                                                </div>
                                            @elseif($product->stock <= 5)
                                                <div class="stock-status low-stock">
                                                    <span>Dernières pièces</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Hover Actions -->
                                        <div class="product-actions">
                                            <a href="{{ route('produits.show', $product) }}" class="action-btn primary">
                                                <i class="fas fa-eye"></i>
                                                <span>Voir détails</span>
                                            </a>
                                            <a href="{{ route('produits.category', $product->categorie) }}" class="action-btn secondary">
                                                <i class="fas fa-layer-group"></i>
                                                <span>Catégorie</span>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="product-content">
                                        <div class="product-header">
                                            <div class="product-category-tag">
                                                {{ $product->categorie->label }}
                                            </div>
                                            <div class="product-price-tag">
                                                {{ $product->prix_formatte }}
                                            </div>
                                        </div>
                                        
                                        <h3 class="product-name">
                                            <a href="{{ route('produits.show', $product) }}">{{ $product->nom }}</a>
                                        </h3>
                                        
                                        <p class="product-desc">{{ Str::limit($product->description, 90) }}</p>
                                        
                                        <div class="product-meta">
                                            <div class="stock-info">
                                                @if($product->stock > 0)
                                                    <div class="stock-available-modern">
                                                        <div class="stock-dot"></div>
                                                        <span>{{ $product->stock }} disponible{{ $product->stock > 1 ? 's' : '' }}</span>
                                                    </div>
                                                @else
                                                    <div class="stock-unavailable-modern">
                                                        <div class="stock-dot-empty"></div>
                                                        <span>Non disponible</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-date">
                                                <small>Ajouté le {{ $product->date_ajout ? \Carbon\Carbon::parse($product->date_ajout)->format('d/m/Y') : 'N/A' }}</small>
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
                            @if(request()->hasAny(['search', 'categorie_id', 'type']))
                                Essayez de modifier vos critères de recherche.
                            @else
                                Il n'y a actuellement aucun produit disponible.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'categorie_id', 'type']))
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
            <h2 class="mb-3">Vous avez des produits à recycler ?</h2>
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

/* Modern Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    padding: 1rem 0;
}

.product-item {
    position: relative;
}

.product-card-modern {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: 1px solid rgba(0, 0, 0, 0.05);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card-modern:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

/* Image Container */
.product-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.product-card-modern:hover .product-img {
    transform: scale(1.1);
}

.product-placeholder-modern {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
}

.product-placeholder-modern i {
    font-size: 3rem;
    opacity: 0.8;
}

/* Badges */
.badges-container {
    position: absolute;
    top: 15px;
    left: 15px;
    right: 15px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.type-badge {
    backdrop-filter: blur(10px);
    border-radius: 20px;
    overflow: hidden;
}

.badge-eco {
    background: rgba(40, 167, 69, 0.9);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: block;
}

.badge-food {
    background: rgba(23, 162, 184, 0.9);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: block;
}

.badge-regular {
    background: rgba(255, 193, 7, 0.9);
    color: #333;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: block;
}

.stock-status {
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 0.3rem 0.6rem;
    font-size: 0.7rem;
    font-weight: 600;
}

.out-of-stock {
    background: rgba(220, 53, 69, 0.9);
    color: white;
}

.low-stock {
    background: rgba(255, 152, 0, 0.9);
    color: white;
}

/* Hover Actions */
.product-actions {
    position: absolute;
    bottom: 15px;
    left: 15px;
    right: 15px;
    display: flex;
    gap: 0.5rem;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.product-card-modern:hover .product-actions {
    opacity: 1;
    transform: translateY(0);
}

.action-btn {
    flex: 1;
    padding: 0.6rem;
    border-radius: 12px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
    font-size: 0.8rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
}

.action-btn.primary {
    background: rgba(34, 197, 94, 0.9);
    color: white;
}

.action-btn.secondary {
    background: rgba(255, 255, 255, 0.9);
    color: #333;
}

.action-btn:hover {
    transform: scale(1.05);
}

/* Product Content */
.product-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.product-category-tag {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
}

.product-price-tag {
    background: linear-gradient(135deg, #11998e, #38ef7d);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.9rem;
    font-weight: 700;
}

.product-name {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 0.8rem;
    line-height: 1.3;
}

.product-name a {
    color: #2d3748;
    text-decoration: none;
    transition: color 0.2s ease;
}

.product-name a:hover {
    color: #22c55e;
}

.product-desc {
    color: #718096;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.2rem;
    flex: 1;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.stock-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stock-available-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #38a169;
    font-size: 0.85rem;
    font-weight: 500;
}

.stock-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #38a169;
    animation: pulse 2s infinite;
}

.stock-unavailable-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #e53e3e;
    font-size: 0.85rem;
    font-weight: 500;
}

.stock-dot-empty {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #e53e3e;
}

.product-date {
    color: #a0aec0;
    font-size: 0.75rem;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .product-image-container {
        height: 220px;
    }
    
    .product-content {
        padding: 1.2rem;
    }
    
    .product-meta {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
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
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
}
</style>
@endpush