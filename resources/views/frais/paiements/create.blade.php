@extends('layouts.app')

@section('content')

    <style>
        .paiement-create {
            --pc-card: #ffffff;
            --pc-text: #263247;
            --pc-muted: #778399;
            --pc-border: #e7ebf2;
            --pc-primary: #4361ee;
            --pc-soft: #edf1ff;
            --pc-shadow: 0 5px 20px rgba(30, 45, 75, .055);
            color: var(--pc-text);
        }

        .paiement-create .pc-hero {
            background: linear-gradient(120deg, #263b80, #4361ee 65%, #7388f5);
            border-radius: 18px;
            padding: 27px 30px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(67, 97, 238, .18);
        }

        .paiement-create .pc-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            right: -65px;
            top: -110px;
            background: rgba(255, 255, 255, .09);
        }

        .paiement-create .pc-hero h2 {
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .paiement-create .pc-hero p {
            color: rgba(255, 255, 255, .78);
        }

        .paiement-create .pc-card {
            background: var(--pc-card);
            border: 1px solid var(--pc-border);
            border-radius: 15px;
            box-shadow: var(--pc-shadow);
            overflow: hidden;
        }

        .paiement-create .pc-card-header {
            padding: 17px 21px;
            border-bottom: 1px solid var(--pc-border);
            background: var(--pc-card);
        }

        .paiement-create .pc-card-body {
            padding: 22px;
        }

        .paiement-create .pc-title {
            color: var(--pc-text);
            font-weight: 750;
            margin: 0;
            font-size: 16px;
        }

        .paiement-create .pc-subtitle {
            color: var(--pc-muted);
            font-size: 12px;
        }

        .paiement-create .form-label {
            color: var(--pc-text);
            font-size: 13px;
            font-weight: 650;
            margin-bottom: 7px;
        }

        .paiement-create .form-control,
        .paiement-create .form-select {
            min-height: 43px;
            border-color: var(--pc-border);
            border-radius: 9px;
            background-color: var(--pc-card);
            color: var(--pc-text);
        }

        .paiement-create .form-control:focus,
        .paiement-create .form-select:focus {
            border-color: var(--pc-primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, .12);
        }

        .paiement-create .btn {
            border-radius: 9px;
            font-weight: 600;
        }

        .paiement-create .pc-student {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .paiement-create .pc-student-photo {
            width: 76px;
            height: 76px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--pc-border);
            flex-shrink: 0;
        }

        .paiement-create .pc-student-avatar {
            width: 76px;
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--pc-soft);
            color: var(--pc-primary);
            font-size: 34px;
            flex-shrink: 0;
        }

        .paiement-create .pc-student-name {
            font-size: 19px;
            font-weight: 800;
            color: var(--pc-text);
        }

        .paiement-create .pc-student-info {
            color: var(--pc-muted);
            font-size: 12px;
        }

        .paiement-create .pc-table-scroll {
            max-height: 520px;
            overflow: auto;
        }

        .paiement-create .table {
            color: var(--pc-text);
            margin-bottom: 0;
            white-space: nowrap;
        }

        .paiement-create .table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f2f5fa;
            color: #65728a;
            font-size: 11px;
            font-weight: 750;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 14px 12px;
            border-bottom: 1px solid var(--pc-border);
        }

        .paiement-create .table tbody td {
            padding: 13px 12px;
            border-color: var(--pc-border);
            vertical-align: middle;
            font-size: 13px;
        }

        .paiement-create .table tbody tr:hover {
            background: rgba(67, 97, 238, .035);
        }

        .paiement-create .pc-fee-name {
            font-weight: 700;
            color: var(--pc-text);
        }

        .paiement-create .pc-muted {
            color: var(--pc-muted);
            font-size: 11px;
        }

        .paiement-create .pc-amount {
            font-weight: 750;
            color: var(--pc-text);
        }

        .paiement-create .pc-remaining {
            font-weight: 800;
            color: #d34b55;
        }

        .paiement-create .montant-encaisse {
            min-width: 145px;
            font-weight: 700;
            text-align: right;
        }

        .paiement-create .pc-info {
            border: 1px solid #cfe2ff;
            background: #edf5ff;
            color: #24558d;
            border-radius: 10px;
            padding: 13px 15px;
            font-size: 13px;
        }

        .paiement-create .pc-summary {
            background: linear-gradient(145deg, #f7f9ff, #eef2ff);
            border: 1px solid #e0e7ff;
            border-radius: 13px;
            padding: 18px;
        }

        .paiement-create .pc-summary-label {
            color: var(--pc-muted);
            font-size: 12px;
            font-weight: 650;
        }

        .paiement-create .pc-summary-value {
            font-size: 30px;
            font-weight: 850;
            color: #14804a;
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        .paiement-create .pc-summary-count {
            font-size: 24px;
            font-weight: 800;
            color: var(--pc-primary);
        }

        .paiement-create .pc-summary-divider {
            border-color: #dce3f2;
            opacity: 1;
        }

        .paiement-create .pc-empty {
            text-align: center;
            padding: 45px 20px;
        }

        .paiement-create .pc-empty-icon {
            width: 65px;
            height: 65px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto auto 15px;
            border-radius: 18px;
            background: #e5f7ed;
            color: #14804a;
            font-size: 30px;
        }

        .paiement-create .pc-mode {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            background: var(--pc-soft);
            color: var(--pc-primary);
            border-radius: 9px;
            font-weight: 700;
        }

        .paiement-create .pc-mode i {
            font-size: 21px;
        }

        .paiement-create .pc-submit {
            padding: 13px 18px;
            font-weight: 750;
            font-size: 15px;
        }

        /* DARK */
        html[data-app-theme="dark"] .paiement-create {
            --pc-card: #1e293b;
            --pc-text: #e5e7eb;
            --pc-muted: #a0aec0;
            --pc-border: #334155;
            --pc-soft: #293a60;
            --pc-shadow: 0 5px 20px rgba(0, 0, 0, .15);
        }

        html[data-app-theme="dark"] .paiement-create .pc-hero {
            background: linear-gradient(120deg, #172554, #263b80, #334e9d);
        }

        html[data-app-theme="dark"] .paiement-create .pc-card-header {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        html[data-app-theme="dark"] .paiement-create .table,
        html[data-app-theme="dark"] .paiement-create .table tbody,
        html[data-app-theme="dark"] .paiement-create .table tbody tr,
        html[data-app-theme="dark"] .paiement-create .table tbody td {
            background-color: #1e293b !important;
            color: #e5e7eb !important;
            border-color: #334155 !important;
        }

        html[data-app-theme="dark"] .paiement-create .table thead th {
            background: #29384d !important;
            color: #dbe4f0 !important;
            border-color: #334155 !important;
        }

        html[data-app-theme="dark"] .paiement-create .table tbody tr:hover,
        html[data-app-theme="dark"] .paiement-create .table tbody tr:hover td {
            background: #29384d !important;
        }

        html[data-app-theme="dark"] .paiement-create .pc-fee-name,
        html[data-app-theme="dark"] .paiement-create .pc-title,
        html[data-app-theme="dark"] .paiement-create .pc-student-name,
        html[data-app-theme="dark"] .paiement-create .form-label {
            color: #f1f5f9 !important;
        }

        html[data-app-theme="dark"] .paiement-create .form-control,
        html[data-app-theme="dark"] .paiement-create .form-select {
            background-color: #172235 !important;
            color: #f1f5f9 !important;
            border-color: #475569 !important;
        }

        html[data-app-theme="dark"] .paiement-create .form-control::placeholder {
            color: #94a3b8;
        }

        html[data-app-theme="dark"] .paiement-create .pc-info {
            background: #1d3556;
            border-color: #315780;
            color: #c6e0ff;
        }

        html[data-app-theme="dark"] .paiement-create .pc-summary {
            background: #172b45;
            border-color: #334b6d;
        }

        html[data-app-theme="dark"] .paiement-create .pc-summary-divider {
            border-color: #475569;
        }

        html[data-app-theme="dark"] .paiement-create .pc-mode {
            background: #293a60;
            color: #b8c8ff;
        }

        /* ULTRA PRO */
        html[data-app-theme="ultra-pro"] .paiement-create {
            --pc-primary: #64748b;
            --pc-soft: #f1f5f9;
            --pc-border: #dce3ec;
        }

        html[data-app-theme="ultra-pro"] .paiement-create .pc-hero {
            background: linear-gradient(120deg, #172033, #475569);
        }

        /* EMERALD */
        html[data-app-theme="emerald"] .paiement-create {
            --pc-primary: #059669;
            --pc-soft: #e4f8ef;
        }

        html[data-app-theme="emerald"] .paiement-create .pc-hero {
            background: linear-gradient(120deg, #065f46, #059669, #34a982);
        }

        /* WARM */
        html[data-app-theme="warm"] .paiement-create {
            --pc-primary: #c07843;
            --pc-soft: #fff0e4;
            --pc-border: #f0e1d5;
        }

        html[data-app-theme="warm"] .paiement-create .pc-hero {
            background: linear-gradient(120deg, #854d32, #bd7950, #d99a6c);
        }

        @media (max-width: 768px) {
            .paiement-create .pc-hero {
                padding: 22px 20px;
            }

            .paiement-create .pc-hero h2 {
                font-size: 22px;
            }

            .paiement-create .pc-card-body {
                padding: 17px;
            }

            .paiement-create .pc-student {
                align-items: flex-start;
            }

            .paiement-create .pc-student-photo,
            .paiement-create .pc-student-avatar {
                width: 60px;
                height: 60px;
            }

            .paiement-create .pc-student-name {
                font-size: 16px;
            }

            .paiement-create .pc-summary-value {
                font-size: 25px;
            }
        }


        /* POPUP DE SÉLECTION DES ÉLÈVES */
        .paiement-create .pc-modal .modal-content {
            background: var(--pc-card);
            color: var(--pc-text);
            border: 1px solid var(--pc-border);
            border-radius: 16px;
            overflow: hidden;
        }

        .paiement-create .pc-modal .modal-header {
            background: var(--pc-card);
            border-bottom: 1px solid var(--pc-border);
        }

        .paiement-create .pc-modal .modal-footer {
            background: var(--pc-card);
            border-top: 1px solid var(--pc-border);
        }

        .paiement-create .pc-modal .modal-title {
            color: var(--pc-text);
            font-weight: 800;
        }

        .paiement-create .pc-modal .btn-close {
            filter: none;
        }

        html[data-app-theme="dark"] .paiement-create .pc-modal .btn-close {
            filter: invert(1);
        }

        .paiement-create .pc-student-list {
            max-height: 470px;
            overflow-y: auto;
            padding: 10px;
        }

        .paiement-create .pc-student-option {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px;
            margin-bottom: 8px;
            border: 1px solid var(--pc-border);
            border-radius: 11px;
            background: var(--pc-card);
            transition: .2s ease;
        }

        .paiement-create .pc-student-option:hover {
            border-color: var(--pc-primary);
            background: var(--pc-soft);
        }

        .paiement-create .pc-student-option img,
        .paiement-create .pc-student-option .pc-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .paiement-create .pc-student-option .pc-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--pc-soft);
            color: var(--pc-primary);
            font-size: 22px;
        }

        .paiement-create .pc-student-option .pc-option-name {
            font-weight: 750;
            color: var(--pc-text);
        }

        .paiement-create .pc-student-option .pc-option-info {
            color: var(--pc-muted);
            font-size: 12px;
        }

        .paiement-create .pc-student-option .btn {
            margin-left: auto;
            flex-shrink: 0;
        }

        .paiement-create .pc-selected-student {
            background: var(--pc-soft);
            border: 1px solid var(--pc-border);
            border-radius: 10px;
            padding: 12px 15px;
            color: var(--pc-text);
        }

        .paiement-create .pc-no-student {
            text-align: center;
            padding: 35px 15px;
            color: var(--pc-muted);
        }

        @media (max-width: 576px) {
            .paiement-create .pc-student-option {
                flex-wrap: wrap;
            }

            .paiement-create .pc-student-option .btn {
                width: 100%;
                margin-left: 0;
            }
        }

        .pc-selected-avatar {
            width: 65px;
            height: 65px;
            min-width: 65px;
            border-radius: 50%;
            overflow: hidden;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 25px;
            font-weight: 700;
            border: 3px solid rgba(37, 99, 235, .15);
        }

        .pc-selected-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <div class="container-fluid py-4 paiement-create">

        {{-- EN-TÊTE --}}
        <div class="pc-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 position-relative"
                style="z-index:1;">

                <div>
                    <div class="small mb-2" style="color:rgba(255,255,255,.75);">
                        FINANCES / ENCAISSEMENTS
                    </div>

                    <h2 class="mb-2">
                        <i class="bi bi-cash-coin me-2"></i>
                        Nouvel encaissement
                    </h2>

                    <p class="mb-0">
                        Enregistrer un paiement en espèces et générer automatiquement un reçu.
                    </p>
                </div>

                <a href="{{ route('frais.paiements.index') }}" class="btn btn-light px-3 py-2">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour aux paiements
                </a>

            </div>
        </div>

        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Veuillez corriger les erreurs suivantes :
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- SÉLECTION DE L'ÉLÈVE --}}
        @php
            $classesDisponibles = $eleves->pluck('classe')->filter()->unique('id')->sortBy('nom');
        @endphp

        <div class="pc-card mb-4">

            <div class="pc-card-header">
                <h5 class="pc-title">
                    <i class="bi bi-person-search text-primary me-2"></i>
                    Sélection de l'élève
                </h5>

                <small class="pc-subtitle">
                    Recherchez et choisissez un élève pour afficher ses frais scolaires.
                </small>
            </div>

            <div class="pc-card-body">

                <form method="GET" action="{{ route('frais.paiements.create') }}" id="formSelectionEleve">

                    <input type="hidden" name="eleve_id" id="eleve_id"
                        value="{{ old('eleve_id', $eleveSelectionne->id ?? request('eleve_id')) }}">

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-9">

                            <label class="form-label">
                                Élève sélectionné
                            </label>

                            <div id="eleveSelectionneAffichage">

                                @if ($eleveSelectionne)
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-check-fill text-success fs-4"></i>

                                        <div>
                                            <div class="fw-bold">
                                                {{ $eleveSelectionne->nom }} {{ $eleveSelectionne->prenom }}
                                            </div>

                                            <small class="pc-muted">
                                                {{ $eleveSelectionne->matricule }}
                                                — {{ $eleveSelectionne->classe->nom ?? 'Sans classe' }}
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Aucun élève sélectionné.</span>
                                @endif

                            </div>

                        </div>

                        <div class="col-lg-3">

                            <button type="button" class="btn btn-outline-primary w-100 py-2" data-bs-toggle="modal"
                                data-bs-target="#modalSelectionEleve">
                                <i class="bi bi-people me-1"></i>
                                Choisir un élève
                            </button>

                        </div>

                        <div class="col-12">

                            <button type="submit" class="btn btn-primary px-4" id="btnAfficherFrais"
                                {{ !$eleveSelectionne ? 'disabled' : '' }}>
                                <i class="bi bi-search me-1"></i>
                                Afficher les frais
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>

        {{-- POPUP DE SÉLECTION --}}
        <div class="modal fade pc-modal" id="modalSelectionEleve" tabindex="-1" aria-labelledby="modalSelectionEleveLabel"
            aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">

                    <div class="modal-header">

                        <div>
                            <h5 class="modal-title" id="modalSelectionEleveLabel">
                                <i class="bi bi-people text-primary me-2"></i>
                                Choisir un élève
                            </h5>

                            <small class="pc-muted">
                                Recherchez un élève puis cliquez sur « Choisir ».
                            </small>
                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>

                    </div>

                    <div class="modal-body">

                        {{-- RECHERCHE ET FILTRE --}}
                        <div class="row g-3 mb-3">

                            <div class="col-md-7">

                                <label class="form-label">
                                    Rechercher
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>

                                    <input type="text" id="rechercheElevePopup" class="form-control"
                                        placeholder="Nom, prénom ou matricule..." autocomplete="off">
                                </div>

                            </div>

                            <div class="col-md-5">

                                <label class="form-label">
                                    Filtrer par classe
                                </label>

                                <select id="filtreClassePopup" class="form-select">

                                    <option value="">Toutes les classes</option>

                                    @foreach ($classesDisponibles as $classe)
                                        <option value="{{ $classe->id }}">
                                            {{ $classe->nom }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <small class="pc-muted">
                                Liste des élèves
                            </small>

                            <span class="badge bg-primary" id="nombreElevesPopup">
                                {{ $eleves->count() }} élève(s)
                            </span>

                        </div>

                        {{-- LISTE DES ÉLÈVES --}}
                        <div class="pc-student-list">

                            @foreach ($eleves as $eleve)
                                <div class="pc-student-option"
                                    data-nom="{{ strtolower($eleve->nom . ' ' . $eleve->prenom . ' ' . $eleve->matricule) }}"
                                    data-classe="{{ $eleve->classe_id ?? '' }}">

                                    @if ($eleve->photo)
                                        <img src="{{ asset('storage/' . $eleve->photo) }}" alt="Photo de l'élève">
                                    @else
                                        <div class="pc-avatar">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    @endif

                                    <div class="flex-grow-1">

                                        <div class="pc-option-name">
                                            {{ $eleve->nom }}
                                            {{ $eleve->prenom }}
                                        </div>

                                        <div class="pc-option-info">
                                            <span>
                                                <i class="bi bi-card-text me-1"></i>
                                                {{ $eleve->matricule }}
                                            </span>

                                            <span class="ms-2">
                                                <i class="bi bi-mortarboard me-1"></i>
                                                {{ $eleve->classe->nom ?? 'Sans classe' }}
                                            </span>
                                        </div>

                                    </div>

                                    <button type="button" class="btn btn-primary btn-sm btn-choisir-eleve"
                                        data-id="{{ $eleve->id }}" data-nom="{{ $eleve->nom }}"
                                        data-prenom="{{ $eleve->prenom }}" data-matricule="{{ $eleve->matricule }}"
                                        data-classe-nom="{{ $eleve->classe->nom ?? 'Sans classe' }}"
                                        data-photo="{{ $eleve->photo ? asset('storage/' . $eleve->photo) : '' }}">
                                        Choisir
                                    </button>

                                </div>
                            @endforeach

                            <div class="pc-no-student d-none" id="aucunEleveTrouve">
                                <i class="bi bi-search fs-1 d-block mb-2"></i>
                                <strong>Aucun élève trouvé</strong>
                                <div class="small">
                                    Modifiez votre recherche ou votre filtre.
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Fermer
                        </button>

                    </div>

                </div>
            </div>
        </div>


        @if ($eleveSelectionne)

            {{-- INFORMATIONS DE L'ÉLÈVE --}}
            <div class="pc-card mb-4">
                <div class="pc-card-body">

                    <div class="pc-student">

                        @if ($eleveSelectionne->photo)
                            <img src="{{ asset('storage/' . $eleveSelectionne->photo) }}" alt="Photo de l'élève"
                                class="pc-student-photo">
                        @else
                            <div class="pc-student-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif

                        <div class="flex-grow-1">
                            <div class="pc-student-name">
                                {{ $eleveSelectionne->nom }}
                                {{ $eleveSelectionne->prenom }}
                            </div>

                            <div class="d-flex flex-wrap gap-3 mt-2 pc-student-info">
                                <span>
                                    <i class="bi bi-card-text me-1"></i>
                                    {{ $eleveSelectionne->matricule }}
                                </span>

                                <span>
                                    <i class="bi bi-mortarboard me-1"></i>
                                    {{ $eleveSelectionne->classe->nom ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <span class="badge rounded-pill text-bg-primary px-3 py-2 d-none d-md-inline-flex">
                            Élève sélectionné
                        </span>

                    </div>

                </div>
            </div>

            @if ($frais->isNotEmpty())
                {{-- FORMULAIRE DE PAIEMENT --}}
                <form method="POST" action="{{ route('frais.paiements.store') }}" id="formPaiement">

                    @csrf

                    <input type="hidden" name="eleve_id" value="{{ $eleveSelectionne->id }}">

                    {{-- FRAIS À PAYER --}}
                    <div class="pc-card mb-4">

                        <div class="pc-card-header">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                                <div>
                                    <h5 class="pc-title">
                                        <i class="bi bi-receipt text-primary me-2"></i>
                                        Frais restant à payer
                                    </h5>
                                    <small class="pc-subtitle">
                                        Saisissez les montants à encaisser pour chaque frais.
                                    </small>
                                </div>

                                <span class="badge rounded-pill text-bg-primary px-3 py-2">
                                    {{ $frais->count() }} frais disponible(s)
                                </span>

                            </div>
                        </div>

                        <div class="pc-card-body">

                            <div class="pc-info mb-3">
                                <i class="bi bi-info-circle me-2"></i>
                                Vous pouvez régler plusieurs frais dans un seul paiement.
                                Les paiements partiels sont également autorisés.
                            </div>

                            <div class="pc-table-scroll">
                                <table class="table table-hover align-middle">

                                    <thead>
                                        <tr>
                                            <th>Frais</th>
                                            <th>Période</th>
                                            <th>Échéance</th>
                                            <th class="text-end">Montant dû</th>
                                            <th class="text-end">Déjà payé</th>
                                            <th class="text-end">Reste à payer</th>
                                            <th style="min-width:170px;">Montant encaissé</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($frais as $ligne)
                                            <tr>

                                                <td>
                                                    <div class="pc-fee-name">
                                                        {{ $ligne->tarifFrais->typeFrais->nom ?? $ligne->libelle }}
                                                    </div>

                                                    <small class="pc-muted">
                                                        {{ $ligne->libelle }}
                                                    </small>
                                                </td>

                                                <td>
                                                    <span class="pc-muted">
                                                        {{ $ligne->cle_periode ?? '-' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    {{ $ligne->date_echeance ? $ligne->date_echeance->format('d/m/Y') : '-' }}
                                                </td>

                                                <td class="text-end">
                                                    <span class="pc-amount">
                                                        {{ number_format($ligne->montant_du, 0, ',', ' ') }} Ar
                                                    </span>
                                                </td>

                                                <td class="text-end text-success fw-semibold">
                                                    {{ number_format($ligne->montant_paye, 0, ',', ' ') }} Ar
                                                </td>

                                                <td class="text-end">
                                                    <span class="pc-remaining">
                                                        {{ number_format($ligne->reste_a_payer, 0, ',', ' ') }} Ar
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="number" name="frais[{{ $ligne->id }}]"
                                                        class="form-control montant-encaisse" min="0"
                                                        max="{{ $ligne->reste_a_payer }}" step="0.01" placeholder="0"
                                                        value="{{ old('frais.' . $ligne->id) }}"
                                                        data-reste="{{ $ligne->reste_a_payer }}">
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                    {{-- INFORMATIONS ET RÉCAPITULATIF --}}
                    <div class="row g-4">

                        {{-- INFORMATIONS DU PAIEMENT --}}
                        <div class="col-lg-7">

                            <div class="pc-card h-100">

                                <div class="pc-card-header">
                                    <h5 class="pc-title">
                                        <i class="bi bi-clipboard-check text-primary me-2"></i>
                                        Informations du paiement
                                    </h5>
                                </div>

                                <div class="pc-card-body">

                                    <div class="mb-4">
                                        <label class="form-label">Date du paiement</label>

                                        <input type="date" name="date_paiement" class="form-control"
                                            value="{{ old('date_paiement', now()->format('Y-m-d')) }}" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Mode de paiement</label>

                                        <div class="pc-mode">
                                            <i class="bi bi-cash-coin"></i>
                                            <div>
                                                Espèces
                                                <div class="pc-muted" style="color:inherit;opacity:.75;">
                                                    Paiement au comptant
                                                </div>
                                            </div>
                                        </div>

                                        <small class="pc-muted d-block mt-2">
                                            Les encaissements sont effectués uniquement en espèces.
                                        </small>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Observations</label>

                                        <textarea name="observations" class="form-control" rows="4" placeholder="Observations éventuelles...">{{ old('observations') }}</textarea>
                                    </div>

                                </div>
                            </div>

                        </div>

                        {{-- RÉCAPITULATIF --}}
                        <div class="col-lg-5">

                            <div class="pc-card h-100">

                                <div class="pc-card-header">
                                    <h5 class="pc-title">
                                        <i class="bi bi-calculator text-primary me-2"></i>
                                        Récapitulatif de l'encaissement
                                    </h5>
                                </div>

                                <div class="pc-card-body d-flex flex-column">

                                    <div class="pc-summary mb-3">

                                        <div class="pc-summary-label mb-1">
                                            Nombre de frais sélectionnés
                                        </div>

                                        <div class="pc-summary-count" id="nombreFrais">
                                            0
                                        </div>

                                        <hr class="pc-summary-divider my-3">

                                        <div class="pc-summary-label mb-2">
                                            Montant total encaissé
                                        </div>

                                        <div class="pc-summary-value" id="totalEncaisse">
                                            0 Ar
                                        </div>

                                    </div>

                                    <div class="alert alert-warning small">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Après validation, le paiement sera enregistré et un reçu sera automatiquement
                                        généré.
                                    </div>

                                    <button type="submit" class="btn btn-success btn-lg w-100 pc-submit mt-auto"
                                        id="btnValider">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Valider l'encaissement
                                    </button>

                                </div>
                            </div>

                        </div>

                    </div>

                </form>
            @else
                {{-- AUCUN FRAIS --}}
                <div class="pc-card">
                    <div class="pc-empty">

                        <div class="pc-empty-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>

                        <h5 class="fw-bold" style="color:var(--pc-text);">
                            Aucun frais à encaisser
                        </h5>

                        <p class="mb-0" style="color:var(--pc-muted);">
                            Cet élève n'a actuellement aucun frais impayé ou partiellement payé.
                        </p>

                    </div>
                </div>
            @endif

        @endif

    </div>

    {{-- CALCUL AUTOMATIQUE DU TOTAL --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const champs = document.querySelectorAll('.montant-encaisse');
            const totalElement = document.getElementById('totalEncaisse');
            const nombreElement = document.getElementById('nombreFrais');
            const formulaire = document.getElementById('formPaiement');
            const bouton = document.getElementById('btnValider');

            const formatMontant = new Intl.NumberFormat('fr-FR', {
                maximumFractionDigits: 2
            });

            function calculerTotal() {

                let total = 0;
                let nombre = 0;

                champs.forEach(function(champ) {

                    const montant = parseFloat(champ.value) || 0;

                    if (montant > 0) {
                        total += montant;
                        nombre++;
                    }

                });

                if (totalElement) {
                    totalElement.textContent = formatMontant.format(total) + ' Ar';
                }

                if (nombreElement) {
                    nombreElement.textContent = nombre;
                }

                return total;
            }

            champs.forEach(function(champ) {

                champ.addEventListener('input', function() {

                    const montant = parseFloat(this.value) || 0;
                    const reste = parseFloat(this.dataset.reste);

                    if (montant < 0) {
                        this.setCustomValidity('Le montant ne peut pas être négatif.');
                    } else if (montant > reste) {
                        this.setCustomValidity(
                            'Le montant ne peut pas dépasser le reste à payer.'
                        );
                    } else {
                        this.setCustomValidity('');
                    }

                    calculerTotal();

                });

            });

            if (formulaire) {

                formulaire.addEventListener('submit', function(event) {

                    const total = calculerTotal();

                    let montantInvalide = false;

                    champs.forEach(function(champ) {

                        const montant = parseFloat(champ.value) || 0;
                        const reste = parseFloat(champ.dataset.reste);

                        if (montant < 0 || montant > reste) {
                            montantInvalide = true;
                            champ.reportValidity();
                        }

                    });

                    if (montantInvalide) {
                        event.preventDefault();
                        return;
                    }

                    if (total <= 0) {
                        event.preventDefault();
                        alert('Veuillez saisir au moins un montant à encaisser.');
                        return;
                    }

                    if (bouton) {
                        bouton.disabled = true;
                        bouton.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-2"></span>Enregistrement en cours...';
                    }

                });

            }

            calculerTotal();

        });


        document.addEventListener('DOMContentLoaded', function() {

            const recherche = document.getElementById('rechercheElevePopup');
            const filtreClasse = document.getElementById('filtreClassePopup');
            const listeEleves = document.querySelectorAll('.pc-student-option');
            const aucunEleve = document.getElementById('aucunEleveTrouve');
            const compteur = document.getElementById('nombreElevesPopup');

            const champEleve = document.getElementById('eleve_id');
            const affichageEleve = document.getElementById('eleveSelectionneAffichage');
            const boutonAfficher = document.getElementById('btnAfficherFrais');

            const modalElement = document.getElementById('modalSelectionEleve');

            function filtrerEleves() {

                const terme = recherche.value.toLowerCase().trim();
                const classe = filtreClasse.value;

                let nombreVisible = 0;

                listeEleves.forEach(function(eleve) {

                    const nom = eleve.dataset.nom || '';
                    const classeEleve = eleve.dataset.classe || '';

                    const correspondRecherche = nom.includes(terme);
                    const correspondClasse = !classe || classeEleve === classe;

                    const visible = correspondRecherche && correspondClasse;

                    eleve.classList.toggle('d-none', !visible);

                    if (visible) {
                        nombreVisible++;
                    }

                });

                compteur.textContent = nombreVisible + ' élève(s)';

                aucunEleve.classList.toggle('d-none', nombreVisible > 0);
            }

            recherche.addEventListener('input', filtrerEleves);
            filtreClasse.addEventListener('change', filtrerEleves);

            function fermerPopupEleve() {

                const modalElement = document.getElementById('modalSelectionEleve');

                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                modalElement.setAttribute('aria-hidden', 'true');
                modalElement.removeAttribute('aria-modal');

                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');

                document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                    backdrop.remove();
                });
            }

            document.querySelectorAll('.btn-choisir-eleve').forEach(function(bouton) {

                bouton.addEventListener('click', function() {

                    const id = this.dataset.id;
                    const nom = this.dataset.nom;
                    const prenom = this.dataset.prenom;
                    const matricule = this.dataset.matricule;
                    const classe = this.dataset.classeNom;
                    const photo = this.dataset.photo;

                    champEleve.value = id;

                    affichageEleve.innerHTML = `
    <div class="d-flex align-items-center gap-3">

        <div class="pc-selected-avatar">
            ${
                photo
                    ? `<img src="${photo}" alt="Photo de l'élève">`
                    : `<span>${prenom.charAt(0).toUpperCase()}</span>`
            }
        </div>

        <div>
            <div class="fw-bold"></div>
            <small class="pc-muted"></small>
        </div>

    </div>
`;

                    affichageEleve.querySelector('.fw-bold').textContent =
                        nom + ' ' + prenom;

                    affichageEleve.querySelector('.pc-muted').textContent =
                        matricule + ' — ' + classe;
                    affichageEleve.querySelector('.pc-muted').textContent =
                        matricule + ' — ' + classe;

                    boutonAfficher.disabled = false;

                    fermerPopupEleve();

                });

            });

            modalElement.addEventListener('shown.bs.modal', function() {
                recherche.focus();
            });

        });
    </script>


@endsection
