@extends('layouts.backoffice')

@section('title', 'Gestion des Donations - BackOffice')
@section('page-title', 'Gestion des Donations')
@section('page-subtitle', 'Voir et gérer toutes les donations')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Gestion des Donations</h1>
            <p class="dashboard-subtitle">Liste de toutes les donations aux associations</p>
        </div>
    </div>

    <div class="dashboard-content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('donations.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Recherche</label>
                        <input type="text" name="search" value="{{ old('search', request('search')) }}" class="form-control" placeholder="Rechercher par utilisateur ou association...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Acceptée</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Livré</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                        <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Toutes les Donations</h3>
                <div class="card-actions">
                    <small class="text-muted">{{ $donations->total() }} donation(s) trouvée(s)</small>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Donateur</th>
                                <th>Association</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Produits</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $donation)
                                <tr>
                                    <td>{{ $donation->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary-light me-3">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($donation->user->name, 25) }}</h6>
                                                <small class="text-muted">{{ $donation->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary-light me-3">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($donation->association->name, 25) }}</h6>
                                                <small class="text-muted">{{ $donation->association->domain }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $donation->formatted_date }}</td>
                                    <td>
                                        <select class="form-select status-select" data-id="{{ $donation->id }}">
                                            <option value="pending" {{ $donation->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="accepted" {{ $donation->status == 'accepted' ? 'selected' : '' }}>Acceptée</option>
                                            <option value="delivered" {{ $donation->status == 'delivered' ? 'selected' : '' }}>Livré</option>
                                            <option value="cancelled" {{ $donation->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                        </select>
                                    </td>
                                    <td>{{ $donation->items->sum('quantity') }} produit(s)</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('donations.show', $donation) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="confirmDelete({{ $donation->id }}, '{{ addslashes($donation->id) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                                            <h5>Aucune donation trouvée</h5>
                                            <p class="text-muted">Aucune donation n'a encore été effectuée</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($donations->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $donations->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer la donation <strong id="donationId"></strong> ?</p>
                        <p class="text-danger"><small>Cette action est irréversible.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form id="deleteForm" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const donationId = this.dataset.id;
        const status = this.value;

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
                alert('Statut mis à jour avec succès.');
            } else {
                alert(data.message || 'Erreur lors de la mise à jour du statut.');
                this.value = this.dataset.current;
            }
        })
        .catch(error => {
            alert('Erreur lors de la mise à jour du statut.');
            this.value = this.dataset.current;
        });
    });
});

function confirmDelete(id, donationId) {
    document.getElementById('donationId').textContent = donationId;
    document.getElementById('deleteForm').action = `/donations/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush