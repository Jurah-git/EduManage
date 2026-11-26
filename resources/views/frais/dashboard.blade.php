@extends('layouts.app')

@section('content')

    @php
        $maxMontantMois = max($montantsMois ?: [1]);
        $maxMontantMois = max($maxMontantMois, 1);

        $moisActuel = now()->translatedFormat('F Y');

        $nomEleve = function ($eleve) {
            return $eleve ? trim(($eleve->nom ?? '') . ' ' . ($eleve->prenom ?? '')) : 'Élève inconnu';
        };

        $formatMontant = function ($montant) {
            return number_format((float) $montant, 0, ',', ' ') . ' Ar';
        };
    @endphp

    <div class="container-fluid py-4 finance-dashboard">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="fd-hero mb-4">
            <div class="fd-hero-content">
                <div>
                    <div class="fd-eyebrow">
                        <i class="bi bi-bar-chart-line me-2"></i>
                        GESTION FINANCIÈRE
                    </div>

                    <h2>Tableau de bord financier</h2>

                    <p>
                        Suivez les encaissements et les frais scolaires de votre établissement.
                    </p>

                    <div class="fd-date">
                        <i class="bi bi-calendar3 me-2"></i>
                        {{ now()->translatedFormat('l d F Y') }}
                    </div>
                </div>

                <div class="fd-hero-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>

        {{-- =====================================================
             INDICATEURS PRINCIPAUX
        ====================================================== --}}
        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="fd-stat-card stat-blue">
                    <div class="fd-stat-top">
                        <div class="fd-stat-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <span class="fd-stat-label">ENCAISSEMENTS</span>
                    </div>

                    <div class="fd-stat-value">
                        {{ $formatMontant($totalEncaisse) }}
                    </div>

                    <div class="fd-stat-footer">
                        <i class="bi bi-check-circle-fill"></i>
                        Total des paiements validés
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="fd-stat-card stat-green">
                    <div class="fd-stat-top">
                        <div class="fd-stat-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <span class="fd-stat-label">CE MOIS-CI</span>
                    </div>

                    <div class="fd-stat-value">
                        {{ $formatMontant($totalEncaisseMois) }}
                    </div>

                    <div class="fd-stat-footer">
                        <i class="bi bi-calendar3"></i>
                        {{ ucfirst($moisActuel) }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="fd-stat-card stat-orange">
                    <div class="fd-stat-top">
                        <div class="fd-stat-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <span class="fd-stat-label">À RECOUVRER</span>
                    </div>

                    <div class="fd-stat-value">
                        {{ $formatMontant($totalResteARecouvrer) }}
                    </div>

                    <div class="fd-stat-footer">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Solde restant des frais scolaires
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="fd-stat-card stat-purple">
                    <div class="fd-stat-top">
                        <div class="fd-stat-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <span class="fd-stat-label">PAIEMENTS VALIDÉS</span>
                    </div>

                    <div class="fd-stat-value">
                        {{ number_format($nombrePaiements, 0, ',', ' ') }}
                    </div>

                    <div class="fd-stat-footer">
                        <i class="bi bi-calendar-event"></i>
                        {{ $nombrePaiementsMois }} ce mois-ci
                    </div>
                </div>
            </div>

        </div>

        {{-- =====================================================
             GRAPHIQUE ET RÉSUMÉ
        ====================================================== --}}
        <div class="row g-3 mb-4">

            {{-- ÉVOLUTION DES ENCAISSEMENTS --}}
            <div class="col-12 col-xl-8">
                <div class="fd-panel h-100">

                    <div class="fd-panel-header">
                        <div>
                            <h5>
                                <i class="bi bi-graph-up-arrow me-2"></i>
                                Évolution des encaissements
                            </h5>
                            <p>Comparaison des six derniers mois</p>
                        </div>

                        <span class="fd-panel-badge">
                            6 mois
                        </span>
                    </div>

                    <div class="fd-chart">

                        @foreach ($labelsMois as $index => $label)
                            @php
                                $montant = $montantsMois[$index] ?? 0;
                                $hauteur = $montant > 0 ? max(4, ($montant / $maxMontantMois) * 100) : 0;
                            @endphp

                            <div class="fd-chart-column">

                                <div class="fd-chart-value">
                                    @if ($montant > 0)
                                        {{ number_format($montant / 1000000, 2, ',', ' ') }} M
                                    @else
                                        —
                                    @endif
                                </div>

                                <div class="fd-chart-track">
                                    <div class="fd-chart-bar" style="height: {{ $hauteur }}%">
                                    </div>
                                </div>

                                <div class="fd-chart-label">
                                    {{ $label }}
                                </div>

                            </div>
                        @endforeach

                    </div>

                    <div class="fd-chart-legend">
                        <span class="fd-legend-dot"></span>
                        Montant encaissé en Ariary
                    </div>

                </div>
            </div>

            {{-- RÉSUMÉ DES FRAIS --}}
            <div class="col-12 col-xl-4">
                <div class="fd-panel h-100">

                    <div class="fd-panel-header">
                        <div>
                            <h5>
                                <i class="bi bi-clipboard-data me-2"></i>
                                Situation des frais
                            </h5>
                            <p>État des règlements en attente</p>
                        </div>
                    </div>

                    <div class="fd-summary-list">

                        <div class="fd-summary-item">
                            <div class="fd-summary-icon unpaid">
                                <i class="bi bi-exclamation-circle"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="fd-summary-title">Frais impayés</div>
                                <div class="fd-summary-subtitle">Non encore réglés</div>
                            </div>

                            <div class="fd-summary-number">
                                {{ $nombreFraisImpayes }}
                            </div>
                        </div>

                        <div class="fd-summary-item">
                            <div class="fd-summary-icon partial">
                                <i class="bi bi-clock-history"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="fd-summary-title">Frais partiels</div>
                                <div class="fd-summary-subtitle">Paiement incomplet</div>
                            </div>

                            <div class="fd-summary-number">
                                {{ $nombreFraisPartiels }}
                            </div>
                        </div>

                        <div class="fd-summary-item">
                            <div class="fd-summary-icon students">
                                <i class="bi bi-people"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="fd-summary-title">Élèves concernés</div>
                                <div class="fd-summary-subtitle">Avec un solde restant</div>
                            </div>

                            <div class="fd-summary-number">
                                {{ $nombreElevesAvecSolde }}
                            </div>
                        </div>

                        <div class="fd-summary-item">
                            <div class="fd-summary-icon cancelled">
                                <i class="bi bi-x-circle"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="fd-summary-title">Paiements annulés</div>
                                <div class="fd-summary-subtitle">Montant total annulé</div>
                            </div>

                            <div class="fd-summary-amount">
                                {{ $formatMontant($totalAnnule) }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- =====================================================
             DERNIERS PAIEMENTS
        ====================================================== --}}
        <div class="fd-panel mb-4">

            <div class="fd-panel-header">
                <div>
                    <h5>
                        <i class="bi bi-receipt-cutoff me-2"></i>
                        Derniers paiements
                    </h5>
                    <p>Les huit dernières opérations enregistrées</p>
                </div>

                @if (auth()->user()->aPermission('frais.paiements_voir'))
                    <a href="{{ route('frais.paiements.index') }}" class="fd-link">
                        Voir tous les paiements
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                @endif
            </div>

            <div class="fd-table-wrapper">
                <table class="table fd-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Élève</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Mode</th>
                            <th>Statut</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($derniersPaiements as $paiement)
                            <tr>
                                <td>
                                    <span class="fd-reference">
                                        {{ $paiement->numero_paiement }}
                                    </span>
                                </td>

                                <td>
                                    <div class="fd-student-name">
                                        {{ $nomEleve($paiement->eleve) }}
                                    </div>

                                    <small class="fd-muted">
                                        {{ $paiement->eleve?->classe?->nom ?? 'Classe non renseignée' }}
                                    </small>
                                </td>

                                <td>
                                    {{ $paiement->date_paiement?->format('d/m/Y') ?? '—' }}
                                </td>

                                <td>
                                    <strong class="fd-amount">
                                        {{ $formatMontant($paiement->montant_total) }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="fd-mode">
                                        <i class="bi bi-cash me-1"></i>
                                        {{ ucfirst($paiement->mode_paiement) }}
                                    </span>
                                </td>

                                <td>
                                    @if ($paiement->statut === 'valide')
                                        <span class="fd-status success">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Validé
                                        </span>
                                    @else
                                        <span class="fd-status danger">
                                            <i class="bi bi-x-circle-fill me-1"></i>
                                            Annulé
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if (auth()->user()->aPermission('frais.paiements_voir'))
                                        <a href="{{ route('frais.paiements.show', $paiement) }}" class="fd-action"
                                            title="Voir le paiement">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @else
                                        <span class="fd-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="fd-empty">
                                        <i class="bi bi-inbox"></i>
                                        <p>Aucun paiement enregistré pour le moment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- =====================================================
             FRAIS RESTANT À RÉGLER
        ====================================================== --}}
        <div class="fd-panel">

            <div class="fd-panel-header">
                <div>
                    <h5>
                        <i class="bi bi-hourglass-bottom me-2"></i>
                        Frais restant à régler
                    </h5>
                    <p>Élèves ayant des frais impayés ou partiellement payés</p>
                </div>

                @if (auth()->user()->aPermission('frais.situations_voir'))
                    <a href="{{ route('frais.situations.index') }}" class="fd-link">
                        Voir les situations
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                @endif
            </div>

            <div class="fd-table-wrapper">
                <table class="table fd-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Désignation</th>
                            <th>Montant dû</th>
                            <th>Déjà réglé</th>
                            <th>Reste à payer</th>
                            <th>Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($fraisEnAttente->take(10) as $frais)
                            @php
                                $montantDu = (float) $frais->montant_du;
                                $montantRegle = (float) ($frais->montant_regle ?? 0);
                                $reste = max(0, $montantDu - $montantRegle);
                            @endphp

                            @if ($reste > 0)
                                <tr>
                                    <td>
                                        <div class="fd-student-name">
                                            {{ $nomEleve($frais->eleve) }}
                                        </div>

                                        <small class="fd-muted">
                                            {{ $frais->eleve?->matricule ?? '—' }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ $frais->eleve?->classe?->nom ?? '—' }}
                                    </td>

                                    <td>
                                        {{ $frais->libelle }}
                                    </td>

                                    <td>
                                        {{ $formatMontant($montantDu) }}
                                    </td>

                                    <td>
                                        {{ $formatMontant($montantRegle) }}
                                    </td>

                                    <td>
                                        <strong class="fd-remaining">
                                            {{ $formatMontant($reste) }}
                                        </strong>
                                    </td>

                                    <td>
                                        @if ($frais->statut === 'impaye')
                                            <span class="fd-status danger">Impayé</span>
                                        @else
                                            <span class="fd-status warning">Partiel</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif

                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="fd-empty">
                                        <i class="bi bi-check-circle"></i>
                                        <p>Aucun frais en attente de règlement.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        @if (
                            $fraisEnAttente->isNotEmpty() &&
                                $fraisEnAttente->every(function ($frais) {
                                    return max(0, (float) $frais->montant_du - (float) ($frais->montant_regle ?? 0)) <= 0;
                                }))
                            <tr>
                                <td colspan="7">
                                    <div class="fd-empty">
                                        <i class="bi bi-check-circle"></i>
                                        <p>Aucun solde restant à régler.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($fraisEnAttente->count() > 10)
                <div class="fd-table-footer">
                    Affichage des 10 premières lignes sur {{ $fraisEnAttente->count() }} frais en attente.
                </div>
            @endif

        </div>

    </div>

    {{-- =====================================================
         STYLES
    ====================================================== --}}
    <style>
        .finance-dashboard {
            color: var(--bs-body-color);
        }

        .finance-dashboard * {
            box-sizing: border-box;
        }

        .fd-muted {
            color: var(--bs-secondary-color);
        }

        /* HERO */

        .fd-hero {
            padding: 27px 30px;
            border-radius: 18px;
            color: #fff;
            background: linear-gradient(115deg, #1e3a5f, #256fa5);
            box-shadow: 0 8px 25px rgba(30, 58, 95, .13);
        }

        .fd-hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .fd-eyebrow {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            opacity: .8;
            margin-bottom: 8px;
        }

        .fd-hero h2 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .fd-hero p {
            font-size: 13px;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 12px;
        }

        .fd-date {
            font-size: 12px;
            color: rgba(255, 255, 255, .8);
        }

        .fd-hero-icon {
            width: 76px;
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 20px;
            background: rgba(255, 255, 255, .14);
            font-size: 37px;
        }

        /* STATISTIQUES */

        .fd-stat-card {
            height: 100%;
            padding: 19px;
            border: 1px solid var(--bs-border-color);
            border-radius: 15px;
            background: var(--bs-body-bg);
            box-shadow: 0 3px 12px rgba(0, 0, 0, .035);
            transition: transform .2s, box-shadow .2s;
        }

        .fd-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .07);
        }

        .fd-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 18px;
        }

        .fd-stat-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 21px;
        }

        .fd-stat-label {
            color: var(--bs-secondary-color);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .7px;
        }

        .fd-stat-value {
            font-size: clamp(19px, 2vw, 25px);
            font-weight: 800;
            letter-spacing: -.5px;
            overflow-wrap: anywhere;
            margin-bottom: 12px;
        }

        .fd-stat-footer {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--bs-secondary-color);
            font-size: 11px;
        }

        .stat-blue .fd-stat-icon {
            color: #2875d0;
            background: rgba(40, 117, 208, .12);
        }

        .stat-blue .fd-stat-value {
            color: #2875d0;
        }

        .stat-green .fd-stat-icon {
            color: #159b63;
            background: rgba(21, 155, 99, .12);
        }

        .stat-green .fd-stat-value {
            color: #159b63;
        }

        .stat-orange .fd-stat-icon {
            color: #d88a18;
            background: rgba(216, 138, 24, .13);
        }

        .stat-orange .fd-stat-value {
            color: #d88a18;
        }

        .stat-purple .fd-stat-icon {
            color: #8060c8;
            background: rgba(128, 96, 200, .12);
        }

        .stat-purple .fd-stat-value {
            color: #8060c8;
        }

        /* PANNEAUX */

        .fd-panel {
            padding: 21px;
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            background: var(--bs-body-bg);
            box-shadow: 0 3px 12px rgba(0, 0, 0, .035);
            min-width: 0;
        }

        .fd-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .fd-panel-header h5 {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .fd-panel-header h5 i {
            color: var(--bs-primary);
        }

        .fd-panel-header p {
            color: var(--bs-secondary-color);
            font-size: 11px;
            margin: 0;
        }

        .fd-panel-badge {
            padding: 7px 11px;
            border-radius: 8px;
            color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle);
            font-size: 11px;
            font-weight: 700;
        }

        .fd-link {
            color: var(--bs-primary);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .fd-link:hover {
            text-decoration: underline;
        }

        /* GRAPHIQUE */

        .fd-chart {
            height: 235px;
            display: flex;
            align-items: stretch;
            justify-content: space-around;
            gap: 12px;
            padding: 8px 5px 0;
        }

        .fd-chart-column {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .fd-chart-value {
            min-height: 24px;
            color: var(--bs-secondary-color);
            font-size: 10px;
            font-weight: 700;
            text-align: center;
        }

        .fd-chart-track {
            width: min(42px, 70%);
            flex: 1;
            display: flex;
            align-items: flex-end;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
            background: var(--bs-tertiary-bg);
        }

        .fd-chart-bar {
            width: 100%;
            min-height: 0;
            border-radius: 8px 8px 0 0;
            background: linear-gradient(180deg, #48a6e8, #2563a6);
            transition: height .4s ease;
        }

        .fd-chart-label {
            min-height: 29px;
            padding-top: 9px;
            color: var(--bs-secondary-color);
            font-size: 10px;
            font-weight: 700;
            text-align: center;
        }

        .fd-chart-legend {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--bs-secondary-color);
            font-size: 11px;
            margin-top: 12px;
        }

        .fd-legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #328acb;
        }

        /* RÉSUMÉ FRAIS */

        .fd-summary-list {
            display: flex;
            flex-direction: column;
        }

        .fd-summary-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--bs-border-color);
        }

        .fd-summary-item:last-child {
            border-bottom: 0;
        }

        .fd-summary-icon {
            width: 39px;
            height: 39px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 11px;
            font-size: 17px;
        }

        .fd-summary-icon.unpaid {
            color: #dc5555;
            background: rgba(220, 85, 85, .12);
        }

        .fd-summary-icon.partial {
            color: #d58b20;
            background: rgba(213, 139, 32, .13);
        }

        .fd-summary-icon.students {
            color: #3984ca;
            background: rgba(57, 132, 202, .12);
        }

        .fd-summary-icon.cancelled {
            color: #8060c8;
            background: rgba(128, 96, 200, .12);
        }

        .fd-summary-title {
            font-size: 12px;
            font-weight: 800;
        }

        .fd-summary-subtitle {
            color: var(--bs-secondary-color);
            font-size: 10px;
            margin-top: 3px;
        }

        .fd-summary-number {
            font-size: 18px;
            font-weight: 800;
        }

        .fd-summary-amount {
            font-size: 12px;
            font-weight: 800;
            text-align: right;
        }

        /* TABLEAUX */

        .fd-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--bs-border-color);
            border-radius: 11px;
        }

        .fd-table {
            min-width: 850px;
            color: var(--bs-body-color);
        }

        .fd-table thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            padding: 13px 14px;
            background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color);
            border-bottom: 1px solid var(--bs-border-color);
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .fd-table tbody td {
            padding: 13px 14px;
            border-color: var(--bs-border-color);
            background: var(--bs-body-bg);
            font-size: 12px;
            white-space: nowrap;
        }

        .fd-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .fd-table tbody tr:hover td {
            background: var(--bs-tertiary-bg);
        }

        .fd-reference {
            color: var(--bs-primary);
            font-weight: 800;
            font-size: 11px;
        }

        .fd-student-name {
            font-weight: 700;
        }

        .fd-amount {
            color: #159b63;
        }

        .fd-remaining {
            color: #dc8a22;
        }

        .fd-mode {
            color: var(--bs-secondary-color);
            font-size: 11px;
        }

        .fd-status {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
        }

        .fd-status.success {
            color: #16834c;
            background: rgba(25, 175, 105, .12);
        }

        .fd-status.danger {
            color: #d44747;
            background: rgba(212, 71, 71, .12);
        }

        .fd-status.warning {
            color: #b7791f;
            background: rgba(213, 139, 32, .13);
        }

        .fd-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle);
            text-decoration: none;
            transition: .2s;
        }

        .fd-action:hover {
            color: #fff;
            background: var(--bs-primary);
        }

        .fd-empty {
            padding: 28px 12px;
            text-align: center;
            color: var(--bs-secondary-color);
        }

        .fd-empty i {
            font-size: 27px;
            display: block;
            margin-bottom: 8px;
        }

        .fd-empty p {
            font-size: 12px;
            margin: 0;
        }

        .fd-table-footer {
            padding-top: 12px;
            color: var(--bs-secondary-color);
            font-size: 11px;
        }

        /* RESPONSIVE */

        @media (max-width: 576px) {
            .fd-hero {
                padding: 22px 18px;
            }

            .fd-hero h2 {
                font-size: 21px;
            }

            .fd-hero-icon {
                width: 53px;
                height: 53px;
                font-size: 25px;
                border-radius: 14px;
            }

            .fd-panel {
                padding: 15px;
            }

            .fd-chart {
                gap: 5px;
                height: 205px;
            }

            .fd-chart-track {
                width: 30px;
            }

            .fd-chart-value,
            .fd-chart-label {
                font-size: 9px;
            }
        }

        /* =====================================================
               THÈME DARK
            ====================================================== */

        html[data-app-theme="dark"] .fd-panel,
        html[data-app-theme="dark"] .fd-stat-card {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }

        html[data-app-theme="dark"] .fd-table-wrapper {
            border-color: #3a4b61;
        }

        html[data-app-theme="dark"] .fd-table thead th {
            background: #263449;
            color: #cbd5e1;
            border-color: #3a4b61;
        }

        html[data-app-theme="dark"] .fd-table tbody td {
            background: #1e293b;
            color: #e2e8f0;
            border-color: #334155;
        }

        html[data-app-theme="dark"] .fd-table tbody tr:hover td {
            background: #263449;
        }

        html[data-app-theme="dark"] .fd-chart-track {
            background: #263449;
        }

        html[data-app-theme="dark"] .fd-summary-item {
            border-color: #334155;
        }

        /* =====================================================
               THÈME ULTRA PRO
            ====================================================== */

        html[data-app-theme="ultra-pro"] .fd-hero {
            background: linear-gradient(115deg, #111827, #334155);
        }

        html[data-app-theme="ultra-pro"] .fd-panel,
        html[data-app-theme="ultra-pro"] .fd-stat-card {
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .07);
        }

        html[data-app-theme="ultra-pro"] .fd-chart-bar {
            background: linear-gradient(180deg, #64748b, #1e293b);
        }

        /* =====================================================
               THÈME EMERALD
            ====================================================== */

        html[data-app-theme="emerald"] .fd-hero {
            background: linear-gradient(115deg, #064e3b, #059669);
        }

        html[data-app-theme="emerald"] .fd-chart-bar {
            background: linear-gradient(180deg, #34d399, #047857);
        }

        html[data-app-theme="emerald"] .fd-link,
        html[data-app-theme="emerald"] .fd-reference {
            color: #059669;
        }

        /* =====================================================
               THÈME CRÈME PRESTIGE
            ====================================================== */

        html[data-app-theme="creme-prestige"] .fd-hero {
            background: linear-gradient(115deg, #55412d, #9b7950);
        }

        html[data-app-theme="creme-prestige"] .fd-panel,
        html[data-app-theme="creme-prestige"] .fd-stat-card {
            background: #fffdf8;
            border-color: #e7dcc8;
            box-shadow: 0 5px 17px rgba(92, 69, 39, .07);
        }

        html[data-app-theme="creme-prestige"] .fd-table thead th {
            background: #f5eddf;
            color: #725a3e;
            border-color: #e7dcc8;
        }

        html[data-app-theme="creme-prestige"] .fd-table tbody td {
            background: #fffdf8;
            border-color: #eee4d3;
            color: #55412d;
        }

        html[data-app-theme="creme-prestige"] .fd-table tbody tr:hover td {
            background: #f9f3e8;
        }

        html[data-app-theme="creme-prestige"] .fd-chart-track {
            background: #f1e7d6;
        }

        html[data-app-theme="creme-prestige"] .fd-chart-bar {
            background: linear-gradient(180deg, #c5a477, #80613d);
        }

        html[data-app-theme="creme-prestige"] .fd-summary-item {
            border-color: #e7dcc8;
        }
    </style>

@endsection
