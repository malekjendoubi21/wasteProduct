@extends('layouts.backoffice')

@section('title', 'Gestion des Associations - BackOffice')
@section('page-title', 'Gestion des Associations')
@section('page-subtitle', 'Gérer les associations et leurs statuts')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Gestion des Associations</h1>
            <p class="dashboard-subtitle">Gérer les associations et leurs informations</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('associations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Nouvelle Association</span>
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

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Filtres -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('associations.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Recherche</label>
                        <input type="text" name="search" value="{{ old('search', request('search')) }}" class="form-control" placeholder="Nom de l'association...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                        <a href="{{ route('associations.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Toutes les Associations</h3>
                <div class="card-actions">
                    <small class="text-muted">{{ $associations->total() }} association(s) trouvée(s)</small>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Domaine</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($associations as $association)
                                <tr>
                                    <td>{{ $association->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary-light me-3">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($association->name, 25) }}</h6>
                                                <small class="text-muted">{{ Str::limit($association->description ?? '', 40) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $association->contact_email }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $association->domain }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $association->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $association->status == 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('associations.show', $association) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('associations.edit', $association) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer"
                                                    onclick="confirmDelete({{ $association->id }}, '{{ addslashes($association->name) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                            <h5>Aucune association trouvée</h5>
                                            <p class="text-muted">Commencez par créer votre première association</p>
                                            <a href="{{ route('associations.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Créer une association
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($associations->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $associations->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer l'association <strong id="associationName"></strong> ?</p>
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
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('associationName').textContent = name;
    document.getElementById('deleteForm').action = `/associations/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush