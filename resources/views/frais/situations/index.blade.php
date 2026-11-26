@extends('layouts.app')

@section('content')
    @php
        $totalGeneralDu = $totalGeneralDu ?? 0;
        $totalGeneralPaye = $totalGeneralPaye ?? 0;
        $totalGeneralReste = $totalGeneralReste ?? 0;
    @endphp

    <div class="situations-page">
        <div class="container-fluid py-4">

            {{-- EN-TÊTE --}}
            <div class="situations-hero mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <div class="situations-eyebrow">
                            <i class="bi bi-wallet2"></i>
                            GESTION FINANCIÈRE
                        </div>

                        <h2 class="fw-bold mb-2">Situations financières</h2>

                        <p class="mb-0">
                            Consultez les frais scolaires, les paiements et les soldes des élèves.
                        </p>
                    </div>

                    <div class="situations-hero-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>

            </div>

            {{-- MESSAGES --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- INDICATEURS --}}
            <div class="row g-3 mb-4">

                <div class="col-xl-4 col-md-6">
                    <div class="situation-stat-card stat-due">
                        <div>
                            <div class="stat-label">Total des frais dus</div>
                            <div class="stat-value">
                                {{ number_format($totalGeneralDu, 0, ',', ' ') }} Ar
                            </div>
                            <div class="stat-description">Montant total à régler</div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="situation-stat-card stat-paid">
                        <div>
                            <div class="stat-label">Total des paiements</div>
                            <div class="stat-value">
                                {{ number_format($totalGeneralPaye, 0, ',', ' ') }} Ar
                            </div>
                            <div class="stat-description">Montant déjà encaissé</div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="situation-stat-card stat-remaining">
                        <div>
                            <div class="stat-label">Reste total à payer</div>
                            <div class="stat-value">
                                {{ number_format($totalGeneralReste, 0, ',', ' ') }} Ar
                            </div>
                            <div class="stat-description">Solde restant à recouvrer</div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- LISTE DES ÉLÈVES --}}
            <div class="situation-panel">

                <div class="situation-panel-header">
                    <div>
                        <h5 class="mb-1">
                            <i class="bi bi-people me-2"></i>
                            Liste des situations financières
                        </h5>
                        <p class="mb-0">Suivi individuel des frais et des règlements</p>
                    </div>

                    <span class="situation-count">
                        <i class="bi bi-person-check me-1"></i>
                        {{ $eleves->total() }} élève(s)
                    </span>
                </div>

                <div class="situation-panel-body">

                    {{-- RECHERCHE ET FILTRES --}}
                    <form method="GET" action="{{ route('frais.situations.index') }}" class="situation-filter-form mb-4">

                        <div class="filter-heading">
                            <i class="bi bi-funnel"></i>
                            Recherche et filtres
                        </div>

                        <div class="row g-3">

                            <div class="col-lg-3 col-md-6">
                                <label class="form-label">Rechercher un élève</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" name="recherche" class="form-control"
                                        placeholder="Nom, prénom ou matricule..." value="{{ request('recherche') }}">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <label class="form-label">Classe</label>
                                <select name="classe_id" class="form-select">
                                    <option value="">Toutes les classes</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{ $classe->id }}"
                                            {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <label class="form-label">Année scolaire</label>
                                <select name="annee" class="form-select">
                                    <option value="">Toutes les années</option>
                                    @foreach ($annees as $annee)
                                        <option value="{{ $annee }}"
                                            {{ request('annee') == $annee ? 'selected' : '' }}>
                                            {{ $annee }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <label class="form-label">Situation</label>
                                <select name="statut" class="form-select">
                                    <option value="">Toutes</option>
                                    <option value="impaye" {{ request('statut') == 'impaye' ? 'selected' : '' }}>
                                        Impayé
                                    </option>
                                    <option value="partiel" {{ request('statut') == 'partiel' ? 'selected' : '' }}>
                                        Partiel
                                    </option>
                                    <option value="paye" {{ request('statut') == 'paye' ? 'selected' : '' }}>
                                        Payé
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-search me-1"></i>
                                    Filtrer
                                </button>

                                <a href="{{ route('frais.situations.index') }}"
                                    class="btn btn-outline-secondary reset-filter" title="Réinitialiser les filtres">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>

                        </div>
                    </form>

                    {{-- TABLEAU --}}
                    <div class="table-responsive situation-table-scroll">
                        <table class="table situation-table align-middle">

                            <thead>
                                <tr>
                                    <th>Élève</th>
                                    <th>Matricule</th>
                                    <th>Classe</th>
                                    <th class="text-end">Total dû</th>
                                    <th class="text-end">Total payé</th>
                                    <th class="text-end">Reste à payer</th>
                                    <th>Situation</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($eleves as $eleve)
                                    @php
                                        if ($eleve->total_du <= 0 && $eleve->total_paye <= 0) {
                                            $statut = 'aucun';
                                        } elseif ($eleve->reste_a_payer <= 0.009) {
                                            $statut = 'paye';
                                        } elseif ($eleve->total_paye > 0) {
                                            $statut = 'partiel';
                                        } else {
                                            $statut = 'impaye';
                                        }
                                    @endphp

                                    <tr>
                                        <td>
                                            <div class="student-name">
                                                <div class="student-avatar">
                                                    @if ($eleve->photo)
                                                        <img src="{{ asset('storage/' . $eleve->photo) }}"
                                                            alt="Photo de {{ $eleve->nom }} {{ $eleve->prenom }}"
                                                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($eleve->nom . ' ' . $eleve->prenom) }}&background=e9edff&color=5267d8';">
                                                    @else
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($eleve->nom . ' ' . $eleve->prenom) }}&background=e9edff&color=5267d8"
                                                            alt="Avatar de {{ $eleve->nom }}">
                                                    @endif
                                                </div>
                                                <span>
                                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                                </span>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="student-matricule">
                                                {{ $eleve->matricule }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="class-label">
                                                {{ $eleve->classe->nom ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="text-end amount-cell">
                                            {{ number_format($eleve->total_du, 0, ',', ' ') }} Ar
                                        </td>

                                        <td class="text-end amount-cell amount-paid">
                                            {{ number_format($eleve->total_paye, 0, ',', ' ') }} Ar
                                        </td>

                                        <td class="text-end amount-cell amount-remaining">
                                            {{ number_format($eleve->reste_a_payer, 0, ',', ' ') }} Ar
                                        </td>

                                        <td>
                                            @if ($statut === 'aucun')
                                                <span class="status-badge status-none">
                                                    <i class="bi bi-dash-circle"></i>
                                                    Aucun frais
                                                </span>
                                            @elseif ($statut === 'paye')
                                                <span class="status-badge status-paid">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Payé
                                                </span>
                                            @elseif ($statut === 'partiel')
                                                <span class="status-badge status-partial">
                                                    <i class="bi bi-clock-fill"></i>
                                                    Partiel
                                                </span>
                                            @else
                                                <span class="status-badge status-unpaid">
                                                    <i class="bi bi-exclamation-circle-fill"></i>
                                                    Impayé
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('frais.situations.show', $eleve->id) }}"
                                                class="btn btn-sm btn-outline-primary view-situation-btn"
                                                title="Voir la situation financière">
                                                <i class="bi bi-eye me-1"></i>
                                                Voir
                                            </a>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="bi bi-inbox"></i>
                                                <h6>Aucun élève trouvé</h6>
                                                <p class="mb-0">
                                                    Aucun résultat ne correspond à votre recherche.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    @if ($eleves->hasPages())
                        <div class="situation-pagination mt-4">
                            {{ $eleves->withQueryString()->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <style>
        /* =====================================================
                   SITUATIONS FINANCIÈRES - THÈME PAR DÉFAUT
                ===================================================== */

        .situations-page {
            --sf-bg: #f4f6fb;
            --sf-card: #ffffff;
            --sf-text: #263247;
            --sf-muted: #7c899d;
            --sf-border: #e5eaf2;
            --sf-primary: #5267d8;
            --sf-primary-soft: #edf0ff;
            --sf-input: #ffffff;

            color: var(--sf-text);
        }

        .situations-page .situations-hero {
            background: linear-gradient(120deg, #263d83, #5267d8 60%, #7b78df);
            color: #ffffff;
            border-radius: 18px;
            padding: 28px 32px;
            box-shadow: 0 8px 24px rgba(54, 73, 150, .16);
        }

        .situations-eyebrow {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.8px;
            opacity: .8;
            margin-bottom: 10px;
        }

        .situations-eyebrow i {
            margin-right: 5px;
        }

        .situations-hero h2 {
            font-size: 27px;
        }

        .situations-hero p {
            color: rgba(255, 255, 255, .8);
            font-size: 14px;
        }

        .situations-hero-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .15);
            font-size: 34px;
        }

        .situations-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 12px;
            color: rgba(255, 255, 255, .7);
        }

        .situations-breadcrumb strong {
            color: #ffffff;
        }

        .situation-stat-card {
            min-height: 132px;
            padding: 22px;
            border-radius: 16px;
            background: var(--sf-card);
            border: 1px solid var(--sf-border);
            box-shadow: 0 4px 16px rgba(30, 45, 80, .045);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .situation-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 22px rgba(30, 45, 80, .09);
        }

        .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--sf-muted);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 23px;
            font-weight: 800;
            color: var(--sf-text);
            line-height: 1.3;
        }

        .stat-description {
            font-size: 11px;
            color: var(--sf-muted);
            margin-top: 7px;
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .stat-due .stat-icon {
            background: #edf0ff;
            color: #5267d8;
        }

        .stat-paid .stat-icon {
            background: #e4f7ed;
            color: #15945a;
        }

        .stat-remaining .stat-icon {
            background: #fff0ed;
            color: #dc574b;
        }

        .situation-panel {
            background: var(--sf-card);
            border: 1px solid var(--sf-border);
            border-radius: 17px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(30, 45, 80, .045);
        }

        .situation-panel-header {
            padding: 21px 24px;
            border-bottom: 1px solid var(--sf-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .situation-panel-header h5 {
            font-size: 16px;
            font-weight: 800;
            color: var(--sf-text);
        }

        .situation-panel-header p {
            font-size: 12px;
            color: var(--sf-muted);
        }

        .situation-panel-header h5 i {
            color: var(--sf-primary);
        }

        .situation-count {
            background: var(--sf-primary-soft);
            color: var(--sf-primary);
            border-radius: 30px;
            padding: 7px 13px;
            font-size: 12px;
            font-weight: 700;
        }

        .situation-panel-body {
            padding: 24px;
        }

        .situation-filter-form {
            padding: 19px;
            border: 1px solid var(--sf-border);
            border-radius: 13px;
            background: var(--sf-bg);
        }

        .filter-heading {
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 17px;
            color: var(--sf-text);
        }

        .filter-heading i {
            color: var(--sf-primary);
            margin-right: 7px;
        }

        .situation-filter-form .form-label {
            color: var(--sf-text);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .situation-filter-form .form-control,
        .situation-filter-form .form-select,
        .situation-filter-form .input-group-text {
            min-height: 41px;
            background-color: var(--sf-input);
            border-color: var(--sf-border);
            color: var(--sf-text);
            font-size: 12px;
        }

        .situation-filter-form .input-group-text {
            color: var(--sf-muted);
        }

        .situation-filter-form .form-control:focus,
        .situation-filter-form .form-select:focus {
            border-color: var(--sf-primary);
            box-shadow: 0 0 0 .2rem rgba(82, 103, 216, .12);
        }

        .situation-filter-form .btn-primary {
            min-height: 41px;
            background: var(--sf-primary);
            border-color: var(--sf-primary);
            font-size: 12px;
            font-weight: 700;
        }

        .reset-filter {
            min-width: 43px;
            min-height: 41px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .situation-table {
            margin-bottom: 0;
            color: var(--sf-text);
            font-size: 12px;
            border-color: var(--sf-border);
        }

        .situation-table thead th {
            background: var(--sf-bg);
            color: var(--sf-muted);
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 15px 12px;
            white-space: nowrap;
            border-bottom: 1px solid var(--sf-border);
        }

        .situation-table tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--sf-border);
            background: var(--sf-card);
            color: var(--sf-text);
        }

        .situation-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .situation-table tbody tr:hover td {
            background: var(--sf-bg);
        }

        .student-name {
            display: flex;
            align-items: center;
            gap: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .student-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--sf-primary-soft);
            border: 2px solid var(--sf-border);
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .student-matricule {
            color: var(--sf-muted);
            font-size: 11px;
            font-weight: 600;
        }

        .class-label {
            display: inline-block;
            background: var(--sf-bg);
            border: 1px solid var(--sf-border);
            border-radius: 6px;
            padding: 5px 8px;
            font-size: 11px;
            font-weight: 600;
        }

        .amount-cell {
            font-weight: 700;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        .amount-paid {
            color: #15945a !important;
        }

        .amount-remaining {
            color: #dc574b !important;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 30px;
            padding: 6px 10px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-none {
            color: #6b7280;
            background: #eef0f3;
        }

        .status-paid {
            color: #13834e;
            background: #e1f6e9;
        }

        .status-partial {
            color: #956300;
            background: #fff1c9;
        }

        .status-unpaid {
            color: #c23c36;
            background: #ffe5e2;
        }

        .view-situation-btn {
            border-radius: 7px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .empty-state {
            padding: 20px;
            color: var(--sf-muted);
        }

        .empty-state>i {
            font-size: 38px;
            margin-bottom: 12px;
            opacity: .55;
        }

        .empty-state h6 {
            color: var(--sf-text);
            font-weight: 800;
        }

        .empty-state p {
            font-size: 12px;
        }

        .situation-pagination {
            display: flex;
            justify-content: flex-end;
        }

        .situation-pagination .pagination {
            margin-bottom: 0;
        }

        .situation-pagination .page-link {
            background: var(--sf-card);
            border-color: var(--sf-border);
            color: var(--sf-text);
            font-size: 12px;
        }

        .situation-pagination .active .page-link {
            background: var(--sf-primary);
            border-color: var(--sf-primary);
            color: #ffffff;
        }

        /* =====================================================
                   MODE SOMBRE
                ===================================================== */

        html[data-app-theme="dark"] .situations-page {
            --sf-bg: #151c2b;
            --sf-card: #202a3b;
            --sf-text: #edf2fa;
            --sf-muted: #a8b5c8;
            --sf-border: #39465b;
            --sf-primary: #ad9fff;
            --sf-primary-soft: #343052;
            --sf-input: #182235;

            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-stat-card,
        html[data-app-theme="dark"] .situations-page .situation-panel {
            background: #202a3b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-filter-form {
            background: #182235 !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-table {
            --bs-table-bg: #202a3b;
            --bs-table-color: #edf2fa;
            --bs-table-hover-bg: #29364b;
            --bs-table-hover-color: #ffffff;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-table thead th {
            background: #182235 !important;
            color: #b7c4d8 !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-table tbody td,
        html[data-app-theme="dark"] .situations-page .situation-table tbody tr,
        html[data-app-theme="dark"] .situations-page .situation-table tbody th {
            background-color: #202a3b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-table tbody tr:hover td {
            background-color: #29364b !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-table .amount-paid {
            color: #6ee7a5 !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-table .amount-remaining {
            color: #ff9c91 !important;
        }

        html[data-app-theme="dark"] .situations-page .student-matricule,
        html[data-app-theme="dark"] .situations-page .stat-label,
        html[data-app-theme="dark"] .situations-page .stat-description {
            color: #a8b5c8 !important;
        }

        html[data-app-theme="dark"] .situations-page .class-label {
            background: #182235 !important;
            border-color: #39465b !important;
            color: #dce5f3 !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-filter-form .form-control,
        html[data-app-theme="dark"] .situations-page .situation-filter-form .form-select,
        html[data-app-theme="dark"] .situations-page .situation-filter-form .input-group-text {
            background-color: #182235 !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-filter-form .form-control::placeholder {
            color: #8998ad !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-filter-form select option {
            background: #202a3b;
            color: #edf2fa;
        }

        html[data-app-theme="dark"] .situations-page .situation-panel-header {
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situations-page .situation-count {
            background: #343052 !important;
            color: #c6bbff !important;
        }

        html[data-app-theme="dark"] .situations-page .status-none {
            background: #374151 !important;
            color: #d1d5db !important;
        }

        html[data-app-theme="dark"] .situations-page .status-paid {
            background: #164b35 !important;
            color: #8df0b6 !important;
        }

        html[data-app-theme="dark"] .situations-page .status-partial {
            background: #59451b !important;
            color: #ffdb82 !important;
        }

        html[data-app-theme="dark"] .situations-page .status-unpaid {
            background: #5b2928 !important;
            color: #ffaaa3 !important;
        }

        html[data-app-theme="dark"] .situations-page .pagination .page-link {
            background: #202a3b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situations-page .pagination .active .page-link {
            background: #6256b8 !important;
            color: #ffffff !important;
            border-color: #6256b8 !important;
        }

        /* =====================================================
                   THÈME ULTRA PRO
                ===================================================== */

        html[data-app-theme="ultra-pro"] .situations-page {
            --sf-bg: #151b2b;
            --sf-card: #20283b;
            --sf-text: #f0f3fa;
            --sf-muted: #a8b3c8;
            --sf-border: #39445d;
            --sf-primary: #d6b46a;
            --sf-primary-soft: #3c3528;
            --sf-input: #182235;
        }

        html[data-app-theme="ultra-pro"] .situations-page .situations-hero {
            background: linear-gradient(120deg, #111827, #29344d 65%, #725b32);
        }

        html[data-app-theme="ultra-pro"] .situations-page .situation-table thead th {
            background: #182235;
            color: #d6b46a;
        }

        /* =====================================================
                   THÈME EMERALD
                ===================================================== */

        html[data-app-theme="emerald"] .situations-page {
            --sf-bg: #eaf5f0;
            --sf-card: #ffffff;
            --sf-text: #173b30;
            --sf-muted: #648276;
            --sf-border: #cce4d8;
            --sf-primary: #16865c;
            --sf-primary-soft: #dff3e9;
            --sf-input: #ffffff;
        }

        html[data-app-theme="emerald"] .situations-page .situations-hero {
            background: linear-gradient(120deg, #075b43, #16865c, #38a77b);
        }

        /* =====================================================
                   THÈME WARM
                ===================================================== */

        html[data-app-theme="warm"] .situations-page {
            --sf-bg: #fbf3e9;
            --sf-card: #fffdf9;
            --sf-text: #4a3528;
            --sf-muted: #927967;
            --sf-border: #ead8c6;
            --sf-primary: #b87542;
            --sf-primary-soft: #f7e9da;
            --sf-input: #fffdf9;
        }

        html[data-app-theme="warm"] .situations-page .situations-hero {
            background: linear-gradient(120deg, #74452f, #b87542, #d39a65);
        }

        /* =====================================================
                   RESPONSIVE
                ===================================================== */

        @media (max-width: 768px) {
            .situations-page .situations-hero {
                padding: 22px;
            }

            .situations-hero h2 {
                font-size: 22px;
            }

            .situations-hero-icon {
                width: 55px;
                height: 55px;
                font-size: 25px;
            }

            .situation-panel-body {
                padding: 15px;
            }

            .situation-stat-card {
                min-height: 110px;
                padding: 17px;
            }

            .stat-value {
                font-size: 19px;
            }

            .situation-filter-form {
                padding: 15px;
            }
        }

        /* Défilement de la liste des élèves */
        .situation-table-scroll {
            max-height: 550px;
            overflow-y: auto;
            overflow-x: auto;
            border: 1px solid var(--sf-border);
            border-radius: 10px;
        }

        /* En-tête fixe pendant le défilement */
        .situation-table-scroll thead th {
            position: sticky;
            top: 0;
            z-index: 5;
        }

        /* Barre de défilement */
        .situation-table-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .situation-table-scroll::-webkit-scrollbar-thumb {
            background: #9aa7bd;
            border-radius: 10px;
        }

        .situation-table-scroll::-webkit-scrollbar-track {
            background: var(--sf-bg);
        }
    </style>
@endsection
