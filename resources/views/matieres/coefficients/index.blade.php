@extends('layouts.app')

@section('content')
    <style>
        /* =====================================================
           COEFFICIENTS - VARIABLES ET STYLE PRINCIPAL
        ===================================================== */

        .coeff-page {
            --cf-primary: #28649c;
            --cf-primary-rgb: 40, 100, 156;
            --cf-accent: #168e91;
            --cf-text: #26364b;
            --cf-muted: #8290a4;
            --cf-border: #e8edf4;
            --cf-surface: #ffffff;
            --cf-soft: #f4f7fb;
            --cf-input-bg: #ffffff;
            --cf-table-hover: #f5f9ff;
            --cf-icon-bg: #eaf2ff;
            --cf-icon-color: #3478bd;
            --cf-footer: #fafbfd;
            --cf-button-bg: #ffffff;
            --cf-button-text: #617189;

            padding: 24px;
            max-width: 1450px;
            margin: auto;
            color: var(--cf-text);
        }

        /* =====================================================
           THÈME SOMBRE
        ===================================================== */

        html[data-app-theme="dark"] .coeff-page {
            --cf-primary: #70aef2;
            --cf-primary-rgb: 112, 174, 242;
            --cf-accent: #32c4c3;
            --cf-text: #e7edf7;
            --cf-muted: #9eacc0;
            --cf-border: #304057;
            --cf-surface: #19283c;
            --cf-soft: #142238;
            --cf-input-bg: #101e31;
            --cf-table-hover: #20344d;
            --cf-icon-bg: #203a58;
            --cf-icon-color: #83baff;
            --cf-footer: #142238;
            --cf-button-bg: #1d3048;
            --cf-button-text: #d5dfed;
        }

        /* =====================================================
           THÈME ULTRA PRO
        ===================================================== */

        html[data-app-theme="ultra-pro"] .coeff-page {
            --cf-primary: #60a5fa;
            --cf-primary-rgb: 96, 165, 250;
            --cf-accent: #22d3ee;
            --cf-text: #e8f0fc;
            --cf-muted: #9bacc4;
            --cf-border: #293d59;
            --cf-surface: #14243b;
            --cf-soft: #102037;
            --cf-input-bg: #0d1b30;
            --cf-table-hover: #1b3553;
            --cf-icon-bg: #1b3857;
            --cf-icon-color: #75b8ff;
            --cf-footer: #102037;
            --cf-button-bg: #1a304c;
            --cf-button-text: #dbe8f8;
        }

        /* =====================================================
           THÈME EMERALD
        ===================================================== */

        html[data-app-theme="emerald"] .coeff-page {
            --cf-primary: #15966d;
            --cf-primary-rgb: 21, 150, 109;
            --cf-accent: #35b98c;
            --cf-icon-bg: #e8f8f2;
            --cf-icon-color: #15966b;
            --cf-table-hover: #f0faf5;
        }

        html[data-app-theme="dark"][data-app-theme="emerald"] .coeff-page {
            --cf-icon-bg: #173e34;
            --cf-icon-color: #63d6a8;
            --cf-table-hover: #183b34;
        }

        /* =====================================================
           THÈME WARM
        ===================================================== */

        html[data-app-theme="warm"] .coeff-page {
            --cf-primary: #c46b45;
            --cf-primary-rgb: 196, 107, 69;
            --cf-accent: #e6a06e;
            --cf-icon-bg: #fff0e8;
            --cf-icon-color: #c46b45;
            --cf-table-hover: #fff8f3;
        }

        html[data-app-theme="warm"] .coeff-hero {
            background: linear-gradient(120deg, #8f4933, #c46b45 60%, #e6a06e);
        }

        /* =====================================================
           HERO
        ===================================================== */

        .coeff-hero {
            position: relative;
            overflow: hidden;
            padding: 30px 34px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(120deg,
                    #172c50,
                    #24558a 60%,
                    #168e91);
            box-shadow: 0 12px 30px rgba(23, 44, 80, .17);
            margin-bottom: 24px;
        }

        .coeff-hero::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            right: -45px;
            top: -100px;
            border: 35px solid rgba(255, 255, 255, .10);
            border-radius: 50%;
            pointer-events: none;
        }

        .coeff-hero::before {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            right: 150px;
            bottom: -80px;
            border: 20px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            pointer-events: none;
        }

        html[data-app-theme="ultra-pro"] .coeff-hero {
            background: linear-gradient(120deg, #102746, #17618b 60%, #168eaa);
        }

        html[data-app-theme="emerald"] .coeff-hero {
            background: linear-gradient(120deg, #075c47, #15966d 60%, #42bd91);
        }

        .coeff-hero-content {
            position: relative;
            z-index: 1;
        }

        .coeff-hero h3 {
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -.4px;
        }

        .coeff-hero p {
            margin: 0;
            opacity: .9;
            font-size: 13px;
            max-width: 700px;
            line-height: 1.7;
        }

        .coeff-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 13px;
            opacity: .95;
        }

        .coeff-hero-icon {
            width: 41px;
            height: 41px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .17);
            border: 1px solid rgba(255, 255, 255, .2);
            font-size: 19px;
        }

        /* =====================================================
           STATISTIQUES
        ===================================================== */

        .coeff-stat-card {
            background: var(--cf-surface);
            border: 1px solid var(--cf-border);
            border-radius: 15px;
            padding: 19px;
            height: 100%;
            box-shadow: 0 5px 18px rgba(20, 40, 70, .04);
            transition: .2s;
        }

        .coeff-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 22px rgba(20, 40, 70, .08);
        }

        .coeff-stat-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 13px;
            background: var(--cf-icon-bg);
            color: var(--cf-icon-color);
        }

        .coeff-stat-number {
            font-size: 26px;
            font-weight: 800;
            color: var(--cf-text);
            line-height: 1.2;
        }

        .coeff-stat-label {
            font-size: 12px;
            color: var(--cf-muted);
            margin-top: 5px;
            font-weight: 600;
        }

        /* =====================================================
           CARTE DU TABLEAU
        ===================================================== */

        .coeff-card {
            margin-top: 23px;
            background: var(--cf-surface);
            border: 1px solid var(--cf-border);
            border-radius: 17px;
            box-shadow: 0 8px 25px rgba(20, 40, 70, .05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 405px);
            min-height: 390px;
            max-height: 650px;
        }

        .coeff-card-header {
            padding: 21px 24px;
            border-bottom: 1px solid var(--cf-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .coeff-card-title h5 {
            margin: 0 0 5px;
            font-weight: 800;
            font-size: 16px;
            color: var(--cf-text);
        }

        .coeff-card-title h5 i {
            color: var(--cf-primary);
        }

        .coeff-card-title p {
            margin: 0;
            font-size: 12px;
            color: var(--cf-muted);
        }

        /* =====================================================
           RECHERCHE
        ===================================================== */

        .coeff-search {
            position: relative;
            width: 290px;
            max-width: 100%;
        }

        .coeff-search i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--cf-muted);
        }

        .coeff-search input {
            width: 100%;
            height: 42px;
            border: 1px solid var(--cf-border);
            border-radius: 10px;
            padding: 8px 12px 8px 37px;
            font-size: 13px;
            outline: none;
            transition: .2s;
            background: var(--cf-input-bg);
            color: var(--cf-text);
        }

        .coeff-search input::placeholder {
            color: var(--cf-muted);
        }

        .coeff-search input:focus {
            border-color: var(--cf-primary);
            box-shadow: 0 0 0 3px rgba(var(--cf-primary-rgb), .12);
        }

        /* =====================================================
           TABLEAU
        ===================================================== */

        .coeff-table-wrapper {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: auto;
        }

        .coeff-table {
            width: 100%;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .coeff-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--cf-soft);
            color: var(--cf-muted);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 15px 22px;
            border-bottom: 1px solid var(--cf-border);
            white-space: nowrap;
        }

        .coeff-table tbody td {
            padding: 14px 22px;
            border-bottom: 1px solid var(--cf-border);
            vertical-align: middle;
            font-size: 13px;
            color: var(--cf-text);
        }

        .coeff-table tbody tr {
            transition: background .15s;
        }

        .coeff-table tbody tr:hover {
            background: var(--cf-table-hover);
        }

        .coeff-table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* =====================================================
           MATIÈRE
        ===================================================== */

        .coeff-subject {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .coeff-subject-icon {
            width: 37px;
            height: 37px;
            border-radius: 11px;
            background: var(--cf-icon-bg);
            color: var(--cf-icon-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
        }

        .coeff-subject-name {
            font-weight: 700;
            color: var(--cf-text);
        }

        /* =====================================================
           BOUTON CONFIGURER
        ===================================================== */

        .coeff-configure-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px 14px;
            border-radius: 9px;
            background: rgba(var(--cf-primary-rgb), .10);
            border: 1px solid rgba(var(--cf-primary-rgb), .22);
            color: var(--cf-primary);
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: .2s;
            white-space: nowrap;
        }

        .coeff-configure-btn:hover {
            background: var(--cf-primary);
            border-color: var(--cf-primary);
            color: white;
            transform: translateY(-1px);
        }

        /* =====================================================
           ÉTATS VIDES
        ===================================================== */

        .coeff-empty {
            padding: 55px 20px !important;
            text-align: center;
            color: var(--cf-muted) !important;
        }

        .coeff-empty i {
            display: block;
            font-size: 35px;
            margin-bottom: 13px;
            color: var(--cf-muted);
            opacity: .65;
        }

        .coeff-empty strong {
            color: var(--cf-text);
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .coeff-card-footer {
            padding: 15px 22px;
            border-top: 1px solid var(--cf-border);
            background: var(--cf-footer);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .coeff-footer-info {
            font-size: 12px;
            color: var(--cf-muted);
        }

        /* =====================================================
           PAGINATION
        ===================================================== */

        .coeff-pagination {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .coeff-pagination button {
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border: 1px solid var(--cf-border);
            background: var(--cf-button-bg);
            border-radius: 7px;
            color: var(--cf-button-text);
            font-size: 12px;
            font-weight: 700;
            transition: .2s;
        }

        .coeff-pagination button:hover:not(:disabled),
        .coeff-pagination button.active {
            background: var(--cf-primary);
            border-color: var(--cf-primary);
            color: white;
        }

        .coeff-pagination button:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .coeff-per-page {
            height: 32px;
            padding: 4px 9px;
            border: 1px solid var(--cf-border);
            border-radius: 7px;
            background: var(--cf-input-bg);
            color: var(--cf-text);
            font-size: 12px;
            outline: none;
        }

        .coeff-per-page:focus {
            border-color: var(--cf-primary);
            box-shadow: 0 0 0 2px rgba(var(--cf-primary-rgb), .12);
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media(max-width: 768px) {

            .coeff-page {
                padding: 14px;
            }

            .coeff-hero {
                padding: 24px;
            }

            .coeff-hero h3 {
                font-size: 22px;
            }

            .coeff-card {
                height: calc(100vh - 370px);
                min-height: 350px;
            }

            .coeff-card-header {
                padding: 17px;
            }

            .coeff-search {
                width: 100%;
            }

            .coeff-table thead th,
            .coeff-table tbody td {
                padding: 12px;
            }

            .coeff-card-footer {
                padding: 13px;
            }

            .coeff-pagination {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media(max-width: 480px) {

            .coeff-stat-card {
                padding: 15px;
            }

            .coeff-stat-number {
                font-size: 23px;
            }

            .coeff-card-footer {
                align-items: flex-start;
            }

            .coeff-card-footer>div:first-child {
                width: 100%;
            }

            .coeff-pagination {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="coeff-page">

        {{-- =====================================================
         HERO
    ====================================================== --}}

        <div class="coeff-hero">

            <div class="coeff-hero-content">

                <div class="coeff-hero-label">

                    <div class="coeff-hero-icon">
                        <i class="bi bi-sliders"></i>
                    </div>

                    <span>Paramètres pédagogiques</span>

                </div>

                <h3>Gestion des coefficients</h3>

                <p>
                    Configurez les coefficients de chaque matière pour organiser
                    le calcul des moyennes et des résultats scolaires.
                </p>

            </div>

        </div>

        {{-- =====================================================
         STATISTIQUES
    ====================================================== --}}

        <div class="row g-3">

            {{-- TOTAL MATIÈRES --}}

            <div class="col-md-4">

                <div class="coeff-stat-card">

                    <div class="coeff-stat-icon">
                        <i class="bi bi-book-half"></i>
                    </div>

                    <div class="coeff-stat-number">
                        {{ $matieres->count() }}
                    </div>

                    <div class="coeff-stat-label">
                        Matières disponibles
                    </div>

                </div>

            </div>

            {{-- MATIÈRES AFFICHÉES --}}

            <div class="col-md-4">

                <div class="coeff-stat-card">

                    <div class="coeff-stat-icon" style="background:rgba(21,150,107,.12);color:#15966b;">

                        <i class="bi bi-check-circle-fill"></i>

                    </div>

                    <div class="coeff-stat-number" id="coeffVisibleCount">
                        {{ $matieres->count() }}
                    </div>

                    <div class="coeff-stat-label">
                        Matières correspondantes
                    </div>

                </div>

            </div>

            {{-- CONFIGURATION --}}

            <div class="col-md-4">

                <div class="coeff-stat-card">

                    <div class="coeff-stat-icon" style="background:rgba(210,138,39,.12);color:#d28a27;">

                        <i class="bi bi-calculator-fill"></i>

                    </div>

                    <div class="coeff-stat-number">
                        <i class="bi bi-gear-wide-connected"></i>
                    </div>

                    <div class="coeff-stat-label">
                        Configuration des coefficients
                    </div>

                </div>

            </div>

        </div>

        {{-- =====================================================
         TABLEAU DES MATIÈRES
    ====================================================== --}}

        <div class="coeff-card">

            {{-- EN-TÊTE DU TABLEAU --}}

            <div class="coeff-card-header">

                <div class="coeff-card-title">

                    <h5>
                        <i class="bi bi-list-ul me-2"></i>
                        Liste des matières
                    </h5>

                    <p>
                        Consultez les matières et accédez à leur configuration.
                    </p>

                </div>

                <div class="coeff-search">

                    <i class="bi bi-search"></i>

                    <input type="text" id="searchMatiere" placeholder="Rechercher une matière..." autocomplete="off">

                </div>

            </div>

            {{-- CONTENU DU TABLEAU --}}

            <div class="coeff-table-wrapper">

                <table class="coeff-table">

                    <thead>

                        <tr>

                            <th>Matière</th>

                            @if (auth()->user()->aPermission('coefficients.modifier'))
                                <th width="180" class="text-center">
                                    Action
                                </th>
                            @endif

                        </tr>

                    </thead>

                    <tbody id="coeffTableBody">

                        @forelse ($matieres as $matiere)
                            <tr class="matiere-row" data-name="{{ strtolower($matiere->nom) }}">

                                <td>

                                    <div class="coeff-subject">

                                        <div class="coeff-subject-icon">
                                            <i class="bi bi-book-fill"></i>
                                        </div>

                                        <span class="coeff-subject-name">
                                            {{ $matiere->nom }}
                                        </span>

                                    </div>

                                </td>

                                @if (auth()->user()->aPermission('coefficients.modifier'))
                                    <td class="text-center">

                                        <a href="{{ route('coefficients.edit', $matiere->id) }}"
                                            class="coeff-configure-btn">

                                            <i class="bi bi-sliders"></i>
                                            Configurer

                                        </a>

                                    </td>
                                @endif

                            </tr>

                        @empty

                            <tr>

                                <td colspan="{{ auth()->user()->aPermission('coefficients.modifier') ? 2 : 1 }}"
                                    class="coeff-empty">

                                    <i class="bi bi-book-half"></i>

                                    <strong class="d-block mb-1">
                                        Aucune matière trouvée
                                    </strong>

                                    <span>
                                        Les matières apparaîtront ici lorsqu'elles seront enregistrées.
                                    </span>

                                </td>

                            </tr>
                        @endforelse

                        {{-- AUCUN RÉSULTAT DE RECHERCHE --}}

                        <tr id="searchEmpty" style="display:none;">

                            <td colspan="{{ auth()->user()->aPermission('coefficients.modifier') ? 2 : 1 }}"
                                class="coeff-empty">

                                <i class="bi bi-search"></i>

                                <strong class="d-block mb-1">
                                    Aucun résultat
                                </strong>

                                <span>
                                    Aucune matière ne correspond à votre recherche.
                                </span>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

            {{-- =================================================
             FOOTER ET PAGINATION
        ================================================== --}}

            <div class="coeff-card-footer">

                <div class="d-flex align-items-center gap-3 flex-wrap">

                    <span class="coeff-footer-info" id="coeffFooterInfo">
                        Affichage de {{ $matieres->count() }} matière(s)
                    </span>

                    <div class="d-flex align-items-center gap-2">

                        <span class="coeff-footer-info">
                            Afficher :
                        </span>

                        <select id="coeffPerPage" class="coeff-per-page">

                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="all">Tout</option>

                        </select>

                    </div>

                </div>

                <div class="coeff-pagination" id="coeffPagination">

                    <button type="button" id="coeffPrev" title="Page précédente" aria-label="Page précédente">
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <span id="coeffPageNumbers" class="d-flex gap-1"></span>

                    <button type="button" id="coeffNext" title="Page suivante" aria-label="Page suivante">
                        <i class="bi bi-chevron-right"></i>
                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
     JAVASCRIPT : RECHERCHE ET PAGINATION
========================================================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('searchMatiere');
            const perPageSelect = document.getElementById('coeffPerPage');

            const rows = Array.from(
                document.querySelectorAll('.matiere-row')
            );

            const prevButton = document.getElementById('coeffPrev');
            const nextButton = document.getElementById('coeffNext');

            const pageNumbers = document.getElementById('coeffPageNumbers');
            const footerInfo = document.getElementById('coeffFooterInfo');

            const visibleCount = document.getElementById('coeffVisibleCount');
            const searchEmpty = document.getElementById('searchEmpty');

            let currentPage = 1;

            // =====================================================
            // FILTRAGE DES MATIÈRES
            // =====================================================

            function getFilteredRows() {

                const search = searchInput.value.toLowerCase().trim();

                return rows.filter(function(row) {

                    return row.dataset.name.includes(search);

                });

            }

            // =====================================================
            // AFFICHAGE DU TABLEAU
            // =====================================================

            function renderTable() {

                const filteredRows = getFilteredRows();

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

                const start = (currentPage - 1) * perPage;
                const end = Math.min(start + perPage, total);

                // Masquer toutes les lignes

                rows.forEach(function(row) {
                    row.style.display = 'none';
                });

                // Afficher uniquement les lignes de la page actuelle

                filteredRows.slice(start, end).forEach(function(row) {
                    row.style.display = '';
                });

                // Gestion du message vide

                if (searchEmpty) {
                    searchEmpty.style.display = total === 0 ? '' : 'none';
                }

                // Mise à jour des statistiques

                if (visibleCount) {
                    visibleCount.textContent = total;
                }

                // Mise à jour du pied de tableau

                if (footerInfo) {

                    footerInfo.textContent = total === 0 ?
                        'Aucune matière à afficher' :
                        'Affichage de ' + (start + 1) +
                        ' à ' + end + ' sur ' + total + ' matière(s)';

                }

                renderPagination(totalPages);

            }

            // =====================================================
            // CONSTRUCTION DE LA PAGINATION
            // =====================================================

            function renderPagination(totalPages) {

                pageNumbers.innerHTML = '';

                prevButton.disabled = currentPage === 1;
                nextButton.disabled = currentPage === totalPages;

                if (getFilteredRows().length === 0 || totalPages <= 1) {
                    return;
                }

                let pages = [];

                if (totalPages <= 5) {

                    for (let i = 1; i <= totalPages; i++) {
                        pages.push(i);
                    }

                } else {

                    pages.push(1);

                    let start = Math.max(2, currentPage - 1);
                    let end = Math.min(totalPages - 1, currentPage + 1);

                    if (start > 2) {
                        pages.push('...');
                    }

                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }

                    if (end < totalPages - 1) {
                        pages.push('...');
                    }

                    pages.push(totalPages);

                }

                pages.forEach(function(page) {

                    if (page === '...') {

                        const dots = document.createElement('span');

                        dots.textContent = '...';
                        dots.style.padding = '5px';
                        dots.style.color = 'var(--cf-muted)';

                        pageNumbers.appendChild(dots);

                        return;

                    }

                    const button = document.createElement('button');

                    button.type = 'button';
                    button.textContent = page;

                    if (page === currentPage) {
                        button.classList.add('active');
                    }

                    button.addEventListener('click', function() {

                        currentPage = page;
                        renderTable();

                    });

                    pageNumbers.appendChild(button);

                });

            }

            // =====================================================
            // ÉVÉNEMENT : RECHERCHE
            // =====================================================

            if (searchInput) {

                searchInput.addEventListener('input', function() {

                    currentPage = 1;
                    renderTable();

                });

            }

            // =====================================================
            // ÉVÉNEMENT : NOMBRE DE LIGNES PAR PAGE
            // =====================================================

            if (perPageSelect) {

                perPageSelect.addEventListener('change', function() {

                    currentPage = 1;
                    renderTable();

                });

            }

            // =====================================================
            // ÉVÉNEMENT : PAGE PRÉCÉDENTE
            // =====================================================

            if (prevButton) {

                prevButton.addEventListener('click', function() {

                    if (currentPage > 1) {

                        currentPage--;
                        renderTable();

                    }

                });

            }

            // =====================================================
            // ÉVÉNEMENT : PAGE SUIVANTE
            // =====================================================

            if (nextButton) {

                nextButton.addEventListener('click', function() {

                    const filteredRows = getFilteredRows();

                    const perPage = perPageSelect.value === 'all' ?
                        Math.max(filteredRows.length, 1) :
                        parseInt(perPageSelect.value, 10);

                    const totalPages = Math.max(
                        1,
                        Math.ceil(filteredRows.length / perPage)
                    );

                    if (currentPage < totalPages) {

                        currentPage++;
                        renderTable();

                    }

                });

            }

            // =====================================================
            // INITIALISATION
            // =====================================================

            renderTable();

        });
    </script>
@endsection
