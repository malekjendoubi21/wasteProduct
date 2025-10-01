@extends('layouts.backoffice')

@section('title', 'Détails de la Donation - BackOffice')
@section('page-title', 'Détails de la Donation')
@section('page-subtitle', 'Informations sur la donation')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Donation #{{ $donation->id }}</h1>
            <p class="dashboard-subtitle">Détails de la donation à {{ $donation->association->name }}</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('donations.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la liste</span>
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informations générales</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-group">
                            <label>ID</label>
                            <p>{{ $donation->id }}</p>
                        </div>
                        <div class="info-group">
                            <label>Donateur</label>
                            <p>
                                <a href="#" class="badge bg-info text-decoration-none">
                                    {{ $donation->user->name }} ({{ $donation->user->email }})
                                </a>
                            </p>
                        </div>
                        <div class="info-group">
                            <label>Association</label>
                            <p>
                                <a href="{{ route('associations.show', $donation->association) }}" class="badge bg-info text-decoration-none">
                                    {{ $donation->association->name }}
                                </a>
                            </p>
                        </div>
                        <div class="info-group">
                            <label>Date</label>
                            <p>{{ $donation->formatted_date }}</p>
                        </div>
                        <div class="info-group">
                            <label>Statut</label>
                            <p>
                                <span class="badge {{ $donation->status == 'accepted' ? 'bg-success' : ($donation->status == 'pending' ? 'bg-warning' : ($donation->status == 'delivered' ? 'bg-primary' : 'bg-danger')) }}">
                                    {{ $donation->status_label }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produits donnés</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                        <th>Catégorie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donation->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->nom }}" class="avatar-sm me-3" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
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
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Description</h3>
                        </div>
                        <div class="card-body">
                            <p class="lead">{{ $donation->description }}</p>
                        </div>
                    </div>
                @endif

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Actions rapides</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status" class="form-label">Mettre à jour le statut</label>
                            <div class="input-group">
                                <select id="status" class="form-select">
                                    <option value="pending" {{ $donation->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="accepted" {{ $donation->status == 'accepted' ? 'selected' : '' }}>Acceptée</option>
                                    <option value="delivered" {{ $donation->status == 'delivered' ? 'selected' : '' }}>Livré</option>
                                    <option value="cancelled" {{ $donation->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                </select>
                                <button type="button" class="btn btn-primary" onclick="updateStatus({{ $donation->id }})">
                                    <i class="fas fa-save"></i> Mettre à jour
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function updateStatus(donationId) {
        const status = document.getElementById('status').value;

        fetch(`/donations/${donationId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Erreur lors de la mise à jour du statut.');
            }
        })
        .catch(error => {
            alert('Erreur lors de la mise à jour du statut.');
        });
    }
    </script>
    @endpush
@endsection