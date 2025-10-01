@extends('layouts.backoffice')

@section('title', ' - Edit Order')

@section('content')
<div class="dashboard-header">
  <div class="dashboard-header-content">
    <h1 class="dashboard-title">Edit Order #{{ $commande->id }}</h1>
  </div>
</div>
<div class="dashboard-content">
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('commandes.update', $commande) }}" id="order-form">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label class="form-label">Date</label>
          <input type="datetime-local" name="date" class="form-control" value="{{ old('date', optional($commande->date)->format('Y-m-d\TH:i')) }}">
          @error('date')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label class="form-label">Items</label>
          <div id="items">
            @php $idx = 0; @endphp
            @foreach($commande->liste_produits ?? [] as $it)
            <div class="item-row d-flex gap-2 mb-2">
              <select class="form-control" name="items[{{ $idx }}][produit_id]" required>
                <option value="">Select product</option>
                @foreach($produits as $p)
                  <option value="{{ $p->id }}" data-price="{{ $p->prix_base }}" @selected($p->id == ($it['produit_id'] ?? null))>{{ $p->nom }} ({{ number_format($p->prix_base, 2) }})</option>
                @endforeach
              </select>
              <input type="number" class="form-control" name="items[{{ $idx }}][quantite]" value="{{ $it['quantite'] ?? 1 }}" min="1" required>
              <button type="button" class="btn btn-outline-danger" onclick="removeItemRow(this)">Remove</button>
            </div>
            @php $idx++; @endphp
            @endforeach
            @if(($commande->liste_produits ?? []) === [])
            <div class="item-row d-flex gap-2 mb-2">
              <select class="form-control" name="items[0][produit_id]" required>
                <option value="">Select product</option>
                @foreach($produits as $p)
                  <option value="{{ $p->id }}" data-price="{{ $p->prix_base }}">{{ $p->nom }} ({{ number_format($p->prix_base, 2) }})</option>
                @endforeach
              </select>
              <input type="number" class="form-control" name="items[0][quantite]" value="1" min="1" required>
              <button type="button" class="btn btn-outline-danger" onclick="removeItemRow(this)">Remove</button>
            </div>
            @endif
          </div>
          <button type="button" class="btn btn-outline-primary mt-2" onclick="addItemRow()">Add item</button>
        </div>

        <div class="mb-3"><strong>Total: </strong><span id="total">{{ number_format($commande->montant, 2) }}</span></div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
let itemIndex = document.querySelectorAll('#items .item-row').length || 1;
function addItemRow() {
  const items = document.getElementById('items');
  const row = document.createElement('div');
  row.className = 'item-row d-flex gap-2 mb-2';
  row.innerHTML = `
    <select class="form-control" name="items[${itemIndex}][produit_id]" required>
      <option value="">Select product</option>
      ${Array.from(document.querySelectorAll('#items select:first-of-type option')).map(o=>o.outerHTML).join('')}
    </select>
    <input type="number" class="form-control" name="items[${itemIndex}][quantite]" value="1" min="1" required>
    <button type="button" class="btn btn-outline-danger" onclick="removeItemRow(this)">Remove</button>
  `;
  items.appendChild(row);
  itemIndex++;
}
function removeItemRow(btn){
  const row = btn.closest('.item-row');
  row.parentNode.removeChild(row);
}
</script>
@endpush
