@extends('layouts.app')

@section('title', ' - Passer une commande')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Passer une commande</h1>
        <a href="{{ route('front.orders.index') }}" class="btn btn-secondary">Mes commandes</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez corriger les erreurs ci-dessous :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('front.orders.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Produit</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                            <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" data-price="{{ $p->prix_base }}">
                                        {{ $p->nom }} ({{ number_format($p->prix_base,2,',',' ') }} €)
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Choisissez le produit que vous souhaitez commander.</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Quantité</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                            <input type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}" class="form-control @error('quantity') is-invalid @enderror" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Nombre d'unités.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Montant TTC (auto-calculé)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
                            <input type="text" id="montant_ttc" class="form-control" placeholder="Sera calculé automatiquement" readonly>
                        </div>
                        <small class="text-muted">prix × quantité + 10% TVA</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Confirmer la commande</button>
                    <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">Continuer vos achats</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function() {
    const select = document.querySelector('select[name="product_id"]');
    const qty = document.querySelector('input[name="quantity"]');
    const out = document.getElementById('montant_ttc');
    function compute() {
        const opt = select && select.options[select.selectedIndex];
        const price = parseFloat(opt && opt.dataset ? opt.dataset.price : 0) || 0;
        const q = parseInt(qty && qty.value ? qty.value : '0', 10) || 0;
        const montant = Math.round((price * q * 1.10) * 100) / 100;
        out.value = q > 0 && price > 0 ? montant.toFixed(2) + ' €' : '';
    }
    if (select) select.addEventListener('change', compute);
    if (qty) qty.addEventListener('input', compute);
    compute();
})();
</script>
@endsection
