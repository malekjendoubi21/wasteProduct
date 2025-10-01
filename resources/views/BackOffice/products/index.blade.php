@extends('layouts.backoffice')

@section('title', ' - Gestion des Produits')
@section('page-title', 'Gestion des Produits')
@section('page-subtitle', 'Gérer les produits et leurs catégories')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Gestion des Produits</h1>
            <p class="dashboard-subtitle">Gérer les produits de recyclage et leurs catégories</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Nouveau Produit</span>
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
                <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Recherche</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nom du produit...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie_id" class="form-select">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->label }}
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
                    <div class="col-md-3">
                        <label class="form-label">Stock</label>
                        <select name="stock" class="form-select">
                            <option value="">Tous</option>
                            <option value="available" {{ request('stock') == 'available' ? 'selected' : '' }}>En stock</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tous les Produits</h3>
                <div class="card-actions">
                    <small class="text-muted">{{ $products->total() }} produit(s) trouvé(s)</small>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produit</th>
                                <th>Catégorie</th>
                                <th>Prix</th>
                                <th>Stock</th>
                                <th>Type</th>
                                <th>Date d'ajout</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->image)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->nom }}" 
                                                     class="avatar-sm me-3" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <div class="avatar-sm bg-primary-light me-3">
                                                    <i class="fas fa-box"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($product->nom, 25) }}</h6>
                                                <small class="text-muted">{{ Str::limit($product->description, 40) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $product->categorie->label }}</span>
                                    </td>
                                    <td>{{ $product->prix_formatte }}</td>
                                    <td>
                                        @if($product->stock > 0)
                                            <span class="badge bg-success">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Rupture</span>
                                        @endif
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $product->date_ajout_formattee }}</small>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer" 
                                                    onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->nom) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <h5>Aucun produit trouvé</h5>
                                            <p class="text-muted">Commencez par créer votre premier produit</p>
                                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Créer un produit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->appends(request()->query())->links() }}
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
                    <p>Êtes-vous sûr de vouloir supprimer le produit <strong id="productName"></strong> ?</p>
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
    document.getElementById('productName').textContent = name;
    document.getElementById('deleteForm').action = `/dashboard/products/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
