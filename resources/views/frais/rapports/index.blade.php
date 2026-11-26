@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 rf-page">

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
        <div class="rf-hero mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <div class="rf-eyebrow">
                        <i class="bi bi-bar-chart-line-fill"></i>
                        GESTION FINANCIÈRE
                    </div>

                    <h2 class="rf-title">
                        <i class="bi bi-graph-up-arrow me-2"></i>
                        Rapports financiers
                    </h2>

                    <p class="rf-subtitle mb-0">
                        Analysez les encaissements, les frais scolaires et les opérations financières.
                    </p>
                </div>

                <a href="{{ route('frais.dashboard') }}" class="rf-back-btn">
                    <i class="bi bi-arrow-left"></i>
                    Retour au tableau de bord
                </a>

            </div>
        </div>


        {{-- =====================================================
         FILTRES
    ====================================================== --}}
        <div class="rf-card mb-4">

            <div class="rf-card-header">
                <div>
                    <h5>
                        <i class="bi bi-funnel-fill me-2"></i>
                        Filtres des rapports
                    </h5>
                    <p>Choisissez les critères pour affiner vos statistiques financières.</p>
                </div>

                <span class="rf-header-icon">
                    <i class="bi bi-sliders"></i>
                </span>
            </div>

            <div class="rf-card-body">

                <form method="GET" action="{{ route('frais.rapports.index') }}">

                    <div class="row g-3">

                        {{-- ANNÉE SCOLAIRE --}}
                        <div class="col-xl-4 col-md-6">
                            <label class="rf-label">
                                <i class="bi bi-calendar3 me-1"></i>
                                Année scolaire
                            </label>

                            <select name="annee_scolaire_id" class="form-select">
                                <option value="">Toutes les années</option>

                                @foreach ($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}" @selected($filtres['annee_scolaire_id'] == $annee->id)>
                                        {{ $annee->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- CLASSE --}}
                        <div class="col-xl-4 col-md-6">
                            <label class="rf-label">
                                <i class="bi bi-mortarboard me-1"></i>
                                Classe
                            </label>

                            <select name="classe_id" class="form-select">
                                <option value="">Toutes les classes</option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}" @selected($filtres['classe_id'] == $classe->id)>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- CAISSIER --}}
                        <div class="col-xl-4 col-md-6">
                            <label class="rf-label">
                                <i class="bi bi-person-badge me-1"></i>
                                Caissier
                            </label>

                            <select name="user_id" class="form-select">
                                <option value="">Tous les caissiers</option>

                                @foreach ($caissiers as $caissier)
                                    <option value="{{ $caissier->id }}" @selected($filtres['user_id'] == $caissier->id)>
                                        {{ $caissier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DATE DEBUT --}}
                        <div class="col-xl-4 col-md-6">
                            <label class="rf-label">
                                <i class="bi bi-calendar-event me-1"></i>
                                Date de début
                            </label>

                            <input type="date" name="date_debut" class="form-control"
                                value="{{ $filtres['date_debut'] }}">
                        </div>

                        {{-- DATE FIN --}}
                        <div class="col-xl-4 col-md-6">
                            <label class="rf-label">
                                <i class="bi bi-calendar-check me-1"></i>
                                Date de fin
                            </label>

                            <input type="date" name="date_fin" class="form-control" value="{{ $filtres['date_fin'] }}">
                        </div>

                        {{-- ACTIONS --}}
                        <div class="col-xl-4 col-md-6 d-flex align-items-end gap-2">

                            <button type="submit" class="rf-btn rf-btn-primary flex-fill">
                                <i class="bi bi-search"></i>
                                Appliquer
                            </button>

                            <a href="{{ route('frais.rapports.index') }}" class="rf-btn rf-btn-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Réinitialiser
                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        {{-- =====================================================
         STATISTIQUES PRINCIPALES
    ====================================================== --}}
        <div class="row g-3 mb-4">

            {{-- TOTAL ENCAISSÉ --}}
            <div class="col-xl-3 col-md-6">
                <div class="rf-stat rf-stat-green">

                    <div class="rf-stat-top">
                        <div>
                            <div class="rf-stat-label">Total encaissé</div>

                            <div class="rf-stat-value">
                                {{ number_format($totalEncaisse, 0, ',', ' ') }}
                                <small>Ar</small>
                            </div>
                        </div>

                        <div class="rf-stat-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>

                    <div class="rf-stat-footer">
                        <i class="bi bi-check-circle"></i>
                        {{ $nombrePaiements }} paiement(s) concerné(s)
                    </div>

                </div>
            </div>

            {{-- RESTE À PAYER --}}
            <div class="col-xl-3 col-md-6">
                <div class="rf-stat rf-stat-red">

                    <div class="rf-stat-top">
                        <div>
                            <div class="rf-stat-label">Reste à payer</div>

                            <div class="rf-stat-value">
                                {{ number_format($totalImpayes, 0, ',', ' ') }}
                                <small>Ar</small>
                            </div>
                        </div>

                        <div class="rf-stat-icon">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                    </div>

                    <div class="rf-stat-footer">
                        <i class="bi bi-hourglass-split"></i>
                        Frais impayés et partiellement payés
                    </div>

                </div>
            </div>

            {{-- FRAIS IMPAYÉS --}}
            <div class="col-xl-3 col-md-6">
                <div class="rf-stat rf-stat-orange">

                    <div class="rf-stat-top">
                        <div>
                            <div class="rf-stat-label">Frais impayés</div>

                            <div class="rf-stat-value">
                                {{ number_format($nombreFraisImpayes, 0, ',', ' ') }}
                            </div>
                        </div>

                        <div class="rf-stat-icon">
                            <i class="bi bi-file-earmark-excel"></i>
                        </div>
                    </div>

                    <div class="rf-stat-footer">
                        <i class="bi bi-exclamation-triangle"></i>
                        Frais sans règlement complet
                    </div>

                </div>
            </div>

            {{-- PAIEMENTS ANNULÉS --}}
            <div class="col-xl-3 col-md-6">
                <div class="rf-stat rf-stat-gray">

                    <div class="rf-stat-top">
                        <div>
                            <div class="rf-stat-label">Paiements annulés</div>

                            <div class="rf-stat-value">
                                {{ number_format($totalAnnule, 0, ',', ' ') }}
                                <small>Ar</small>
                            </div>
                        </div>

                        <div class="rf-stat-icon">
                            <i class="bi bi-x-octagon"></i>
                        </div>
                    </div>

                    <div class="rf-stat-footer">
                        <i class="bi bi-receipt"></i>
                        {{ $paiementsAnnules->count() }} paiement(s) annulé(s)
                    </div>

                </div>
            </div>

        </div>


        {{-- =====================================================
         ENCAISSEMENTS JOURNALIERS
    ====================================================== --}}
        <div class="rf-card mb-4">

            <div class="rf-card-header">
                <div>
                    <h5>
                        <i class="bi bi-calendar-day me-2"></i>
                        Encaissements par jour
                    </h5>
                    <p>Évolution quotidienne des montants encaissés.</p>
                </div>

                <span class="rf-section-icon rf-blue">
                    <i class="bi bi-calendar3"></i>
                </span>
            </div>

            <div class="rf-table-container">

                <table class="table rf-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Date d'encaissement</th>
                            <th class="text-end">Montant encaissé</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($encaissementsJournaliers as $ligne)
                            <tr>
                                <td>
                                    <div class="rf-date-cell">
                                        <i class="bi bi-calendar3"></i>
                                        {{ \Carbon\Carbon::parse($ligne->date)->format('d/m/Y') }}
                                    </div>
                                </td>

                                <td class="text-end">
                                    <span class="rf-money rf-money-green">
                                        {{ number_format($ligne->total, 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </span>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="2">
                                    <div class="rf-empty">
                                        <i class="bi bi-calendar-x"></i>
                                        <span>Aucun encaissement pour cette période.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>


        {{-- =====================================================
         ENCAISSEMENTS MENSUELS
    ====================================================== --}}
        <div class="rf-card mb-4">

            <div class="rf-card-header">
                <div>
                    <h5>
                        <i class="bi bi-calendar-month me-2"></i>
                        Encaissements par mois
                    </h5>
                    <p>Suivi mensuel des recettes de l'établissement.</p>
                </div>

                <span class="rf-section-icon rf-purple">
                    <i class="bi bi-graph-up"></i>
                </span>
            </div>

            <div class="rf-table-container">

                <table class="table rf-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Mois</th>
                            <th class="text-end">Montant encaissé</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($encaissementsMensuels as $ligne)
                            <tr>
                                <td>
                                    <div class="rf-date-cell">
                                        <i class="bi bi-calendar-month"></i>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $ligne->mois)->translatedFormat('F Y') }}
                                    </div>
                                </td>

                                <td class="text-end">
                                    <span class="rf-money rf-money-green">
                                        {{ number_format($ligne->total, 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </span>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="2">
                                    <div class="rf-empty">
                                        <i class="bi bi-calendar-x"></i>
                                        <span>Aucun encaissement pour cette période.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>


        {{-- =====================================================
         ENCAISSEMENTS PAR CLASSE ET CAISSIER
    ====================================================== --}}
        <div class="row g-4 mb-4">

            {{-- PAR CLASSE --}}
            <div class="col-lg-6">

                <div class="rf-card h-100">

                    <div class="rf-card-header">
                        <div>
                            <h5>
                                <i class="bi bi-mortarboard me-2"></i>
                                Encaissements par classe
                            </h5>
                            <p>Répartition des recettes selon les classes.</p>
                        </div>

                        <span class="rf-section-icon rf-blue">
                            <i class="bi bi-building"></i>
                        </span>
                    </div>

                    <div class="rf-table-container">

                        <table class="table rf-table align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>Classe</th>
                                    <th class="text-end">Montant encaissé</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($encaissementsParClasse as $ligne)
                                    <tr>
                                        <td>
                                            <div class="rf-name-cell">
                                                <span class="rf-small-icon rf-blue">
                                                    <i class="bi bi-book"></i>
                                                </span>
                                                {{ $ligne->nom }}
                                            </div>
                                        </td>

                                        <td class="text-end">
                                            <span class="rf-money">
                                                {{ number_format($ligne->total, 0, ',', ' ') }}
                                                <small>Ar</small>
                                            </span>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="2">
                                            <div class="rf-empty">
                                                <i class="bi bi-inbox"></i>
                                                <span>Aucune donnée disponible.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>
                </div>

            </div>


            {{-- PAR CAISSIER --}}
            <div class="col-lg-6">

                <div class="rf-card h-100">

                    <div class="rf-card-header">
                        <div>
                            <h5>
                                <i class="bi bi-people me-2"></i>
                                Encaissements par caissier
                            </h5>
                            <p>Répartition des encaissements par utilisateur.</p>
                        </div>

                        <span class="rf-section-icon rf-purple">
                            <i class="bi bi-person-badge"></i>
                        </span>
                    </div>

                    <div class="rf-table-container">

                        <table class="table rf-table align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>Caissier</th>
                                    <th class="text-end">Montant encaissé</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($encaissementsParCaissier as $ligne)
                                    <tr>
                                        <td>
                                            <div class="rf-name-cell">
                                                <span class="rf-small-icon rf-purple">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                                {{ $ligne->name }}
                                            </div>
                                        </td>

                                        <td class="text-end">
                                            <span class="rf-money">
                                                {{ number_format($ligne->total, 0, ',', ' ') }}
                                                <small>Ar</small>
                                            </span>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="2">
                                            <div class="rf-empty">
                                                <i class="bi bi-inbox"></i>
                                                <span>Aucune donnée disponible.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>
                </div>

            </div>

        </div>


        {{-- =====================================================
         FRAIS IMPAYÉS ET PARTIELS
    ====================================================== --}}
        <div class="rf-card mb-4">

            <div class="rf-card-header">

                <div>
                    <h5>
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Frais impayés et partiellement payés
                    </h5>

                    <p>Liste des frais dont le règlement n'est pas encore complet.</p>
                </div>

                <span class="rf-count-warning">
                    <i class="bi bi-hourglass-split me-1"></i>
                    {{ $fraisEnAttente->count() }}
                </span>

            </div>

            <div class="rf-table-container">

                <table class="table rf-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Frais</th>
                            <th class="text-end">Montant dû</th>
                            <th class="text-end">Déjà réglé</th>
                            <th class="text-end">Reste à payer</th>
                            <th>État</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($fraisEnAttente as $frais)
                            <tr>

                                <td>
                                    <div class="rf-student-name">
                                        <i class="bi bi-person-circle"></i>
                                        {{ $frais->eleve->nom ?? '' }}
                                        {{ $frais->eleve->prenom ?? '' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="rf-class-name">
                                        {{ $frais->eleve->classe->nom ?? '—' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="rf-fee-name">
                                        {{ $frais->libelle }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    {{ number_format($frais->montant_du, 0, ',', ' ') }}
                                    <small>Ar</small>
                                </td>

                                <td class="text-end">
                                    <span class="rf-money-green">
                                        {{ number_format($frais->montant_regle, 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </span>
                                </td>

                                <td class="text-end">
                                    <span class="rf-money-red">
                                        {{ number_format($frais->reste_a_payer, 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </span>
                                </td>

                                <td>
                                    @if ($frais->statut === 'partiel')
                                        <span class="rf-status rf-status-partial">
                                            <i class="bi bi-clock-history"></i>
                                            Partiel
                                        </span>
                                    @else
                                        <span class="rf-status rf-status-unpaid">
                                            <i class="bi bi-exclamation-circle"></i>
                                            Impayé
                                        </span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7">
                                    <div class="rf-empty rf-empty-success">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Aucun frais restant à payer.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>


        {{-- =====================================================
         PAIEMENTS ANNULÉS
    ====================================================== --}}
        <div class="rf-card mb-4">

            <div class="rf-card-header">

                <div>
                    <h5>
                        <i class="bi bi-x-octagon me-2"></i>
                        Historique des paiements annulés
                    </h5>

                    <p>Suivi des opérations annulées et de leurs motifs.</p>
                </div>

                <span class="rf-section-icon rf-red">
                    <i class="bi bi-shield-exclamation"></i>
                </span>

            </div>

            <div class="rf-table-container">

                <table class="table rf-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>N° paiement</th>
                            <th>Date</th>
                            <th>Élève</th>
                            <th>Caissier</th>
                            <th class="text-end">Montant</th>
                            <th>Motif d'annulation</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($paiementsAnnules as $paiement)
                            <tr>

                                <td>
                                    <span class="rf-payment-number">
                                        <i class="bi bi-receipt me-1"></i>
                                        {{ $paiement->numero_paiement }}
                                    </span>
                                </td>

                                <td>
                                    <div class="rf-date-cell">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $paiement->date_paiement?->format('d/m/Y') ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="rf-student-name">
                                        {{ $paiement->eleve->nom ?? '' }}
                                        {{ $paiement->eleve->prenom ?? '' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $paiement->utilisateur->name ?? '—' }}
                                </td>

                                <td class="text-end">
                                    <span class="rf-money-red">
                                        {{ number_format($paiement->montant_total, 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </span>
                                </td>

                                <td>
                                    <span class="rf-reason">
                                        {{ $paiement->annulation->motif ?? '—' }}
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6">
                                    <div class="rf-empty">
                                        <i class="bi bi-shield-check"></i>
                                        <span>Aucun paiement annulé.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>


    <style>
        /* =========================================================
       1. VARIABLES GÉNÉRALES
    ========================================================= */

        .rf-page {
            --rf-primary: #2563eb;
            --rf-primary-hover: #1d4ed8;
            --rf-primary-soft: #eff6ff;

            --rf-surface: #ffffff;
            --rf-surface-alt: #f8fafc;
            --rf-surface-hover: #f1f5f9;

            --rf-text: #172033;
            --rf-heading: #111827;
            --rf-muted: #718096;

            --rf-border: #e2e8f0;
            --rf-shadow: 0 5px 22px rgba(15, 23, 42, .055);

            --rf-green: #059669;
            --rf-red: #dc2626;
            --rf-orange: #d97706;
            --rf-purple: #7c3aed;
            --rf-blue: #2563eb;

            color: var(--rf-text);
        }

        /* =========================================================
       2. HERO
    ========================================================= */

        .rf-hero {
            padding: 27px 30px;
            border-radius: 18px;
            color: #fff;
            background: linear-gradient(120deg, #172554, #1d4ed8 65%, #3b82f6);
            box-shadow: 0 10px 28px rgba(37, 99, 235, .18);
            position: relative;
            overflow: hidden;
        }

        .rf-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border: 35px solid rgba(255, 255, 255, .07);
            border-radius: 50%;
            right: 65px;
            top: -135px;
        }

        .rf-eyebrow {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 9px;
        }

        .rf-title {
            font-size: 25px;
            font-weight: 850;
            color: #fff;
            margin-bottom: 7px;
        }

        .rf-subtitle {
            font-size: 13px;
            color: rgba(255, 255, 255, .82);
        }

        .rf-back-btn {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 16px;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 9px;
            color: #fff;
            background: rgba(255, 255, 255, .12);
            font-size: 12px;
            font-weight: 750;
            text-decoration: none;
            transition: .2s;
        }

        .rf-back-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, .23);
        }

        /* =========================================================
       3. CARTES
    ========================================================= */

        .rf-card {
            background: var(--rf-surface);
            border: 1px solid var(--rf-border);
            border-radius: 16px;
            box-shadow: var(--rf-shadow);
            overflow: hidden;
        }

        .rf-card-header {
            padding: 19px 22px;
            border-bottom: 1px solid var(--rf-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .rf-card-header h5 {
            color: var(--rf-heading);
            font-size: 15px;
            font-weight: 850;
            margin: 0 0 5px;
        }

        .rf-card-header p {
            color: var(--rf-muted);
            font-size: 12px;
            margin: 0;
        }

        .rf-card-body {
            padding: 22px;
        }

        .rf-header-icon,
        .rf-section-icon {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .rf-header-icon {
            background: var(--rf-primary-soft);
            color: var(--rf-primary);
        }

        .rf-blue {
            background: var(--rf-primary-soft);
            color: var(--rf-primary);
        }

        .rf-purple {
            background: #f0eaff;
            color: #7c3aed;
        }

        .rf-red {
            background: #feecec;
            color: #dc2626;
        }

        /* =========================================================
       4. FILTRES
    ========================================================= */

        .rf-label {
            display: block;
            color: var(--rf-text);
            font-size: 12px;
            font-weight: 750;
            margin-bottom: 8px;
        }

        .rf-page .form-control,
        .rf-page .form-select {
            min-height: 43px;
            background: var(--rf-surface-alt);
            color: var(--rf-text);
            border: 1px solid var(--rf-border);
            border-radius: 9px;
            font-size: 12px;
            box-shadow: none;
        }

        .rf-page .form-control::placeholder {
            color: var(--rf-muted);
        }

        .rf-page .form-control:focus,
        .rf-page .form-select:focus {
            background: var(--rf-surface);
            color: var(--rf-text);
            border-color: var(--rf-primary);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--rf-primary) 14%, transparent);
        }

        .rf-page .form-select option {
            background: var(--rf-surface);
            color: var(--rf-text);
        }

        /* BOUTONS */

        .rf-btn {
            min-height: 41px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            padding: 9px 15px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 750;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: .2s;
        }

        .rf-btn-primary {
            background: var(--rf-primary);
            color: #fff;
            border-color: var(--rf-primary);
        }

        .rf-btn-primary:hover {
            background: var(--rf-primary-hover);
            color: #fff;
            border-color: var(--rf-primary-hover);
            transform: translateY(-1px);
        }

        .rf-btn-secondary {
            background: var(--rf-surface-alt);
            color: var(--rf-text);
            border-color: var(--rf-border);
        }

        .rf-btn-secondary:hover {
            color: var(--rf-primary);
            border-color: var(--rf-primary);
        }

        /* =========================================================
       5. STATISTIQUES
    ========================================================= */

        .rf-stat {
            min-height: 145px;
            padding: 20px;
            background: var(--rf-surface);
            border: 1px solid var(--rf-border);
            border-radius: 15px;
            box-shadow: var(--rf-shadow);
            transition: .2s;
        }

        .rf-stat:hover {
            transform: translateY(-2px);
        }

        .rf-stat-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .rf-stat-label {
            color: var(--rf-muted);
            font-size: 12px;
            font-weight: 750;
        }

        .rf-stat-value {
            color: var(--rf-heading);
            font-size: 23px;
            font-weight: 850;
            margin-top: 9px;
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        .rf-stat-value small {
            color: var(--rf-muted);
            font-size: 11px;
            font-weight: 700;
        }

        .rf-stat-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .rf-stat-footer {
            border-top: 1px solid var(--rf-border);
            padding-top: 12px;
            margin-top: 14px;
            color: var(--rf-muted);
            font-size: 10px;
        }

        .rf-stat-green .rf-stat-icon {
            color: #059669;
            background: #e4f8ef;
        }

        .rf-stat-red .rf-stat-icon {
            color: #dc2626;
            background: #feecec;
        }

        .rf-stat-orange .rf-stat-icon {
            color: #d97706;
            background: #fff3df;
        }

        .rf-stat-gray .rf-stat-icon {
            color: #64748b;
            background: #edf1f5;
        }

        .rf-stat-green .rf-stat-footer i {
            color: #059669;
        }

        .rf-stat-red .rf-stat-footer i {
            color: #dc2626;
        }

        .rf-stat-orange .rf-stat-footer i {
            color: #d97706;
        }

        /* =========================================================
       6. TABLEAUX
    ========================================================= */

        .rf-table-container {
            max-height: 440px;
            overflow: auto;
        }

        .rf-table {
            min-width: 600px;
            color: var(--rf-text);
            border-color: var(--rf-border);

            --bs-table-bg: var(--rf-surface);
            --bs-table-color: var(--rf-text);
            --bs-table-border-color: var(--rf-border);
            --bs-table-hover-bg: var(--rf-surface-hover);
            --bs-table-hover-color: var(--rf-text);
        }

        .rf-table thead th {
            position: sticky;
            top: 0;
            z-index: 4;
            padding: 14px 15px;
            background: var(--rf-surface-alt);
            color: var(--rf-muted);
            border-bottom: 1px solid var(--rf-border);
            font-size: 10px;
            font-weight: 850;
            letter-spacing: .4px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .rf-table tbody td {
            padding: 13px 15px;
            background: var(--rf-surface);
            color: var(--rf-text);
            border-bottom: 1px solid var(--rf-border);
            font-size: 12px;
            vertical-align: middle;
        }

        .rf-table tbody tr:hover td {
            background: var(--rf-surface-hover);
        }

        .rf-date-cell {
            color: var(--rf-text);
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .rf-date-cell i {
            color: var(--rf-primary);
            margin-right: 6px;
        }

        .rf-money {
            color: var(--rf-heading);
            font-size: 12px;
            font-weight: 850;
            white-space: nowrap;
        }

        .rf-money small,
        .rf-money-green small,
        .rf-money-red small {
            color: var(--rf-muted);
            font-size: 10px;
        }

        .rf-money-green {
            color: #059669;
            font-size: 12px;
            font-weight: 850;
            white-space: nowrap;
        }

        .rf-money-red {
            color: #dc2626;
            font-size: 12px;
            font-weight: 850;
            white-space: nowrap;
        }

        .rf-name-cell {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--rf-text);
            font-size: 12px;
            font-weight: 750;
        }

        .rf-small-icon {
            width: 31px;
            height: 31px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
        }

        .rf-small-icon.rf-blue {
            background: var(--rf-primary-soft);
            color: var(--rf-primary);
        }

        .rf-small-icon.rf-purple {
            background: #f0eaff;
            color: #7c3aed;
        }

        .rf-student-name {
            color: var(--rf-text);
            font-size: 12px;
            font-weight: 750;
        }

        .rf-student-name i {
            color: var(--rf-primary);
            margin-right: 4px;
        }

        .rf-class-name,
        .rf-fee-name {
            color: var(--rf-muted);
            font-size: 11px;
            font-weight: 650;
        }

        .rf-payment-number {
            color: var(--rf-primary);
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .rf-reason {
            display: inline-block;
            max-width: 260px;
            color: var(--rf-muted);
            font-size: 11px;
            overflow-wrap: anywhere;
        }

        /* =========================================================
       7. BADGES ET ÉTATS
    ========================================================= */

        .rf-count-warning {
            padding: 8px 12px;
            border-radius: 8px;
            background: #fff3df;
            color: #a16207;
            font-size: 11px;
            font-weight: 850;
            white-space: nowrap;
        }

        .rf-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 9px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 850;
            white-space: nowrap;
        }

        .rf-status-partial {
            color: #92400e;
            background: #fef3c7;
        }

        .rf-status-unpaid {
            color: #b91c1c;
            background: #fee2e2;
        }

        /* =========================================================
       8. ÉTATS VIDES
    ========================================================= */

        .rf-empty {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 24px 15px;
            color: var(--rf-muted);
            font-size: 12px;
            font-weight: 600;
        }

        .rf-empty>i {
            color: var(--rf-primary);
            font-size: 19px;
        }

        .rf-empty-success {
            color: #059669;
        }

        .rf-empty-success>i {
            color: #059669;
        }

        /* =========================================================
       9. THÈME CLAIR CLASSIQUE
    ========================================================= */

        html[data-app-theme="clair"] .rf-page,
        html:not([data-app-theme]) .rf-page {
            --rf-primary: #2563eb;
            --rf-primary-hover: #1d4ed8;
            --rf-primary-soft: #eff6ff;

            --rf-surface: #ffffff;
            --rf-surface-alt: #f8fafc;
            --rf-surface-hover: #f1f5f9;

            --rf-text: #172033;
            --rf-heading: #111827;
            --rf-muted: #718096;

            --rf-border: #e2e8f0;
        }

        /* =========================================================
       10. THÈME SOMBRE
    ========================================================= */

        html[data-app-theme="dark"] .rf-page {
            --rf-primary: #60a5fa;
            --rf-primary-hover: #3b82f6;
            --rf-primary-soft: #1e3a5f;

            --rf-surface: #1e293b;
            --rf-surface-alt: #263449;
            --rf-surface-hover: #334155;

            --rf-text: #dbe4f0;
            --rf-heading: #f1f5f9;
            --rf-muted: #a6b4c7;

            --rf-border: #3b4a60;
            --rf-shadow: 0 5px 22px rgba(0, 0, 0, .20);
        }

        html[data-app-theme="dark"] .rf-page .rf-hero {
            background: linear-gradient(120deg, #0b1220, #172c4b 65%, #1d4ed8);
        }

        html[data-app-theme="dark"] .rf-page .rf-card,
        html[data-app-theme="dark"] .rf-page .rf-stat {
            background: var(--rf-surface);
            border-color: var(--rf-border);
        }

        html[data-app-theme="dark"] .rf-page .rf-card-header {
            background: #202e43;
            border-color: var(--rf-border);
        }

        html[data-app-theme="dark"] .rf-page .rf-card-header h5,
        html[data-app-theme="dark"] .rf-page .rf-stat-value,
        html[data-app-theme="dark"] .rf-page .rf-money {
            color: #f1f5f9;
        }

        html[data-app-theme="dark"] .rf-page .rf-card-header p,
        html[data-app-theme="dark"] .rf-page .rf-stat-label,
        html[data-app-theme="dark"] .rf-page .rf-stat-footer {
            color: #a6b4c7;
        }

        html[data-app-theme="dark"] .rf-page .form-control,
        html[data-app-theme="dark"] .rf-page .form-select {
            background-color: #111c2e;
            color: #e5edf8;
            border-color: #46566d;
        }

        html[data-app-theme="dark"] .rf-page .form-control:focus,
        html[data-app-theme="dark"] .rf-page .form-select:focus {
            background-color: #142239;
            color: #fff;
            border-color: #60a5fa;
        }

        html[data-app-theme="dark"] .rf-page .form-control::placeholder {
            color: #9aabc1;
        }

        html[data-app-theme="dark"] .rf-page .form-select option {
            background: #1e293b;
            color: #e5edf8;
        }

        html[data-app-theme="dark"] .rf-page .rf-table {
            --bs-table-bg: #1e293b;
            --bs-table-color: #dbe4f0;
            --bs-table-hover-bg: #334155;
            --bs-table-hover-color: #fff;
            --bs-table-border-color: #3b4a60;
        }

        html[data-app-theme="dark"] .rf-page .rf-table thead th {
            background: #263449;
            color: #c3d0e0;
            border-color: #3b4a60;
        }

        html[data-app-theme="dark"] .rf-page .rf-table tbody td {
            background: #1e293b;
            color: #dbe4f0;
            border-color: #3b4a60;
        }

        html[data-app-theme="dark"] .rf-page .rf-table tbody tr:hover td {
            background: #334155;
            color: #fff;
        }

        html[data-app-theme="dark"] .rf-page .rf-date-cell,
        html[data-app-theme="dark"] .rf-page .rf-name-cell,
        html[data-app-theme="dark"] .rf-page .rf-student-name,
        html[data-app-theme="dark"] .rf-page .rf-stat-value,
        html[data-app-theme="dark"] .rf-page .rf-money {
            color: #f1f5f9;
        }

        html[data-app-theme="dark"] .rf-page .rf-class-name,
        html[data-app-theme="dark"] .rf-page .rf-fee-name,
        html[data-app-theme="dark"] .rf-page .rf-reason {
            color: #a6b4c7;
        }

        html[data-app-theme="dark"] .rf-page .rf-money-green {
            color: #6ee7b7;
        }

        html[data-app-theme="dark"] .rf-page .rf-money-red {
            color: #fca5a5;
        }

        html[data-app-theme="dark"] .rf-page .rf-stat-green .rf-stat-icon {
            background: #064e3b;
            color: #6ee7b7;
        }

        html[data-app-theme="dark"] .rf-page .rf-stat-red .rf-stat-icon {
            background: #7f1d1d;
            color: #fecaca;
        }

        html[data-app-theme="dark"] .rf-page .rf-stat-orange .rf-stat-icon {
            background: #78350f;
            color: #fcd34d;
        }

        html[data-app-theme="dark"] .rf-page .rf-stat-gray .rf-stat-icon {
            background: #374151;
            color: #d1d5db;
        }

        html[data-app-theme="dark"] .rf-page .rf-status-partial {
            background: #78350f;
            color: #fde68a;
        }

        html[data-app-theme="dark"] .rf-page .rf-status-unpaid {
            background: #7f1d1d;
            color: #fecaca;
        }

        html[data-app-theme="dark"] .rf-page .rf-count-warning {
            background: #78350f;
            color: #fde68a;
        }

        html[data-app-theme="dark"] .rf-page .rf-purple {
            background: #3b276b;
            color: #c4b5fd;
        }

        html[data-app-theme="dark"] .rf-page .rf-red {
            background: #7f1d1d;
            color: #fecaca;
        }

        html[data-app-theme="dark"] .rf-page .rf-small-icon.rf-purple {
            background: #3b276b;
            color: #c4b5fd;
        }

        /* =========================================================
       11. THÈME ULTRA PRO
    ========================================================= */

        html[data-app-theme="ultra-pro"] .rf-page {
            --rf-primary: #3b82f6;
            --rf-primary-hover: #2563eb;
            --rf-primary-soft: #eaf1ff;

            --rf-surface: #ffffff;
            --rf-surface-alt: #f1f5f9;
            --rf-surface-hover: #eaf0f8;

            --rf-text: #263449;
            --rf-heading: #101d33;
            --rf-muted: #65758b;

            --rf-border: #dce4ef;
            --rf-shadow: 0 9px 30px rgba(15, 23, 42, .07);
        }

        html[data-app-theme="ultra-pro"] .rf-page .rf-hero {
            background: linear-gradient(115deg, #101827, #233b62 65%, #2563eb);
        }

        html[data-app-theme="ultra-pro"] .rf-page .rf-card,
        html[data-app-theme="ultra-pro"] .rf-page .rf-stat {
            border-radius: 17px;
        }

        html[data-app-theme="ultra-pro"] .rf-page .rf-table thead th {
            background: #eaf0f8;
            color: #465873;
        }

        /* =========================================================
       12. THÈME ÉMERAUDE
    ========================================================= */

        html[data-app-theme="emerald"] .rf-page {
            --rf-primary: #059669;
            --rf-primary-hover: #047857;
            --rf-primary-soft: #d1fae5;

            --rf-surface: #ffffff;
            --rf-surface-alt: #f0fdf7;
            --rf-surface-hover: #e7f8ef;

            --rf-text: #164e3c;
            --rf-heading: #064e3b;
            --rf-muted: #658477;

            --rf-border: #cde9da;
            --rf-shadow: 0 5px 22px rgba(6, 78, 59, .06);
        }

        html[data-app-theme="emerald"] .rf-page .rf-hero {
            background: linear-gradient(120deg, #064e3b, #047857, #10b981);
        }

        html[data-app-theme="emerald"] .rf-page .rf-table thead th {
            background: #e8f7ef;
            color: #166047;
        }

        html[data-app-theme="emerald"] .rf-page .rf-stat-green .rf-stat-icon {
            background: #d1fae5;
            color: #047857;
        }

        /* =========================================================
       13. THÈME CRÈME PRESTIGE
    ========================================================= */

        html[data-app-theme="creme-prestige"] .rf-page {
            --rf-primary: #a87935;
            --rf-primary-hover: #855b22;
            --rf-primary-soft: #f5ead5;

            --rf-surface: #fffdf8;
            --rf-surface-alt: #f8f2e7;
            --rf-surface-hover: #f5eddf;

            --rf-text: #514331;
            --rf-heading: #392b1b;
            --rf-muted: #89775e;

            --rf-border: #e9dcc5;
            --rf-shadow: 0 7px 24px rgba(91, 66, 29, .07);
        }

        html[data-app-theme="creme-prestige"] .rf-page .rf-hero {
            background: linear-gradient(120deg, #49351f, #80602e, #b28a4d);
        }

        html[data-app-theme="creme-prestige"] .rf-page .rf-table thead th {
            background: #f1e7d5;
            color: #6d5735;
        }

        html[data-app-theme="creme-prestige"] .rf-page .rf-stat-green .rf-stat-icon {
            background: #e5eedb;
            color: #527443;
        }

        html[data-app-theme="creme-prestige"] .rf-page .rf-stat-red .rf-stat-icon {
            background: #f8e5dc;
            color: #a64e36;
        }

        html[data-app-theme="creme-prestige"] .rf-page .rf-stat-orange .rf-stat-icon {
            background: #f9edda;
            color: #a87935;
        }

        html[data-app-theme="creme-prestige"] .rf-page .rf-status-partial {
            background: #f5ead5;
            color: #855b22;
        }

        html[data-app-theme="creme-prestige"] .rf-page .rf-status-unpaid {
            background: #f8e5dc;
            color: #9c4731;
        }

        html[data-app-theme="creme-prestige"] .rf-page .rf-count-warning {
            background: #f5ead5;
            color: #855b22;
        }

        /* =========================================================
       14. RESPONSIVE
    ========================================================= */

        @media(max-width: 768px) {

            .rf-hero {
                padding: 22px;
            }

            .rf-title {
                font-size: 21px;
            }

            .rf-back-btn {
                width: 100%;
                justify-content: center;
            }

            .rf-card-header {
                padding: 16px;
            }

            .rf-card-body {
                padding: 16px;
            }

            .rf-stat {
                min-height: 125px;
            }

            .rf-stat-value {
                font-size: 20px;
            }

            .rf-table-container {
                max-height: 380px;
            }

        }
    </style>
@endsection
