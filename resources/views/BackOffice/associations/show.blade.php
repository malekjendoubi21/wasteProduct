@extends('layouts.backoffice')

@section('title', 'Détails de l\'Association - BackOffice')
@section('page-title', 'Détails de l\'Association')
@section('page-subtitle', 'Informations détaillées de "{{ $association->name }}"')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">{{ $association->name }}</h1>
            <p class="dashboard-subtitle">Détails de l'association et informations</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('associations.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la liste</span>
            </a>
            <a href="{{ route('associations.edit', $association) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                <span>Modifier</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Informations principales -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informations générales</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-group">
                            <label>ID</label>
                            <p>{{ $association->id }}</p>
                        </div>

                        <div class="info-group">
                            <label>Email</label>
                            <p><i class="fas fa-envelope text-primary me-2"></i>{{ $association->contact_email }}</p>
                        </div>

                        <div class="info-group">
                            <label>Téléphone</label>
                            <p><i
                                    class="fas fa-phone text-primary me-2"></i>{{ $association->contact_phone ?? 'Non renseigné' }}
                            </p>
                        </div>

                        <div class="info-group">
                            <label>Domaine</label>
                            <p>
                                <span class="badge bg-info fs-6">{{ $association->domain }}</span>
                            </p>
                        </div>

                        <div class="info-group">
                            <label>Statut</label>
                            <p>
                                <span
                                    class="badge {{ $association->status == 'active' ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $association->status == 'active' ? 'Actif' : 'Inactif' }}
                                </span>
                            </p>
                        </div>

                        <div class="info-group">
                            <label>Date de création</label>
                            <p>{{ $association->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Statistiques</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="stat-item text-center">
                                    <div class="stat-value text-primary">{{ $association->donations->count() }}</div>
                                    <div class="stat-label">Donations reçues</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="stat-item text-center">
                                    <div class="stat-value text-info">
                                        {{ $association->status == 'active' ? 'Actif' : 'Inactif' }}</div>
                                    <div class="stat-label">Statut actuel</div>
                                </div>
                            </div>
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
                        <p class="lead">{{ $association->description ?? 'Aucune description fournie.' }}</p>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Adresse</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">{{ $association->address }}</p>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Actions rapides</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Actions</label>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('associations.edit', $association) }}" class="btn btn-warning">
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
                    <p>Êtes-vous sûr de vouloir supprimer l'association <strong>{{ $association->name }}</strong> ?</p>
                    <p class="text-danger"><small>Cette action est irréversible.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('associations.destroy', $association) }}"
                        style="display: inline;">
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
        function confirmDelete() {
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
@endpush
