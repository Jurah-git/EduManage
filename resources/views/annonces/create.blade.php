
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-megaphone-fill text-warning me-2"></i>
                Nouvelle annonce
            </h2>
            <p class="text-muted mb-0">
                Rédigez une communication destinée aux parents.
            </p>
        </div>

        <a href="{{ route('annonces.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Retour aux annonces
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez corriger les erreurs :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-pencil-square me-2"></i>
                Informations de l'annonce
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('annonces.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            Titre de l'annonce *
                        </label>
                        <input type="text"
                               name="titre"
                               class="form-control @error('titre') is-invalid @enderror"
                               value="{{ old('titre') }}"
                               placeholder="Exemple : Réunion des parents d'élèves"
                               required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Catégorie *
                        </label>
                        <select name="categorie" class="form-select" required>
                            <option value="information" {{ old('categorie', 'information') === 'information' ? 'selected' : '' }}>Information</option>
                            <option value="evenement" {{ old('categorie') === 'evenement' ? 'selected' : '' }}>Événement</option>
                            <option value="reunion" {{ old('categorie') === 'reunion' ? 'selected' : '' }}>Réunion</option>
                            <option value="urgence" {{ old('categorie') === 'urgence' ? 'selected' : '' }}>Urgence</option>
                            <option value="autre" {{ old('categorie') === 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Public concerné *
                        </label>
                        <select name="public_cible" class="form-select" required>
                            <option value="parents" {{ old('public_cible', 'parents') === 'parents' ? 'selected' : '' }}>
                                Parents
                            </option>
                            <option value="tous" {{ old('public_cible') === 'tous' ? 'selected' : '' }}>
                                Tous les utilisateurs (actuellement visible aux parents également)
                            </option>
                        </select>
                        <small class="text-muted">
                            Les parents verront les annonces destinées aux parents ou à tous.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Statut *
                        </label>
                        <select name="statut" class="form-select" required>
                            <option value="brouillon" {{ old('statut', 'brouillon') === 'brouillon' ? 'selected' : '' }}>
                                Enregistrer comme brouillon
                            </option>
                            <option value="publie" {{ old('statut') === 'publie' ? 'selected' : '' }}>
                                Publier immédiatement
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Contenu de l'annonce *
                        </label>
                        <textarea name="contenu"
                                  rows="9"
                                  class="form-control @error('contenu') is-invalid @enderror"
                                  placeholder="Rédigez ici le contenu complet de votre annonce..."
                                  required>{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Une annonce enregistrée comme brouillon ne sera pas visible par les parents.
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('annonces.index') }}"
                       class="btn btn-light border">
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        Enregistrer l'annonce
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
