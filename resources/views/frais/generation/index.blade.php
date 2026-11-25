@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Génération des frais scolaires</h3>
                <p class="text-muted mb-0">
                    Générer automatiquement les frais des élèves inscrits et validés.
                </p>
            </div>
            <a href="{{ route('frais.tarifs.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour aux tarifs
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-receipt"></i> Générer les frais mensuels
                </h5>
            </div>

            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Information :</strong>
                    Les frais seront générés uniquement pour les élèves ayant une
                    inscription validée dans la classe et l'année scolaire du tarif choisi.
                    Les frais déjà générés pour la même période ne seront pas dupliqués.
                </div>

                <form action="{{ route('frais.generation.generer') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="tarif_frais_id" class="form-label">
                                Tarif scolaire <span class="text-danger">*</span>
                            </label>

                            <select name="tarif_frais_id" id="tarif_frais_id"
                                class="form-select @error('tarif_frais_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un tarif --</option>

                                @foreach ($tarifs as $tarif)
                                    @if ($tarif->typeFrais && $tarif->typeFrais->frequence === 'mensuelle')
                                        <option value="{{ $tarif->id }}"
                                            {{ old('tarif_frais_id') == $tarif->id ? 'selected' : '' }}>
                                            {{ $tarif->typeFrais->nom }}
                                            — {{ $tarif->classe->nom ?? 'Classe inconnue' }}
                                            — {{ $tarif->anneeScolaire->nom ?? 'Année inconnue' }}
                                            — {{ number_format($tarif->montant, 0, ',', ' ') }} Ar
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            @error('tarif_frais_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="mois" class="form-label">
                                Mois <span class="text-danger">*</span>
                            </label>

                            <select name="mois" id="mois" class="form-select @error('mois') is-invalid @enderror"
                                required>
                                <option value="">-- Choisir --</option>
                                @php
                                    $nomsMois = [
                                        1 => 'Janvier',
                                        2 => 'Février',
                                        3 => 'Mars',
                                        4 => 'Avril',
                                        5 => 'Mai',
                                        6 => 'Juin',
                                        7 => 'Juillet',
                                        8 => 'Août',
                                        9 => 'Septembre',
                                        10 => 'Octobre',
                                        11 => 'Novembre',
                                        12 => 'Décembre',
                                    ];
                                @endphp

                                @foreach ($nomsMois as $numero => $nom)
                                    <option value="{{ $numero }}" {{ old('mois') == $numero ? 'selected' : '' }}>
                                        {{ $nom }}
                                    </option>
                                @endforeach
                            </select>

                            @error('mois')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="annee" class="form-label">
                                Année <span class="text-danger">*</span>
                            </label>

                            <input type="number" name="annee" id="annee"
                                class="form-control @error('annee') is-invalid @enderror" min="2000" max="2100"
                                value="{{ old('annee', now()->year) }}" required>

                            @error('annee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="date_echeance" class="form-label">
                                Date limite de paiement <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="date_echeance" id="date_echeance"
                                class="form-control @error('date_echeance') is-invalid @enderror"
                                value="{{ old('date_echeance') }}" required>

                            @error('date_echeance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted">
                                La date limite doit appartenir au mois sélectionné.
                            </small>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('Confirmer la génération des frais pour les élèves inscrits et validés ?')">
                            <i class="bi bi-gear"></i> Générer les frais
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0">Tarifs mensuels disponibles</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Type de frais</th>
                                <th>Classe</th>
                                <th>Année scolaire</th>
                                <th class="text-end">Montant</th>
                                <th>Validité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tarifs as $tarif)
                                @if ($tarif->typeFrais && $tarif->typeFrais->frequence === 'mensuelle')
                                    <tr>
                                        <td>{{ $tarif->typeFrais->nom }}</td>
                                        <td>{{ $tarif->classe->nom ?? '-' }}</td>
                                        <td>{{ $tarif->anneeScolaire->nom ?? '-' }}</td>
                                        <td class="text-end fw-bold">
                                            {{ number_format($tarif->montant, 0, ',', ' ') }} Ar
                                        </td>
                                        <td>
                                            {{ $tarif->date_debut?->format('d/m/Y') ?? '-' }}
                                            au
                                            {{ $tarif->date_fin?->format('d/m/Y') ?? '-' }}
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Aucun tarif disponible.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
