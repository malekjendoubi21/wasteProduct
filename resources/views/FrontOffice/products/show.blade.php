@extends('layouts.app')

@section('title', ' - ' . $product->nom)

@section('content')
    <!-- Hero Section -->
    <section class="hero-section-small">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('produits.index') }}">Produits</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('produits.category', $product->categorie) }}">{{ $product->categorie->label }}</a></li>
                        <li class="breadcrumb-item active">{{ $product->nom }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Product Detail Section -->
    <section class="product-detail-section py-5">
        <div class="container">
            <div class="row">
                <!-- Image du produit -->
                <div class="col-lg-6">
                    <div class="product-image-container">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->nom }}" 
                                 class="img-fluid rounded shadow">
                        @else
                            <div class="product-placeholder-large">
                                <i class="fas fa-image"></i>
                                <span>Aucune image disponible</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informations du produit -->
                <div class="col-lg-6">
                    <div class="product-details">
                        <!-- Catégorie et type -->
                        <div class="product-meta mb-3">
                            <a href="{{ route('produits.category', $product->categorie) }}" class="badge bg-primary me-2">
                                {{ $product->categorie->label }}
                            </a>
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

                        <!-- Titre -->
                        <h1 class="product-title">{{ $product->nom }}</h1>

                        <!-- Prix -->
                        <div class="product-price mb-4">
                            <span class="price">{{ $product->prix_formatte }}</span>
                        </div>

                        <!-- Stock -->
                        <div class="product-stock mb-4">
                            @if($product->stock > 0)
                                <div class="stock-available">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span class="text-success fw-bold">En stock ({{ $product->stock }} unités disponibles)</span>
                                </div>
                            @else
                                <div class="stock-unavailable">
                                    <i class="fas fa-times-circle text-danger"></i>
                                    <span class="text-danger fw-bold">Rupture de stock</span>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="product-description mb-4">
                            <h5>Description</h5>
                            <p class="lead">{{ $product->description }}</p>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="product-additional-info mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="info-item">
                                        <strong>Type:</strong>
                                        <span>{{ $product->getTypes()[$product->type] ?? $product->type }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-item">
                                        <strong>Ajouté le:</strong>
                                        <span>{{ $product->date_ajout_formattee }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="product-actions">
                            @if($product->stock > 0)
                                <button class="btn btn-primary btn-lg me-3">
                                    <i class="fas fa-shopping-cart"></i>
                                    Contacter pour achat
                                </button>
                                @auth
                                    <a href="{{ route('donations.create', $product) }}" class="btn btn-success btn-lg me-3">
                                        <i class="fas fa-gift"></i>
                                        Ajouter à mes dons
                                    </a>
                                @endauth
                            @else
                                <button class="btn btn-secondary btn-lg me-3" disabled>
                                    <i class="fas fa-times"></i>
                                    Indisponible
                                </button>
                            @endif
                            
                            <button class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-heart"></i>
                                Ajouter aux favoris
                            </button>
                        </div>

                        <!-- Partage -->
                        <div class="product-share mt-4">
                            <h6>Partager ce produit:</h6>
                            <div class="share-buttons">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info btn-sm me-2">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success btn-sm me-2">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" class="btn btn-outline-dark btn-sm">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    @if($relatedProducts->count() > 0)
        <section class="related-products-section py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5">Produits similaires</h2>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="product-card">
                                <div class="product-image">
                                    @if($relatedProduct->image)
                                        <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->nom }}" 
                                             class="img-fluid">
                                    @else
                                        <div class="product-placeholder">
                                            <i class="fas fa-image"></i>
                                            <span>Aucune image</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Badge type -->
                                    <div class="product-badge">
                                        @switch($relatedProduct->type)
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

                                    <div class="product-overlay">
                                        <a href="{{ route('produits.show', $relatedProduct) }}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i> Voir détails
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="product-info">
                                    <div class="product-category">
                                        <span class="text-muted">{{ $relatedProduct->categorie->label }}</span>
                                    </div>
                                    <h5 class="product-title">
                                        <a href="{{ route('produits.show', $relatedProduct) }}">{{ Str::limit($relatedProduct->nom, 30) }}</a>
                                    </h5>
                                    <div class="product-footer">
                                        <div class="product-price">
                                            <span class="price">{{ $relatedProduct->prix_formatte }}</span>
                                        </div>
                                        <div class="product-stock">
                                            @if($relatedProduct->stock > 0)
                                                <span class="stock-available">
                                                    <i class="fas fa-check-circle text-success"></i>
                                                    En stock
                                                </span>
                                            @else
                                                <span class="stock-unavailable">
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                    Rupture
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="cta-section bg-primary text-white py-5">
        <div class="container text-center">
            <h2 class="mb-3">Intéressé par ce produit ?</h2>
            <p class="lead mb-4">Contactez-nous pour plus d'informations ou pour effectuer un achat</p>
            <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                <i class="fas fa-envelope"></i> Nous contacter
            </a>
        </div>
    </section>
