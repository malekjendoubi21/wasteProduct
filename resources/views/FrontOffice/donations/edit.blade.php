
@extends('layouts.app')

@section('title', 'Modifier le don - ' . ($donation->items->first()->product->nom ?? 'Don'))

@section('content')
    <div class="donation-container animate-slide-in" style="--delay: 0.2s;">
        <h1 class="donation-title text-center mb-5">Modifier le don pour : {{ $donation->items->first()->product->nom ?? 'Produit' }}</h1>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show modern-alert modern-alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-lg donation-card animate-slide-in" style="--delay: 0.4s;">
            <div class="card-header">
                <h3 class="card-title">Modifier les détails du don</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('donations.update', $donation) }}" method="POST" id="donation-edit-form">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="donation_id" value="{{ $donation->id }}">

                    <div class="form-group mb-4">
                        <label for="association_id" class="info-label">Sélectionner une association</label>
                        <select name="association_id" id="association_id" class="form-control form-control-modern" required>
                            <option value="">Choisir une association</option>
                            @if ($associations->isNotEmpty())
                                @foreach ($associations as $association)
                                    <option value="{{ $association->id }}" {{ $association->id == $donation->association_id ? 'selected' : '' }}>
                                        {{ $association->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>Aucune association disponible</option>
                            @endif
                        </select>
                        @error('association_id')
                            <span class="text-danger error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="quantity" class="info-label">Quantité (Stock disponible : {{ $donation->items->first()->product->stock + $donation->items->first()->quantity ?? 0 }})</label>
                        <input type="number" name="quantity" id="quantity" class="form-control form-control-modern" min="1" value="{{ old('quantity', $donation->items->first()->quantity ?? 1) }}" required>
                        @error('quantity')
                            <span class="text-danger error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="description" class="info-label">Description (optionnel)</label>
                        <textarea name="description" id="description" class="form-control form-control-modern" rows="4">{{ old('description', $donation->description) }}</textarea>
                        @error('description')
                            <span class="text-danger error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning btn-modern">Modifier le don</button>
                        <a href="{{ route('donations.index') }}" class="btn btn-secondary btn-modern">Annuler</a>
                    </div>
                </form>
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

/* Donation Container */
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
    padding: 1rem 1.5rem;
    box-shadow: var(--shadow-sm);
    animation: fadeIn 0.5s ease;
}

.modern-alert-danger {
    background: linear-gradient(145deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
    border: 1px solid #ef4444;
    color: var(--text-color);
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

/* Form Styling */
.form-group {
    position: relative;
}

.info-label {
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--secondary-color);
    margin-bottom: 0.5rem;
    display: block;
}

.form-control-modern {
    border-radius: var(--radius-md);
    border: 1px solid rgba(0, 0, 0, 0.1);
    padding: 0.75rem;
    font-size: var(--font-size-lg);
    transition: all var(--transition-base);
    box-shadow: var(--shadow-sm);
}

.form-control-modern:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
    outline: none;
}

.form-control-modern:invalid:not(:placeholder-shown) {
    border-color: #ef4444;
}

.error-message {
    font-size: 0.85rem;
    margin-top: 0.25rem;
    display: block;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
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

.btn-warning.btn-modern {
    background: var(--accent-color);
    color: var(--text-color);
    border: none;
}

.btn-warning.btn-modern:hover {
    background: #eab308; /* darken(var(--accent-color), 10%) */
}

.btn-secondary.btn-modern {
    background: var(--text-secondary);
    color: white;
    border: none;
}

.btn-secondary.btn-modern:hover {
    background: #4b5563; /* darken(var(--text-secondary), 10%) */
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

    .form-actions {
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

    .form-control-modern {
        font-size: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Form input focus animation
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.form-control-modern');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.querySelector('.info-label').style.color = 'var(--primary-color)';
        });
        input.addEventListener('blur', () => {
            input.parentElement.querySelector('.info-label').style.color = 'var(--secondary-color)';
        });
    });

    // Form validation feedback
    const form = document.getElementById('donation-edit-form');
    form.addEventListener('submit', (e) => {
        const quantity = document.getElementById('quantity');
        const maxQuantity = {{ $donation->items->first()->product->stock + $donation->items->first()->quantity ?? 0 }};
        if (quantity.value > maxQuantity) {
            e.preventDefault();
            quantity.classList.add('is-invalid');
            const error = document.createElement('span');
            error.className = 'text-danger error-message';
            error.textContent = 'La quantité dépasse le stock disponible.';
            if (!quantity.nextElementSibling?.classList.contains('error-message')) {
                quantity.parentElement.appendChild(error);
            }
        } else {
            quantity.classList.remove('is-invalid');
            const existingError = quantity.nextElementSibling;
            if (existingError?.classList.contains('error-message')) {
                existingError.remove();
            }
        }
    });
});
</script>
@endpush
