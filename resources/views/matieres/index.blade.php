@extends('layouts.app')

@section('content')

    <div class="matieres-page">

        {{-- EN-TÊTE --}}
        <div class="matieres-hero">
            <div class="matieres-hero-content">
                <div class="matieres-hero-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>

                <div>
                    <span class="matieres-eyebrow">GESTION PÉDAGOGIQUE</span>
                    <h2>Gestion des matières</h2>
                    <p>Consultez et gérez les matières de votre établissement.</p>
                </div>
            </div>

            @if (auth()->user()->aPermission('matieres.creer'))
                <a href="{{ route('matieres.create') }}" class="matieres-add-btn">
                    <i class="bi bi-plus-lg"></i>
                    Ajouter une matière
                </a>
            @endif
        </div>

        {{-- NAVIGATION --}}
        <div class="matieres-breadcrumb">
            <i class="bi bi-house-door"></i>
            <span>Accueil</span>
            <i class="bi bi-chevron-right"></i>
            <strong>Matières</strong>
        </div>

        {{-- ALERTES --}}
        @if (session('success'))
            <div class="matieres-alert success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="matieres-alert danger">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- STATISTIQUES --}}
        <div class="matieres-stats">

            <div class="matieres-stat-card">
                <div class="matieres-stat-icon blue">
                    <i class="bi bi-book-half"></i>
                </div>
                <div class="matieres-stat-content">
                    <span>Total des matières</span>
                    <h3>{{ $matieres->total() }}</h3>
                    <small>Matières enregistrées</small>
                </div>
            </div>

            <div class="matieres-stat-card">
                <div class="matieres-stat-icon purple">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>
                <div class="matieres-stat-content">
                    <span>Classes associées</span>
                    <h3>{{ $matieres->getCollection()->sum(fn($matiere) => $matiere->classes->count()) }}</h3>
                    <small>Associations sur cette page</small>
                </div>
            </div>

            <div class="matieres-stat-card">
                <div class="matieres-stat-icon green">
                    <i class="bi bi-layers-fill"></i>
                </div>
                <div class="matieres-stat-content">
                    <span>Page actuelle</span>
                    <h3>{{ $matieres->currentPage() }}</h3>
                    <small>Sur {{ $matieres->lastPage() }} page(s)</small>
                </div>
            </div>

        </div>

        {{-- TABLEAU --}}
        <div class="matieres-card">

            {{-- HEADER --}}
            <div class="matieres-card-header">
                <div class="matieres-card-title">
                    <div class="matieres-title-icon">
                        <i class="bi bi-list-ul"></i>
                    </div>

                    <div>
                        <h5>Liste des matières</h5>
                        <p>Retrouvez toutes les matières de votre établissement.</p>
                    </div>
                </div>

                <span class="matieres-total-badge">
                    <i class="bi bi-book"></i>
                    {{ $matieres->total() }} matière(s)
                </span>
            </div>

            {{-- RECHERCHE --}}
            <div class="matieres-toolbar">
                <div class="matieres-search-wrapper">
                    <i class="bi bi-search"></i>

                    <input type="text" id="rechercheMatiere" placeholder="Rechercher par code, matière ou classe..."
                        autocomplete="off" aria-label="Rechercher une matière">

                    <button type="button" id="effacerRecherche" title="Effacer la recherche"
                        aria-label="Effacer la recherche">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <span class="matieres-toolbar-info">
                    <i class="bi bi-funnel"></i>
                    Recherche rapide
                </span>
            </div>

            {{-- TABLEAU SCROLLABLE --}}
            <div class="matieres-table-wrapper">
                <table class="matieres-table" id="tableMatieres">

                    <thead>
                        <tr>
                            <th class="col-code">CODE</th>
                            <th class="col-matiere">MATIÈRE</th>
                            <th class="col-classes">CLASSES ASSOCIÉES</th>

                            @if (auth()->user()->aPermission('matieres.modifier') || auth()->user()->aPermission('matieres.supprimer'))
                                <th class="col-actions">ACTIONS</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($matieres as $matiere)
                            <tr class="matiere-row">

                                {{-- CODE --}}
                                <td>
                                    <span class="matiere-code">
                                        <i class="bi bi-hash"></i>
                                        {{ $matiere->code }}
                                    </span>
                                </td>

                                {{-- NOM --}}
                                <td>
                                    <div class="matiere-name-cell">
                                        <div class="matiere-name-icon">
                                            <i class="bi bi-journal-bookmark-fill"></i>
                                        </div>

                                        <div class="matiere-name-info">
                                            <strong>{{ $matiere->nom }}</strong>
                                            <small>Matière pédagogique</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- CLASSES --}}
                                <td>
                                    <div class="matiere-classes">
                                        @forelse($matiere->classes as $classe)
                                            <span class="matiere-class-badge">
                                                <i class="bi bi-people-fill"></i>
                                                {{ $classe->nom }}
                                            </span>
                                        @empty
                                            <span class="matiere-no-class">
                                                <i class="bi bi-dash-circle"></i>
                                                Aucune classe associée
                                            </span>
                                        @endforelse
                                    </div>
                                </td>

                                {{-- ACTIONS --}}
                                @if (auth()->user()->aPermission('matieres.modifier') || auth()->user()->aPermission('matieres.supprimer'))
                                    <td>
                                        <div class="matiere-actions">

                                            @if (auth()->user()->aPermission('matieres.modifier'))
                                                <a href="{{ route('matieres.edit', $matiere) }}"
                                                    class="matiere-action-btn edit" title="Modifier"
                                                    aria-label="Modifier {{ $matiere->nom }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif

                                            @if (auth()->user()->aPermission('matieres.supprimer'))
                                                <form action="{{ route('matieres.destroy', $matiere) }}" method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cette matière ?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="matiere-action-btn delete"
                                                        title="Supprimer" aria-label="Supprimer {{ $matiere->nom }}">
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
                                <td colspan="{{ auth()->user()->aPermission('matieres.modifier') || auth()->user()->aPermission('matieres.supprimer') ? 4 : 3 }}"
                                    class="matieres-empty">

                                    <div class="matieres-empty-icon">
                                        <i class="bi bi-journal-x"></i>
                                    </div>

                                    <h5>Aucune matière enregistrée</h5>

                                    <p>
                                        Les matières de votre établissement apparaîtront ici.
                                    </p>

                                    @if (auth()->user()->aPermission('matieres.creer'))
                                        <a href="{{ route('matieres.create') }}" class="matieres-empty-btn">
                                            <i class="bi bi-plus-lg"></i>
                                            Ajouter une matière
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse

                        {{-- RECHERCHE SANS RÉSULTAT --}}
                        <tr id="aucunResultat" style="display:none;">
                            <td colspan="{{ auth()->user()->aPermission('matieres.modifier') || auth()->user()->aPermission('matieres.supprimer') ? 4 : 3 }}"
                                class="matieres-empty">

                                <div class="matieres-empty-icon">
                                    <i class="bi bi-search"></i>
                                </div>

                                <h5>Aucun résultat trouvé</h5>
                                <p>Essayez avec un autre mot-clé.</p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- FOOTER --}}
            <div class="matieres-card-footer">

                <div class="matieres-pagination-info">
                    @if ($matieres->total() > 0)
                        Affichage de
                        <strong>{{ $matieres->firstItem() }}</strong>
                        à
                        <strong>{{ $matieres->lastItem() }}</strong>
                        sur
                        <strong>{{ $matieres->total() }}</strong>
                        matières
                    @else
                        Aucune matière à afficher
                    @endif
                </div>

                <div class="matieres-pagination-controls">

                    {{-- NOMBRE PAR PAGE --}}
                    <form method="GET" action="{{ route('matieres.index') }}" class="matieres-per-page">

                        <label for="per_page">Afficher</label>

                        <select name="per_page" id="per_page" onchange="this.form.submit()">

                            @foreach ([10, 15, 25, 50] as $nombre)
                                <option value="{{ $nombre }}" {{ (int) $perPage === $nombre ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach

                        </select>

                        <span>par page</span>
                    </form>

                    {{-- PAGINATION --}}
                    <div class="matieres-pagination">
                        {{ $matieres->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>

    </div>


    <style>
        /* =========================================================
       MATIERES - VARIABLES ET BASE
    ========================================================= */

        .matieres-page {
            --mat-bg: #f4f7fc;
            --mat-surface: #ffffff;
            --mat-surface-soft: #f8fafd;
            --mat-text: #263449;
            --mat-heading: #263c58;
            --mat-muted: #8995a6;
            --mat-border: #e8edf4;
            --mat-row-hover: #f5f9ff;
            --mat-primary: #2868aa;
            --mat-primary-soft: #edf4ff;
            --mat-shadow: 0 5px 22px rgba(31, 55, 85, .055);

            padding: 22px 25px 35px;
            color: var(--mat-text);
            min-width: 0;
        }

        /* =========================================================
       HERO
    ========================================================= */

        .matieres-hero {
            background: linear-gradient(115deg, #173b70, #2466a7 65%, #288b9c);
            border-radius: 18px;
            padding: 27px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            color: white;
            box-shadow: 0 9px 25px rgba(26, 74, 125, .17);
        }

        .matieres-hero-content {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
        }

        .matieres-hero-icon {
            width: 62px;
            height: 62px;
            border-radius: 17px;
            background: rgba(255, 255, 255, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
            border: 1px solid rgba(255, 255, 255, .2);
            flex-shrink: 0;
        }

        .matieres-eyebrow {
            font-size: 10px;
            letter-spacing: 2px;
            font-weight: 800;
            opacity: .75;
        }

        .matieres-hero h2 {
            font-size: 24px;
            font-weight: 800;
            margin: 4px 0;
            color: white;
        }

        .matieres-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
        }

        .matieres-add-btn {
            padding: 12px 17px;
            border-radius: 10px;
            background: white;
            color: #245f98;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: .25s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .matieres-add-btn:hover {
            background: #eaf3fc;
            color: #173b70;
            transform: translateY(-2px);
        }

        /* =========================================================
       BREADCRUMB
    ========================================================= */

        .matieres-breadcrumb {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 21px 0;
            font-size: 12px;
            color: var(--mat-muted);
        }

        .matieres-breadcrumb i {
            font-size: 10px;
        }

        .matieres-breadcrumb strong {
            color: var(--mat-primary);
        }

        /* =========================================================
       ALERTES
    ========================================================= */

        .matieres-alert {
            padding: 14px 17px;
            border-radius: 10px;
            margin-bottom: 17px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
        }

        .matieres-alert.success {
            color: #218052;
            background: #eaf8f0;
            border: 1px solid #cdebd9;
        }

        .matieres-alert.danger {
            color: #b93832;
            background: #fff1f0;
            border: 1px solid #f6d2cf;
        }

        /* =========================================================
       STATISTIQUES
    ========================================================= */

        .matieres-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 22px;
        }

        .matieres-stat-card {
            background: var(--mat-surface);
            border: 1px solid var(--mat-border);
            border-radius: 15px;
            padding: 19px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 17px rgba(31, 55, 85, .045);
            transition: .25s;
            min-width: 0;
        }

        .matieres-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(31, 55, 85, .08);
        }

        .matieres-stat-icon {
            width: 49px;
            height: 49px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .matieres-stat-icon.blue {
            color: #347bb9;
            background: #eaf3fc;
        }

        .matieres-stat-icon.purple {
            color: #8666bd;
            background: #f1edfb;
        }

        .matieres-stat-icon.green {
            color: #299769;
            background: #e9f8f0;
        }

        .matieres-stat-content {
            min-width: 0;
        }

        .matieres-stat-card span {
            display: block;
            font-size: 11px;
            color: var(--mat-muted);
            font-weight: 600;
        }

        .matieres-stat-card h3 {
            font-size: 23px;
            font-weight: 800;
            margin: 3px 0;
            color: var(--mat-heading);
        }

        .matieres-stat-card small {
            color: var(--mat-muted);
            opacity: .85;
            font-size: 10px;
        }

        /* =========================================================
       CARTE PRINCIPALE
    ========================================================= */

        .matieres-card {
            height: calc(100vh - 390px);
            min-height: 430px;
            max-height: 650px;
            background: var(--mat-surface);
            border: 1px solid var(--mat-border);
            border-radius: 17px;
            box-shadow: var(--mat-shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* HEADER */

        .matieres-card-header {
            padding: 21px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--mat-border);
            flex-shrink: 0;
        }

        .matieres-card-title {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .matieres-title-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf2fc;
            color: #2868aa;
            font-size: 18px;
            flex-shrink: 0;
        }

        .matieres-card-title h5 {
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 4px;
            color: var(--mat-heading);
        }

        .matieres-card-title p {
            font-size: 11px;
            color: var(--mat-muted);
            margin: 0;
        }

        .matieres-total-badge {
            background: var(--mat-primary-soft);
            color: var(--mat-primary);
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================================================
       RECHERCHE
    ========================================================= */

        .matieres-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 24px;
            border-bottom: 1px solid var(--mat-border);
            flex-shrink: 0;
        }

        .matieres-search-wrapper {
            display: flex;
            align-items: center;
            width: min(450px, 100%);
            height: 41px;
            padding: 0 12px;
            border: 1px solid var(--mat-border);
            background: var(--mat-surface-soft);
            border-radius: 9px;
            transition: .25s;
        }

        .matieres-search-wrapper:focus-within {
            border-color: #4387cb;
            background: var(--mat-surface);
            box-shadow: 0 0 0 3px rgba(67, 135, 203, .09);
        }

        .matieres-search-wrapper>i {
            color: var(--mat-muted);
            font-size: 13px;
            margin-right: 10px;
        }

        .matieres-search-wrapper input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 11px;
            color: var(--mat-text);
            min-width: 0;
        }

        .matieres-search-wrapper input::placeholder {
            color: var(--mat-muted);
            opacity: .8;
        }

        .matieres-search-wrapper button {
            border: none;
            background: transparent;
            color: var(--mat-muted);
            cursor: pointer;
            display: none;
            padding: 5px;
            flex-shrink: 0;
        }

        .matieres-search-wrapper button:hover {
            color: #dc5555;
        }

        .matieres-toolbar-info {
            color: var(--mat-muted);
            font-size: 11px;
            white-space: nowrap;
        }

        .matieres-toolbar-info i {
            color: #4387cb;
            margin-right: 5px;
        }

        /* =========================================================
       TABLEAU SCROLLABLE
    ========================================================= */

        .matieres-table-wrapper {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: auto;
            position: relative;
        }

        .matieres-table-wrapper::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        .matieres-table-wrapper::-webkit-scrollbar-track {
            background: var(--mat-surface-soft);
        }

        .matieres-table-wrapper::-webkit-scrollbar-thumb {
            background: #c6d2e0;
            border-radius: 10px;
        }

        .matieres-table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #8fa5bd;
        }

        .matieres-table {
            width: 100%;
            min-width: 720px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .matieres-table thead {
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .matieres-table thead th {
            background: var(--mat-surface-soft);
            color: var(--mat-muted);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .7px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--mat-border);
            white-space: nowrap;
        }

        .matieres-table tbody td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--mat-border);
            vertical-align: middle;
            background: var(--mat-surface);
            transition: background .2s;
        }

        .matieres-table tbody tr {
            transition: .2s;
        }

        .matieres-table tbody tr:hover td {
            background: var(--mat-row-hover);
        }

        .matieres-table tbody tr:last-child td {
            border-bottom: none;
        }

        .col-code {
            width: 155px;
        }

        .col-matiere {
            min-width: 190px;
        }

        .col-classes {
            min-width: 240px;
        }

        .col-actions {
            width: 120px;
            text-align: center;
        }

        /* CODE */

        .matiere-code {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--mat-primary-soft);
            color: var(--mat-primary);
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 800;
        }

        .matiere-code i {
            font-size: 9px;
            opacity: .7;
        }

        /* NOM */

        .matiere-name-cell {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .matiere-name-icon {
            width: 38px;
            height: 38px;
            background: var(--mat-surface-soft);
            color: #4781b7;
            border: 1px solid var(--mat-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .matiere-name-info strong {
            display: block;
            font-size: 12px;
            color: var(--mat-heading);
        }

        .matiere-name-info small {
            display: block;
            font-size: 10px;
            color: var(--mat-muted);
            margin-top: 4px;
        }

        /* CLASSES */

        .matiere-classes {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            max-width: 360px;
        }

        .matiere-class-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 9px;
            background: #f0f8f5;
            color: #368668;
            border: 1px solid #dcefe6;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
        }

        .matiere-class-badge i {
            font-size: 9px;
        }

        .matiere-no-class {
            color: var(--mat-muted);
            font-size: 10px;
        }

        /* =========================================================
       ACTIONS
    ========================================================= */

        .matiere-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .matiere-actions form {
            margin: 0;
        }

        .matiere-action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 9px;
            text-decoration: none;
            cursor: pointer;
            transition: .2s;
        }

        .matiere-action-btn.edit {
            background: #fff5df;
            color: #c18c27;
        }

        .matiere-action-btn.edit:hover {
            background: #f7e6bd;
            transform: translateY(-2px);
        }

        .matiere-action-btn.delete {
            background: #fff0ef;
            color: #d75c56;
        }

        .matiere-action-btn.delete:hover {
            background: #fbdad8;
            transform: translateY(-2px);
        }

        /* =========================================================
       ÉTAT VIDE
    ========================================================= */

        .matieres-empty {
            text-align: center;
            padding: 45px 20px !important;
        }

        .matieres-empty-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            background: var(--mat-surface-soft);
            color: #8ba3bd;
            border: 1px solid var(--mat-border);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .matieres-empty h5 {
            font-size: 15px;
            font-weight: 800;
            color: var(--mat-heading);
        }

        .matieres-empty p {
            color: var(--mat-muted);
            font-size: 11px;
        }

        .matieres-empty-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 8px;
            background: var(--mat-primary);
            color: white;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
        }

        .matieres-empty-btn:hover {
            filter: brightness(1.1);
            color: white;
            transform: translateY(-2px);
        }

        /* =========================================================
       FOOTER ET PAGINATION
    ========================================================= */

        .matieres-card-footer {
            padding: 15px 22px;
            border-top: 1px solid var(--mat-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
            background: var(--mat-surface);
        }

        .matieres-pagination-info {
            font-size: 11px;
            color: var(--mat-muted);
        }

        .matieres-pagination-info strong {
            color: var(--mat-heading);
        }

        .matieres-pagination-controls {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .matieres-per-page {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            color: var(--mat-muted);
            white-space: nowrap;
            margin: 0;
        }

        .matieres-per-page select {
            border: 1px solid var(--mat-border);
            border-radius: 7px;
            padding: 6px 9px;
            background: var(--mat-surface-soft);
            color: var(--mat-text);
            outline: none;
            font-size: 11px;
        }

        .matieres-per-page select:focus {
            border-color: var(--mat-primary);
        }

        .matieres-pagination nav {
            margin: 0;
        }

        .matieres-pagination .pagination {
            margin: 0;
            gap: 4px;
        }

        .matieres-pagination .page-link {
            border: 1px solid var(--mat-border);
            border-radius: 7px !important;
            color: var(--mat-text);
            background: var(--mat-surface);
            font-size: 11px;
            padding: 7px 10px;
        }

        .matieres-pagination .page-item.active .page-link {
            background: var(--mat-primary);
            border-color: var(--mat-primary);
            color: white;
        }

        .matieres-pagination .page-link:hover {
            background: var(--mat-primary-soft);
            color: var(--mat-primary);
        }

        /* =========================================================
       MODE SOMBRE
    ========================================================= */

        html[data-app-theme="dark"] .matieres-page {
            --mat-bg: #111827;
            --mat-surface: #1b2637;
            --mat-surface-soft: #222f42;
            --mat-text: #dce5f1;
            --mat-heading: #f0f5fc;
            --mat-muted: #a0aec0;
            --mat-border: #344257;
            --mat-row-hover: #26364c;
            --mat-primary: #76b8f5;
            --mat-primary-soft: #263e59;
            --mat-shadow: 0 6px 24px rgba(0, 0, 0, .2);
        }

        html[data-app-theme="dark"] .matieres-hero {
            background: linear-gradient(115deg, #14243c, #1d456b 65%, #17616a);
            border: 1px solid rgba(148, 190, 230, .13);
        }

        html[data-app-theme="dark"] .matieres-stat-icon.blue,
        html[data-app-theme="dark"] .matieres-title-icon {
            background: #263e59;
            color: #83bdf2;
        }

        html[data-app-theme="dark"] .matieres-stat-icon.purple {
            background: #39304f;
            color: #c1a4f2;
        }

        html[data-app-theme="dark"] .matieres-stat-icon.green {
            background: #1e4439;
            color: #75d5a9;
        }

        html[data-app-theme="dark"] .matieres-class-badge {
            background: #1e4038;
            color: #8de0ba;
            border-color: #315c4e;
        }

        html[data-app-theme="dark"] .matiere-action-btn.edit {
            background: #493d26;
            color: #f0c36b;
        }

        html[data-app-theme="dark"] .matiere-action-btn.delete {
            background: #492d31;
            color: #ff9994;
        }

        html[data-app-theme="dark"] .matieres-alert.success {
            background: #193c30;
            border-color: #2d604a;
            color: #8ce0b3;
        }

        html[data-app-theme="dark"] .matieres-alert.danger {
            background: #462a2d;
            border-color: #714044;
            color: #ffaaa5;
        }

        html[data-app-theme="dark"] .matieres-empty-icon {
            color: #9bb5d2;
        }

        html[data-app-theme="dark"] .matieres-search-wrapper:focus-within {
            background: #1b2637;
        }

        html[data-app-theme="dark"] .matieres-pagination .page-link:hover {
            background: #304863;
            color: #a9d3fa;
        }

        html[data-app-theme="dark"] .matieres-table-wrapper::-webkit-scrollbar-track {
            background: #1b2637;
        }

        html[data-app-theme="dark"] .matieres-table-wrapper::-webkit-scrollbar-thumb {
            background: #52647b;
        }

        /* =========================================================
       MODE ULTRA PRO
    ========================================================= */

        html[data-app-theme="ultra-pro"] .matieres-page {
            --mat-surface: #111d31;
            --mat-surface-soft: #17263d;
            --mat-text: #dbe8f7;
            --mat-heading: #f3f8ff;
            --mat-muted: #91a5bf;
            --mat-border: #293d59;
            --mat-row-hover: #1b304b;
            --mat-primary: #56b9f5;
            --mat-primary-soft: #1d3c5b;
            --mat-shadow: 0 8px 30px rgba(0, 0, 0, .22);
        }

        html[data-app-theme="ultra-pro"] .matieres-hero {
            background: linear-gradient(115deg, #09182d, #123d66 60%, #087c89);
            border: 1px solid rgba(91, 190, 255, .18);
            box-shadow: 0 12px 30px rgba(0, 30, 65, .25);
        }

        html[data-app-theme="ultra-pro"] .matieres-title-icon,
        html[data-app-theme="ultra-pro"] .matieres-stat-icon.blue {
            background: #1c3c5e;
            color: #72c5ff;
        }

        html[data-app-theme="ultra-pro"] .matieres-stat-icon.purple {
            background: #392f59;
            color: #c2a5ff;
        }

        html[data-app-theme="ultra-pro"] .matieres-stat-icon.green {
            background: #1c493e;
            color: #78e2b4;
        }

        html[data-app-theme="ultra-pro"] .matieres-class-badge {
            background: #1a403a;
            border-color: #2a6255;
            color: #8be5c2;
        }

        html[data-app-theme="ultra-pro"] .matieres-alert.success {
            background: #193c30;
            border-color: #2d604a;
            color: #8ce0b3;
        }

        html[data-app-theme="ultra-pro"] .matieres-alert.danger {
            background: #462a2d;
            border-color: #714044;
            color: #ffaaa5;
        }

        html[data-app-theme="ultra-pro"] .matiere-action-btn.edit {
            background: #493d26;
            color: #f0c36b;
        }

        html[data-app-theme="ultra-pro"] .matiere-action-btn.delete {
            background: #492d31;
            color: #ff9994;
        }

        html[data-app-theme="ultra-pro"] .matieres-table-wrapper::-webkit-scrollbar-track {
            background: #111d31;
        }

        html[data-app-theme="ultra-pro"] .matieres-table-wrapper::-webkit-scrollbar-thumb {
            background: #405979;
        }

        /* =========================================================
       THÈME EMERALD
    ========================================================= */

        html[data-app-theme="emerald"] .matieres-page {
            --mat-primary: #168568;
            --mat-primary-soft: #e6f6f0;
        }

        html[data-app-theme="emerald"] .matieres-hero {
            background: linear-gradient(115deg, #075b4a, #13866b 65%, #36a58a);
        }

        /* =========================================================
       THÈME WARM
    ========================================================= */

        html[data-app-theme="warm"] .matieres-page {
            --mat-primary: #a66a35;
            --mat-primary-soft: #fbf0e4;
        }

        html[data-app-theme="warm"] .matieres-hero {
            background: linear-gradient(115deg, #70452e, #a66a35 65%, #c28b56);
        }

        /* =========================================================
       RESPONSIVE
    ========================================================= */

        @media (max-width: 1000px) {
            .matieres-card {
                height: calc(100vh - 370px);
                min-height: 400px;
            }

            .matieres-card-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .matieres-pagination-controls {
                width: 100%;
                justify-content: space-between;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 700px) {
            .matieres-page {
                padding: 13px;
            }

            .matieres-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 21px;
            }

            .matieres-hero h2 {
                font-size: 19px;
            }

            .matieres-hero-icon {
                width: 49px;
                height: 49px;
                font-size: 21px;
            }

            .matieres-add-btn {
                width: 100%;
            }

            .matieres-stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .matieres-card {
                height: 600px;
                max-height: calc(100vh - 250px);
                min-height: 430px;
            }

            .matieres-card-header {
                padding: 17px;
            }

            .matieres-total-badge {
                font-size: 10px;
                padding: 7px 9px;
            }

            .matieres-toolbar {
                padding: 13px 17px;
                align-items: flex-start;
                flex-direction: column;
            }

            .matieres-search-wrapper {
                width: 100%;
            }

            .matieres-toolbar-info {
                display: none;
            }

            .matieres-card-footer {
                padding: 14px;
            }

            .matieres-pagination-controls {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }

            .matieres-pagination {
                max-width: 100%;
                overflow-x: auto;
            }
        }

        @media (max-width: 420px) {
            .matieres-hero-content {
                align-items: flex-start;
                gap: 12px;
            }

            .matieres-hero h2 {
                font-size: 17px;
            }

            .matieres-card-title p {
                max-width: 190px;
            }

            .matieres-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .matieres-total-badge {
                align-self: flex-start;
            }

            .matieres-pagination-info {
                line-height: 1.8;
            }
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const recherche = document.getElementById('rechercheMatiere');
            const effacer = document.getElementById('effacerRecherche');
            const lignes = document.querySelectorAll('.matiere-row');
            const aucunResultat = document.getElementById('aucunResultat');

            if (!recherche) return;

            function filtrerMatieres() {

                const terme = recherche.value.toLowerCase().trim();

                let resultat = 0;

                lignes.forEach(function(ligne) {

                    const correspond = ligne.textContent
                        .toLowerCase()
                        .includes(terme);

                    ligne.style.display = correspond ? '' : 'none';

                    if (correspond) resultat++;

                });

                if (aucunResultat) {
                    aucunResultat.style.display =
                        resultat === 0 && lignes.length > 0 ? '' : 'none';
                }

                if (effacer) {
                    effacer.style.display = terme ? 'block' : 'none';
                }
            }

            recherche.addEventListener('input', filtrerMatieres);

            if (effacer) {
                effacer.addEventListener('click', function() {
                    recherche.value = '';
                    filtrerMatieres();
                    recherche.focus();
                });
            }

        });
    </script>

@endsection
