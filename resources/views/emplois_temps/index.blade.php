@extends('layouts.app')

@section('content')

    <div class="emplois-page">

        @php
            $show = auth()->user()->aPermission('emploi_temps.show');
            $modifier = auth()->user()->aPermission('emploi_temps.modifier');
            $supprimer = auth()->user()->aPermission('emploi_temps.supprimer');
            $valider = auth()->user()->aPermission('emploi_temps.valider');
            $creer = auth()->user()->aPermission('emploi_temps.creer');

            $afficherActions = $show || $modifier || $supprimer || $valider;

            $emploisPage = $emploisTemps->getCollection();

            $totalPage = $emploisPage->count();
            $publiesPage = $emploisPage->where('statut', 'publie')->count();
            $brouillonsPage = $emploisPage->where('statut', 'brouillon')->count();
            $creneauxPage = $emploisPage->sum('creneaux_count');
        @endphp

        <style>
            /* =====================================================
                   EMPLOIS DU TEMPS - PAGE PRINCIPALE
                ===================================================== */

            .emplois-page {
                --emploi-bg: #f3f6fc;
                --emploi-surface: #ffffff;
                --emploi-surface-soft: #f8faff;
                --emploi-text: #26364d;
                --emploi-heading: #172b4d;
                --emploi-muted: #78869b;
                --emploi-border: #e4eaf2;
                --emploi-primary: #2874d0;
                --emploi-primary-dark: #1759a9;
                --emploi-primary-soft: #eaf2ff;
                --emploi-success: #15966e;
                --emploi-success-soft: #e2f6ed;
                --emploi-warning: #d99a20;
                --emploi-warning-soft: #fff5dc;
                --emploi-info: #2695bd;
                --emploi-info-soft: #e4f5fb;
                --emploi-danger: #dc5454;
                --emploi-danger-soft: #fff0f0;
                --emploi-shadow: 0 8px 28px rgba(30, 50, 80, .07);

                min-height: 100vh;
                padding: 26px;
                background: var(--emploi-bg);
                color: var(--emploi-text);
            }

            .emplois-page *,
            .emplois-page *::before,
            .emplois-page *::after {
                box-sizing: border-box;
            }

            /* =====================================================
                   MODE SOMBRE
                ===================================================== */

            html[data-app-theme="dark"] .emplois-page {
                --emploi-bg: #111827;
                --emploi-surface: #1e293b;
                --emploi-surface-soft: #263449;
                --emploi-text: #dce5f1;
                --emploi-heading: #f1f5f9;
                --emploi-muted: #a0aec0;
                --emploi-border: #35445b;
                --emploi-primary: #5799ef;
                --emploi-primary-dark: #83b5f8;
                --emploi-primary-soft: #263e5f;
                --emploi-success: #45c99a;
                --emploi-success-soft: #193f36;
                --emploi-warning: #f0b642;
                --emploi-warning-soft: #493a20;
                --emploi-info: #64c3df;
                --emploi-info-soft: #1e4050;
                --emploi-danger: #ff8585;
                --emploi-danger-soft: #482b32;
                --emploi-shadow: 0 8px 28px rgba(0, 0, 0, .20);
            }

            /* =====================================================
                   ULTRA PRO
                ===================================================== */

            html[data-app-theme="ultra-pro"] .emplois-page {
                --emploi-bg: #eef2f8;
                --emploi-surface: #ffffff;
                --emploi-surface-soft: #f5f7fb;
                --emploi-text: #29364b;
                --emploi-heading: #101d35;
                --emploi-muted: #748198;
                --emploi-border: #dce4ef;
                --emploi-primary: #315fa9;
                --emploi-primary-dark: #21477f;
                --emploi-primary-soft: #e8effb;
                --emploi-success: #16845f;
                --emploi-success-soft: #e0f3ea;
                --emploi-warning: #b77b12;
                --emploi-warning-soft: #fff3d5;
                --emploi-info: #2586a8;
                --emploi-info-soft: #e3f3f8;
                --emploi-danger: #cc5151;
                --emploi-danger-soft: #fff0f0;
                --emploi-shadow: 0 12px 32px rgba(21, 42, 75, .10);
            }

            /* =====================================================
                   EMERALD
                ===================================================== */

            html[data-app-theme="emerald"] .emplois-page {
                --emploi-bg: #edf7f3;
                --emploi-surface: #ffffff;
                --emploi-surface-soft: #f3faf7;
                --emploi-text: #23463d;
                --emploi-heading: #153c31;
                --emploi-muted: #718d82;
                --emploi-border: #d5e9df;
                --emploi-primary: #15966e;
                --emploi-primary-dark: #087653;
                --emploi-primary-soft: #e0f5ec;
                --emploi-success: #12845f;
                --emploi-success-soft: #e0f5ec;
                --emploi-warning: #b77c32;
                --emploi-warning-soft: #f8ead8;
                --emploi-info: #258b9d;
                --emploi-info-soft: #e1f3f4;
                --emploi-danger: #c94f59;
                --emploi-danger-soft: #fff0f0;
                --emploi-shadow: 0 8px 28px rgba(20, 100, 75, .08);
            }

            /* =====================================================
                   WARM
                ===================================================== */

            html[data-app-theme="warm"] .emplois-page {
                --emploi-bg: #f8f3ed;
                --emploi-surface: #fffdf9;
                --emploi-surface-soft: #faf5ed;
                --emploi-text: #554438;
                --emploi-heading: #392b20;
                --emploi-muted: #958474;
                --emploi-border: #eadfd2;
                --emploi-primary: #b77c40;
                --emploi-primary-dark: #94602d;
                --emploi-primary-soft: #f8ead8;
                --emploi-success: #4b916c;
                --emploi-success-soft: #e7f3e9;
                --emploi-warning: #bd8432;
                --emploi-warning-soft: #fbefd9;
                --emploi-info: #548fa0;
                --emploi-info-soft: #e7f1f3;
                --emploi-danger: #c85c55;
                --emploi-danger-soft: #fff0ec;
                --emploi-shadow: 0 8px 28px rgba(90, 60, 30, .07);
            }

            /* =====================================================
                   HERO
                ===================================================== */

            .emplois-page .emploi-hero {
                position: relative;
                overflow: hidden;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
                padding: 27px 30px;
                margin-bottom: 23px;
                border-radius: 20px;
                color: #fff;
                background: linear-gradient(120deg, #2874d0, #174c91);
                box-shadow: 0 10px 25px rgba(40, 100, 180, .18);
            }

            .emplois-page .emploi-hero::before {
                content: "";
                position: absolute;
                width: 240px;
                height: 240px;
                right: 12%;
                top: -155px;
                border: 36px solid rgba(255, 255, 255, .10);
                border-radius: 50%;
            }

            .emplois-page .emploi-hero-content {
                position: relative;
                z-index: 1;
            }

            .emplois-page .emploi-hero h2 {
                margin: 0 0 8px;
                color: #fff;
                font-size: 25px;
                font-weight: 800;
            }

            .emplois-page .emploi-hero p {
                margin: 0;
                color: rgba(255, 255, 255, .85);
                font-size: 14px;
            }

            .emplois-page .emploi-hero-icon {
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

            .emplois-page .emploi-add-btn {
                position: relative;
                z-index: 2;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 11px 17px;
                border: 1px solid rgba(255, 255, 255, .35);
                border-radius: 10px;
                color: #fff;
                background: rgba(255, 255, 255, .16);
                text-decoration: none;
                font-size: 13px;
                font-weight: 700;
                transition: .2s;
            }

            .emplois-page .emploi-add-btn:hover {
                color: #fff;
                background: rgba(255, 255, 255, .28);
                transform: translateY(-2px);
            }

            /* =====================================================
                   ALERTES
                ===================================================== */

            .emplois-page .emploi-alert {
                padding: 14px 18px;
                margin-bottom: 17px;
                border-radius: 12px;
                font-size: 13px;
            }

            .emplois-page .emploi-alert ul {
                padding-left: 20px;
            }

            /* =====================================================
                   STATISTIQUES
                ===================================================== */

            .emplois-page .emploi-stats {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
                margin-bottom: 23px;
            }

            .emplois-page .emploi-stat {
                position: relative;
                overflow: hidden;
                display: flex;
                align-items: center;
                gap: 14px;
                min-width: 0;
                padding: 19px;
                border: 1px solid var(--emploi-border);
                border-radius: 15px;
                background: var(--emploi-surface);
                box-shadow: var(--emploi-shadow);
                transition: .2s;
            }

            .emplois-page .emploi-stat:hover {
                transform: translateY(-3px);
            }

            .emplois-page .emploi-stat-icon {
                width: 47px;
                height: 47px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 13px;
                font-size: 21px;
            }

            .emplois-page .emploi-stat-icon.blue {
                color: var(--emploi-primary);
                background: var(--emploi-primary-soft);
            }

            .emplois-page .emploi-stat-icon.green {
                color: var(--emploi-success);
                background: var(--emploi-success-soft);
            }

            .emplois-page .emploi-stat-icon.orange {
                color: var(--emploi-warning);
                background: var(--emploi-warning-soft);
            }

            .emplois-page .emploi-stat-icon.cyan {
                color: var(--emploi-info);
                background: var(--emploi-info-soft);
            }

            .emplois-page .emploi-stat-label {
                margin-bottom: 5px;
                color: var(--emploi-muted);
                font-size: 12px;
                font-weight: 600;
            }

            .emplois-page .emploi-stat-value {
                color: var(--emploi-heading);
                font-size: 24px;
                font-weight: 800;
                line-height: 1.2;
            }

            .emplois-page .emploi-stat-note {
                margin-top: 4px;
                color: var(--emploi-muted);
                font-size: 10px;
            }

            /* =====================================================
                   CARTES
                ===================================================== */

            .emplois-page .emploi-card {
                overflow: hidden;
                margin-bottom: 22px;
                border: 1px solid var(--emploi-border);
                border-radius: 16px;
                background: var(--emploi-surface);
                box-shadow: var(--emploi-shadow);
            }

            .emplois-page .emploi-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                padding: 18px 22px;
                border-bottom: 1px solid var(--emploi-border);
                background: var(--emploi-surface-soft);
            }

            .emplois-page .emploi-card-heading {
                display: flex;
                align-items: center;
                gap: 11px;
            }

            .emplois-page .emploi-card-heading i {
                color: var(--emploi-primary);
                font-size: 19px;
            }

            .emplois-page .emploi-card-heading h5 {
                margin: 0;
                color: var(--emploi-heading);
                font-size: 15px;
                font-weight: 800;
            }

            .emplois-page .emploi-card-heading small {
                display: block;
                margin-top: 3px;
                color: var(--emploi-muted);
                font-size: 11px;
            }

            .emplois-page .emploi-card-body {
                padding: 22px;
            }

            /* =====================================================
                   FILTRES
                ===================================================== */

            .emplois-page .form-label {
                margin-bottom: 7px;
                color: var(--emploi-heading);
                font-size: 12px;
                font-weight: 700;
            }

            .emplois-page .form-control,
            .emplois-page .form-select {
                min-height: 43px;
                border: 1px solid var(--emploi-border);
                border-radius: 9px;
                background-color: var(--emploi-surface);
                color: var(--emploi-text);
                font-size: 13px;
                box-shadow: none;
            }

            .emplois-page .form-control:focus,
            .emplois-page .form-select:focus {
                border-color: var(--emploi-primary);
                box-shadow: 0 0 0 3px color-mix(in srgb, var(--emploi-primary) 15%, transparent);
            }

            .emplois-page .form-select option {
                color: var(--emploi-text);
                background: var(--emploi-surface);
            }

            .emplois-page .emploi-filter-btn {
                min-height: 43px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                padding: 9px 15px;
                border: 1px solid var(--emploi-primary);
                border-radius: 9px;
                color: #fff;
                background: var(--emploi-primary);
                font-size: 12px;
                font-weight: 700;
                text-decoration: none;
                transition: .2s;
            }

            .emplois-page .emploi-filter-btn:hover {
                color: #fff;
                background: var(--emploi-primary-dark);
            }

            .emplois-page .emploi-reset-btn {
                width: 43px;
                height: 43px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid var(--emploi-border);
                border-radius: 9px;
                color: var(--emploi-muted);
                background: var(--emploi-surface);
                font-size: 16px;
                text-decoration: none;
                transition: .2s;
            }

            .emplois-page .emploi-reset-btn:hover {
                color: var(--emploi-primary);
                border-color: var(--emploi-primary);
                background: var(--emploi-primary-soft);
            }

            /* =====================================================
                   BADGES
                ===================================================== */

            .emplois-page .emploi-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 7px 11px;
                border-radius: 30px;
                font-size: 11px;
                font-weight: 800;
                white-space: nowrap;
            }

            .emplois-page .emploi-badge.published {
                color: var(--emploi-success);
                background: var(--emploi-success-soft);
            }

            .emplois-page .emploi-badge.draft {
                color: var(--emploi-warning);
                background: var(--emploi-warning-soft);
            }

            .emplois-page .emploi-badge.slots {
                color: var(--emploi-info);
                background: var(--emploi-info-soft);
            }

            .emplois-page .emploi-count {
                padding: 7px 12px;
                border: 1px solid var(--emploi-border);
                border-radius: 30px;
                color: var(--emploi-heading);
                background: var(--emploi-surface);
                font-size: 11px;
                font-weight: 800;
                white-space: nowrap;
            }

            /* =====================================================
                   TABLEAU
                ===================================================== */

            .emplois-page .emploi-table-wrap {
                overflow-x: auto;
            }

            .emplois-page .emploi-table {
                width: 100%;
                min-width: 850px;
                margin: 0;
                border-collapse: separate;
                border-spacing: 0;
                color: var(--emploi-text);
            }

            .emplois-page .emploi-table thead th {
                position: sticky;
                top: 0;
                z-index: 1;
                padding: 15px 13px;
                border-bottom: 1px solid var(--emploi-border);
                color: var(--emploi-muted);
                background: var(--emploi-surface-soft);
                font-size: 11px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .4px;
                white-space: nowrap;
            }

            .emplois-page .emploi-table tbody td {
                padding: 15px 13px;
                border-bottom: 1px solid var(--emploi-border);
                color: var(--emploi-text);
                background: var(--emploi-surface);
                font-size: 12px;
                vertical-align: middle;
            }

            .emplois-page .emploi-table tbody tr:last-child td {
                border-bottom: none;
            }

            .emplois-page .emploi-table tbody tr:hover td {
                background: var(--emploi-surface-soft);
            }

            .emplois-page .emploi-number {
                color: var(--emploi-muted);
                font-weight: 700;
            }

            .emplois-page .emploi-class-name {
                color: var(--emploi-heading);
                font-weight: 800;
            }

            .emplois-page .emploi-title {
                color: var(--emploi-heading);
                font-weight: 700;
            }

            .emplois-page .emploi-year {
                color: var(--emploi-muted);
            }

            /* =====================================================
                   ACTIONS
                ===================================================== */

            .emplois-page .emploi-actions {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 5px;
            }

            .emplois-page .emploi-action-btn {
                width: 32px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid var(--emploi-border);
                border-radius: 8px;
                background: var(--emploi-surface);
                font-size: 14px;
                text-decoration: none;
                cursor: pointer;
                transition: .2s;
            }

            .emplois-page .emploi-action-btn:hover {
                transform: translateY(-2px);
            }

            .emplois-page .action-view {
                color: var(--emploi-primary);
            }

            .emplois-page .action-view:hover {
                color: var(--emploi-primary);
                background: var(--emploi-primary-soft);
                border-color: var(--emploi-primary);
            }

            .emplois-page .action-edit {
                color: var(--emploi-warning);
            }

            .emplois-page .action-edit:hover {
                color: var(--emploi-warning);
                background: var(--emploi-warning-soft);
                border-color: var(--emploi-warning);
            }

            .emplois-page .action-delete {
                color: var(--emploi-danger);
            }

            .emplois-page .action-delete:hover {
                color: var(--emploi-danger);
                background: var(--emploi-danger-soft);
                border-color: var(--emploi-danger);
            }

            .emplois-page .action-publish {
                color: var(--emploi-success);
            }

            .emplois-page .action-publish:hover {
                color: var(--emploi-success);
                background: var(--emploi-success-soft);
                border-color: var(--emploi-success);
            }

            .emplois-page .action-draft {
                color: var(--emploi-muted);
            }

            .emplois-page .action-draft:hover {
                color: var(--emploi-heading);
                background: var(--emploi-surface-soft);
                border-color: var(--emploi-muted);
            }

            /* =====================================================
                   ETAT VIDE
                ===================================================== */

            .emplois-page .emploi-empty {
                padding: 55px 20px !important;
                text-align: center;
            }

            .emplois-page .emploi-empty-icon {
                width: 75px;
                height: 75px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 16px;
                border-radius: 22px;
                color: var(--emploi-muted);
                background: var(--emploi-surface-soft);
                font-size: 34px;
            }

            .emplois-page .emploi-empty h6 {
                margin-bottom: 7px;
                color: var(--emploi-heading);
                font-size: 15px;
                font-weight: 800;
            }

            .emplois-page .emploi-empty p {
                margin-bottom: 17px;
                color: var(--emploi-muted);
                font-size: 12px;
            }

            /* =====================================================
                   PAGINATION
                ===================================================== */

            .emplois-page .emploi-pagination {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 14px;
                padding: 17px 22px;
                border-top: 1px solid var(--emploi-border);
                background: var(--emploi-surface);
            }

            .emplois-page .pagination-summary {
                color: var(--emploi-muted);
                font-size: 12px;
            }

            .emplois-page .pagination-summary strong {
                color: var(--emploi-heading);
            }

            .emplois-page .pagination {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin: 0;
            }

            .emplois-page .page-item .page-link {
                min-width: 34px;
                height: 34px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 5px 10px;
                border: 1px solid var(--emploi-border);
                border-radius: 8px !important;
                color: var(--emploi-text);
                background: var(--emploi-surface);
                font-size: 12px;
                font-weight: 700;
                box-shadow: none;
            }

            .emplois-page .page-item .page-link:hover {
                color: var(--emploi-primary);
                border-color: var(--emploi-primary);
                background: var(--emploi-primary-soft);
            }

            .emplois-page .page-item.active .page-link {
                color: #fff;
                border-color: var(--emploi-primary);
                background: var(--emploi-primary);
            }

            .emplois-page .page-item.disabled .page-link {
                color: var(--emploi-muted);
                background: var(--emploi-surface-soft);
                opacity: .55;
            }

            /* =====================================================
                   RESPONSIVE
                ===================================================== */

            @media (max-width: 1100px) {
                .emplois-page .emploi-stats {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 768px) {
                .emplois-page {
                    padding: 15px;
                }

                .emplois-page .emploi-hero {
                    padding: 22px;
                }

                .emplois-page .emploi-hero h2 {
                    font-size: 20px;
                }

                .emplois-page .emploi-card-header,
                .emplois-page .emploi-card-body {
                    padding: 16px;
                }

                .emplois-page .emploi-pagination {
                    align-items: flex-start;
                    flex-direction: column;
                    padding: 15px;
                }
            }

            @media (max-width: 480px) {
                .emplois-page .emploi-stats {
                    grid-template-columns: 1fr 1fr;
                    gap: 10px;
                }

                .emplois-page .emploi-stat {
                    padding: 13px;
                    gap: 9px;
                }

                .emplois-page .emploi-stat-icon {
                    width: 38px;
                    height: 38px;
                    font-size: 17px;
                }

                .emplois-page .emploi-stat-value {
                    font-size: 20px;
                }

                .emplois-page .emploi-hero-icon {
                    display: none;
                }

                .emplois-page .emploi-hero {
                    align-items: flex-start;
                }

                .emplois-page .emploi-add-btn {
                    padding: 9px 11px;
                    font-size: 11px;
                }
            }
        </style>

        {{-- =====================================================
             HERO
        ====================================================== --}}

        <div class="emploi-hero">

            <div class="emploi-hero-content">
                <h2>
                    <i class="bi bi-calendar-week me-2"></i>
                    Emplois du temps
                </h2>

                <p>
                    Gestion et organisation des emplois du temps par classe et par année scolaire.
                </p>
            </div>

            <div class="d-flex align-items-center gap-3">

                @if ($creer)
                    <a href="{{ route('emplois-temps.create') }}" class="emploi-add-btn">
                        <i class="bi bi-plus-circle"></i>
                        Nouvel emploi du temps
                    </a>
                @endif

                <div class="emploi-hero-icon">
                    <i class="bi bi-calendar2-week"></i>
                </div>

            </div>

        </div>

        {{-- =====================================================
             MESSAGES
        ====================================================== --}}

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show emploi-alert" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show emploi-alert" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger emploi-alert">
                <strong>
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Veuillez corriger les erreurs suivantes :
                </strong>

                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- =====================================================
             STATISTIQUES
        ====================================================== --}}

        <div class="emploi-stats">

            <div class="emploi-stat">
                <div class="emploi-stat-icon blue">
                    <i class="bi bi-calendar-week"></i>
                </div>
                <div>
                    <div class="emploi-stat-label">Total des résultats</div>
                    <div class="emploi-stat-value">{{ $emploisTemps->total() }}</div>
                    <div class="emploi-stat-note">Tous les résultats filtrés</div>
                </div>
            </div>

            <div class="emploi-stat">
                <div class="emploi-stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="emploi-stat-label">Emplois publiés</div>
                    <div class="emploi-stat-value">{{ $publiesPage }}</div>
                    <div class="emploi-stat-note">Sur cette page</div>
                </div>
            </div>

            <div class="emploi-stat">
                <div class="emploi-stat-icon orange">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <div class="emploi-stat-label">Brouillons</div>
                    <div class="emploi-stat-value">{{ $brouillonsPage }}</div>
                    <div class="emploi-stat-note">Sur cette page</div>
                </div>
            </div>

            <div class="emploi-stat">
                <div class="emploi-stat-icon cyan">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <div class="emploi-stat-label">Créneaux</div>
                    <div class="emploi-stat-value">{{ $creneauxPage }}</div>
                    <div class="emploi-stat-note">Sur cette page</div>
                </div>
            </div>

        </div>

        {{-- =====================================================
             FILTRES
        ====================================================== --}}

        <div class="emploi-card">

            <div class="emploi-card-header">
                <div class="emploi-card-heading">
                    <i class="bi bi-funnel"></i>
                    <div>
                        <h5>Filtrer les emplois du temps</h5>
                        <small>Affinez la liste selon vos critères</small>
                    </div>
                </div>

                <span class="emploi-count">
                    <i class="bi bi-sliders me-1"></i>
                    Filtres
                </span>
            </div>

            <div class="emploi-card-body">

                <form method="GET" action="{{ route('emplois-temps.index') }}">

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-4 col-md-6">
                            <label for="classe_id" class="form-label">
                                <i class="bi bi-building me-1"></i>
                                Classe
                            </label>

                            <select name="classe_id" id="classe_id" class="form-select">
                                <option value="">Toutes les classes</option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}" @selected(request('classe_id') == $classe->id)>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <label for="annee_scolaire_id" class="form-label">
                                <i class="bi bi-calendar3 me-1"></i>
                                Année scolaire
                            </label>

                            <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select">
                                <option value="">Toutes les années</option>

                                @foreach ($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}" @selected(request('annee_scolaire_id') == $annee->id)>
                                        {{ $annee->nom ?? ($annee->libelle ?? ($annee->annee ?? $annee->id)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <label for="statut" class="form-label">
                                <i class="bi bi-flag me-1"></i>
                                Statut
                            </label>

                            <select name="statut" id="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="brouillon" @selected(request('statut') === 'brouillon')>
                                    Brouillon
                                </option>
                                <option value="publie" @selected(request('statut') === 'publie')>
                                    Publié
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <div class="d-flex gap-2">
                                <button type="submit" class="emploi-filter-btn flex-grow-1">
                                    <i class="bi bi-search"></i>
                                    Filtrer
                                </button>

                                <a href="{{ route('emplois-temps.index') }}" class="emploi-reset-btn"
                                    title="Réinitialiser les filtres">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        {{-- =====================================================
             TABLEAU DES EMPLOIS DU TEMPS
        ====================================================== --}}

        <div class="emploi-card">

            <div class="emploi-card-header">

                <div class="emploi-card-heading">
                    <i class="bi bi-list-ul"></i>
                    <div>
                        <h5>Liste des emplois du temps</h5>
                        <small>Consultez et gérez les emplois du temps enregistrés</small>
                    </div>
                </div>

                <span class="emploi-count">
                    {{ $emploisTemps->total() }} résultat(s)
                </span>

            </div>

            <div class="emploi-table-wrap">

                <table class="emploi-table">

                    <thead>
                        <tr>
                            <th class="ps-4">N°</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th>Titre</th>
                            <th>Créneaux</th>
                            <th>Statut</th>

                            @if ($afficherActions)
                                <th class="text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($emploisTemps as $emploi)
                            <tr>

                                <td class="ps-4">
                                    <span class="emploi-number">
                                        {{ $emploisTemps->firstItem() + $loop->index }}
                                    </span>
                                </td>

                                <td>
                                    <span class="emploi-class-name">
                                        <i class="bi bi-mortarboard me-1"></i>
                                        {{ $emploi->classe->nom ?? 'Classe supprimée' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="emploi-year">
                                        {{ $emploi->anneeScolaire->nom ??
                                            ($emploi->anneeScolaire->libelle ?? ($emploi->anneeScolaire->annee ?? 'Année scolaire')) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="emploi-title">
                                        {{ $emploi->titre ?: 'Emploi du temps général' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="emploi-badge slots">
                                        <i class="bi bi-clock"></i>
                                        {{ $emploi->creneaux_count }} créneau(x)
                                    </span>
                                </td>

                                <td>
                                    @if ($emploi->statut === 'publie')
                                        <span class="emploi-badge published">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Publié
                                        </span>
                                    @else
                                        <span class="emploi-badge draft">
                                            <i class="bi bi-pencil-square"></i>
                                            Brouillon
                                        </span>
                                    @endif
                                </td>

                                @if ($afficherActions)
                                    <td>
                                        <div class="emploi-actions">

                                            {{-- VOIR --}}
                                            @if ($show)
                                                <a href="{{ route('emplois-temps.show', $emploi) }}"
                                                    class="emploi-action-btn action-view" title="Voir les détails"
                                                    aria-label="Voir les détails">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif

                                            {{-- MODIFIER --}}
                                            @if ($modifier && $emploi->statut !== 'publie')
                                                <a href="{{ route('emplois-temps.edit', $emploi) }}"
                                                    class="emploi-action-btn action-edit" title="Modifier"
                                                    aria-label="Modifier">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif

                                            {{-- SUPPRIMER --}}
                                            @if ($supprimer && $emploi->statut !== 'publie')
                                                <form action="{{ route('emplois-temps.destroy', $emploi) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cet emploi du temps ?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="emploi-action-btn action-delete"
                                                        title="Supprimer" aria-label="Supprimer">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- PUBLIER --}}
                                            @if ($valider && $emploi->statut !== 'publie')
                                                <form action="{{ route('emplois-temps.publier', $emploi) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Voulez-vous publier cet emploi du temps ?');">
                                                    @csrf

                                                    <button type="submit" class="emploi-action-btn action-publish"
                                                        title="Publier" aria-label="Publier">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- REMETTRE EN BROUILLON --}}
                                            @if ($valider && $emploi->statut === 'publie')
                                                <form action="{{ route('emplois-temps.brouillon', $emploi) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Voulez-vous remettre cet emploi du temps en brouillon ?');">
                                                    @csrf

                                                    <button type="submit" class="emploi-action-btn action-draft"
                                                        title="Remettre en brouillon" aria-label="Remettre en brouillon">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                @endif

                            </tr>

                        @empty

                            <tr>
                                <td colspan="{{ $afficherActions ? 7 : 6 }}" class="emploi-empty">

                                    <div class="emploi-empty-icon">
                                        <i class="bi bi-calendar-x"></i>
                                    </div>

                                    <h6>Aucun emploi du temps trouvé</h6>

                                    <p>
                                        Aucun résultat ne correspond à vos critères de recherche.
                                    </p>

                                    @if ($creer)
                                        <a href="{{ route('emplois-temps.create') }}" class="emploi-filter-btn">
                                            <i class="bi bi-plus-circle"></i>
                                            Créer un emploi du temps
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- =================================================
                 PAGINATION
            ================================================== --}}

            @if ($emploisTemps->hasPages())
                <div class="emploi-pagination">

                    <div class="pagination-summary">
                        Affichage de
                        <strong>{{ $emploisTemps->firstItem() }}</strong>
                        à
                        <strong>{{ $emploisTemps->lastItem() }}</strong>
                        sur
                        <strong>{{ $emploisTemps->total() }}</strong>
                        résultat(s)
                    </div>

                    <div>
                        {{ $emploisTemps->onEachSide(2)->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection
