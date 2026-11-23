@extends('layouts.app')

@section('content')
    <div class="enseignant-show-page">

        <style>
            /* =====================================================
                   ENSEIGNANTS - FICHE DETAILLEE
                ===================================================== */

            .enseignant-show-page {
                --show-bg: #f3f6fc;
                --show-surface: #ffffff;
                --show-surface-soft: #f8faff;
                --show-text: #26364d;
                --show-heading: #172b4d;
                --show-muted: #78869b;
                --show-border: #e4eaf2;
                --show-primary: #2874d0;
                --show-primary-dark: #1759a9;
                --show-primary-soft: #eaf2ff;
                --show-success: #15966e;
                --show-success-soft: #e2f6ed;
                --show-danger: #dc5454;
                --show-danger-soft: #fff0f0;
                --show-shadow: 0 8px 28px rgba(30, 50, 80, .07);

                min-height: 100vh;
                padding: 26px;
                background: var(--show-bg);
                color: var(--show-text);
            }

            .enseignant-show-page *,
            .enseignant-show-page *::before,
            .enseignant-show-page *::after {
                box-sizing: border-box;
            }

            /* =====================================================
                   MODE SOMBRE
                ===================================================== */

            html[data-app-theme="dark"] .enseignant-show-page {
                --show-bg: #111827;
                --show-surface: #1e293b;
                --show-surface-soft: #263449;
                --show-text: #dce5f1;
                --show-heading: #f1f5f9;
                --show-muted: #a0aec0;
                --show-border: #35445b;
                --show-primary: #5799ef;
                --show-primary-dark: #83b5f8;
                --show-primary-soft: #263e5f;
                --show-success: #45c99a;
                --show-success-soft: #193f36;
                --show-danger: #ff8585;
                --show-danger-soft: #482b32;
                --show-shadow: 0 8px 28px rgba(0, 0, 0, .20);
            }

            /* =====================================================
                   ULTRA PRO
                ===================================================== */

            html[data-app-theme="ultra-pro"] .enseignant-show-page {
                --show-bg: #eef2f8;
                --show-surface: #ffffff;
                --show-surface-soft: #f5f7fb;
                --show-text: #29364b;
                --show-heading: #101d35;
                --show-muted: #748198;
                --show-border: #dce4ef;
                --show-primary: #315fa9;
                --show-primary-dark: #21477f;
                --show-primary-soft: #e8effb;
                --show-success: #16845f;
                --show-success-soft: #e0f3ea;
                --show-danger: #cc5151;
                --show-danger-soft: #fff0f0;
                --show-shadow: 0 12px 32px rgba(21, 42, 75, .10);
            }

            /* =====================================================
                   EMERALD
                ===================================================== */

            html[data-app-theme="emerald"] .enseignant-show-page {
                --show-bg: #edf7f3;
                --show-surface: #ffffff;
                --show-surface-soft: #f3faf7;
                --show-text: #23463d;
                --show-heading: #153c31;
                --show-muted: #718d82;
                --show-border: #d5e9df;
                --show-primary: #15966e;
                --show-primary-dark: #087653;
                --show-primary-soft: #e0f5ec;
                --show-success: #12845f;
                --show-success-soft: #e0f5ec;
                --show-danger: #c94f59;
                --show-danger-soft: #fff0f0;
                --show-shadow: 0 8px 28px rgba(20, 100, 75, .08);
            }

            /* =====================================================
                   WARM
                ===================================================== */

            html[data-app-theme="warm"] .enseignant-show-page {
                --show-bg: #f8f3ed;
                --show-surface: #fffdf9;
                --show-surface-soft: #faf5ed;
                --show-text: #554438;
                --show-heading: #392b20;
                --show-muted: #958474;
                --show-border: #eadfd2;
                --show-primary: #b77c40;
                --show-primary-dark: #94602d;
                --show-primary-soft: #f8ead8;
                --show-success: #4b916c;
                --show-success-soft: #e7f3e9;
                --show-danger: #c85c55;
                --show-danger-soft: #fff0ec;
                --show-shadow: 0 8px 28px rgba(90, 60, 30, .07);
            }

            /* =====================================================
                   HERO
                ===================================================== */

            .enseignant-show-page .show-hero {
                position: relative;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                padding: 27px 30px;
                margin-bottom: 25px;
                border-radius: 20px;
                color: #ffffff;
                background: linear-gradient(120deg, #2874d0, #174c91);
                box-shadow: 0 10px 25px rgba(40, 100, 180, .18);
            }

            .enseignant-show-page .show-hero::before {
                content: "";
                position: absolute;
                width: 230px;
                height: 230px;
                right: 12%;
                top: -145px;
                border: 35px solid rgba(255, 255, 255, .10);
                border-radius: 50%;
            }

            .enseignant-show-page .show-hero-content {
                position: relative;
                z-index: 1;
            }

            .enseignant-show-page .show-hero h2 {
                margin: 0 0 8px;
                color: #ffffff;
                font-size: 25px;
                font-weight: 800;
            }

            .enseignant-show-page .show-hero p {
                margin: 0;
                color: rgba(255, 255, 255, .85);
                font-size: 14px;
            }

            .enseignant-show-page .show-hero-icon {
                position: relative;
                z-index: 1;
                width: 58px;
                height: 58px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 17px;
                background: rgba(255, 255, 255, .18);
                font-size: 27px;
            }

            .enseignant-show-page .show-back-btn {
                position: relative;
                z-index: 2;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                border: 1px solid rgba(255, 255, 255, .35);
                border-radius: 10px;
                color: #ffffff;
                background: rgba(255, 255, 255, .15);
                text-decoration: none;
                font-size: 13px;
                font-weight: 700;
                transition: .2s;
            }

            .enseignant-show-page .show-back-btn:hover {
                color: #ffffff;
                background: rgba(255, 255, 255, .28);
                transform: translateY(-2px);
            }

            /* =====================================================
                   ALERTES
                ===================================================== */

            .enseignant-show-page .show-alert {
                padding: 14px 18px;
                margin-bottom: 20px;
                border-radius: 12px;
                font-size: 13px;
            }

            /* =====================================================
                   CARTE PRINCIPALE
                ===================================================== */

            .enseignant-show-page .show-card {
                overflow: hidden;
                border: 1px solid var(--show-border);
                border-radius: 18px;
                background: var(--show-surface);
                box-shadow: var(--show-shadow);
            }

            .enseignant-show-page .show-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                padding: 19px 24px;
                border-bottom: 1px solid var(--show-border);
                background: var(--show-surface-soft);
            }

            .enseignant-show-page .show-card-heading {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .enseignant-show-page .show-card-icon {
                width: 41px;
                height: 41px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                color: var(--show-primary);
                background: var(--show-primary-soft);
                font-size: 20px;
            }

            .enseignant-show-page .show-card-header h5 {
                margin: 0;
                color: var(--show-heading);
                font-size: 16px;
                font-weight: 800;
            }

            .enseignant-show-page .show-card-header small {
                display: block;
                margin-top: 4px;
                color: var(--show-muted);
                font-size: 12px;
            }

            .enseignant-show-page .show-card-body {
                padding: 27px;
            }

            /* =====================================================
                   PROFIL
                ===================================================== */

            .enseignant-show-page .teacher-profile {
                display: flex;
                align-items: center;
                gap: 25px;
                padding: 23px;
                margin-bottom: 27px;
                border: 1px solid var(--show-border);
                border-radius: 15px;
                background: var(--show-surface-soft);
            }

            .enseignant-show-page .teacher-photo {
                width: 132px;
                height: 132px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                border: 4px solid var(--show-surface);
                border-radius: 50%;
                background: var(--show-primary-soft);
                box-shadow: 0 4px 15px rgba(30, 50, 80, .12);
            }

            .enseignant-show-page .teacher-photo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .enseignant-show-page .teacher-photo i {
                color: var(--show-primary);
                font-size: 65px;
            }

            .enseignant-show-page .teacher-identity {
                min-width: 0;
            }

            .enseignant-show-page .teacher-identity h3 {
                margin: 0 0 10px;
                color: var(--show-heading);
                font-size: 24px;
                font-weight: 800;
            }

            .enseignant-show-page .teacher-matricule {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                margin-bottom: 13px;
                color: var(--show-muted);
                font-size: 13px;
            }

            .enseignant-show-page .teacher-matricule strong {
                color: var(--show-heading);
            }

            .enseignant-show-page .teacher-status {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 7px 12px;
                border-radius: 30px;
                font-size: 12px;
                font-weight: 800;
            }

            .enseignant-show-page .teacher-status.active {
                color: var(--show-success);
                background: var(--show-success-soft);
            }

            .enseignant-show-page .teacher-status.inactive {
                color: var(--show-danger);
                background: var(--show-danger-soft);
            }

            .enseignant-show-page .status-dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: currentColor;
            }

            /* =====================================================
                   SECTION INFORMATIONS
                ===================================================== */

            .enseignant-show-page .show-section-title {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 17px;
                color: var(--show-heading);
                font-size: 15px;
                font-weight: 800;
            }

            .enseignant-show-page .show-section-title i {
                color: var(--show-primary);
                font-size: 18px;
            }

            .enseignant-show-page .info-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 15px;
            }

            .enseignant-show-page .info-item {
                min-width: 0;
                padding: 17px;
                border: 1px solid var(--show-border);
                border-radius: 12px;
                background: var(--show-surface);
                transition: .2s;
            }

            .enseignant-show-page .info-item:hover {
                border-color: var(--show-primary);
                transform: translateY(-2px);
            }

            .enseignant-show-page .info-label {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 9px;
                color: var(--show-muted);
                font-size: 12px;
                font-weight: 700;
            }

            .enseignant-show-page .info-label i {
                color: var(--show-primary);
                font-size: 15px;
            }

            .enseignant-show-page .info-value {
                overflow-wrap: anywhere;
                color: var(--show-heading);
                font-size: 14px;
                font-weight: 700;
            }

            .enseignant-show-page .info-value.empty {
                color: var(--show-muted);
                font-weight: 500;
            }

            /* =====================================================
                   ACTIONS
                ===================================================== */

            .enseignant-show-page .show-actions {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 12px;
                padding-top: 23px;
                margin-top: 27px;
                border-top: 1px solid var(--show-border);
            }

            .enseignant-show-page .show-actions-note {
                color: var(--show-muted);
                font-size: 12px;
            }

            .enseignant-show-page .show-actions-buttons {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .enseignant-show-page .show-action-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 10px 17px;
                border-radius: 10px;
                text-decoration: none;
                font-size: 13px;
                font-weight: 700;
                transition: .2s;
            }

            .enseignant-show-page .show-edit-btn {
                border: 1px solid var(--show-primary);
                color: #ffffff;
                background: var(--show-primary);
            }

            .enseignant-show-page .show-edit-btn:hover {
                color: #ffffff;
                background: var(--show-primary-dark);
                transform: translateY(-2px);
            }

            .enseignant-show-page .show-list-btn {
                border: 1px solid var(--show-border);
                color: var(--show-text);
                background: var(--show-surface);
            }

            .enseignant-show-page .show-list-btn:hover {
                color: var(--show-heading);
                background: var(--show-surface-soft);
            }

            /* =====================================================
                   RESPONSIVE
                ===================================================== */

            @media (max-width: 768px) {
                .enseignant-show-page {
                    padding: 15px;
                }

                .enseignant-show-page .show-hero {
                    padding: 22px;
                }

                .enseignant-show-page .show-hero h2 {
                    font-size: 20px;
                }

                .enseignant-show-page .show-card-body {
                    padding: 18px;
                }

                .enseignant-show-page .show-card-header {
                    padding: 16px;
                }

                .enseignant-show-page .teacher-profile {
                    gap: 17px;
                    padding: 17px;
                }

                .enseignant-show-page .teacher-photo {
                    width: 105px;
                    height: 105px;
                }

                .enseignant-show-page .teacher-identity h3 {
                    font-size: 19px;
                }
            }

            @media (max-width: 576px) {
                .enseignant-show-page .info-grid {
                    grid-template-columns: 1fr;
                }

                .enseignant-show-page .teacher-profile {
                    flex-direction: column;
                    text-align: center;
                }

                .enseignant-show-page .teacher-identity {
                    width: 100%;
                }

                .enseignant-show-page .show-hero-icon {
                    display: none;
                }

                .enseignant-show-page .show-hero {
                    align-items: flex-start;
                }

                .enseignant-show-page .show-actions {
                    align-items: stretch;
                    flex-direction: column;
                }

                .enseignant-show-page .show-actions-buttons {
                    width: 100%;
                }

                .enseignant-show-page .show-action-btn {
                    flex: 1;
                }
            }
        </style>

        {{-- =====================================================
             BANDEAU PRINCIPAL
        ====================================================== --}}

        <div class="show-hero">

            <div class="show-hero-content">
                <h2>
                    <i class="bi bi-person-vcard me-2"></i>
                    Fiche de l'enseignant
                </h2>

                <p>
                    Consultez les informations personnelles et professionnelles de cet enseignant.
                </p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('enseignants.index') }}" class="show-back-btn">
                    <i class="bi bi-arrow-left"></i>
                    Retour à la liste
                </a>

                <div class="show-hero-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>

        </div>

        {{-- =====================================================
             MESSAGE DE SUCCÈS
        ====================================================== --}}

        @if (session('success'))
            <div class="alert alert-success show-alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- =====================================================
             FICHE DE L'ENSEIGNANT
        ====================================================== --}}

        <div class="show-card">

            <div class="show-card-header">

                <div class="show-card-heading">
                    <div class="show-card-icon">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>
                        <h5>Informations de l'enseignant</h5>
                        <small>Fiche détaillée et renseignements personnels</small>
                    </div>
                </div>

                <span class="badge rounded-pill px-3 py-2"
                    style="color: var(--show-primary); background: var(--show-primary-soft);">
                    <i class="bi bi-shield-check me-1"></i>
                    Fiche enregistrée
                </span>

            </div>

            <div class="show-card-body">

                {{-- =================================================
                     PROFIL DE L'ENSEIGNANT
                ================================================== --}}

                <div class="teacher-profile">

                    <div class="teacher-photo">

                        @if ($enseignant->photo)
                            <img src="{{ asset('storage/' . $enseignant->photo) }}"
                                alt="Photo de {{ $enseignant->prenom }} {{ $enseignant->nom }}">
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif

                    </div>

                    <div class="teacher-identity">

                        <h3>
                            {{ $enseignant->nom }} {{ $enseignant->prenom }}
                        </h3>

                        <div class="teacher-matricule">
                            <i class="bi bi-person-badge"></i>
                            Matricule :
                            <strong>{{ $enseignant->matricule ?: 'Non renseigné' }}</strong>
                        </div>

                        <div>
                            @if ($enseignant->statut === 'actif')
                                <span class="teacher-status active">
                                    <span class="status-dot"></span>
                                    Enseignant actif
                                </span>
                            @else
                                <span class="teacher-status inactive">
                                    <span class="status-dot"></span>
                                    Enseignant inactif
                                </span>
                            @endif
                        </div>

                    </div>

                </div>

                {{-- =================================================
                     INFORMATIONS PERSONNELLES
                ================================================== --}}

                <div class="show-section-title">
                    <i class="bi bi-person-circle"></i>
                    Informations personnelles
                </div>

                <div class="info-grid">

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-gender-ambiguous"></i>
                            Sexe
                        </div>
                        <div class="info-value {{ !$enseignant->sexe ? 'empty' : '' }}">
                            {{ $enseignant->sexe ?: 'Non renseigné' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-calendar-event"></i>
                            Date de naissance
                        </div>
                        <div class="info-value {{ !$enseignant->date_naissance ? 'empty' : '' }}">
                            {{ $enseignant->date_naissance?->format('d/m/Y') ?? 'Non renseignée' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-telephone"></i>
                            Téléphone
                        </div>
                        <div class="info-value {{ !$enseignant->telephone ? 'empty' : '' }}">
                            {{ $enseignant->telephone ?: 'Non renseigné' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-envelope"></i>
                            Adresse e-mail
                        </div>
                        <div class="info-value {{ !$enseignant->email ? 'empty' : '' }}">
                            {{ $enseignant->email ?: 'Non renseignée' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-geo-alt"></i>
                            Adresse
                        </div>
                        <div class="info-value {{ !$enseignant->adresse ? 'empty' : '' }}">
                            {{ $enseignant->adresse ?: 'Non renseignée' }}
                        </div>
                    </div>

                </div>

                {{-- =================================================
                     INFORMATIONS PROFESSIONNELLES
                ================================================== --}}

                <div class="show-section-title mt-4">
                    <i class="bi bi-briefcase"></i>
                    Informations professionnelles
                </div>

                <div class="info-grid">

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-award"></i>
                            Diplôme
                        </div>
                        <div class="info-value {{ !$enseignant->diplome ? 'empty' : '' }}">
                            {{ $enseignant->diplome ?: 'Non renseigné' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-book"></i>
                            Spécialité
                        </div>
                        <div class="info-value {{ !$enseignant->specialite ? 'empty' : '' }}">
                            {{ $enseignant->specialite ?: 'Non renseignée' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-calendar-check"></i>
                            Date de recrutement
                        </div>
                        <div class="info-value {{ !$enseignant->date_recrutement ? 'empty' : '' }}">
                            {{ $enseignant->date_recrutement?->format('d/m/Y') ?? 'Non renseignée' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-person-badge"></i>
                            Matricule
                        </div>
                        <div class="info-value {{ !$enseignant->matricule ? 'empty' : '' }}">
                            {{ $enseignant->matricule ?: 'Non renseigné' }}
                        </div>
                    </div>

                </div>

                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="show-actions">

                    <div class="show-actions-note">
                        <i class="bi bi-info-circle me-1"></i>
                        Consultez ou modifiez les informations de cette fiche.
                    </div>

                    <div class="show-actions-buttons">

                        <a href="{{ route('enseignants.index') }}" class="show-action-btn show-list-btn">
                            <i class="bi bi-list-ul"></i>
                            Retour à la liste
                        </a>

                        <a href="{{ route('enseignants.edit', $enseignant) }}" class="show-action-btn show-edit-btn">
                            <i class="bi bi-pencil-square"></i>
                            Modifier la fiche
                        </a>

                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
