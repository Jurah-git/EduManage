@extends('layouts.app')

@section('content')
    @php
        $classesFiltre = collect($eleves)->map(fn($e) => $e->classe->nom ?? null)->filter()->unique()->sort()->values();
    @endphp

    <style>
        /* =========================================================
                   EDU MANAGE - SAISIE DES NOTES
                ========================================================= */

        .notes-page {
            --np-bg: #f3f6fc;
            --np-card: #ffffff;
            --np-soft: #f7f9fd;
            --np-text: #24344d;
            --np-muted: #718096;
            --np-border: #e3eaf3;
            --np-primary: #3972e6;
            --np-primary-soft: #eaf1ff;
            --np-shadow: 0 8px 28px rgba(32, 56, 92, .06);

            background: var(--np-bg);
            color: var(--np-text);
            min-height: calc(100vh - 60px);
            transition: background .25s, color .25s;
        }

        .notes-page * {
            box-sizing: border-box;
        }

        /* =========================================================
                   HERO
                ========================================================= */

        .notes-page .notes-hero {
            position: relative;
            overflow: hidden;
            padding: 27px 30px;
            border-radius: 22px;
            background: linear-gradient(135deg, #2458b8, #5388f0);
            color: #fff;
            box-shadow: 0 12px 28px rgba(45, 100, 210, .17);
        }

        .notes-page .notes-hero::before {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            right: -65px;
            top: -110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
        }

        .notes-page .notes-hero::after {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            right: 120px;
            bottom: -120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
        }

        .notes-page .notes-hero-content {
            position: relative;
            z-index: 1;
        }

        .notes-page .notes-hero-icon {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 17px;
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .18);
            font-size: 1.6rem;
        }

        .notes-page .notes-hero-title {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -.4px;
            margin: 0;
            color: #fff;
        }

        .notes-page .notes-hero-subtitle {
            color: rgba(255, 255, 255, .83);
            font-size: .92rem;
            margin: 7px 0 0;
        }

        .notes-page .notes-count-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border-radius: 30px;
            color: #fff;
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .22);
            backdrop-filter: blur(5px);
            font-size: .83rem;
            white-space: nowrap;
        }

        .notes-page .notes-count-pill strong {
            color: #fff;
            font-size: .95rem;
        }

        /* =========================================================
                   PANNEAU PRINCIPAL
                ========================================================= */

        .notes-page .card-modern {
            background: var(--np-card);
            border: 1px solid var(--np-border);
            border-radius: 20px;
            box-shadow: var(--np-shadow);
            overflow: hidden;
        }

        .notes-page .notes-card-header {
            background: var(--np-card);
            border-bottom: 1px solid var(--np-border);
            padding: 20px 24px;
        }

        .notes-page .notes-card-heading {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notes-page .notes-card-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--np-primary-soft);
            color: var(--np-primary);
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .notes-page .notes-card-title {
            color: var(--np-text);
            font-weight: 800;
            font-size: 1rem;
            margin: 0;
        }

        .notes-page .notes-card-description {
            color: var(--np-muted);
            font-size: .8rem;
            margin-top: 4px;
        }

        /* =========================================================
                   FILTRES
                ========================================================= */

        .notes-page .notes-filters {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
        }

        .notes-page .filter-control {
            background-color: var(--np-card);
            border: 1px solid var(--np-border);
            color: var(--np-text);
            border-radius: 10px;
            font-size: .84rem;
            min-height: 38px;
            box-shadow: none;
            transition: border .2s, box-shadow .2s, background .2s;
        }

        .notes-page .filter-control::placeholder {
            color: var(--np-muted);
            opacity: .85;
        }

        .notes-page .filter-control:focus {
            background-color: var(--np-card);
            color: var(--np-text);
            border-color: var(--np-primary);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--np-primary) 14%, transparent);
        }

        .notes-page select.filter-control option {
            background: var(--np-card);
            color: var(--np-text);
        }

        .notes-page .notes-search {
            position: relative;
            min-width: 230px;
            flex: 1;
        }

        .notes-page .notes-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--np-muted);
            z-index: 2;
            pointer-events: none;
        }

        .notes-page .notes-search input {
            padding-left: 36px;
            width: 100%;
        }

        .notes-page .btn-reset-filter {
            min-height: 38px;
            border: 1px solid var(--np-border);
            border-radius: 10px;
            background: var(--np-soft);
            color: var(--np-muted);
            font-size: .82rem;
            font-weight: 650;
            padding: 7px 13px;
            transition: .2s;
        }

        .notes-page .btn-reset-filter:hover {
            border-color: var(--np-primary);
            color: var(--np-primary);
            background: var(--np-primary-soft);
        }

        /* =========================================================
                   TABLEAU
                ========================================================= */

        .notes-page .table-responsive {
            background: var(--np-card);
        }

        .notes-page .table-modern {
            width: 100%;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
            color: var(--np-text);
        }

        .notes-page .table-modern thead th {
            background: var(--np-soft);
            color: var(--np-muted);
            font-size: .74rem;
            text-transform: uppercase;
            letter-spacing: .7px;
            font-weight: 800;
            padding: 15px 20px;
            border-bottom: 1px solid var(--np-border);
            border-top: none;
            white-space: nowrap;
        }

        .notes-page .table-modern tbody td {
            background: var(--np-card);
            color: var(--np-text);
            padding: 14px 20px;
            vertical-align: middle;
            border-bottom: 1px solid var(--np-border);
            font-size: .89rem;
        }

        .notes-page .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        .notes-page .table-modern tbody tr {
            transition: background .18s ease;
        }

        .notes-page .table-modern tbody tr:hover td {
            background: var(--np-soft);
        }

        /* =========================================================
                   AVATAR ÉLÈVE
                ========================================================= */

        /* =========================================================
           PHOTO ÉLÈVE
        ========================================================= */

        .notes-page .avatar-eleve {
            width: 46px;
            height: 46px;
            min-width: 46px;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
            border: 2px solid var(--np-border);
            background: var(--np-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 3px 9px rgba(32, 56, 92, .10);
            transition: all .25s ease;
        }

        .notes-page .avatar-eleve:hover {
            transform: scale(1.08);
            border-color: var(--np-primary);
            box-shadow: 0 5px 13px rgba(57, 114, 230, .20);
        }

        .notes-page .photo-eleve {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
        }

        .notes-page .avatar-initials {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(145deg, #e7efff, #d7e5ff);
            color: #3568c8;
            font-size: .84rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        /* Mode sombre */
        html[data-app-theme="dark"] .notes-page .avatar-eleve {
            border-color: #40516b;
        }

        html[data-app-theme="dark"] .notes-page .avatar-initials {
            background: #283f61;
            color: #a5c4ff;
        }

        /* Ultra Pro */
        html[data-app-theme="ultra-pro"] .notes-page .avatar-eleve {
            border-color: #40516b;
        }

        html[data-app-theme="ultra-pro"] .notes-page .avatar-initials {
            background: #243c5d;
            color: #a4c7ff;
        }

        /* Émeraude */
        html[data-app-theme="emerald"] .notes-page .avatar-initials {
            background: #ddf3e8;
            color: #16865f;
        }

        /* Crème Prestige */
        html[data-app-theme="warm"] .notes-page .avatar-initials {
            background: #f3e4d0;
            color: #a76d33;
        }

        .notes-page .student-name {
            font-weight: 700;
            color: var(--np-text);
        }

        .notes-page .student-meta {
            color: var(--np-muted);
            font-size: .74rem;
            margin-top: 3px;
        }

        /* =========================================================
                   BADGE CLASSE
                ========================================================= */

        .notes-page .badge-classe {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--np-primary-soft);
            color: var(--np-primary);
            font-weight: 750;
            padding: 7px 12px;
            border-radius: 9px;
            font-size: .78rem;
            white-space: nowrap;
        }

        .notes-page .badge-non-affecte {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--np-soft);
            color: var(--np-muted);
            border: 1px solid var(--np-border);
            font-weight: 650;
            padding: 7px 11px;
            border-radius: 9px;
            font-size: .77rem;
        }

        /* =========================================================
                   BOUTON SAISIE
                ========================================================= */

        .notes-page .btn-action {
            border: none;
            border-radius: 9px;
            font-weight: 700;
            padding: 8px 14px;
            font-size: .82rem;
            transition: transform .15s, box-shadow .15s, background .15s;
            background: var(--np-primary);
            color: #fff;
            white-space: nowrap;
        }

        .notes-page .btn-action:hover {
            background: var(--np-primary);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 5px 12px color-mix(in srgb, var(--np-primary) 25%, transparent);
        }

        .notes-page .btn-action:active {
            transform: scale(.97);
        }

        /* =========================================================
                   ÉTAT VIDE
                ========================================================= */

        .notes-page .notes-empty {
            text-align: center;
            padding: 65px 20px;
        }

        .notes-page .notes-empty-icon {
            width: 76px;
            height: 76px;
            margin: 0 auto 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 23px;
            background: var(--np-soft);
            color: var(--np-muted);
            border: 1px solid var(--np-border);
            font-size: 2rem;
        }

        .notes-page .notes-empty-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--np-text);
            margin-bottom: 7px;
        }

        .notes-page .notes-empty-text {
            color: var(--np-muted);
            font-size: .87rem;
            margin: 0;
        }

        /* =========================================================
                   ZONE AJAX
                ========================================================= */

        .notes-page #zone {
            margin-top: 24px;
        }

        .notes-page #zone:empty {
            margin-top: 0;
        }

        /* =========================================================
                   ALERTES
                ========================================================= */

        .notes-page .alert {
            border-radius: 12px;
        }

        /* =========================================================
                   POPUP ENREGISTREMENT
                ========================================================= */

        .popup-save {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            padding: 20px;
            background: rgba(9, 16, 30, .62);
            backdrop-filter: blur(5px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }

        .popup-box {
            background: #ffffff;
            color: #23334d;
            padding: 32px;
            border-radius: 22px;
            width: 430px;
            max-width: 95%;
            text-align: center;
            box-shadow: 0 25px 80px rgba(0, 0, 0, .25);
            animation: notesPopupIn .22s ease-out;
        }

        .popup-box .popup-success-icon {
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background: #e6f7ed;
            color: #20a15a;
            font-size: 2rem;
            margin: 0 auto 16px;
        }

        .popup-box h5 {
            font-weight: 850;
            color: #24344d;
            margin-bottom: 10px;
        }

        .popup-box p {
            color: #64748b;
            font-size: .93rem;
            margin-bottom: 22px;
            line-height: 1.6;
        }

        .popup-box .btn-popup-ok {
            border-radius: 10px;
            padding: 9px 30px;
            font-weight: 750;
            background: #20a15a;
            border: none;
            color: #fff;
            transition: .2s;
        }

        .popup-box .btn-popup-ok:hover {
            background: #168347;
            transform: translateY(-1px);
        }

        @keyframes notesPopupIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .popup-erreur {
            border: 2px solid #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .10) !important;
        }

        .erreur-periode {
            color: #ef4444;
            font-size: .76rem;
            margin-top: 6px;
            font-weight: 600;
        }

        /* =========================================================
                   THÈME DARK
                ========================================================= */

        html[data-app-theme="dark"] .notes-page {
            --np-bg: #111827;
            --np-card: #1b2433;
            --np-soft: #222e40;
            --np-text: #e5edf8;
            --np-muted: #9aabc2;
            --np-border: #344256;
            --np-primary: #82aaff;
            --np-primary-soft: #263c61;
            --np-shadow: 0 8px 28px rgba(0, 0, 0, .20);
        }

        html[data-app-theme="dark"] .notes-page .notes-hero {
            background: linear-gradient(135deg, #172e50, #244c82);
        }

        html[data-app-theme="dark"] .notes-page .table-modern thead th,
        html[data-app-theme="dark"] .notes-page .table-modern tbody td {
            background: var(--np-card);
            color: var(--np-text);
            border-color: var(--np-border);
        }

        html[data-app-theme="dark"] .notes-page .table-modern thead th {
            background: var(--np-soft);
            color: var(--np-muted);
        }

        html[data-app-theme="dark"] .notes-page .table-modern tbody tr:hover td {
            background: var(--np-soft);
        }

        html[data-app-theme="dark"] .notes-page .filter-control {
            background: var(--np-card);
            color: var(--np-text);
            border-color: var(--np-border);
        }

        html[data-app-theme="dark"] .notes-page .btn-reset-filter {
            background: var(--np-soft);
            color: var(--np-muted);
            border-color: var(--np-border);
        }

        /* =========================================================
                   THÈME ULTRA PRO
                ========================================================= */

        html[data-app-theme="ultra-pro"] .notes-page {
            --np-bg: #0c1426;
            --np-card: #151f35;
            --np-soft: #1c2942;
            --np-text: #e6edfa;
            --np-muted: #9aaed0;
            --np-border: #2d3b57;
            --np-primary: #8eafff;
            --np-primary-soft: #263a61;
            --np-shadow: 0 12px 35px rgba(0, 0, 0, .23);
        }

        html[data-app-theme="ultra-pro"] .notes-page .notes-hero {
            background: linear-gradient(135deg, #1b2c50, #364e82);
        }

        html[data-app-theme="ultra-pro"] .notes-page .table-modern thead th,
        html[data-app-theme="ultra-pro"] .notes-page .table-modern tbody td {
            background: var(--np-card);
            color: var(--np-text);
            border-color: var(--np-border);
        }

        html[data-app-theme="ultra-pro"] .notes-page .table-modern thead th {
            background: var(--np-soft);
            color: var(--np-muted);
        }

        html[data-app-theme="ultra-pro"] .notes-page .table-modern tbody tr:hover td {
            background: var(--np-soft);
        }

        html[data-app-theme="ultra-pro"] .notes-page .filter-control {
            background: var(--np-card);
            color: var(--np-text);
            border-color: var(--np-border);
        }

        html[data-app-theme="ultra-pro"] .notes-page .btn-reset-filter {
            background: var(--np-soft);
            color: var(--np-muted);
            border-color: var(--np-border);
        }

        /* =========================================================
                   THÈME EMERALD
                ========================================================= */

        html[data-app-theme="emerald"] .notes-page {
            --np-bg: #eff8f4;
            --np-card: #ffffff;
            --np-soft: #eaf5ef;
            --np-text: #214738;
            --np-muted: #6d8b7a;
            --np-border: #d5e8dc;
            --np-primary: #168653;
            --np-primary-soft: #ddf3e7;
            --np-shadow: 0 10px 28px rgba(28, 100, 62, .07);
        }

        html[data-app-theme="emerald"] .notes-page .notes-hero {
            background: linear-gradient(135deg, #18764b, #38a875);
        }

        /* =========================================================
                   THÈME WARM
                ========================================================= */

        html[data-app-theme="warm"] .notes-page {
            --np-bg: #faf4ec;
            --np-card: #fffdf9;
            --np-soft: #f7eee3;
            --np-text: #4b3829;
            --np-muted: #967e68;
            --np-border: #eadbc9;
            --np-primary: #b87536;
            --np-primary-soft: #f7e8d6;
            --np-shadow: 0 10px 28px rgba(130, 85, 42, .07);
        }

        html[data-app-theme="warm"] .notes-page .notes-hero {
            background: linear-gradient(135deg, #96602f, #c68b4b);
        }

        /* =========================================================
                   RESPONSIVE
                ========================================================= */

        @media (max-width: 992px) {
            .notes-page .notes-filters {
                width: 100%;
            }

            .notes-page .notes-search {
                min-width: 200px;
            }
        }

        @media (max-width: 768px) {
            .notes-page .notes-hero {
                padding: 22px;
                border-radius: 17px;
            }

            .notes-page .notes-hero-title {
                font-size: 1.35rem;
            }

            .notes-page .notes-hero-icon {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }

            .notes-page .notes-card-header {
                padding: 17px;
            }

            .notes-page .notes-filters {
                flex-direction: column;
                align-items: stretch;
            }

            .notes-page .notes-search {
                width: 100%;
                min-width: 100%;
            }

            .notes-page .notes-filters select {
                width: 100% !important;
            }

            .notes-page .btn-reset-filter {
                width: 100%;
            }

            .notes-page .table-modern thead th,
            .notes-page .table-modern tbody td {
                padding: 12px 14px;
            }
        }

        @media (max-width: 480px) {
            .notes-page .notes-hero {
                padding: 18px;
            }

            .notes-page .notes-hero-title {
                font-size: 1.2rem;
            }

            .notes-page .notes-hero-subtitle {
                font-size: .82rem;
            }

            .notes-page .notes-count-pill {
                width: 100%;
                justify-content: center;
            }

            .notes-page .notes-card-header {
                padding: 14px;
            }
        }

        /* =========================================================
                   IMPRESSION
                ========================================================= */

        @media print {
            .notes-page {
                background: white !important;
                color: #222 !important;
                padding: 0 !important;
            }

            .notes-page .notes-hero {
                background: white !important;
                color: #222 !important;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            .notes-page .notes-hero-title {
                color: #222 !important;
            }

            .notes-page .notes-hero-subtitle {
                color: #555 !important;
            }

            .notes-page .notes-hero-icon {
                background: #eee !important;
                color: #333 !important;
            }

            .notes-page .card-modern {
                background: white !important;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            .notes-page .notes-card-header,
            .notes-page .table-modern thead th,
            .notes-page .table-modern tbody td {
                background: white !important;
                color: #222 !important;
                border-color: #ddd !important;
            }

            .notes-page .notes-filters,
            .notes-page .btn-action,
            .notes-page .btn-reset-filter {
                display: none !important;
            }

            .notes-page .table-modern thead th {
                background: #f1f1f1 !important;
            }

            .notes-page .notes-hero::before,
            .notes-page .notes-hero::after {
                display: none !important;
            }

            .popup-save {
                display: none !important;
            }
        }
    </style>

    <div class="notes-page py-4">

        <div class="container-fluid px-4">

            {{-- =====================================================
                 EN-TÊTE DE PAGE
            ====================================================== --}}

            <div class="notes-hero mb-4">

                <div
                    class="notes-hero-content d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

                    <div class="d-flex align-items-center gap-3">

                        <div class="notes-hero-icon">
                            <i class="bi bi-journal-check"></i>
                        </div>

                        <div>
                            <h2 class="notes-hero-title">
                                Saisie des notes
                            </h2>

                            <p class="notes-hero-subtitle">
                                Sélectionnez un élève pour saisir ou consulter ses notes journalières et de composition.
                            </p>
                        </div>

                    </div>

                    <div class="notes-count-pill">
                        <i class="bi bi-people-fill"></i>
                        <span>Élèves affichés :</span>
                        <strong id="compteurEleves">{{ count($eleves) }}</strong>
                        <span>/ {{ count($eleves) }}</span>
                    </div>

                </div>

            </div>

            {{-- =====================================================
                 LISTE DES ÉLÈVES
            ====================================================== --}}

            <div id="liste-eleves">

                <div class="card card-modern">

                    {{-- HEADER DU TABLEAU --}}

                    <div class="notes-card-header">

                        <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center gap-3">

                            <div class="notes-card-heading">

                                <div class="notes-card-icon">
                                    <i class="bi bi-people"></i>
                                </div>

                                <div>
                                    <h5 class="notes-card-title">
                                        Liste des élèves
                                    </h5>

                                    <div class="notes-card-description">
                                        Recherchez, filtrez et sélectionnez un élève.
                                    </div>
                                </div>

                            </div>

                            {{-- RECHERCHE, FILTRE ET TRI --}}

                            <div class="notes-filters">

                                {{-- RECHERCHE --}}

                                <div class="notes-search">

                                    <i class="bi bi-search notes-search-icon"></i>

                                    <input type="text" id="searchEleve"
                                        class="form-control form-control-sm filter-control"
                                        placeholder="Rechercher un élève..." autocomplete="off">

                                </div>

                                {{-- FILTRE CLASSE --}}

                                <select id="filterClasse" class="form-select form-select-sm filter-control"
                                    style="width:auto; min-width:165px;">

                                    <option value="">Toutes les classes</option>

                                    @foreach ($classesFiltre as $nomClasse)
                                        <option value="{{ mb_strtolower($nomClasse) }}">
                                            {{ $nomClasse }}
                                        </option>
                                    @endforeach

                                    <option value="__non_affecte__">
                                        Non affecté
                                    </option>

                                </select>

                                {{-- TRI --}}

                                <select id="sortEleves" class="form-select form-select-sm filter-control"
                                    style="width:auto; min-width:160px;">

                                    <option value="az">Nom : A → Z</option>
                                    <option value="za">Nom : Z → A</option>
                                    <option value="classe_az">Classe : A → Z</option>

                                </select>

                                {{-- RESET --}}

                                <button type="button" id="btnResetFiltres" class="btn-reset-filter"
                                    title="Réinitialiser les filtres">

                                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                                    Réinitialiser

                                </button>

                            </div>

                        </div>

                    </div>

                    {{-- TABLEAU --}}

                    <div class="table-responsive">

                        <table class="table table-modern text-center mb-0" id="tableEleves">

                            <thead>

                                <tr>
                                    <th class="text-start" style="min-width:250px;">Élève</th>
                                    <th style="min-width:150px;">Classe</th>
                                    <th style="min-width:130px;">Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($eleves as $eleve)
                                    @php
                                        $initiales = strtoupper(
                                            mb_substr($eleve->nom, 0, 1) . mb_substr($eleve->prenom, 0, 1),
                                        );

                                        $nomComplet = trim($eleve->nom . ' ' . $eleve->prenom);

                                        $classeNom = $eleve->classe->nom ?? 'zzz_non_affecte';

                                        $classeSlug = $eleve->classe
                                            ? mb_strtolower($eleve->classe->nom)
                                            : '__non_affecte__';
                                    @endphp

                                    <tr class="eleve-row" data-nom="{{ mb_strtolower($nomComplet) }}"
                                        data-classe="{{ $classeSlug }}" data-classe-tri="{{ mb_strtolower($classeNom) }}">

                                        {{-- NOM --}}

                                        <td class="text-start">

                                            <div class="d-flex align-items-center justify-content-start gap-3">

                                                <div class="avatar-eleve">

                                                    @if ($eleve->photo)
                                                        <img src="{{ asset('storage/' . $eleve->photo) }}"
                                                            alt="Photo de {{ $nomComplet }}" class="photo-eleve"
                                                            loading="lazy"
                                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                                        <div class="avatar-initials" style="display:none;">
                                                            {{ $initiales ?: 'EL' }}
                                                        </div>
                                                    @else
                                                        <div class="avatar-initials">
                                                            {{ $initiales ?: 'EL' }}
                                                        </div>
                                                    @endif

                                                </div>

                                                <div>
                                                    <div class="student-name">
                                                        {{ $eleve->nom }} {{ $eleve->prenom }}
                                                    </div>

                                                    <div class="student-meta">
                                                        <i class="bi bi-person-badge me-1"></i>
                                                        Élève
                                                    </div>
                                                </div>

                                            </div>

                                        </td>

                                        {{-- CLASSE --}}

                                        <td>

                                            @if ($eleve->classe)
                                                <span class="badge-classe">
                                                    <i class="bi bi-mortarboard-fill"></i>
                                                    {{ $eleve->classe->nom }}
                                                </span>
                                            @else
                                                <span class="badge-non-affecte">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                    Non affecté
                                                </span>
                                            @endif

                                        </td>

                                        {{-- ACTION --}}

                                        <td>

                                            <button type="button" class="btn btn-primary btn-sm btn-action"
                                                onclick="loadEleve({{ $eleve->id }})">

                                                <i class="bi bi-pencil-square me-1"></i>
                                                Saisir les notes

                                            </button>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3">

                                            <div class="notes-empty">

                                                <div class="notes-empty-icon">
                                                    <i class="bi bi-people"></i>
                                                </div>

                                                <h5 class="notes-empty-title">
                                                    Aucun élève enregistré
                                                </h5>

                                                <p class="notes-empty-text">
                                                    Les élèves apparaîtront ici lorsqu'ils seront ajoutés à l'établissement.
                                                </p>

                                            </div>

                                        </td>

                                    </tr>
                                @endforelse

                                {{-- AUCUN RÉSULTAT DE FILTRE --}}

                                <tr id="aucunResultatFiltre" style="display:none;">

                                    <td colspan="3">

                                        <div class="notes-empty py-5">

                                            <div class="notes-empty-icon">
                                                <i class="bi bi-search"></i>
                                            </div>

                                            <h5 class="notes-empty-title">
                                                Aucun résultat
                                            </h5>

                                            <p class="notes-empty-text">
                                                Aucun élève ne correspond aux filtres sélectionnés.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            {{-- =====================================================
                 ZONE FORMULAIRE ÉLÈVE (AJAX)
            ====================================================== --}}

            <div id="zone"></div>

        </div>

    </div>

    {{-- =========================================================
         POPUP ENREGISTREMENT
    ========================================================= --}}

    <div id="popup-save" class="popup-save">

        <div class="popup-box">

            <div class="popup-success-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <h5>
                Enregistrement réussi !
            </h5>

            <p id="popup-text"></p>

            <button type="button" onclick="closePopup()" class="btn-popup-ok">
                <i class="bi bi-check-circle me-1"></i>
                OK
            </button>

        </div>

    </div>

    <script>
        // =====================================================
        // FILTRAGE ET TRI DE LA LISTE DES ELEVES
        // =====================================================

        function appliquerFiltresEtTri() {

            const tbody = document.querySelector('#tableEleves tbody');

            if (!tbody) return;

            const rows = Array.from(tbody.querySelectorAll('tr.eleve-row'));

            const terme = (document.getElementById('searchEleve')?.value || '')
                .toLowerCase()
                .trim();

            const classeChoisie = document.getElementById('filterClasse')?.value || '';

            const ordre = document.getElementById('sortEleves')?.value || 'az';

            rows.sort((a, b) => {

                const nomA = a.dataset.nom || '';
                const nomB = b.dataset.nom || '';

                const classeA = a.dataset.classeTri || '';
                const classeB = b.dataset.classeTri || '';

                if (ordre === 'az') {
                    return nomA.localeCompare(nomB, 'fr', {
                        sensitivity: 'base'
                    });
                }

                if (ordre === 'za') {
                    return nomB.localeCompare(nomA, 'fr', {
                        sensitivity: 'base'
                    });
                }

                if (ordre === 'classe_az') {

                    if (classeA === classeB) {
                        return nomA.localeCompare(nomB, 'fr', {
                            sensitivity: 'base'
                        });
                    }

                    return classeA.localeCompare(classeB, 'fr', {
                        sensitivity: 'base'
                    });
                }

                return 0;
            });

            let visibles = 0;

            const emptyRow = document.getElementById('aucunResultatFiltre');

            rows.forEach(row => {

                tbody.appendChild(row);

                const nom = row.dataset.nom || '';
                const classe = row.dataset.classe || '';

                const matchNom = !terme || nom.includes(terme) || classe.includes(terme);

                const matchClasse = !classeChoisie || classe === classeChoisie;

                const afficher = matchNom && matchClasse;

                row.style.display = afficher ? '' : 'none';

                if (afficher) visibles++;
            });

            if (emptyRow) {
                emptyRow.style.display = visibles === 0 && rows.length > 0 ? '' : 'none';
            }

            const compteur = document.getElementById('compteurEleves');

            if (compteur) {
                compteur.textContent = visibles;
            }
        }

        document.getElementById('searchEleve')?.addEventListener('input', appliquerFiltresEtTri);

        document.getElementById('filterClasse')?.addEventListener('change', appliquerFiltresEtTri);

        document.getElementById('sortEleves')?.addEventListener('change', appliquerFiltresEtTri);

        document.getElementById('btnResetFiltres')?.addEventListener('click', function() {

            document.getElementById('searchEleve').value = '';

            document.getElementById('filterClasse').value = '';

            document.getElementById('sortEleves').value = 'az';

            appliquerFiltresEtTri();

        });

        // Appliquer le tri A -> Z au chargement

        appliquerFiltresEtTri();


        // =====================================================
        // CHARGER UN ELEVE
        // =====================================================

        function loadEleve(id) {

            document.getElementById('liste-eleves').style.display = 'none';

            const zone = document.getElementById('zone');

            zone.innerHTML = `
                <div class="card card-modern p-5 text-center">
                    <div class="py-4">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <div class="fw-bold" style="color:var(--np-text);">
                            Chargement des notes...
                        </div>
                        <div class="small mt-1" style="color:var(--np-muted);">
                            Veuillez patienter
                        </div>
                    </div>
                </div>
            `;

            fetch('/bulletin/eleve/' + id)

                .then(r => {
                    if (!r.ok) {
                        throw new Error('Erreur HTTP ' + r.status);
                    }
                    return r.text();
                })

                .then(html => {

                    zone.innerHTML = html;

                    // Le partial notes_form.blade.php vient d'être injecté.
                    // On initialise les événements APRES innerHTML.

                    initChargementNotes();

                    initNotes();

                    initSaveForms();

                    calculTable('note-journalier');

                    calculTable('note-composition');

                    // Amener la zone de formulaire dans la vue
                    zone.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                })

                .catch(error => {

                    console.error(error);

                    zone.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Erreur lors du chargement de l'élève.
                            <button type="button" class="btn btn-outline-danger btn-sm ms-3"
                                onclick="retourListe()">
                                Retour à la liste
                            </button>
                        </div>
                    `;

                });

        }


        // =====================================================
        // INITIALISER LE CHARGEMENT DES NOTES
        // =====================================================

        function initChargementNotes() {

            const zoneNotes = document.getElementById('notes-existantes');

            if (!zoneNotes) {

                console.log('Données des notes introuvables.');

                return;

            }

            let notes = {};

            try {

                notes = JSON.parse(zoneNotes.dataset.notes || '{}');

            } catch (error) {

                console.error('Erreur lecture des notes :', error);

                return;

            }


            // =================================================
            // PERIODE JOURNALIERE
            // =================================================

            const selectJournalier = document.querySelector('.periode-select-journalier');

            if (selectJournalier) {

                selectJournalier.addEventListener('change', function() {

                    const periodeId = this.value;

                    const hidden = document.querySelector('.periode-hidden-journalier');

                    if (hidden) {
                        hidden.value = periodeId;
                    }

                    chargerNotesParPeriode(notes, periodeId, 'journalier');

                });

            }


            // =================================================
            // PERIODE COMPOSITION
            // =================================================

            const selectComposition = document.querySelector('.periode-select-composition');

            if (selectComposition) {

                selectComposition.addEventListener('change', function() {

                    const periodeId = this.value;

                    const hidden = document.querySelector('.periode-hidden-composition');

                    if (hidden) {
                        hidden.value = periodeId;
                    }

                    chargerNotesParPeriode(notes, periodeId, 'composition');

                });

            }

        }


        // =====================================================
        // CHARGER NOTES D'UNE PERIODE
        // =====================================================

        function chargerNotesParPeriode(notes, periodeId, type) {

            const classeInput = type === 'journalier' ?
                '.note-journalier' :
                '.note-composition';

            const inputs = document.querySelectorAll(classeInput);


            // =================================================
            // AUCUNE PERIODE
            // =================================================

            if (!periodeId) {

                viderNotes(type);

                calculTable(
                    type === 'journalier' ?
                    'note-journalier' :
                    'note-composition'
                );

                return;

            }


            // =================================================
            // NOTES DE LA PERIODE
            // =================================================

            const notesPeriode = notes[periodeId];

            if (!notesPeriode) {

                viderNotes(type);

                calculTable(
                    type === 'journalier' ?
                    'note-journalier' :
                    'note-composition'
                );

                return;

            }


            // =================================================
            // NOTES DU TYPE
            // =================================================

            const notesType = notesPeriode[type];

            if (!notesType) {

                viderNotes(type);

                calculTable(
                    type === 'journalier' ?
                    'note-journalier' :
                    'note-composition'
                );

                return;

            }


            // =================================================
            // REMPLIR LES INPUTS
            // =================================================

            inputs.forEach(function(input) {

                const matiereId = input.dataset.matiere;

                const note = notesType[matiereId];

                const row = input.closest('tr');

                if (!row) {
                    return;
                }

                const coef = row.querySelector('.coef');

                const base = row.querySelector('input[name*="[base]"]');

                if (note) {

                    // NOTE
                    input.value = note.valeur ?? '';

                    // COEFFICIENT
                    if (coef) {
                        coef.value = note.coef ?? coef.value;
                    }

                    // BASE
                    if (base) {
                        base.value = note.base ?? 20;
                    }

                } else {

                    // Aucune note pour cette matière dans cette période.
                    input.value = '';

                    if (base) {
                        base.value = 20;
                    }

                }

            });


            // =================================================
            // RECALCUL IMMEDIAT
            // =================================================

            calculTable(
                type === 'journalier' ?
                'note-journalier' :
                'note-composition'
            );

        }


        // =====================================================
        // VIDER LES NOTES
        // =====================================================

        function viderNotes(type) {

            const classeInput = type === 'journalier' ?
                '.note-journalier' :
                '.note-composition';

            document.querySelectorAll(classeInput).forEach(function(input) {

                input.value = '';

                const row = input.closest('tr');

                if (!row) {
                    return;
                }

                const base = row.querySelector('input[name*="[base]"]');

                if (base) {
                    base.value = 20;
                }

            });

        }


        // =====================================================
        // POPUP
        // =====================================================

        function closePopup() {

            document.getElementById('popup-save').style.display = 'none';

        }


        function showPopup(txt) {

            document.getElementById('popup-text').innerHTML = txt;

            document.getElementById('popup-save').style.display = 'flex';

        }


        // =====================================================
        // APPRECIATION
        // =====================================================

        function appreciation(noteReelle) {

            if (noteReelle < 5)
                return {
                    texte: "Très insuffisant",
                    couleur: "#8B0000"
                };

            if (noteReelle >= 5 && noteReelle < 10)
                return {
                    texte: "Insuffisant",
                    couleur: "red"
                };

            if (noteReelle >= 10 && noteReelle < 12)
                return {
                    texte: "Passable",
                    couleur: "orange"
                };

            if (noteReelle >= 12 && noteReelle < 14)
                return {
                    texte: "Assez bien",
                    couleur: "#c59d00"
                };

            if (noteReelle >= 14 && noteReelle < 17)
                return {
                    texte: "Bien",
                    couleur: "green"
                };

            if (noteReelle >= 17 && noteReelle <= 20)
                return {
                    texte: "Très bien",
                    couleur: "#0066cc"
                };

            return {
                texte: "Erreur",
                couleur: "black"
            };

        }


        // =====================================================
        // CALCUL TABLE
        // =====================================================

        function calculTable(type) {

            let notes = document.querySelectorAll('.' + type);

            let total = 0;

            let totalCoef = 0;

            notes.forEach(input => {

                let row = input.closest('tr');

                let note = parseFloat(input.value) || 0;

                let coefInput = row.querySelector('.coef');

                let coef = coefInput ?
                    parseFloat(coefInput.value) || 0 :
                    0;

                total += note;

                totalCoef += coef;

                let noteReelle = 0;

                if (coef > 0) {
                    noteReelle = note / coef;
                }

                let appr = row.querySelector('.appr');

                if (appr) {

                    let a = appreciation(noteReelle);

                    appr.innerHTML = a.texte;

                    appr.style.color = a.couleur;

                }

            });

            let moyenne = 0;

            if (totalCoef > 0) {
                moyenne = total / totalCoef;
            }

            let suffixe = type === 'note-journalier' ?
                'journalier' :
                'composition';

            const totalElement = document.getElementById('total-' + suffixe);

            const coefElement = document.getElementById('coef-' + suffixe);

            const moyenneElement = document.getElementById('moyenne-' + suffixe);

            if (totalElement) {
                totalElement.innerHTML = total.toFixed(2);
            }

            if (coefElement) {
                coefElement.innerHTML = totalCoef.toFixed(2);
            }

            if (moyenneElement) {
                moyenneElement.innerHTML = moyenne.toFixed(2);
            }

        }


        // =====================================================
        // INITIALISER LES INPUTS
        // =====================================================

        function initNotes() {

            document.querySelectorAll('.note-journalier, .note-composition, .coef')
                .forEach(el => {

                    el.addEventListener('input', function() {

                        calculTable('note-journalier');

                        calculTable('note-composition');

                    });

                });

            calculTable('note-journalier');

            calculTable('note-composition');

        }


        // =====================================================
        // ENREGISTRER LES FORMULAIRES
        // =====================================================

        function initSaveForms() {

            let forms = document.querySelectorAll('#form-journalier, #form-composition');

            forms.forEach(form => {

                form.addEventListener('submit', function(e) {

                    e.preventDefault();

                    let select = form.querySelector('select');

                    let periode = form.querySelector('input[name="periode_id"]');

                    document.querySelectorAll('.erreur-periode').forEach(x => x.remove());

                    select.classList.remove('popup-erreur');


                    // =================================================
                    // VERIFICATION PERIODE
                    // =================================================

                    if (!select.value) {

                        select.classList.add('popup-erreur');

                        let div = document.createElement('div');

                        div.className = 'erreur-periode';

                        div.innerHTML = 'Veuillez choisir une période.';

                        select.after(div);

                        select.focus();

                        return;

                    }

                    periode.value = select.value;

                    let fd = new FormData(form);


                    // =================================================
                    // REQUETE AJAX
                    // =================================================

                    fetch(form.action, {
                            method: 'POST',
                            body: fd,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Accept': 'application/json'
                            }
                        })

                        .then(r => {

                            if (!r.ok) {
                                throw new Error('Erreur HTTP ' + r.status);
                            }

                            return r.json();

                        })

                        .then(data => {

                            if (!data.success) {
                                throw new Error(data.message || 'Erreur enregistrement');
                            }

                            let nom = form.dataset.nom;

                            let prenom = form.dataset.prenom;

                            showPopup(
                                'Les notes de <b>' +
                                nom +
                                ' ' +
                                prenom +
                                '</b> ont été enregistrées avec succès.'
                            );

                        })

                        .catch(err => {

                            console.error(err);

                            alert('Erreur lors de l’enregistrement des notes.');

                        });

                });

            });

        }


        // =====================================================
        // RETOUR LISTE
        // =====================================================

        function retourListe() {

            document.getElementById('liste-eleves').style.display = 'block';

            document.getElementById('zone').innerHTML = '';

            // Remonter au début de la liste
            document.getElementById('liste-eleves').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }
    </script>
@endsection
