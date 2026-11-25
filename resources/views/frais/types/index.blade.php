@extends('layouts.app')

@section('content')

    <div class="types-page">

        {{-- HERO --}}
        <div class="types-hero">
            <div class="types-hero-content">
                <div class="types-hero-icon">
                    <i class="bi bi-tags-fill"></i>
                </div>
                <div>
                    <span class="types-eyebrow">GESTION FINANCIÈRE</span>
                    <h2>Types de frais scolaires</h2>
                    <p>Configurez et gérez les différentes catégories de frais de votre établissement.</p>
                </div>
            </div>

            @if (auth()->user()->aPermission('frais.types_creer'))
                <a href="{{ route('frais.types.create') }}" class="types-add-btn">
                    <i class="bi bi-plus-lg"></i>
                    Ajouter un type de frais
                </a>
            @endif
        </div>

        {{-- BREADCRUMB --}}
        <div class="types-breadcrumb">
            <i class="bi bi-house-door"></i>
            <span>Accueil</span>
            <i class="bi bi-chevron-right"></i>
            <span>Gestion financière</span>
            <i class="bi bi-chevron-right"></i>
            <strong>Types de frais</strong>
        </div>

        {{-- ALERTES --}}
        @if (session('success'))
            <div class="types-alert success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="types-alert danger">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="types-alert danger">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>
                    @foreach ($errors->all() as $erreur)
                        <div>{{ $erreur }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- STATISTIQUES --}}
        <div class="types-stats">

            <div class="types-stat-card">
                <div class="types-stat-icon blue">
                    <i class="bi bi-tags-fill"></i>
                </div>
                <div class="types-stat-content">
                    <span>Total des types</span>
                    <h3>{{ $totalTypes }}</h3>
                    <small>Catégories enregistrées</small>
                </div>
            </div>

            <div class="types-stat-card">
                <div class="types-stat-icon green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="types-stat-content">
                    <span>Types actifs</span>
                    <h3>{{ $totalActifs }}</h3>
                    <small>Disponibles pour les tarifs</small>
                </div>
            </div>

            <div class="types-stat-card">
                <div class="types-stat-icon purple">
                    <i class="bi bi-pause-circle-fill"></i>
                </div>
                <div class="types-stat-content">
                    <span>Types inactifs</span>
                    <h3>{{ $totalInactifs }}</h3>
                    <small>Catégories désactivées</small>
                </div>
            </div>

        </div>

        {{-- CARTE PRINCIPALE --}}
        <div class="types-card">

            {{-- HEADER --}}
            <div class="types-card-header">
                <div class="types-card-title">
                    <div class="types-title-icon">
                        <i class="bi bi-list-ul"></i>
                    </div>
                    <div>
                        <h5>Liste des types de frais</h5>
                        <p>Retrouvez toutes les catégories de frais de votre établissement.</p>
                    </div>
                </div>

                <span class="types-total-badge">
                    <i class="bi bi-collection"></i>
                    {{ $types->total() }} type(s)
                </span>
            </div>

            {{-- RECHERCHE ET FILTRES --}}
            <div class="types-toolbar">

                <form action="{{ route('frais.types.index') }}" method="GET" class="types-filter-form">

                    <div class="types-search-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" name="recherche" id="rechercheType" value="{{ $recherche }}"
                            placeholder="Rechercher un nom ou une description..." autocomplete="off">

                        <button type="button" id="effacerRecherche" title="Effacer la recherche">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="types-filter-group">

                        <select name="frequence" class="types-select" aria-label="Filtrer par fréquence">
                            <option value="">Toutes les fréquences</option>
                            <option value="unique" @selected($frequence === 'unique')>Unique</option>
                            <option value="mensuelle" @selected($frequence === 'mensuelle')>Mensuelle</option>
                            <option value="trimestrielle" @selected($frequence === 'trimestrielle')>Trimestrielle</option>
                            <option value="annuelle" @selected($frequence === 'annuelle')>Annuelle</option>
                        </select>

                        <select name="statut" class="types-select" aria-label="Filtrer par statut">
                            <option value="">Tous les statuts</option>
                            <option value="actif" @selected($statut === 'actif')>Actif</option>
                            <option value="inactif" @selected($statut === 'inactif')>Inactif</option>
                        </select>

                        <button type="submit" class="types-filter-btn">
                            <i class="bi bi-funnel-fill"></i>
                            Filtrer
                        </button>

                        <a href="{{ route('frais.types.index') }}" class="types-reset-btn" title="Réinitialiser">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>

                    </div>

                </form>

                <div class="types-toolbar-info">
                    <i class="bi bi-info-circle"></i>
                    Recherche et filtres avancés
                </div>
            </div>

            {{-- TABLEAU --}}
            <div class="types-table-wrapper">

                <table class="types-table">

                    <thead>
                        <tr>
                            <th class="col-number">N°</th>
                            <th class="col-name">NOM DU FRAIS</th>
                            <th class="col-description">DESCRIPTION</th>
                            <th class="col-frequency">FRÉQUENCE</th>
                            <th class="col-status">STATUT</th>

                            @if (auth()->user()->aPermission('frais.types_voir') ||
                                    auth()->user()->aPermission('frais.types_modifier') ||
                                    auth()->user()->aPermission('frais.types_supprimer'))
                                <th class="col-actions">ACTIONS</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($types as $type)
                            <tr class="type-row">

                                <td>
                                    <span class="type-number">
                                        {{ $types->firstItem() + $loop->index }}
                                    </span>
                                </td>

                                {{-- NOM --}}
                                <td>
                                    <div class="type-name-cell">
                                        <div class="type-name-icon">
                                            <i class="bi bi-tag-fill"></i>
                                        </div>
                                        <div class="type-name-info">
                                            <strong>{{ $type->nom }}</strong>
                                            <small>Catégorie de frais</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- DESCRIPTION --}}
                                <td>
                                    <span class="type-description">
                                        {{ $type->description ?: 'Aucune description' }}
                                    </span>
                                </td>

                                {{-- FREQUENCE --}}
                                <td>
                                    @php
                                        $frequences = [
                                            'unique' => ['Frais unique', 'unique'],
                                            'mensuelle' => ['Mensuelle', 'mensuelle'],
                                            'trimestrielle' => ['Trimestrielle', 'trimestrielle'],
                                            'annuelle' => ['Annuelle', 'annuelle'],
                                        ];

                                        $frequenceInfo = $frequences[$type->frequence] ?? [$type->frequence, 'autre'];
                                    @endphp

                                    <span class="type-frequency {{ $frequenceInfo[1] }}">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $frequenceInfo[0] }}
                                    </span>
                                </td>

                                {{-- STATUT --}}
                                <td>
                                    @if ($type->actif)
                                        <span class="type-status active">
                                            <span class="status-dot"></span>
                                            Actif
                                        </span>
                                    @else
                                        <span class="type-status inactive">
                                            <span class="status-dot"></span>
                                            Inactif
                                        </span>
                                    @endif
                                </td>

                                {{-- ACTIONS --}}
                                @if (auth()->user()->aPermission('frais.types_voir') ||
                                        auth()->user()->aPermission('frais.types_modifier') ||
                                        auth()->user()->aPermission('frais.types_supprimer'))
                                    <td>
                                        <div class="type-actions">

                                            @if (auth()->user()->aPermission('frais.types_voir'))
                                                <a href="{{ route('frais.types.show', $type->id) }}"
                                                    class="type-action-btn view" title="Consulter">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                            @endif

                                            @if (auth()->user()->aPermission('frais.types_modifier'))
                                                <a href="{{ route('frais.types.edit', $type->id) }}"
                                                    class="type-action-btn edit" title="Modifier">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif

                                            @if (auth()->user()->aPermission('frais.types_supprimer'))
                                                <form action="{{ route('frais.types.destroy', $type->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer ce type de frais ?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="type-action-btn delete"
                                                        title="Supprimer">
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
                                <td colspan="{{ auth()->user()->aPermission('frais.types_voir') ||
                                auth()->user()->aPermission('frais.types_modifier') ||
                                auth()->user()->aPermission('frais.types_supprimer')
                                    ? 6
                                    : 5 }}"
                                    class="types-empty">

                                    <div class="types-empty-icon">
                                        <i class="bi bi-tags"></i>
                                    </div>

                                    <h5>Aucun type de frais trouvé</h5>
                                    <p>Les types de frais de votre établissement apparaîtront ici.</p>

                                    @if (auth()->user()->aPermission('frais.types_creer'))
                                        <a href="{{ route('frais.types.create') }}" class="types-empty-btn">
                                            <i class="bi bi-plus-lg"></i>
                                            Ajouter un type de frais
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>

            {{-- FOOTER --}}
            <div class="types-card-footer">

                <div class="types-pagination-info">
                    @if ($types->total() > 0)
                        Affichage de
                        <strong>{{ $types->firstItem() }}</strong>
                        à
                        <strong>{{ $types->lastItem() }}</strong>
                        sur
                        <strong>{{ $types->total() }}</strong>
                        type(s)
                    @else
                        Aucun type à afficher
                    @endif
                </div>

                <div class="types-pagination">
                    {{ $types->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>

    </div>

    <style>
        /* =====================================================
       BASE
    ===================================================== */

        .types-page {
            --typ-surface: #ffffff;
            --typ-surface-soft: #f8fafd;
            --typ-text: #29394e;
            --typ-heading: #263c58;
            --typ-muted: #8995a6;
            --typ-border: #e8edf4;
            --typ-hover: #f4f8fd;
            --typ-primary: #2868aa;
            --typ-primary-soft: #edf4ff;
            --typ-shadow: 0 5px 22px rgba(31, 55, 85, .055);

            padding: 22px 25px 35px;
            color: var(--typ-text);
            min-width: 0;
        }

        /* =====================================================
       HERO
    ===================================================== */

        .types-hero {
            background: linear-gradient(115deg, #173b70, #2466a7 65%, #288b9c);
            border-radius: 18px;
            padding: 27px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            color: #fff;
            box-shadow: 0 9px 25px rgba(26, 74, 125, .17);
        }

        .types-hero-content {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
        }

        .types-hero-icon {
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

        .types-eyebrow {
            font-size: 10px;
            letter-spacing: 2px;
            font-weight: 800;
            opacity: .75;
        }

        .types-hero h2 {
            font-size: 24px;
            font-weight: 800;
            margin: 4px 0;
            color: #fff;
        }

        .types-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
        }

        .types-add-btn {
            padding: 12px 17px;
            border-radius: 10px;
            background: #fff;
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

        .types-add-btn:hover {
            background: #eaf3fc;
            color: #173b70;
            transform: translateY(-2px);
        }

        /* =====================================================
       BREADCRUMB
    ===================================================== */

        .types-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 11px;
            margin: 21px 0;
            font-size: 12px;
            color: var(--typ-muted);
        }

        .types-breadcrumb i {
            font-size: 10px;
        }

        .types-breadcrumb strong {
            color: var(--typ-primary);
        }

        /* =====================================================
       ALERTES
    ===================================================== */

        .types-alert {
            padding: 14px 17px;
            border-radius: 10px;
            margin-bottom: 17px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
        }

        .types-alert.success {
            color: #218052;
            background: #eaf8f0;
            border: 1px solid #cdebd9;
        }

        .types-alert.danger {
            color: #b93832;
            background: #fff1f0;
            border: 1px solid #f6d2cf;
        }

        /* =====================================================
       STATISTIQUES
    ===================================================== */

        .types-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 22px;
        }

        .types-stat-card {
            background: var(--typ-surface);
            border: 1px solid var(--typ-border);
            border-radius: 15px;
            padding: 19px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 17px rgba(31, 55, 85, .045);
            transition: .25s;
            min-width: 0;
        }

        .types-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(31, 55, 85, .08);
        }

        .types-stat-icon {
            width: 49px;
            height: 49px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .types-stat-icon.blue {
            color: #347bb9;
            background: #eaf3fc;
        }

        .types-stat-icon.green {
            color: #299769;
            background: #e9f8f0;
        }

        .types-stat-icon.purple {
            color: #8666bd;
            background: #f1edfb;
        }

        .types-stat-content {
            min-width: 0;
        }

        .types-stat-content span {
            display: block;
            font-size: 11px;
            color: var(--typ-muted);
            font-weight: 600;
        }

        .types-stat-content h3 {
            font-size: 23px;
            font-weight: 800;
            margin: 3px 0;
            color: var(--typ-heading);
        }

        .types-stat-content small {
            color: var(--typ-muted);
            font-size: 10px;
        }

        /* =====================================================
       CARTE PRINCIPALE
    ===================================================== */

        .types-card {
            height: calc(100vh - 390px);
            min-height: 430px;
            max-height: 680px;
            background: var(--typ-surface);
            border: 1px solid var(--typ-border);
            border-radius: 17px;
            box-shadow: var(--typ-shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* HEADER */

        .types-card-header {
            padding: 21px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--typ-border);
            flex-shrink: 0;
        }

        .types-card-title {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .types-title-icon {
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

        .types-card-title h5 {
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 4px;
            color: var(--typ-heading);
        }

        .types-card-title p {
            font-size: 11px;
            color: var(--typ-muted);
            margin: 0;
        }

        .types-total-badge {
            background: var(--typ-primary-soft);
            color: var(--typ-primary);
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =====================================================
       RECHERCHE ET FILTRES
    ===================================================== */

        .types-toolbar {
            padding: 15px 24px;
            border-bottom: 1px solid var(--typ-border);
            flex-shrink: 0;
        }

        .types-filter-form {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .types-search-wrapper {
            display: flex;
            align-items: center;
            width: min(360px, 100%);
            height: 41px;
            padding: 0 12px;
            border: 1px solid var(--typ-border);
            background: var(--typ-surface-soft);
            border-radius: 9px;
            transition: .25s;
        }

        .types-search-wrapper:focus-within {
            border-color: #4387cb;
            background: var(--typ-surface);
            box-shadow: 0 0 0 3px rgba(67, 135, 203, .09);
        }

        .types-search-wrapper>i {
            color: var(--typ-muted);
            font-size: 13px;
            margin-right: 10px;
        }

        .types-search-wrapper input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 11px;
            color: var(--typ-text);
            min-width: 0;
        }

        .types-search-wrapper input::placeholder {
            color: var(--typ-muted);
        }

        .types-search-wrapper button {
            border: none;
            background: transparent;
            color: var(--typ-muted);
            cursor: pointer;
            display: none;
            padding: 5px;
        }

        .types-search-wrapper button:hover {
            color: #dc5555;
        }

        .types-filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .types-select {
            height: 41px;
            min-width: 145px;
            border: 1px solid var(--typ-border);
            border-radius: 8px;
            padding: 0 11px;
            outline: none;
            background: var(--typ-surface-soft);
            color: var(--typ-text);
            font-size: 11px;
        }

        .types-select:focus {
            border-color: #4387cb;
            box-shadow: 0 0 0 3px rgba(67, 135, 203, .09);
        }

        .types-filter-btn {
            height: 41px;
            border: none;
            border-radius: 8px;
            padding: 0 15px;
            background: var(--typ-primary);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            transition: .2s;
        }

        .types-filter-btn:hover {
            filter: brightness(1.1);
        }

        .types-reset-btn {
            height: 41px;
            width: 41px;
            border: 1px solid var(--typ-border);
            border-radius: 8px;
            background: var(--typ-surface-soft);
            color: var(--typ-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: .2s;
        }

        .types-reset-btn:hover {
            color: var(--typ-primary);
            border-color: var(--typ-primary);
        }

        .types-toolbar-info {
            margin-top: 10px;
            color: var(--typ-muted);
            font-size: 10px;
        }

        .types-toolbar-info i {
            color: var(--typ-primary);
            margin-right: 5px;
        }

        /* =====================================================
       TABLEAU
    ===================================================== */

        .types-table-wrapper {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: auto;
            position: relative;
        }

        .types-table-wrapper::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        .types-table-wrapper::-webkit-scrollbar-track {
            background: var(--typ-surface-soft);
        }

        .types-table-wrapper::-webkit-scrollbar-thumb {
            background: #c6d2e0;
            border-radius: 10px;
        }

        .types-table {
            width: 100%;
            min-width: 850px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .types-table thead {
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .types-table thead th {
            background: var(--typ-surface-soft);
            color: var(--typ-muted);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .7px;
            padding: 16px 15px;
            border-bottom: 1px solid var(--typ-border);
            white-space: nowrap;
        }

        .types-table tbody td {
            padding: 14px 15px;
            border-bottom: 1px solid var(--typ-border);
            vertical-align: middle;
            background: var(--typ-surface);
            transition: background .2s;
        }

        .types-table tbody tr:hover td {
            background: var(--typ-hover);
        }

        .types-table tbody tr:last-child td {
            border-bottom: none;
        }

        .col-number {
            width: 65px;
            padding-left: 22px !important;
        }

        .col-name {
            min-width: 190px;
        }

        .col-description {
            min-width: 210px;
        }

        .col-frequency {
            min-width: 145px;
        }

        .col-status {
            width: 115px;
        }

        .col-actions {
            width: 125px;
            text-align: center;
        }

        /* NUMERO */

        .type-number {
            color: var(--typ-muted);
            font-size: 11px;
            font-weight: 700;
        }

        /* NOM */

        .type-name-cell {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .type-name-icon {
            width: 38px;
            height: 38px;
            background: var(--typ-surface-soft);
            color: #4781b7;
            border: 1px solid var(--typ-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .type-name-info strong {
            display: block;
            font-size: 12px;
            color: var(--typ-heading);
        }

        .type-name-info small {
            display: block;
            font-size: 10px;
            color: var(--typ-muted);
            margin-top: 4px;
        }

        /* DESCRIPTION */

        .type-description {
            color: var(--typ-muted);
            font-size: 11px;
            display: inline-block;
            max-width: 260px;
        }

        /* FREQUENCE */

        .type-frequency {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
        }

        .type-frequency.unique {
            background: #f1edfb;
            color: #8061b7;
        }

        .type-frequency.mensuelle {
            background: #eaf3fc;
            color: #347bb9;
        }

        .type-frequency.trimestrielle {
            background: #fff3e4;
            color: #b7792e;
        }

        .type-frequency.annuelle {
            background: #e9f8f0;
            color: #299769;
        }

        .type-frequency.autre {
            background: var(--typ-surface-soft);
            color: var(--typ-muted);
        }

        /* STATUT */

        .type-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .type-status.active {
            color: #218052;
            background: #eaf8f0;
        }

        .type-status.inactive {
            color: #8793a3;
            background: #f0f2f5;
        }

        /* =====================================================
       ACTIONS
    ===================================================== */

        .type-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .type-actions form {
            margin: 0;
        }

        .type-action-btn {
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

        .type-action-btn.view {
            background: #eaf3fc;
            color: #347bb9;
        }

        .type-action-btn.edit {
            background: #fff5df;
            color: #c18c27;
        }

        .type-action-btn.delete {
            background: #fff0ef;
            color: #d75c56;
        }

        .type-action-btn:hover {
            transform: translateY(-2px);
            filter: brightness(.95);
        }

        /* =====================================================
       ÉTAT VIDE
    ===================================================== */

        .types-empty {
            text-align: center;
            padding: 45px 20px !important;
        }

        .types-empty-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            background: var(--typ-surface-soft);
            color: #8ba3bd;
            border: 1px solid var(--typ-border);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .types-empty h5 {
            font-size: 15px;
            font-weight: 800;
            color: var(--typ-heading);
        }

        .types-empty p {
            color: var(--typ-muted);
            font-size: 11px;
        }

        .types-empty-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 8px;
            background: var(--typ-primary);
            color: #fff;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
        }

        /* =====================================================
       FOOTER
    ===================================================== */

        .types-card-footer {
            padding: 15px 22px;
            border-top: 1px solid var(--typ-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
            background: var(--typ-surface);
        }

        .types-pagination-info {
            font-size: 11px;
            color: var(--typ-muted);
        }

        .types-pagination-info strong {
            color: var(--typ-heading);
        }

        .types-pagination nav {
            margin: 0;
        }

        .types-pagination .pagination {
            margin: 0;
            gap: 4px;
        }

        .types-pagination .page-link {
            border: 1px solid var(--typ-border);
            border-radius: 7px !important;
            color: var(--typ-text);
            background: var(--typ-surface);
            font-size: 11px;
            padding: 7px 10px;
        }

        .types-pagination .page-item.active .page-link {
            background: var(--typ-primary);
            border-color: var(--typ-primary);
            color: #fff;
        }

        .types-pagination .page-link:hover {
            background: var(--typ-primary-soft);
            color: var(--typ-primary);
        }

        /* =====================================================
       MODE SOMBRE
    ===================================================== */

        html[data-app-theme="dark"] .types-page,
        html[data-app-theme="ultra-pro"] .types-page {
            --typ-surface: #1b2637;
            --typ-surface-soft: #222f42;
            --typ-text: #dce5f1;
            --typ-heading: #f0f5fc;
            --typ-muted: #a0aec0;
            --typ-border: #344257;
            --typ-hover: #26364c;
            --typ-primary: #76b8f5;
            --typ-primary-soft: #263e59;
            --typ-shadow: 0 6px 24px rgba(0, 0, 0, .2);
        }

        html[data-app-theme="dark"] .types-hero {
            background: linear-gradient(115deg, #14243c, #1d456b 65%, #17616a);
            border: 1px solid rgba(148, 190, 230, .13);
        }

        html[data-app-theme="dark"] .types-stat-icon.blue,
        html[data-app-theme="dark"] .types-title-icon {
            background: #263e59;
            color: #83bdf2;
        }

        html[data-app-theme="dark"] .types-stat-icon.green {
            background: #1e4439;
            color: #75d5a9;
        }

        html[data-app-theme="dark"] .types-stat-icon.purple {
            background: #39304f;
            color: #c1a4f2;
        }

        html[data-app-theme="dark"] .type-frequency.unique {
            background: #39304f;
            color: #c1a4f2;
        }

        html[data-app-theme="dark"] .type-frequency.mensuelle {
            background: #263e59;
            color: #9ccaff;
        }

        html[data-app-theme="dark"] .type-frequency.trimestrielle {
            background: #493b2b;
            color: #f3c58b;
        }

        html[data-app-theme="dark"] .type-frequency.annuelle {
            background: #1e4439;
            color: #8de0b0;
        }

        html[data-app-theme="dark"] .type-status.active {
            background: #1e4439;
            color: #8de0b0;
        }

        html[data-app-theme="dark"] .type-status.inactive {
            background: #303b4c;
            color: #b0bdcd;
        }

        html[data-app-theme="dark"] .type-action-btn.view {
            background: #263e59;
            color: #9ccaff;
        }

        html[data-app-theme="dark"] .type-action-btn.edit {
            background: #493d26;
            color: #f0c36b;
        }

        html[data-app-theme="dark"] .type-action-btn.delete {
            background: #492d31;
            color: #ff9994;
        }

        html[data-app-theme="dark"] .types-alert.success {
            background: #193c30;
            border-color: #2d604a;
            color: #8ce0b3;
        }

        html[data-app-theme="dark"] .types-alert.danger {
            background: #462a2d;
            border-color: #714044;
            color: #ffaaa5;
        }

        html[data-app-theme="dark"] .types-table-wrapper::-webkit-scrollbar-thumb {
            background: #52647b;
        }

        /* =====================================================
       ULTRA PRO
    ===================================================== */

        html[data-app-theme="ultra-pro"] .types-hero {
            background: linear-gradient(115deg, #09182d, #123d66 60%, #087c89);
            border: 1px solid rgba(91, 190, 255, .18);
        }

        /* =====================================================
       EMERALD
    ===================================================== */

        html[data-app-theme="emerald"] .types-page {
            --typ-primary: #168568;
            --typ-primary-soft: #e6f6f0;
        }

        html[data-app-theme="emerald"] .types-hero {
            background: linear-gradient(115deg, #075b4a, #13866b 65%, #36a58a);
        }

        /* =====================================================
       WARM
    ===================================================== */

        html[data-app-theme="warm"] .types-page {
            --typ-primary: #a66a35;
            --typ-primary-soft: #fbf0e4;
        }

        html[data-app-theme="warm"] .types-hero {
            background: linear-gradient(115deg, #70452e, #a66a35 65%, #c28b56);
        }

        /* =====================================================
       RESPONSIVE
    ===================================================== */

        @media (max-width: 1000px) {
            .types-card {
                height: calc(100vh - 370px);
                min-height: 400px;
            }

            .types-filter-form {
                align-items: stretch;
                flex-direction: column;
            }

            .types-search-wrapper {
                width: 100%;
            }

            .types-filter-group {
                width: 100%;
            }

            .types-select {
                flex: 1;
                min-width: 0;
            }
        }

        @media (max-width: 700px) {
            .types-page {
                padding: 13px;
            }

            .types-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 21px;
            }

            .types-hero h2 {
                font-size: 19px;
            }

            .types-hero-icon {
                width: 49px;
                height: 49px;
                font-size: 21px;
            }

            .types-add-btn {
                width: 100%;
            }

            .types-stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .types-card {
                height: 600px;
                max-height: calc(100vh - 250px);
                min-height: 430px;
            }

            .types-card-header {
                padding: 17px;
            }

            .types-total-badge {
                font-size: 10px;
            }

            .types-toolbar {
                padding: 13px 17px;
            }

            .types-filter-group {
                display: grid;
                grid-template-columns: 1fr 1fr;
            }

            .types-filter-btn {
                justify-content: center;
            }

            .types-toolbar-info {
                display: none;
            }

            .types-card-footer {
                padding: 14px;
                align-items: flex-start;
                flex-direction: column;
            }

            .types-pagination {
                max-width: 100%;
                overflow-x: auto;
            }
        }

        @media (max-width: 420px) {
            .types-hero-content {
                align-items: flex-start;
                gap: 12px;
            }

            .types-hero h2 {
                font-size: 17px;
            }

            .types-card-title p {
                max-width: 190px;
            }

            .types-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .types-filter-group {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const recherche = document.getElementById('rechercheType');
            const effacer = document.getElementById('effacerRecherche');

            if (!recherche || !effacer) return;

            function actualiserBouton() {
                effacer.style.display = recherche.value.trim() ? 'block' : 'none';
            }

            recherche.addEventListener('input', actualiserBouton);

            effacer.addEventListener('click', function() {
                recherche.value = '';
                actualiserBouton();
                recherche.focus();
            });

            actualiserBouton();

        });
    </script>

@endsection
