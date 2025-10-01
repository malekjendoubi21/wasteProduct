@extends('layouts.backoffice')

@section('title', ' - Véhicules')

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <h1 class="dashboard-title">Véhicules</h1>
    </div>
    <div class="dashboard-header-actions">
        <a href="{{ route('vehicules.create') }}" class="btn btn-primary">Nouveau</a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead><tr><th>ID</th><th>Immatriculation</th><th>Type</th><th>Capacité</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($vehicules as $v)
                    <tr>
                        <td>{{ $v->id }}</td>
                        <td>{{ $v->immatriculation }}</td>
                        <td>{{ $v->type }}</td>
                        <td>{{ $v->capacite }}</td>
                        <td>
                            <a href="{{ route('vehicules.show', $v) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                            <a href="{{ route('vehicules.edit', $v) }}" class="btn btn-sm btn-outline-warning">Modifier</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Aucun véhicule</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($vehicules->hasPages())
            <div class="d-flex justify-content-center mt-4">{{ $vehicules->links() }}</div>
        @endif
    </div>
</div>
@endsection
