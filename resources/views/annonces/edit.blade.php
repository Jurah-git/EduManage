
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-pencil-square text-primary me-2"></i>
                Modifier une annonce
            </h2>
            <p class="text-muted mb-0">
                Modifiez les informations de cette communication.
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
                {{ $annonce->titre }}
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('annonces.update', $annonce) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            Titre de l'annonce *
                        </label>

                        <input type="text"
                               name="titre"
                               class="form-control @error('titre') is-invalid @enderror"
                               value="{{ old('titre', $annonce->titre) }}"
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
                            @foreach([
                                'information' => 'Information',
                                'evenement' => 'Événement',
                                'reunion' => 'Réunion',
                                'urgence' => 'Urgence',
                                'autre' => 'Autre'
                            ] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('categorie', $annonce->categorie) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Public concerné *
                        </label>

                        <select name="public_cible" class="form-select" required>
                            <option value="parents"
                                {{ old('public_cible', $annonce->public_cible) === 'parents' ? 'selected' : '' }}>
                                Parents
                            </option>

                            <option value="tous"
                                {{ old('public_cible', $annonce->public_cible) === 'tous' ? 'selected' : '' }}>
                                Tous les utilisateurs
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Statut *
                        </label>

                        <select name="statut" class="form-select" required>
                            <option value="brouillon"
                                {{ old('statut', $annonce->statut) === 'brouillon' ? 'selected' : '' }}>
                                Brouillon
                            </option>

                            <option value="publie"
                                {{ old('statut', $annonce->statut) === 'publie' ? 'selected' : '' }}>
                                Publiée
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
                                  required>{{ old('contenu', $annonce->contenu) }}</textarea>

                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Les modifications d'une annonce publiée seront immédiatement visibles par les parents.
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('annonces.index') }}"
                       class="btn btn-light border">
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection
