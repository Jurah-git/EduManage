
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- EN-TÊTE --}}
    <div class="mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-futbol me-2 text-primary"></i>
            Activités parascolaires
        </h2>

        <p class="text-muted">
            Découvrez les activités proposées par l'école et demandez
            l'inscription de vos enfants.
        </p>
    </div>

    {{-- MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Une erreur est survenue :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ANNÉE SCOLAIRE --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="fas fa-calendar-alt fa-2x text-primary me-3"></i>

                <div>
                    <h6 class="fw-bold mb-1">Année scolaire active</h6>

                    @if($anneeActive)
                        <span class="text-success">
                            {{ $anneeActive->nom }}
                        </span>
                    @else
                        <span class="text-danger">
                            Aucune année scolaire active.
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- LISTE DES ACTIVITÉS --}}
    <div class="row">

        @forelse($activites as $activite)

            <div class="col-md-6 col-xl-4 mb-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">

                            <span class="badge bg-primary">
                                {{ $activite->categorie ?? 'Activité' }}
                            </span>

                            <i class="fas fa-running fa-2x text-primary"></i>

                        </div>

                        <h5 class="fw-bold">
                            {{ $activite->nom }}
                        </h5>

                        <p class="text-muted">
                            {{ $activite->description ?? 'Aucune description disponible.' }}
                        </p>

                        <hr>

                        <p class="mb-2">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                            <strong>Tarif indicatif :</strong>

                            @if($activite->tarif_indicatif !== null)
                                {{ number_format((float) $activite->tarif_indicatif, 0, ',', ' ') }} Ar
                            @else
                                À confirmer auprès de l'administration
                            @endif
                        </p>

                        @if($activite->periodicite)
                            <p class="mb-2">
                                <i class="fas fa-clock text-primary me-2"></i>
                                {{ $activite->periodicite }}
                            </p>
                        @endif

                        @if($activite->jours)
                            <p class="mb-2">
                                <i class="fas fa-calendar-day text-primary me-2"></i>
                                {{ implode(', ', $activite->jours) }}
                            </p>
                        @endif

                        @if($activite->heure_debut && $activite->heure_fin)
                            <p class="mb-2">
                                <i class="fas fa-hourglass-half text-primary me-2"></i>
                                {{ substr($activite->heure_debut, 0, 5) }}
                                -
                                {{ substr($activite->heure_fin, 0, 5) }}
                            </p>
                        @endif

                    </div>

                    <div class="card-footer bg-white border-0 p-3">

                        @if($anneeActive && $parent->eleves->isNotEmpty())

                            <form method="POST"
                                  action="{{ route('parent.activites.store') }}">

                                @csrf

                                <input type="hidden"
                                       name="activite_parascolaire_id"
                                       value="{{ $activite->id }}">

                                <label class="form-label fw-semibold">
                                    Choisir mon enfant
                                </label>

                                <select name="eleve_id"
                                        class="form-select mb-3"
                                        required>

                                    <option value="">
                                        Sélectionner un enfant
                                    </option>

                                    @foreach($parent->eleves as $eleve)
                                        <option value="{{ $eleve->id }}"
                                            {{ (string) old('eleve_id') === (string) $eleve->id ? 'selected' : '' }}>
                                            {{ $eleve->prenom }} {{ $eleve->nom }}
                                        </option>
                                    @endforeach

                                </select>

                                <button type="submit"
                                        class="btn btn-primary w-100">

                                    <i class="fas fa-paper-plane me-1"></i>
                                    Demander une inscription

                                </button>

                            </form>

                        @elseif(!$anneeActive)

                            <button class="btn btn-secondary w-100" disabled>
                                Année scolaire indisponible
                            </button>

                        @else

                            <div class="alert alert-warning mb-0">
                                Aucun enfant associé à votre compte.
                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucune activité parascolaire n'est actuellement disponible.
                </div>
            </div>

        @endforelse

    </div>

    {{-- LIEN VERS LES DEMANDES --}}
    <div class="mt-3">
        <a href="{{ route('parent.activites.demandes') }}"
           class="btn btn-outline-primary">

            <i class="fas fa-list-alt me-1"></i>
            Consulter mes demandes

        </a>
    </div>

</div>

@endsection
