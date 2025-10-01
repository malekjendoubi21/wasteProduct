@extends('layouts.backoffice')

@section('title', 'Modifier une Association - BackOffice')
@section('page-title', 'Modifier une Association')
@section('page-subtitle', 'Modifier "{{ $association->name }}"')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <h1 class="dashboard-title">Modifier l'Association</h1>
            <p class="dashboard-subtitle">Modifier les informations de "{{ $association->name }}"</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('associations.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la liste</span>
            </a>
            <a href="{{ route('associations.show', $association) }}" class="btn btn-outline-info">
                <i class="fas fa-eye"></i>
                <span>Voir</span>
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informations de l'association</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('associations.update', $association) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $association->name) }}" placeholder="Nom de l'association" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $association->contact_email) }}" placeholder="contact@association.org" required>
                                        @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_phone" class="form-label">Téléphone</label>
                                        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $association->contact_phone) }}" placeholder="+33 123 456 789">
                                        @error('contact_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="domain" class="form-label">Domaine <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('domain') is-invalid @enderror" id="domain" name="domain" value="{{ old('domain', $association->domain) }}" placeholder="Ex: Environnement, Social" required>
                                        @error('domain')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Adresse <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="4" placeholder="Adresse complète..." required>{{ old('address', $association->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Décrivez l'association...">{{ old('description', $association->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="active" {{ old('status', $association->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                            <option value="inactive" {{ old('status', $association->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Mettre à jour
                                </button>
                                <a href="{{ route('associations.show', $association) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection