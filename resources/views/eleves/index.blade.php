@extends('layouts.app')

@section('content')
    @php
        $nombreElevesAffiches = $eleves->count();
        $nombreClasses = $classes->count();

        $filtresActifs = collect([request('nom'), request('prenom'), request('classe_id'), request('numero_classe')])
            ->filter(fn($value) => $value !== null && $value !== '')
            ->count();
    @endphp

    <style>
        /* ==========================================================
       EDUMANAGE — GESTION DES ÉLÈVES ULTRA PRO
    ========================================================== */

        .students-page {
            --st-bg: #f3f6fb;
            --st-card: #ffffff;
            --st-soft: #f7f9fd;
            --st-border: #e5eaf2;
            --st-text: #34445d;
            --st-heading: #172a45;
            --st-muted: #8391a6;
            --st-primary: #3979df;
            --st-primary-soft: #edf4ff;
            --st-hover: #f5f8fd;
            --st-shadow: 0 4px 18px rgba(20, 40, 70, .045);

            padding: 24px;
            min-height: 100vh;
            background: var(--st-bg);
            color: var(--st-text);
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 13px;
            transition: background .25s ease, color .25s ease;
        }

        .students-page * {
            box-sizing: border-box;
        }

        /* ==========================================================
       HEADER
    ========================================================== */

        .students-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .students-heading h1 {
            color: var(--st-heading);
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.5px;
            margin: 0 0 6px;
        }

        .students-heading p {
            color: var(--st-muted);
            font-size: 12px;
            margin: 0;
        }

        .students-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .students-add-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            padding: 0 17px;
            border: none;
            border-radius: 10px;
            color: #fff !important;
            background: linear-gradient(135deg, #4386ed, #2866cb);
            box-shadow: 0 5px 13px rgba(51, 112, 214, .20);
            text-decoration: none;
            font-weight: 700;
            font-size: 12px;
            transition: .2s ease;
        }

        .students-add-btn:hover {
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 7px 18px rgba(51, 112, 214, .28);
        }

        /* ==========================================================
       STATISTIQUES
    ========================================================== */

        .students-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .students-stat-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--st-card);
            border: 1px solid var(--st-border);
            border-radius: 13px;
            padding: 17px;
            box-shadow: var(--st-shadow);
            min-width: 0;
            transition: .2s ease;
        }

        .students-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(20, 40, 70, .07);
        }

        .students-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: 12px;
            font-size: 20px;
        }

        .students-stat-blue {
            background: #eaf1ff;
            color: #3875d8;
        }

        .students-stat-purple {
            background: #f0eaff;
            color: #8357cb;
        }

        .students-stat-orange {
            background: #fff1e2;
            color: #d28a36;
        }

        .students-stat-label {
            font-size: 11px;
            color: var(--st-muted);
            margin-bottom: 4px;
        }

        .students-stat-value {
            color: var(--st-heading);
            font-size: 22px;
            font-weight: 800;
            line-height: 1.2;
        }

        /* ==========================================================
       ALERT
    ========================================================== */

        .students-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid #bde7ce;
            background: #effaf3;
            color: #24794b;
            font-size: 12px;
        }

        /* ==========================================================
       PANEL PRINCIPAL
    ========================================================== */

        .students-main-card {
            background: var(--st-card);
            border: 1px solid var(--st-border);
            border-radius: 15px;
            box-shadow: var(--st-shadow);
            overflow: hidden;
        }

        .students-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--st-border);
            background: var(--st-card);
            flex-wrap: wrap;
        }

        .students-card-title {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .students-title-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: var(--st-primary-soft);
            color: var(--st-primary);
            font-size: 17px;
        }

        .students-card-title h2 {
            color: var(--st-heading);
            font-size: 14px;
            font-weight: 750;
            margin: 0 0 3px;
        }

        .students-card-title p {
            color: var(--st-muted);
            font-size: 10px;
            margin: 0;
        }

        .students-result-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 8px;
            background: var(--st-primary-soft);
            color: var(--st-primary);
            font-size: 10px;
            font-weight: 700;
        }

        /* ==========================================================
       FILTRES
    ========================================================== */

        .students-filter-area {
            padding: 18px 20px;
            border-bottom: 1px solid var(--st-border);
            background: var(--st-soft);
        }

        .students-filter-heading {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--st-heading);
            font-size: 11px;
            font-weight: 750;
            margin-bottom: 13px;
        }

        .students-filter-heading i {
            color: var(--st-primary);
            font-size: 14px;
        }

        .students-filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1.2fr .8fr 1.1fr auto auto;
            align-items: end;
            gap: 10px;
        }

        .students-filter-field {
            min-width: 0;
        }

        .students-filter-field label {
            display: block;
            color: var(--st-muted);
            font-size: 10px;
            font-weight: 650;
            margin-bottom: 6px;
        }

        .students-filter-field .form-control,
        .students-filter-field .form-select {
            height: 38px;
            min-height: 38px;
            border-radius: 8px;
            border: 1px solid var(--st-border);
            background: var(--st-card);
            color: var(--st-text);
            font-size: 11px;
            padding: 7px 10px;
            box-shadow: none !important;
        }

        .students-filter-field .form-control::placeholder {
            color: var(--st-muted);
            opacity: .8;
        }

        .students-filter-field .form-control:focus,
        .students-filter-field .form-select:focus {
            border-color: #80aaf0;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .10) !important;
        }

        .students-filter-actions {
            display: flex;
            gap: 7px;
        }

        .students-filter-btn {
            height: 38px;
            border: none;
            border-radius: 8px;
            padding: 0 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: #fff;
            background: #3476dc;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            transition: .2s;
        }

        .students-filter-btn:hover {
            background: #2863bf;
        }

        .students-reset-btn {
            height: 38px;
            width: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--st-border);
            border-radius: 8px;
            background: var(--st-card);
            color: var(--st-muted);
            text-decoration: none;
            transition: .2s;
        }

        .students-reset-btn:hover {
            color: var(--st-primary);
            background: var(--st-primary-soft);
            border-color: #bcd1f3;
        }

        /* ==========================================================
       TABLEAU
    ========================================================== */

        .students-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .students-table {
            width: 100%;
            min-width: 950px;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .students-table thead th {
            background: var(--st-soft);
            color: var(--st-muted);
            padding: 13px 14px;
            font-size: 10px;
            font-weight: 750;
            text-transform: uppercase;
            letter-spacing: .45px;
            white-space: nowrap;
            border-bottom: 1px solid var(--st-border);
        }

        .students-table tbody td {
            background: var(--st-card);
            color: var(--st-text);
            padding: 12px 14px;
            font-size: 11px;
            vertical-align: middle;
            border-bottom: 1px solid var(--st-border);
            transition: background .15s;
        }

        .students-table tbody tr:hover td {
            background: var(--st-hover);
        }

        .students-table tbody tr:last-child td {
            border-bottom: none;
        }

        .student-photo-cell {
            width: 65px;
        }

        .student-photo {
            width: 39px;
            height: 39px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            border: 2px solid var(--st-border);
            background: var(--st-soft);
        }

        .student-name {
            color: var(--st-heading);
            font-weight: 750;
            font-size: 11px;
        }

        .student-firstname {
            color: var(--st-text);
            font-size: 11px;
        }

        .student-gender {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--st-muted-2, var(--st-muted));
        }

        .student-gender i {
            color: var(--st-muted);
        }

        .student-class-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 9px;
            border-radius: 6px;
            background: #eaf1ff;
            color: #3976d5;
            font-weight: 700;
            font-size: 10px;
            white-space: nowrap;
        }

        .student-number-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 8px;
            background: var(--st-soft);
            color: var(--st-text);
            border: 1px solid var(--st-border);
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
        }

        .student-matricule {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 6px;
            background: var(--st-soft);
            color: var(--st-muted-2, var(--st-muted));
            font-size: 10px;
            font-family: Consolas, monospace;
            white-space: nowrap;
        }

        /* ==========================================================
       ACTIONS
    ========================================================== */

        .students-actions {
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .student-action-btn {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid transparent;
            font-size: 12px;
            text-decoration: none !important;
            cursor: pointer;
            transition: .18s ease;
        }

        .student-action-view {
            background: #e8f2ff;
            color: #3978d6;
            border-color: #d7e7ff;
        }

        .student-action-view:hover {
            background: #d5e7ff;
            color: #245eb5;
        }

        .student-action-edit {
            background: #fff2df;
            color: #c88527;
            border-color: #ffebcf;
        }

        .student-action-edit:hover {
            background: #ffe5bd;
            color: #a96812;
        }

        .student-action-delete {
            background: #ffebed;
            color: #d55461;
            border-color: #ffdade;
        }

        .student-action-delete:hover {
            background: #ffd8dc;
            color: #bb3443;
        }

        /* ==========================================================
       EMPTY STATE
    ========================================================== */

        .students-empty {
            text-align: center;
            padding: 55px 20px !important;
            background: var(--st-card) !important;
        }

        .students-empty-icon {
            width: 62px;
            height: 62px;
            border-radius: 18px;
            margin: 0 auto 13px;
            background: var(--st-soft);
            color: var(--st-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .students-empty h3 {
            color: var(--st-heading);
            font-size: 14px;
            font-weight: 750;
            margin-bottom: 6px;
        }

        .students-empty p {
            color: var(--st-muted);
            font-size: 11px;
            margin: 0;
        }

        /* ==========================================================
       FOOTER
    ========================================================== */

        .students-table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 20px;
            border-top: 1px solid var(--st-border);
            background: var(--st-card);
            flex-wrap: wrap;
        }

        .students-footer-text {
            color: var(--st-muted);
            font-size: 10px;
        }

        .students-footer-text strong {
            color: var(--st-heading);
        }

        .students-footer-pagination {
            margin: 0;
        }

        /* ==========================================================
       PAGINATION LARAVEL
    ========================================================== */

        .students-table-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .students-table-footer .page-link {
            min-width: 30px;
            height: 30px;
            padding: 5px 9px;
            border: 1px solid var(--st-border);
            border-radius: 7px !important;
            background: var(--st-card);
            color: var(--st-text);
            font-size: 10px;
            box-shadow: none;
        }

        .students-table-footer .page-item.active .page-link {
            background: #3476dc;
            border-color: #3476dc;
            color: #fff;
        }

        .students-table-footer .page-item.disabled .page-link {
            opacity: .45;
        }

        .students-table-footer .page-link:hover {
            background: var(--st-primary-soft);
            color: var(--st-primary);
        }

        /* ==========================================================
       DARK MODE — THEME EDUMANAGE
    ========================================================== */

        html[data-app-theme="dark"] .students-page {
            --st-bg: #1b2637;
            --st-card: #253246;
            --st-soft: #202d40;
            --st-border: #36465d;
            --st-text: #d5dfed;
            --st-heading: #edf3fc;
            --st-muted: #8fa2bc;
            --st-muted-2: #b1bfd2;
            --st-primary: #85b3ff;
            --st-primary-soft: #293f5d;
            --st-hover: #2d3c51;
            --st-shadow: 0 4px 18px rgba(0, 0, 0, .12);
        }

        html[data-app-theme="dark"] .students-page .students-stat-blue {
            background: #293f61;
            color: #8cb9ff;
        }

        html[data-app-theme="dark"] .students-page .students-stat-purple {
            background: #3b315a;
            color: #c3a3ff;
        }

        html[data-app-theme="dark"] .students-page .students-stat-orange {
            background: #51402e;
            color: #ffc27e;
        }

        html[data-app-theme="dark"] .students-page .students-title-icon {
            background: #293f5d;
            color: #8cb9ff;
        }

        html[data-app-theme="dark"] .students-page .student-class-badge {
            background: #293f61;
            color: #8cb9ff;
        }

        html[data-app-theme="dark"] .students-page .student-action-view {
            background: #293f61;
            color: #8cb9ff;
            border-color: #344d70;
        }

        html[data-app-theme="dark"] .students-page .student-action-view:hover {
            background: #344d70;
        }

        html[data-app-theme="dark"] .students-page .student-action-edit {
            background: #51402e;
            color: #ffc27e;
            border-color: #625039;
        }

        html[data-app-theme="dark"] .students-page .student-action-edit:hover {
            background: #665037;
        }

        html[data-app-theme="dark"] .students-page .student-action-delete {
            background: #52343e;
            color: #ff9eae;
            border-color: #65414c;
        }

        html[data-app-theme="dark"] .students-page .student-action-delete:hover {
            background: #68404d;
        }

        html[data-app-theme="dark"] .students-page .students-alert {
            background: #203e35;
            color: #8ce0b4;
            border-color: #315c4b;
        }

        html[data-app-theme="dark"] .students-page .students-filter-btn {
            background: #356fc9;
            color: #fff;
        }

        html[data-app-theme="dark"] .students-page .students-reset-btn:hover {
            background: #293f5d;
            color: #8cb9ff;
            border-color: #3c5576;
        }

        html[data-app-theme="dark"] .students-page .students-result-badge {
            background: #293f5d;
            color: #8cb9ff;
        }

        html[data-app-theme="dark"] .students-page .students-filter-field .form-control,
        html[data-app-theme="dark"] .students-page .students-filter-field .form-select {
            background-color: #202d40;
            border-color: #36465d;
            color: #d5dfed;
        }

        html[data-app-theme="dark"] .students-page .students-filter-field .form-control::placeholder {
            color: #8294ae;
        }

        html[data-app-theme="dark"] .students-page .students-filter-field .form-select option {
            background: #253246;
            color: #d5dfed;
        }

        html[data-app-theme="dark"] .students-page .students-table thead th {
            background: #202d40;
            color: #94a6bf;
            border-color: #36465d;
        }

        html[data-app-theme="dark"] .students-page .students-table tbody td {
            background: #253246;
            color: #d5dfed;
            border-color: #36465d;
        }

        html[data-app-theme="dark"] .students-page .students-table tbody tr:hover td {
            background: #2d3c51;
        }

        html[data-app-theme="dark"] .students-page .student-name {
            color: #edf3fc;
        }

        html[data-app-theme="dark"] .students-page .student-firstname {
            color: #c2cede;
        }

        html[data-app-theme="dark"] .students-page .student-number-badge,
        html[data-app-theme="dark"] .students-page .student-matricule {
            background: #202d40;
            border-color: #36465d;
            color: #b1bfd2;
        }

        html[data-app-theme="dark"] .students-page .student-photo {
            border-color: #36465d;
        }

        html[data-app-theme="dark"] .students-page .students-empty {
            background: #253246 !important;
        }

        html[data-app-theme="dark"] .students-page .students-empty-icon {
            background: #202d40;
            color: #94a6bf;
        }

        html[data-app-theme="dark"] .students-page .students-empty h3 {
            color: #edf3fc;
        }

        html[data-app-theme="dark"] .students-page .students-empty p {
            color: #94a6bf;
        }

        html[data-app-theme="dark"] .students-page .students-table-footer {
            background: #253246;
            border-color: #36465d;
        }

        html[data-app-theme="dark"] .students-page .students-footer-text {
            color: #94a6bf;
        }

        html[data-app-theme="dark"] .students-page .students-footer-text strong {
            color: #edf3fc;
        }

        html[data-app-theme="dark"] .students-page .page-link {
            background: #202d40;
            border-color: #36465d;
            color: #d5dfed;
        }

        html[data-app-theme="dark"] .students-page .page-item.active .page-link {
            background: #356fc9;
            border-color: #356fc9;
            color: #fff;
        }

        html[data-app-theme="dark"] .students-page .page-link:hover {
            background: #293f5d;
            color: #8cb9ff;
        }

        /* ==========================================================
       RESPONSIVE
    ========================================================== */

        @media (max-width: 1250px) {
            .students-filter-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .students-filter-actions {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .students-page {
                padding: 15px;
            }

            .students-heading h1 {
                font-size: 21px;
            }

            .students-stats {
                grid-template-columns: 1fr;
                gap: 9px;
            }

            .students-stat-card {
                padding: 13px;
            }

            .students-filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .students-filter-actions {
                grid-column: span 2;
            }

            .students-filter-btn {
                flex: 1;
            }

            .students-card-header,
            .students-filter-area {
                padding: 14px;
            }

            .students-table-footer {
                padding: 12px 14px;
            }
        }

        @media (max-width: 480px) {
            .students-page {
                padding: 10px;
            }

            .students-header {
                align-items: flex-start;
            }

            .students-add-btn {
                padding: 0 12px;
            }

            .students-filter-grid {
                grid-template-columns: 1fr;
            }

            .students-filter-actions {
                grid-column: auto;
            }

            .students-card-header {
                align-items: flex-start;
            }
        }

        @media print {
            .students-page {
                background: #fff !important;
                color: #000 !important;
            }

            .students-header-actions,
            .students-filter-area,
            .students-actions {
                display: none !important;
            }

            .students-main-card {
                box-shadow: none;
            }
        }
    </style>

    <div class="students-page">

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
        <div class="students-header">

            <div class="students-heading">
                <h1>
                    <i class="bi bi-mortarboard me-2" style="color:#4784e7;"></i>
                    Gestion des élèves
                </h1>

                <p>
                    Consultez, recherchez et gérez l'ensemble des dossiers scolaires.
                </p>
            </div>

            <div class="students-header-actions">

                @if (auth()->user()->aPermission('eleves.creer'))
                    <a href="{{ route('eleves.create') }}" class="students-add-btn">
                        <i class="bi bi-plus-lg"></i>
                        Nouvel élève
                    </a>
                @endif

            </div>
        </div>

        {{-- =====================================================
         STATISTIQUES
    ====================================================== --}}
        <div class="students-stats">

            <div class="students-stat-card">
                <div class="students-stat-icon students-stat-blue">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div>
                    <div class="students-stat-label">Élèves affichés</div>
                    <div class="students-stat-value">
                        {{ number_format($nombreElevesAffiches, 0, ',', ' ') }}
                    </div>
                </div>
            </div>

            <div class="students-stat-card">
                <div class="students-stat-icon students-stat-purple">
                    <i class="bi bi-building"></i>
                </div>

                <div>
                    <div class="students-stat-label">Classes disponibles</div>
                    <div class="students-stat-value">
                        {{ number_format($nombreClasses, 0, ',', ' ') }}
                    </div>
                </div>
            </div>

            <div class="students-stat-card">
                <div class="students-stat-icon students-stat-orange">
                    <i class="bi bi-funnel"></i>
                </div>

                <div>
                    <div class="students-stat-label">Filtres appliqués</div>
                    <div class="students-stat-value">
                        {{ $filtresActifs }}
                    </div>
                </div>
            </div>

        </div>

        {{-- =====================================================
         MESSAGE DE SUCCÈS
    ====================================================== --}}
        @if (session('success'))
            <div class="students-alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- =====================================================
         CONTENU PRINCIPAL
    ====================================================== --}}
        <div class="students-main-card">

            {{-- Header du tableau --}}
            <div class="students-card-header">

                <div class="students-card-title">
                    <div class="students-title-icon">
                        <i class="bi bi-list-ul"></i>
                    </div>

                    <div>
                        <h2>Liste des élèves</h2>
                        <p>Répertoire des élèves inscrits dans l'établissement</p>
                    </div>
                </div>

                <div class="students-result-badge">
                    <i class="bi bi-person-lines-fill"></i>
                    {{ $nombreElevesAffiches }} résultat(s)
                </div>

            </div>

            {{-- =================================================
             FILTRES
        ================================================== --}}
            <div class="students-filter-area">

                <div class="students-filter-heading">
                    <i class="bi bi-sliders"></i>
                    Recherche et filtres
                </div>

                <form method="GET" action="{{ route('eleves.index') }}">

                    <div class="students-filter-grid">

                        {{-- NOM --}}
                        <div class="students-filter-field">
                            <label for="filter-nom">Nom</label>
                            <input type="text" id="filter-nom" name="nom" value="{{ request('nom') }}"
                                class="form-control" placeholder="Rechercher un nom">
                        </div>

                        {{-- PRENOM --}}
                        <div class="students-filter-field">
                            <label for="filter-prenom">Prénom</label>
                            <input type="text" id="filter-prenom" name="prenom" value="{{ request('prenom') }}"
                                class="form-control" placeholder="Rechercher un prénom">
                        </div>

                        {{-- CLASSE --}}
                        <div class="students-filter-field">
                            <label for="filter-classe">Classe</label>
                            <select id="filter-classe" name="classe_id" class="form-select">
                                <option value="">Toutes les classes</option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}"
                                        {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- NUMERO --}}
                        <div class="students-filter-field">
                            <label for="filter-numero">N° de classe</label>
                            <input type="number" id="filter-numero" name="numero_classe"
                                value="{{ request('numero_classe') }}" class="form-control" placeholder="Ex : 12"
                                min="1">
                        </div>

                        {{-- TRI --}}
                        <div class="students-filter-field">
                            <label for="filter-sort">Ordre de tri</label>
                            <select id="filter-sort" name="sort" class="form-select">
                                <option value="nom_asc" {{ request('sort', 'nom_asc') == 'nom_asc' ? 'selected' : '' }}>
                                    Nom A → Z
                                </option>

                                <option value="nom_desc" {{ request('sort') == 'nom_desc' ? 'selected' : '' }}>
                                    Nom Z → A
                                </option>

                                <option value="prenom_asc" {{ request('sort') == 'prenom_asc' ? 'selected' : '' }}>
                                    Prénom A → Z
                                </option>

                                <option value="prenom_desc" {{ request('sort') == 'prenom_desc' ? 'selected' : '' }}>
                                    Prénom Z → A
                                </option>

                                <option value="numero_asc" {{ request('sort') == 'numero_asc' ? 'selected' : '' }}>
                                    Numéro croissant
                                </option>

                                <option value="numero_desc" {{ request('sort') == 'numero_desc' ? 'selected' : '' }}>
                                    Numéro décroissant
                                </option>
                            </select>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="students-filter-actions">

                            <button type="submit" class="students-filter-btn">
                                <i class="bi bi-search"></i>
                                Filtrer
                            </button>

                            <a href="{{ route('eleves.index') }}" class="students-reset-btn"
                                title="Réinitialiser les filtres" aria-label="Réinitialiser">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>

                        </div>

                    </div>
                </form>
            </div>

            {{-- =================================================
             TABLEAU DES ÉLÈVES
        ================================================== --}}
            <div class="students-table-wrap">

                <table class="students-table">

                    <thead>
                        <tr>
                            <th class="student-photo-cell">Photo</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Sexe</th>
                            <th>N°</th>
                            <th>Matricule</th>
                            <th style="width:125px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($eleves as $eleve)
                            <tr>

                                {{-- PHOTO --}}
                                <td class="student-photo-cell">
                                    @if ($eleve->photo)
                                        <img src="{{ asset('storage/' . $eleve->photo) }}" class="student-photo"
                                            alt="Photo de {{ $eleve->nom }} {{ $eleve->prenom }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($eleve->nom . ' ' . $eleve->prenom) }}&background=3979D8&color=fff&size=128"
                                            class="student-photo"
                                            alt="Avatar de {{ $eleve->nom }} {{ $eleve->prenom }}">
                                    @endif
                                </td>

                                {{-- NOM --}}
                                <td>
                                    <span class="student-name">
                                        {{ $eleve->nom }}
                                    </span>
                                </td>

                                {{-- PRENOM --}}
                                <td>
                                    <span class="student-firstname">
                                        {{ $eleve->prenom }}
                                    </span>
                                </td>

                                {{-- CLASSE --}}
                                <td>
                                    <span class="student-class-badge">
                                        {{ $eleve->classe->nom ?? 'Non assignée' }}
                                    </span>
                                </td>

                                {{-- SEXE --}}
                                <td>
                                    <span class="student-gender">
                                        @if (strtolower($eleve->sexe) == 'masculin')
                                            <i class="bi bi-gender-male"></i>
                                        @elseif (strtolower($eleve->sexe) == 'féminin' || strtolower($eleve->sexe) == 'feminin')
                                            <i class="bi bi-gender-female"></i>
                                        @else
                                            <i class="bi bi-person"></i>
                                        @endif

                                        {{ $eleve->sexe ?? '-' }}
                                    </span>
                                </td>

                                {{-- NUMERO --}}
                                <td>
                                    <span class="student-number-badge">
                                        {{ $eleve->numero_classe ? 'N° ' . $eleve->numero_classe : '-' }}
                                    </span>
                                </td>

                                {{-- MATRICULE --}}
                                <td>
                                    <span class="student-matricule">
                                        {{ $eleve->matricule ?? '-' }}
                                    </span>
                                </td>

                                {{-- ACTIONS --}}
                                <td>
                                    <div class="students-actions">

                                        {{-- VOIR --}}
                                        <a href="{{ route('eleves.show', $eleve) }}"
                                            class="student-action-btn student-action-view" title="Voir la fiche">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- MODIFIER --}}
                                        @if (auth()->user()->aPermission('eleves.modifier'))
                                            <a href="{{ route('eleves.edit', $eleve) }}"
                                                class="student-action-btn student-action-edit" title="Modifier l'élève">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endif

                                        {{-- SUPPRIMER --}}
                                        @if (auth()->user()->aPermission('eleves.supprimer'))
                                            <form action="{{ route('eleves.destroy', $eleve) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ? Cette action est irréversible.')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="student-action-btn student-action-delete"
                                                    title="Supprimer l'élève">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty

                            {{-- AUCUN RESULTAT --}}
                            <tr>
                                <td colspan="8" class="students-empty">

                                    <div class="students-empty-icon">
                                        <i class="bi bi-person-x"></i>
                                    </div>

                                    <h3>Aucun élève trouvé</h3>

                                    <p>
                                        Aucun élève ne correspond à votre recherche.
                                        Modifiez vos filtres ou réinitialisez-les.
                                    </p>

                                    @if ($filtresActifs > 0)
                                        <a href="{{ route('eleves.index') }}" class="students-add-btn mt-3">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            Réinitialiser les filtres
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- =================================================
             PIED DU TABLEAU / PAGINATION
        ================================================== --}}
            <div class="students-table-footer">

                <div class="students-footer-text">
                    <i class="bi bi-info-circle me-1"></i>

                    Élèves affichés :
                    <strong>{{ $nombreElevesAffiches }}</strong>

                    @if ($filtresActifs > 0)
                        <span class="ms-1">
                            · {{ $filtresActifs }} filtre(s) actif(s)
                        </span>
                    @endif
                </div>

                @if (method_exists($eleves, 'links'))
                    <div class="students-footer-pagination">
                        {{ $eleves->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="text-center mt-4" style="color:var(--st-muted);font-size:10px;">
            <i class="bi bi-mortarboard me-1"></i>
            EduManage · Gestion des dossiers scolaires
        </div>

    </div>
@endsection
