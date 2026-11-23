@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 inscription-show-page">

        <style>
            /* =====================================================
                   CONFIGURATION GÉNÉRALE
                ===================================================== */

            .inscription-show-page {
                --show-bg: #f4f7fc;
                --show-card: #ffffff;
                --show-text: #263445;
                --show-muted: #7b8795;
                --show-border: #e7edf4;
                --show-soft: #f7f9fc;
                --show-primary: #2469a8;
                --show-shadow: 0 5px 22px rgba(30, 50, 80, .055);

                color: var(--show-text);
            }

            .show-inscription {
                max-width: 1250px;
                margin: auto;
            }

            /* =====================================================
                   EN-TÊTE
                ===================================================== */

            .show-header {
                position: relative;
                overflow: hidden;
                background: linear-gradient(120deg, #172f50, #2874b9);
                color: white;
                border-radius: 20px;
                padding: 30px 34px;
                margin-bottom: 25px;
                box-shadow: 0 10px 28px rgba(20, 50, 85, .15);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 20px;
            }

            .show-header::after {
                content: "";
                position: absolute;
                width: 260px;
                height: 260px;
                right: -85px;
                top: -145px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .07);
                pointer-events: none;
            }

            .show-header-content,
            .show-reference {
                position: relative;
                z-index: 1;
            }

            .show-header h3 {
                font-weight: 800;
                font-size: 25px;
                margin: 0 0 8px;
                letter-spacing: -.4px;
            }

            .show-header p {
                margin: 0;
                color: rgba(255, 255, 255, .82);
                font-size: 14px;
            }

            .show-header-icon {
                width: 43px;
                height: 43px;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                border-radius: 12px;
                background: rgba(255, 255, 255, .15);
                margin-right: 9px;
                font-size: 20px;
                vertical-align: middle;
            }

            .show-reference {
                background: rgba(255, 255, 255, .13);
                border: 1px solid rgba(255, 255, 255, .22);
                border-radius: 14px;
                padding: 14px 20px;
                text-align: center;
                backdrop-filter: blur(5px);
            }

            .show-reference small {
                display: block;
                color: rgba(255, 255, 255, .8);
                font-size: 10px;
                font-weight: 750;
                letter-spacing: 1.1px;
                margin-bottom: 5px;
            }

            .show-reference strong {
                font-size: 21px;
                letter-spacing: 1px;
            }

            /* =====================================================
                   CARTES
                ===================================================== */

            .show-card {
                background: var(--show-card);
                border: 1px solid var(--show-border);
                border-radius: 17px;
                box-shadow: var(--show-shadow);
                margin-bottom: 22px;
                overflow: hidden;
                transition: border-color .2s, box-shadow .2s;
            }

            .show-card-header {
                padding: 19px 24px;
                border-bottom: 1px solid var(--show-border);
                display: flex;
                align-items: center;
                gap: 13px;
            }

            .show-section-icon {
                width: 40px;
                height: 40px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: #eaf3ff;
                color: #2469a8;
                font-size: 18px;
            }

            .show-card-header h5 {
                margin: 0;
                font-size: 15px;
                font-weight: 800;
                color: var(--show-text);
            }

            .show-card-header p {
                margin: 5px 0 0;
                color: var(--show-muted);
                font-size: 12px;
            }

            .show-card-body {
                padding: 24px;
            }

            /* =====================================================
                   PROFIL ÉLÈVE
                ===================================================== */

            .student-profile {
                display: flex;
                align-items: center;
                gap: 21px;
                padding: 21px;
                background: var(--show-soft);
                border: 1px solid var(--show-border);
                border-radius: 15px;
            }

            .student-photo,
            .student-initial {
                width: 96px;
                height: 96px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .student-photo {
                object-fit: cover;
                border: 4px solid var(--show-card);
                box-shadow: 0 3px 12px rgba(0, 0, 0, .12);
            }

            .student-initial {
                background: #dcecff;
                color: #2469a8;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 31px;
                font-weight: 850;
                border: 4px solid var(--show-card);
            }

            .student-profile h4 {
                font-weight: 850;
                font-size: 20px;
                margin: 0 0 9px;
                color: var(--show-text);
            }

            .student-profile p {
                margin: 0 0 6px;
                color: var(--show-muted);
                font-size: 13px;
            }

            .student-profile p strong {
                color: var(--show-text);
                font-weight: 750;
            }

            /* =====================================================
                   INFORMATIONS
                ===================================================== */

            .info-item {
                padding: 17px;
                border: 1px solid var(--show-border);
                border-radius: 13px;
                height: 100%;
                background: var(--show-card);
                transition: .2s ease;
            }

            .info-item:hover {
                border-color: #c5d9ee;
                transform: translateY(-2px);
            }

            .info-label {
                display: block;
                color: var(--show-muted);
                font-size: 10px;
                font-weight: 800;
                margin-bottom: 9px;
                text-transform: uppercase;
                letter-spacing: .65px;
            }

            .info-value {
                display: block;
                color: var(--show-text);
                font-size: 14px;
                font-weight: 750;
                overflow-wrap: anywhere;
            }

            /* =====================================================
                   BADGES
                ===================================================== */

            .status-badge,
            .type-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 13px;
                border-radius: 30px;
                font-size: 11px;
                font-weight: 800;
            }

            .status-attente {
                color: #946200;
                background: #fff3cd;
            }

            .status-validee {
                color: #146c43;
                background: #d1e7dd;
            }

            .status-annulee {
                color: #b02a37;
                background: #f8d7da;
            }

            .type-badge {
                border-radius: 9px;
                background: #eaf3ff;
                color: #2469a8;
            }

            /* =====================================================
                   FINANCES
                ===================================================== */

            .financial-box {
                padding: 24px;
                border-radius: 15px;
                background: linear-gradient(120deg, #edf6ff, #f7fbff);
                border: 1px solid #dceafa;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 15px;
            }

            .financial-label {
                display: block;
                color: #718096;
                font-size: 13px;
                font-weight: 700;
                margin-bottom: 7px;
            }

            .financial-box strong {
                color: #205d96;
                font-size: 29px;
                font-weight: 850;
            }

            .financial-icon {
                width: 55px;
                height: 55px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(36, 105, 168, .1);
                color: #2469a8;
                border-radius: 15px;
                font-size: 25px;
            }

            /* =====================================================
                   OBSERVATIONS
                ===================================================== */

            .observation-box {
                background: var(--show-soft);
                border: 1px solid var(--show-border);
                border-radius: 13px;
                padding: 19px;
                color: var(--show-text);
                font-size: 14px;
                line-height: 1.8;
                white-space: pre-line;
                overflow-wrap: anywhere;
            }

            /* =====================================================
                   BOUTONS
                ===================================================== */

            .show-actions {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                flex-wrap: wrap;
                margin-top: 8px;
            }

            .show-btn {
                border: 0;
                border-radius: 11px;
                padding: 12px 18px;
                font-size: 13px;
                font-weight: 750;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                cursor: pointer;
                transition: .2s ease;
            }

            .show-btn:hover {
                transform: translateY(-2px);
            }

            .show-btn-primary {
                background: #2469a8;
                color: white;
                box-shadow: 0 4px 12px rgba(36, 105, 168, .18);
            }

            .show-btn-primary:hover {
                background: #18558e;
                color: white;
            }

            .show-btn-secondary {
                background: var(--show-soft);
                border: 1px solid var(--show-border);
                color: var(--show-text);
            }

            .show-btn-secondary:hover {
                background: var(--show-border);
                color: var(--show-text);
            }

            /* =====================================================
                   THÈME SOMBRE
                ===================================================== */

            html[data-app-theme="dark"] .inscription-show-page {
                --show-bg: #111827;
                --show-card: #1e293b;
                --show-text: #e5edf7;
                --show-muted: #9aaabe;
                --show-border: #334155;
                --show-soft: #263449;
                --show-primary: #60a5fa;
                --show-shadow: 0 5px 22px rgba(0, 0, 0, .15);
            }

            html[data-app-theme="dark"] .show-section-icon {
                background: #263f5d;
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .student-initial {
                background: #263f5d;
                color: #93c5fd;
                border-color: #334155;
            }

            html[data-app-theme="dark"] .student-photo {
                border-color: #334155;
            }

            html[data-app-theme="dark"] .info-item:hover {
                border-color: #52749b;
            }

            html[data-app-theme="dark"] .type-badge {
                background: #263f5d;
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .status-attente {
                background: #493b1c;
                color: #facc75;
            }

            html[data-app-theme="dark"] .status-validee {
                background: #173e35;
                color: #86efac;
            }

            html[data-app-theme="dark"] .status-annulee {
                background: #49272e;
                color: #fda4af;
            }

            html[data-app-theme="dark"] .financial-box {
                background: linear-gradient(120deg, #203b58, #263449);
                border-color: #385575;
            }

            html[data-app-theme="dark"] .financial-label {
                color: #a8bad0;
            }

            html[data-app-theme="dark"] .financial-box strong {
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .financial-icon {
                background: rgba(147, 197, 253, .12);
                color: #93c5fd;
            }

            /* =====================================================
                   AUTRES THÈMES SOMBRES / PERSONNALISÉS
                ===================================================== */

            html[data-app-theme="ultra-pro"] .inscription-show-page {
                --show-bg: #111827;
                --show-card: #1e293b;
                --show-text: #e5edf7;
                --show-muted: #9aaabe;
                --show-border: #334155;
                --show-soft: #263449;
                --show-shadow: 0 5px 22px rgba(0, 0, 0, .15);
            }

            html[data-app-theme="ultra-pro"] .show-section-icon,
            html[data-app-theme="ultra-pro"] .type-badge {
                background: #263f5d;
                color: #93c5fd;
            }

            html[data-app-theme="emerald"] .inscription-show-page {
                --show-primary: #16865d;
            }

            html[data-app-theme="emerald"] .show-section-icon {
                background: #e2f5eb;
                color: #16865d;
            }

            html[data-app-theme="warm"] .inscription-show-page {
                --show-primary: #b66b37;
            }

            html[data-app-theme="warm"] .show-section-icon {
                background: #fff0df;
                color: #b66b37;
            }

            /* =====================================================
                   RESPONSIVE
                ===================================================== */

            @media(max-width: 768px) {
                .show-header {
                    padding: 23px;
                }

                .show-header h3 {
                    font-size: 21px;
                }

                .show-card-body {
                    padding: 17px;
                }

                .show-card-header {
                    padding: 16px 18px;
                }

                .financial-box strong {
                    font-size: 24px;
                }
            }

            @media(max-width: 600px) {
                .show-header {
                    align-items: stretch;
                }

                .show-reference {
                    width: 100%;
                }

                .student-profile {
                    align-items: center;
                    flex-direction: column;
                    text-align: center;
                }

                .student-profile h4 {
                    font-size: 18px;
                }

                .show-actions {
                    flex-direction: column;
                }

                .show-btn {
                    width: 100%;
                }
            }

            /* =====================================================
                   IMPRESSION
                ===================================================== */

            @media print {
                @page {
                    size: A4;
                    margin: 15mm;
                }

                body {
                    background: white !important;
                    color: #263445 !important;
                }

                .show-actions,
                .sidebar,
                .topbar,
                .show-btn {
                    display: none !important;
                }

                .inscription-show-page {
                    padding: 0 !important;
                }

                .show-inscription {
                    max-width: 100%;
                }

                .show-card {
                    background: white !important;
                    border: 1px solid #ddd !important;
                    box-shadow: none !important;
                    break-inside: avoid;
                }

                .show-card-header h5,
                .info-value,
                .student-profile h4,
                .observation-box {
                    color: #263445 !important;
                }

                .show-header {
                    box-shadow: none !important;
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }

                .student-profile,
                .info-item,
                .observation-box {
                    background: white !important;
                }

                .financial-box {
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }
            }
        </style>

        <div class="show-inscription">

            {{-- =====================================================
                 EN-TÊTE
            ====================================================== --}}

            <div class="show-header">

                <div class="show-header-content">
                    <h3>
                        <span class="show-header-icon">
                            <i class="bi bi-folder2-open"></i>
                        </span>
                        Dossier d'inscription
                    </h3>

                    <p>
                        Consultation détaillée et suivi du dossier de l'élève.
                    </p>
                </div>

                <div class="show-reference">
                    <small>NUMÉRO DU DOSSIER</small>
                    <strong>
                        INS-{{ str_pad($inscription->id, 5, '0', STR_PAD_LEFT) }}
                    </strong>
                </div>

            </div>

            {{-- =====================================================
                 IDENTITÉ DE L'ÉLÈVE
            ====================================================== --}}

            <div class="show-card">

                <div class="show-card-header">
                    <div class="show-section-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>

                    <div>
                        <h5>Identité de l'élève</h5>
                        <p>Informations personnelles de l'élève concerné.</p>
                    </div>
                </div>

                <div class="show-card-body">

                    <div class="student-profile">

                        @if ($inscription->eleve && $inscription->eleve->photo)
                            <img src="{{ asset('storage/' . $inscription->eleve->photo) }}" class="student-photo"
                                alt="Photo de l'élève">
                        @else
                            <div class="student-initial">
                                {{ strtoupper(substr($inscription->eleve->prenom ?? 'E', 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <h4>
                                {{ $inscription->eleve->nom ?? 'Élève inconnu' }}
                                {{ $inscription->eleve->prenom ?? '' }}
                            </h4>

                            <p>
                                <i class="bi bi-upc-scan me-1"></i>
                                Matricule :
                                <strong>
                                    {{ $inscription->eleve->matricule ?? 'Non renseigné' }}
                                </strong>
                            </p>

                            <p>
                                <i class="bi bi-list-ol me-1"></i>
                                Numéro dans la classe :
                                <strong>
                                    {{ $inscription->eleve->numero_classe ?? 'Non renseigné' }}
                                </strong>
                            </p>
                        </div>

                    </div>

                    <div class="row g-3 mt-2">

                        <div class="col-md-4">
                            <div class="info-item">
                                <span class="info-label">Sexe</span>
                                <span class="info-value">
                                    {{ $inscription->eleve->sexe ?? 'Non renseigné' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-item">
                                <span class="info-label">Date de naissance</span>
                                <span class="info-value">
                                    {{ $inscription->eleve->date_naissance
                                        ? \Carbon\Carbon::parse($inscription->eleve->date_naissance)->format('d/m/Y')
                                        : 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-item">
                                <span class="info-label">Classe actuelle de l'élève</span>
                                <span class="info-value">
                                    {{ $inscription->eleve->classe->nom ?? 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- =====================================================
                 INFORMATIONS DE L'INSCRIPTION
            ====================================================== --}}

            <div class="show-card">

                <div class="show-card-header">
                    <div class="show-section-icon">
                        <i class="bi bi-journal-check"></i>
                    </div>

                    <div>
                        <h5>Informations de l'inscription</h5>
                        <p>Année scolaire, classe et statut du dossier.</p>
                    </div>
                </div>

                <div class="show-card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Type d'inscription</span>

                                <span class="info-value">
                                    @if ($inscription->type === 'reinscription')
                                        <span class="type-badge">
                                            <i class="bi bi-arrow-repeat"></i>
                                            Réinscription
                                        </span>
                                    @else
                                        <span class="type-badge">
                                            <i class="bi bi-person-plus"></i>
                                            Nouvelle inscription
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Statut du dossier</span>

                                <span class="info-value">
                                    @if ($inscription->statut === 'validee')
                                        <span class="status-badge status-validee">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Validée
                                        </span>
                                    @elseif($inscription->statut === 'annulee')
                                        <span class="status-badge status-annulee">
                                            <i class="bi bi-x-circle-fill"></i>
                                            Annulée
                                        </span>
                                    @else
                                        <span class="status-badge status-attente">
                                            <i class="bi bi-clock-fill"></i>
                                            En attente
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Classe d'inscription</span>
                                <span class="info-value">
                                    {{ $inscription->classe->nom ?? 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Année scolaire</span>
                                <span class="info-value">
                                    {{ $inscription->anneeScolaire->nom ?? 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Date d'inscription</span>
                                <span class="info-value">
                                    {{ $inscription->date_inscription?->format('d/m/Y') ?? 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Numéro du dossier</span>
                                <span class="info-value">
                                    INS-{{ str_pad($inscription->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- =====================================================
                 INFORMATIONS FINANCIÈRES
            ====================================================== --}}

            <div class="show-card">

                <div class="show-card-header">
                    <div class="show-section-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <div>
                        <h5>Informations financières</h5>
                        <p>Montant des frais d'inscription enregistrés.</p>
                    </div>
                </div>

                <div class="show-card-body">

                    <div class="financial-box">

                        <div>
                            <span class="financial-label">
                                Frais d'inscription
                            </span>

                            <strong>
                                {{ number_format((float) $inscription->frais_inscription, 2, ',', ' ') }}
                                Ar
                            </strong>
                        </div>

                        <div class="financial-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                    </div>

                </div>
            </div>

            {{-- =====================================================
                 OBSERVATIONS
            ====================================================== --}}

            <div class="show-card">

                <div class="show-card-header">
                    <div class="show-section-icon">
                        <i class="bi bi-chat-left-text"></i>
                    </div>

                    <div>
                        <h5>Observations</h5>
                        <p>Informations complémentaires relatives à ce dossier.</p>
                    </div>
                </div>

                <div class="show-card-body">

                    <div class="observation-box">
                        {{ $inscription->observations ?: 'Aucune observation enregistrée pour cette inscription.' }}
                    </div>

                </div>
            </div>

            {{-- =====================================================
                 ACTIONS
            ====================================================== --}}

            <div class="show-actions">

                <a href="{{ route('inscriptions.index') }}" class="show-btn show-btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Retour à la liste
                </a>

                <button type="button" onclick="window.print()" class="show-btn show-btn-secondary">
                    <i class="bi bi-printer"></i>
                    Imprimer
                </button>

                <a href="{{ route('inscriptions.edit', $inscription->id) }}" class="show-btn show-btn-primary">
                    <i class="bi bi-pencil-square"></i>
                    Modifier le dossier
                </a>

            </div>

        </div>
    </div>
@endsection
