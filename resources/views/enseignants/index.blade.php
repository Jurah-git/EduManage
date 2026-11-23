@extends('layouts.app')

@section('content')

    @php
        $show = auth()->user()->aPermission('enseignants.show');
        $modifier = auth()->user()->aPermission('enseignants.modifier');
        $supprimer = auth()->user()->aPermission('enseignants.supprimer');
        $creer = auth()->user()->aPermission('enseignants.creer');

        $afficherActions = $show || $modifier || $supprimer;

        $totalEnseignants = $enseignants->total();
        $enseignantsPage = $enseignants->getCollection();

        $actifs = $enseignantsPage->where('statut', 'actif')->count();
        $inactifs = $enseignantsPage->where('statut', '!=', 'actif')->count();
    @endphp

    <style>
        /* =====================================================
               ENSEIGNANTS - PAGE PRINCIPALE
            ===================================================== */

        .enseignants-page {
            --ens-bg: #f4f7fc;
            --ens-surface: #ffffff;
            --ens-soft: #f5f7fb;
            --ens-text: #29394f;
            --ens-heading: #243853;
            --ens-muted: #8390a2;
            --ens-border: #e5eaf1;
            --ens-hover: #f4f8ff;
            --ens-accent: #356bc1;
            --ens-accent-soft: #edf3ff;
            --ens-shadow: 0 6px 22px rgba(25, 42, 70, .055);

            min-height: 100vh;
            padding: 23px;
            background: var(--ens-bg);
            color: var(--ens-text);
            transition: background .25s ease, color .25s ease;
        }

        .enseignants-page,
        .enseignants-page * {
            box-sizing: border-box;
        }

        /* =====================================================
               HERO
            ===================================================== */

        .ens-hero {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 28px 30px;
            margin-bottom: 22px;
            border-radius: 19px;
            color: #ffffff;
            background: linear-gradient(120deg, #263b70, #287e9b);
            box-shadow: 0 10px 28px rgba(31, 59, 105, .16);
        }

        .ens-hero::before,
        .ens-hero::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .ens-hero::before {
            width: 260px;
            height: 260px;
            right: -65px;
            top: -130px;
            background: rgba(255, 255, 255, .08);
        }

        .ens-hero::after {
            width: 140px;
            height: 140px;
            right: 145px;
            bottom: -110px;
            background: rgba(255, 255, 255, .06);
        }

        .ens-hero-content {
            position: relative;
            z-index: 1;
        }

        .ens-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 30px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .13);
            font-size: 11px;
            font-weight: 750;
            letter-spacing: .7px;
            margin-bottom: 13px;
        }

        .ens-hero h3 {
            font-size: 27px;
            font-weight: 850;
            margin: 0 0 8px;
            letter-spacing: -.5px;
        }

        .ens-hero p {
            margin: 0;
            font-size: 13px;
            color: rgba(255, 255, 255, .82);
        }

        .ens-hero-action {
            position: relative;
            z-index: 2;
            flex-shrink: 0;
        }

        .ens-btn-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 12px 18px;
            border-radius: 11px;
            background: #ffffff;
            color: #28568f;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, .5);
            box-shadow: 0 5px 16px rgba(0, 0, 0, .12);
            transition: .2s ease;
        }

        .ens-btn-add:hover {
            background: #edf4ff;
            color: #17477f;
            transform: translateY(-2px);
        }

        /* =====================================================
               MESSAGES
            ===================================================== */

        .ens-alert {
            border-radius: 11px;
            padding: 13px 16px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 600;
        }

        .ens-alert-success {
            background: rgba(34, 170, 105, .10);
            border: 1px solid rgba(34, 170, 105, .25);
            color: #168653;
        }

        .ens-alert-danger {
            background: rgba(220, 53, 69, .10);
            border: 1px solid rgba(220, 53, 69, .25);
            color: #dc3545;
        }

        /* =====================================================
               STATISTIQUES
            ===================================================== */

        .ens-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .ens-stat {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px 19px;
            min-width: 0;
            background: var(--ens-surface);
            border: 1px solid var(--ens-border);
            border-radius: 15px;
            box-shadow: var(--ens-shadow);
            transition: transform .2s ease;
        }

        .ens-stat:hover {
            transform: translateY(-3px);
        }

        .ens-stat-icon {
            width: 47px;
            height: 47px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            font-size: 20px;
            flex-shrink: 0;
            background: var(--ens-accent-soft);
            color: var(--ens-accent);
        }

        .ens-stat-icon.success {
            background: rgba(34, 170, 105, .12);
            color: #22a56b;
        }

        .ens-stat-icon.danger {
            background: rgba(220, 53, 69, .11);
            color: #dc5361;
        }

        .ens-stat strong {
            display: block;
            font-size: 23px;
            line-height: 1.2;
            font-weight: 850;
            color: var(--ens-heading);
        }

        .ens-stat small {
            display: block;
            font-size: 12px;
            margin-top: 4px;
            color: var(--ens-muted);
        }

        /* =====================================================
               CARTE TABLEAU
            ===================================================== */

        .ens-card {
            background: var(--ens-surface);
            border: 1px solid var(--ens-border);
            border-radius: 17px;
            overflow: hidden;
            box-shadow: var(--ens-shadow);
        }

        .ens-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            padding: 20px 23px;
            border-bottom: 1px solid var(--ens-border);
        }

        .ens-card-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ens-card-title-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--ens-accent-soft);
            color: var(--ens-accent);
            font-size: 17px;
        }

        .ens-card-title h5 {
            margin: 0 0 4px;
            color: var(--ens-heading);
            font-size: 15px;
            font-weight: 850;
        }

        .ens-card-title p {
            margin: 0;
            color: var(--ens-muted);
            font-size: 12px;
        }

        .ens-total-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border-radius: 30px;
            background: var(--ens-accent-soft);
            color: var(--ens-accent);
            font-size: 12px;
            font-weight: 800;
        }

        /* =====================================================
               RECHERCHE
            ===================================================== */

        .ens-search-section {
            padding: 17px 23px;
            border-bottom: 1px solid var(--ens-border);
        }

        .ens-search-form {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .ens-search-input {
            position: relative;
            flex: 1;
            min-width: 0;
        }

        .ens-search-input i {
            position: absolute;
            left: 14px;
            top: 13px;
            color: var(--ens-muted);
            font-size: 14px;
            pointer-events: none;
        }

        .ens-search-input input {
            width: 100%;
            height: 42px;
            padding: 9px 13px 9px 40px;
            border: 1px solid var(--ens-border);
            border-radius: 10px;
            background: var(--ens-surface);
            color: var(--ens-text);
            font-size: 13px;
            outline: none;
            transition: .2s ease;
        }

        .ens-search-input input::placeholder {
            color: var(--ens-muted);
        }

        .ens-search-input input:focus {
            border-color: var(--ens-accent);
            box-shadow: 0 0 0 3px rgba(67, 131, 215, .12);
        }

        .ens-search-btn,
        .ens-reset-btn {
            height: 42px;
            padding: 0 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 750;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s ease;
        }

        .ens-search-btn {
            border: 1px solid var(--ens-accent);
            background: var(--ens-accent);
            color: #ffffff;
        }

        .ens-search-btn:hover {
            filter: brightness(1.08);
            color: #ffffff;
        }

        .ens-reset-btn {
            border: 1px solid var(--ens-border);
            background: var(--ens-surface-soft);
            color: var(--ens-text);
        }

        .ens-reset-btn:hover {
            border-color: var(--ens-accent);
            color: var(--ens-accent);
        }

        /* =====================================================
               TABLEAU
            ===================================================== */

        .ens-table-wrapper {
            overflow-x: auto;
            width: 100%;
        }

        .ens-table {
            width: 100%;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
            color: var(--ens-text);
            white-space: nowrap;
        }

        .ens-table thead th {
            padding: 15px 17px;
            background: var(--ens-soft);
            color: var(--ens-muted);
            font-size: 10px;
            font-weight: 850;
            text-transform: uppercase;
            letter-spacing: .65px;
            border-bottom: 1px solid var(--ens-border);
        }

        .ens-table tbody td {
            padding: 13px 17px;
            vertical-align: middle;
            font-size: 12px;
            color: var(--ens-text);
            border-bottom: 1px solid var(--ens-border);
        }

        .ens-table tbody tr {
            transition: background .18s ease;
        }

        .ens-table tbody tr:hover {
            background: var(--ens-hover);
        }

        .ens-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* =====================================================
               PROFIL ENSEIGNANT
            ===================================================== */

        .ens-photo {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--ens-border);
            display: block;
            margin: auto;
        }

        .ens-avatar-placeholder {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            background: var(--ens-accent-soft);
            color: var(--ens-accent);
            font-size: 18px;
        }

        .ens-identity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ens-identity-name {
            font-size: 12px;
            font-weight: 800;
            color: var(--ens-heading);
        }

        .ens-matricule {
            display: inline-flex;
            padding: 6px 9px;
            border-radius: 7px;
            background: var(--ens-accent-soft);
            color: var(--ens-accent);
            font-size: 11px;
            font-weight: 800;
        }

        .ens-specialite {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--ens-text);
            font-weight: 600;
        }

        .ens-specialite i {
            color: var(--ens-muted);
        }

        .ens-telephone {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--ens-text);
        }

        .ens-telephone i {
            color: var(--ens-muted);
        }

        .ens-dash {
            color: var(--ens-muted);
        }

        /* =====================================================
               STATUT
            ===================================================== */

        .ens-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 10px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 850;
        }

        .ens-status::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .ens-status-active {
            background: rgba(34, 170, 105, .12);
            color: #20a56a;
        }

        .ens-status-inactive {
            background: rgba(220, 53, 69, .11);
            color: #dc5361;
        }

        /* =====================================================
               ACTIONS
            ===================================================== */

        .ens-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .ens-action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid transparent;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            transition: .18s ease;
        }

        .ens-action-btn:hover {
            transform: translateY(-2px);
        }

        .ens-action-view {
            background: rgba(32, 145, 190, .12);
            color: #2593bd;
            border-color: rgba(32, 145, 190, .15);
        }

        .ens-action-edit {
            background: rgba(232, 164, 47, .14);
            color: #d49325;
            border-color: rgba(232, 164, 47, .17);
        }

        .ens-action-delete {
            background: rgba(220, 53, 69, .11);
            color: #dc5361;
            border-color: rgba(220, 53, 69, .15);
        }

        .ens-action-view:hover {
            background: #2593bd;
            color: white;
        }

        .ens-action-edit:hover {
            background: #d49325;
            color: white;
        }

        .ens-action-delete:hover {
            background: #dc5361;
            color: white;
        }

        .ens-actions form {
            display: inline-flex;
            margin: 0;
        }

        /* =====================================================
               VIDE
            ===================================================== */

        .ens-empty {
            padding: 48px 20px !important;
            text-align: center;
            white-space: normal !important;
        }

        .ens-empty-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 13px;
            border-radius: 17px;
            background: var(--ens-accent-soft);
            color: var(--ens-accent);
            font-size: 25px;
        }

        .ens-empty strong {
            display: block;
            color: var(--ens-heading);
            font-size: 14px;
            margin-bottom: 5px;
        }

        .ens-empty span {
            color: var(--ens-muted);
            font-size: 12px;
        }

        /* =====================================================
               PAGINATION PROFESSIONNELLE
            ===================================================== */

        .ens-pagination-footer {
            padding: 17px 22px;
            border-top: 1px solid var(--ens-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .ens-pagination-info {
            color: var(--ens-muted);
            font-size: 12px;
        }

        .ens-pagination-info strong {
            color: var(--ens-heading);
            font-weight: 850;
        }

        .ens-pagination-controls {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .ens-pagination-controls a,
        .ens-pagination-controls span {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--ens-border);
            border-radius: 8px;
            background: var(--ens-surface);
            color: var(--ens-text);
            font-size: 12px;
            font-weight: 750;
            text-decoration: none;
            transition: .18s ease;
        }

        .ens-pagination-controls a:hover {
            color: var(--ens-accent);
            border-color: var(--ens-accent);
            background: var(--ens-accent-soft);
        }

        .ens-pagination-controls .active span {
            background: var(--ens-accent);
            color: #ffffff;
            border-color: var(--ens-accent);
        }

        .ens-pagination-controls .disabled span {
            opacity: .35;
            cursor: not-allowed;
        }

        .ens-pagination-controls .dots span {
            border-color: transparent;
            background: transparent;
            color: var(--ens-muted);
            min-width: 20px;
        }

        /* =====================================================
               BAS DE PAGE
            ===================================================== */

        .ens-card-footer {
            padding: 12px 22px;
            background: var(--ens-soft);
            border-top: 1px solid var(--ens-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .ens-footer-note {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--ens-muted);
            font-size: 11px;
        }

        .ens-footer-note i {
            color: var(--ens-accent);
        }

        /* =====================================================
               MODE SOMBRE
            ===================================================== */

        html[data-app-theme="dark"] .enseignants-page {
            --ens-bg: #111827;
            --ens-surface: #1c2637;
            --ens-soft: #263449;
            --ens-text: #dce5f1;
            --ens-heading: #f1f5fb;
            --ens-muted: #a0aec0;
            --ens-border: #344256;
            --ens-hover: #26364b;
            --ens-accent: #75adff;
            --ens-accent-soft: rgba(76, 139, 231, .16);
            --ens-shadow: 0 7px 24px rgba(0, 0, 0, .17);
        }

        html[data-app-theme="dark"] .ens-hero {
            background: linear-gradient(120deg, #172b50, #15566d);
        }

        html[data-app-theme="dark"] .ens-btn-add {
            background: #eaf2ff;
            color: #244e85;
        }

        html[data-app-theme="dark"] .ens-alert-success {
            color: #6ee7a9;
        }

        html[data-app-theme="dark"] .ens-alert-danger {
            color: #ff929d;
        }

        /* =====================================================
               ULTRA PRO
            ===================================================== */

        html[data-app-theme="ultra-pro"] .enseignants-page {
            --ens-bg: #eef2f8;
            --ens-surface: #ffffff;
            --ens-soft: #f0f4fa;
            --ens-text: #24344c;
            --ens-heading: #172c4b;
            --ens-muted: #78879b;
            --ens-border: #dce4ef;
            --ens-hover: #edf3fc;
            --ens-accent: #315fba;
            --ens-accent-soft: #e8efff;
            --ens-shadow: 0 8px 28px rgba(27, 48, 83, .07);
        }

        html[data-app-theme="ultra-pro"] .ens-hero {
            background: linear-gradient(120deg, #142d58, #235c85);
        }

        /* =====================================================
               ÉMERAUDE
            ===================================================== */

        html[data-app-theme="emerald"] .enseignants-page {
            --ens-bg: #edf7f2;
            --ens-surface: #ffffff;
            --ens-soft: #eff8f3;
            --ens-text: #244238;
            --ens-heading: #174d3b;
            --ens-muted: #728f82;
            --ens-border: #d6e9de;
            --ens-hover: #edf8f1;
            --ens-accent: #16865c;
            --ens-accent-soft: #e1f4e9;
            --ens-shadow: 0 7px 24px rgba(24, 95, 65, .06);
        }

        html[data-app-theme="emerald"] .ens-hero {
            background: linear-gradient(120deg, #145c46, #218b70);
        }

        /* =====================================================
               WARM
            ===================================================== */

        html[data-app-theme="warm"] .enseignants-page {
            --ens-bg: #faf5ef;
            --ens-surface: #fffdf9;
            --ens-soft: #f8f0e6;
            --ens-text: #514033;
            --ens-heading: #593e2b;
            --ens-muted: #998777;
            --ens-border: #eadfd2;
            --ens-hover: #fbf1e5;
            --ens-accent: #b7793e;
            --ens-accent-soft: #f8ead9;
            --ens-shadow: 0 7px 24px rgba(111, 76, 43, .06);
        }

        html[data-app-theme="warm"] .ens-hero {
            background: linear-gradient(120deg, #765035, #b47b48);
        }

        /* =====================================================
               RESPONSIVE
            ===================================================== */

        @media(max-width: 900px) {
            .ens-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ens-stats .ens-stat:last-child {
                grid-column: 1 / -1;
            }
        }

        @media(max-width: 768px) {
            .enseignants-page {
                padding: 12px;
            }

            .ens-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 24px 21px;
            }

            .ens-hero h3 {
                font-size: 22px;
            }

            .ens-hero-action,
            .ens-btn-add {
                width: 100%;
            }

            .ens-stats {
                grid-template-columns: 1fr;
            }

            .ens-stats .ens-stat:last-child {
                grid-column: auto;
            }

            .ens-card-header {
                padding: 17px;
            }

            .ens-search-section {
                padding: 15px;
            }

            .ens-search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .ens-search-btn,
            .ens-reset-btn {
                width: 100%;
            }

            .ens-pagination-footer {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px;
            }

            .ens-pagination-controls {
                width: 100%;
            }

            .ens-card-footer {
                padding: 13px 16px;
            }
        }
    </style>

    <div class="enseignants-page">

        {{-- =================================================
             HERO
        ================================================== --}}

        <div class="ens-hero">

            <div class="ens-hero-content">

                <div class="ens-hero-label">
                    <i class="bi bi-mortarboard-fill"></i>
                    GESTION DU PERSONNEL PÉDAGOGIQUE
                </div>

                <h3>
                    <i class="bi bi-person-workspace me-2"></i>
                    Liste des enseignants
                </h3>

                <p>
                    Gérez les informations, les spécialités et les statuts des enseignants de votre établissement.
                </p>

            </div>

            @if ($creer)
                <div class="ens-hero-action">
                    <a href="{{ route('enseignants.create') }}" class="ens-btn-add">
                        <i class="bi bi-plus-circle-fill"></i>
                        Ajouter un enseignant
                    </a>
                </div>
            @endif

        </div>

        {{-- =================================================
             MESSAGES
        ================================================== --}}

        @if (session('success'))
            <div class="ens-alert ens-alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="ens-alert ens-alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- =================================================
             STATISTIQUES
        ================================================== --}}

        <div class="ens-stats">

            <div class="ens-stat">
                <div class="ens-stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div>
                    <strong>{{ $totalEnseignants }}</strong>
                    <small>Total des enseignants</small>
                </div>
            </div>

            <div class="ens-stat">
                <div class="ens-stat-icon success">
                    <i class="bi bi-person-check-fill"></i>
                </div>

                <div>
                    <strong>{{ $actifs }}</strong>
                    <small>Enseignants actifs sur cette page</small>
                </div>
            </div>

            <div class="ens-stat">
                <div class="ens-stat-icon danger">
                    <i class="bi bi-person-x-fill"></i>
                </div>

                <div>
                    <strong>{{ $inactifs }}</strong>
                    <small>Enseignants inactifs sur cette page</small>
                </div>
            </div>

        </div>

        {{-- =================================================
             CARTE PRINCIPALE
        ================================================== --}}

        <div class="ens-card">

            {{-- EN-TÊTE --}}
            <div class="ens-card-header">

                <div class="ens-card-title">

                    <div class="ens-card-title-icon">
                        <i class="bi bi-list-ul"></i>
                    </div>

                    <div>
                        <h5>Enseignants enregistrés</h5>
                        <p>Consultez et gérez les fiches des enseignants.</p>
                    </div>

                </div>

                <div class="ens-total-badge">
                    <i class="bi bi-people-fill"></i>
                    {{ $totalEnseignants }} enseignant(s)
                </div>

            </div>

            {{-- RECHERCHE --}}
            <div class="ens-search-section">

                <form method="GET" action="{{ route('enseignants.index') }}" class="ens-search-form">

                    <div class="ens-search-input">
                        <i class="bi bi-search"></i>

                        <input type="text" name="search"
                            placeholder="Rechercher par nom, prénom, matricule, spécialité..."
                            value="{{ request('search') }}">
                    </div>

                    <button type="submit" class="ens-search-btn">
                        <i class="bi bi-search"></i>
                        Rechercher
                    </button>

                    <a href="{{ route('enseignants.index') }}" class="ens-reset-btn">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Réinitialiser
                    </a>

                </form>

            </div>

            {{-- TABLEAU --}}
            <div class="ens-table-wrapper">

                <table class="ens-table">

                    <thead>
                        <tr>
                            <th class="text-center">Photo</th>
                            <th>Matricule</th>
                            <th>Nom et prénom</th>
                            <th>Spécialité</th>
                            <th>Téléphone</th>
                            <th>Statut</th>

                            @if ($afficherActions)
                                <th class="text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($enseignants as $enseignant)
                            <tr>

                                {{-- PHOTO --}}
                                <td class="text-center">

                                    @if ($enseignant->photo)
                                        <img src="{{ asset('storage/' . $enseignant->photo) }}"
                                            alt="Photo de {{ $enseignant->nom }}" class="ens-photo">
                                    @else
                                        <div class="ens-avatar-placeholder">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    @endif

                                </td>

                                {{-- MATRICULE --}}
                                <td>
                                    <span class="ens-matricule">
                                        {{ $enseignant->matricule }}
                                    </span>
                                </td>

                                {{-- IDENTITÉ --}}
                                <td>
                                    <div class="ens-identity">
                                        <span class="ens-identity-name">
                                            {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                        </span>
                                    </div>
                                </td>

                                {{-- SPÉCIALITÉ --}}
                                <td>

                                    @if ($enseignant->specialite)
                                        <span class="ens-specialite">
                                            <i class="bi bi-book"></i>
                                            {{ $enseignant->specialite }}
                                        </span>
                                    @else
                                        <span class="ens-dash">—</span>
                                    @endif

                                </td>

                                {{-- TÉLÉPHONE --}}
                                <td>

                                    @if ($enseignant->telephone)
                                        <span class="ens-telephone">
                                            <i class="bi bi-telephone"></i>
                                            {{ $enseignant->telephone }}
                                        </span>
                                    @else
                                        <span class="ens-dash">—</span>
                                    @endif

                                </td>

                                {{-- STATUT --}}
                                <td>

                                    @if ($enseignant->statut == 'actif')
                                        <span class="ens-status ens-status-active">
                                            Actif
                                        </span>
                                    @else
                                        <span class="ens-status ens-status-inactive">
                                            Inactif
                                        </span>
                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                @if ($afficherActions)
                                    <td>

                                        <div class="ens-actions">

                                            {{-- VOIR --}}
                                            @if ($show)
                                                <a href="{{ route('enseignants.show', $enseignant) }}"
                                                    class="ens-action-btn ens-action-view" title="Voir la fiche"
                                                    aria-label="Voir la fiche">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                            @endif

                                            {{-- MODIFIER --}}
                                            @if ($modifier)
                                                <a href="{{ route('enseignants.edit', $enseignant) }}"
                                                    class="ens-action-btn ens-action-edit" title="Modifier"
                                                    aria-label="Modifier">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                            @endif

                                            {{-- SUPPRIMER --}}
                                            @if ($supprimer)
                                                <form action="{{ route('enseignants.destroy', $enseignant) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cet enseignant ?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="ens-action-btn ens-action-delete"
                                                        title="Supprimer" aria-label="Supprimer">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>

                                                </form>
                                            @endif

                                        </div>

                                    </td>
                                @endif

                            </tr>

                        @empty

                            <tr>
                                <td colspan="{{ $afficherActions ? 7 : 6 }}" class="ens-empty">

                                    <div class="ens-empty-icon">
                                        <i class="bi bi-people"></i>
                                    </div>

                                    <strong>Aucun enseignant trouvé</strong>

                                    <span>
                                        @if (request('search'))
                                            Aucun résultat ne correspond à votre recherche.
                                        @else
                                            Aucun enseignant n'est encore enregistré dans votre établissement.
                                        @endif
                                    </span>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- =================================================
                 PAGINATION
            ================================================== --}}

            @if ($enseignants->hasPages())
                <div class="ens-pagination-footer">

                    <div class="ens-pagination-info">

                        Affichage de

                        <strong>{{ $enseignants->firstItem() }}</strong>

                        à

                        <strong>{{ $enseignants->lastItem() }}</strong>

                        sur

                        <strong>{{ $enseignants->total() }}</strong>

                        enseignants

                    </div>

                    <div class="ens-pagination-controls">

                        {{-- PREMIÈRE PAGE --}}
                        @if ($enseignants->onFirstPage())
                            <span class="disabled" title="Première page">
                                <i class="bi bi-chevron-double-left"></i>
                            </span>
                        @else
                            <a href="{{ $enseignants->url(1) }}" title="Première page" aria-label="Première page">
                                <i class="bi bi-chevron-double-left"></i>
                            </a>
                        @endif

                        {{-- PAGE PRÉCÉDENTE --}}
                        @if ($enseignants->onFirstPage())
                            <span class="disabled" title="Page précédente">
                                <i class="bi bi-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $enseignants->previousPageUrl() }}" title="Page précédente"
                                aria-label="Page précédente">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        @endif

                        {{-- NUMÉROS DE PAGE --}}
                        @foreach ($enseignants->getUrlRange(max(1, $enseignants->currentPage() - 2), min($enseignants->lastPage(), $enseignants->currentPage() + 2)) as $page => $url)
                            @if ($page == $enseignants->currentPage())
                                <span class="active">
                                    <span>{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- PAGE SUIVANTE --}}
                        @if ($enseignants->hasMorePages())
                            <a href="{{ $enseignants->nextPageUrl() }}" title="Page suivante"
                                aria-label="Page suivante">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @else
                            <span class="disabled" title="Page suivante">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        @endif

                        {{-- DERNIÈRE PAGE --}}
                        @if ($enseignants->hasMorePages())
                            <a href="{{ $enseignants->url($enseignants->lastPage()) }}" title="Dernière page"
                                aria-label="Dernière page">
                                <i class="bi bi-chevron-double-right"></i>
                            </a>
                        @else
                            <span class="disabled" title="Dernière page">
                                <i class="bi bi-chevron-double-right"></i>
                            </span>
                        @endif

                    </div>

                </div>
            @endif

            {{-- BAS DE CARTE --}}
            <div class="ens-card-footer">

                <div class="ens-footer-note">
                    <i class="bi bi-shield-check"></i>
                    Gestion sécurisée des enseignants
                </div>

                <div class="ens-footer-note">
                    <i class="bi bi-database-check"></i>
                    {{ $totalEnseignants }} enseignant(s) enregistré(s)
                </div>

            </div>

        </div>

    </div>

@endsection
