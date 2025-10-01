@extends('layouts.backoffice')

@section('title', ' - Modifier Commande #'.$commande->id)

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <h1 class="dashboard-title">Modifier Commande #{{ $commande->id }}</h1>
    </div>
    <div class="dashboard-header-actions">
        <a href="{{ route('orders.show', $commande) }}" class="btn btn-secondary">Retour</a>
    </div>
    
</div>
<div class="card">
    <div class="card-body">
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

        <form method="POST" action="{{ route('orders.update', $commande) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Client</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <select name="id_utilisateur" class="form-select @error('id_utilisateur') is-invalid @enderror" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('id_utilisateur', $commande->id_utilisateur) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('id_utilisateur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Montant TTC (auto-calculé)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
                        <input type="text" id="montant_ttc" class="form-control" value="{{ number_format($commande->montant, 2, ',', ' ') }} €" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Produit</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-box"></i></span>
                        <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                            @foreach(\App\Models\Product::orderBy('nom')->get() as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->prix_base }}" {{ old('product_id', $commande->product_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nom }} ({{ number_format($p->prix_base,2,',',' ') }} €)
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Quantité</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                        <input type="number" min="1" name="quantity" value="{{ old('quantity', $commande->quantity) }}" class="form-control @error('quantity') is-invalid @enderror">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('orders.show', $commande) }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
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
