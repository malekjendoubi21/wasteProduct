@extends('layouts.backoffice')

@section('title', ' - Orders Management')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Gestion des Commandes</h1>
            <p class="dashboard-subtitle">Suivre et gérer les commandes clients</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Nouvelle Commande</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Toutes les Commandes</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Montant</th>
                                <th>Produit</th>
                                <th>Qté</th>
                                <th>Date</th>
                                <th>Livraisons</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commandes as $commande)
                                <tr>
                                    <td>#{{ $commande->id }}</td>
                                    <td>{{ optional($commande->utilisateur)->name }}</td>
                                    <td>{{ number_format($commande->montant, 2, ',', ' ') }} €</td>
                                    <td>{{ optional($commande->product)->nom }}</td>
                                    <td>{{ $commande->quantity }}</td>
                                    <td>{{ optional($commande->date)->format('Y-m-d H:i') }}</td>
                                    <td>{{ $commande->livraisons()->count() }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $commande) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                        <a href="{{ route('orders.edit', $commande) }}" class="btn btn-sm btn-outline-warning">Modifier</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Aucune commande trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @isset($commandes)
                    @if($commandes instanceof \Illuminate\Contracts\Pagination\Paginator || $commandes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <div class="d-flex justify-content-center mt-4">
                            {{ $commandes->links() }}
                        </div>
                    @endif
                @endisset
            </div>
        </div>
    </div>
@endsection
