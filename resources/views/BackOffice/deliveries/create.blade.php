@extends('layouts.backoffice')

@section('title', ' - Nouvelle livraison')

@section('content')
<div class="dashboard-header">
  <div class="dashboard-header-content">
    <h1 class="dashboard-title">Créer une livraison</h1>
  </div>
</div>
<div class="dashboard-content">
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('livraisons.store') }}">
        @csrf
        <div class="row">
          <div class="col-6">
            <div class="form-group">
            <label class="form-label">Commande</label>
            <select name="commande_id" class="form-control form-select @error('commande_id') is-invalid @enderror" required>
              <option value="">-- Sélectionner --</option>
              @foreach($commandes as $c)
                <option value="{{ $c->id }}">#{{ $c->id }}</option>
              @endforeach
            </select>
            @error('commande_id')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
            <label class="form-label">Trajet</label>
            <select name="trajet_id" class="form-control form-select @error('trajet_id') is-invalid @enderror" required>
              <option value="">-- Sélectionner --</option>
              @foreach($trajets as $t)
                <option value="{{ $t->id }}">{{ $t->point_depart }} → {{ $t->point_arrivee }} ({{ optional($t->date)->format('Y-m-d') }})</option>
              @endforeach
            </select>
            @error('trajet_id')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
            <label class="form-label">Adresse de livraison</label>
            <input type="text" name="adresse_livraison" class="form-control @error('adresse_livraison') is-invalid @enderror" value="{{ old('adresse_livraison') }}" required>
            @error('adresse_livraison')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
            <label class="form-label">Date de livraison</label>
            <input type="datetime-local" name="date_livraison" class="form-control @error('date_livraison') is-invalid @enderror" value="{{ old('date_livraison') }}">
            @error('date_livraison')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
            <label class="form-label">Statut</label>
            <select name="statut" class="form-control form-select @error('statut') is-invalid @enderror" required>
              <option value="en_preparation" @selected(old('statut')==='en_preparation')>En préparation</option>
              <option value="en_cours" @selected(old('statut')==='en_cours')>En cours</option>
              <option value="livree" @selected(old('statut')==='livree')>Livrée</option>
              <option value="annulee" @selected(old('statut')==='annulee')>Annulée</option>
            </select>
            @error('statut')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
            <label class="form-label">Employé (optionnel)</label>
            <select name="user_id" class="form-control form-select @error('user_id') is-invalid @enderror">
              <option value="">-- Aucun --</option>
              @foreach($employes as $u)
                <option value="{{ $u->id }}">{{ $u->name }}</option>
              @endforeach
            </select>
            @error('user_id')<span class="form-feedback is-invalid">{{ $message }}</span>@enderror
            </div>
          </div>
        </div>
        <div class="mt-4">
          <button class="btn btn-primary">Enregistrer</button>
          <a class="btn btn-secondary" href="{{ route('livraisons.index') }}">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
