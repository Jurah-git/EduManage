@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-pencil-square text-primary"></i>
                Modifier l'emploi du temps
            </h2>
            <p class="text-muted mb-0">
                Modifier les informations générales de l'emploi du temps.
            </p>
        </div>

        <a href="{{ route('emplois-temps.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">Informations générales</h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('emplois-temps.update', $emploiTemps) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="classe_id" class="form-label fw-semibold">
                            Classe <span class="text-danger">*</span>
                        </label>

                        <select name="classe_id" id="classe_id"
                                class="form-select @error('classe_id') is-invalid @enderror"
                                required>
                            <option value="">-- Sélectionner une classe --</option>

                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    {{ old('classe_id', $emploiTemps->classe_id) == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>

                        @error('classe_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="annee_scolaire_id" class="form-label fw-semibold">
                            Année scolaire <span class="text-danger">*</span>
                        </label>

                        <select name="annee_scolaire_id" id="annee_scolaire_id"
                                class="form-select @error('annee_scolaire_id') is-invalid @enderror"
                                required>
                            <option value="">-- Sélectionner une année scolaire --</option>

                            @foreach($anneesScolaires as $annee)
                                <option value="{{ $annee->id }}"
                                    {{ old('annee_scolaire_id', $emploiTemps->annee_scolaire_id) == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->nom ?? $annee->libelle ?? $annee->annee ?? $annee->id }}
                                </option>
                            @endforeach
                        </select>

                        @error('annee_scolaire_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="titre" class="form-label fw-semibold">
                            Titre (facultatif)
                        </label>

                        <input type="text" name="titre" id="titre"
                               class="form-control @error('titre') is-invalid @enderror"
                               value="{{ old('titre', $emploiTemps->titre) }}"
                               placeholder="Ex. Emploi du temps de la classe de 6ème">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('emplois-temps.show', $emploiTemps) }}"
                       class="btn btn-light border">
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
