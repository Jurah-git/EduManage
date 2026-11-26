@extends('layouts.app')

@section('content')
    @php
        $totalPaiements = $paiements->total();
    @endphp

    <style>
        .paiements-page {
            --pay-bg: #f5f7fb;
            --pay-card: #ffffff;
            --pay-text: #263247;
            --pay-muted: #778399;
            --pay-border: #e7ebf2;
            --pay-primary: #4361ee;
            --pay-soft: #edf1ff;
            --pay-shadow: 0 5px 20px rgba(30, 45, 75, .055);
            color: var(--pay-text);
        }

        .paiements-page .pay-hero {
            background: linear-gradient(120deg, #263b80, #4361ee 65%, #7388f5);
            border-radius: 18px;
            padding: 28px 30px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(67, 97, 238, .18);
        }

        .paiements-page .pay-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            right: -65px;
            top: -110px;
            background: rgba(255, 255, 255, .09);
        }

        .paiements-page .pay-hero h2 {
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .paiements-page .pay-hero p {
            color: rgba(255, 255, 255, .78);
        }

        .paiements-page .pay-card {
            background: var(--pay-card);
            border: 1px solid var(--pay-border);
            border-radius: 15px;
            box-shadow: var(--pay-shadow);
        }

        .paiements-page .pay-stat {
            padding: 17px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            height: 100%;
        }

        .paiements-page .pay-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .paiements-page .pay-stat-label {
            color: var(--pay-muted);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .paiements-page .pay-stat-value {
            font-size: 21px;
            font-weight: 800;
            line-height: 1.3;
        }

        .paiements-page .pay-section-title {
            font-weight: 750;
            color: var(--pay-text);
        }

        .paiements-page .form-label {
            color: var(--pay-text);
            font-size: 13px;
            font-weight: 650;
        }

        .paiements-page .form-control,
        .paiements-page .form-select {
            min-height: 43px;
            border-color: var(--pay-border);
            border-radius: 9px;
            background-color: var(--pay-card);
            color: var(--pay-text);
        }

        .paiements-page .form-control:focus,
        .paiements-page .form-select:focus {
            border-color: var(--pay-primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, .12);
        }

        .paiements-page .btn {
            border-radius: 9px;
            font-weight: 600;
        }

        .paiements-page .pay-table-scroll {
            max-height: 570px;
            overflow: auto;
        }

        .paiements-page .table {
            color: var(--pay-text);
            margin-bottom: 0;
            white-space: nowrap;
        }

        .paiements-page .table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f2f5fa;
            color: #65728a;
            font-size: 11px;
            font-weight: 750;
            text-transform: uppercase;
            letter-spacing: .45px;
            padding: 15px 12px;
            border-bottom: 1px solid var(--pay-border);
        }

        .paiements-page .table tbody td {
            padding: 13px 12px;
            border-color: var(--pay-border);
            vertical-align: middle;
            font-size: 13px;
        }

        .paiements-page .table tbody tr:hover {
            background: rgba(67, 97, 238, .035);
        }

        .paiements-page .pay-number {
            color: var(--pay-primary);
            font-weight: 750;
        }

        .paiements-page .pay-student {
            font-weight: 700;
            color: var(--pay-text);
        }

        .paiements-page .pay-muted {
            color: var(--pay-muted);
            font-size: 11px;
        }

        .paiements-page .pay-amount {
            font-weight: 800;
            color: var(--pay-text);
        }

        .paiements-page .pay-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .paiements-page .pay-badge-success {
            color: #14804a;
            background: #e5f7ed;
        }

        .paiements-page .pay-badge-danger {
            color: #c03945;
            background: #fdebed;
        }

        .paiements-page .pay-badge-neutral {
            color: #596579;
            background: #edf0f5;
        }

        .paiements-page .pay-receipt {
            color: #14804a;
            font-weight: 700;
            font-size: 12px;
        }

        .paiements-page .pay-actions {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .paiements-page .pay-actions .btn {
            font-size: 11px;
            padding: 5px 9px;
        }

        .paiements-page .pay-empty {
            padding: 55px 20px !important;
            text-align: center;
            color: var(--pay-muted);
            white-space: normal;
        }

        .paiements-page .pay-empty-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            border-radius: 18px;
            background: var(--pay-soft);
            color: var(--pay-primary);
            font-size: 27px;
        }

        .paiements-page .card-footer {
            background: var(--pay-card);
            border-top: 1px solid var(--pay-border);
            border-radius: 0 0 15px 15px;
        }

        .paiements-page .pagination {
            margin-bottom: 0;
        }

        .paiements-page .page-link {
            color: var(--pay-primary);
            border-color: var(--pay-border);
            border-radius: 7px;
            margin: 0 2px;
        }

        .paiements-page .page-item.active .page-link {
            background: var(--pay-primary);
            border-color: var(--pay-primary);
            color: white;
        }

        .paiements-page .pay-table-scroll::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        .paiements-page .pay-table-scroll::-webkit-scrollbar-thumb {
            background: #cbd3e0;
            border-radius: 10px;
        }

        /* DARK */
        html[data-app-theme="dark"] .paiements-page {
            --pay-bg: #111827;
            --pay-card: #1e293b;
            --pay-text: #e5e7eb;
            --pay-muted: #a0aec0;
            --pay-border: #334155;
            --pay-soft: #293a60;
            --pay-shadow: 0 5px 20px rgba(0, 0, 0, .15);
        }

        html[data-app-theme="dark"] .paiements-page .pay-hero {
            background: linear-gradient(120deg, #172554, #263b80, #334e9d);
        }

        html[data-app-theme="dark"] .paiements-page .table,
        html[data-app-theme="dark"] .paiements-page .table tbody,
        html[data-app-theme="dark"] .paiements-page .table tbody tr,
        html[data-app-theme="dark"] .paiements-page .table tbody td {
            background-color: #1e293b !important;
            color: #e5e7eb !important;
            border-color: #334155 !important;
        }

        html[data-app-theme="dark"] .paiements-page .table thead th {
            background: #29384d !important;
            color: #dbe4f0 !important;
            border-color: #334155 !important;
        }

        html[data-app-theme="dark"] .paiements-page .table tbody tr:hover,
        html[data-app-theme="dark"] .paiements-page .table tbody tr:hover td {
            background: #29384d !important;
        }

        html[data-app-theme="dark"] .paiements-page .pay-student,
        html[data-app-theme="dark"] .paiements-page .pay-amount,
        html[data-app-theme="dark"] .paiements-page .pay-section-title,
        html[data-app-theme="dark"] .paiements-page .form-label {
            color: #f1f5f9 !important;
        }

        html[data-app-theme="dark"] .paiements-page .form-control,
        html[data-app-theme="dark"] .paiements-page .form-select {
            background-color: #172235 !important;
            color: #f1f5f9 !important;
            border-color: #475569 !important;
        }

        html[data-app-theme="dark"] .paiements-page .form-control::placeholder {
            color: #94a3b8;
        }

        html[data-app-theme="dark"] .paiements-page .card-footer {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        html[data-app-theme="dark"] .paiements-page .pay-badge-neutral {
            background: #334155;
            color: #e2e8f0;
        }

        html[data-app-theme="dark"] .paiements-page .pay-badge-success {
            background: #123d30;
            color: #86efac;
        }

        html[data-app-theme="dark"] .paiements-page .pay-badge-danger {
            background: #4a252d;
            color: #fda4af;
        }

        html[data-app-theme="dark"] .paiements-page .page-link {
            background: #172235;
            border-color: #475569;
            color: #cbd5e1;
        }

        html[data-app-theme="dark"] .paiements-page .page-item.active .page-link {
            background: var(--pay-primary);
            color: white;
        }

        /* ULTRA PRO */
        html[data-app-theme="ultra-pro"] .paiements-page {
            --pay-primary: #64748b;
            --pay-soft: #f1f5f9;
            --pay-border: #dce3ec;
        }

        html[data-app-theme="ultra-pro"] .paiements-page .pay-hero {
            background: linear-gradient(120deg, #172033, #475569);
        }

        /* EMERALD */
        html[data-app-theme="emerald"] .paiements-page {
            --pay-primary: #059669;
            --pay-soft: #e4f8ef;
        }

        html[data-app-theme="emerald"] .paiements-page .pay-hero {
            background: linear-gradient(120deg, #065f46, #059669, #34a982);
        }

        /* WARM */
        html[data-app-theme="warm"] .paiements-page {
            --pay-primary: #c07843;
            --pay-soft: #fff0e4;
            --pay-border: #f0e1d5;
        }

        html[data-app-theme="warm"] .paiements-page .pay-hero {
            background: linear-gradient(120deg, #854d32, #bd7950, #d99a6c);
        }

        @media (max-width: 768px) {
            .paiements-page .pay-hero {
                padding: 22px 20px;
            }

            .paiements-page .pay-hero h2 {
                font-size: 22px;
            }

            .paiements-page .pay-stat-value {
                font-size: 18px;
            }

            .paiements-page .pay-table-scroll {
                max-height: 500px;
            }

            .paiements-page .card-footer>div {
                align-items: flex-start !important;
            }
        }
    </style>

    <div class="container-fluid py-4 paiements-page">

        {{-- EN-TÊTE --}}
        <div class="pay-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 position-relative"
                style="z-index:1;">
                <div>
                    <div class="small mb-2" style="color:rgba(255,255,255,.75);">
                        FINANCES / ENCAISSEMENTS
                    </div>
                    <h2 class="mb-2">💰 Liste des paiements</h2>
                    <p class="mb-0">
                        Consultez et suivez l'historique des encaissements de l'établissement.
                    </p>
                </div>

                @if (auth()->user()->aPermission('frais.encaisser'))
                    <a href="{{ route('frais.paiements.create') }}" class="btn btn-light px-4 py-2">
                        <span class="me-1">＋</span> Nouvel encaissement
                    </a>
                @endif
            </div>
        </div>

        {{-- MESSAGES --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <strong>Succès :</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <strong>Attention :</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- INDICATEUR --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="pay-card pay-stat">
                    <div class="pay-stat-icon" style="background:#edf1ff;color:#4361ee;">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <div class="pay-stat-label">Paiements enregistrés</div>
                        <div class="pay-stat-value">{{ number_format($totalPaiements, 0, ',', ' ') }}</div>
                        <small class="pay-muted">Résultats correspondant aux filtres</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pay-card pay-stat">
                    <div class="pay-stat-icon" style="background:#e5f7ed;color:#14804a;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="pay-stat-label">Mode de paiement</div>
                        <div class="pay-stat-value">Espèces</div>
                        <small class="pay-muted">Encaissements en espèces uniquement</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pay-card pay-stat">
                    <div class="pay-stat-icon" style="background:#fff0e4;color:#c07843;">
                        <i class="bi bi-search"></i>
                    </div>
                    <div>
                        <div class="pay-stat-label">Recherche</div>
                        <div class="pay-stat-value">Filtres</div>
                        <small class="pay-muted">Par numéro, élève ou statut</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- RECHERCHE ET FILTRES --}}
        <div class="pay-card mb-4">
            <div class="p-3 p-md-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-funnel text-primary"></i>
                    <h5 class="pay-section-title mb-0">Recherche et filtres</h5>
                </div>

                <form method="GET" action="{{ route('frais.paiements.index') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-6">
                            <label class="form-label">Rechercher un paiement</label>
                            <input type="text" name="recherche" class="form-control" value="{{ request('recherche') }}"
                                placeholder="Numéro, nom, prénom ou matricule...">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Statut du paiement</label>
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="valide" {{ request('statut') === 'valide' ? 'selected' : '' }}>
                                    Validé
                                </option>
                                <option value="annule" {{ request('statut') === 'annule' ? 'selected' : '' }}>
                                    Annulé
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search me-1"></i> Rechercher
                            </button>

                            <a href="{{ route('frais.paiements.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- TABLEAU DES PAIEMENTS --}}
        <div class="pay-card overflow-hidden">

            <div class="p-3 p-md-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h5 class="pay-section-title mb-1">Historique des encaissements</h5>
                    <small class="pay-muted">Liste des paiements et de leurs reçus associés</small>
                </div>

                <span class="badge rounded-pill text-bg-primary px-3 py-2">
                    {{ $totalPaiements }} paiement(s)
                </span>
            </div>

            <div class="pay-table-scroll">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">N° Paiement</th>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Mode</th>
                            <th>Statut</th>
                            <th>Reçu</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($paiements as $paiement)
                            <tr>
                                <td class="ps-3">
                                    <span class="pay-number">
                                        {{ $paiement->numero_paiement }}
                                    </span>
                                </td>

                                <td>
                                    <div class="pay-student">
                                        {{ $paiement->eleve?->nom }}
                                        {{ $paiement->eleve?->prenom }}
                                    </div>
                                    <small class="pay-muted">
                                        {{ $paiement->eleve?->matricule ?? 'Matricule non renseigné' }}
                                    </small>
                                </td>

                                <td>
                                    {{ $paiement->eleve?->classe?->nom ?? '-' }}
                                </td>

                                <td>
                                    {{ $paiement->date_paiement?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>
                                    <span class="pay-amount">
                                        {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ar
                                    </span>
                                </td>

                                <td>
                                    <span class="pay-badge pay-badge-neutral">
                                        <i class="bi bi-cash"></i> Espèces
                                    </span>
                                </td>

                                <td>
                                    @if ($paiement->statut === 'valide')
                                        <span class="pay-badge pay-badge-success">
                                            <i class="bi bi-check-circle-fill"></i> Validé
                                        </span>
                                    @else
                                        <span class="pay-badge pay-badge-danger">
                                            <i class="bi bi-x-circle-fill"></i> Annulé
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($paiement->recu)
                                        <span class="pay-receipt">
                                            <i class="bi bi-receipt me-1"></i>
                                            {{ $paiement->recu->numero_recu }}
                                        </span>
                                    @else
                                        <span class="pay-muted">Aucun reçu</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="pay-actions">
                                        <a href="{{ route('frais.paiements.show', $paiement) }}"
                                            class="btn btn-sm btn-outline-primary" title="Voir les détails">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>

                                        @if ($paiement->recu && $paiement->statut === 'valide')
                                            <a href="{{ route('frais.recus.imprimer', $paiement->recu) }}"
                                                target="_blank" class="btn btn-sm btn-outline-success"
                                                title="Imprimer le reçu">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="pay-empty">
                                    <div class="pay-empty-icon">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Aucun paiement trouvé</h6>
                                    <p class="mb-0">
                                        Les paiements correspondant à votre recherche apparaîtront ici.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($paiements->hasPages())
                <div class="card-footer p-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <small class="pay-muted">
                            Affichage de {{ $paiements->firstItem() }}
                            à {{ $paiements->lastItem() }}
                            sur {{ $paiements->total() }} paiement(s)
                        </small>

                        {{ $paiements->withQueryString()->links() }}
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
