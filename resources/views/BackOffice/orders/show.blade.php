@extends('layouts.backoffice')

@section('title', ' - Order Details')

@section('content')
<div class="dashboard-header">
  <div class="dashboard-header-content">
    <h1 class="dashboard-title">Order #{{ $commande->id }}</h1>
  </div>
</div>
<div class="dashboard-content">
  <div class="card">
    <div class="card-body">
      <div class="mb-3"><strong>Customer:</strong> {{ optional($commande->user)->name ?? '—' }}</div>
      <div class="mb-3"><strong>Total:</strong> {{ number_format($commande->montant, 2) }}</div>
      <div class="mb-3"><strong>Date:</strong> {{ optional($commande->date ?? $commande->created_at)->format('Y-m-d H:i') }}</div>
      <div class="mb-3"><strong>Products:</strong>
        <pre class="p-2 bg-light" style="white-space: pre-wrap;">{{ json_encode($commande->liste_produits, JSON_PRETTY_PRINT) }}</pre>
      </div>
      <a href="{{ route('commandes.edit', $commande) }}" class="btn btn-primary">Edit</a>
      <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Back</a>
    </div>
  </div>
</div>
@endsection
