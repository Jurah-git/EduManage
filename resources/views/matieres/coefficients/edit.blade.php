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
        .coef-edit-page {
            padding: 20px;
            color: #263445;
        }

        /* HERO */
        .coef-hero {
            position: relative;
            overflow: hidden;
            padding: 28px 32px;
            border-radius: 18px;
            color: white;
            background: linear-gradient(120deg, #263b70, #287e9b);
            box-shadow: 0 10px 28px rgba(31, 59, 105, .18);
            margin-bottom: 22px;
        }

        .coef-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            right: -55px;
            top: -100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
        }

        .coef-hero-content {
            position: relative;
            z-index: 1;
        }

        .coef-hero h3 {
            font-weight: 800;
            margin: 0 0 8px;
        }

        .coef-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .82);
        }

        .coef-subtitle {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 30px;
            background: rgba(255, 255, 255, .14);
            font-size: 12px;
            margin-bottom: 13px;
        }

        /* STATISTIQUES */
        .coef-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 22px;
        }

        .coef-stat {
            background: white;
            border: 1px solid #e9edf3;
            border-radius: 14px;
            padding: 17px 19px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .035);
        }

        .coef-stat-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 19px;
            background: #edf3ff;
            color: #3564b8;
            flex-shrink: 0;
        }

        .coef-stat strong {
            display: block;
            font-size: 22px;
            font-weight: 800;
            line-height: 1.2;
        }

        .coef-stat small {
            color: #7b8796;
            font-size: 12px;
        }

        /* CARD */
        .coef-card {
            background: white;
            border: 1px solid #e7ebf1;
            border-radius: 17px;
            overflow: hidden;
            box-shadow: 0 6px 22px rgba(25, 42, 70, .055);
        }

        .coef-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #edf0f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .coef-card-header h5 {
            margin: 0 0 5px;
            font-weight: 800;
            color: #263b58;
        }

        .coef-card-header p {
            margin: 0;
            font-size: 13px;
            color: #8591a0;
        }

        /* RECHERCHE ET NOMBRE PAR PAGE */
        .coef-tools {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .coef-search {
            position: relative;
            min-width: 220px;
        }

        .coef-search input {
            width: 100%;
            padding: 10px 13px 10px 38px;
            border: 1px solid #dfe5ed;
            border-radius: 9px;
            outline: none;
            font-size: 13px;
        }

        .coef-search input:focus {
            border-color: #4383d7;
            box-shadow: 0 0 0 3px rgba(67, 131, 215, .10);
        }

        .coef-search i {
            position: absolute;
            left: 13px;
            top: 13px;
            color: #8793a3;
        }

        .coef-page-size {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #64748b;
            white-space: nowrap;
        }

        .coef-page-size select {
            width: 85px;
            border-radius: 8px;
            border-color: #dfe5ed;
            font-size: 13px;
        }

        /* TABLEAU */
        .coef-table-wrapper {
            max-height: 470px;
            overflow-y: auto;
            overflow-x: auto;
        }

        .coef-table {
            width: 100%;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .coef-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f5f7fb;
            color: #526174;
            padding: 15px 22px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid #e5eaf1;
        }

        .coef-table tbody td {
            padding: 13px 22px;
            vertical-align: middle;
            border-bottom: 1px solid #edf0f4;
        }

        .coef-table tbody tr:hover {
            background: #f8faff;
        }

        .coef-class {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 650;
            color: #34445a;
        }

        .coef-class-icon {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #edf3ff;
            color: #3867b5;
            border-radius: 9px;
            flex-shrink: 0;
        }

        .coef-input-wrap {
            max-width: 180px;
            position: relative;
        }

        .coef-input-wrap input {
            height: 42px;
            border: 1px solid #dce3ec;
            border-radius: 9px;
            font-weight: 700;
            color: #263b58;
            padding-right: 48px;
        }

        .coef-input-wrap input:focus {
            border-color: #4383d7;
            box-shadow: 0 0 0 3px rgba(67, 131, 215, .12);
        }

        .coef-input-suffix {
            position: absolute;
            right: 13px;
            top: 11px;
            color: #8793a3;
            font-size: 12px;
            pointer-events: none;
        }

        /* AUCUN RESULTAT */
        .coef-empty {
            display: none;
            padding: 35px;
            text-align: center;
            color: #8490a0;
        }

        /* PAGINATION */
        .coef-pagination-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 14px 22px;
            border-top: 1px solid #edf0f4;
            font-size: 13px;
            color: #718096;
        }

        .coef-pagination {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            align-items: center;
        }

        .coef-pagination button {
            min-width: 34px;
            height: 34px;
            border: 1px solid #dce3ec;
            background: white;
            color: #42536a;
            padding: 5px 10px;
            border-radius: 7px;
            font-size: 13px;
            cursor: pointer;
        }

        .coef-pagination button:hover:not(:disabled) {
            border-color: #2878bd;
            color: #2878bd;
        }

        .coef-pagination button.active {
            background: #2878bd;
            color: white;
            border-color: #2878bd;
        }

        .coef-pagination button:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .coef-pagination .coef-dots {
            padding: 0 4px;
            color: #94a3b8;
        }

        /* PROGRESSION ET ACTIONS */
        .coef-card-footer {
            padding: 18px 24px;
            border-top: 1px solid #edf0f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .coef-progress {
            width: 180px;
            height: 7px;
            background: #e9edf3;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 7px;
        }

        .coef-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #2878bd, #24a69a);
            border-radius: 20px;
            transition: width .25s ease;
        }

        .coef-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .coef-actions .btn {
            padding: 10px 18px;
            border-radius: 9px;
            font-weight: 650;
        }

        @media(max-width: 768px) {
            .coef-edit-page {
                padding: 12px;
            }

            .coef-stats {
                grid-template-columns: 1fr;
            }

            .coef-hero {
                padding: 23px;
            }

            .coef-card-header,
            .coef-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .coef-tools {
                width: 100%;
                align-items: stretch;
                flex-direction: column;
            }

            .coef-search {
                width: 100%;
            }

            .coef-page-size {
                justify-content: flex-start;
            }

            .coef-actions {
                width: 100%;
            }

            .coef-actions .btn {
                flex: 1;
            }

            .coef-pagination-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="coef-edit-page">

        {{-- HERO --}}
        <div class="coef-hero">
            <div class="coef-hero-content">

                <div class="coef-subtitle">
                    <i class="fas fa-sliders-h"></i>
                    CONFIGURATION PÉDAGOGIQUE
                </div>

                <h3>
                    <i class="fas fa-calculator me-2"></i>
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
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <strong>{{ $totalClasses }}</strong>
                    <small>Classes disponibles</small>
                </div>
            </div>

            <div class="coef-stat">
                <div class="coef-stat-icon" style="background:#e8f8ef;color:#24945b;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <strong id="configuredCount">
                        {{ $classesConfigurees }}
                    </strong>
                    <small>Coefficients renseignés</small>
                </div>
            </div>

            <div class="coef-stat">
                <div class="coef-stat-icon" style="background:#fff3e6;color:#d88732;">
                    <i class="fas fa-chart-pie"></i>
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
                            <i class="fas fa-list-check me-2 text-primary"></i>
                            Configuration par classe
                        </h5>

                        <p>
                            Saisissez le coefficient correspondant à chaque classe.
                        </p>
                    </div>

                    <div class="coef-tools">

                        {{-- RECHERCHE --}}
                        <div class="coef-search">
                            <i class="fas fa-search"></i>

                            <input type="text" id="searchClasse" placeholder="Rechercher une classe...">
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
                                                <i class="fas fa-graduation-cap"></i>
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
                                    <td colspan="2" class="text-center py-5 text-muted">

                                        <i class="fas fa-school fa-2x mb-3 d-block"></i>

                                        Aucune classe disponible.

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                    <div class="coef-empty" id="coefEmpty">

                        <i class="fas fa-search fa-2x mb-2 d-block"></i>

                        Aucune classe ne correspond à votre recherche.

                    </div>

                </div>

                {{-- PAGINATION --}}
                <div class="coef-pagination-footer">

                    <span id="coefPageInfo"></span>

                    <div class="coef-pagination" id="coefPagination">
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="coef-card-footer">

                    <div>
                        <div class="small fw-bold text-secondary">
                            État de configuration
                        </div>

                        <div class="coef-progress">
                            <div class="coef-progress-bar" id="coefProgressBar" style="width: {{ $pourcentage }}%;">
                            </div>
                        </div>
                    </div>

                    <div class="coef-actions">

                        <a href="{{ route('coefficients.index') }}" class="btn btn-light border">

                            <i class="fas fa-arrow-left me-2"></i>
                            Retour

                        </a>

                        <button type="submit" class="btn btn-success">

                            <i class="fas fa-save me-2"></i>
                            Enregistrer les coefficients

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const search = document.getElementById('searchClasse');

            const rows = Array.from(
                document.querySelectorAll('.coef-row')
            );

            const empty = document.getElementById('coefEmpty');

            const inputs = document.querySelectorAll('.coef-input');

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

            // RECHERCHE
            function filterRows() {

                const value = search.value.toLowerCase().trim();

                filteredRows = rows.filter(row =>
                    row.textContent.toLowerCase().includes(value)
                );

                currentPage = 1;

                renderTable();
            }

            // AFFICHAGE DU TABLEAU
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

                // Afficher les lignes de la page actuelle
                const start = (currentPage - 1) * perPage;

                const end = Math.min(start + perPage, total);

                filteredRows.slice(start, end).forEach(row => {
                    row.style.display = '';
                });

                // Message vide
                empty.style.display = total === 0 ?
                    'block' :
                    'none';

                // Informations de pagination
                pageInfo.textContent = total === 0 ?
                    'Aucune classe trouvée' :
                    `Affichage de ${start + 1} à ${end} sur ${total} classes`;

                renderPagination(totalPages);
            }

            // CREATION DES BOUTONS DE PAGINATION
            function addButton(label, page, disabled = false, active = false) {

                const button = document.createElement('button');

                button.type = 'button';

                button.textContent = label;

                button.disabled = disabled;

                if (active) {
                    button.classList.add('active');
                }

                button.addEventListener('click', function() {

                    currentPage = page;

                    renderTable();

                });

                pagination.appendChild(button);
            }

            // PAGINATION AVEC NUMEROS
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

                    const last = Math.min(totalPages - 1, currentPage + 1);

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

            // EVENEMENT RECHERCHE
            search.addEventListener('input', filterRows);

            // CHANGEMENT NOMBRE PAR PAGE
            perPageSelect.addEventListener('change', function() {

                currentPage = 1;

                renderTable();

            });

            // COMPTEUR ET PROGRESSION
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

                configuredCount.textContent = configured;

                configuredPercentage.textContent =
                    percentage + '%';

                progressBar.style.width =
                    percentage + '%';

            }

            inputs.forEach(input => {

                input.addEventListener('input', updateProgress);

            });

            // INITIALISATION
            updateProgress();

            renderTable();

        });
    </script>
@endsection
