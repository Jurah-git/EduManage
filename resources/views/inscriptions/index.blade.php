@extends('layouts.app')

@section('content')
    <style>
        /* =========================================================
               INSCRIPTIONS — ULTRA PRO
            ========================================================= */

        .ins-page {
            --ins-bg: #f4f7fc;
            --ins-card: #ffffff;
            --ins-soft: #f8fafc;
            --ins-border: #e5eaf2;
            --ins-text: #475569;
            --ins-heading: #1e293b;
            --ins-muted: #94a3b8;
            --ins-primary: #2563eb;
            --ins-primary-soft: #eff6ff;
            --ins-hover: #f5f9ff;
            --ins-shadow: 0 4px 18px rgba(15, 23, 42, .045);

            background: var(--ins-bg);
            color: var(--ins-text);
            min-height: 100vh;
            padding: 26px;
            border-radius: 18px;
            transition: background .25s, color .25s;
        }

        /* HEADER */
        .ins-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 26px;
        }

        .ins-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .ins-header-icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 17px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1d4ed8;
            font-size: 26px;
            flex-shrink: 0;
            box-shadow: 0 5px 15px rgba(37, 99, 235, .08);
        }

        .ins-header h2 {
            font-size: 27px;
            font-weight: 850;
            color: var(--ins-heading);
            margin: 0 0 5px;
            letter-spacing: -.5px;
        }

        .ins-header p {
            color: var(--ins-muted);
            margin: 0;
            font-size: 13px;
        }

        .ins-btn-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 12px 19px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff !important;
            text-decoration: none !important;
            font-weight: 750;
            font-size: 13px;
            border: none;
            box-shadow: 0 5px 15px rgba(37, 99, 235, .20);
            transition: all .2s;
        }

        .ins-btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(37, 99, 235, .27);
        }

        /* STATISTICS */
        .ins-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 24px;
        }

        .ins-stat-card {
            position: relative;
            overflow: hidden;
            background: var(--ins-card);
            border: 1px solid var(--ins-border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: var(--ins-shadow);
            transition: all .22s ease;
        }

        .ins-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 25px rgba(15, 23, 42, .08);
        }

        .ins-stat-card::after {
            content: "";
            position: absolute;
            right: -22px;
            bottom: -28px;
            width: 85px;
            height: 85px;
            border-radius: 50%;
            background: currentColor;
            opacity: .035;
        }

        .ins-stat-icon {
            width: 53px;
            height: 53px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .ins-stat-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .ins-stat-green {
            background: #ecfdf5;
            color: #059669;
        }

        .ins-stat-orange {
            background: #fff7ed;
            color: #ea580c;
        }

        .ins-stat-purple {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .ins-stat-info {
            min-width: 0;
        }

        .ins-stat-info span {
            display: block;
            font-size: 11px;
            color: var(--ins-muted);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .ins-stat-info h3 {
            margin: 0;
            font-size: 23px;
            font-weight: 850;
            color: var(--ins-heading);
            overflow-wrap: anywhere;
        }

        .ins-stat-info h3.ins-stat-money {
            font-size: 19px;
        }

        /* ALERTS */
        .ins-alert {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* FILTER CARD */
        .ins-filter-card {
            background: var(--ins-card);
            border: 1px solid var(--ins-border);
            border-radius: 16px;
            padding: 21px;
            margin-bottom: 22px;
            box-shadow: var(--ins-shadow);
        }

        .ins-filter-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 850;
            margin-bottom: 18px;
            color: var(--ins-heading);
        }

        .ins-filter-title-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--ins-primary-soft);
            color: var(--ins-primary);
        }

        .ins-filter-grid {
            display: grid;
            grid-template-columns: 2fr 1.15fr 1.1fr 1.1fr auto;
            gap: 12px;
            align-items: end;
        }

        .ins-form-group label {
            display: block;
            font-size: 11px;
            font-weight: 750;
            color: var(--ins-muted);
            margin-bottom: 7px;
        }

        .ins-form-control {
            width: 100%;
            height: 43px;
            border: 1px solid var(--ins-border);
            border-radius: 10px;
            padding: 0 12px;
            background: var(--ins-card);
            color: var(--ins-text);
            font-size: 12px;
            outline: none;
            transition: .2s;
        }

        .ins-form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
        }

        .ins-form-control::placeholder {
            color: var(--ins-muted);
        }

        .ins-filter-actions {
            display: flex;
            gap: 8px;
        }

        .ins-btn-filter {
            height: 43px;
            padding: 0 17px;
            border: none;
            border-radius: 10px;
            background: #1e293b;
            color: white;
            font-weight: 750;
            font-size: 12px;
            cursor: pointer;
            transition: .2s;
            white-space: nowrap;
        }

        .ins-btn-filter:hover {
            background: #334155;
            transform: translateY(-1px);
        }

        .ins-btn-reset {
            height: 43px;
            width: 43px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            border: 1px solid var(--ins-border);
            color: var(--ins-muted);
            text-decoration: none;
            background: var(--ins-card);
            transition: .2s;
        }

        .ins-btn-reset:hover {
            color: #ef4444;
            border-color: #ef4444;
            background: rgba(239, 68, 68, .06);
        }

        /* TABLE CARD */
        .ins-table-card {
            background: var(--ins-card);
            border: 1px solid var(--ins-border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--ins-shadow);
        }

        .ins-table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 22px;
            flex-wrap: wrap;
            gap: 12px;
            border-bottom: 1px solid var(--ins-border);
        }

        .ins-table-header h5 {
            font-size: 15px;
            font-weight: 850;
            margin: 0;
            color: var(--ins-heading);
        }

        .ins-table-header p {
            margin: 5px 0 0;
            font-size: 11px;
            color: var(--ins-muted);
        }

        .ins-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--ins-primary-soft);
            color: var(--ins-primary);
            padding: 8px 13px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 850;
            white-space: nowrap;
        }

        .ins-table-scroll {
            max-height: 560px;
            overflow: auto;
        }

        .ins-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 1050px;
        }

        .ins-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--ins-soft);
            padding: 13px 15px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .55px;
            font-weight: 850;
            color: var(--ins-muted);
            border-bottom: 1px solid var(--ins-border);
            white-space: nowrap;
        }

        .ins-table tbody td {
            padding: 13px 15px;
            border-bottom: 1px solid var(--ins-border);
            vertical-align: middle;
            font-size: 12px;
            color: var(--ins-text);
        }

        .ins-table tbody tr {
            transition: background .15s;
        }

        .ins-table tbody tr:hover {
            background: var(--ins-hover);
        }

        .ins-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* STUDENT */
        .ins-student {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 200px;
        }

        .ins-student-photo {
            width: 43px;
            height: 43px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--ins-border);
            flex-shrink: 0;
            background: var(--ins-soft);
        }

        .ins-student-name {
            font-weight: 850;
            color: var(--ins-heading);
            font-size: 12px;
        }

        .ins-student-matricule {
            display: block;
            font-size: 10px;
            color: var(--ins-muted);
            margin-top: 4px;
        }

        /* CLASS */
        .ins-class-badge {
            display: inline-flex;
            align-items: center;
            background: var(--ins-soft);
            border: 1px solid var(--ins-border);
            color: var(--ins-text);
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 750;
            white-space: nowrap;
        }

        /* SCHOOL YEAR */
        .ins-year {
            font-weight: 750;
            color: var(--ins-text);
            white-space: nowrap;
        }

        /* TYPE */
        .ins-type {
            display: inline-flex;
            align-items: center;
            font-size: 11px;
            font-weight: 750;
            color: var(--ins-text);
            white-space: nowrap;
        }

        /* STATUS */
        .ins-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 850;
            white-space: nowrap;
        }

        .ins-status-attente {
            background: #fff7ed;
            color: #c2410c;
        }

        .ins-status-validee {
            background: #ecfdf5;
            color: #047857;
        }

        .ins-status-annulee {
            background: #fef2f2;
            color: #dc2626;
        }

        /* MONEY */
        .ins-money {
            font-weight: 850;
            color: var(--ins-heading);
            white-space: nowrap;
        }

        /* ACTIONS */
        .ins-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ins-action-btn {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--ins-border);
            background: var(--ins-card);
            text-decoration: none;
            cursor: pointer;
            transition: all .16s;
            font-size: 13px;
        }

        .ins-action-view {
            color: #2563eb;
        }

        .ins-action-view:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
            transform: translateY(-1px);
        }

        .ins-action-edit {
            color: #d97706;
        }

        .ins-action-edit:hover {
            background: #fffbeb;
            border-color: #fde68a;
            transform: translateY(-1px);
        }

        .ins-action-delete {
            color: #dc2626;
        }

        .ins-action-delete:hover {
            background: #fef2f2;
            border-color: #fecaca;
            transform: translateY(-1px);
        }

        /* EMPTY STATE */
        .ins-empty {
            padding: 65px 20px !important;
            text-align: center;
        }

        .ins-empty-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 15px;
            border-radius: 22px;
            background: var(--ins-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .ins-empty h5 {
            font-weight: 850;
            color: var(--ins-heading);
            margin-bottom: 8px;
        }

        .ins-empty p {
            color: var(--ins-muted);
            font-size: 12px;
            margin-bottom: 20px;
        }

        /* PAGINATION */
        .ins-pagination {
            padding: 17px 22px;
            border-top: 1px solid var(--ins-border);
            background: var(--ins-card);
        }

        .ins-pagination nav {
            display: flex;
            justify-content: flex-end;
        }

        .ins-pagination .pagination {
            margin-bottom: 0;
        }

        .ins-pagination .page-link {
            background: var(--ins-card);
            border-color: var(--ins-border);
            color: var(--ins-text);
        }

        .ins-pagination .page-item.active .page-link {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
        }

        /* =========================================================
               DARK MODE
            ========================================================= */

        html[data-app-theme="dark"] .ins-page {
            --ins-bg: #0f172a;
            --ins-card: #182338;
            --ins-soft: #202d43;
            --ins-border: #2b3a52;
            --ins-text: #cbd5e1;
            --ins-heading: #f1f5f9;
            --ins-muted: #94a3b8;
            --ins-primary: #60a5fa;
            --ins-primary-soft: rgba(59, 130, 246, .15);
            --ins-hover: #1e2c42;
            --ins-shadow: 0 4px 18px rgba(0, 0, 0, .12);
        }

        html[data-app-theme="dark"] .ins-header-icon {
            background: rgba(59, 130, 246, .15);
            color: #60a5fa;
        }

        html[data-app-theme="dark"] .ins-stat-blue {
            background: rgba(59, 130, 246, .15);
            color: #60a5fa;
        }

        html[data-app-theme="dark"] .ins-stat-green {
            background: rgba(16, 185, 129, .13);
            color: #34d399;
        }

        html[data-app-theme="dark"] .ins-stat-orange {
            background: rgba(249, 115, 22, .13);
            color: #fb923c;
        }

        html[data-app-theme="dark"] .ins-stat-purple {
            background: rgba(139, 92, 246, .15);
            color: #a78bfa;
        }

        html[data-app-theme="dark"] .ins-btn-filter {
            background: #334155;
            color: #f8fafc;
        }

        html[data-app-theme="dark"] .ins-btn-filter:hover {
            background: #475569;
        }

        html[data-app-theme="dark"] .ins-status-attente {
            background: rgba(249, 115, 22, .14);
            color: #fb923c;
        }

        html[data-app-theme="dark"] .ins-status-validee {
            background: rgba(16, 185, 129, .13);
            color: #34d399;
        }

        html[data-app-theme="dark"] .ins-status-annulee {
            background: rgba(239, 68, 68, .13);
            color: #f87171;
        }

        html[data-app-theme="dark"] .ins-action-view:hover {
            background: rgba(59, 130, 246, .15);
            border-color: #3b82f6;
        }

        html[data-app-theme="dark"] .ins-action-edit:hover {
            background: rgba(245, 158, 11, .12);
            border-color: #d97706;
        }

        html[data-app-theme="dark"] .ins-action-delete:hover {
            background: rgba(239, 68, 68, .12);
            border-color: #dc2626;
        }

        html[data-app-theme="dark"] .ins-alert.alert-success {
            background: rgba(16, 185, 129, .12);
            color: #34d399;
        }

        html[data-app-theme="dark"] .ins-alert.alert-danger {
            background: rgba(239, 68, 68, .12);
            color: #f87171;
        }

        /* =========================================================
               RESPONSIVE
            ========================================================= */

        @media (max-width: 1250px) {
            .ins-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ins-filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ins-filter-actions {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .ins-page {
                padding: 16px;
                border-radius: 12px;
            }

            .ins-header {
                align-items: flex-start;
            }

            .ins-header h2 {
                font-size: 22px;
            }

            .ins-header-icon {
                width: 48px;
                height: 48px;
                font-size: 21px;
                border-radius: 14px;
            }

            .ins-btn-add {
                padding: 11px 15px;
            }

            .ins-filter-card {
                padding: 16px;
            }

            .ins-table-header {
                padding: 17px;
            }
        }

        @media (max-width: 520px) {
            .ins-page {
                padding: 12px;
            }

            .ins-header {
                gap: 13px;
            }

            .ins-header-left {
                gap: 11px;
            }

            .ins-header h2 {
                font-size: 19px;
            }

            .ins-header p {
                font-size: 11px;
                line-height: 1.6;
            }

            .ins-header .ins-btn-add {
                width: 100%;
            }

            .ins-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .ins-stat-card {
                padding: 13px;
                gap: 10px;
                border-radius: 13px;
            }

            .ins-stat-icon {
                width: 39px;
                height: 39px;
                font-size: 17px;
                border-radius: 11px;
            }

            .ins-stat-info span {
                font-size: 10px;
            }

            .ins-stat-info h3 {
                font-size: 20px;
            }

            .ins-stat-info h3.ins-stat-money {
                font-size: 15px;
            }

            .ins-filter-grid {
                grid-template-columns: 1fr;
            }

            .ins-filter-actions {
                grid-column: auto;
            }

            .ins-btn-filter {
                flex: 1;
            }

            .ins-table-header {
                align-items: flex-start;
            }

            .ins-empty {
                padding: 45px 15px !important;
            }

            .ins-pagination {
                padding: 12px;
                overflow-x: auto;
            }
        }
    </style>

    <div class="ins-page">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <div class="ins-header">

            <div class="ins-header-left">
                <div class="ins-header-icon">
                    <i class="bi bi-person-vcard"></i>
                </div>

                <div>
                    <h2>Gestion des inscriptions</h2>

                    <p>
                        Gérez les inscriptions, réinscriptions et dossiers administratifs des élèves.
                    </p>
                </div>
            </div>

            <a href="{{ route('inscriptions.create') }}" class="ins-btn-add">
                <i class="bi bi-plus-circle"></i>
                Nouvelle inscription
            </a>

        </div>

        {{-- =====================================================
             ALERTES
        ====================================================== --}}
        @if (session('success'))
            <div class="alert alert-success ins-alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger ins-alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- =====================================================
             STATISTIQUES
        ====================================================== --}}
        <div class="ins-stats">

            {{-- TOTAL --}}
            <div class="ins-stat-card">
                <div class="ins-stat-icon ins-stat-blue">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>

                <div class="ins-stat-info">
                    <span>Total des inscriptions</span>
                    <h3>{{ $inscriptions->total() }}</h3>
                </div>
            </div>

            {{-- VALIDÉES --}}
            <div class="ins-stat-card">
                <div class="ins-stat-icon ins-stat-green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div class="ins-stat-info">
                    <span>Validées (page)</span>
                    <h3>
                        {{ $inscriptions->getCollection()->where('statut', 'validee')->count() }}
                    </h3>
                </div>
            </div>

            {{-- EN ATTENTE --}}
            <div class="ins-stat-card">
                <div class="ins-stat-icon ins-stat-orange">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div class="ins-stat-info">
                    <span>En attente (page)</span>
                    <h3>
                        {{ $inscriptions->getCollection()->where('statut', 'en_attente')->count() }}
                    </h3>
                </div>
            </div>

            {{-- FRAIS --}}
            <div class="ins-stat-card">
                <div class="ins-stat-icon ins-stat-purple">
                    <i class="bi bi-wallet2"></i>
                </div>

                <div class="ins-stat-info">
                    <span>Frais affichés (page)</span>
                    <h3 class="ins-stat-money">
                        {{ number_format($inscriptions->getCollection()->sum('frais_inscription'), 0, ',', ' ') }}
                        <small style="font-size:12px;">Ar</small>
                    </h3>
                </div>
            </div>

        </div>

        {{-- =====================================================
             FILTRES
        ====================================================== --}}
        <div class="ins-filter-card">

            <div class="ins-filter-title">
                <span class="ins-filter-title-icon">
                    <i class="bi bi-funnel-fill"></i>
                </span>

                Recherche et filtres
            </div>

            <form method="GET" action="{{ route('inscriptions.index') }}">

                <div class="ins-filter-grid">

                    {{-- RECHERCHE --}}
                    <div class="ins-form-group">
                        <label>
                            <i class="bi bi-search"></i>
                            Nom, prénom ou matricule
                        </label>

                        <input type="text" name="recherche" class="ins-form-control"
                            placeholder="Ex : Rakoto, ELV-2026..." value="{{ request('recherche') }}">
                    </div>

                    {{-- ANNÉE SCOLAIRE --}}
                    <div class="ins-form-group">
                        <label>
                            <i class="bi bi-calendar3"></i>
                            Année scolaire
                        </label>

                        <select name="annee_scolaire_id" class="ins-form-control">
                            <option value="">Toutes les années</option>

                            @foreach ($anneesScolaires as $annee)
                                <option value="{{ $annee->id }}"
                                    {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- CLASSE --}}
                    <div class="ins-form-group">
                        <label>
                            <i class="bi bi-door-open"></i>
                            Classe
                        </label>

                        <select name="classe_id" class="ins-form-control">
                            <option value="">Toutes les classes</option>

                            @foreach ($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STATUT --}}
                    <div class="ins-form-group">
                        <label>
                            <i class="bi bi-flag"></i>
                            Statut
                        </label>

                        <select name="statut" class="ins-form-control">
                            <option value="">Tous les statuts</option>

                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>
                                En attente
                            </option>

                            <option value="validee" {{ request('statut') == 'validee' ? 'selected' : '' }}>
                                Validée
                            </option>

                            <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>
                                Annulée
                            </option>
                        </select>
                    </div>

                    {{-- BOUTONS --}}
                    <div class="ins-filter-actions">

                        <button type="submit" class="ins-btn-filter">
                            <i class="bi bi-search"></i>
                            Filtrer
                        </button>

                        <a href="{{ route('inscriptions.index') }}" class="ins-btn-reset"
                            title="Réinitialiser les filtres">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>

                    </div>

                </div>

            </form>

        </div>

        {{-- =====================================================
             TABLEAU DES INSCRIPTIONS
        ====================================================== --}}
        <div class="ins-table-card">

            {{-- EN-TÊTE --}}
            <div class="ins-table-header">

                <div>
                    <h5>
                        <i class="bi bi-list-ul"></i>
                        Liste des inscriptions
                    </h5>

                    <p>
                        Consultez les dossiers d'inscription de votre établissement.
                    </p>
                </div>

                <span class="ins-count-badge">
                    <i class="bi bi-folder2-open"></i>
                    {{ $inscriptions->total() }} dossier(s)
                </span>

            </div>

            {{-- TABLE --}}
            <div class="ins-table-scroll">

                <table class="ins-table">

                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Frais</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        {{-- CORRECTION : utilisation de $inscriptions --}}
                        @forelse ($inscriptions as $inscription)
                            <tr>

                                {{-- ÉLÈVE --}}
                                <td>
                                    <div class="ins-student">

                                        @if ($inscription->eleve && $inscription->eleve->photo)
                                            <img src="{{ asset('storage/' . $inscription->eleve->photo) }}"
                                                class="ins-student-photo" alt="Photo de l'élève">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(($inscription->eleve->nom ?? 'Élève') . ' ' . ($inscription->eleve->prenom ?? '')) }}&background=E8F0FE&color=2563EB&size=80"
                                                class="ins-student-photo" alt="Avatar de l'élève">
                                        @endif

                                        <div>
                                            <div class="ins-student-name">
                                                {{ $inscription->eleve->nom ?? '—' }}
                                                {{ $inscription->eleve->prenom ?? '' }}
                                            </div>

                                            <span class="ins-student-matricule">
                                                <i class="bi bi-card-text"></i>
                                                {{ $inscription->eleve->matricule ?? 'Sans matricule' }}
                                            </span>
                                        </div>

                                    </div>
                                </td>

                                {{-- CLASSE --}}
                                <td>
                                    <span class="ins-class-badge">
                                        <i class="bi bi-building"></i>
                                        {{ $inscription->classe->nom ?? '—' }}
                                    </span>
                                </td>

                                {{-- ANNÉE SCOLAIRE --}}
                                <td>
                                    <span class="ins-year">
                                        {{ $inscription->anneeScolaire->nom ?? '—' }}
                                    </span>
                                </td>

                                {{-- TYPE --}}
                                <td>
                                    <span class="ins-type">
                                        @if ($inscription->type === 'nouvelle_inscription')
                                            <i class="bi bi-person-plus me-1"></i>
                                            Nouvelle
                                        @else
                                            <i class="bi bi-arrow-repeat me-1"></i>
                                            Réinscription
                                        @endif
                                    </span>
                                </td>

                                {{-- DATE --}}
                                <td>
                                    <span style="white-space:nowrap;">
                                        <i class="bi bi-calendar-event me-1" style="color:var(--ins-muted);"></i>
                                        {{ $inscription->date_inscription?->format('d/m/Y') ?? '—' }}
                                    </span>
                                </td>

                                {{-- FRAIS --}}
                                <td>
                                    <span class="ins-money">
                                        {{ number_format((float) $inscription->frais_inscription, 0, ',', ' ') }}
                                        Ar
                                    </span>
                                </td>

                                {{-- STATUT --}}
                                <td>
                                    @if ($inscription->statut === 'validee')
                                        <span class="ins-status ins-status-validee">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Validée
                                        </span>
                                    @elseif ($inscription->statut === 'annulee')
                                        <span class="ins-status ins-status-annulee">
                                            <i class="bi bi-x-circle-fill"></i>
                                            Annulée
                                        </span>
                                    @else
                                        <span class="ins-status ins-status-attente">
                                            <i class="bi bi-clock-fill"></i>
                                            En attente
                                        </span>
                                    @endif
                                </td>

                                {{-- ACTIONS --}}
                                <td>
                                    <div class="ins-actions">

                                        {{-- VOIR --}}
                                        <a href="{{ route('inscriptions.show', $inscription->id) }}"
                                            class="ins-action-btn ins-action-view" title="Voir le dossier">

                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        {{-- MODIFIER --}}
                                        <a href="{{ route('inscriptions.edit', $inscription->id) }}"
                                            class="ins-action-btn ins-action-edit" title="Modifier">

                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        {{-- SUPPRIMER --}}
                                        @if ($inscription->statut !== 'validee')
                                            <form action="{{ route('inscriptions.destroy', $inscription->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer cette inscription ?');"
                                                style="display:inline;">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="ins-action-btn ins-action-delete"
                                                    title="Supprimer">

                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>

                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty

                            {{-- AUCUN RÉSULTAT --}}
                            <tr>
                                <td colspan="8" class="ins-empty">

                                    <div class="ins-empty-icon">
                                        <i class="bi bi-folder2-open" style="color:var(--ins-muted);"></i>
                                    </div>

                                    <h5>Aucune inscription trouvée</h5>

                                    <p>
                                        Aucun dossier ne correspond à votre recherche ou à vos filtres.
                                    </p>

                                    <a href="{{ route('inscriptions.create') }}" class="ins-btn-add">
                                        <i class="bi bi-plus-circle"></i>
                                        Créer une inscription
                                    </a>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            @if ($inscriptions->hasPages())
                <div class="ins-pagination">
                    {{ $inscriptions->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>

    </div>
@endsection
