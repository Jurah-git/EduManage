
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
            Découvrez les activités parascolaires proposées par notre établissement.
            Cette page est réservée à la consultation des informations.
        </p>
    </div>

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

    {{-- INFORMATIONS PARENT --}}
    <div class="alert alert-info border-0 shadow-sm mb-4">
        <i class="fas fa-info-circle me-2"></i>
        Vous pouvez consulter les activités, leurs horaires et leurs tarifs
        indicatifs. Pour toute demande d'inscription, contactez l'administration.
    </div>

    {{-- LISTE DES ACTIVITÉS --}}
    <div class="row">

        @forelse($activites as $activite)

            <div class="col-md-6 col-xl-4 mb-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">

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

                        {{-- TARIF --}}
                        <p class="mb-3">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                            <strong>Tarif indicatif :</strong><br>

                            @if($activite->tarif_indicatif !== null)
                                {{ number_format((float) $activite->tarif_indicatif, 0, ',', ' ') }} Ar
                            @else
                                À confirmer auprès de l'administration
                            @endif
                        </p>

                        {{-- PÉRIODICITÉ --}}
                        @if($activite->periodicite)
                            <p class="mb-3">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <strong>Périodicité :</strong>
                                {{ $activite->periodicite }}
                            </p>
                        @endif

                        {{-- JOURS --}}
                        @if(!empty($activite->jours))
                            <p class="mb-3">
                                <i class="fas fa-calendar-day text-primary me-2"></i>
                                <strong>Jours :</strong>
                                {{ implode(', ', $activite->jours) }}
                            </p>
                        @endif

                        {{-- HORAIRES --}}
                        @if($activite->heure_debut && $activite->heure_fin)
                            <p class="mb-0">
                                <i class="fas fa-hourglass-half text-primary me-2"></i>
                                <strong>Horaires :</strong>
                                {{ substr($activite->heure_debut, 0, 5) }}
                                -
                                {{ substr($activite->heure_fin, 0, 5) }}
                            </p>
                        @endif

                    </div>

                    {{-- CONSULTATION UNIQUEMENT --}}
                    <div class="card-footer border-0 p-3">
                        <div class="alert alert-light border mb-0">
                            <i class="fas fa-eye text-primary me-2"></i>
                            <span class="text-muted">
                                Activité disponible en consultation.
                            </span>
                        </div>
                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info shadow-sm">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucune activité parascolaire n'est actuellement disponible.
                </div>
            </div>

        @endforelse

    </div>

</div>

@endsection
