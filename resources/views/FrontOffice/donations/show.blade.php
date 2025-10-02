```blade
@extends('layouts.backoffice')

@section('title', 'Détails de la Donation - FrontOffice')
@section('page-title', 'Détails de la Donation')
@section('page-subtitle', 'Informations sur votre donation')

@section('content')
    <div class="dashboard-container animate-slide-in" style="--delay: 0.2s;">
        <div class="dashboard-header">
            <div class="dashboard-header-content">
                <h1 class="dashboard-title">Donation #{{ $donation->id }}</h1>
                <p class="dashboard-subtitle">Détails de la donation à {{ $donation->association->name }}</p>
            </div>
            <div class="dashboard-header-actions">
                <a href="{{ route('dons.index') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-arrow-left me-2"></i>Retour à mes donations
                </a>
            </div>
        </div>

        <div class="dashboard-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-lg donation-card animate-slide-in" style="--delay: 0.4s;">
                        <div class="card-header">
                            <h3 class="card-title">Informations générales</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-group">
                                <label class="info-label">ID</label>
                                <p class="info-text">{{ $donation->id }}</p>
                            </div>
                            <div class="info-group">
                                <label class="info-label">Association</label>
                                <p class="info-text">
                                    <a href="{{ route('associations.show', $donation->association) }}" class="badge bg-info text-decoration-none">
                                        {{ $donation->association->name }}
                                    </a>
                                </p>
                            </div>
                            <div class="info-group">
                                <label class="info-label">Date</label>
                                <p class="info-text">{{ $donation->formatted_date }}</p>
                            </div>
                            <div class="info-group">
                                <label class="info-label">Statut</label>
                                <p class="info-text">
                                    <span class="badge donation-status bg-{{ $donation->status == 'accepted' ? 'success' : ($donation->status == 'pending' ? 'warning' : ($donation->status == 'delivered' ? 'primary' : 'danger')) }}">
                                        {{ $donation->status_label }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-lg donation-card animate-slide-in" style="--delay: 0.5s;">
                        <div class="card-header">
                            <h3 class="card-title">Produits donnés</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-modern">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Quantité</th>
                                            <th>Catégorie</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($donation->items as $item)
                                            <tr class="table-row">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product->image)
                                                            <img src="{{ $item->product->image_url }}" 
                                                                 alt="{{ $item->product->nom }}" 
                                                                 class="donation-image" 
                                                                 loading="lazy">
                                                        @else
                                                            <div class="avatar-sm bg-primary-light me-3">
                                                                <i class="fas fa-box"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ Str::limit($item->product->nom, 25) }}</h6>
                                                            <small class="text-muted">{{ Str::limit($item->product->description, 40) }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>
                                                    <span class="badge bg-info">{{ $item->product->categorie->label }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($donation->description)
                        <div class="card shadow-lg donation-card mt-4 animate-slide-in" style="--delay: 0.6s;">
                            <div class="card-header">
                                <h3 class="card-title">Description</h3>
                            </div>
                            <div class="card-body">
                                <p class="lead">{{ $donation->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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

/* Dashboard Container */
.dashboard-container {
    padding: 2rem 1rem;
    background: var(--background-color);
    min-height: 100vh;
}

/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.dashboard-title {
    font-size: var(--font-size-2xl);
    font-weight: 700;
    color: var(--text-color);
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    padding-bottom: 1rem;
}

.dashboard-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    border-radius: var(--radius-md);
}

.dashboard-subtitle {
    font-size: var(--font-size-lg);
    color: var(--text-secondary);
    margin-top: 0.5rem;
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

.card-header {
    background: var(--card-background);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 1rem 1.5rem;
}

.card-title {
    font-size: var(--font-size-lg);
    font-weight: 600;
    color: var(--text-color);
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

/* Info Group */
.info-group {
    margin-bottom: 1rem;
}

.info-label {
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--secondary-color);
    margin-bottom: 0.25rem;
}

.info-text {
    font-size: var(--font-size-lg);
    color: var(--text-color);
    margin: 0;
}

.donation-status {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    border-radius: var(--radius-md);
}

/* Table Styling */
.table-modern {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

.table-modern th,
.table-modern td {
    padding: 1rem;
    vertical-align: middle;
}

.table-modern th {
    background: var(--secondary-color);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9rem;
}

.table-modern tr {
    transition: background var(--transition-base);
}

.table-modern tr:hover {
    background: rgba(0, 0, 0, 0.05);
}

.donation-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: var(--radius-md);
    border: 1px solid rgba(0, 0, 0, 0.1);
    transition: transform var(--transition-base);
}

.donation-image:hover {
    transform: scale(1.1);
}

.avatar-sm.bg-primary-light {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-md);
    background: rgba(34, 197, 94, 0.1);
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
    .dashboard-title {
        font-size: var(--font-size-xl);
    }

    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .dashboard-header-actions {
        width: 100%;
        text-align: center;
    }

    .btn-modern {
        width: 100%;
        text-align: center;
    }

    .donation-image {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 576px) {
    .dashboard-container {
        padding: 1rem;
    }

    .table-modern th,
    .table-modern td {
        padding: 0.75rem;
        font-size: 0.85rem;
    }

    .info-text,
    .card-title {
        font-size: 1rem;
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