@extends('layouts.app')

@section('title', ' - Mes commandes')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Mes commandes</h1>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead><tr><th>#</th><th>Date</th><th>Montant</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($commandes as $cmd)
                    <tr>
                        <td>#{{ $cmd->id }}</td>
                        <td>{{ optional($cmd->date)->format('Y-m-d H:i') }}</td>
                        <td>{{ number_format($cmd->montant, 2, ',', ' ') }} €</td>
                        <td><a href="{{ route('front.orders.show', $cmd) }}" class="btn btn-sm btn-outline-primary">Voir</a></td>
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
