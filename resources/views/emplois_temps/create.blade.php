```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar-plus text-primary me-2"></i>
                Nouvel emploi du temps
            </h2>
            <p class="text-muted mb-0">
                Créer un emploi du temps pour une classe et une année scolaire.
            </p>
        </div>

        <a href="{{ route('emplois-temps.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Retour à la liste
        </a>
    </div>

    {{-- Erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Informations générales
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('emplois-temps.store') }}" method="POST">
                        @csrf

                        {{-- Classe --}}
                        <div class="mb-4">
                            <label for="classe_id" class="form-label fw-semibold">
                                Classe <span class="text-danger">*</span>
                            </label>

                            <select name="classe_id" id="classe_id"
                                    class="form-select @error('classe_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Sélectionner une classe --</option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}"
                                        @selected(old('classe_id') == $classe->id)>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>

                            @error('classe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Année scolaire --}}
                        <div class="mb-4">
                            <label for="annee_scolaire_id" class="form-label fw-semibold">
                                Année scolaire <span class="text-danger">*</span>
                            </label>

                            <select name="annee_scolaire_id" id="annee_scolaire_id"
                                    class="form-select @error('annee_scolaire_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Sélectionner une année scolaire --</option>

                                @foreach ($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}"
                                        @selected(old('annee_scolaire_id') == $annee->id)>
                                        {{ $annee->nom ?? $annee->libelle ?? $annee->annee ?? $annee->id }}
                                    </option>
                                @endforeach
                            </select>

                            @error('annee_scolaire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Titre --}}
                        <div class="mb-4">
                            <label for="titre" class="form-label fw-semibold">
                                Titre de l'emploi du temps
                            </label>

                            <input type="text"
                                   name="titre"
                                   id="titre"
                                   class="form-control @error('titre') is-invalid @enderror"
                                   value="{{ old('titre') }}"
                                   placeholder="Ex. : Emploi du temps 6ème A">

                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Ce champ est facultatif. Tu peux le laisser vide.
                            </div>
                        </div>

                        {{-- Statut --}}
                        <div class="alert alert-info d-flex align-items-start gap-2">
                            <i class="bi bi-info-circle fs-5"></i>
                            <div>
                                <strong>Statut initial : Brouillon</strong>
                                <div>
                                    L'emploi du temps sera enregistré en brouillon.
                                    Tu pourras le publier après avoir ajouté les créneaux horaires.
                                </div>
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('emplois-temps.index') }}"
                               class="btn btn-light border">
                                Annuler
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                Enregistrer
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

