@extends('layouts.app')

@section('content')
    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><i class="bi bi-pencil-square"></i> Modifier un tarif</h2>
                <p class="text-muted mb-0">Modification du tarif scolaire.</p>
            </div>

            <a href="{{ route('frais.tarifs.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <strong>Informations du tarif</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('frais.tarifs.update', $tarif->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="type_frais_id" class="form-label">
                                Type de frais <span class="text-danger">*</span>
                            </label>

                            <select name="type_frais_id" id="type_frais_id"
                                class="form-select @error('type_frais_id') is-invalid @enderror" required>
                                <option value="">-- Choisir un type de frais --</option>

                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" @selected(old('type_frais_id', $tarif->type_frais_id) == $type->id)>
                                        {{ $type->nom }}
                                    </option>
                                @endforeach
                            </select>

                            @error('type_frais_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="annee_scolaire_id" class="form-label">
                                Année scolaire <span class="text-danger">*</span>
                            </label>

                            <select name="annee_scolaire_id" id="annee_scolaire_id"
                                class="form-select @error('annee_scolaire_id') is-invalid @enderror" required>
                                <option value="">-- Choisir une année scolaire --</option>

                                @foreach ($annees as $annee)
                                    <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id', $tarif->annee_scolaire_id) == $annee->id)>
                                        {{ $annee->nom }}
                                        {{ $annee->active ? '(Active)' : '' }}
                                    </option>
                                @endforeach
                            </select>

                            @error('annee_scolaire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="classe_id" class="form-label">
                                Classe <span class="text-danger">*</span>
                            </label>

                            <select name="classe_id" id="classe_id"
                                class="form-select @error('classe_id') is-invalid @enderror" required>
                                <option value="">-- Choisir une classe --</option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}" @selected(old('classe_id', $tarif->classe_id) == $classe->id)>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>

                            @error('classe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="montant" class="form-label">
                                Montant (Ariary) <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">
                                <input type="number" name="montant" id="montant"
                                    class="form-control @error('montant') is-invalid @enderror"
                                    value="{{ old('montant', $tarif->montant) }}" min="0.01" step="0.01" required>
                                <span class="input-group-text">Ar</span>

                                @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" name="date_debut" id="date_debut"
                                class="form-control @error('date_debut') is-invalid @enderror"
                                value="{{ old('date_debut', $tarif->date_debut ? \Carbon\Carbon::parse($tarif->date_debut)->format('Y-m-d') : '') }}">

                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" name="date_fin" id="date_fin"
                                class="form-control @error('date_fin') is-invalid @enderror"
                                value="{{ old('date_fin', $tarif->date_fin ? \Carbon\Carbon::parse($tarif->date_fin)->format('Y-m-d') : '') }}">

                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="actif" id="actif" class="form-check-input" value="1"
                                    @checked(old('actif', $tarif->actif) == '1')>
                                <label for="actif" class="form-check-label">
                                    Tarif actif
                                </label>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Enregistrer les modifications
                        </button>

                        <a href="{{ route('frais.tarifs.index') }}" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
