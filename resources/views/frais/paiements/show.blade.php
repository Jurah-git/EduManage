@extends('layouts.app')

@section('content')

    @php
        $estValide = $paiement->statut === 'valide';
        $eleve = $paiement->eleve;
        $photoEleve = $eleve?->photo ? asset('storage/' . $eleve->photo) : null;
    @endphp

    <style>
        .ps-page {
            --ps-primary: #2563eb;
            --ps-primary-soft: rgba(37, 99, 235, .10);
            --ps-success: #059669;
            --ps-danger: #dc2626;
            --ps-warning: #d97706;
            --ps-text: #1e293b;
            --ps-muted: #64748b;
            --ps-card: #ffffff;
            --ps-bg: #f4f7fb;
            --ps-border: #e2e8f0;
            --ps-head: #f8fafc;
            color: var(--ps-text);
            padding: 24px;
            border-radius: 18px;
            background: var(--ps-bg);
        }

        .ps-page * {
            box-sizing: border-box;
        }

        .ps-hero {
            position: relative;
            overflow: hidden;
            padding: 28px;
            margin-bottom: 24px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(120deg, #172554, #1d4ed8 65%, #3b82f6);
            box-shadow: 0 12px 30px rgba(30, 64, 175, .16);
        }

        .ps-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            right: -65px;
            top: -110px;
            background: rgba(255, 255, 255, .08);
        }

        .ps-hero-content {
            position: relative;
            z-index: 1;
        }

        .ps-hero h2 {
            font-size: 25px;
            font-weight: 800;
            margin: 0 0 7px;
        }

        .ps-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
        }

        .ps-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 10px;
            background: rgba(255, 255, 255, .12);
            transition: .2s;
        }

        .ps-back:hover {
            background: white;
            color: #1d4ed8;
        }

        .ps-card {
            background: var(--ps-card);
            border: 1px solid var(--ps-border);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 22px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .035);
        }

        .ps-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 17px 21px;
            background: var(--ps-head);
            border-bottom: 1px solid var(--ps-border);
        }

        .ps-card-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--ps-primary-soft);
            color: var(--ps-primary);
            font-size: 18px;
        }

        .ps-card-header h5 {
            font-size: 15px;
            font-weight: 800;
            margin: 0;
            color: var(--ps-text);
        }

        .ps-card-header p {
            font-size: 11px;
            margin: 3px 0 0;
            color: var(--ps-muted);
        }

        .ps-card-body {
            padding: 22px;
        }

        .ps-info-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px 24px;
        }

        .ps-info-label {
            display: block;
            color: var(--ps-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .45px;
            margin-bottom: 6px;
        }

        .ps-info-value {
            color: var(--ps-text);
            font-size: 14px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .ps-amount {
            color: var(--ps-success);
            font-size: 21px;
            font-weight: 900;
        }

        .ps-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 800;
        }

        .ps-status-valid {
            color: #047857;
            background: #d1fae5;
        }

        .ps-status-cancel {
            color: #b91c1c;
            background: #fee2e2;
        }

        .ps-student {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .ps-student-photo {
            width: 86px;
            height: 86px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 29px;
            font-weight: 800;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border: 3px solid var(--ps-border);
        }

        .ps-student-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ps-student-name {
            font-size: 19px;
            font-weight: 900;
            color: var(--ps-text);
            margin-bottom: 7px;
        }

        .ps-student-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .ps-student-tag {
            padding: 5px 9px;
            border-radius: 7px;
            background: var(--ps-head);
            border: 1px solid var(--ps-border);
            color: var(--ps-muted);
            font-size: 11px;
            font-weight: 700;
        }

        .ps-table-wrap {
            max-height: 430px;
            overflow: auto;
        }

        .ps-table {
            width: 100%;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
            color: var(--ps-text);
        }

        .ps-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            padding: 14px 17px;
            background: var(--ps-head);
            color: var(--ps-muted);
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid var(--ps-border);
            white-space: nowrap;
        }

        .ps-table tbody td {
            padding: 15px 17px;
            border-bottom: 1px solid var(--ps-border);
            font-size: 13px;
            color: var(--ps-text);
            background: var(--ps-card);
        }

        .ps-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .ps-table tbody tr:hover td {
            background: var(--ps-head);
        }

        .ps-total-row th {
            padding: 17px;
            background: var(--ps-head);
            color: var(--ps-text);
            font-size: 13px;
            border-top: 1px solid var(--ps-border);
        }

        .ps-total-value {
            color: var(--ps-success) !important;
            font-size: 17px !important;
            font-weight: 900 !important;
        }

        .ps-receipt {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
            padding: 20px;
            border: 1px solid var(--ps-border);
            border-radius: 13px;
            background: var(--ps-head);
        }

        .ps-receipt-number {
            font-size: 20px;
            font-weight: 900;
            color: var(--ps-text);
            margin: 4px 0;
        }

        .ps-btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            border: 0;
            border-radius: 10px;
            padding: 11px 17px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: .2s;
            cursor: pointer;
        }

        .ps-btn:hover {
            transform: translateY(-1px);
            filter: brightness(.96);
        }

        .ps-btn-success {
            color: white;
            background: #059669;
        }

        .ps-btn-danger {
            color: white;
            background: #dc2626;
        }

        .ps-btn-secondary {
            color: var(--ps-text);
            background: var(--ps-head);
            border: 1px solid var(--ps-border);
        }

        .ps-cancel-card {
            border: 1px solid rgba(220, 38, 38, .35);
        }

        .ps-cancel-card .ps-card-header {
            background: rgba(220, 38, 38, .07);
            border-bottom-color: rgba(220, 38, 38, .2);
        }

        .ps-cancel-card .ps-card-icon {
            color: var(--ps-danger);
            background: rgba(220, 38, 38, .1);
        }

        .ps-form-label {
            color: var(--ps-text);
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .ps-form-control {
            width: 100%;
            padding: 12px 14px;
            color: var(--ps-text);
            background: var(--ps-card);
            border: 1px solid var(--ps-border);
            border-radius: 10px;
            font-size: 13px;
        }

        .ps-form-control:focus {
            outline: none;
            border-color: var(--ps-primary);
            box-shadow: 0 0 0 3px var(--ps-primary-soft);
        }

        .ps-muted {
            color: var(--ps-muted);
        }

        .ps-alert {
            border-radius: 12px;
            padding: 14px 17px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        /* RESPONSIVE */
        @media(max-width: 768px) {
            .ps-page {
                padding: 12px;
            }

            .ps-hero {
                padding: 21px;
            }

            .ps-hero h2 {
                font-size: 21px;
            }

            .ps-hero-content {
                gap: 16px;
                align-items: flex-start !important;
                flex-direction: column;
            }

            .ps-info-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 17px;
            }

            .ps-card-body {
                padding: 16px;
            }

            .ps-student {
                align-items: flex-start;
            }

            .ps-student-photo {
                width: 68px;
                height: 68px;
            }
        }

        @media(max-width: 480px) {
            .ps-info-grid {
                grid-template-columns: 1fr;
            }

            .ps-student-name {
                font-size: 16px;
            }
        }

        /* THÈME DARK */
        html[data-app-theme="dark"] .ps-page {
            --ps-text: #e2e8f0;
            --ps-muted: #94a3b8;
            --ps-card: #172033;
            --ps-bg: #0f172a;
            --ps-border: #334155;
            --ps-head: #1e293b;
            --ps-primary-soft: rgba(96, 165, 250, .15);
        }

        html[data-app-theme="dark"] .ps-hero {
            background: linear-gradient(120deg, #0f172a, #1e3a8a);
        }

        html[data-app-theme="dark"] .ps-table tbody td {
            color: var(--ps-text);
        }

        html[data-app-theme="dark"] .ps-status-valid {
            color: #6ee7b7;
            background: #064e3b;
        }

        html[data-app-theme="dark"] .ps-status-cancel {
            color: #fca5a5;
            background: #7f1d1d;
        }

        /* THÈME ULTRA PRO */
        html[data-app-theme="ultra-pro"] .ps-page {
            --ps-primary: #818cf8;
            --ps-primary-soft: rgba(129, 140, 248, .13);
            --ps-success: #34d399;
            --ps-text: #e5e7eb;
            --ps-muted: #a1a1aa;
            --ps-card: #171923;
            --ps-bg: #11131c;
            --ps-border: #303443;
            --ps-head: #202331;
        }

        html[data-app-theme="ultra-pro"] .ps-hero {
            background: linear-gradient(120deg, #111827, #312e81, #4338ca);
        }

        html[data-app-theme="ultra-pro"] .ps-table tbody td {
            color: var(--ps-text);
        }

        /* THÈME EMERALD */
        html[data-app-theme="emerald"] .ps-page {
            --ps-primary: #047857;
            --ps-primary-soft: rgba(4, 120, 87, .12);
            --ps-success: #059669;
            --ps-text: #064e3b;
            --ps-muted: #64748b;
            --ps-card: #ffffff;
            --ps-bg: #ecfdf5;
            --ps-border: #bbf7d0;
            --ps-head: #d1fae5;
        }

        html[data-app-theme="emerald"] .ps-hero {
            background: linear-gradient(120deg, #064e3b, #059669, #10b981);
        }

        /* THÈME WARM */
        html[data-app-theme="warm"] .ps-page {
            --ps-primary: #b45309;
            --ps-primary-soft: rgba(180, 83, 9, .12);
            --ps-success: #15803d;
            --ps-text: #422006;
            --ps-muted: #78716c;
            --ps-card: #fffdf8;
            --ps-bg: #fff7ed;
            --ps-border: #fed7aa;
            --ps-head: #ffedd5;
        }

        html[data-app-theme="warm"] .ps-hero {
            background: linear-gradient(120deg, #78350f, #b45309, #d97706);
        }

        /* ALERTES DANS LES THÈMES SOMBRES */
        html[data-app-theme="dark"] .ps-alert,
        html[data-app-theme="ultra-pro"] .ps-alert {
            color: var(--ps-text);
        }

        html[data-app-theme="dark"] .ps-alert.alert-success,
        html[data-app-theme="ultra-pro"] .ps-alert.alert-success {
            background: #064e3b;
            border-color: #047857;
        }

        html[data-app-theme="dark"] .ps-alert.alert-danger,
        html[data-app-theme="ultra-pro"] .ps-alert.alert-danger {
            background: #7f1d1d;
            border-color: #b91c1c;
        }

        html[data-app-theme="dark"] .ps-alert.alert-warning,
        html[data-app-theme="ultra-pro"] .ps-alert.alert-warning {
            background: #78350f;
            border-color: #b45309;
        }
    </style>

    <div class="ps-page">

        {{-- EN-TÊTE --}}
        <div class="ps-hero">
            <div class="ps-hero-content d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2>
                        <i class="bi bi-receipt-cutoff me-2"></i>
                        Détail du paiement
                    </h2>
                    <p>Consultation détaillée de l'encaissement et de son reçu.</p>
                </div>

                <a href="{{ route('frais.paiements.index') }}" class="ps-back">
                    <i class="bi bi-arrow-left"></i>
                    Retour aux paiements
                </a>
            </div>
        </div>

        {{-- CONFIRMATION --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show ps-alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="alert alert-danger ps-alert">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>Une erreur est survenue.</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- INFORMATIONS DU PAIEMENT --}}
        <div class="ps-card">
            <div class="ps-card-header">
                <div class="ps-card-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h5>Informations du paiement</h5>
                    <p>Références et détails de l'encaissement</p>
                </div>
            </div>

            <div class="ps-card-body">
                <div class="ps-info-grid">

                    <div>
                        <span class="ps-info-label">Numéro de paiement</span>
                        <div class="ps-info-value">{{ $paiement->numero_paiement }}</div>
                    </div>

                    <div>
                        <span class="ps-info-label">Date du paiement</span>
                        <div class="ps-info-value">
                            {{ $paiement->date_paiement?->format('d/m/Y') ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <span class="ps-info-label">Statut</span>
                        @if ($estValide)
                            <span class="ps-status ps-status-valid">
                                <i class="bi bi-check-circle-fill"></i> Validé
                            </span>
                        @else
                            <span class="ps-status ps-status-cancel">
                                <i class="bi bi-x-circle-fill"></i> Annulé
                            </span>
                        @endif
                    </div>

                    <div>
                        <span class="ps-info-label">Mode de paiement</span>
                        <div class="ps-info-value">
                            <i class="bi bi-cash me-1"></i> Espèces
                        </div>
                    </div>

                    <div>
                        <span class="ps-info-label">Encaissé par</span>
                        <div class="ps-info-value">
                            {{ $paiement->utilisateur?->name ?? 'Non renseigné' }}
                        </div>
                    </div>

                    <div>
                        <span class="ps-info-label">Montant total</span>
                        <div class="ps-amount">
                            {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ar
                        </div>
                    </div>

                    @if ($paiement->observations)
                        <div style="grid-column: 1 / -1;">
                            <span class="ps-info-label">Observations</span>
                            <div class="ps-info-value" style="font-weight:500;">
                                {{ $paiement->observations }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ÉLÈVE CONCERNÉ --}}
        <div class="ps-card">
            <div class="ps-card-header">
                <div class="ps-card-icon">
                    <i class="bi bi-person-vcard"></i>
                </div>
                <div>
                    <h5>Élève concerné</h5>
                    <p>Identification de l'élève associé à ce paiement</p>
                </div>
            </div>

            <div class="ps-card-body">
                <div class="ps-student">

                    <div class="ps-student-photo">
                        @if ($photoEleve)
                            <img src="{{ $photoEleve }}" alt="Photo de l'élève">
                        @else
                            {{ strtoupper(substr($eleve?->prenom ?? ($eleve?->nom ?? 'E'), 0, 1)) }}
                        @endif
                    </div>

                    <div class="flex-grow-1">
                        <div class="ps-student-name">
                            {{ $eleve?->nom ?? 'Élève inconnu' }}
                            {{ $eleve?->prenom }}
                        </div>

                        <div class="ps-student-meta">
                            <span class="ps-student-tag">
                                <i class="bi bi-upc-scan me-1"></i>
                                {{ $eleve?->matricule ?? 'Matricule non renseigné' }}
                            </span>

                            <span class="ps-student-tag">
                                <i class="bi bi-mortarboard me-1"></i>
                                {{ $eleve?->classe?->nom ?? 'Classe non renseignée' }}
                            </span>

                            @if ($eleve?->numero_classe)
                                <span class="ps-student-tag">
                                    N° {{ $eleve->numero_classe }}
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- DÉTAIL DES FRAIS --}}
        <div class="ps-card">
            <div class="ps-card-header">
                <div class="ps-card-icon">
                    <i class="bi bi-list-check"></i>
                </div>
                <div>
                    <h5>Détail des frais réglés</h5>
                    <p>Répartition du montant encaissé</p>
                </div>
            </div>

            <div class="ps-table-wrap">
                <table class="ps-table">
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th>Période</th>
                            <th class="text-end">Montant payé</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($paiement->details as $detail)
                            <tr>
                                <td class="fw-bold">
                                    {{ $detail->eleveFrais?->libelle ?? 'Frais scolaire' }}
                                </td>

                                <td>
                                    {{ $detail->eleveFrais?->cle_periode ?? '-' }}
                                </td>

                                <td class="text-end fw-bold">
                                    {{ number_format((float) $detail->montant_paye, 0, ',', ' ') }} Ar
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 ps-muted">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    Aucun détail disponible.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot>
                        <tr class="ps-total-row">
                            <th colspan="2">TOTAL PAYÉ</th>
                            <th class="text-end ps-total-value">
                                {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ar
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- REÇU --}}
        <div class="ps-card">
            <div class="ps-card-header">
                <div class="ps-card-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                    <h5>Reçu de paiement</h5>
                    <p>Document justificatif de l'encaissement</p>
                </div>
            </div>

            <div class="ps-card-body">
                @if ($paiement->recu)
                    <div class="ps-receipt">
                        <div>
                            <span class="ps-info-label">Numéro du reçu</span>

                            <div class="ps-receipt-number">
                                {{ $paiement->recu->numero_recu }}
                            </div>

                            <div class="ps-muted" style="font-size:12px;">
                                <i class="bi bi-calendar3 me-1"></i>
                                Émis le :
                                {{ $paiement->recu->date_emission?->format('d/m/Y H:i') ?? '-' }}
                            </div>
                        </div>

                        @if ($estValide && auth()->user()->aPermission('frais.recus_imprimer'))
                            <a href="{{ route('frais.recus.imprimer', $paiement->recu) }}" class="ps-btn ps-btn-success">
                                <i class="bi bi-printer-fill"></i>
                                Afficher le reçu
                            </a>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning ps-alert mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Aucun reçu n'est associé à ce paiement.
                    </div>
                @endif
            </div>
        </div>

        {{-- HISTORIQUE D'ANNULATION --}}
        @if (!$estValide && $paiement->annulation)
            <div class="ps-card">
                <div class="ps-card-header">
                    <div class="ps-card-icon" style="color:#dc2626;background:rgba(220,38,38,.1);">
                        <i class="bi bi-shield-exclamation"></i>
                    </div>

                    <div>
                        <h5>Paiement annulé</h5>
                        <p>Informations relatives à l'annulation</p>
                    </div>
                </div>

                <div class="ps-card-body">
                    <div class="ps-info-grid">

                        <div>
                            <span class="ps-info-label">Motif de l'annulation</span>
                            <div class="ps-info-value">
                                {{ $paiement->annulation->motif }}
                            </div>
                        </div>

                        <div>
                            <span class="ps-info-label">Date d'annulation</span>
                            <div class="ps-info-value">
                                {{ $paiement->annulation->date_annulation?->format('d/m/Y H:i') ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <span class="ps-info-label">Annulé par</span>
                            <div class="ps-info-value">
                                {{ $paiement->annulation->utilisateur?->name ?? 'Non renseigné' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        {{-- ANNULATION --}}
        @if ($estValide && auth()->user()->aPermission('frais.paiements_annuler'))
            <div class="ps-card ps-cancel-card">

                <div class="ps-card-header">
                    <div class="ps-card-icon">
                        <i class="bi bi-exclamation-octagon"></i>
                    </div>

                    <div>
                        <h5>Annuler ce paiement</h5>
                        <p>Cette opération nécessite un motif obligatoire</p>
                    </div>
                </div>

                <div class="ps-card-body">

                    <div class="alert alert-warning ps-alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        L'annulation sera enregistrée dans l'historique.
                        Le paiement ne sera pas supprimé définitivement.
                    </div>

                    <form method="POST" action="{{ route('frais.paiements.annuler', $paiement) }}"
                        onsubmit="return confirm('Confirmer l’annulation de ce paiement ? Cette opération ne peut pas être annulée automatiquement.')">

                        @csrf

                        <div class="mb-3">
                            <label for="motif" class="ps-form-label">
                                Motif obligatoire de l'annulation
                            </label>

                            <textarea name="motif" id="motif" class="ps-form-control" rows="4" required maxlength="1000"
                                placeholder="Expliquez précisément la raison de l'annulation...">{{ old('motif') }}</textarea>

                            @error('motif')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="ps-btn ps-btn-danger">
                            <i class="bi bi-x-circle-fill"></i>
                            Confirmer l'annulation
                        </button>

                    </form>
                </div>
            </div>
        @endif

    </div>

@endsection
