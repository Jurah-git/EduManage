@extends('layouts.app')

@section('content')

    <style>
        /* =====================================================
       CLASSES - PAGE PRINCIPALE
    ===================================================== */

        .classes-page {
            padding: 20px 24px;
            color: #26364d;
        }

        /* =====================================================
       BANDEAU PRINCIPAL
    ===================================================== */

        .classes-hero {
            position: relative;
            overflow: hidden;
            padding: 23px 27px;
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
            font-size: 25px;
        }

        .classes-hero h2 {
            margin: 0 0 5px;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .classes-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
        }

        .btn-add-classe {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 11px 17px;
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
            padding: 12px 16px;
            border: none;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        /* =====================================================
       CARTE DU TABLEAU
    ===================================================== */

        .classes-card {
            height: calc(100vh - 180px);
            min-height: 380px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #fff;
            border: 1px solid #edf0f5;
            border-radius: 17px;
            box-shadow: 0 5px 22px rgba(31, 45, 61, .045);
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
            border-bottom: 1px solid #edf0f5;
            background: #fff;
        }

        .classes-card-title h5 {
            margin: 0 0 5px;
            color: #25364d;
            font-size: 16px;
            font-weight: 800;
        }

        .classes-card-title p {
            margin: 0;
            color: #8994a5;
            font-size: 12px;
        }

        /* =====================================================
       RECHERCHE
    ===================================================== */

        .classes-search {
            position: relative;
            width: 260px;
            max-width: 100%;
        }

        .classes-search input {
            width: 100%;
            height: 39px;
            padding: 0 13px 0 38px;
            border: 1px solid #e5eaf1;
            border-radius: 10px;
            outline: none;
            background: #f8fafd;
            color: #34445b;
            font-size: 12px;
            transition: .2s;
        }

        .classes-search input:focus {
            border-color: #38a5d0;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(56, 165, 208, .10);
        }

        .classes-search i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa6b6;
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
            scrollbar-color: #cbd5e1 #f5f7fa;
        }

        .classes-table-wrapper::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        .classes-table-wrapper::-webkit-scrollbar-track {
            background: #f5f7fa;
        }

        .classes-table-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
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
            padding: 14px 20px;
            background: #f7f9fc;
            color: #7d899a;
            border-bottom: 1px solid #e9edf3;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .7px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .classes-table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f2f6;
            background: #fff;
        }

        .classes-table tbody tr {
            transition: background .2s;
        }

        .classes-table tbody tr:hover td {
            background: #f8fbff;
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
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 11px;
            background: #edf5ff;
            color: #1765a9;
            font-size: 16px;
        }

        .classe-name strong {
            display: block;
            color: #293a50;
            font-size: 13px;
            font-weight: 800;
        }

        /* =====================================================
       BADGE ELEVES
    ===================================================== */

        .classe-eleves-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            border-radius: 8px;
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

        .btn-classe-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 8px;
            border: none;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s;
            cursor: pointer;
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
            padding: 55px 20px !important;
            text-align: center;
            color: #9aa5b5;
        }

        .classes-empty i {
            display: block;
            margin-bottom: 12px;
            font-size: 34px;
            color: #cbd5e1;
        }

        .classes-empty strong {
            display: block;
            margin-bottom: 5px;
            color: #526176;
            font-size: 14px;
        }

        .classes-empty span {
            font-size: 12px;
        }

        /* =====================================================
       AUCUN RESULTAT RECHERCHE
    ===================================================== */

        .classes-no-result {
            display: none;
            padding: 35px 15px;
            text-align: center;
            color: #8994a5;
            font-size: 13px;
        }

        /* =====================================================
       FOOTER PAGINATION
    ===================================================== */

        .classes-card-footer {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            padding: 14px 22px;
            background: #fff;
            border-top: 1px solid #edf0f5;
        }

        .classes-pagination-info {
            color: #8490a3;
            font-size: 11px;
            font-weight: 600;
        }

        .classes-pagination-info strong {
            color: #26364d;
            font-weight: 800;
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
            color: #8490a3;
            font-size: 11px;
            font-weight: 600;
        }

        .classes-per-page select {
            padding: 6px 10px;
            border: 1px solid #e4e9f1;
            border-radius: 8px;
            background: #f8f9fc;
            color: #34445b;
            font-size: 11px;
            font-weight: 700;
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
            padding: 6px 10px;
            border: 1px solid #e8edf4;
            border-radius: 8px !important;
            background: #fff;
            color: #52637b;
            font-size: 11px;
            font-weight: 700;
        }

        .classes-pagination .page-item.active .page-link {
            border-color: #1765a9;
            background: #1765a9;
            color: #fff;
        }

        .classes-pagination .page-item.disabled .page-link {
            background: #f8f9fc;
            color: #bdc5d0;
        }

        /* =====================================================
       RESPONSIVE
    ===================================================== */

        @media (max-width: 768px) {

            .classes-page {
                padding: 14px;
            }

            .classes-hero {
                padding: 18px;
            }

            .classes-hero-content {
                align-items: flex-start;
            }

            .classes-hero h2 {
                font-size: 20px;
            }

            .classes-hero p {
                font-size: 11px;
            }

            .classes-hero-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }

            .btn-add-classe {
                padding: 9px 11px;
                font-size: 11px;
            }

            .classes-card {
                height: calc(100vh - 150px);
                min-height: 350px;
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


    <div class="classes-page">

        {{-- =====================================================
         BANDEAU PRINCIPAL
    ====================================================== --}}

        <div class="classes-hero">

            <div class="classes-hero-content">

                <div class="classes-hero-left">

                    <div class="classes-hero-icon">
                        <i class="fas fa-school"></i>
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

                        <i class="fas fa-plus"></i>
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
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger classes-alert">
                <i class="fas fa-exclamation-circle me-2"></i>
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
                        <i class="fas fa-list-ul me-2 text-primary"></i>
                        Liste des classes
                    </h5>

                    <p>
                        Retrouvez toutes les classes enregistrées dans votre établissement.
                    </p>

                </div>


                {{-- RECHERCHE --}}

                <div class="classes-search">

                    <i class="fas fa-search"></i>

                    <input type="text" id="searchClasse" placeholder="Rechercher une classe..." autocomplete="off">

                </div>

            </div>


            {{-- TABLEAU SCROLLABLE --}}

            <div class="classes-table-wrapper">

                <table class="classes-table">

                    <thead>

                        <tr>

                            <th>CLASSE</th>

                            <th>ÉLÈVES INSCRITS</th>

                            @if (auth()->user()->aPermission('classes.modifier') || auth()->user()->aPermission('classes.supprimer'))
                                <th width="220">ACTIONS</th>
                            @endif

                        </tr>

                    </thead>


                    <tbody id="classesTableBody">

                        @forelse($classes as $classe)
                            <tr class="classe-row">

                                {{-- NOM CLASSE --}}

                                <td>

                                    <div class="classe-name">

                                        <div class="classe-avatar">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>

                                        <strong>
                                            {{ $classe->nom }}
                                        </strong>

                                    </div>

                                </td>


                                {{-- NOMBRE D'ELEVES --}}

                                <td>

                                    <span class="classe-eleves-badge">

                                        <i class="fas fa-user-graduate"></i>

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

                                                    <i class="fas fa-pen"></i>
                                                    Modifier

                                                </a>
                                            @endif


                                            @if (auth()->user()->aPermission('classes.supprimer'))
                                                <form action="{{ route('classes.destroy', $classe) }}" method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cette classe ?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn-classe-action btn-classe-delete">

                                                        <i class="fas fa-trash-alt"></i>
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

                                <td colspan="3" class="classes-empty">

                                    <i class="fas fa-school"></i>

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

                    <i class="fas fa-search me-2"></i>

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
     RECHERCHE INSTANTANEE
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
