@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 tarif-show-page">

        {{-- =========================
         VARIABLES ET STATISTIQUES
    ========================== --}}
        @php
            $nombreFrais = $tarif->elevesFrais->count();

            $totalMontantDu = $tarif->elevesFrais->sum('montant_du');

            $nombrePayes = $tarif->elevesFrais->where('statut', 'paye')->count();

            $nombrePartiels = $tarif->elevesFrais->where('statut', 'partiel')->count();

            $nombreImpayes = $tarif->elevesFrais->where('statut', 'impaye')->count();

            $pourcentagePaiement = $nombreFrais > 0 ? round(($nombrePayes / $nombreFrais) * 100) : 0;
        @endphp

        {{-- =========================
         EN-TÊTE
    ========================== --}}
        <div class="tarif-hero mb-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    <div class="tarif-breadcrumb mb-2">
                        <a href="{{ route('dashboard') }}">Tableau de bord</a>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('frais.tarifs.index') }}">Tarifs scolaires</a>
                        <i class="bi bi-chevron-right"></i>
                        <span>Détails</span>
                    </div>

                    <h2 class="mb-2">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Détails du tarif scolaire
                    </h2>

                    <p class="mb-0">
                        Consultation des informations et des frais associés à ce tarif.
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-2">

                    @if (auth()->user()->aPermission('frais.tarifs_gerer'))
                        <a href="{{ route('frais.tarifs.edit', $tarif->id) }}" class="btn btn-light tarif-action-btn">
                            <i class="bi bi-pencil-square me-1"></i>
                            Modifier
                        </a>
                    @endif

                    <a href="{{ route('frais.tarifs.index') }}" class="btn btn-outline-light tarif-action-btn">
                        <i class="bi bi-arrow-left me-1"></i>
                        Retour
                    </a>

                </div>

            </div>
        </div>

        {{-- =========================
         CARTES STATISTIQUES
    ========================== --}}
        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="tarif-stat-card">
                    <div class="tarif-stat-icon icon-primary">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <span class="tarif-stat-label">Frais générés</span>
                        <h3>{{ $nombreFrais }}</h3>
                        <small>Lignes de frais associées</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="tarif-stat-card">
                    <div class="tarif-stat-icon icon-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <span class="tarif-stat-label">Frais soldés</span>
                        <h3>{{ $nombrePayes }}</h3>
                        <small>Entièrement payés</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="tarif-stat-card">
                    <div class="tarif-stat-icon icon-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <span class="tarif-stat-label">Paiements partiels</span>
                        <h3>{{ $nombrePartiels }}</h3>
                        <small>Reste à payer</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="tarif-stat-card">
                    <div class="tarif-stat-icon icon-danger">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div>
                        <span class="tarif-stat-label">Frais impayés</span>
                        <h3>{{ $nombreImpayes }}</h3>
                        <small>En attente de paiement</small>
                    </div>
                </div>
            </div>

        </div>

        {{-- =========================
         INFORMATIONS GÉNÉRALES
    ========================== --}}
        <div class="tarif-card mb-4">

            <div class="tarif-card-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="tarif-header-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Informations générales</h5>
                        <small>Caractéristiques du tarif scolaire</small>
                    </div>
                </div>

                @if ($tarif->actif)
                    <span class="badge rounded-pill bg-success">
                        <i class="bi bi-check-circle me-1"></i> Actif
                    </span>
                @else
                    <span class="badge rounded-pill bg-secondary">
                        <i class="bi bi-pause-circle me-1"></i> Inactif
                    </span>
                @endif
            </div>

            <div class="tarif-card-body">

                <div class="row g-4">

                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="tarif-info-item">
                            <span class="tarif-info-label">
                                <i class="bi bi-receipt me-1"></i>
                                Type de frais
                            </span>
                            <strong>{{ $tarif->typeFrais->nom ?? '—' }}</strong>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="tarif-info-item">
                            <span class="tarif-info-label">
                                <i class="bi bi-calendar3 me-1"></i>
                                Année scolaire
                            </span>
                            <strong>{{ $tarif->anneeScolaire->nom ?? '—' }}</strong>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="tarif-info-item">
                            <span class="tarif-info-label">
                                <i class="bi bi-mortarboard me-1"></i>
                                Classe concernée
                            </span>
                            <strong>{{ $tarif->classe->nom ?? '—' }}</strong>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="tarif-info-item">
                            <span class="tarif-info-label">
                                <i class="bi bi-currency-exchange me-1"></i>
                                Montant du tarif
                            </span>
                            <strong class="tarif-amount">
                                {{ number_format((float) $tarif->montant, 0, ',', ' ') }} Ar
                            </strong>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="tarif-info-item">
                            <span class="tarif-info-label">
                                <i class="bi bi-calendar-check me-1"></i>
                                Date de début
                            </span>
                            <strong>
                                {{ $tarif->date_debut ? \Carbon\Carbon::parse($tarif->date_debut)->format('d/m/Y') : 'Non définie' }}
                            </strong>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="tarif-info-item">
                            <span class="tarif-info-label">
                                <i class="bi bi-calendar-x me-1"></i>
                                Date de fin
                            </span>
                            <strong>
                                {{ $tarif->date_fin ? \Carbon\Carbon::parse($tarif->date_fin)->format('d/m/Y') : 'Non définie' }}
                            </strong>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- =========================
         SUIVI DES FRAIS GÉNÉRÉS
    ========================== --}}
        <div class="tarif-card">

            <div class="tarif-card-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="tarif-header-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Frais générés pour les élèves</h5>
                        <small>Liste des frais associés à ce tarif</small>
                    </div>
                </div>

                <span class="badge rounded-pill bg-primary">
                    {{ $nombreFrais }} ligne(s)
                </span>
            </div>

            <div class="tarif-card-body">

                {{-- Résumé financier --}}
                <div class="tarif-summary mb-4">
                    <div>
                        <span class="tarif-info-label">Montant total dû</span>
                        <h4 class="mb-0 tarif-amount">
                            {{ number_format((float) $totalMontantDu, 0, ',', ' ') }} Ar
                        </h4>
                    </div>

                    <div class="tarif-progress-info">
                        <span class="tarif-info-label">Frais entièrement soldés</span>
                        <strong>{{ $pourcentagePaiement }} %</strong>
                        <div class="progress tarif-progress">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $pourcentagePaiement }}%" aria-valuenow="{{ $pourcentagePaiement }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">

                    <table class="table tarif-table align-middle">

                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Libellé</th>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Montant dû</th>
                                <th>Statut</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($tarif->elevesFrais as $frais)
                                <tr>
                                    <td>
                                        <span class="tarif-row-number">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        <strong>{{ $frais->libelle }}</strong>
                                    </td>

                                    <td>
                                        {{ $frais->mois ?: '—' }}
                                    </td>

                                    <td>
                                        {{ $frais->annee ?: '—' }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ number_format((float) $frais->montant_du, 0, ',', ' ') }} Ar
                                    </td>

                                    <td>
                                        @if ($frais->statut === 'paye')
                                            <span class="badge rounded-pill bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Payé
                                            </span>
                                        @elseif($frais->statut === 'partiel')
                                            <span class="badge rounded-pill bg-warning text-dark">
                                                <i class="bi bi-clock me-1"></i>
                                                Partiellement payé
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                Impayé
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="tarif-empty">
                                            <i class="bi bi-inbox"></i>
                                            <h6>Aucun frais généré</h6>
                                            <p class="mb-0">
                                                Aucun frais n'est encore associé à ce tarif.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                        @if ($nombreFrais > 0)
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total</th>
                                    <th colspan="2">
                                        {{ number_format((float) $totalMontantDu, 0, ',', ' ') }} Ar
                                    </th>
                                </tr>
                            </tfoot>
                        @endif

                    </table>

                </div>

                <div class="tarif-footer-note mt-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Les statuts affichés correspondent à la situation actuelle des frais.
                </div>

            </div>
        </div>

    </div>

    {{-- =========================
     STYLES
========================== --}}
    <style>
        .tarif-show-page {
            --ts-bg: #f4f7fb;
            --ts-card: #ffffff;
            --ts-text: #263449;
            --ts-muted: #748198;
            --ts-border: #e5eaf1;
            --ts-primary: #5265d8;
            --ts-soft: #eef1ff;
            color: var(--ts-text);
        }

        /* HERO */
        .tarif-show-page .tarif-hero {
            background: linear-gradient(125deg, #3347a8, #6879e8);
            color: #fff;
            padding: 28px 30px;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(52, 71, 168, .16);
        }

        .tarif-hero h2 {
            font-size: 1.55rem;
            font-weight: 750;
        }

        .tarif-hero p {
            color: rgba(255, 255, 255, .82);
        }

        .tarif-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            font-size: .82rem;
            color: rgba(255, 255, 255, .75);
        }

        .tarif-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .tarif-breadcrumb a:hover {
            text-decoration: underline;
        }

        .tarif-action-btn {
            border-radius: 9px;
            font-weight: 600;
            padding: 9px 15px;
        }

        /* STATISTIQUES */
        .tarif-stat-card {
            height: 100%;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 19px;
            background: var(--ts-card);
            border: 1px solid var(--ts-border);
            border-radius: 15px;
            box-shadow: 0 3px 12px rgba(25, 42, 70, .045);
        }

        .tarif-stat-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            font-size: 1.35rem;
        }

        .icon-primary {
            background: #e9edff;
            color: #5265d8;
        }

        .icon-success {
            background: #e4f7ed;
            color: #198754;
        }

        .icon-warning {
            background: #fff4db;
            color: #d18b00;
        }

        .icon-danger {
            background: #fde8e8;
            color: #dc3545;
        }

        .tarif-stat-label {
            display: block;
            color: var(--ts-muted);
            font-size: .82rem;
            margin-bottom: 3px;
        }

        .tarif-stat-card h3 {
            font-size: 1.55rem;
            font-weight: 750;
            margin: 0;
            color: var(--ts-text);
        }

        .tarif-stat-card small {
            color: var(--ts-muted);
            font-size: .76rem;
        }

        /* CARTES */
        .tarif-card {
            background: var(--ts-card);
            border: 1px solid var(--ts-border);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(25, 42, 70, .045);
        }

        .tarif-card-header {
            min-height: 76px;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            border-bottom: 1px solid var(--ts-border);
        }

        .tarif-card-header h5 {
            font-weight: 700;
            color: var(--ts-text);
            font-size: 1rem;
        }

        .tarif-card-header small {
            color: var(--ts-muted);
            font-size: .78rem;
        }

        .tarif-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: var(--ts-soft);
            color: var(--ts-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }

        .tarif-card-body {
            padding: 24px;
        }

        /* INFORMATIONS */
        .tarif-info-item {
            height: 100%;
            padding: 15px;
            border: 1px solid var(--ts-border);
            background: var(--ts-bg);
            border-radius: 11px;
        }

        .tarif-info-label {
            display: block;
            color: var(--ts-muted);
            font-size: .8rem;
            margin-bottom: 7px;
        }

        .tarif-info-item strong {
            display: block;
            color: var(--ts-text);
            font-size: .96rem;
            font-weight: 650;
            overflow-wrap: anywhere;
        }

        .tarif-amount {
            color: var(--ts-primary) !important;
            font-weight: 750 !important;
        }

        /* RÉSUMÉ */
        .tarif-summary {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            padding: 19px;
            background: var(--ts-bg);
            border: 1px solid var(--ts-border);
            border-radius: 12px;
        }

        .tarif-progress-info {
            width: 100%;
            max-width: 270px;
        }

        .tarif-progress-info strong {
            display: block;
            margin-bottom: 7px;
            color: var(--ts-text);
            font-size: 1.1rem;
        }

        .tarif-progress {
            height: 8px;
            border-radius: 20px;
            background: var(--ts-border);
        }

        /* TABLEAU */
        .tarif-table {
            margin-bottom: 0;
            color: var(--ts-text);
            border-color: var(--ts-border);
        }

        .tarif-table thead th {
            padding: 14px 12px;
            background: var(--ts-bg);
            color: var(--ts-muted);
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid var(--ts-border);
        }

        .tarif-table tbody td {
            padding: 14px 12px;
            color: var(--ts-text);
            border-color: var(--ts-border);
            font-size: .88rem;
        }

        .tarif-table tbody tr:hover td {
            background: var(--ts-soft);
        }

        .tarif-table tfoot th {
            padding: 16px 12px;
            background: var(--ts-bg);
            color: var(--ts-text);
            border-color: var(--ts-border);
        }

        .tarif-row-number {
            display: inline-flex;
            width: 29px;
            height: 29px;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--ts-soft);
            color: var(--ts-primary);
            font-weight: 700;
            font-size: .8rem;
        }

        .tarif-empty {
            color: var(--ts-muted);
        }

        .tarif-empty>i {
            display: block;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .tarif-empty h6 {
            color: var(--ts-text);
            font-weight: 700;
        }

        .tarif-footer-note {
            color: var(--ts-muted);
            font-size: .8rem;
        }

        /* =========================
       MODE SOMBRE
    ========================= */
        html[data-app-theme="dark"] .tarif-show-page {
            --ts-bg: #151c2b;
            --ts-card: #202a3b;
            --ts-text: #edf2fa;
            --ts-muted: #a8b5c8;
            --ts-border: #39465b;
            --ts-primary: #ad9fff;
            --ts-soft: #343052;
            background: #151c2b !important;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarif-show-page .tarif-card,
        html[data-app-theme="dark"] .tarif-show-page .tarif-stat-card {
            background: #202a3b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarif-show-page .tarif-card-header,
        html[data-app-theme="dark"] .tarif-show-page .tarif-info-item,
        html[data-app-theme="dark"] .tarif-show-page .tarif-summary,
        html[data-app-theme="dark"] .tarif-show-page .tarif-table thead th,
        html[data-app-theme="dark"] .tarif-show-page .tarif-table tfoot th {
            background: #151c2b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarif-show-page .tarif-table,
        html[data-app-theme="dark"] .tarif-show-page .tarif-table tbody tr,
        html[data-app-theme="dark"] .tarif-show-page .tarif-table tbody td {
            background-color: #202a3b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarif-show-page .tarif-table tbody tr:hover td {
            background: #343052 !important;
        }

        html[data-app-theme="dark"] .tarif-show-page .tarif-card-header h5,
        html[data-app-theme="dark"] .tarif-show-page .tarif-info-item strong,
        html[data-app-theme="dark"] .tarif-show-page .tarif-stat-card h3,
        html[data-app-theme="dark"] .tarif-show-page .tarif-table tfoot th,
        html[data-app-theme="dark"] .tarif-show-page .tarif-empty h6 {
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarif-show-page .tarif-stat-icon {
            background: #343052 !important;
            color: #c0b5ff !important;
        }

        html[data-app-theme="dark"] .tarif-show-page .tarif-row-number {
            background: #343052 !important;
            color: #c0b5ff !important;
        }

        /* =========================
       ULTRA PRO
    ========================= */
        html[data-app-theme="ultra-pro"] .tarif-show-page {
            --ts-bg: #182337;
            --ts-card: #202d43;
            --ts-text: #eaf0fa;
            --ts-muted: #aab8ce;
            --ts-border: #34445e;
            --ts-primary: #7eb7ff;
            --ts-soft: #293d5c;
        }

        html[data-app-theme="ultra-pro"] .tarif-show-page .tarif-card,
        html[data-app-theme="ultra-pro"] .tarif-show-page .tarif-stat-card {
            background: #202d43;
            border-color: #34445e;
        }

        html[data-app-theme="ultra-pro"] .tarif-show-page .tarif-info-item,
        html[data-app-theme="ultra-pro"] .tarif-show-page .tarif-summary,
        html[data-app-theme="ultra-pro"] .tarif-show-page .tarif-table thead th,
        html[data-app-theme="ultra-pro"] .tarif-show-page .tarif-table tfoot th {
            background: #182337;
        }

        /* =========================
       EMERALD
    ========================= */
        html[data-app-theme="emerald"] .tarif-show-page {
            --ts-bg: #effaf5;
            --ts-card: #ffffff;
            --ts-text: #173f32;
            --ts-muted: #648477;
            --ts-border: #cfe9dc;
            --ts-primary: #13865d;
            --ts-soft: #dcf5e9;
        }

        html[data-app-theme="emerald"] .tarif-show-page .tarif-hero {
            background: linear-gradient(125deg, #08734e, #20a477);
        }

        /* =========================
       WARM
    ========================= */
        html[data-app-theme="warm"] .tarif-show-page {
            --ts-bg: #fff8f0;
            --ts-card: #ffffff;
            --ts-text: #513b2d;
            --ts-muted: #927866;
            --ts-border: #f0dfce;
            --ts-primary: #c4773e;
            --ts-soft: #fbe8d7;
        }

        html[data-app-theme="warm"] .tarif-show-page .tarif-hero {
            background: linear-gradient(125deg, #a95d35, #d99559);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .tarif-show-page .tarif-hero {
                padding: 22px 18px;
            }

            .tarif-hero h2 {
                font-size: 1.25rem;
            }

            .tarif-card-body {
                padding: 17px;
            }

            .tarif-card-header {
                padding: 14px 16px;
            }

            .tarif-summary {
                align-items: flex-start;
                flex-direction: column;
            }

            .tarif-progress-info {
                max-width: 100%;
            }
        }
    </style>
@endsection
