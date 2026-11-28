
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4 parent-dashboard">

    {{-- EN-TÊTE --}}
    <div class="mb-4">
        <span class="badge rounded-pill bg-primary-subtle text-primary mb-2">
            ESPACE PERSONNEL
        </span>

        <h2 class="fw-bold mb-2">
            <i class="fas fa-user-circle me-2"></i>
            Espace Parent
        </h2>

        <p class="text-muted mb-0">
            Bienvenue {{ $parent->prenom }} {{ $parent->nom }}.
            Retrouvez ici les informations scolaires de vos enfants.
        </p>
    </div>

    {{-- STATISTIQUES --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-primary-subtle text-primary p-3 me-3">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Mes enfants</div>
                        <h3 class="fw-bold mb-0">
                            {{ $parent->eleves->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-success-subtle text-success p-3 me-3">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Statut du compte</div>
                        <h5 class="fw-bold mb-0">Parent actif</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-warning-subtle text-warning p-3 me-3">
                        <i class="fas fa-school fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Plateforme</div>
                        <h5 class="fw-bold mb-0">EduManage</h5>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- INFORMATIONS DU PARENT --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">
                <i class="fas fa-id-card text-primary me-2"></i>
                Mes informations
            </h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <div class="text-muted small">Nom</div>
                    <strong>{{ $parent->nom }}</strong>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Prénom</div>
                    <strong>{{ $parent->prenom }}</strong>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Téléphone</div>
                    <strong>{{ $parent->telephone ?? 'Non renseigné' }}</strong>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Adresse email</div>
                    <strong>{{ $parent->email ?? 'Non renseigné' }}</strong>
                </div>

            </div>
        </div>
    </div>

    {{-- ACCÈS AUX SERVICES --}}
    <div class="mb-3">
        <h5 class="fw-bold">
            <i class="fas fa-th-large text-primary me-2"></i>
            Mes services scolaires
        </h5>

        <p class="text-muted small">
            Consultez les informations concernant la scolarité de vos enfants.
        </p>
    </div>

    <div class="row g-3 mb-4">

        {{-- MES ENFANTS --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('parent.enfants') }}"
               class="card parent-service-card border-0 shadow-sm h-100 text-decoration-none">
                <div class="card-body p-4">
                    <div class="service-icon bg-primary-subtle text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6 class="fw-bold mt-3">Mes enfants</h6>
                    <p class="text-muted small mb-3">
                        Consulter les informations de mes enfants inscrits.
                    </p>
                    <span class="text-primary small fw-bold">
                        Consulter <i class="fas fa-arrow-right ms-1"></i>
                    </span>
                </div>
            </a>
        </div>

        {{-- EMPLOI DU TEMPS --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('parent.emploi-temps') }}"
               class="card parent-service-card border-0 shadow-sm h-100 text-decoration-none">
                <div class="card-body p-4">
                    <div class="service-icon bg-success-subtle text-success">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h6 class="fw-bold mt-3">Emploi du temps</h6>
                    <p class="text-muted small mb-3">
                        Consulter les horaires et les matières de chaque enfant.
                    </p>
                    <span class="text-success small fw-bold">
                        Consulter <i class="fas fa-arrow-right ms-1"></i>
                    </span>
                </div>
            </a>
        </div>

       
        {{-- NOTES ET BULLETINS --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('parent.notes.index') }}"
               class="card parent-service-card border-0 shadow-sm h-100 text-decoration-none">

                <div class="card-body p-4">

                    <div class="service-icon bg-primary-subtle text-primary">
                        <i class="fas fa-graduation-cap"></i>
                    </div>

                    <h6 class="fw-bold mt-3">
                        Notes et bulletins
                    </h6>

                    <p class="text-muted small mb-3">
                        Consulter les résultats scolaires et les bulletins de mes enfants.
                    </p>

                    <span class="text-primary small fw-bold">
                        Consulter
                        <i class="fas fa-arrow-right ms-1"></i>
                    </span>

                </div>
            </a>
        </div>

{{-- FRAIS ET ÉCOLAGES --}}
<div class="col-md-6 col-xl-3">
    <a href="{{ route('parent.frais') }}"
       class="card parent-service-card border-0 shadow-sm h-100 text-decoration-none">
        <div class="card-body p-4">
            <div class="service-icon bg-success-subtle text-success">
                <i class="fas fa-wallet"></i>
            </div>

            <h6 class="fw-bold mt-3">Frais et écolages</h6>

            <p class="text-muted small mb-3">
                Consulter les frais scolaires, les montants payés et les soldes de mes enfants.
            </p>

            <span class="text-success small fw-bold">
                Consulter <i class="fas fa-arrow-right ms-1"></i>
            </span>
        </div>
    </a>
</div>
        {{-- HISTORIQUE DES PAIEMENTS --}}
<div class="col-md-6 col-xl-3">
    <a href="{{ route('parent.paiements.historique') }}"
       class="card parent-service-card border-0 shadow-sm h-100 text-decoration-none">
        <div class="card-body p-4">
            <div class="service-icon bg-primary-subtle text-primary">
                <i class="fas fa-receipt"></i>
            </div>

            <h6 class="fw-bold mt-3">Historique des paiements</h6>

            <p class="text-muted small mb-3">
                Consultez les paiements et les reçus enregistrés pour vos enfants.
            </p>

            <span class="text-primary small fw-bold">
                Consulter <i class="fas fa-arrow-right ms-1"></i>
            </span>
        </div>
    </a>
</div>
        
        {{-- ANNONCES ET COMMUNICATIONS --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('parent.annonces.index') }}"
               class="card parent-service-card border-0 shadow-sm h-100 text-decoration-none">

                <div class="card-body p-4">

                    <div class="service-icon bg-warning-subtle text-warning">
                        <i class="fas fa-bullhorn"></i>
                    </div>

                    <h6 class="fw-bold mt-3">
                        Annonces et communications
                    </h6>

                    <p class="text-muted small mb-3">
                        Lire les informations et annonces de l'établissement.
                    </p>

                    <span class="text-warning small fw-bold">
                        Consulter
                        <i class="fas fa-arrow-right ms-1"></i>
                    </span>

                </div>
            </a>
        </div>
        {{-- DISCUSSION AVEC L'ADMINISTRATION --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('parent.messagerie.index') }}"
               class="card parent-service-card border-0 shadow-sm h-100 text-decoration-none">
                <div class="card-body p-4">
                    <div class="service-icon bg-primary-subtle text-primary">
                        <i class="fas fa-comments"></i>
                    </div>

                    <h6 class="fw-bold mt-3">
                        Discussion avec l'administration
                    </h6>

                    <p class="text-muted small mb-3">
                        Envoyer un message et consulter les réponses de l'établissement.
                    </p>

                    <span class="text-primary small fw-bold">
                        Ouvrir la discussion
                        <i class="fas fa-arrow-right ms-1"></i>
                    </span>
                </div>
            </a>
        </div>

        {{-- ACTIVITÉS PARASCOLAIRES --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('parent.activites.index') }}"
               class="card parent-service-card border-0 shadow-sm h-100 text-decoration-none">
                <div class="card-body p-4">
                    <div class="service-icon bg-success-subtle text-success">
                        <i class="fas fa-running"></i>
                    </div>
                    <h6 class="fw-bold mt-3">Activités parascolaires</h6>
                    <p class="text-muted small mb-3">
                        Découvrir les activités proposées par l'école.
                    </p>
                    <span class="text-success small fw-bold">
                        Consulter <i class="fas fa-arrow-right ms-1"></i>
                    </span>
                </div>
            </a>
        </div>

    </div>

    {{-- LISTE DES ENFANTS --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-user-graduate me-2"></i>
                Mes enfants inscrits
            </h5>
        </div>

        <div class="card-body p-4">

            @forelse($parent->eleves as $eleve)

                <div class="border rounded-3 p-3 mb-3">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div>
                            <h5 class="fw-bold mb-2">
                                {{ $eleve->prenom }} {{ $eleve->nom }}
                            </h5>

                            <p class="text-muted mb-1">
                                <i class="fas fa-id-badge me-2"></i>
                                Matricule :
                                {{ $eleve->matricule ?? 'Non renseigné' }}
                            </p>

                            <p class="text-muted mb-1">
                                <i class="fas fa-school me-2"></i>
                                Classe :
                                {{ $eleve->classe->nom ?? 'Non renseignée' }}
                            </p>

                            <small class="text-muted">
                                Lien de parenté :
                                {{ $eleve->pivot->lien_parente ?? 'Non renseigné' }}
                            </small>
                        </div>

                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i>
                            Élève associé
                        </span>

                    </div>
                </div>

            @empty

                <div class="alert alert-info mb-0">
                    Aucun enfant n'est actuellement associé à votre compte.
                </div>

            @endforelse

            <a href="{{ route('parent.enfants') }}"
               class="btn btn-primary mt-2">
                <i class="fas fa-eye me-1"></i>
                Voir tous mes enfants
            </a>

        </div>
    </div>

    <div class="text-center text-muted small py-3">
        <i class="fas fa-shield-alt me-1"></i>
        Espace sécurisé — Consultation des informations scolaires uniquement.
    </div>

</div>

<style>
    .parent-service-card {
        color: inherit;
        border-radius: 14px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .parent-service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .12) !important;
    }

    .service-icon {
        width: 52px;
        height: 52px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    html[data-app-theme="dark"] .parent-dashboard .card,
    html[data-app-theme="ultra-pro"] .parent-dashboard .card {
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
    }

    html[data-app-theme="dark"] .parent-dashboard .border,
    html[data-app-theme="ultra-pro"] .parent-dashboard .border {
        border-color: rgba(255,255,255,.15) !important;
    }
</style>

@endsection
