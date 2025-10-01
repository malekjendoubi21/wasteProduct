@extends('layouts.backoffice')

@section('title', ' - Détail Demande Partenariat')

@section('content')
    <div class="dashboard-header">
        <h1 class="dashboard-title">Détail de la demande</h1>
        <p class="dashboard-subtitle">{{ $demande->nom_organisation }}</p>
    </div>

    <div class="dashboard-content">
        <div class="card">
            <div class="card-body">
                <p><strong>Nom de l'organisation :</strong> {{ $demande->nom_organisation }}</p>
                <p><strong>Type :</strong> {{ $demande->type_organisation }}</p>
                <p><strong>Secteur :</strong> {{ $demande->secteur_activite }}</p>
                <p><strong>Email :</strong> {{ $demande->email_contact }}</p>
                <p><strong>Téléphone :</strong> {{ $demande->telephone_contact }}</p>
                <p><strong>Adresse :</strong> {{ $demande->adresse }}</p>
                <p><strong>Message :</strong> {{ $demande->message }}</p>
                <p><strong>Logo :</strong>
                    @if($demande->logo)
                        @php
                            // Ajuste le chemin pour utiliser uniquement le nom de fichier après 'images/'
                            $logoPath = str_replace('images/', '', $demande->logo);
                        @endphp
                        <img src="{{ asset('images/' . $logoPath) }}" alt="Logo" width="100" 
                             onerror="this.onerror=null; this.src='{{ asset('images/default-logo.png') }}'; this.alt='Logo par défaut';">
                    @else
                        N/A
                    @endif
                </p>
                <p><strong>Statut :</strong> 
                    @if($demande->statut == 'en_attente')
                        <span class="badge bg-warning">En attente</span>
                    @elseif($demande->statut == 'accepte')
                        <span class="badge bg-success">Accepté</span>
                    @else
                        <span class="badge bg-danger">Refusé</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection