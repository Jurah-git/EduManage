@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4 parent-show-page">

        {{-- En-tête --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1 page-title">
                    <i class="bi bi-person-vcard-fill me-2"></i>
                    Fiche du parent
                </h2>
                <p class="text-secondary mb-0">
                    Consultation des informations et des enfants associés.
                </p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('parents.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour
                </a>

                <a href="{{ route('parents.edit', $parent) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i>
                    Modifier
                </a>
            </div>
        </div>

        {{-- Identité du parent --}}
        <div class="card border-0 shadow-sm parent-profile-card mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center flex-wrap gap-4">
                    <div class="parent-avatar">
                        {{ strtoupper(mb_substr($parent->prenom, 0, 1)) }}{{ strtoupper(mb_substr($parent->nom, 0, 1)) }}
                    </div>

                    <div class="flex-grow-1">
                        <h3 class="fw-bold mb-1">
                            {{ $parent->nom }} {{ $parent->prenom }}
                        </h3>

                        <p class="text-secondary mb-2">
                            Fiche parent #{{ $parent->id }}
                        </p>

                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge rounded-pill bg-light text-dark border">
                                <i class="bi bi-people me-1"></i>
                                {{ $parent->eleves->count() }}
                                enfant(s) associé(s)
                            </span>

                            @if ($parent->user_id)
                                <span class="badge rounded-pill bg-success-subtle text-success border">
                                    Compte utilisateur associé
                                </span>
                            @else
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary border">
                                    Aucun compte de connexion
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Coordonnées --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100 parent-info-card">
                    <div class="card-header bg-white border-0 p-4">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            Coordonnées
                        </h5>
                    </div>

                    <div class="card-body px-4 pt-0 pb-4">
                        <div class="info-item">
                            <span class="info-label">Nom complet</span>
                            <span class="info-value">
                                {{ $parent->nom }} {{ $parent->prenom }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Téléphone principal</span>
                            <span class="info-value">
                                {{ $parent->telephone ?: 'Non renseigné' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Téléphone secondaire</span>
                            <span class="info-value">
                                {{ $parent->telephone_secondaire ?: 'Non renseigné' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Adresse e-mail</span>
                            <span class="info-value">
                                {{ $parent->email ?: 'Non renseignée' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Profession</span>
                            <span class="info-value">
                                {{ $parent->profession ?: 'Non renseignée' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Adresse</span>
                            <span class="info-value">
                                {{ $parent->adresse ?: 'Non renseignée' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Fiche créée le</span>
                            <span class="info-value">
                                {{ $parent->created_at?->format('d/m/Y à H:i') ?? '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Enfants --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100 parent-info-card">
                    <div class="card-header bg-white border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-mortarboard-fill me-2"></i>
                                Enfants associés
                            </h5>

                            <span class="badge rounded-pill children-badge">
                                {{ $parent->eleves->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 pt-0">
                        @forelse ($parent->eleves as $eleve)
                            <div class="student-item">
                                <div class="student-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="fw-semibold">
                                        {{ $eleve->nom }} {{ $eleve->prenom }}
                                    </div>

                                    <small class="text-secondary d-block">
                                        Matricule : {{ $eleve->matricule ?: 'Non renseigné' }}
                                    </small>

                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <span class="badge bg-light text-dark border">
                                            {{ $eleve->pivot->lien_parente }}
                                        </span>

                                        @if ($eleve->pivot->responsable_legal)
                                            <span class="badge bg-primary-subtle text-primary">
                                                Responsable légal
                                            </span>
                                        @endif

                                        @if ($eleve->pivot->contact_principal)
                                            <span class="badge bg-success-subtle text-success">
                                                Contact principal
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-person-plus display-5 text-secondary"></i>
                                <h6 class="fw-bold mt-3">Aucun enfant associé</h6>
                                <p class="text-secondary mb-0">
                                    Modifiez cette fiche pour associer un élève.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .parent-show-page {
            color: #243447;
        }

        .parent-show-page .page-title {
            color: #102a43;
        }

        .parent-show-page .btn-primary {
            background: #102a43;
            border-color: #102a43;
            border-radius: 8px;
        }

        .parent-show-page .btn-primary:hover {
            background: #183f60;
        }

        .parent-profile-card,
        .parent-info-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .parent-avatar {
            width: 90px;
            height: 90px;
            flex-shrink: 0;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #e7eef7;
            color: #102a43;
            font-size: 28px;
            font-weight: 700;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 14px 0;
            border-bottom: 1px solid #edf1f5;
        }

        .info-item:last-child {
            border-bottom: 0;
        }

        .info-label {
            color: #718096;
            font-size: 13px;
        }

        .info-value {
            color: #243447;
            font-weight: 500;
            overflow-wrap: anywhere;
        }

        .student-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 18px 0;
            border-bottom: 1px solid #edf1f5;
        }

        .student-item:last-child {
            border-bottom: 0;
        }

        .student-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #f0f4f8;
            color: #102a43;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .children-badge {
            background: #e7eef7;
            color: #102a43;
            padding: 7px 11px;
        }
    </style>
@endsection
