@extends('layouts.app')

@section('content')
    <style>
        /* =====================================================
       TARIFS SCOLAIRES - STYLE GENERAL
    ===================================================== */

        .tarifs-page {
            --tp-bg: #f4f6fb;
            --tp-card: #ffffff;
            --tp-text: #263449;
            --tp-muted: #718096;
            --tp-border: #e2e8f0;
            --tp-primary: #6256d9;
            --tp-soft: #eeecff;

            background: var(--tp-bg);
            color: var(--tp-text);
            padding: 22px;
            border-radius: 18px;
            min-height: 100%;
        }

        .tarifs-page,
        .tarifs-page * {
            box-sizing: border-box;
        }

        /* =====================================================
       EN-TETE
    ===================================================== */

        .tarifs-page .tp-hero {
            background: linear-gradient(120deg, #5145cd, #8274ee);
            padding: 27px 30px;
            border-radius: 18px;
            color: #fff;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px rgba(81, 69, 205, .18);
        }

        .tarifs-page .tp-breadcrumb {
            font-size: 12px;
            margin-bottom: 13px;
            color: rgba(255, 255, 255, .75);
        }

        .tarifs-page .tp-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .tarifs-page .tp-hero h2 {
            font-size: 25px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .tarifs-page .tp-hero p {
            font-size: 14px;
            margin: 0;
            color: rgba(255, 255, 255, .85);
        }

        .tarifs-page .tp-hero .btn {
            border-radius: 10px;
            font-weight: 700;
            padding: 10px 17px;
        }

        /* =====================================================
       STATISTIQUES
    ===================================================== */

        .tarifs-page .tp-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .tarifs-page .tp-stat {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 19px;
            border-radius: 15px;
            background: var(--tp-card);
            border: 1px solid var(--tp-border);
            box-shadow: 0 5px 18px rgba(0, 0, 0, .04);
        }

        .tarifs-page .tp-stat-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: var(--tp-soft);
            color: var(--tp-primary);
            font-size: 22px;
        }

        .tarifs-page .tp-stat-label {
            color: var(--tp-muted);
            font-size: 12px;
            margin-bottom: 4px;
        }

        .tarifs-page .tp-stat-value {
            color: var(--tp-text);
            font-size: 23px;
            font-weight: 800;
        }

        /* =====================================================
       CARTE PRINCIPALE
    ===================================================== */

        .tarifs-page .tp-card {
            background: var(--tp-card);
            border: 1px solid var(--tp-border);
            border-radius: 17px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .04);
        }

        .tarifs-page .tp-card-header {
            padding: 19px 22px;
            border-bottom: 1px solid var(--tp-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .tarifs-page .tp-card-header h5 {
            font-size: 16px;
            font-weight: 800;
            color: var(--tp-text);
            margin: 0;
        }

        .tarifs-page .tp-card-header small {
            display: block;
            margin-top: 5px;
            color: var(--tp-muted);
        }

        .tarifs-page .tp-card-body {
            padding: 20px 22px;
        }

        /* =====================================================
       TABLEAU
    ===================================================== */

        .tarifs-page .table {
            color: var(--tp-text);
            background: var(--tp-card);
            margin-bottom: 0;
            vertical-align: middle;
            white-space: nowrap;
            border-color: var(--tp-border);
        }

        .tarifs-page .table thead th {
            background: var(--tp-bg);
            color: var(--tp-muted);
            border-color: var(--tp-border);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 14px 12px;
        }

        .tarifs-page .table tbody td {
            background: var(--tp-card);
            color: var(--tp-text);
            border-color: var(--tp-border);
            padding: 15px 12px;
            font-size: 13px;
        }

        .tarifs-page .table tbody tr:hover td {
            background: var(--tp-soft);
            color: var(--tp-text);
        }

        .tarifs-page .tp-type {
            color: var(--tp-text);
            font-weight: 750;
        }

        .tarifs-page .tp-amount {
            color: var(--tp-primary);
            font-weight: 800;
            font-size: 14px;
        }

        .tarifs-page .tp-period {
            color: var(--tp-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .tarifs-page .tp-muted {
            color: var(--tp-muted);
        }

        /* =====================================================
       BADGES
    ===================================================== */

        .tarifs-page .tp-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 750;
        }

        .tarifs-page .tp-badge-active {
            color: #16834b;
            background: #e3f7eb;
        }

        .tarifs-page .tp-badge-inactive {
            color: #64748b;
            background: #edf0f4;
        }

        /* =====================================================
       BOUTONS ACTIONS
    ===================================================== */

        .tarifs-page .tp-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .tarifs-page .tp-actions .btn {
            width: 33px;
            height: 33px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            border-radius: 8px;
        }

        .tarifs-page .tp-actions form {
            margin: 0;
        }

        /* =====================================================
       AUCUN RESULTAT
    ===================================================== */

        .tarifs-page .tp-empty {
            padding: 45px 15px !important;
            text-align: center;
            color: var(--tp-muted) !important;
            white-space: normal;
        }

        .tarifs-page .tp-empty i {
            display: block;
            font-size: 38px;
            margin-bottom: 12px;
            opacity: .6;
        }

        /* =====================================================
       PAGINATION
    ===================================================== */

        .tarifs-page .pagination {
            margin-bottom: 0;
        }

        .tarifs-page .pagination .page-link {
            color: var(--tp-primary);
            background: var(--tp-card);
            border-color: var(--tp-border);
        }

        .tarifs-page .pagination .active .page-link {
            color: #fff;
            background: var(--tp-primary);
            border-color: var(--tp-primary);
        }

        .tarifs-page .tp-pagination-info {
            color: var(--tp-muted);
            font-size: 12px;
        }

        /* =====================================================
       ALERTES
    ===================================================== */

        .tarifs-page .alert {
            border-radius: 12px;
        }

        /* =====================================================
       MODE SOMBRE - CORRECTION EXPLICITE
    ===================================================== */

        html[data-app-theme="dark"] .tarifs-page {
            --tp-bg: #151c2b;
            --tp-card: #202a3b;
            --tp-text: #edf2fa;
            --tp-muted: #a8b5c8;
            --tp-border: #39465b;
            --tp-primary: #ad9fff;
            --tp-soft: #343052;

            background: #151c2b !important;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarifs-page .tp-stat,
        html[data-app-theme="dark"] .tarifs-page .tp-card {
            background: #202a3b !important;
            border-color: #39465b !important;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarifs-page .tp-card-header {
            background: #202a3b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarifs-page .tp-card-header h5,
        html[data-app-theme="dark"] .tarifs-page .tp-stat-value,
        html[data-app-theme="dark"] .tarifs-page .tp-type {
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarifs-page .tp-stat-label,
        html[data-app-theme="dark"] .tarifs-page .tp-card-header small,
        html[data-app-theme="dark"] .tarifs-page .tp-muted {
            color: #a8b5c8 !important;
        }

        html[data-app-theme="dark"] .tarifs-page .tp-stat-icon {
            background: #343052 !important;
            color: #ad9fff !important;
        }

        /* En-tête du tableau */
        html[data-app-theme="dark"] .tarifs-page .table thead th {
            background: #182234 !important;
            color: #b8c5d8 !important;
            border-color: #39465b !important;
        }

        /* Cellules du tableau */
        html[data-app-theme="dark"] .tarifs-page .table,
        html[data-app-theme="dark"] .tarifs-page .table tbody,
        html[data-app-theme="dark"] .tarifs-page .table tbody tr,
        html[data-app-theme="dark"] .tarifs-page .table tbody td {
            background-color: #202a3b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        /* Survol des lignes */
        html[data-app-theme="dark"] .tarifs-page .table-hover tbody tr:hover td {
            background-color: #303b51 !important;
            color: #ffffff !important;
        }

        /* Montants */
        html[data-app-theme="dark"] .tarifs-page .tp-amount {
            color: #ad9fff !important;
        }

        /* Périodes et textes secondaires */
        html[data-app-theme="dark"] .tarifs-page .tp-period,
        html[data-app-theme="dark"] .tarifs-page .tp-empty {
            color: #a8b5c8 !important;
        }

        /* Badges */
        html[data-app-theme="dark"] .tarifs-page .tp-badge-active {
            color: #75e5a5 !important;
            background: #174331 !important;
        }

        html[data-app-theme="dark"] .tarifs-page .tp-badge-inactive {
            color: #c4cedb !important;
            background: #354154 !important;
        }

        /* Pagination */
        html[data-app-theme="dark"] .tarifs-page .pagination .page-link {
            color: #c1b7ff !important;
            background: #202a3b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarifs-page .pagination .active .page-link {
            color: #fff !important;
            background: #6256d9 !important;
            border-color: #6256d9 !important;
        }

        html[data-app-theme="dark"] .tarifs-page .tp-pagination-info {
            color: #a8b5c8 !important;
        }

        /* =====================================================
       THEME ULTRA PRO
    ===================================================== */

        html[data-app-theme="ultra-pro"] .tarifs-page {
            --tp-bg: #101827;
            --tp-card: #1b293d;
            --tp-text: #edf4ff;
            --tp-muted: #a4b4ca;
            --tp-border: #34445c;
            --tp-primary: #79bdff;
            --tp-soft: #243c59;
        }

        /* =====================================================
       THEME EMERALD
    ===================================================== */

        html[data-app-theme="emerald"] .tarifs-page {
            --tp-bg: #edf7f2;
            --tp-card: #ffffff;
            --tp-text: #173b30;
            --tp-muted: #638477;
            --tp-border: #d4e9df;
            --tp-primary: #13865c;
            --tp-soft: #dff5e9;
        }

        html[data-app-theme="emerald"] .tarifs-page .tp-hero {
            background: linear-gradient(120deg, #087b54, #22a879);
        }

        /* =====================================================
       THEME WARM
    ===================================================== */

        html[data-app-theme="warm"] .tarifs-page {
            --tp-bg: #faf3eb;
            --tp-card: #fffdf9;
            --tp-text: #493629;
            --tp-muted: #967d68;
            --tp-border: #eadbcb;
            --tp-primary: #bd7541;
            --tp-soft: #f8e8d8;
        }

        html[data-app-theme="warm"] .tarifs-page .tp-hero {
            background: linear-gradient(120deg, #a85d32, #d9955c);
        }

        /* =====================================================
       RESPONSIVE
    ===================================================== */

        @media(max-width: 768px) {
            .tarifs-page {
                padding: 12px;
            }

            .tarifs-page .tp-hero {
                padding: 22px;
            }

            .tarifs-page .tp-hero h2 {
                font-size: 21px;
            }

            .tarifs-page .tp-stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .tarifs-page .tp-card-header,
            .tarifs-page .tp-card-body {
                padding: 15px;
            }
        }
    </style>


    <div class="tarifs-page">

        {{-- EN-TÊTE --}}
        <div class="tp-hero">

            <div class="tp-breadcrumb">
                <a href="{{ route('dashboard') }}">Tableau de bord</a>
                <span class="mx-2">/</span>
                Gestion financière
                <span class="mx-2">/</span>
                Tarifs scolaires
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    <h2>
                        <i class="bi bi-cash-stack me-2"></i>
                        Tarifs scolaires
                    </h2>

                    <p>
                        Gestion des tarifs par type de frais, année scolaire et classe.
                    </p>
                </div>

                @if (auth()->user()->aPermission('frais.tarifs_gerer'))
                    <a href="{{ route('frais.tarifs.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-circle me-1"></i>
                        Ajouter un tarif
                    </a>
                @endif

            </div>
        </div>


        {{-- MESSAGES --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- STATISTIQUES --}}
        <div class="tp-stats">

            <div class="tp-stat">
                <div class="tp-stat-icon">
                    <i class="bi bi-collection"></i>
                </div>

                <div>
                    <div class="tp-stat-label">Nombre total de tarifs</div>
                    <div class="tp-stat-value">{{ $tarifs->total() }}</div>
                </div>
            </div>

            <div class="tp-stat">
                <div class="tp-stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>
                    <div class="tp-stat-label">Tarifs actifs</div>
                    <div class="tp-stat-value">
                        {{ $tarifs->getCollection()->where('actif', true)->count() }}
                    </div>
                </div>
            </div>

            <div class="tp-stat">
                <div class="tp-stat-icon">
                    <i class="bi bi-pause-circle"></i>
                </div>

                <div>
                    <div class="tp-stat-label">Tarifs inactifs</div>
                    <div class="tp-stat-value">
                        {{ $tarifs->getCollection()->where('actif', false)->count() }}
                    </div>
                </div>
            </div>

        </div>


        {{-- LISTE DES TARIFS --}}
        <div class="tp-card">

            <div class="tp-card-header">

                <div>
                    <h5>
                        <i class="bi bi-list-ul me-2"></i>
                        Liste des tarifs scolaires
                    </h5>

                    <small>
                        Consultez et gérez les tarifs enregistrés.
                    </small>
                </div>

                <span class="badge rounded-pill text-bg-primary">
                    {{ $tarifs->total() }} tarif(s)
                </span>

            </div>


            <div class="tp-card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Type de frais</th>
                                <th>Année scolaire</th>
                                <th>Classe</th>
                                <th>Montant</th>
                                <th>Période</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($tarifs as $tarif)
                                <tr>

                                    <td class="tp-muted">
                                        {{ $tarifs->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <div class="tp-type">
                                            <i class="bi bi-receipt me-1"></i>
                                            {{ $tarif->typeFrais->nom ?? 'Type supprimé' }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $tarif->anneeScolaire->nom ?? '—' }}
                                    </td>

                                    <td>
                                        {{ $tarif->classe->nom ?? '—' }}
                                    </td>

                                    <td>
                                        <span class="tp-amount">
                                            {{ number_format((float) $tarif->montant, 0, ',', ' ') }} Ar
                                        </span>
                                    </td>

                                    <td>
                                        <div class="tp-period">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $tarif->date_debut ? \Carbon\Carbon::parse($tarif->date_debut)->format('d/m/Y') : '—' }}

                                            <br>

                                            <span>au</span>

                                            {{ $tarif->date_fin ? \Carbon\Carbon::parse($tarif->date_fin)->format('d/m/Y') : '—' }}
                                        </div>
                                    </td>

                                    <td>
                                        @if ($tarif->actif)
                                            <span class="tp-badge tp-badge-active">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Actif
                                            </span>
                                        @else
                                            <span class="tp-badge tp-badge-inactive">
                                                <i class="bi bi-pause-circle-fill"></i>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="tp-actions">

                                            @if (auth()->user()->aPermission('frais.tarifs_voir'))
                                                <a href="{{ route('frais.tarifs.show', $tarif->id) }}"
                                                    class="btn btn-sm btn-outline-info" title="Consulter">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif

                                            @if (auth()->user()->aPermission('frais.tarifs_gerer'))
                                                <a href="{{ route('frais.tarifs.edit', $tarif->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Modifier">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="{{ route('frais.tarifs.destroy', $tarif->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer ce tarif ?');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                </form>
                                            @endif

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="tp-empty">

                                        <i class="bi bi-inbox"></i>

                                        <strong>
                                            Aucun tarif scolaire enregistré.
                                        </strong>

                                        <div class="mt-2">
                                            Ajoutez un tarif pour commencer.
                                        </div>

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- PAGINATION --}}
                @if ($tarifs->hasPages())
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">

                        <div class="tp-pagination-info">
                            Affichage de {{ $tarifs->firstItem() ?? 0 }}
                            à {{ $tarifs->lastItem() ?? 0 }}
                            sur {{ $tarifs->total() }} tarif(s)
                        </div>

                        {{ $tarifs->links() }}

                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
