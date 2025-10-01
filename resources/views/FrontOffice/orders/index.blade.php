@extends('layouts.app')

@section('title', ' - Mes commandes')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Mes commandes</h1>
        @auth
            @if(auth()->user()->role === 'partenaire')
                <a href="{{ route('front.orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-cart-plus"></i>
                    <span>Passer une commande</span>
                </a>
            @endif
        @endauth
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead><tr><th>#</th><th>Date</th><th>Montant</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($commandes as $cmd)
                    <tr>
                        <td>#{{ $cmd->id }}</td>
                        <td>{{ optional($cmd->date)->format('Y-m-d H:i') }}</td>
                        <td><span class="badge bg-success">{{ number_format($cmd->montant, 2, ',', ' ') }} €</span></td>
                        <td>
                            <a href="{{ route('front.orders.show', $cmd) }}" class="btn btn-sm btn-outline-success" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Aucune commande</td></tr>
                @endforelse
                </tbody>
            </table>
            @if($commandes->hasPages())
                <div class="d-flex justify-content-center mt-4">{{ $commandes->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
