@extends('layouts.app')

@section('content')

    <div class="situation-show-page">
        <div class="container-fluid py-4">

            {{-- EN-TÊTE --}}
            <div class="situation-show-hero mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <div class="show-eyebrow">
                            <i class="bi bi-wallet2"></i>
                            GESTION FINANCIÈRE
                        </div>

                        <h2 class="fw-bold mb-2">Situation financière de l'élève</h2>

                        <p class="mb-0">
                            Détail des frais scolaires et historique des paiements.
                        </p>
                    </div>

                    <a href="{{ route('frais.situations.index') }}" class="btn btn-light btn-back">
                        <i class="bi bi-arrow-left me-1"></i>
                        Retour à la liste
                    </a>
                </div>

                
            </div>

            {{-- INFORMATIONS DE L'ÉLÈVE --}}
            <div class="student-profile-card mb-4">
                <div class="student-profile-photo">
                    @if ($eleve->photo)
                        <img src="{{ asset('storage/' . $eleve->photo) }}"
                            alt="Photo de {{ $eleve->nom }} {{ $eleve->prenom }}"
                            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($eleve->nom . ' ' . $eleve->prenom) }}&background=e9edff&color=5267d8';">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($eleve->nom . ' ' . $eleve->prenom) }}&background=e9edff&color=5267d8"
                            alt="Avatar de {{ $eleve->nom }}">
                    @endif
                </div>

                <div class="student-profile-info">
                    <span class="profile-label">FICHE DE L'ÉLÈVE</span>

                    <h3>{{ $eleve->nom }} {{ $eleve->prenom }}</h3>

                    <div class="student-profile-details">
                        <span>
                            <i class="bi bi-card-text"></i>
                            Matricule : <strong>{{ $eleve->matricule }}</strong>
                        </span>

                        <span>
                            <i class="bi bi-mortarboard"></i>
                            Classe : <strong>{{ $eleve->classe->nom ?? '-' }}</strong>
                        </span>
                    </div>
                </div>

                <div class="profile-student-icon">
                    <i class="bi bi-person-vcard"></i>
                </div>
            </div>

            {{-- RÉSUMÉ FINANCIER --}}
            <div class="row g-3 mb-4">

                <div class="col-xl-4 col-md-6">
                    <div class="show-stat-card stat-due">
                        <div>
                            <div class="show-stat-label">Total des frais dus</div>
                            <div class="show-stat-value">
                                {{ number_format($totalDu, 0, ',', ' ') }} Ar
                            </div>
                            <div class="show-stat-description">Montant total à régler</div>
                        </div>
                        <div class="show-stat-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="show-stat-card stat-paid">
                        <div>
                            <div class="show-stat-label">Total des paiements</div>
                            <div class="show-stat-value">
                                {{ number_format($totalPaye, 0, ',', ' ') }} Ar
                            </div>
                            <div class="show-stat-description">Montant déjà encaissé</div>
                        </div>
                        <div class="show-stat-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="show-stat-card stat-remaining">
                        <div>
                            <div class="show-stat-label">Reste à payer</div>
                            <div class="show-stat-value">
                                {{ number_format($resteTotal, 0, ',', ' ') }} Ar
                            </div>
                            <div class="show-stat-description">Solde restant à recouvrer</div>
                        </div>
                        <div class="show-stat-icon">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- DÉTAIL DES FRAIS --}}
            <div class="show-panel">

                <div class="show-panel-header">
                    <div>
                        <h5>
                            <i class="bi bi-list-ul me-2"></i>
                            Détail des frais scolaires
                        </h5>
                        <p class="mb-0">Consultez les frais, les échéances et les paiements associés.</p>
                    </div>

                    <span class="show-count">
                        <i class="bi bi-receipt me-1"></i>
                        {{ $frais->count() }} ligne(s)
                    </span>
                </div>

                <div class="show-panel-body">

                    <div class="show-table-scroll">
                        <table class="table show-fees-table align-middle">

                            <thead>
                                <tr>
                                    <th>Frais</th>
                                    <th>Période</th>
                                    <th>Échéance</th>
                                    <th class="text-end">Montant dû</th>
                                    <th class="text-end">Montant payé</th>
                                    <th class="text-end">Reste</th>
                                    <th>Situation</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($frais as $ligne)
                                    <tr class="fee-main-row">
                                        <td>
                                            <div class="fee-name">
                                                {{ $ligne->tarifFrais->typeFrais->nom ?? $ligne->libelle }}
                                            </div>

                                            @if ($ligne->libelle)
                                                <small class="fee-description">
                                                    {{ $ligne->libelle }}
                                                </small>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="period-label">
                                                {{ $ligne->cle_periode ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="fee-date">
                                            {{ $ligne->date_echeance ? $ligne->date_echeance->format('d/m/Y') : '-' }}
                                        </td>

                                        <td class="text-end fee-amount">
                                            {{ number_format($ligne->montant_du, 0, ',', ' ') }} Ar
                                        </td>

                                        <td class="text-end fee-amount text-success">
                                            {{ number_format($ligne->montant_paye, 0, ',', ' ') }} Ar
                                        </td>

                                        <td class="text-end fee-amount text-danger">
                                            {{ number_format($ligne->reste_a_payer, 0, ',', ' ') }} Ar
                                        </td>

                                        <td>
                                            @if ($ligne->statut_calcule === 'paye')
                                                <span class="fee-status status-paid">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Payé
                                                </span>
                                            @elseif ($ligne->statut_calcule === 'partiel')
                                                <span class="fee-status status-partial">
                                                    <i class="bi bi-clock-fill"></i>
                                                    Partiel
                                                </span>
                                            @else
                                                <span class="fee-status status-unpaid">
                                                    <i class="bi bi-exclamation-circle-fill"></i>
                                                    Impayé
                                                </span>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- HISTORIQUE DES PAIEMENTS --}}
                                    @if ($ligne->detailsPaiements->isNotEmpty())
                                        <tr class="payment-history-row">
                                            <td colspan="7">

                                                <div class="payment-history-box">

                                                    <div class="payment-history-title">
                                                        <i class="bi bi-clock-history"></i>
                                                        Historique des paiements
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-sm payment-history-table mb-0">

                                                            <thead>
                                                                <tr>
                                                                    <th>N° paiement</th>
                                                                    <th>Date</th>
                                                                    <th>Mode</th>
                                                                    <th>Caissier</th>
                                                                    <th class="text-end">Montant</th>
                                                                    <th>Statut</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                @foreach ($ligne->detailsPaiements as $detail)
                                                                    @php
                                                                        $paiement = $detail->paiement;
                                                                    @endphp

                                                                    @if ($paiement)
                                                                        <tr>
                                                                            <td class="payment-number">
                                                                                {{ $paiement->numero_paiement }}
                                                                            </td>

                                                                            <td>
                                                                                {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : '-' }}
                                                                            </td>

                                                                            <td>
                                                                                {{ ucfirst($paiement->mode_paiement) }}
                                                                            </td>

                                                                            <td>
                                                                                {{ $paiement->utilisateur->name ?? '-' }}
                                                                            </td>

                                                                            <td class="text-end fw-semibold">
                                                                                {{ number_format($detail->montant_paye, 0, ',', ' ') }}
                                                                                Ar
                                                                            </td>

                                                                            <td>
                                                                                @if ($paiement->statut === 'valide')
                                                                                    <span class="fee-status status-paid">
                                                                                        Validé
                                                                                    </span>
                                                                                @else
                                                                                    <span class="fee-status status-unpaid">
                                                                                        Annulé
                                                                                    </span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>

                                                                        {{-- MOTIF D'ANNULATION --}}
                                                                        @if ($paiement->statut === 'annule' && $paiement->annulation)
                                                                            <tr class="cancellation-row">
                                                                                <td colspan="6">
                                                                                    <i
                                                                                        class="bi bi-exclamation-triangle-fill me-1"></i>
                                                                                    <strong>Motif d'annulation :</strong>
                                                                                    {{ $paiement->annulation->motif ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </tbody>

                                                        </table>
                                                    </div>

                                                </div>

                                            </td>
                                        </tr>
                                    @endif

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="show-empty-state">
                                                <i class="bi bi-inbox"></i>
                                                <h6>Aucun frais généré</h6>
                                                <p class="mb-0">
                                                    Aucun frais n'a été généré pour cet élève.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

            {{-- RETOUR --}}
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('frais.situations.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour à la liste
                </a>
            </div>

        </div>
    </div>

    <style>
        /* =====================================================
       SITUATION FINANCIÈRE - THÈME PAR DÉFAUT
    ===================================================== */

        .situation-show-page {
            --ss-bg: #f4f6fb;
            --ss-card: #ffffff;
            --ss-text: #263247;
            --ss-muted: #7c899d;
            --ss-border: #e5eaf2;
            --ss-primary: #5267d8;
            --ss-primary-soft: #edf0ff;

            color: var(--ss-text);
        }

        .situation-show-hero {
            padding: 27px 30px;
            color: #ffffff;
            border-radius: 18px;
            background: linear-gradient(120deg, #263d83, #5267d8 60%, #7b78df);
            box-shadow: 0 8px 24px rgba(54, 73, 150, .16);
        }

        .show-eyebrow {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.7px;
            opacity: .8;
            margin-bottom: 10px;
        }

        .situation-show-hero h2 {
            font-size: 25px;
        }

        .situation-show-hero p {
            font-size: 13px;
            color: rgba(255, 255, 255, .8);
        }

        .btn-back {
            font-size: 12px;
            font-weight: 700;
            border-radius: 8px;
        }

        .show-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            font-size: 11px;
            color: rgba(255, 255, 255, .7);
        }

        .show-breadcrumb a {
            color: rgba(255, 255, 255, .85);
            text-decoration: none;
        }

        .show-breadcrumb strong {
            color: #ffffff;
        }

        /* PROFIL ÉLÈVE */

        .student-profile-card {
            display: flex;
            align-items: center;
            gap: 22px;
            padding: 23px 26px;
            background: var(--ss-card);
            border: 1px solid var(--ss-border);
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(30, 45, 80, .045);
        }

        .student-profile-photo {
            width: 90px;
            height: 90px;
            flex-shrink: 0;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--ss-border);
            background: var(--ss-primary-soft);
        }

        .student-profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .student-profile-info {
            flex: 1;
            min-width: 0;
        }

        .profile-label {
            color: var(--ss-primary);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .student-profile-info h3 {
            color: var(--ss-text);
            font-size: 21px;
            font-weight: 800;
            margin: 5px 0 10px;
        }

        .student-profile-details {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 22px;
            color: var(--ss-muted);
            font-size: 12px;
        }

        .student-profile-details i {
            color: var(--ss-primary);
            margin-right: 4px;
        }

        .student-profile-details strong {
            color: var(--ss-text);
        }

        .profile-student-icon {
            width: 57px;
            height: 57px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--ss-primary-soft);
            color: var(--ss-primary);
            font-size: 26px;
        }

        /* INDICATEURS */

        .show-stat-card {
            min-height: 125px;
            padding: 21px;
            background: var(--ss-card);
            border: 1px solid var(--ss-border);
            border-radius: 15px;
            box-shadow: 0 4px 16px rgba(30, 45, 80, .045);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .show-stat-label {
            color: var(--ss-muted);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .show-stat-value {
            color: var(--ss-text);
            font-size: 22px;
            font-weight: 800;
            font-variant-numeric: tabular-nums;
        }

        .show-stat-description {
            color: var(--ss-muted);
            font-size: 11px;
            margin-top: 6px;
        }

        .show-stat-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-due .show-stat-icon {
            background: #edf0ff;
            color: #5267d8;
        }

        .stat-paid .show-stat-icon {
            background: #e4f7ed;
            color: #15945a;
        }

        .stat-remaining .show-stat-icon {
            background: #fff0ed;
            color: #dc574b;
        }

        /* PANNEAU FRAIS */

        .show-panel {
            background: var(--ss-card);
            border: 1px solid var(--ss-border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(30, 45, 80, .045);
        }

        .show-panel-header {
            padding: 21px 24px;
            border-bottom: 1px solid var(--ss-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .show-panel-header h5 {
            color: var(--ss-text);
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .show-panel-header h5 i {
            color: var(--ss-primary);
        }

        .show-panel-header p {
            color: var(--ss-muted);
            font-size: 11px;
        }

        .show-count {
            background: var(--ss-primary-soft);
            color: var(--ss-primary);
            padding: 7px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 800;
        }

        .show-panel-body {
            padding: 23px;
        }

        /* TABLEAU PRINCIPAL */

        .show-table-scroll {
            max-height: 570px;
            overflow: auto;
            border: 1px solid var(--ss-border);
            border-radius: 10px;
        }

        .show-fees-table {
            margin-bottom: 0;
            color: var(--ss-text);
            font-size: 12px;
            border-color: var(--ss-border);
        }

        .show-fees-table>thead>tr>th {
            position: sticky;
            top: 0;
            z-index: 5;
            background: var(--ss-bg);
            color: var(--ss-muted);
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 15px 12px;
            white-space: nowrap;
            border-bottom: 1px solid var(--ss-border);
        }

        .show-fees-table>tbody>tr>td {
            padding: 14px 12px;
            background: var(--ss-card);
            color: var(--ss-text);
            border-color: var(--ss-border);
        }

        .fee-main-row:hover>td {
            background: var(--ss-bg);
        }

        .fee-name {
            font-weight: 800;
            color: var(--ss-text);
        }

        .fee-description {
            display: block;
            color: var(--ss-muted);
            margin-top: 4px;
            font-size: 10px;
        }

        .period-label {
            display: inline-block;
            background: var(--ss-primary-soft);
            color: var(--ss-primary);
            padding: 5px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
        }

        .fee-date {
            color: var(--ss-muted) !important;
            white-space: nowrap;
        }

        .fee-amount {
            white-space: nowrap;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .fee-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-paid {
            background: #e1f6e9;
            color: #13834e;
        }

        .status-partial {
            background: #fff1c9;
            color: #956300;
        }

        .status-unpaid {
            background: #ffe5e2;
            color: #c23c36;
        }

        /* HISTORIQUE DES PAIEMENTS */

        .payment-history-row>td {
            padding: 12px 16px !important;
            background: var(--ss-bg) !important;
        }

        .payment-history-box {
            padding: 15px;
            border: 1px solid var(--ss-border);
            border-left: 3px solid var(--ss-primary);
            border-radius: 9px;
            background: var(--ss-card);
        }

        .payment-history-title {
            font-size: 12px;
            font-weight: 800;
            color: var(--ss-primary);
            margin-bottom: 12px;
        }

        .payment-history-title i {
            margin-right: 6px;
        }

        .payment-history-table {
            color: var(--ss-text);
            font-size: 11px;
            border-color: var(--ss-border);
        }

        .payment-history-table thead th {
            background: var(--ss-bg);
            color: var(--ss-muted);
            font-size: 10px;
            text-transform: uppercase;
            padding: 10px;
            white-space: nowrap;
        }

        .payment-history-table tbody td {
            background: var(--ss-card);
            color: var(--ss-text);
            padding: 10px;
            border-color: var(--ss-border);
        }

        .payment-number {
            font-weight: 700;
            color: var(--ss-primary) !important;
        }

        .cancellation-row td {
            background: #fff0ed !important;
            color: #bd433b !important;
            font-size: 11px;
            padding: 10px !important;
        }

        .show-empty-state {
            padding: 20px;
            color: var(--ss-muted);
        }

        .show-empty-state>i {
            font-size: 38px;
            opacity: .55;
            margin-bottom: 12px;
        }

        .show-empty-state h6 {
            color: var(--ss-text);
            font-weight: 800;
        }

        /* =====================================================
       MODE SOMBRE
    ===================================================== */

        html[data-app-theme="dark"] .situation-show-page {
            --ss-bg: #151c2b;
            --ss-card: #202a3b;
            --ss-text: #edf2fa;
            --ss-muted: #a8b5c8;
            --ss-border: #39465b;
            --ss-primary: #ad9fff;
            --ss-primary-soft: #343052;

            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .situation-show-page .student-profile-card,
        html[data-app-theme="dark"] .situation-show-page .show-stat-card,
        html[data-app-theme="dark"] .situation-show-page .show-panel,
        html[data-app-theme="dark"] .situation-show-page .payment-history-box {
            background: #202a3b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situation-show-page .show-panel-header,
        html[data-app-theme="dark"] .situation-show-page .show-fees-table,
        html[data-app-theme="dark"] .situation-show-page .payment-history-table {
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situation-show-page .show-fees-table>thead>tr>th,
        html[data-app-theme="dark"] .situation-show-page .payment-history-table thead th {
            background: #182235 !important;
            color: #b7c4d8 !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situation-show-page .show-fees-table>tbody>tr>td,
        html[data-app-theme="dark"] .situation-show-page .payment-history-table tbody td {
            background: #202a3b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .situation-show-page .fee-main-row:hover>td {
            background: #29364b !important;
        }

        html[data-app-theme="dark"] .situation-show-page .payment-history-row>td {
            background: #182235 !important;
        }

        html[data-app-theme="dark"] .situation-show-page .payment-history-box {
            background: #202a3b !important;
        }

        html[data-app-theme="dark"] .situation-show-page .cancellation-row td {
            background: #5b2928 !important;
            color: #ffb0a8 !important;
        }

        html[data-app-theme="dark"] .situation-show-page .status-paid {
            background: #164b35 !important;
            color: #8df0b6 !important;
        }

        html[data-app-theme="dark"] .situation-show-page .status-partial {
            background: #59451b !important;
            color: #ffdb82 !important;
        }

        html[data-app-theme="dark"] .situation-show-page .status-unpaid {
            background: #5b2928 !important;
            color: #ffaaa3 !important;
        }

        html[data-app-theme="dark"] .situation-show-page .text-success {
            color: #6ee7a5 !important;
        }

        html[data-app-theme="dark"] .situation-show-page .text-danger {
            color: #ff9c91 !important;
        }

        /* =====================================================
       ULTRA PRO
    ===================================================== */

        html[data-app-theme="ultra-pro"] .situation-show-page {
            --ss-bg: #151b2b;
            --ss-card: #20283b;
            --ss-text: #f0f3fa;
            --ss-muted: #a8b3c8;
            --ss-border: #39445d;
            --ss-primary: #d6b46a;
            --ss-primary-soft: #3c3528;
        }

        html[data-app-theme="ultra-pro"] .situation-show-page .situation-show-hero {
            background: linear-gradient(120deg, #111827, #29344d 65%, #725b32);
        }

        html[data-app-theme="ultra-pro"] .situation-show-page .show-fees-table thead th {
            background: #182235;
            color: #d6b46a;
        }

        /* =====================================================
       EMERALD
    ===================================================== */

        html[data-app-theme="emerald"] .situation-show-page {
            --ss-bg: #eaf5f0;
            --ss-card: #ffffff;
            --ss-text: #173b30;
            --ss-muted: #648276;
            --ss-border: #cce4d8;
            --ss-primary: #16865c;
            --ss-primary-soft: #dff3e9;
        }

        html[data-app-theme="emerald"] .situation-show-page .situation-show-hero {
            background: linear-gradient(120deg, #075b43, #16865c, #38a77b);
        }

        /* =====================================================
       WARM
    ===================================================== */

        html[data-app-theme="warm"] .situation-show-page {
            --ss-bg: #fbf3e9;
            --ss-card: #fffdf9;
            --ss-text: #4a3528;
            --ss-muted: #927967;
            --ss-border: #ead8c6;
            --ss-primary: #b87542;
            --ss-primary-soft: #f7e9da;
        }

        html[data-app-theme="warm"] .situation-show-page .situation-show-hero {
            background: linear-gradient(120deg, #74452f, #b87542, #d39a65);
        }

        /* =====================================================
       RESPONSIVE
    ===================================================== */

        @media (max-width: 768px) {
            .situation-show-hero {
                padding: 21px;
            }

            .situation-show-hero h2 {
                font-size: 21px;
            }

            .student-profile-card {
                padding: 17px;
                gap: 14px;
            }

            .student-profile-photo {
                width: 68px;
                height: 68px;
            }

            .student-profile-info h3 {
                font-size: 17px;
            }

            .profile-student-icon {
                display: none;
            }

            .student-profile-details {
                flex-direction: column;
                gap: 7px;
            }

            .show-panel-body {
                padding: 14px;
            }

            .show-stat-card {
                min-height: 110px;
                padding: 16px;
            }

            .show-stat-value {
                font-size: 19px;
            }

            .show-table-scroll {
                max-height: 480px;
            }
        }
    </style>

@endsection
