@extends('layouts.backoffice')

@section('title', ' - Gestion des Catégories')
@section('page-title', 'Gestion des Catégories')
@section('page-subtitle', 'Gérer les catégories de produits')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Gestion des Catégories</h1>
            <p class="dashboard-subtitle">Gérer les catégories de produits et les classifications</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Nouvelle Catégorie</span>
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Toutes les Catégories</h3>
                <div class="card-actions">
                    <form method="GET" action="{{ route('categories.search') }}" class="search-form">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher des catégories..." class="search-input">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Rechercher</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Libellé</th>
                                <th>Nb Produits</th>
                                <th>Date de création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $categorie)
                                <tr>
                                    <td>{{ $categorie->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary-light me-3">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $categorie->label }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $categorie->produits_count ?? 0 }} produits</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $categorie->date_creation_formattee }}</small>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('categories.show', $categorie) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('categories.edit', $categorie) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer" 
                                                    onclick="confirmDelete({{ $categorie->id }}, '{{ $categorie->label }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                            <h5>Aucune catégorie trouvée</h5>
                                            <p class="text-muted">Commencez par créer votre première catégorie</p>
                                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Créer une catégorie
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($categories) && $categories->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $categories->links() }}
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
                    <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong id="categoryName"></strong> ?</p>
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
    document.getElementById('categoryName').textContent = name;
    document.getElementById('deleteForm').action = `/dashboard/categories/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
