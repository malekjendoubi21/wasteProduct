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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
}

.product-placeholder-large {
    width: 100%;
    height: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #6c757d;
    border-radius: 10px;
}

.product-placeholder-large i {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.product-meta {
    margin-bottom: 1rem;
}

.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
}

.product-price .price {
    font-size: 2.5rem;
    font-weight: 700;
    color: #28a745;
}

.product-stock {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #28a745;
}

.product-stock.stock-unavailable {
    border-left-color: #dc3545;
    background: #fff5f5;
}

.product-description {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.product-additional-info {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
}

.info-item {
    margin-bottom: 0.5rem;
}

.product-actions .btn {
    min-width: 200px;
    margin-bottom: 1rem;
}

.product-share h6 {
    color: #666;
    margin-bottom: 1rem;
}

.share-buttons .btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Styles pour les produits similaires (réutilisation des styles de la page index) */
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

.product-category {
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
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
    padding: 0;
    background: none;
    border: none;
}

.stock-available {
    color: #28a745;
}

.stock-unavailable {
    color: #dc3545;
}

.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
}
</style>
@endpush