@extends('layouts.app')

@section('content')
    @php
        $totalClasses = $classes->count();
        $classesConfigurees = 0;

        foreach ($classes as $classe) {
            if (
                isset($coefficients[$classe->id]) &&
                $coefficients[$classe->id] !== '' &&
                $coefficients[$classe->id] !== null
            ) {
                $classesConfigurees++;
            }
        }

        $pourcentage = $totalClasses > 0 ? round(($classesConfigurees / $totalClasses) * 100) : 0;
    @endphp

    <style>
        /* =====================================================
               COEFFICIENTS - CONFIGURATION
            ===================================================== */

        .coef-edit-page {
            --coef-bg: #f4f7fc;
            --coef-surface: #ffffff;
            --coef-surface-soft: #f5f7fb;
            --coef-text: #263445;
            --coef-heading: #263b58;
            --coef-muted: #8491a2;
            --coef-border: #e5eaf1;
            --coef-hover: #f2f6fd;
            --coef-input: #ffffff;
            --coef-accent: #2878bd;
            --coef-accent-soft: #edf3ff;
            --coef-shadow: 0 6px 22px rgba(25, 42, 70, .055);

            padding: 22px;
            color: var(--coef-text);
            min-height: 100vh;
            background: var(--coef-bg);
            transition: background .25s ease, color .25s ease;
        }

        .coef-edit-page,
        .coef-edit-page * {
            box-sizing: border-box;
        }

        /* =====================================================
               HERO
            ===================================================== */

        .coef-hero {
            position: relative;
            overflow: hidden;
            padding: 30px 32px;
            border-radius: 19px;
            color: #ffffff;
            background: linear-gradient(120deg, #263b70, #287e9b);
            box-shadow: 0 10px 28px rgba(31, 59, 105, .18);
            margin-bottom: 23px;
        }

        .coef-hero::before,
        .coef-hero::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .coef-hero::before {
            width: 260px;
            height: 260px;
            right: -65px;
            top: -125px;
            background: rgba(255, 255, 255, .08);
        }

        .coef-hero::after {
            width: 150px;
            height: 150px;
            right: 115px;
            bottom: -110px;
            background: rgba(255, 255, 255, .06);
        }

        .coef-hero-content {
            position: relative;
            z-index: 1;
        }

        .coef-subtitle {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 7px 13px;
            border-radius: 30px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .13);
            font-size: 11px;
            font-weight: 750;
            letter-spacing: .8px;
            margin-bottom: 15px;
        }

        .coef-hero h3 {
            font-weight: 850;
            font-size: 27px;
            margin: 0 0 9px;
            letter-spacing: -.5px;
        }

        .coef-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .82);
            font-size: 14px;
        }

        /* =====================================================
               STATISTIQUES
            ===================================================== */

        .coef-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 23px;
        }

        .coef-stat {
            min-width: 0;
            background: var(--coef-surface);
            border: 1px solid var(--coef-border);
            border-radius: 15px;
            padding: 19px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: var(--coef-shadow);
            transition: transform .2s ease, border-color .2s ease;
        }

        .coef-stat:hover {
            transform: translateY(-3px);
        }

        .coef-stat-icon {
            width: 47px;
            height: 47px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            font-size: 20px;
            background: var(--coef-accent-soft);
            color: var(--coef-accent);
            flex-shrink: 0;
        }

        .coef-stat-icon.success {
            background: rgba(34, 170, 105, .12);
            color: #22a56b;
        }

        .coef-stat-icon.warning {
            background: rgba(225, 145, 49, .13);
            color: #d88732;
        }

        .coef-stat strong {
            display: block;
            font-size: 24px;
            font-weight: 850;
            line-height: 1.2;
            color: var(--coef-heading);
        }

        .coef-stat small {
            display: block;
            color: var(--coef-muted);
            font-size: 12px;
            margin-top: 4px;
        }

        /* =====================================================
               CARTE PRINCIPALE
            ===================================================== */

        .coef-card {
            background: var(--coef-surface);
            border: 1px solid var(--coef-border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--coef-shadow);
        }

        .coef-card-header {
            padding: 21px 24px;
            border-bottom: 1px solid var(--coef-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 17px;
        }

        .coef-card-header h5 {
            margin: 0 0 6px;
            font-weight: 850;
            font-size: 16px;
            color: var(--coef-heading);
        }

        .coef-card-header h5 i {
            color: var(--coef-accent);
        }

        .coef-card-header p {
            margin: 0;
            font-size: 13px;
            color: var(--coef-muted);
        }

        /* =====================================================
               OUTILS
            ===================================================== */

        .coef-tools {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .coef-search {
            position: relative;
            min-width: 235px;
        }

        .coef-search input {
            width: 100%;
            height: 41px;
            padding: 9px 13px 9px 39px;
            border: 1px solid var(--coef-border);
            border-radius: 10px;
            outline: none;
            font-size: 13px;
            color: var(--coef-text);
            background: var(--coef-input);
            transition: .2s ease;
        }

        .coef-search input::placeholder {
            color: var(--coef-muted);
        }

        .coef-search input:focus {
            border-color: var(--coef-accent);
            box-shadow: 0 0 0 3px rgba(67, 131, 215, .12);
        }

        .coef-search i {
            position: absolute;
            left: 14px;
            top: 13px;
            color: var(--coef-muted);
            font-size: 14px;
            pointer-events: none;
        }

        .coef-page-size {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--coef-muted);
            white-space: nowrap;
        }

        .coef-page-size select {
            width: 85px;
            height: 39px;
            border-radius: 9px;
            border: 1px solid var(--coef-border);
            background-color: var(--coef-input);
            color: var(--coef-text);
            font-size: 13px;
        }

        /* =====================================================
               TABLEAU
            ===================================================== */

        .coef-table-wrapper {
            max-height: 490px;
            overflow-y: auto;
            overflow-x: auto;
        }

        .coef-table {
            width: 100%;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
            color: var(--coef-text);
        }

        .coef-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--coef-surface-soft);
            color: var(--coef-muted);
            padding: 15px 23px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .7px;
            font-weight: 800;
            border-bottom: 1px solid var(--coef-border);
        }

        .coef-table tbody td {
            padding: 13px 23px;
            vertical-align: middle;
            border-bottom: 1px solid var(--coef-border);
            color: var(--coef-text);
            font-size: 13px;
        }

        .coef-table tbody tr {
            transition: background .18s ease;
        }

        .coef-table tbody tr:hover {
            background: var(--coef-hover);
        }

        .coef-table tbody tr:last-child td {
            border-bottom: none;
        }

        .coef-class {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: var(--coef-heading);
        }

        .coef-class-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--coef-accent-soft);
            color: var(--coef-accent);
            border-radius: 10px;
            flex-shrink: 0;
            font-size: 15px;
        }

        /* =====================================================
               CHAMP COEFFICIENT
            ===================================================== */

        .coef-input-wrap {
            max-width: 185px;
            position: relative;
        }

        .coef-input-wrap input {
            height: 43px;
            border: 1px solid var(--coef-border);
            border-radius: 10px;
            font-weight: 750;
            color: var(--coef-heading);
            background: var(--coef-input);
            padding-right: 53px;
            font-size: 14px;
            transition: .2s ease;
        }

        .coef-input-wrap input::placeholder {
            color: var(--coef-muted);
            font-weight: 400;
        }

        .coef-input-wrap input:focus {
            border-color: var(--coef-accent);
            box-shadow: 0 0 0 3px rgba(67, 131, 215, .12);
            background: var(--coef-input);
            color: var(--coef-heading);
        }

        .coef-input-suffix {
            position: absolute;
            right: 13px;
            top: 13px;
            color: var(--coef-muted);
            font-size: 11px;
            font-weight: 700;
            pointer-events: none;
        }

        /* =====================================================
               ÉTATS VIDES
            ===================================================== */

        .coef-empty {
            display: none;
            padding: 45px 20px;
            text-align: center;
            color: var(--coef-muted);
        }

        .coef-empty i {
            color: var(--coef-accent);
            font-size: 30px;
            margin-bottom: 12px;
        }

        .coef-empty strong {
            display: block;
            color: var(--coef-heading);
            font-size: 14px;
            margin-bottom: 5px;
        }

        .coef-empty p {
            margin: 0;
            font-size: 12px;
        }

        .coef-no-classes {
            text-align: center;
            padding: 45px 20px !important;
            color: var(--coef-muted) !important;
        }

        .coef-no-classes i {
            display: block;
            font-size: 30px;
            color: var(--coef-accent);
            margin-bottom: 12px;
        }

        /* =====================================================
               PAGINATION
            ===================================================== */

        .coef-pagination-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 15px 23px;
            border-top: 1px solid var(--coef-border);
            font-size: 12px;
            color: var(--coef-muted);
        }

        .coef-pagination {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            align-items: center;
        }

        .coef-pagination button {
            min-width: 35px;
            height: 35px;
            border: 1px solid var(--coef-border);
            background: var(--coef-surface);
            color: var(--coef-text);
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 650;
            cursor: pointer;
            transition: .18s ease;
        }

        .coef-pagination button:hover:not(:disabled) {
            border-color: var(--coef-accent);
            color: var(--coef-accent);
        }

        .coef-pagination button.active {
            background: var(--coef-accent);
            color: #ffffff;
            border-color: var(--coef-accent);
        }

        .coef-pagination button:disabled {
            opacity: .35;
            cursor: not-allowed;
        }

        .coef-pagination .coef-dots {
            padding: 0 5px;
            color: var(--coef-muted);
        }

        /* =====================================================
               FOOTER ET PROGRESSION
            ===================================================== */

        .coef-card-footer {
            padding: 19px 24px;
            border-top: 1px solid var(--coef-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
        }

        .coef-progress-label {
            color: var(--coef-heading);
            font-size: 12px;
            font-weight: 800;
        }

        .coef-progress {
            width: 210px;
            max-width: 100%;
            height: 8px;
            background: var(--coef-surface-soft);
            border-radius: 20px;
            overflow: hidden;
            margin-top: 9px;
            border: 1px solid var(--coef-border);
        }

        .coef-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #2878bd, #24a69a);
            border-radius: 20px;
            transition: width .3s ease;
        }

        .coef-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .coef-actions .btn {
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .coef-actions .btn:hover {
            transform: translateY(-2px);
        }

        .coef-btn-back {
            color: var(--coef-text) !important;
            background: var(--coef-surface) !important;
            border: 1px solid var(--coef-border) !important;
        }

        .coef-btn-save {
            background: linear-gradient(120deg, #16865c, #21a875) !important;
            border: none !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(25, 150, 95, .18);
        }

        /* =====================================================
               THÈME SOMBRE
            ===================================================== */

        html[data-app-theme="dark"] .coef-edit-page {
            --coef-bg: #111827;
            --coef-surface: #1c2637;
            --coef-surface-soft: #263449;
            --coef-text: #dce5f1;
            --coef-heading: #f1f5fb;
            --coef-muted: #a0aec0;
            --coef-border: #344256;
            --coef-hover: #26364b;
            --coef-input: #172235;
            --coef-accent: #75adff;
            --coef-accent-soft: rgba(76, 139, 231, .16);
            --coef-shadow: 0 7px 24px rgba(0, 0, 0, .17);
        }

        html[data-app-theme="dark"] .coef-hero {
            background: linear-gradient(120deg, #172b50, #15566d);
        }

        html[data-app-theme="dark"] .coef-stat-icon.success {
            background: rgba(34, 170, 105, .15);
        }

        html[data-app-theme="dark"] .coef-stat-icon.warning {
            background: rgba(225, 145, 49, .15);
        }

        html[data-app-theme="dark"] .coef-pagination button.active {
            color: #ffffff;
        }

        /* =====================================================
               THÈME ULTRA PRO
            ===================================================== */

        html[data-app-theme="ultra-pro"] .coef-edit-page {
            --coef-bg: #eef2f8;
            --coef-surface: #ffffff;
            --coef-surface-soft: #f0f4fa;
            --coef-text: #24344c;
            --coef-heading: #172c4b;
            --coef-muted: #78879b;
            --coef-border: #dce4ef;
            --coef-hover: #edf3fc;
            --coef-input: #ffffff;
            --coef-accent: #315fba;
            --coef-accent-soft: #e8efff;
            --coef-shadow: 0 8px 28px rgba(27, 48, 83, .07);
        }

        html[data-app-theme="ultra-pro"] .coef-hero {
            background: linear-gradient(120deg, #142d58, #235c85);
        }

        /* =====================================================
               THÈME ÉMERAUDE
            ===================================================== */

        html[data-app-theme="emerald"] .coef-edit-page {
            --coef-bg: #edf7f2;
            --coef-surface: #ffffff;
            --coef-surface-soft: #eff8f3;
            --coef-text: #244238;
            --coef-heading: #174d3b;
            --coef-muted: #728f82;
            --coef-border: #d6e9de;
            --coef-hover: #edf8f1;
            --coef-input: #ffffff;
            --coef-accent: #16865c;
            --coef-accent-soft: #e1f4e9;
            --coef-shadow: 0 7px 24px rgba(24, 95, 65, .06);
        }

        html[data-app-theme="emerald"] .coef-hero {
            background: linear-gradient(120deg, #145c46, #218b70);
        }

        html[data-app-theme="emerald"] .coef-progress-bar {
            background: linear-gradient(90deg, #16865c, #36b98b);
        }

        /* =====================================================
               THÈME WARM
            ===================================================== */

        html[data-app-theme="warm"] .coef-edit-page {
            --coef-bg: #faf5ef;
            --coef-surface: #fffdf9;
            --coef-surface-soft: #f8f0e6;
            --coef-text: #514033;
            --coef-heading: #593e2b;
            --coef-muted: #998777;
            --coef-border: #eadfd2;
            --coef-hover: #fbf1e5;
            --coef-input: #fffdf9;
            --coef-accent: #b7793e;
            --coef-accent-soft: #f8ead9;
            --coef-shadow: 0 7px 24px rgba(111, 76, 43, .06);
        }

        html[data-app-theme="warm"] .coef-hero {
            background: linear-gradient(120deg, #765035, #b47b48);
        }

        html[data-app-theme="warm"] .coef-progress-bar {
            background: linear-gradient(90deg, #b7793e, #d6a15c);
        }

        /* =====================================================
               RESPONSIVE
            ===================================================== */

        @media(max-width: 900px) {
            .coef-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .coef-stats .coef-stat:last-child {
                grid-column: 1 / -1;
            }
        }

        @media(max-width: 768px) {
            .coef-edit-page {
                padding: 12px;
            }

            .coef-hero {
                padding: 24px 21px;
            }

            .coef-hero h3 {
                font-size: 21px;
            }

            .coef-stats {
                grid-template-columns: 1fr;
            }

            .coef-stats .coef-stat:last-child {
                grid-column: auto;
            }

            .coef-card-header,
            .coef-card-footer {
                align-items: stretch;
                flex-direction: column;
                padding: 18px;
            }

            .coef-tools {
                width: 100%;
                align-items: stretch;
                flex-direction: column;
            }

            .coef-search {
                width: 100%;
                min-width: 0;
            }

            .coef-page-size {
                justify-content: flex-start;
            }

            .coef-table thead th,
            .coef-table tbody td {
                padding: 12px 14px;
            }

            .coef-input-wrap {
                min-width: 125px;
            }

            .coef-actions {
                width: 100%;
            }

            .coef-actions .btn {
                flex: 1;
                text-align: center;
            }

            .coef-pagination-footer {
                flex-direction: column;
                align-items: flex-start;
                padding: 14px 18px;
            }

            .coef-progress {
                width: 100%;
            }
        }

        @media(max-width: 420px) {
            .coef-actions {
                flex-direction: column;
            }

            .coef-actions .btn {
                width: 100%;
            }

            .coef-pagination {
                max-width: 100%;
            }
        }
    </style>

    <div class="coef-edit-page">

        {{-- HERO --}}
        <div class="coef-hero">
            <div class="coef-hero-content">

                <div class="coef-subtitle">
                    <i class="bi bi-sliders"></i>
                    CONFIGURATION PÉDAGOGIQUE
                </div>

                <h3>
                    <i class="bi bi-calculator me-2"></i>
                    Coefficients : {{ $matiere->nom }}
                </h3>

                <p>
                    Définissez l'importance de cette matière pour chaque classe de votre établissement.
                </p>

            </div>
        </div>

        {{-- STATISTIQUES --}}
        <div class="coef-stats">

            <div class="coef-stat">
                <div class="coef-stat-icon">
                    <i class="bi bi-buildings"></i>
                </div>

                <div>
                    <strong>{{ $totalClasses }}</strong>
                    <small>Classes disponibles</small>
                </div>
            </div>

            <div class="coef-stat">
                <div class="coef-stat-icon success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div>
                    <strong id="configuredCount">
                        {{ $classesConfigurees }}
                    </strong>
                    <small>Coefficients renseignés</small>
                </div>
            </div>

            <div class="coef-stat">
                <div class="coef-stat-icon warning">
                    <i class="bi bi-pie-chart-fill"></i>
                </div>

                <div>
                    <strong id="configuredPercentage">
                        {{ $pourcentage }}%
                    </strong>
                    <small>Progression de configuration</small>
                </div>
            </div>

        </div>

        {{-- FORMULAIRE --}}
        <form method="POST" action="{{ route('coefficients.save', $matiere->id) }}">
            @csrf

            <div class="coef-card">

                {{-- HEADER --}}
                <div class="coef-card-header">

                    <div>
                        <h5>
                            <i class="bi bi-list-check me-2"></i>
                            Configuration par classe
                        </h5>

                        <p>
                            Saisissez le coefficient correspondant à chaque classe.
                        </p>
                    </div>

                    <div class="coef-tools">

                        {{-- RECHERCHE --}}
                        <div class="coef-search">
                            <i class="bi bi-search"></i>

                            <input type="text" id="searchClasse" placeholder="Rechercher une classe..."
                                autocomplete="off">
                        </div>

                        {{-- NOMBRE PAR PAGE --}}
                        <div class="coef-page-size">
                            <label for="coefPerPage">Afficher :</label>

                            <select id="coefPerPage" class="form-select">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="all">Tout</option>
                            </select>
                        </div>

                    </div>

                </div>

                {{-- TABLEAU --}}
                <div class="coef-table-wrapper">

                    <table class="coef-table">

                        <thead>
                            <tr>
                                <th>Classe</th>
                                <th style="width:240px;">Coefficient</th>
                            </tr>
                        </thead>

                        <tbody id="coefTableBody">

                            @forelse ($classes as $classe)
                                <tr class="coef-row">

                                    <td>
                                        <div class="coef-class">

                                            <div class="coef-class-icon">
                                                <i class="bi bi-mortarboard-fill"></i>
                                            </div>

                                            {{ $classe->nom }}

                                        </div>
                                    </td>

                                    <td>
                                        <div class="coef-input-wrap">

                                            <input type="number" min="1" step="1"
                                                class="form-control coef-input" name="coef[{{ $classe->id }}]"
                                                value="{{ old('coef.' . $classe->id, $coefficients[$classe->id] ?? '') }}"
                                                placeholder="Ex : 2">

                                            <span class="coef-input-suffix">
                                                Coef.
                                            </span>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="2" class="coef-no-classes">

                                        <i class="bi bi-buildings"></i>

                                        Aucune classe disponible.

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                    {{-- RECHERCHE SANS RÉSULTAT --}}
                    <div class="coef-empty" id="coefEmpty">

                        <i class="bi bi-search"></i>

                        <strong>Aucune classe trouvée</strong>

                        <p>
                            Essayez avec un autre nom de classe.
                        </p>

                    </div>

                </div>

                {{-- PAGINATION --}}
                <div class="coef-pagination-footer">

                    <span id="coefPageInfo"></span>

                    <div class="coef-pagination" id="coefPagination"></div>

                </div>

                {{-- FOOTER --}}
                <div class="coef-card-footer">

                    <div class="coef-progress-container">

                        <div class="coef-progress-label">
                            <i class="bi bi-graph-up-arrow me-1"></i>
                            État de configuration
                        </div>

                        <div class="coef-progress">
                            <div class="coef-progress-bar" id="coefProgressBar" style="width: {{ $pourcentage }}%;"></div>
                        </div>

                    </div>

                    <div class="coef-actions">

                        <a href="{{ route('coefficients.index') }}" class="btn coef-btn-back">
                            <i class="bi bi-arrow-left me-2"></i>
                            Retour
                        </a>

                        <button type="submit" class="btn coef-btn-save">

                            <i class="bi bi-check2-circle me-2"></i>
                            Enregistrer les coefficients

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

    {{-- =====================================================
         JAVASCRIPT : RECHERCHE, PAGINATION ET PROGRESSION
    ====================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const search = document.getElementById('searchClasse');

            const rows = Array.from(
                document.querySelectorAll('.coef-row')
            );

            const empty = document.getElementById('coefEmpty');

            const inputs = Array.from(
                document.querySelectorAll('.coef-input')
            );

            const configuredCount =
                document.getElementById('configuredCount');

            const configuredPercentage =
                document.getElementById('configuredPercentage');

            const progressBar =
                document.getElementById('coefProgressBar');

            const perPageSelect =
                document.getElementById('coefPerPage');

            const pagination =
                document.getElementById('coefPagination');

            const pageInfo =
                document.getElementById('coefPageInfo');

            let currentPage = 1;

            let filteredRows = [...rows];

            // =================================================
            // RECHERCHE
            // =================================================

            function filterRows() {

                const value = search.value.toLowerCase().trim();

                filteredRows = rows.filter(row =>
                    row.textContent.toLowerCase().includes(value)
                );

                currentPage = 1;

                renderTable();
            }

            // =================================================
            // AFFICHAGE DU TABLEAU
            // =================================================

            function renderTable() {

                const perPage = perPageSelect.value === 'all' ?
                    Math.max(filteredRows.length, 1) :
                    parseInt(perPageSelect.value, 10);

                const total = filteredRows.length;

                const totalPages = Math.max(
                    1,
                    Math.ceil(total / perPage)
                );

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }

                // Masquer toutes les lignes
                rows.forEach(row => {
                    row.style.display = 'none';
                });

                // Calcul de la plage à afficher
                const start = (currentPage - 1) * perPage;

                const end = Math.min(start + perPage, total);

                // Afficher uniquement les lignes de la page
                filteredRows.slice(start, end).forEach(row => {
                    row.style.display = '';
                });

                // Message vide
                if (empty) {
                    empty.style.display = total === 0 ? 'block' : 'none';
                }

                // Informations de pagination
                if (pageInfo) {
                    pageInfo.textContent = total === 0 ?
                        'Aucune classe trouvée' :
                        `Affichage de ${start + 1} à ${end} sur ${total} classes`;
                }

                renderPagination(totalPages);
            }

            // =================================================
            // CRÉATION DES BOUTONS
            // =================================================

            function addButton(label, page, disabled = false, active = false) {

                const button = document.createElement('button');

                button.type = 'button';

                button.textContent = label;

                button.disabled = disabled;

                if (active) {
                    button.classList.add('active');
                    button.setAttribute('aria-current', 'page');
                }

                button.addEventListener('click', function() {

                    if (disabled || page < 1) {
                        return;
                    }

                    currentPage = page;

                    renderTable();

                });

                pagination.appendChild(button);
            }

            // =================================================
            // PAGINATION AVEC NUMÉROS
            // =================================================

            function renderPagination(totalPages) {

                pagination.innerHTML = '';

                if (filteredRows.length === 0) {
                    return;
                }

                addButton(
                    '‹',
                    currentPage - 1,
                    currentPage === 1
                );

                let pages = [];

                if (totalPages <= 7) {

                    for (let i = 1; i <= totalPages; i++) {
                        pages.push(i);
                    }

                } else {

                    pages.push(1);

                    if (currentPage > 3) {
                        pages.push('...');
                    }

                    const first = Math.max(2, currentPage - 1);

                    const last = Math.min(
                        totalPages - 1,
                        currentPage + 1
                    );

                    for (let i = first; i <= last; i++) {
                        pages.push(i);
                    }

                    if (currentPage < totalPages - 2) {
                        pages.push('...');
                    }

                    pages.push(totalPages);

                }

                pages.forEach(page => {

                    if (page === '...') {

                        const dots = document.createElement('span');

                        dots.textContent = '...';

                        dots.className = 'coef-dots';

                        pagination.appendChild(dots);

                    } else {

                        addButton(
                            page,
                            page,
                            false,
                            page === currentPage
                        );

                    }

                });

                addButton(
                    '›',
                    currentPage + 1,
                    currentPage === totalPages
                );

            }

            // =================================================
            // ÉVÉNEMENTS DE RECHERCHE
            // =================================================

            if (search) {
                search.addEventListener('input', filterRows);
            }

            // =================================================
            // CHANGEMENT DU NOMBRE PAR PAGE
            // =================================================

            if (perPageSelect) {

                perPageSelect.addEventListener('change', function() {

                    currentPage = 1;

                    renderTable();

                });

            }

            // =================================================
            // COMPTEUR ET PROGRESSION
            // =================================================

            function updateProgress() {

                let configured = 0;

                inputs.forEach(input => {

                    if (
                        input.value.trim() !== '' &&
                        Number(input.value) >= 1
                    ) {
                        configured++;
                    }

                });

                const total = inputs.length;

                const percentage = total > 0 ?
                    Math.round((configured / total) * 100) :
                    0;

                if (configuredCount) {
                    configuredCount.textContent = configured;
                }

                if (configuredPercentage) {
                    configuredPercentage.textContent = percentage + '%';
                }

                if (progressBar) {
                    progressBar.style.width = percentage + '%';
                }

            }

            inputs.forEach(input => {

                input.addEventListener('input', updateProgress);

            });

            // =================================================
            // INITIALISATION
            // =================================================

            updateProgress();

            renderTable();

        });
    </script>
@endsection
