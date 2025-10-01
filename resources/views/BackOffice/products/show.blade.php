@extends('layouts.backoffice')

@section('title', ' - Détails du Produit')
@section('page-title', 'Détails du Produit')
@section('page-subtitle', 'Informations détaillées du produit')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">{{ $product->nom }}</h1>
            <p class="dashboard-subtitle">Détails du produit et informations</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la liste</span>
            </a>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                <span>Modifier</span>
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
            <!-- Image et informations principales -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Image du produit</h3>
                    </div>
                    <div class="card-body text-center">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->nom }}" 
                                 class="img-fluid rounded" style="max-height: 300px;">
                        @else
                            <div class="empty-image">
                                <i class="fas fa-image fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Aucune image disponible</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Informations générales</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-group">
                            <label>ID</label>
                            <p>{{ $product->id }}</p>
                        </div>
                        
                        <div class="info-group">
                            <label>Prix</label>
                            <p class="h5 text-primary">{{ $product->prix_formatte }}</p>
                        </div>
                        
                        <div class="info-group">
                            <label>Stock</label>
                            <p>
                                @if($product->stock > 0)
                                    <span class="badge bg-success fs-6">{{ $product->stock }} unités</span>
                                @else
                                    <span class="badge bg-danger fs-6">Rupture de stock</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="info-group">
                            <label>Type</label>
                            <p>
                                @switch($product->type)
                                    @case('recyclé')
                                        <span class="badge bg-success fs-6">Recyclé</span>
                                        @break
                                    @case('alimentaire')
                                        <span class="badge bg-info fs-6">Alimentaire</span>
                                        @break
                                    @case('non_recyclé')
                                        <span class="badge bg-warning fs-6">Non recyclé</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                        
                        <div class="info-group">
                            <label>Catégorie</label>
                            <p>
                                <a href="{{ route('categories.show', $product->categorie) }}" class="badge bg-info fs-6 text-decoration-none">
                                    {{ $product->categorie->label }}
                                </a>
                            </p>
                        </div>
                        
                        <div class="info-group">
                            <label>Date d'ajout</label>
                            <p>{{ $product->date_ajout_formattee }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description et actions -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Description</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">{{ $product->description }}</p>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Actions rapides</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quick_stock" class="form-label">Mise à jour du stock</label>
                                    <div class="input-group">
                                        <input type="number" id="quick_stock" class="form-control" value="{{ $product->stock }}" min="0">
                                        <button type="button" class="btn btn-primary" onclick="updateStock()">
                                            <i class="fas fa-save"></i> Mettre à jour
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Actions</label>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Statistiques</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stat-item text-center">
                                    <div class="stat-value text-primary">{{ $product->stock }}</div>
                                    <div class="stat-label">Stock actuel</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item text-center">
                                    <div class="stat-value text-success">{{ $product->prix_base }}€</div>
                                    <div class="stat-label">Prix unitaire</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item text-center">
                                    <div class="stat-value text-info">{{ number_format($product->prix_base * $product->stock, 2) }}€</div>
                                    <div class="stat-label">Valeur totale</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <p>Êtes-vous sûr de vouloir supprimer le produit <strong>{{ $product->nom }}</strong> ?</p>
                    <p class="text-danger"><small>Cette action est irréversible.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" style="display: inline;">
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
function updateStock() {
    const stock = document.getElementById('quick_stock').value;
    
    fetch(`{{ route('products.updateStock', $product) }}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ stock: parseInt(stock) })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur lors de la mise à jour du stock');
        }
    })
    .catch(error => {
        alert('Erreur lors de la mise à jour du stock');
    });
}

function confirmDelete() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush