@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4 rec-page">

        {{-- ================= EN-TÊTE ================= --}}
        <div class="rec-hero mb-4">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div>
                    <div class="rec-eyebrow">
                        <i class="bi bi-cash-stack"></i>
                        GESTION FINANCIÈRE
                    </div>

                    <h2 class="rec-title">
                        <i class="bi bi-receipt-cutoff me-2"></i>
                        Reçus de paiement
                    </h2>

                    <p class="rec-subtitle mb-0">
                        Consultez, recherchez et imprimez les reçus des paiements enregistrés.
                    </p>
                </div>

                <div class="rec-hero-icon">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
        </div>


        {{-- ================= INDICATEURS ================= --}}
        <div class="row g-3 mb-4">

            <div class="col-xl-4 col-md-6">
                <div class="rec-stat">
                    <div class="rec-stat-icon rec-icon-blue">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div>
                        <div class="rec-stat-label">Reçus trouvés</div>
                        <div class="rec-stat-value">
                            {{ number_format($recus->total(), 0, ',', ' ') }}
                        </div>
                        <div class="rec-stat-info">Résultats correspondant aux filtres</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="rec-stat">
                    <div class="rec-stat-icon rec-icon-green">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div>
                        <div class="rec-stat-label">Reçus validés</div>
                        <div class="rec-stat-value">
                            {{ $recus->getCollection()->filter(fn($r) => $r->paiement?->statut === 'valide')->count() }}
                        </div>
                        <div class="rec-stat-info">Sur la page actuelle</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="rec-stat">
                    <div class="rec-stat-icon rec-icon-red">
                        <i class="bi bi-x-circle"></i>
                    </div>

                    <div>
                        <div class="rec-stat-label">Reçus annulés</div>
                        <div class="rec-stat-value">
                            {{ $recus->getCollection()->filter(fn($r) => $r->paiement?->statut === 'annule')->count() }}
                        </div>
                        <div class="rec-stat-info">Sur la page actuelle</div>
                    </div>
                </div>
            </div>

        </div>


        {{-- ================= RECHERCHE ET FILTRES ================= --}}
        <div class="rec-card mb-4">

            <div class="rec-card-header">
                <div>
                    <h5>
                        <i class="bi bi-funnel me-2"></i>
                        Recherche et filtres
                    </h5>
                    <p>Affinez la liste des reçus selon vos critères.</p>
                </div>
            </div>

            <div class="rec-card-body">

                <form method="GET" action="{{ route('frais.recus.index') }}">

                    <div class="row g-3">

                        <div class="col-xl-4 col-md-6">
                            <label class="rec-label">Recherche</label>

                            <div class="rec-input-icon">
                                <i class="bi bi-search"></i>

                                <input type="text" name="recherche" class="form-control"
                                    placeholder="N° reçu, paiement, élève, matricule..." value="{{ request('recherche') }}">
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-6">
                            <label class="rec-label">Statut</label>

                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>

                                <option value="valide" @selected(request('statut') === 'valide')>
                                    Validé
                                </option>

                                <option value="annule" @selected(request('statut') === 'annule')>
                                    Annulé
                                </option>
                            </select>
                        </div>

                        <div class="col-xl-2 col-md-6">
                            <label class="rec-label">Mode de paiement</label>

                            <select name="mode_paiement" class="form-select">
                                <option value="">Tous les modes</option>

                                <option value="especes" @selected(request('mode_paiement') === 'especes')>
                                    Espèces
                                </option>
                            </select>
                        </div>

                        <div class="col-xl-2 col-md-6">
                            <label class="rec-label">Date du</label>

                            <input type="date" name="date_debut" class="form-control"
                                value="{{ request('date_debut') }}">
                        </div>

                        <div class="col-xl-2 col-md-6">
                            <label class="rec-label">Date au</label>

                            <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                        </div>

                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">

                        <div class="rec-filter-hint">
                            <i class="bi bi-info-circle me-1"></i>
                            Les filtres peuvent être combinés.
                        </div>

                        <div class="d-flex gap-2 flex-wrap">

                            <a href="{{ route('frais.recus.index') }}" class="rec-btn rec-btn-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Réinitialiser
                            </a>

                            <button type="submit" class="rec-btn rec-btn-primary">
                                <i class="bi bi-search"></i>
                                Rechercher
                            </button>

                        </div>
                    </div>

                </form>

            </div>
        </div>


        {{-- ================= HISTORIQUE ================= --}}
        <div class="rec-card">

            <div class="rec-card-header rec-history-header">

                <div>
                    <h5>
                        <i class="bi bi-list-ul me-2"></i>
                        Historique des reçus
                    </h5>
                    <p>Liste des reçus correspondant à votre recherche.</p>
                </div>

                <span class="rec-count">
                    <i class="bi bi-receipt me-1"></i>
                    {{ number_format($recus->total(), 0, ',', ' ') }} reçu(s)
                </span>

            </div>


            <div class="rec-table-container">

                <table class="table rec-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="ps-4">N° Reçu</th>
                            <th>Élève</th>
                            <th>Matricule</th>
                            <th>N° Paiement</th>
                            <th>Date d'émission</th>
                            <th class="text-end">Montant payé</th>
                            <th>Mode</th>
                            <th>Statut</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recus as $recu)
                            @php
                                $paiement = $recu->paiement;
                                $eleve = $paiement?->eleve;
                            @endphp

                            <tr>

                                {{-- NUMÉRO REÇU --}}
                                <td class="ps-4">
                                    <div class="rec-number">
                                        <i class="bi bi-receipt"></i>
                                        {{ $recu->numero_recu }}
                                    </div>
                                </td>

                                {{-- ÉLÈVE --}}
                                <td>
                                    @if ($eleve)
                                        <div class="rec-student">

                                            <div class="rec-avatar">
                                                @if ($eleve->photo)
                                                    <img src="{{ asset('storage/' . $eleve->photo) }}" alt="Photo élève">
                                                @else
                                                    <i class="bi bi-person-fill"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="rec-student-name">
                                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                                </div>
                                                <div class="rec-student-sub">
                                                    Élève
                                                </div>
                                            </div>

                                        </div>
                                    @else
                                        <span class="rec-muted">Élève introuvable</span>
                                    @endif
                                </td>

                                {{-- MATRICULE --}}
                                <td>
                                    <span class="rec-matricule">
                                        {{ $eleve?->matricule ?? '—' }}
                                    </span>
                                </td>

                                {{-- NUMÉRO PAIEMENT --}}
                                <td>
                                    <span class="rec-payment-number">
                                        {{ $paiement?->numero_paiement ?? '—' }}
                                    </span>
                                </td>

                                {{-- DATE --}}
                                <td>
                                    <div class="rec-date">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $recu->date_emission?->format('d/m/Y') ?? '—' }}
                                    </div>

                                    <div class="rec-date-time">
                                        {{ $recu->date_emission?->format('H:i') ?? '' }}
                                    </div>
                                </td>

                                {{-- MONTANT --}}
                                <td class="text-end">
                                    <span class="rec-amount">
                                        {{ number_format((float) ($paiement?->montant_total ?? 0), 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </span>
                                </td>

                                {{-- MODE --}}
                                <td>
                                    <span class="rec-mode">
                                        <i class="bi bi-cash"></i>

                                        {{ $paiement?->mode_paiement === 'especes' ? 'Espèces' : $paiement?->mode_paiement ?? '—' }}
                                    </span>
                                </td>

                                {{-- STATUT --}}
                                <td>

                                    @if ($paiement?->statut === 'valide')
                                        <span class="rec-status rec-status-valid">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Validé
                                        </span>
                                    @elseif($paiement?->statut === 'annule')
                                        <span class="rec-status rec-status-cancel">
                                            <i class="bi bi-x-circle-fill"></i>
                                            Annulé
                                        </span>
                                    @else
                                        <span class="rec-status rec-status-unknown">
                                            Inconnu
                                        </span>
                                    @endif

                                </td>

                                {{-- ACTION --}}
                                <td class="text-center">

                                    @if ($paiement && $paiement->statut === 'valide')
                                        @if (auth()->user()->aPermission('frais.recus_imprimer'))
                                            <a href="{{ route('frais.recus.imprimer', $recu) }}" class="rec-action-btn"
                                                title="Afficher et imprimer le reçu">

                                                <i class="bi bi-printer-fill"></i>
                                                Afficher

                                            </a>
                                        @else
                                            <span class="rec-unavailable">
                                                <i class="bi bi-lock"></i>
                                                Non autorisé
                                            </span>
                                        @endif
                                    @else
                                        <span class="rec-unavailable">
                                            <i class="bi bi-slash-circle"></i>
                                            Indisponible
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9">

                                    <div class="rec-empty">

                                        <div class="rec-empty-icon">
                                            <i class="bi bi-receipt"></i>
                                        </div>

                                        <h5>Aucun reçu trouvé</h5>

                                        <p>
                                            Aucun reçu ne correspond aux critères sélectionnés.
                                        </p>

                                        @if (request()->hasAny(['recherche', 'statut', 'mode_paiement', 'date_debut', 'date_fin']))
                                            <a href="{{ route('frais.recus.index') }}" class="rec-btn rec-btn-primary">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                                Effacer les filtres
                                            </a>
                                        @endif

                                    </div>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>


            {{-- PAGINATION --}}
            @if ($recus->hasPages())
                <div class="rec-pagination">

                    <div class="rec-pagination-info">
                        Affichage de
                        <strong>{{ $recus->firstItem() ?? 0 }}</strong>
                        à
                        <strong>{{ $recus->lastItem() ?? 0 }}</strong>
                        sur
                        <strong>{{ $recus->total() }}</strong>
                        reçu(s)
                    </div>

                    {{ $recus->withQueryString()->links() }}

                </div>
            @endif

        </div>

    </div>


    <style>
        /* =========================================================
       1. VARIABLES COMMUNES
    ========================================================= */

        .rec-page {
            --rec-primary: #2563eb;
            --rec-primary-hover: #1d4ed8;
            --rec-primary-soft: #eff6ff;

            --rec-bg: #f5f7fb;
            --rec-surface: #ffffff;
            --rec-surface-alt: #f8fafc;
            --rec-surface-hover: #f1f5f9;

            --rec-text: #172033;
            --rec-heading: #111827;
            --rec-muted: #718096;

            --rec-border: #e2e8f0;
            --rec-shadow: 0 5px 22px rgba(15, 23, 42, .055);

            --rec-blue: #2563eb;
            --rec-green: #059669;
            --rec-red: #dc2626;
            --rec-orange: #d97706;

            color: var(--rec-text);
        }

        /* =========================================================
       2. HERO
    ========================================================= */

        .rec-hero {
            padding: 27px 30px;
            border-radius: 18px;
            color: #fff;
            background: linear-gradient(120deg, #172554, #1d4ed8 65%, #3b82f6);
            box-shadow: 0 10px 28px rgba(37, 99, 235, .18);
            position: relative;
            overflow: hidden;
        }

        .rec-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border: 35px solid rgba(255, 255, 255, .07);
            border-radius: 50%;
            right: 55px;
            top: -125px;
        }

        .rec-eyebrow {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.6px;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 9px;
        }

        .rec-title {
            font-size: 25px;
            font-weight: 850;
            color: #fff;
            margin-bottom: 7px;
        }

        .rec-subtitle {
            color: rgba(255, 255, 255, .8);
            font-size: 13px;
        }

        .rec-hero-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .15);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 31px;
            position: relative;
            z-index: 1;
        }

        /* =========================================================
       3. STATISTIQUES
    ========================================================= */

        .rec-stat {
            display: flex;
            align-items: center;
            gap: 17px;
            min-height: 112px;
            padding: 20px;
            border-radius: 15px;
            background: var(--rec-surface);
            border: 1px solid var(--rec-border);
            box-shadow: var(--rec-shadow);
            transition: .2s;
        }

        .rec-stat:hover {
            transform: translateY(-2px);
        }

        .rec-stat-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .rec-icon-blue {
            color: #2563eb;
            background: #eaf1ff;
        }

        .rec-icon-green {
            color: #059669;
            background: #e4f8ef;
        }

        .rec-icon-red {
            color: #dc2626;
            background: #feecec;
        }

        .rec-stat-label {
            color: var(--rec-muted);
            font-size: 12px;
            font-weight: 750;
        }

        .rec-stat-value {
            color: var(--rec-heading);
            font-size: 25px;
            font-weight: 850;
            line-height: 1.4;
        }

        .rec-stat-info {
            color: var(--rec-muted);
            font-size: 11px;
        }

        /* =========================================================
       4. CARTES
    ========================================================= */

        .rec-card {
            background: var(--rec-surface);
            border: 1px solid var(--rec-border);
            border-radius: 16px;
            box-shadow: var(--rec-shadow);
            overflow: hidden;
        }

        .rec-card-header {
            padding: 19px 22px;
            border-bottom: 1px solid var(--rec-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .rec-card-header h5 {
            font-size: 15px;
            font-weight: 850;
            color: var(--rec-heading);
            margin-bottom: 5px;
        }

        .rec-card-header p {
            font-size: 12px;
            color: var(--rec-muted);
            margin-bottom: 0;
        }

        .rec-card-body {
            padding: 22px;
        }

        /* =========================================================
       5. FORMULAIRES
    ========================================================= */

        .rec-label {
            display: block;
            font-size: 12px;
            font-weight: 750;
            color: var(--rec-text);
            margin-bottom: 8px;
        }

        .rec-page .form-control,
        .rec-page .form-select {
            min-height: 43px;
            border: 1px solid var(--rec-border);
            border-radius: 9px;
            background-color: var(--rec-surface-alt);
            color: var(--rec-text);
            font-size: 12px;
            box-shadow: none;
            transition: .2s;
        }

        .rec-page .form-control::placeholder {
            color: var(--rec-muted);
            opacity: .8;
        }

        .rec-page .form-control:focus,
        .rec-page .form-select:focus {
            background-color: var(--rec-surface);
            border-color: var(--rec-primary);
            color: var(--rec-text);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--rec-primary) 14%, transparent);
        }

        .rec-page .form-select option {
            background: var(--rec-surface);
            color: var(--rec-text);
        }

        .rec-input-icon {
            position: relative;
        }

        .rec-input-icon>i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--rec-muted);
            z-index: 2;
        }

        .rec-input-icon input {
            padding-left: 38px;
        }

        .rec-filter-hint {
            color: var(--rec-muted);
            font-size: 11px;
        }

        /* BOUTONS */

        .rec-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            padding: 9px 16px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 750;
            text-decoration: none;
            border: 1px solid transparent;
            transition: .2s;
            cursor: pointer;
        }

        .rec-btn-primary {
            color: #fff;
            background: var(--rec-primary);
            border-color: var(--rec-primary);
        }

        .rec-btn-primary:hover {
            color: #fff;
            background: var(--rec-primary-hover);
            border-color: var(--rec-primary-hover);
            transform: translateY(-1px);
        }

        .rec-btn-secondary {
            color: var(--rec-text);
            background: var(--rec-surface-alt);
            border-color: var(--rec-border);
        }

        .rec-btn-secondary:hover {
            color: var(--rec-primary);
            border-color: var(--rec-primary);
            background: var(--rec-surface);
        }

        /* =========================================================
       6. TABLEAU
    ========================================================= */

        .rec-history-header {
            min-height: 76px;
        }

        .rec-count {
            white-space: nowrap;
            padding: 8px 13px;
            border-radius: 9px;
            background: var(--rec-primary-soft);
            color: var(--rec-primary);
            font-size: 12px;
            font-weight: 850;
        }

        .rec-table-container {
            max-height: 590px;
            overflow: auto;
        }

        .rec-table {
            min-width: 1120px;
            color: var(--rec-text);
            border-color: var(--rec-border);
            --bs-table-bg: var(--rec-surface);
            --bs-table-color: var(--rec-text);
            --bs-table-hover-bg: var(--rec-surface-hover);
            --bs-table-hover-color: var(--rec-text);
            --bs-table-border-color: var(--rec-border);
        }

        .rec-table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            padding: 14px 12px;
            background: var(--rec-surface-alt);
            color: var(--rec-muted);
            border-bottom: 1px solid var(--rec-border);
            font-size: 10px;
            font-weight: 850;
            text-transform: uppercase;
            letter-spacing: .45px;
            white-space: nowrap;
        }

        .rec-table tbody td {
            padding: 13px 12px;
            border-bottom: 1px solid var(--rec-border);
            font-size: 12px;
            vertical-align: middle;
            background: var(--rec-surface);
            color: var(--rec-text);
        }

        .rec-table tbody tr:hover td {
            background: var(--rec-surface-hover);
        }

        .rec-number {
            color: var(--rec-primary);
            font-weight: 850;
            white-space: nowrap;
        }

        .rec-number i {
            margin-right: 5px;
        }

        .rec-student {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 170px;
        }

        .rec-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--rec-primary-soft);
            color: var(--rec-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .rec-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rec-student-name {
            font-size: 12px;
            font-weight: 800;
            color: var(--rec-heading);
        }

        .rec-student-sub {
            color: var(--rec-muted);
            font-size: 10px;
            margin-top: 2px;
        }

        .rec-muted,
        .rec-matricule,
        .rec-payment-number {
            font-size: 11px;
            color: var(--rec-muted);
            font-weight: 700;
        }

        .rec-date {
            font-size: 11px;
            font-weight: 750;
            color: var(--rec-text);
            white-space: nowrap;
        }

        .rec-date i {
            color: var(--rec-primary);
            margin-right: 4px;
        }

        .rec-date-time {
            padding-left: 18px;
            font-size: 10px;
            color: var(--rec-muted);
        }

        .rec-amount {
            font-size: 13px;
            font-weight: 850;
            color: var(--rec-heading);
            white-space: nowrap;
        }

        .rec-amount small {
            font-size: 10px;
            color: var(--rec-muted);
        }

        .rec-mode {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--rec-text);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .rec-mode i {
            color: var(--rec-green);
        }

        /* BADGES */

        .rec-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 9px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 850;
            white-space: nowrap;
        }

        .rec-status-valid {
            color: #047857;
            background: #dcfce7;
        }

        .rec-status-cancel {
            color: #b91c1c;
            background: #fee2e2;
        }

        .rec-status-unknown {
            color: #475569;
            background: #e2e8f0;
        }

        /* ACTION */

        .rec-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 11px;
            border-radius: 8px;
            color: var(--rec-primary);
            background: var(--rec-primary-soft);
            border: 1px solid var(--rec-border);
            text-decoration: none;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
            transition: .2s;
        }

        .rec-action-btn:hover {
            color: #fff;
            background: var(--rec-primary);
            border-color: var(--rec-primary);
        }

        .rec-unavailable {
            color: var(--rec-muted);
            font-size: 10px;
            white-space: nowrap;
        }

        /* =========================================================
       7. AUCUN RÉSULTAT
    ========================================================= */

        .rec-empty {
            text-align: center;
            padding: 55px 20px;
        }

        .rec-empty-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 16px;
            border-radius: 20px;
            background: var(--rec-primary-soft);
            color: var(--rec-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .rec-empty h5 {
            color: var(--rec-heading);
            font-size: 16px;
            font-weight: 850;
        }

        .rec-empty p {
            color: var(--rec-muted);
            font-size: 12px;
            margin-bottom: 18px;
        }

        /* =========================================================
       8. PAGINATION
    ========================================================= */

        .rec-pagination {
            padding: 16px 20px;
            border-top: 1px solid var(--rec-border);
            background: var(--rec-surface);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .rec-pagination-info {
            font-size: 11px;
            color: var(--rec-muted);
        }

        .rec-pagination-info strong {
            color: var(--rec-text);
        }

        .rec-pagination .pagination {
            margin: 0;
            gap: 4px;
        }

        .rec-pagination .page-link {
            color: var(--rec-primary);
            background: var(--rec-surface);
            border: 1px solid var(--rec-border);
            border-radius: 7px;
            font-size: 11px;
        }

        .rec-pagination .page-link:hover {
            background: var(--rec-primary-soft);
        }

        .rec-pagination .active .page-link {
            background: var(--rec-primary);
            border-color: var(--rec-primary);
            color: #fff;
        }

        .rec-pagination .disabled .page-link {
            background: var(--rec-surface-alt);
            color: var(--rec-muted);
        }

        /* =========================================================
       9. THÈME CLAIR CLASSIQUE
    ========================================================= */

        html[data-app-theme="clair"] .rec-page,
        html:not([data-app-theme]) .rec-page {
            --rec-primary: #2563eb;
            --rec-primary-hover: #1d4ed8;
            --rec-primary-soft: #eff6ff;

            --rec-bg: #f5f7fb;
            --rec-surface: #ffffff;
            --rec-surface-alt: #f8fafc;
            --rec-surface-hover: #f1f5f9;

            --rec-text: #172033;
            --rec-heading: #111827;
            --rec-muted: #718096;

            --rec-border: #e2e8f0;
        }

        /* =========================================================
       10. THÈME SOMBRE
    ========================================================= */

        html[data-app-theme="dark"] .rec-page {
            --rec-primary: #60a5fa;
            --rec-primary-hover: #3b82f6;
            --rec-primary-soft: #1e3a5f;

            --rec-bg: #0f172a;
            --rec-surface: #1e293b;
            --rec-surface-alt: #263449;
            --rec-surface-hover: #334155;

            --rec-text: #dbe4f0;
            --rec-heading: #f1f5f9;
            --rec-muted: #a6b4c7;

            --rec-border: #3b4a60;

            --rec-shadow: 0 5px 22px rgba(0, 0, 0, .20);
        }

        html[data-app-theme="dark"] .rec-page .rec-hero {
            background: linear-gradient(120deg, #0b1220, #172c4b 65%, #1d4ed8);
        }

        html[data-app-theme="dark"] .rec-page .rec-stat {
            background: var(--rec-surface);
            border-color: var(--rec-border);
        }

        html[data-app-theme="dark"] .rec-page .rec-card {
            background: var(--rec-surface);
            border-color: var(--rec-border);
        }

        html[data-app-theme="dark"] .rec-page .rec-card-header {
            background: #202e43;
            border-color: var(--rec-border);
        }

        html[data-app-theme="dark"] .rec-page .rec-card-header h5,
        html[data-app-theme="dark"] .rec-page .rec-stat-value,
        html[data-app-theme="dark"] .rec-page .rec-student-name,
        html[data-app-theme="dark"] .rec-page .rec-amount {
            color: var(--rec-heading);
        }

        html[data-app-theme="dark"] .rec-page .rec-card-header p,
        html[data-app-theme="dark"] .rec-page .rec-stat-label,
        html[data-app-theme="dark"] .rec-page .rec-stat-info {
            color: var(--rec-muted);
        }

        html[data-app-theme="dark"] .rec-page .form-control,
        html[data-app-theme="dark"] .rec-page .form-select {
            background-color: #111c2e;
            color: #e5edf8;
            border-color: #46566d;
        }

        html[data-app-theme="dark"] .rec-page .form-control::placeholder {
            color: #9aabc1;
        }

        html[data-app-theme="dark"] .rec-page .form-control:focus,
        html[data-app-theme="dark"] .rec-page .form-select:focus {
            background-color: #142239;
            color: #fff;
            border-color: #60a5fa;
        }

        html[data-app-theme="dark"] .rec-page .form-select option {
            background: #1e293b;
            color: #e5edf8;
        }

        html[data-app-theme="dark"] .rec-page .rec-table {
            --bs-table-bg: #1e293b;
            --bs-table-color: #dbe4f0;
            --bs-table-hover-bg: #334155;
            --bs-table-hover-color: #fff;
            --bs-table-border-color: #3b4a60;
        }

        html[data-app-theme="dark"] .rec-page .rec-table thead th {
            background: #263449;
            color: #c3d0e0;
            border-color: #3b4a60;
        }

        html[data-app-theme="dark"] .rec-page .rec-table tbody td {
            background: #1e293b;
            color: #dbe4f0;
            border-color: #3b4a60;
        }

        html[data-app-theme="dark"] .rec-page .rec-table tbody tr:hover td {
            background: #334155;
            color: #fff;
        }

        html[data-app-theme="dark"] .rec-page .rec-date,
        html[data-app-theme="dark"] .rec-page .rec-mode,
        html[data-app-theme="dark"] .rec-page .rec-student-name,
        html[data-app-theme="dark"] .rec-page .rec-amount {
            color: #f1f5f9;
        }

        html[data-app-theme="dark"] .rec-page .rec-muted,
        html[data-app-theme="dark"] .rec-page .rec-matricule,
        html[data-app-theme="dark"] .rec-page .rec-payment-number,
        html[data-app-theme="dark"] .rec-page .rec-date-time,
        html[data-app-theme="dark"] .rec-page .rec-student-sub {
            color: #a6b4c7;
        }

        html[data-app-theme="dark"] .rec-page .rec-status-valid {
            background: #064e3b;
            color: #a7f3d0;
        }

        html[data-app-theme="dark"] .rec-page .rec-status-cancel {
            background: #7f1d1d;
            color: #fecaca;
        }

        html[data-app-theme="dark"] .rec-page .rec-status-unknown {
            background: #374151;
            color: #e5e7eb;
        }

        html[data-app-theme="dark"] .rec-page .rec-icon-blue {
            background: #1e3a5f;
            color: #93c5fd;
        }

        html[data-app-theme="dark"] .rec-page .rec-icon-green {
            background: #064e3b;
            color: #6ee7b7;
        }

        html[data-app-theme="dark"] .rec-page .rec-icon-red {
            background: #7f1d1d;
            color: #fecaca;
        }

        html[data-app-theme="dark"] .rec-page .rec-btn-secondary {
            background: #263449;
            border-color: #46566d;
            color: #e5edf8;
        }

        html[data-app-theme="dark"] .rec-page .rec-btn-secondary:hover {
            border-color: #60a5fa;
            color: #93c5fd;
        }

        html[data-app-theme="dark"] .rec-page .rec-action-btn {
            background: #1e3a5f;
            border-color: #365b87;
            color: #bfdbfe;
        }

        html[data-app-theme="dark"] .rec-page .rec-action-btn:hover {
            background: #2563eb;
            color: #fff;
        }

        html[data-app-theme="dark"] .rec-page .rec-pagination {
            background: #1e293b;
            border-color: #3b4a60;
        }

        html[data-app-theme="dark"] .rec-page .rec-pagination .page-link {
            background: #263449;
            border-color: #46566d;
            color: #bfdbfe;
        }

        html[data-app-theme="dark"] .rec-page .rec-pagination .active .page-link {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        html[data-app-theme="dark"] .rec-page .rec-empty h5 {
            color: #f1f5f9;
        }

        html[data-app-theme="dark"] .rec-page .rec-empty-icon {
            background: #1e3a5f;
            color: #93c5fd;
        }

        /* =========================================================
       11. THÈME ULTRA PRO
    ========================================================= */

        html[data-app-theme="ultra-pro"] .rec-page {
            --rec-primary: #3b82f6;
            --rec-primary-hover: #2563eb;
            --rec-primary-soft: #eaf1ff;

            --rec-surface: #ffffff;
            --rec-surface-alt: #f1f5f9;
            --rec-surface-hover: #eaf0f8;

            --rec-text: #263449;
            --rec-heading: #101d33;
            --rec-muted: #65758b;

            --rec-border: #dce4ef;
            --rec-shadow: 0 9px 30px rgba(15, 23, 42, .07);
        }

        html[data-app-theme="ultra-pro"] .rec-page .rec-hero {
            background: linear-gradient(115deg, #101827, #233b62 65%, #2563eb);
        }

        html[data-app-theme="ultra-pro"] .rec-page .rec-card,
        html[data-app-theme="ultra-pro"] .rec-page .rec-stat {
            border-radius: 17px;
        }

        html[data-app-theme="ultra-pro"] .rec-page .rec-table thead th {
            background: #eaf0f8;
            color: #465873;
        }

        /* =========================================================
       12. THÈME ÉMERAUDE
    ========================================================= */

        html[data-app-theme="emerald"] .rec-page {
            --rec-primary: #059669;
            --rec-primary-hover: #047857;
            --rec-primary-soft: #d1fae5;

            --rec-surface: #ffffff;
            --rec-surface-alt: #f0fdf7;
            --rec-surface-hover: #e7f8ef;

            --rec-text: #164e3c;
            --rec-heading: #064e3b;
            --rec-muted: #658477;

            --rec-border: #cde9da;
            --rec-shadow: 0 5px 22px rgba(6, 78, 59, .06);
        }

        html[data-app-theme="emerald"] .rec-page .rec-hero {
            background: linear-gradient(120deg, #064e3b, #047857, #10b981);
        }

        html[data-app-theme="emerald"] .rec-page .rec-icon-blue {
            color: #047857;
            background: #d1fae5;
        }

        html[data-app-theme="emerald"] .rec-page .rec-table thead th {
            background: #e8f7ef;
            color: #166047;
        }

        /* =========================================================
       13. THÈME CRÈME PRESTIGE
    ========================================================= */

        html[data-app-theme="creme-prestige"] .rec-page {
            --rec-primary: #a87935;
            --rec-primary-hover: #855b22;
            --rec-primary-soft: #f5ead5;

            --rec-surface: #fffdf8;
            --rec-surface-alt: #f8f2e7;
            --rec-surface-hover: #f5eddf;

            --rec-text: #514331;
            --rec-heading: #392b1b;
            --rec-muted: #89775e;

            --rec-border: #e9dcc5;
            --rec-shadow: 0 7px 24px rgba(91, 66, 29, .07);
        }

        html[data-app-theme="creme-prestige"] .rec-page .rec-hero {
            background: linear-gradient(120deg, #49351f, #80602e, #b28a4d);
        }

        html[data-app-theme="creme-prestige"] .rec-page .rec-icon-blue {
            background: #f5ead5;
            color: #a87935;
        }

        html[data-app-theme="creme-prestige"] .rec-page .rec-icon-green {
            background: #e8f0df;
            color: #527443;
        }

        html[data-app-theme="creme-prestige"] .rec-page .rec-icon-red {
            background: #f8e8df;
            color: #a64e36;
        }

        html[data-app-theme="creme-prestige"] .rec-page .rec-table thead th {
            background: #f1e7d5;
            color: #6d5735;
        }

        html[data-app-theme="creme-prestige"] .rec-page .rec-status-valid {
            background: #e5eedb;
            color: #426337;
        }

        html[data-app-theme="creme-prestige"] .rec-page .rec-status-cancel {
            background: #f8e5dc;
            color: #9c4731;
        }

        /* =========================================================
       14. RESPONSIVE
    ========================================================= */

        @media(max-width: 768px) {

            .rec-hero {
                padding: 22px;
            }

            .rec-title {
                font-size: 21px;
            }

            .rec-hero-icon {
                display: none;
            }

            .rec-card-body {
                padding: 16px;
            }

            .rec-history-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .rec-pagination {
                align-items: flex-start;
                flex-direction: column;
            }

        }
    </style>

@endsection
