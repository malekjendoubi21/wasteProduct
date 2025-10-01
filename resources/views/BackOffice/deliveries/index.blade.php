@extends('layouts.backoffice')

@section('title', ' - Livraisons')

@section('content')
<div class="dashboard-header">
  <div class="dashboard-header-content">
    <h1 class="dashboard-title">Livraisons</h1>
    <p class="dashboard-subtitle">Gérer les livraisons des commandes</p>
  </div>
  <div class="dashboard-header-actions">
    <a class="btn btn-primary" href="{{ route('livraisons.create') }}">Nouvelle livraison</a>
  </div>
</div>
<div class="dashboard-content">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Commande</th>
              <th>Adresse</th>
              <th>Date</th>
              <th>Statut</th>
              <th>Trajet</th>
              <th>Employé</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          @forelse($livraisons as $l)
            <tr>
              <td>{{ $l->id }}</td>
              <td>#{{ $l->commande_id }}</td>
              <td>{{ $l->adresse_livraison }}</td>
              <td>{{ optional($l->date_livraison ?? $l->created_at)->format('Y-m-d') }}</td>
              <td>{{ $l->statut }}</td>
              <td>{{ optional($l->trajet)->point_depart }} → {{ optional($l->trajet)->point_arrivee }}</td>
              <td>{{ optional($l->employe)->name ?? '—' }}</td>
              <td>
                <a class="btn btn-sm" href="{{ route('livraisons.show', $l) }}">Voir</a>
                <a class="btn btn-sm" href="{{ route('livraisons.edit', $l) }}">Editer</a>
                <form method="POST" action="{{ route('livraisons.destroy', $l) }}" class="inline">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette livraison ?')">Supprimer</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="text-center">Aucune livraison</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
      @if(method_exists($livraisons,'links'))
        <div class="mt-3">{{ $livraisons->links() }}</div>
      @endif
    </div>
  </div>
</div>
@endsection