@endsection

@push('styles')
<style>
.hero-section-small {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    padding: 80px 0 40px;
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

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
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

.product-image-container {
    position: relative;
    margin-bottom: 2rem;
}

.product-image-container img {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.product-placeholder-large {
    width: 100%;
    height: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.product-placeholder-large i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.8;
}

.product-meta {
    margin-bottom: 1rem;
}

.product-meta .badge {
    font-size: 0.85rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
}

.badge.bg-primary {
    background: linear-gradient(135deg, #22c55e, #16a34a) !important;
}

.badge.bg-success {
    background: linear-gradient(135deg, #10b981, #059669) !important;
}

.badge.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
}

.badge.bg-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
}

.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.product-price .price {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.product-stock {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-radius: 15px;
    border-left: 4px solid #22c55e;
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.1);
}

.product-stock.stock-unavailable {
    border-left-color: #ef4444;
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.1);
}

.product-description {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(34, 197, 94, 0.1);
}

.product-description h5 {
    color: #22c55e;
    font-weight: 600;
    margin-bottom: 1rem;
}

.product-additional-info {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 2rem;
    border-radius: 20px;
    border: 1px solid rgba(34, 197, 94, 0.1);
}

.info-item {
    margin-bottom: 0.8rem;
}

.info-item strong {
    color: #22c55e;
}

.product-actions .btn {
    min-width: 200px;
    margin-bottom: 1rem;
    border-radius: 12px;
    padding: 0.8rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none;
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #16a34a, #15803d);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
}

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-success:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.btn-outline-primary {
    border: 2px solid #22c55e;
    color: #22c55e;
    background: transparent;
}

.btn-outline-primary:hover {
    background: #22c55e;
    color: white;
    transform: translateY(-2px);
}

.product-share h6 {
    color: #6b7280;
    margin-bottom: 1rem;
    font-weight: 600;
}

.share-buttons .btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.share-buttons .btn:hover {
    transform: translateY(-3px);
}

/* Styles pour les produits similaires */
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
}

.product-info {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-category {
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
    color: #22c55e;
    font-weight: 500;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.product-title a {
    color: #1f2937;
    text-decoration: none;
    transition: color 0.2s ease;
}

.product-title a:hover {
    color: #22c55e;
}

.product-footer {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #f3f4f6;
}

.product-price .price {
    font-size: 1.25rem;
    font-weight: 700;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.product-stock {
    margin-top: 0.5rem;
    font-size: 0.85rem;
    padding: 0;
    background: none;
    border: none;
}

.stock-available {
    color: #22c55e;
}

.stock-unavailable {
    color: #ef4444;
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

@media (max-width: 768px) {
    .product-title {
        font-size: 2rem;
    }
    
    .product-price .price {
        font-size: 2rem;
    }
    
    .product-actions .btn {
        min-width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .product-image-container img {
        max-height: 300px;
    }
}
</style>
@endpush