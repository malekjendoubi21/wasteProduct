@extends('layouts.backoffice')

@section('title', 'Produits')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Gestion des produits</h1>
            <p class="dashboard-subtitle">Gérer les produits recyclés et non recyclés</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('produits.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Nouveau produit</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tous les produits</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Type</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($produits as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>
                                    @if($p->image_url)
                                        <img src="{{ $p->image_url }}" alt="{{ $p->nom }}" style="height:48px;width:auto">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td><a href="{{ route('produits.show', $p) }}" class="link">{{ $p->nom }}</a></td>
                                <td>{{ optional($p->categorie)->libelle }}</td>
                                <td>{{ number_format($p->prix_base, 2) }} DT</td>
                                <td>{{ $p->stock }}</td>
                                <td>{{ $p->type }}</td>
                                <td class="text-right">
                                    <a href="{{ route('produits.edit', $p) }}" class="btn btn-sm">Edit</a>
                                    <form action="{{ route('produits.destroy', $p) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">Aucun produit</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if(method_exists($produits, 'links'))
                    <div class="mt-4">{{ $produits->links() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection
