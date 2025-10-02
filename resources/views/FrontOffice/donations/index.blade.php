```blade
@extends('layouts.app')

@section('title', 'Mes dons')

@section('content')
    <div class="container donation-container animate-slide-in" style="--delay: 0.2s;">
        <h1 class="donation-title text-center mb-5">Mes Dons</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($donations->isEmpty())
            <div class="empty-state card shadow-lg text-center animate-slide-in" style="--delay: 0.4s;">
                <div class="card-body">
                    <i class="fas fa-info-circle fa-3x text-primary mb-3"></i>
                    <p class="empty-state-text">Vous n'avez aucun don pour le moment.</p>
                    <a href="{{ route('produits.index') }}" class="btn btn-primary btn-modern">
                        <i class="fas fa-plus-circle me-2"></i>Faire un don
                    </a>
                </div>
            </div>
        @else
            <div class="donations-grid">
                @foreach ($donations as $donation)
                    <div class="donation-card card shadow-lg animate-slide-in" style="--delay: {{ 0.4 + $loop->index * 0.1 }}s;">
                        <div class="card-body">
                            <div class="donation-header">
                                <h3 class="donation-card-title">Don #{{ $donation->id }}</h3>
                                <span class="badge donation-status bg-{{ $donation->status === \App\Models\Donation::STATUS_PENDING ? 'warning' : ($donation->status === \App\Models\Donation::STATUS_ACCEPTED ? 'success' : 'info') }}">
                                    {{ $donation->status_label }}
                                </span>
                            </div>
                            <div class="donation-content">
                                <div class="donation-images">
                                    @foreach ($donation->items as $item)
                                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/placeholder.jpg') }}" 
                                             alt="{{ $item->product->nom }}" 
                                             class="donation-image" 
                                             loading="lazy">
                                    @endforeach
                                </div>
                                <div class="donation-details">
                                    <p><strong>Date :</strong> {{ $donation->formatted_date }}</p>
                                    <p><strong>Association :</strong> {{ $donation->association->name }}</p>
                                    <p><strong>Produits :</strong></p>
                                    <ul class="product-list">
                                        @foreach ($donation->items as $item)
                                            <li>{{ $item->product->nom }} (x{{ $item->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @if ($donation->status === \App\Models\Donation::STATUS_PENDING)
                                <div class="donation-actions">
                                    <a href="{{ route('donations.edit', $donation) }}" class="btn btn-warning btn-modern btn-sm" title="Modifier">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ route('donations.destroy', $donation) }}" method="POST" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce don ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-modern btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-container mt-5">
                {{ $donations->links('pagination::bootstrap-5') }}
            </div>
        @endif

        <div class="text-center mt-5">
            <a href="{{ route('produits.index') }}" class="btn btn-primary btn-modern btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Retour aux produits
            </a>
        </div>
    </div>
@endsection

@push('styles')
<style>
/* CSS Variables for Consistency */
:root {
    --primary-color: #22c55e;
    --secondary-color: #1e3a8a;
    --accent-color: #facc15;
    --text-color: #1f2937;
    --text-secondary: #6b7280;
    --background-color: #f9fafb;
    --card-background: #ffffff;
    --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 20px rgba(0, 0, 0, 0.15);
    --radius-md: 8px;
    --radius-lg: 12px;
    --transition-base: 0.3s ease;
    --font-size-lg: 1.125rem;
    --font-size-xl: 1.5rem;
    --font-size-2xl: 1.875rem;
}

/* General Container */
.donation-container {
    padding: 2rem 1rem;
    background: var(--background-color);
    min-height: 100vh;
}

/* Title */
.donation-title {
    font-size: var(--font-size-2xl);
    font-weight: 700;
    color: var(--text-color);
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    padding-bottom: 1rem;
}

.donation-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    border-radius: var(--radius-md);
}

/* Modern Alert */
.modern-alert {
    border-radius: var(--radius-lg);
    background: linear-gradient(145deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
    border: 1px solid var(--primary-color);
    color: var(--text-color);
    padding: 1rem 1.5rem;
    box-shadow: var(--shadow-sm);
    animation: fadeIn 0.5s ease;
}

/* Empty State */
.empty-state {
    max-width: 500px;
    margin: 2rem auto;
    border-radius: var(--radius-lg);
    background: var(--card-background);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: transform var(--transition-base);
}

.empty-state:hover {
    transform: translateY(-5px);
}

.empty-state-text {
    font-size: var(--font-size-lg);
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

/* Donations Grid */
.donations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

/* Donation Card */
.donation-card {
    background: var(--card-background);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: transform var(--transition-base), box-shadow var(--transition-base);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.donation-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.donation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.donation-card-title {
    font-size: var(--font-size-lg);
    font-weight: 600;
    color: var(--text-color);
    margin: 0;
}

.donation-status {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    border-radius: var(--radius-md);
}

.donation-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.donation-images {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.donation-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: var(--radius-md);
    border: 1px solid rgba(0, 0, 0, 0.1);
    transition: transform var(--transition-base);
}

.donation-image:hover {
    transform: scale(1.1);
}

.donation-details {
    font-size: var(--font-size-lg);
    color: var(--text-color);
}

.donation-details p {
    margin: 0 0 0.5rem;
}

.donation-details strong {
    color: var(--secondary-color);
}

.product-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.product-list li {
    font-size: 0.95rem;
    color: var(--text-secondary);
    position: relative;
    padding-left: 1.2rem;
}

.product-list li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--primary-color);
    font-weight: bold;
}

.donation-actions {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    gap: 0.5rem;
}

/* Modern Buttons */
.btn-modern {
    border-radius: var(--radius-md);
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all var(--transition-base);
    position: relative;
    overflow: hidden;
}

.btn-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
}

.btn-modern:hover::before {
    left: 100%;
}

.btn-primary.btn-modern {
    background: var(--primary-color);
    border: none;
}

.btn-primary.btn-modern:hover {
    background: #16a34a; /* darken(var(--primary-color), 10%) */
}

.btn-warning.btn-modern {
    background: var(--accent-color);
    color: var(--text-color);
}

.btn-warning.btn-modern:hover {
    background: #eab308; /* darken(var(--accent-color), 10%) */
}

.btn-danger.btn-modern {
    background: #ef4444;
}

.btn-danger.btn-modern:hover {
    background: #dc2626; /* darken(#ef4444, 10%) */
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
}

.pagination .page-link {
    border-radius: var(--radius-md);
    color: var(--primary-color);
    transition: all var(--transition-base);
}

.pagination .page-link:hover {
    background: var(--primary-color);
    color: white;
}

.pagination .page-item.active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

/* Animations */
.animate-slide-in {
    opacity: 0;
    transform: translateY(20px);
    animation: slideIn 0.6s ease forwards;
    animation-delay: var(--delay);
}

@keyframes slideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .donation-title {
        font-size: var(--font-size-xl);
    }

    .donations-grid {
        grid-template-columns: 1fr;
    }

    .donation-image {
        width: 50px;
        height: 50px;
    }

    .donation-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-modern {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 576px) {
    .donation-container {
        padding: 1rem;
    }

    .donation-card {
        margin: 0 0.5rem;
    }

    .donation-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Smooth hover animation for donation cards
document.querySelectorAll('.donation-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-8px)';
        card.style.boxShadow = 'var(--shadow-lg)';
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
        card.style.boxShadow = 'var(--shadow-sm)';
    });
});

// Lazy load images
document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.donation-image');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                observer.unobserve(img);
            }
        });
    }, { rootMargin: '0px 0px 100px 0px' });
    
    images.forEach(img => observer.observe(img));
});
</script>
@endpush
```