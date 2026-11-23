@extends('layouts.app')

@section('content')

    @php
        $peutVoir = auth()->user()->aPermission('bulletins.afficher');
        $peutGenerer = auth()->user()->aPermission('bulletins.creer');

        $afficherActions = $peutVoir || $peutGenerer;

        $classesFiltre = $eleves->map(fn($e) => $e->classe->nom ?? null)->filter()->unique()->sort()->values();
    @endphp

    <div class="bulletin-page">

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
        <div class="bulletin-hero">
            <div class="hero-content">
                <div class="hero-icon">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>

                <div>
                    <h1>Génération des bulletins</h1>
                    <p>
                        Sélectionnez les périodes, recherchez les élèves et
                        gérez leurs bulletins scolaires.
                    </p>
                </div>
            </div>

            <div class="hero-counter">
                <span class="counter-label">Élèves enregistrés</span>
                <div class="counter-value">
                    <i class="bi bi-people-fill"></i>
                    {{ $eleves->count() }}
                </div>
            </div>
        </div>

        {{-- =====================================================
         ALERTES
    ====================================================== --}}
        <div id="alertePeriode" class="alert-periode" style="display:none;">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>
                Veuillez sélectionner au moins une période avant de continuer.
            </span>
        </div>

        {{-- =====================================================
         FORMULAIRE PRINCIPAL
    ====================================================== --}}
        <form id="formBulletin" method="POST" action="{{ route('bulletin.afficher') }}">
            @csrf

            {{-- =================================================
             SÉLECTION DES PÉRIODES
        ================================================== --}}
            <div class="bulletin-panel periode-panel">

                <div class="panel-header">
                    <div class="panel-title">
                        <div class="panel-icon periode-icon">
                            <i class="bi bi-calendar3"></i>
                        </div>

                        <div>
                            <h3>Périodes scolaires</h3>
                            <p>Sélectionnez les périodes à inclure dans le bulletin.</p>
                        </div>
                    </div>

                    <button type="button" id="btnTogglePeriodes" class="btn-toggle-periodes">
                        <i class="bi bi-check2-square"></i>
                        Tout sélectionner
                    </button>
                </div>

                <div class="periodes-grid">
                    @foreach ($periodes as $periode)
                        <label class="periode-pill" for="periode_{{ $periode->id }}">
                            <input type="checkbox" name="periodes[]" value="{{ $periode->id }}"
                                id="periode_{{ $periode->id }}" class="periode-checkbox">

                            <span class="periode-check">
                                <i class="bi bi-check2"></i>
                            </span>

                            <span class="periode-label">
                                {{ $periode->nom }}
                            </span>
                        </label>
                    @endforeach
                </div>

            </div>

            {{-- =================================================
             LISTE DES ÉLÈVES
        ================================================== --}}
            <div class="bulletin-panel eleves-panel">

                <div class="panel-header eleves-header">
                    <div class="panel-title">
                        <div class="panel-icon eleves-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>

                        <div>
                            <h3>Liste des élèves</h3>
                            <p>Recherchez, filtrez et gérez les bulletins.</p>
                        </div>
                    </div>

                    <div class="eleves-total">
                        <span id="nombreElevesAffiches">{{ $eleves->count() }}</span>
                        <span>élève(s)</span>
                    </div>
                </div>

                {{-- FILTRES --}}
                <div class="filters-container">

                    <div class="filter-search">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchEleve" class="filter-control"
                            placeholder="Rechercher un élève ou une classe...">
                        <button type="button" id="btnResetFiltres" title="Réinitialiser les filtres">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>

                    <div class="filter-select-wrap">
                        <i class="bi bi-building"></i>
                        <select id="filterClasse" class="filter-control">
                            <option value="">Toutes les classes</option>
                            @foreach ($classesFiltre as $classe)
                                <option value="{{ Str::slug($classe) }}">
                                    {{ $classe }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-select-wrap">
                        <i class="bi bi-clipboard-check"></i>
                        <select id="filterStatut" class="filter-control">
                            <option value="">Tous les états</option>
                            <option value="disponible">Bulletin disponible</option>
                            <option value="non_genere">Non généré</option>
                        </select>
                    </div>

                    <div class="filter-select-wrap">
                        <i class="bi bi-sort-down"></i>
                        <select id="sortEleves" class="filter-control">
                            <option value="az">Nom : A → Z</option>
                            <option value="za">Nom : Z → A</option>
                            <option value="dispo_first">Bulletins disponibles</option>
                            <option value="non_genere_first">Non générés d'abord</option>
                        </select>
                    </div>

                </div>

                {{-- TABLEAU --}}
                <div class="table-container">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th class="th-eleve">ÉLÈVE</th>
                                <th class="th-classe">CLASSE</th>
                                <th class="th-statut">ÉTAT DU BULLETIN</th>

                                @if ($afficherActions)
                                    <th class="th-actions">ACTIONS</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody id="tbodyEleves">

                            @forelse ($eleves as $eleve)
                                @php
                                    $bulletin = \App\Models\Bulletin::where('eleve_id', $eleve->id)->latest()->first();

                                    $nomComplet = trim(($eleve->nom ?? '') . ' ' . ($eleve->prenom ?? ''));

                                    $initiales = collect(explode(' ', $nomComplet))
                                        ->filter()
                                        ->map(fn($mot) => mb_substr($mot, 0, 1))
                                        ->take(2)
                                        ->implode('');

                                    $classeNom = $eleve->classe->nom ?? 'Non affecté';
                                    $classeSlug = $eleve->classe ? Str::slug($classeNom) : '__non_affecte__';

                                    $statut = $bulletin ? 'disponible' : 'non_genere';
                                @endphp

                                <tr class="eleve-row" data-nom="{{ Str::lower($nomComplet) }}"
                                    data-classe="{{ $classeSlug }}" data-statut="{{ $statut }}">

                                    {{-- ÉLÈVE --}}
                                    <td class="td-eleve">
                                        <div class="eleve-info">

                                            <div class="avatar-eleve">
                                                @if ($eleve->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($eleve->photo))
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

                                            <div class="eleve-details">
                                                <span class="eleve-nom">
                                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                                </span>

                                                <span class="eleve-meta">
                                                    <i class="bi bi-person-badge"></i>
                                                    {{ $eleve->matricule ?? 'Matricule non renseigné' }}
                                                </span>
                                            </div>

                                        </div>
                                    </td>

                                    {{-- CLASSE --}}
                                    <td class="td-classe">
                                        @if ($eleve->classe)
                                            <span class="badge-classe">
                                                <i class="bi bi-diagram-3"></i>
                                                {{ $eleve->classe->nom }}
                                            </span>
                                        @else
                                            <span class="badge-non-affecte">
                                                Non affecté
                                            </span>
                                        @endif
                                    </td>

                                    {{-- STATUT --}}
                                    <td class="td-statut">
                                        @if ($bulletin)
                                            <span class="status-badge status-available">
                                                <span class="status-dot"></span>
                                                Bulletin disponible
                                            </span>
                                        @else
                                            <span class="status-badge status-pending">
                                                <span class="status-dot"></span>
                                                Non généré
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ACTIONS --}}
                                    @if ($afficherActions)
                                        <td class="td-actions">

                                            <div class="actions-group">

                                                {{-- GÉNÉRER --}}
                                                @if ($peutGenerer)
                                                    <button type="submit" name="eleve_id" value="{{ $eleve->id }}"
                                                        class="btn-action btn-generate" title="Générer le bulletin">
                                                        <i class="bi bi-magic"></i>
                                                        <span>Générer</span>
                                                    </button>
                                                @endif

                                                {{-- VOIR  BOUTON MASQUER --}}
                                                @if ($peutVoir)
                                                    <button type="button" class="btn-action btn-view d-none"
                                                        data-eleve="{{ $eleve->id }}" title="Voir le bulletin">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                @endif

                                            </div>
                                        </td>
                                    @endif

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="{{ $afficherActions ? 4 : 3 }}">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <h4>Aucun élève enregistré</h4>
                                            <p>Les élèves apparaîtront ici après leur enregistrement.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            {{-- AUCUN RÉSULTAT APRÈS FILTRE --}}
                            <tr id="filterEmptyRow" style="display:none;">
                                <td colspan="{{ $afficherActions ? 4 : 3 }}">
                                    <div class="empty-state filter-empty">
                                        <div class="empty-icon">
                                            <i class="bi bi-search"></i>
                                        </div>
                                        <h4>Aucun résultat</h4>
                                        <p>Aucun élève ne correspond aux filtres sélectionnés.</p>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <span>
                        <i class="bi bi-info-circle"></i>
                        Utilisez les filtres pour retrouver rapidement un élève.
                    </span>
                </div>

            </div>
        </form>

    </div>

    {{-- =========================================================
     CSS
========================================================= --}}
    <style>
        /* =====================================================
                       VARIABLES ET PAGE
                    ====================================================== */
        .bulletin-page {
            --bp-bg: #f4f7fc;
            --bp-card: #ffffff;
            --bp-soft: #f7f9fd;
            --bp-text: #24344d;
            --bp-muted: #78869b;
            --bp-border: #e4eaf2;
            --bp-primary: #3975e8;
            --bp-primary-soft: #edf3ff;
            --bp-input: #ffffff;
            --bp-shadow: 0 8px 28px rgba(31, 50, 81, .06);

            padding: 24px;
            background: var(--bp-bg);
            color: var(--bp-text);
            min-height: 100vh;
            border-radius: 18px;
            transition: background .25s, color .25s;
        }

        .bulletin-page,
        .bulletin-page * {
            box-sizing: border-box;
        }

        /* =====================================================
                       EN-TÊTE
                    ====================================================== */
        .bulletin-hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 25px 28px;
            margin-bottom: 22px;
            border-radius: 18px;
            background: linear-gradient(120deg, #2463d5, #518df1);
            color: #fff;
            box-shadow: 0 12px 28px rgba(45, 105, 220, .18);
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .hero-icon {
            width: 58px;
            height: 58px;
            flex: 0 0 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: rgba(255, 255, 255, .16);
            font-size: 26px;
        }

        .bulletin-hero h1 {
            font-size: 24px;
            font-weight: 800;
            color: #fff;
            margin: 0 0 7px;
            letter-spacing: -.4px;
        }

        .bulletin-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .82);
            font-size: 13px;
        }

        .hero-counter {
            padding: 13px 20px;
            min-width: 145px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 14px;
            text-align: center;
        }

        .counter-label {
            display: block;
            font-size: 11px;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 5px;
        }

        .counter-value {
            font-size: 24px;
            font-weight: 800;
            color: #fff;
        }

        .counter-value i {
            font-size: 17px;
            margin-right: 5px;
        }

        /* =====================================================
                       PANELS
                    ====================================================== */
        .bulletin-panel {
            background: var(--bp-card);
            border: 1px solid var(--bp-border);
            border-radius: 17px;
            box-shadow: var(--bp-shadow);
            margin-bottom: 22px;
            overflow: hidden;
            transition: background .25s, border .25s;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--bp-border);
        }

        .panel-title {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .panel-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .periode-icon {
            background: #eaf1ff;
            color: #3975e8;
        }

        .eleves-icon {
            background: #e5f8f1;
            color: #15976c;
        }

        .panel-header h3 {
            color: var(--bp-text);
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px;
        }

        .panel-header p {
            color: var(--bp-muted);
            font-size: 12px;
            margin: 0;
        }

        /* =====================================================
                       PÉRIODES
                    ====================================================== */
        .periodes-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding: 22px 24px;
        }

        .periode-pill {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 17px;
            min-height: 46px;
            background: var(--bp-soft);
            border: 1px solid var(--bp-border);
            border-radius: 12px;
            cursor: pointer;
            transition: .2s ease;
            user-select: none;
        }

        .periode-pill:hover {
            border-color: var(--bp-primary);
            transform: translateY(-1px);
        }

        .periode-pill input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .periode-check {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 19px;
            height: 19px;
            border-radius: 6px;
            border: 1.5px solid #a9b8cc;
            background: var(--bp-card);
            color: #fff;
            font-size: 13px;
            transition: .2s;
        }

        .periode-check i {
            opacity: 0;
            transform: scale(.5);
            transition: .2s;
        }

        .periode-pill:has(input:checked) {
            background: var(--bp-primary-soft);
            border-color: var(--bp-primary);
        }

        .periode-pill:has(input:checked) .periode-check {
            background: var(--bp-primary);
            border-color: var(--bp-primary);
        }

        .periode-pill:has(input:checked) .periode-check i {
            opacity: 1;
            transform: scale(1);
        }

        .periode-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--bp-text);
        }

        .btn-toggle-periodes {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 13px;
            border: 1px solid var(--bp-border);
            background: var(--bp-soft);
            color: var(--bp-text);
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .btn-toggle-periodes:hover {
            border-color: var(--bp-primary);
            color: var(--bp-primary);
        }

        /* =====================================================
                       ALERTES
                    ====================================================== */
        .alert-periode {
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid #f1c76c;
            background: #fff8e8;
            color: #8b5b00;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        /* =====================================================
                       FILTRES
                    ====================================================== */
        .filters-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            padding: 18px 24px;
            background: var(--bp-soft);
            border-bottom: 1px solid var(--bp-border);
        }

        .filter-search,
        .filter-select-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .filter-search {
            flex: 1 1 230px;
            min-width: 200px;
        }

        .filter-search>i,
        .filter-select-wrap>i {
            position: absolute;
            left: 12px;
            color: var(--bp-muted);
            font-size: 14px;
            pointer-events: none;
            z-index: 1;
        }

        .filter-control {
            width: 100%;
            height: 42px;
            border-radius: 10px;
            border: 1px solid var(--bp-border);
            background: var(--bp-input);
            color: var(--bp-text);
            outline: none;
            font-size: 12px;
            transition: .2s;
        }

        input.filter-control {
            padding: 0 38px 0 36px;
        }

        select.filter-control {
            min-width: 170px;
            padding: 0 30px 0 35px;
            cursor: pointer;
        }

        .filter-control:focus {
            border-color: var(--bp-primary);
            box-shadow: 0 0 0 3px rgba(57, 117, 232, .1);
        }

        .filter-search #btnResetFiltres,
        #btnResetFiltres {
            position: absolute;
            right: 10px;
            background: transparent;
            border: 0;
            padding: 4px;
            color: var(--bp-muted);
            cursor: pointer;
            font-size: 15px;
        }

        #btnResetFiltres:hover {
            color: #e04b5a;
        }

        /* =====================================================
                       COMPTEUR
                    ====================================================== */
        .eleves-total {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 10px;
            background: var(--bp-primary-soft);
            color: var(--bp-primary);
            font-size: 12px;
            font-weight: 700;
        }

        /* =====================================================
                       TABLEAU
                    ====================================================== */
        .table-container {
            overflow-x: auto;
            width: 100%;
        }

        .table-modern {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            min-width: 720px;
        }

        .table-modern thead th {
            padding: 13px 20px;
            background: var(--bp-soft);
            color: var(--bp-muted);
            border-bottom: 1px solid var(--bp-border);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .7px;
            white-space: nowrap;
        }

        .table-modern tbody tr.eleve-row {
            border-bottom: 1px solid var(--bp-border);
            transition: background .15s;
        }

        .table-modern tbody tr.eleve-row:hover {
            background: var(--bp-primary-soft);
        }

        .table-modern tbody tr:last-child {
            border-bottom: 0;
        }

        .table-modern td {
            padding: 13px 20px;
            vertical-align: middle;
            color: var(--bp-text);
        }

        .th-eleve {
            text-align: left;
        }

        .th-actions {
            text-align: right;
        }

        /* =====================================================
                       IDENTITÉ ÉLÈVE
                    ====================================================== */
        .eleve-info {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 220px;
        }

        /* =====================================================
       PHOTO ET AVATAR ÉLÈVE
    ====================================================== */

        .avatar-eleve {
            width: 46px;
            height: 46px;
            min-width: 46px;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
            border: 2px solid var(--bp-border);
            background: var(--bp-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 7px rgba(0, 0, 0, .08);
            transition: all .25s ease;
        }

        .avatar-eleve:hover {
            transform: scale(1.08);
            border-color: var(--bp-primary);
            box-shadow: 0 4px 12px rgba(57, 117, 232, .18);
        }

        .photo-eleve {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
        }

        .avatar-eleve .avatar-initials {
            width: 100%;
            height: 100%;
            min-width: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #e7efff, #d7e5ff);
            color: #3568c8;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }

        /* Mode sombre */
        html[data-app-theme="dark"] .avatar-eleve {
            border-color: #40516b;
        }

        html[data-app-theme="dark"] .avatar-eleve .avatar-initials {
            background: #283f61;
            color: #a5c4ff;
        }

        /* Ultra Pro */
        html[data-app-theme="ultra-pro"] .avatar-eleve {
            border-color: #40516b;
        }

        html[data-app-theme="ultra-pro"] .avatar-eleve .avatar-initials {
            background: #243c5d;
            color: #a4c7ff;
        }

        /* Émeraude */
        html[data-app-theme="emerald"] .avatar-eleve .avatar-initials {
            background: #ddf3e8;
            color: #16865f;
        }

        /* Crème Prestige */
        html[data-app-theme="warm"] .avatar-eleve .avatar-initials {
            background: #f3e4d0;
            color: #a76d33;
        }

        .eleve-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .eleve-nom {
            font-size: 13px;
            font-weight: 700;
            color: var(--bp-text);
        }

        .eleve-meta {
            font-size: 11px;
            color: var(--bp-muted);
        }

        .eleve-meta i {
            margin-right: 4px;
        }

        /* =====================================================
                       BADGES CLASSE
                    ====================================================== */
        .badge-classe {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 8px;
            background: var(--bp-soft);
            border: 1px solid var(--bp-border);
            color: var(--bp-text);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-non-affecte {
            font-size: 11px;
            color: var(--bp-muted);
            font-style: italic;
        }

        /* =====================================================
                       STATUT
                    ====================================================== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .status-available {
            color: #14825e;
            background: #e5f7ef;
        }

        .status-available .status-dot {
            background: #20ae7b;
        }

        .status-pending {
            color: #a46a12;
            background: #fff4df;
        }

        .status-pending .status-dot {
            background: #e7a638;
        }

        /* =====================================================
                       ACTIONS
                    ====================================================== */
        .td-actions {
            text-align: right;
        }

        .actions-group {
            display: inline-flex;
            justify-content: flex-end;
            align-items: center;
            gap: 6px;
            flex-wrap: nowrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 35px;
            height: 34px;
            padding: 0 9px;
            border-radius: 9px;
            border: 1px solid var(--bp-border);
            background: var(--bp-card);
            color: var(--bp-text);
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            transition: .2s ease;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .btn-generate {
            background: #3975e8;
            color: #fff;
            border-color: #3975e8;
        }

        .btn-generate:hover {
            background: #2864d4;
            color: #fff;
        }

        .btn-view {
            color: #3975e8;
            border-color: #cbdcff;
            background: #edf3ff;
        }

        .btn-view:hover {
            background: #dce9ff;
        }

        .btn-download {
            color: #15976c;
            border-color: #c6ecdc;
            background: #e8f8f1;
        }

        .btn-download:hover {
            background: #d6f2e5;
        }

        .btn-print {
            color: #9060cb;
            border-color: #e3d5f5;
            background: #f5edff;
        }

        .btn-print:hover {
            background: #eaddff;
        }

        .download-menu {
            background: var(--bp-card);
            border: 1px solid var(--bp-border);
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .12);
            min-width: 175px;
        }

        .download-menu .dropdown-item {
            padding: 9px 12px;
            border-radius: 8px;
            color: var(--bp-text);
            font-size: 12px;
        }

        .download-menu .dropdown-item:hover {
            background: var(--bp-primary-soft);
        }

        .download-menu .dropdown-item i {
            margin-right: 8px;
        }

        /* =====================================================
                       ÉTATS VIDES
                    ====================================================== */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-icon {
            width: 55px;
            height: 55px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 13px;
            border-radius: 17px;
            background: var(--bp-soft);
            color: var(--bp-muted);
            font-size: 22px;
        }

        .empty-state h4 {
            font-size: 15px;
            font-weight: 800;
            color: var(--bp-text);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 12px;
            color: var(--bp-muted);
            margin: 0;
        }

        /* =====================================================
                       BAS DU TABLEAU
                    ====================================================== */
        .table-footer {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 14px 20px;
            border-top: 1px solid var(--bp-border);
            background: var(--bp-soft);
            font-size: 11px;
            color: var(--bp-muted);
        }

        /* =====================================================
                       THÈME DARK
                    ====================================================== */
        html[data-app-theme="dark"] .bulletin-page {
            --bp-bg: #121b2b;
            --bp-card: #1b2638;
            --bp-soft: #202d41;
            --bp-text: #e5ecf7;
            --bp-muted: #a3b1c5;
            --bp-border: #334258;
            --bp-primary: #78a7ff;
            --bp-primary-soft: #263d5e;
            --bp-input: #182336;
            --bp-shadow: 0 8px 28px rgba(0, 0, 0, .15);
        }

        html[data-app-theme="dark"] .bulletin-page .periode-icon {
            background: #283f61;
            color: #8db5ff;
        }

        html[data-app-theme="dark"] .bulletin-page .eleves-icon {
            background: #203e3a;
            color: #6cdbb1;
        }

        html[data-app-theme="dark"] .bulletin-page .avatar-initials {
            background: #283f61;
            color: #a5c4ff;
        }

        html[data-app-theme="dark"] .bulletin-page .status-available {
            background: #1e423b;
            color: #77d8b4;
        }

        html[data-app-theme="dark"] .bulletin-page .status-pending {
            background: #493c29;
            color: #edc374;
        }

        html[data-app-theme="dark"] .bulletin-page .btn-view {
            background: #263e61;
            color: #93b9ff;
            border-color: #38557d;
        }

        html[data-app-theme="dark"] .bulletin-page .btn-download {
            background: #204139;
            color: #77d8b4;
            border-color: #315a4b;
        }

        html[data-app-theme="dark"] .bulletin-page .btn-print {
            background: #3a3050;
            color: #c7a8ff;
            border-color: #55436d;
        }

        html[data-app-theme="dark"] .bulletin-page .alert-periode {
            background: #463a27;
            color: #f3cb83;
            border-color: #71572c;
        }

        /* =====================================================
                       THÈME ULTRA PRO
                    ====================================================== */
        html[data-app-theme="ultra-pro"] .bulletin-page {
            --bp-bg: #111827;
            --bp-card: #182338;
            --bp-soft: #1d2a40;
            --bp-text: #e8eef8;
            --bp-muted: #9aabc4;
            --bp-border: #30415a;
            --bp-primary: #60a5fa;
            --bp-primary-soft: #233a59;
            --bp-input: #151f31;
            --bp-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .periode-icon {
            background: #233c60;
            color: #7eb3ff;
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .eleves-icon {
            background: #21453d;
            color: #6fe0b8;
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .avatar-initials {
            background: #243c5d;
            color: #a4c7ff;
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .status-available {
            background: #1d4339;
            color: #6cdbb3;
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .status-pending {
            background: #4b3b25;
            color: #f1c674;
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .btn-view {
            background: #243e61;
            color: #92baff;
            border-color: #3b5c87;
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .btn-download {
            background: #20433a;
            color: #7bd9b6;
            border-color: #315d4a;
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .btn-print {
            background: #3b3152;
            color: #c7a8ff;
            border-color: #57456e;
        }

        html[data-app-theme="ultra-pro"] .bulletin-page .alert-periode {
            background: #463a27;
            color: #f2c981;
            border-color: #71572c;
        }

        /* =====================================================
                       THÈME EMERALD
                    ====================================================== */
        html[data-app-theme="emerald"] .bulletin-page {
            --bp-bg: #edf7f3;
            --bp-card: #ffffff;
            --bp-soft: #f1f8f5;
            --bp-text: #1e4035;
            --bp-muted: #668679;
            --bp-border: #d5e9df;
            --bp-primary: #16865f;
            --bp-primary-soft: #e0f3e9;
            --bp-input: #ffffff;
            --bp-shadow: 0 8px 28px rgba(31, 81, 57, .06);
        }

        html[data-app-theme="emerald"] .bulletin-page .bulletin-hero {
            background: linear-gradient(120deg, #08744f, #24a77b);
            box-shadow: 0 12px 28px rgba(14, 124, 82, .16);
        }

        html[data-app-theme="emerald"] .bulletin-page .periode-icon {
            background: #e0f3e9;
            color: #16865f;
        }

        html[data-app-theme="emerald"] .bulletin-page .eleves-icon {
            background: #d8f2e7;
            color: #13845c;
        }

        html[data-app-theme="emerald"] .bulletin-page .avatar-initials {
            background: #ddf3e8;
            color: #16865f;
        }

        /* =====================================================
                       THÈME WARM
                    ====================================================== */
        html[data-app-theme="warm"] .bulletin-page {
            --bp-bg: #f8f4ed;
            --bp-card: #fffdf9;
            --bp-soft: #f7f1e7;
            --bp-text: #51402e;
            --bp-muted: #907d66;
            --bp-border: #e9dece;
            --bp-primary: #bb7932;
            --bp-primary-soft: #f7e9d5;
            --bp-input: #fffdf9;
            --bp-shadow: 0 8px 28px rgba(92, 66, 36, .06);
        }

        html[data-app-theme="warm"] .bulletin-page .bulletin-hero {
            background: linear-gradient(120deg, #a96924, #d7964f);
            box-shadow: 0 12px 28px rgba(177, 112, 47, .17);
        }

        html[data-app-theme="warm"] .bulletin-page .periode-icon {
            background: #f6e8d5;
            color: #b87531;
        }

        html[data-app-theme="warm"] .bulletin-page .eleves-icon {
            background: #f1e3d0;
            color: #aa6d32;
        }

        html[data-app-theme="warm"] .bulletin-page .avatar-initials {
            background: #f3e4d0;
            color: #a76d33;
        }

        html[data-app-theme="warm"] .bulletin-page .status-available {
            background: #e7f2e5;
            color: #4d8a49;
        }

        html[data-app-theme="warm"] .bulletin-page .status-pending {
            background: #fff0d9;
            color: #a46b1c;
        }

        /* =====================================================
                       RESPONSIVE
                    ====================================================== */
        @media (max-width: 1100px) {
            .filters-container {
                gap: 10px;
            }

            .filter-select-wrap {
                flex: 1 1 180px;
            }

            .filter-select-wrap select {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .bulletin-page {
                padding: 14px;
            }

            .bulletin-hero {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }

            .hero-counter {
                width: 100%;
            }

            .panel-header {
                padding: 17px;
            }

            .periode-panel .panel-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-toggle-periodes {
                width: 100%;
                justify-content: center;
            }

            .periodes-grid {
                padding: 17px;
            }

            .filters-container {
                padding: 15px;
            }

            .filter-search,
            .filter-select-wrap {
                flex: 1 1 100%;
            }

            .filter-select-wrap select {
                width: 100%;
            }

            .table-modern td {
                padding: 12px;
            }

            .table-modern th {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .bulletin-hero h1 {
                font-size: 20px;
            }

            .hero-content {
                gap: 12px;
            }

            .hero-icon {
                width: 48px;
                height: 48px;
                flex-basis: 48px;
                font-size: 22px;
            }

            .panel-title {
                gap: 10px;
            }

            .panel-header h3 {
                font-size: 14px;
            }

            .panel-header p {
                font-size: 11px;
            }

            .eleves-header {
                flex-wrap: wrap;
            }

            .actions-group {
                gap: 4px;
            }

            .btn-action {
                min-width: 32px;
                height: 31px;
                padding: 0 7px;
            }

            .btn-generate span {
                display: none;
            }
        }
    </style>

    {{-- =========================================================
     JAVASCRIPT
========================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* =====================================================
               ÉLÉMENTS
            ====================================================== */
            const form = document.getElementById('formBulletin');
            const tbody = document.getElementById('tbodyEleves');
            const searchInput = document.getElementById('searchEleve');
            const filterClasse = document.getElementById('filterClasse');
            const filterStatut = document.getElementById('filterStatut');
            const sortSelect = document.getElementById('sortEleves');
            const resetBtn = document.getElementById('btnResetFiltres');
            const togglePeriodesBtn = document.getElementById('btnTogglePeriodes');
            const alertePeriode = document.getElementById('alertePeriode');
            const nombreElevesAffiches = document.getElementById('nombreElevesAffiches');
            const filterEmptyRow = document.getElementById('filterEmptyRow');

            if (!form || !tbody) return;

            /* =====================================================
               PÉRIODES
            ====================================================== */
            function getPeriodes() {
                return Array.from(document.querySelectorAll('.periode-checkbox:checked'))
                    .map(cb => cb.value)
                    .join(',');
            }

            function afficherErreurPeriode() {
                if (!alertePeriode) return;

                alertePeriode.style.display = 'flex';
                alertePeriode.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            function cacherErreurPeriode() {
                if (alertePeriode) {
                    alertePeriode.style.display = 'none';
                }
            }

            function verifierPeriodes() {
                return document.querySelectorAll('.periode-checkbox:checked').length > 0;
            }

            document.querySelectorAll('.periode-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (verifierPeriodes()) {
                        cacherErreurPeriode();
                    }
                    actualiserBoutonToggle();
                });
            });

            /* =====================================================
               BOUTON TOUT SÉLECTIONNER
            ====================================================== */
            function actualiserBoutonToggle() {
                if (!togglePeriodesBtn) return;

                const checkboxes = Array.from(document.querySelectorAll('.periode-checkbox'));
                const tousCoches = checkboxes.length > 0 && checkboxes.every(cb => cb.checked);

                togglePeriodesBtn.innerHTML = tousCoches ?
                    '<i class="bi bi-x-square"></i> Tout désélectionner' :
                    '<i class="bi bi-check2-square"></i> Tout sélectionner';
            }

            if (togglePeriodesBtn) {
                togglePeriodesBtn.addEventListener('click', function() {
                    const checkboxes = Array.from(document.querySelectorAll('.periode-checkbox'));
                    const tousCoches = checkboxes.length > 0 && checkboxes.every(cb => cb.checked);

                    checkboxes.forEach(cb => {
                        cb.checked = !tousCoches;
                    });

                    if (!tousCoches) {
                        cacherErreurPeriode();
                    }

                    actualiserBoutonToggle();
                });
            }

            /* =====================================================
               FILTRAGE ET TRI
            ====================================================== */
            function appliquerFiltresEtTri() {
                const terme = (searchInput?.value || '').toLowerCase().trim();
                const classe = filterClasse?.value || '';
                const statut = filterStatut?.value || '';
                const tri = sortSelect?.value || 'az';

                const rows = Array.from(tbody.querySelectorAll('tr.eleve-row'));

                rows.sort(function(a, b) {
                    const nomA = a.dataset.nom || '';
                    const nomB = b.dataset.nom || '';
                    const statutA = a.dataset.statut || '';
                    const statutB = b.dataset.statut || '';

                    if (tri === 'za') {
                        return nomB.localeCompare(nomA);
                    }

                    if (tri === 'dispo_first') {
                        if (statutA !== statutB) {
                            return statutA === 'disponible' ? -1 : 1;
                        }
                        return nomA.localeCompare(nomB);
                    }

                    if (tri === 'non_genere_first') {
                        if (statutA !== statutB) {
                            return statutA === 'non_genere' ? -1 : 1;
                        }
                        return nomA.localeCompare(nomB);
                    }

                    return nomA.localeCompare(nomB);
                });

                let visibleCount = 0;

                rows.forEach(function(row) {
                    const nom = row.dataset.nom || '';
                    const classeEleve = row.dataset.classe || '';
                    const statutEleve = row.dataset.statut || '';

                    const matchNom = !terme || nom.includes(terme) || classeEleve.includes(terme);
                    const matchClasse = !classe || classeEleve === classe;
                    const matchStatut = !statut || statutEleve === statut;

                    const visible = matchNom && matchClasse && matchStatut;

                    row.style.display = visible ? '' : 'none';

                    if (visible) {
                        visibleCount++;
                    }

                    tbody.appendChild(row);
                });

                if (filterEmptyRow) {
                    filterEmptyRow.style.display = visibleCount === 0 && rows.length > 0 ? '' : 'none';
                }

                if (nombreElevesAffiches) {
                    nombreElevesAffiches.textContent = visibleCount;
                }
            }

            searchInput?.addEventListener('input', appliquerFiltresEtTri);
            filterClasse?.addEventListener('change', appliquerFiltresEtTri);
            filterStatut?.addEventListener('change', appliquerFiltresEtTri);
            sortSelect?.addEventListener('change', appliquerFiltresEtTri);

            /* =====================================================
               RÉINITIALISATION
            ====================================================== */
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    if (searchInput) searchInput.value = '';
                    if (filterClasse) filterClasse.value = '';
                    if (filterStatut) filterStatut.value = '';
                    if (sortSelect) sortSelect.value = 'az';

                    appliquerFiltresEtTri();
                    searchInput?.focus();
                });
            }

            /* =====================================================
               VALIDATION AVANT GÉNÉRATION
            ====================================================== */
            form.addEventListener('submit', function(e) {
                if (!verifierPeriodes()) {
                    e.preventDefault();
                    afficherErreurPeriode();
                }
            });

            /* =====================================================
               VOIR BULLETIN
            ====================================================== */
            document.querySelectorAll('.btn-voir').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (!verifierPeriodes()) {
                        afficherErreurPeriode();
                        return;
                    }

                    const eleveId = this.dataset.eleve;
                    const periodes = getPeriodes();

                    const url =
                        `/bulletin/voir-direct?eleve_id=${encodeURIComponent(eleveId)}&periodes=${encodeURIComponent(periodes)}`;

                    window.open(url, '_blank');
                });
            });



            /* =====================================================
               INITIALISATION
            ====================================================== */
            appliquerFiltresEtTri();
            actualiserBoutonToggle();

        });
    </script>

@endsection
