@extends('layouts.backoffice')

@section('title', ' - Nouvelle Livraison')

@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <h1 class="dashboard-title">Nouvelle Livraison</h1>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('livraisons.store') }}">
            @csrf
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
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Commande</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-receipt"></i></span>
                        <select name="id_commande" class="form-select @error('id_commande') is-invalid @enderror" required>
                            @foreach($commandes as $cmd)
                                <option value="{{ $cmd->id }}" {{ old('id_commande') == $cmd->id ? 'selected' : '' }}>#{{ $cmd->id }} - {{ optional($cmd->utilisateur)->name }}</option>
                            @endforeach
                        </select>
                        @error('id_commande')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Trajet</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-route"></i></span>
                        <select name="id_trajet" class="form-select @error('id_trajet') is-invalid @enderror">
                            <option value="">-- Aucun --</option>
                            @foreach($trajets as $trj)
                                <option value="{{ $trj->id }}" {{ old('id_trajet') == $trj->id ? 'selected' : '' }}>#{{ $trj->id }} - {{ optional($trj->vehicule)->immatriculation }}</option>
                            @endforeach
                        </select>
                        @error('id_trajet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Employé</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        <select name="id_utilisateur" class="form-select @error('id_utilisateur') is-invalid @enderror">
                            <option value="">-- Aucun --</option>
                            @foreach($employes as $emp)
                                <option value="{{ $emp->id }}" {{ old('id_utilisateur') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                            @endforeach
                        </select>
                        @error('id_utilisateur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Adresse de livraison</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" name="adresse_livraison" value="{{ old('adresse_livraison') }}" class="form-control @error('adresse_livraison') is-invalid @enderror" placeholder="12 Rue Exemple, Ville" required>
                        @error('adresse_livraison')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date livraison</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        <input type="date" name="date_livraison" value="{{ old('date_livraison') }}" class="form-control @error('date_livraison') is-invalid @enderror">
                        @error('date_livraison')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        <select name="statut" class="form-select @error('statut') is-invalid @enderror" required>
                            @php($statuts = ['en_attente' => 'En attente', 'en_cours' => 'En cours', 'livré' => 'Livré', 'annulé' => 'Annulé'])
                            @foreach($statuts as $key => $label)
                                <option value="{{ $key }}" {{ old('statut', 'en_attente') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('livraisons.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
