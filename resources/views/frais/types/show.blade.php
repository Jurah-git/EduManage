@extends('layouts.app')

@section('content')
    @php
        $frequences = [
            'unique' => 'Unique',
            'mensuelle' => 'Mensuelle',
            'trimestrielle' => 'Trimestrielle',
            'annuelle' => 'Annuelle',
        ];

        $frequenceLabel = $frequences[$type->frequence] ?? ucfirst($type->frequence);

        $nombreTarifs = $type->tarifs->count();
        $tarifsActifs = $type->tarifs->where('actif', true)->count();
        $tarifsInactifs = $type->tarifs->where('actif', false)->count();
    @endphp

    <div class="types-show-page">

        {{-- EN-TÊTE --}}
        <div class="types-show-hero">
            <div class="types-show-hero-content">

                <div class="types-show-breadcrumb">
                    <a href="{{ route('frais.types.index') }}">
                        Gestion des frais
                    </a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Détail du type</span>
                </div>

                <div class="types-show-heading">
                    <div class="types-show-icon">
                        <i class="bi bi-tags-fill"></i>
                    </div>

                    <div>
                        <h2>Détail du type de frais</h2>
                        <p>
                            Consultation des informations et des tarifs scolaires associés.
                        </p>
                    </div>
                </div>
            </div>

            <div class="types-show-hero-actions">
                @if (auth()->user()->aPermission('frais.types_modifier'))
                    <a href="{{ route('frais.types.edit', $type->id) }}" class="types-show-btn types-show-btn-primary">
                        <i class="bi bi-pencil-square"></i>
                        Modifier
                    </a>
                @endif

                <a href="{{ route('frais.types.index') }}" class="types-show-btn types-show-btn-light">
                    <i class="bi bi-arrow-left"></i>
                    Retour
                </a>
            </div>
        </div>

        {{-- INFORMATIONS GÉNÉRALES --}}
        <div class="types-show-section-title">
            <div>
                <h4>Informations générales</h4>
                <p>Les caractéristiques de ce type de frais.</p>
            </div>
        </div>

        <div class="types-show-info-card">

            <div class="types-show-info-top">
                <div class="types-show-info-icon">
                    <i class="bi bi-receipt"></i>
                </div>

                <div class="types-show-info-name">
                    <span>Nom du type de frais</span>
                    <h3>{{ $type->nom }}</h3>
                </div>

                <div class="types-show-status">
                    @if ($type->actif)
                        <span class="types-show-badge active">
                            <i class="bi bi-check-circle-fill"></i>
                            Actif
                        </span>
                    @else
                        <span class="types-show-badge inactive">
                            <i class="bi bi-x-circle-fill"></i>
                            Inactif
                        </span>
                    @endif
                </div>
            </div>

            <div class="types-show-info-grid">

                <div class="types-show-info-item">
                    <div class="types-show-item-icon purple">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <span>Fréquence</span>
                        <strong>{{ $frequenceLabel }}</strong>
                    </div>
                </div>

                <div class="types-show-info-item">
                    <div class="types-show-item-icon blue">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <span>Nombre de tarifs</span>
                        <strong>{{ $nombreTarifs }} tarif(s)</strong>
                    </div>
                </div>

                <div class="types-show-info-item">
                    <div class="types-show-item-icon green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <span>Tarifs actifs</span>
                        <strong>{{ $tarifsActifs }}</strong>
                    </div>
                </div>

                <div class="types-show-info-item">
                    <div class="types-show-item-icon orange">
                        <i class="bi bi-pause-circle"></i>
                    </div>
                    <div>
                        <span>Tarifs inactifs</span>
                        <strong>{{ $tarifsInactifs }}</strong>
                    </div>
                </div>

            </div>

            <div class="types-show-description">
                <div class="types-show-description-title">
                    <i class="bi bi-card-text"></i>
                    Description
                </div>

                <p>
                    {{ $type->description ?: 'Aucune description renseignée pour ce type de frais.' }}
                </p>
            </div>

        </div>

        {{-- STATISTIQUES DES TARIFS --}}
        <div class="types-show-stats">

            <div class="types-show-stat-card">
                <div class="types-show-stat-icon blue">
                    <i class="bi bi-list-ul"></i>
                </div>
                <div>
                    <span>Total des tarifs</span>
                    <strong>{{ $nombreTarifs }}</strong>
                </div>
            </div>

            <div class="types-show-stat-card">
                <div class="types-show-stat-icon green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <span>Tarifs actifs</span>
                    <strong>{{ $tarifsActifs }}</strong>
                </div>
            </div>

            <div class="types-show-stat-card">
                <div class="types-show-stat-icon orange">
                    <i class="bi bi-pause-circle-fill"></i>
                </div>
                <div>
                    <span>Tarifs inactifs</span>
                    <strong>{{ $tarifsInactifs }}</strong>
                </div>
            </div>

        </div>

        {{-- TARIFS SCOLAIRES --}}
        <div class="types-show-section-title types-show-tarifs-heading">
            <div>
                <h4>Tarifs scolaires associés</h4>
                <p>Liste des tarifs configurés pour ce type de frais.</p>
            </div>
        </div>

        <div class="types-show-table-card">

            <div class="types-show-table-header">
                <div class="types-show-table-header-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div>
                    <h5>Historique des tarifs</h5>
                    <span>{{ $nombreTarifs }} tarif(s) enregistré(s)</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table types-show-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Année scolaire</th>
                            <th>Classe</th>
                            <th>Montant</th>
                            <th>Période de validité</th>
                            <th>Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($type->tarifs as $tarif)
                            <tr>
                                <td>
                                    <div class="types-show-cell-main">
                                        <div class="types-show-cell-icon blue">
                                            <i class="bi bi-calendar3"></i>
                                        </div>
                                        <strong>
                                            {{ data_get($tarif, 'anneeScolaire.nom') ?? '—' }}
                                        </strong>
                                    </div>
                                </td>

                                <td>
                                    <span class="types-show-class">
                                        <i class="bi bi-mortarboard"></i>
                                        {{ data_get($tarif, 'classe.nom') ?? '—' }}
                                    </span>
                                </td>

                                <td>
                                    <strong class="types-show-amount">
                                        {{ number_format((float) $tarif->montant, 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </strong>
                                </td>

                                <td>
                                    <div class="types-show-period">
                                        <span>
                                            <i class="bi bi-calendar-event"></i>
                                            {{ $tarif->date_debut ? \Carbon\Carbon::parse($tarif->date_debut)->format('d/m/Y') : '—' }}
                                        </span>

                                        <span class="types-show-period-separator">au</span>

                                        <span>
                                            <i class="bi bi-calendar-check"></i>
                                            {{ $tarif->date_fin ? \Carbon\Carbon::parse($tarif->date_fin)->format('d/m/Y') : '—' }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    @if ($tarif->actif)
                                        <span class="types-show-badge active">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Actif
                                        </span>
                                    @else
                                        <span class="types-show-badge inactive">
                                            <i class="bi bi-pause-circle-fill"></i>
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="types-show-empty">
                                        <div class="types-show-empty-icon">
                                            <i class="bi bi-inbox"></i>
                                        </div>
                                        <strong>Aucun tarif scolaire associé</strong>
                                        <p>
                                            Aucun tarif n'a encore été configuré pour ce type de frais.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="types-show-table-footer">
                <span>
                    <i class="bi bi-info-circle"></i>
                    Les montants sont exprimés en Ariary (Ar).
                </span>

                <a href="{{ route('frais.tarifs.index') }}" class="types-show-footer-link">
                    Consulter les tarifs
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>

    </div>

    <style>
        /* =====================================================
       TYPES DE FRAIS - PAGE SHOW
    ===================================================== */

        .types-show-page {
            --ts-bg: #f5f7fb;
            --ts-card: #ffffff;
            --ts-text: #253247;
            --ts-muted: #748094;
            --ts-border: #e5eaf1;
            --ts-primary: #4f46e5;
            --ts-primary-soft: #eef0ff;
            --ts-shadow: 0 8px 28px rgba(28, 39, 60, .055);

            color: var(--ts-text);
            padding: 22px;
            min-height: 100%;
        }

        /* Thème sombre */
        html[data-app-theme="dark"] .types-show-page {
            --ts-bg: #151b28;
            --ts-card: #202a3a;
            --ts-text: #e7edf7;
            --ts-muted: #a5b1c3;
            --ts-border: #354257;
            --ts-primary: #9b9aff;
            --ts-primary-soft: #34334f;
            --ts-shadow: 0 8px 28px rgba(0, 0, 0, .18);
        }

        /* Ultra Pro */
        html[data-app-theme="ultra-pro"] .types-show-page {
            --ts-bg: #101827;
            --ts-card: #192538;
            --ts-text: #edf4ff;
            --ts-muted: #a8b8ce;
            --ts-border: #34445c;
            --ts-primary: #60a5fa;
            --ts-primary-soft: #263d5b;
            --ts-shadow: 0 8px 28px rgba(0, 0, 0, .2);
        }

        /* Emerald */
        html[data-app-theme="emerald"] .types-show-page {
            --ts-bg: #f0f8f4;
            --ts-card: #ffffff;
            --ts-text: #174b37;
            --ts-muted: #668878;
            --ts-border: #d5e9de;
            --ts-primary: #059669;
            --ts-primary-soft: #e2f5eb;
            --ts-shadow: 0 8px 28px rgba(16, 100, 65, .06);
        }

        /* Warm */
        html[data-app-theme="warm"] .types-show-page {
            --ts-bg: #fbf5ee;
            --ts-card: #fffdf9;
            --ts-text: #55402e;
            --ts-muted: #927d69;
            --ts-border: #eadfd1;
            --ts-primary: #c17b42;
            --ts-primary-soft: #f8ebdc;
            --ts-shadow: 0 8px 28px rgba(120, 75, 35, .06);
        }

        /* HERO */
        .types-show-hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 28px 30px;
            border-radius: 18px;
            color: #fff;
            background: linear-gradient(120deg, #3730a3, #6366f1 60%, #818cf8);
            box-shadow: 0 12px 30px rgba(79, 70, 229, .18);
            margin-bottom: 30px;
        }

        .types-show-breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 12px;
            color: rgba(255, 255, 255, .75);
            margin-bottom: 18px;
        }

        .types-show-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .types-show-breadcrumb a:hover {
            text-decoration: underline;
        }

        .types-show-heading {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .types-show-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: rgba(255, 255, 255, .17);
            font-size: 25px;
        }

        .types-show-heading h2 {
            font-size: 23px;
            font-weight: 800;
            margin: 0 0 5px;
            color: #fff;
        }

        .types-show-heading p {
            margin: 0;
            font-size: 13px;
            color: rgba(255, 255, 255, .8);
        }

        .types-show-hero-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .types-show-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: .2s ease;
        }

        .types-show-btn:hover {
            transform: translateY(-2px);
        }

        .types-show-btn-primary {
            color: #3730a3;
            background: #fff;
        }

        .types-show-btn-primary:hover {
            color: #312e81;
            background: #eef0ff;
        }

        .types-show-btn-light {
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .4);
            background: rgba(255, 255, 255, .12);
        }

        .types-show-btn-light:hover {
            color: #fff;
            background: rgba(255, 255, 255, .22);
        }

        /* TITRES */
        .types-show-section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 0 15px;
        }

        .types-show-section-title h4 {
            color: var(--ts-text);
            font-size: 17px;
            font-weight: 800;
            margin: 0 0 4px;
        }

        .types-show-section-title p {
            color: var(--ts-muted);
            font-size: 12px;
            margin: 0;
        }

        /* INFORMATIONS */
        .types-show-info-card,
        .types-show-stat-card,
        .types-show-table-card {
            background: var(--ts-card);
            border: 1px solid var(--ts-border);
            border-radius: 15px;
            box-shadow: var(--ts-shadow);
        }

        .types-show-info-card {
            padding: 23px;
            margin-bottom: 22px;
        }

        .types-show-info-top {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--ts-border);
        }

        .types-show-info-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ts-primary);
            background: var(--ts-primary-soft);
            border-radius: 14px;
            font-size: 22px;
        }

        .types-show-info-name {
            flex: 1;
            min-width: 0;
        }

        .types-show-info-name span,
        .types-show-info-item span {
            display: block;
            color: var(--ts-muted);
            font-size: 12px;
            margin-bottom: 5px;
        }

        .types-show-info-name h3 {
            color: var(--ts-text);
            font-size: 19px;
            font-weight: 800;
            margin: 0;
            overflow-wrap: anywhere;
        }

        .types-show-status {
            margin-left: auto;
        }

        .types-show-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 11px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .types-show-badge.active {
            color: #15803d;
            background: #dcfce7;
        }

        .types-show-badge.inactive {
            color: #64748b;
            background: #e2e8f0;
        }

        .types-show-info-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            padding: 23px 0;
        }

        .types-show-info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .types-show-item-icon,
        .types-show-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 12px;
        }

        .types-show-item-icon {
            width: 42px;
            height: 42px;
            font-size: 17px;
        }

        .types-show-item-icon.purple {
            color: #7c3aed;
            background: #f1eafe;
        }

        .types-show-item-icon.blue,
        .types-show-stat-icon.blue {
            color: #2563eb;
            background: #dbeafe;
        }

        .types-show-item-icon.green,
        .types-show-stat-icon.green {
            color: #15803d;
            background: #dcfce7;
        }

        .types-show-item-icon.orange,
        .types-show-stat-icon.orange {
            color: #c2410c;
            background: #ffedd5;
        }

        .types-show-info-item strong {
            display: block;
            color: var(--ts-text);
            font-size: 14px;
            font-weight: 800;
        }

        .types-show-description {
            padding: 16px;
            border-radius: 11px;
            background: var(--ts-bg);
            border: 1px solid var(--ts-border);
        }

        .types-show-description-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--ts-text);
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .types-show-description-title i {
            color: var(--ts-primary);
            font-size: 15px;
        }

        .types-show-description p {
            color: var(--ts-muted);
            font-size: 13px;
            line-height: 1.7;
            margin: 0;
            white-space: pre-line;
        }

        /* STATISTIQUES */
        .types-show-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .types-show-stat-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px;
        }

        .types-show-stat-icon {
            width: 45px;
            height: 45px;
            font-size: 19px;
        }

        .types-show-stat-card span {
            display: block;
            color: var(--ts-muted);
            font-size: 12px;
            margin-bottom: 4px;
        }

        .types-show-stat-card strong {
            display: block;
            color: var(--ts-text);
            font-size: 22px;
            font-weight: 800;
        }

        /* TABLEAU */
        .types-show-tarifs-heading {
            margin-top: 5px;
        }

        .types-show-table-card {
            overflow: hidden;
        }

        .types-show-table-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 22px;
            border-bottom: 1px solid var(--ts-border);
        }

        .types-show-table-header-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            color: var(--ts-primary);
            background: var(--ts-primary-soft);
            font-size: 18px;
        }

        .types-show-table-header h5 {
            color: var(--ts-text);
            font-size: 14px;
            font-weight: 800;
            margin: 0 0 3px;
        }

        .types-show-table-header span {
            color: var(--ts-muted);
            font-size: 11px;
        }

        .types-show-table {
            color: var(--ts-text);
            background: var(--ts-card);
        }

        .types-show-table thead th {
            padding: 14px 18px;
            color: var(--ts-muted);
            background: var(--ts-bg);
            border-bottom: 1px solid var(--ts-border);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .types-show-table tbody td {
            padding: 15px 18px;
            color: var(--ts-text);
            background: var(--ts-card);
            border-bottom: 1px solid var(--ts-border);
            font-size: 13px;
        }

        .types-show-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .types-show-table tbody tr:hover td {
            background: var(--ts-bg);
        }

        .types-show-cell-main {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .types-show-cell-main strong {
            font-size: 13px;
            font-weight: 700;
        }

        .types-show-cell-icon {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 9px;
        }

        .types-show-class {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--ts-text);
            font-weight: 600;
        }

        .types-show-class i {
            color: var(--ts-primary);
        }

        .types-show-amount {
            color: var(--ts-text);
            font-weight: 800;
            white-space: nowrap;
        }

        .types-show-amount small {
            color: var(--ts-muted);
            font-size: 11px;
            font-weight: 600;
        }

        .types-show-period {
            display: flex;
            flex-direction: column;
            gap: 5px;
            color: var(--ts-muted);
            font-size: 12px;
            white-space: nowrap;
        }

        .types-show-period span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .types-show-period i {
            color: var(--ts-primary);
        }

        .types-show-period-separator {
            padding-left: 17px;
            font-size: 10px;
        }

        .types-show-empty {
            padding: 42px 15px;
            text-align: center;
        }

        .types-show-empty-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            border-radius: 15px;
            color: var(--ts-muted);
            background: var(--ts-bg);
            font-size: 25px;
        }

        .types-show-empty strong {
            display: block;
            color: var(--ts-text);
            font-size: 14px;
            margin-bottom: 5px;
        }

        .types-show-empty p {
            color: var(--ts-muted);
            font-size: 12px;
            margin: 0;
        }

        .types-show-table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-top: 1px solid var(--ts-border);
            background: var(--ts-bg);
        }

        .types-show-table-footer>span {
            color: var(--ts-muted);
            font-size: 11px;
        }

        .types-show-table-footer>span i {
            margin-right: 5px;
        }

        .types-show-footer-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--ts-primary);
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .types-show-footer-link:hover {
            text-decoration: underline;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .types-show-info-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .types-show-page {
                padding: 12px;
            }

            .types-show-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 22px;
            }

            .types-show-hero-actions {
                width: 100%;
            }

            .types-show-hero-actions .types-show-btn {
                flex: 1;
            }

            .types-show-heading h2 {
                font-size: 19px;
            }

            .types-show-info-card {
                padding: 17px;
            }

            .types-show-stats {
                grid-template-columns: 1fr;
            }

            .types-show-table-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .types-show-info-top {
                flex-wrap: wrap;
            }

            .types-show-status {
                width: 100%;
                margin-left: 67px;
            }

            .types-show-info-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .types-show-heading {
                align-items: flex-start;
            }

            .types-show-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
        }
    </style>
@endsection
