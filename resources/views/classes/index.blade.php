@extends('layouts.app')

@section('content')

    <div class="classes-page">

        <style>
            /* =====================================================
                   VARIABLES ET STRUCTURE
                ===================================================== */

            .classes-page {
                --classes-card: #ffffff;
                --classes-text: #26364d;
                --classes-muted: #8793a5;
                --classes-border: #e8edf4;
                --classes-soft: #f7f9fc;
                --classes-row-hover: #f4f8fd;
                --classes-primary: #1765a9;
                --classes-shadow: 0 5px 22px rgba(31, 45, 61, .045);

                padding: 20px 24px;
                color: var(--classes-text);
            }

            /* =====================================================
                   BANDEAU PRINCIPAL
                ===================================================== */

            .classes-hero {
                position: relative;
                overflow: hidden;
                padding: 25px 28px;
                margin-bottom: 20px;
                border-radius: 19px;
                color: #fff;
                background: linear-gradient(120deg, #102a56, #1765a9 55%, #13a8b8);
                box-shadow: 0 10px 28px rgba(23, 101, 169, .17);
            }

            .classes-hero::before {
                content: "";
                position: absolute;
                width: 220px;
                height: 220px;
                right: 7%;
                top: -130px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .07);
            }

            .classes-hero::after {
                content: "";
                position: absolute;
                width: 150px;
                height: 150px;
                right: 18%;
                bottom: -110px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .06);
            }

            .classes-hero-content {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            }

            .classes-hero-left {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .classes-hero-icon {
                width: 56px;
                height: 56px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 16px;
                background: rgba(255, 255, 255, .15);
                border: 1px solid rgba(255, 255, 255, .2);
                font-size: 24px;
            }

            .classes-hero h2 {
                margin: 0 0 6px;
                font-size: 24px;
                font-weight: 850;
                letter-spacing: -.5px;
            }

            .classes-hero p {
                margin: 0;
                color: rgba(255, 255, 255, .8);
                font-size: 13px;
            }

            .btn-add-classe {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 9px;
                padding: 12px 18px;
                border-radius: 11px;
                background: #fff;
                color: #1765a9;
                font-size: 13px;
                font-weight: 800;
                text-decoration: none;
                white-space: nowrap;
                border: none;
                transition: .25s;
            }

            .btn-add-classe:hover {
                background: #eaf6ff;
                color: #104c83;
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(0, 0, 0, .12);
            }

            /* =====================================================
                   ALERTES
                ===================================================== */

            .classes-alert {
                padding: 13px 16px;
                border: none;
                border-radius: 11px;
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 16px;
            }

            /* =====================================================
                   CARTE PRINCIPALE
                ===================================================== */

            .classes-card {
                height: calc(100vh - 190px);
                min-height: 400px;
                display: flex;
                flex-direction: column;
                overflow: hidden;
                background: var(--classes-card);
                border: 1px solid var(--classes-border);
                border-radius: 17px;
                box-shadow: var(--classes-shadow);
            }

            /* =====================================================
                   HEADER DU TABLEAU
                ===================================================== */

            .classes-card-header {
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                padding: 19px 22px;
                border-bottom: 1px solid var(--classes-border);
                background: var(--classes-card);
            }

            .classes-card-title h5 {
                margin: 0 0 5px;
                color: var(--classes-text);
                font-size: 16px;
                font-weight: 850;
            }

            .classes-card-title h5 i {
                color: var(--classes-primary);
            }

            .classes-card-title p {
                margin: 0;
                color: var(--classes-muted);
                font-size: 12px;
            }

            /* =====================================================
                   RECHERCHE
                ===================================================== */

            .classes-search {
                position: relative;
                width: 280px;
                max-width: 100%;
            }

            .classes-search input {
                width: 100%;
                height: 41px;
                padding: 0 13px 0 39px;
                border: 1px solid var(--classes-border);
                border-radius: 10px;
                outline: none;
                background: var(--classes-soft);
                color: var(--classes-text);
                font-size: 12px;
                transition: .2s;
            }

            .classes-search input::placeholder {
                color: var(--classes-muted);
            }

            .classes-search input:focus {
                border-color: #38a5d0;
                background: var(--classes-card);
                box-shadow: 0 0 0 3px rgba(56, 165, 208, .10);
            }

            .classes-search i {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--classes-muted);
                font-size: 13px;
            }

            /* =====================================================
                   TABLEAU SCROLLABLE
                ===================================================== */

            .classes-table-wrapper {
                flex: 1;
                min-height: 0;
                overflow-y: auto;
                overflow-x: auto;
                scrollbar-width: thin;
                scrollbar-color: #bdc9d8 transparent;
            }

            .classes-table-wrapper::-webkit-scrollbar {
                width: 7px;
                height: 7px;
            }

            .classes-table-wrapper::-webkit-scrollbar-track {
                background: transparent;
            }

            .classes-table-wrapper::-webkit-scrollbar-thumb {
                background: #bdc9d8;
                border-radius: 10px;
            }

            .classes-table {
                width: 100%;
                min-width: 600px;
                margin: 0;
                border-collapse: separate;
                border-spacing: 0;
            }

            .classes-table thead th {
                position: sticky;
                top: 0;
                z-index: 5;
                padding: 15px 20px;
                background: var(--classes-soft);
                color: var(--classes-muted);
                border-bottom: 1px solid var(--classes-border);
                font-size: 10px;
                font-weight: 850;
                letter-spacing: .8px;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .classes-table tbody td {
                padding: 15px 20px;
                vertical-align: middle;
                border-bottom: 1px solid var(--classes-border);
                background: var(--classes-card);
            }

            .classes-table tbody tr {
                transition: background .2s;
            }

            .classes-table tbody tr:hover td {
                background: var(--classes-row-hover);
            }

            .classes-table tbody tr:last-child td {
                border-bottom: none;
            }

            /* =====================================================
                   NOM DE CLASSE
                ===================================================== */

            .classe-name {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .classe-avatar {
                width: 41px;
                height: 41px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 12px;
                background: #edf5ff;
                color: #1765a9;
                font-size: 17px;
            }

            .classe-name strong {
                display: block;
                color: var(--classes-text);
                font-size: 13px;
                font-weight: 850;
            }

            .classe-name small {
                display: block;
                margin-top: 3px;
                color: var(--classes-muted);
                font-size: 10px;
            }

            /* =====================================================
                   BADGE ÉLÈVES
                ===================================================== */

            .classe-eleves-badge {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 8px 12px;
                border-radius: 9px;
                background: #edf5ff;
                color: #1765a9;
                font-size: 11px;
                font-weight: 800;
                white-space: nowrap;
            }

            /* =====================================================
                   ACTIONS
                ===================================================== */

            .classe-actions {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .classe-actions form {
                margin: 0;
            }

            .btn-classe-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 8px 11px;
                border-radius: 8px;
                border: none;
                font-size: 11px;
                font-weight: 750;
                text-decoration: none;
                white-space: nowrap;
                transition: .2s;
                cursor: pointer;
            }

            .btn-classe-action:hover {
                transform: translateY(-2px);
            }

            .btn-classe-edit {
                color: #a36b08;
                background: #fff6df;
            }

            .btn-classe-edit:hover {
                color: #fff;
                background: #e6a321;
            }

            .btn-classe-delete {
                color: #c13b48;
                background: #fff0f1;
            }

            .btn-classe-delete:hover {
                color: #fff;
                background: #dc3545;
            }

            /* =====================================================
                   AUCUNE CLASSE
                ===================================================== */

            .classes-empty {
                padding: 65px 20px !important;
                text-align: center;
                color: var(--classes-muted);
            }

            .classes-empty i {
                display: block;
                margin-bottom: 14px;
                font-size: 38px;
                color: #bdc9d8;
            }

            .classes-empty strong {
                display: block;
                margin-bottom: 6px;
                color: var(--classes-text);
                font-size: 14px;
                font-weight: 800;
            }

            .classes-empty span {
                font-size: 12px;
            }

            /* =====================================================
                   AUCUN RÉSULTAT
                ===================================================== */

            .classes-no-result {
                display: none;
                padding: 40px 15px;
                text-align: center;
                color: var(--classes-muted);
                font-size: 13px;
            }

            .classes-no-result i {
                display: block;
                margin-bottom: 10px;
                font-size: 25px;
            }

            /* =====================================================
                   FOOTER ET PAGINATION
                ===================================================== */

            .classes-card-footer {
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                flex-wrap: wrap;
                padding: 14px 22px;
                background: var(--classes-card);
                border-top: 1px solid var(--classes-border);
            }

            .classes-pagination-info {
                color: var(--classes-muted);
                font-size: 11px;
                font-weight: 600;
            }

            .classes-pagination-info strong {
                color: var(--classes-text);
                font-weight: 850;
            }

            .classes-pagination-controls {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 18px;
                flex-wrap: wrap;
            }

            .classes-per-page {
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--classes-muted);
                font-size: 11px;
                font-weight: 600;
                margin: 0;
            }

            .classes-per-page select {
                padding: 7px 10px;
                border: 1px solid var(--classes-border);
                border-radius: 8px;
                background: var(--classes-soft);
                color: var(--classes-text);
                font-size: 11px;
                font-weight: 750;
                outline: none;
                cursor: pointer;
            }

            .classes-per-page select:focus {
                border-color: #38a5d0;
                box-shadow: 0 0 0 3px rgba(56, 165, 208, .10);
            }

            .classes-pagination nav {
                margin: 0;
            }

            .classes-pagination .pagination {
                margin: 0;
                gap: 4px;
            }

            .classes-pagination .page-link {
                padding: 7px 10px;
                border: 1px solid var(--classes-border);
                border-radius: 8px !important;
                background: var(--classes-card);
                color: var(--classes-text);
                font-size: 11px;
                font-weight: 750;
            }

            .classes-pagination .page-item.active .page-link {
                border-color: #1765a9;
                background: #1765a9;
                color: #fff;
            }

            .classes-pagination .page-item.disabled .page-link {
                background: var(--classes-soft);
                color: var(--classes-muted);
            }

            /* =====================================================
                   MODE SOMBRE
                ===================================================== */

            html[data-app-theme="dark"] .classes-page,
            html[data-app-theme="ultra-pro"] .classes-page {
                --classes-card: #1e293b;
                --classes-text: #e5edf7;
                --classes-muted: #9aaabe;
                --classes-border: #334155;
                --classes-soft: #263449;
                --classes-row-hover: #293b52;
                --classes-primary: #93c5fd;
                --classes-shadow: 0 5px 22px rgba(0, 0, 0, .15);
            }

            html[data-app-theme="dark"] .classe-avatar,
            html[data-app-theme="ultra-pro"] .classe-avatar {
                background: #263f5d;
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .classe-eleves-badge,
            html[data-app-theme="ultra-pro"] .classe-eleves-badge {
                background: #263f5d;
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .btn-classe-edit,
            html[data-app-theme="ultra-pro"] .btn-classe-edit {
                background: #493b1c;
                color: #facc75;
            }

            html[data-app-theme="dark"] .btn-classe-delete,
            html[data-app-theme="ultra-pro"] .btn-classe-delete {
                background: #49272e;
                color: #fda4af;
            }

            html[data-app-theme="dark"] .classes-table-wrapper::-webkit-scrollbar-thumb,
            html[data-app-theme="ultra-pro"] .classes-table-wrapper::-webkit-scrollbar-thumb {
                background: #475569;
            }

            /* =====================================================
                   THÈME EMERALD
                ===================================================== */

            html[data-app-theme="emerald"] .classes-page {
                --classes-primary: #16865d;
            }

            html[data-app-theme="emerald"] .classe-avatar,
            html[data-app-theme="emerald"] .classe-eleves-badge {
                background: #e2f5eb;
                color: #16865d;
            }

            html[data-app-theme="emerald"] .classes-pagination .page-item.active .page-link {
                background: #16865d;
                border-color: #16865d;
            }

            /* =====================================================
                   THÈME WARM
                ===================================================== */

            html[data-app-theme="warm"] .classes-page {
                --classes-primary: #b66b37;
            }

            html[data-app-theme="warm"] .classe-avatar,
            html[data-app-theme="warm"] .classe-eleves-badge {
                background: #fff0df;
                color: #b66b37;
            }

            html[data-app-theme="warm"] .classes-pagination .page-item.active .page-link {
                background: #b66b37;
                border-color: #b66b37;
            }

            /* =====================================================
                   RESPONSIVE
                ===================================================== */

            @media (max-width: 768px) {

                .classes-page {
                    padding: 14px;
                }

                .classes-hero {
                    padding: 19px;
                }

                .classes-hero h2 {
                    font-size: 20px;
                }

                .classes-hero p {
                    font-size: 11px;
                }

                .classes-hero-icon {
                    width: 46px;
                    height: 46px;
                    font-size: 20px;
                }

                .btn-add-classe {
                    padding: 10px 12px;
                    font-size: 11px;
                }

                .classes-card {
                    height: calc(100vh - 160px);
                    min-height: 360px;
                }

                .classes-card-header {
                    padding: 15px;
                    align-items: flex-start;
                    flex-direction: column;
                    gap: 13px;
                }

                .classes-search {
                    width: 100%;
                }

                .classes-card-footer {
                    padding: 13px;
                    flex-direction: column;
                    align-items: flex-start;
                }

                .classes-pagination-controls {
                    width: 100%;
                    justify-content: space-between;
                }

                .classes-pagination {
                    max-width: 100%;
                    overflow-x: auto;
                }
            }

            @media (max-width: 480px) {

                .classes-hero-content {
                    flex-direction: column;
                    align-items: stretch;
                }

                .btn-add-classe {
                    width: 100%;
                }

                .classes-pagination-controls {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 12px;
                }
            }
        </style>

        {{-- =====================================================
             BANDEAU PRINCIPAL
        ====================================================== --}}

        <div class="classes-hero">

            <div class="classes-hero-content">

                <div class="classes-hero-left">

                    <div class="classes-hero-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>

                    <div>
                        <h2>Gestion des classes</h2>

                        <p>
                            Consultez et gérez les classes de votre établissement.
                        </p>
                    </div>

                </div>

                @if (auth()->user()->aPermission('classes.creer'))
                    <a href="{{ route('classes.create') }}" class="btn-add-classe">
                        <i class="bi bi-plus-lg"></i>
                        Nouvelle classe
                    </a>
                @endif

            </div>

        </div>

        {{-- =====================================================
             ALERTES
        ====================================================== --}}

        @if (session('success'))
            <div class="alert alert-success classes-alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger classes-alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- =====================================================
             CARTE PRINCIPALE
        ====================================================== --}}

        <div class="classes-card">

            {{-- HEADER --}}

            <div class="classes-card-header">

                <div class="classes-card-title">

                    <h5>
                        <i class="bi bi-list-ul me-2"></i>
                        Liste des classes
                    </h5>

                    <p>
                        Retrouvez toutes les classes enregistrées dans votre établissement.
                    </p>

                </div>

                {{-- RECHERCHE --}}

                <div class="classes-search">

                    <i class="bi bi-search"></i>

                    <input type="text" id="searchClasse" placeholder="Rechercher une classe..." autocomplete="off">

                </div>

            </div>

            {{-- TABLEAU --}}

            <div class="classes-table-wrapper">

                <table class="classes-table">

                    <thead>
                        <tr>
                            <th>Classe</th>
                            <th>Élèves inscrits</th>

                            @if (auth()->user()->aPermission('classes.modifier') || auth()->user()->aPermission('classes.supprimer'))
                                <th width="220">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody id="classesTableBody">

                        @forelse($classes as $classe)
                            <tr class="classe-row">

                                {{-- NOM DE LA CLASSE --}}

                                <td>

                                    <div class="classe-name">

                                        <div class="classe-avatar">
                                            <i class="bi bi-mortarboard-fill"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $classe->nom }}
                                            </strong>

                                            <small>
                                                Classe de l'établissement
                                            </small>
                                        </div>

                                    </div>

                                </td>

                                {{-- NOMBRE D'ÉLÈVES --}}

                                <td>

                                    <span class="classe-eleves-badge">
                                        <i class="bi bi-people-fill"></i>

                                        {{ $classe->eleves_count ?? 0 }}

                                        élève(s)
                                    </span>

                                </td>

                                {{-- ACTIONS --}}

                                @if (auth()->user()->aPermission('classes.modifier') || auth()->user()->aPermission('classes.supprimer'))
                                    <td>

                                        <div class="classe-actions">

                                            @if (auth()->user()->aPermission('classes.modifier'))
                                                <a href="{{ route('classes.edit', $classe) }}"
                                                    class="btn-classe-action btn-classe-edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                    Modifier
                                                </a>
                                            @endif

                                            @if (auth()->user()->aPermission('classes.supprimer'))
                                                <form action="{{ route('classes.destroy', $classe) }}" method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cette classe ?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn-classe-action btn-classe-delete">
                                                        <i class="bi bi-trash3"></i>
                                                        Supprimer
                                                    </button>

                                                </form>
                                            @endif

                                        </div>

                                    </td>
                                @endif

                            </tr>

                        @empty

                            <tr>
                                <td colspan="{{ auth()->user()->aPermission('classes.modifier') || auth()->user()->aPermission('classes.supprimer') ? 3 : 2 }}"
                                    class="classes-empty">
                                    <i class="bi bi-mortarboard"></i>

                                    <strong>Aucune classe enregistrée</strong>

                                    <span>
                                        Les classes ajoutées apparaîtront ici.
                                    </span>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

                {{-- MESSAGE RECHERCHE VIDE --}}

                <div class="classes-no-result" id="classesNoResult">
                    <i class="bi bi-search"></i>
                    Aucune classe ne correspond à votre recherche.
                </div>

            </div>

            {{-- =====================================================
                 FOOTER PAGINATION
            ====================================================== --}}

            @if ($classes->total() > 0)
                <div class="classes-card-footer">

                    <div class="classes-pagination-info">

                        Affichage

                        <strong>{{ $classes->firstItem() }}</strong>

                        à

                        <strong>{{ $classes->lastItem() }}</strong>

                        sur

                        <strong>{{ $classes->total() }}</strong>

                        classe(s)

                    </div>

                    <div class="classes-pagination-controls">

                        {{-- NOMBRE PAR PAGE --}}

                        <form method="GET" action="{{ route('classes.index') }}" class="classes-per-page">

                            <label for="per_page">
                                Afficher
                            </label>

                            <select name="per_page" id="per_page" onchange="this.form.submit()">

                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>
                                    10
                                </option>

                                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>
                                    15
                                </option>

                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>
                                    25
                                </option>

                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>
                                    50
                                </option>

                            </select>

                            <span>par page</span>

                        </form>

                        {{-- NAVIGATION --}}

                        <div class="classes-pagination">
                            {{ $classes->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>

                    </div>

                </div>
            @endif

        </div>

    </div>

    {{-- =====================================================
         RECHERCHE INSTANTANÉE
    ====================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('searchClasse');
            const rows = document.querySelectorAll('.classe-row');
            const noResult = document.getElementById('classesNoResult');

            if (!searchInput) return;

            searchInput.addEventListener('input', function() {

                const searchValue = this.value.toLowerCase().trim();

                let visibleCount = 0;

                rows.forEach(function(row) {

                    const rowText = row.textContent.toLowerCase();

                    const isVisible = rowText.includes(searchValue);

                    row.style.display = isVisible ? '' : 'none';

                    if (isVisible) {
                        visibleCount++;
                    }

                });

                if (noResult) {

                    noResult.style.display =
                        visibleCount === 0 && rows.length > 0 ?
                        'block' :
                        'none';

                }

            });

        });
    </script>

@endsection
