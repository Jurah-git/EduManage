@extends('layouts.app')

@section('content')

    @php
        $tarifsMensuels = $tarifs->filter(function ($tarif) {
            return $tarif->typeFrais && $tarif->typeFrais->frequence === 'mensuelle';
        });

        $nomsMois = [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre',
        ];
    @endphp

    <div class="container-fluid py-4 generation-page">

        {{-- =========================
         EN-TÊTE
    ========================== --}}
        <div class="generation-hero mb-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    <div class="generation-breadcrumb mb-2">
                        <a href="{{ route('dashboard') }}">Tableau de bord</a>
                        <i class="bi bi-chevron-right"></i>
                        <span>Génération des frais</span>
                    </div>

                    <h2 class="mb-2">
                        <i class="bi bi-calendar2-check me-2"></i>
                        Génération des frais scolaires
                    </h2>

                    <p class="mb-0">
                        Génération des frais mensuels pour les élèves inscrits et validés.
                    </p>
                </div>

                <a href="{{ route('frais.tarifs.index') }}" class="btn btn-outline-light generation-back-btn">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour aux tarifs
                </a>

            </div>
        </div>

        {{-- =========================
         MESSAGES
    ========================== --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show generation-alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show generation-alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show generation-alert">
                <i class="bi bi-x-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="generation-errors mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- =========================
         STATISTIQUES
    ========================== --}}
        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="generation-stat-card">
                    <div class="generation-stat-icon stat-blue">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <span>Tarifs mensuels</span>
                        <h3>{{ $tarifsMensuels->count() }}</h3>
                        <small>Tarifs disponibles</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="generation-stat-card">
                    <div class="generation-stat-icon stat-green">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <span>Fréquence</span>
                        <h3 class="generation-stat-text">Mensuelle</h3>
                        <small>Génération par période</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="generation-stat-card">
                    <div class="generation-stat-icon stat-orange">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <span>Protection</span>
                        <h3 class="generation-stat-text">Activée</h3>
                        <small>Prévention des doublons</small>
                    </div>
                </div>
            </div>

        </div>

        {{-- =========================
         FORMULAIRE DE GÉNÉRATION
    ========================== --}}
        <div class="generation-card mb-4">

            <div class="generation-card-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="generation-header-icon">
                        <i class="bi bi-gear"></i>
                    </div>

                    <div>
                        <h5 class="mb-0">Générer les frais mensuels</h5>
                        <small>Paramètres de génération des écolages</small>
                    </div>
                </div>

                <span class="badge rounded-pill bg-primary">
                    <i class="bi bi-calendar-month me-1"></i>
                    Mensuel
                </span>
            </div>

            <div class="generation-card-body">

                {{-- INFORMATION --}}
                <div class="generation-info mb-4">
                    <div class="generation-info-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>
                        <strong>Comment fonctionne la génération ?</strong>

                        <p class="mb-0">
                            Les frais sont générés uniquement pour les élèves ayant une
                            inscription validée dans la classe et l'année scolaire du tarif choisi.
                            Les frais déjà générés pour la même période ne sont pas dupliqués.
                        </p>
                    </div>
                </div>

                <form action="{{ route('frais.generation.generer') }}" method="POST" id="generation-form">

                    @csrf

                    {{-- SÉLECTION DU TARIF --}}
                    <div class="generation-section-title">
                        <i class="bi bi-receipt"></i>
                        Tarif scolaire
                    </div>

                    <div class="row g-3 mb-4">

                        <div class="col-12">

                            <label for="tarif_frais_id" class="form-label">
                                Sélectionner un tarif mensuel
                                <span class="text-danger">*</span>
                            </label>

                            <select name="tarif_frais_id" id="tarif_frais_id"
                                class="form-select @error('tarif_frais_id') is-invalid @enderror" required>

                                <option value="">-- Sélectionner un tarif --</option>

                                @foreach ($tarifsMensuels as $tarif)
                                    <option value="{{ $tarif->id }}" @selected(old('tarif_frais_id') == $tarif->id)>

                                        {{ $tarif->typeFrais->nom }}
                                        — {{ $tarif->classe->nom ?? 'Classe inconnue' }}
                                        — {{ $tarif->anneeScolaire->nom ?? 'Année inconnue' }}
                                        — {{ number_format((float) $tarif->montant, 0, ',', ' ') }} Ar

                                    </option>
                                @endforeach

                            </select>

                            @error('tarif_frais_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($tarifsMensuels->isEmpty())
                                <div class="generation-empty-warning mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    Aucun tarif mensuel disponible. Veuillez d'abord configurer
                                    un tarif mensuel dans les tarifs scolaires.
                                </div>
                            @endif

                        </div>

                    </div>

                    <hr class="generation-divider">

                    {{-- PÉRIODE --}}
                    <div class="generation-section-title">
                        <i class="bi bi-calendar-range"></i>
                        Période de facturation
                    </div>

                    <div class="row g-3 mb-4">

                        {{-- MOIS --}}
                        <div class="col-12 col-md-4">

                            <label for="mois" class="form-label">
                                Mois <span class="text-danger">*</span>
                            </label>

                            <select name="mois" id="mois" class="form-select @error('mois') is-invalid @enderror"
                                required>

                                <option value="">-- Choisir un mois --</option>

                                @foreach ($nomsMois as $numero => $nom)
                                    <option value="{{ $numero }}" @selected(old('mois') == $numero)>
                                        {{ $nom }}
                                    </option>
                                @endforeach

                            </select>

                            @error('mois')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- ANNÉE --}}
                        <div class="col-12 col-md-4">

                            <label for="annee" class="form-label">
                                Année <span class="text-danger">*</span>
                            </label>

                            <input type="number" name="annee" id="annee"
                                class="form-control @error('annee') is-invalid @enderror" min="2000" max="2100"
                                value="{{ old('annee', now()->year) }}" required>

                            @error('annee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- DATE ÉCHÉANCE --}}
                        <div class="col-12 col-md-4">

                            <label for="date_echeance" class="form-label">
                                Date limite de paiement
                                <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="date_echeance" id="date_echeance"
                                class="form-control @error('date_echeance') is-invalid @enderror"
                                value="{{ old('date_echeance') }}" required>

                            @error('date_echeance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="form-text">
                                La date doit appartenir au mois sélectionné.
                            </small>

                        </div>

                    </div>

                    <div class="generation-period-preview" id="period-preview">
                        <i class="bi bi-calendar-event me-2"></i>
                        <span id="period-preview-text">
                            Sélectionnez un mois et une année pour définir la période.
                        </span>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="generation-form-actions">

                        <button type="submit" class="btn btn-primary" id="generation-submit"
                            @disabled($tarifsMensuels->isEmpty())>

                            <i class="bi bi-gear-fill me-1"></i>
                            Générer les frais
                        </button>

                        <a href="{{ route('frais.tarifs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Annuler
                        </a>

                    </div>

                </form>

            </div>
        </div>

        {{-- =========================
         LISTE DES TARIFS
    ========================== --}}
        <div class="generation-card">

            <div class="generation-card-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="generation-header-icon">
                        <i class="bi bi-list-check"></i>
                    </div>

                    <div>
                        <h5 class="mb-0">Tarifs mensuels disponibles</h5>
                        <small>Liste des tarifs configurés pour les écolages</small>
                    </div>
                </div>

                <span class="badge rounded-pill bg-primary">
                    {{ $tarifsMensuels->count() }} tarif(s)
                </span>
            </div>

            <div class="generation-card-body p-0">

                <div class="table-responsive">

                    <table class="table generation-table align-middle mb-0">

                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Type de frais</th>
                                <th>Classe</th>
                                <th>Année scolaire</th>
                                <th class="text-end">Montant</th>
                                <th>Validité</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($tarifsMensuels as $tarif)
                                <tr>
                                    <td>
                                        <span class="generation-row-number">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        <strong>{{ $tarif->typeFrais->nom }}</strong>
                                    </td>

                                    <td>
                                        {{ $tarif->classe->nom ?? '—' }}
                                    </td>

                                    <td>
                                        {{ $tarif->anneeScolaire->nom ?? '—' }}
                                    </td>

                                    <td class="text-end fw-bold generation-amount">
                                        {{ number_format((float) $tarif->montant, 0, ',', ' ') }} Ar
                                    </td>

                                    <td>
                                        <div class="generation-validity">
                                            <i class="bi bi-calendar3 me-1"></i>

                                            {{ $tarif->date_debut ? \Carbon\Carbon::parse($tarif->date_debut)->format('d/m/Y') : '—' }}

                                            <span class="mx-1">au</span>

                                            {{ $tarif->date_fin ? \Carbon\Carbon::parse($tarif->date_fin)->format('d/m/Y') : '—' }}
                                        </div>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="generation-empty">
                                            <i class="bi bi-inbox"></i>
                                            <h6>Aucun tarif mensuel disponible</h6>
                                            <p class="mb-0">
                                                Configurez d'abord un tarif mensuel pour pouvoir
                                                générer les frais des élèves.
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

    </div>

    {{-- =========================
     JAVASCRIPT
========================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const mois = document.getElementById('mois');
            const annee = document.getElementById('annee');
            const dateEcheance = document.getElementById('date_echeance');

            const preview = document.getElementById('period-preview-text');
            const form = document.getElementById('generation-form');

            const nomsMois = [
                '',
                'Janvier', 'Février', 'Mars', 'Avril',
                'Mai', 'Juin', 'Juillet', 'Août',
                'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ];

            function mettreAJourPeriode() {

                const numeroMois = parseInt(mois.value);
                const valeurAnnee = annee.value;

                if (numeroMois && valeurAnnee) {
                    preview.textContent =
                        'Période sélectionnée : ' +
                        nomsMois[numeroMois] + ' ' + valeurAnnee;
                } else {
                    preview.textContent =
                        'Sélectionnez un mois et une année pour définir la période.';
                }
            }

            function verifierDateEcheance() {

                if (!mois.value || !annee.value || !dateEcheance.value) {
                    dateEcheance.setCustomValidity('');
                    return true;
                }

                const date = dateEcheance.value.split('-');

                const anneeDate = parseInt(date[0]);
                const moisDate = parseInt(date[1]);

                const valide =
                    anneeDate === parseInt(annee.value) &&
                    moisDate === parseInt(mois.value);

                if (!valide) {
                    dateEcheance.setCustomValidity(
                        'La date limite doit appartenir au mois et à l’année sélectionnés.'
                    );
                } else {
                    dateEcheance.setCustomValidity('');
                }

                return valide;
            }

            mois.addEventListener('change', function() {
                mettreAJourPeriode();
                verifierDateEcheance();
            });

            annee.addEventListener('input', function() {
                mettreAJourPeriode();
                verifierDateEcheance();
            });

            dateEcheance.addEventListener('change', verifierDateEcheance);

            form.addEventListener('submit', function(event) {

                if (!verifierDateEcheance()) {
                    event.preventDefault();
                    dateEcheance.reportValidity();
                    return;
                }

                if (!confirm(
                        'Confirmer la génération des frais mensuels pour les élèves inscrits et validés ?'
                    )) {
                    event.preventDefault();
                }

            });

            mettreAJourPeriode();

        });
    </script>

    {{-- =========================
     STYLES
========================== --}}
    <style>
        .generation-page {
            --gp-bg: #f4f7fb;
            --gp-card: #ffffff;
            --gp-text: #263449;
            --gp-muted: #748198;
            --gp-border: #e5eaf1;
            --gp-primary: #5265d8;
            --gp-soft: #eef1ff;

            color: var(--gp-text);
        }

        /* HERO */
        .generation-hero {
            padding: 28px 30px;
            color: #fff;
            border-radius: 18px;
            background: linear-gradient(125deg, #3347a8, #6879e8);
            box-shadow: 0 8px 24px rgba(52, 71, 168, .16);
        }

        .generation-hero h2 {
            font-size: 1.55rem;
            font-weight: 750;
        }

        .generation-hero p {
            color: rgba(255, 255, 255, .82);
        }

        .generation-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            font-size: .82rem;
            color: rgba(255, 255, 255, .75);
        }

        .generation-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .generation-breadcrumb a:hover {
            text-decoration: underline;
        }

        .generation-back-btn {
            padding: 9px 15px;
            border-radius: 9px;
            font-weight: 600;
        }

        /* ALERTES */
        .generation-alert {
            border-radius: 11px;
        }

        .generation-errors {
            padding: 17px 20px;
            color: #842029;
            background: #f8d7da;
            border: 1px solid #f1aeb5;
            border-radius: 12px;
        }

        /* STATISTIQUES */
        .generation-stat-card {
            height: 100%;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 19px;
            background: var(--gp-card);
            border: 1px solid var(--gp-border);
            border-radius: 15px;
            box-shadow: 0 3px 12px rgba(25, 42, 70, .045);
        }

        .generation-stat-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            font-size: 1.35rem;
        }

        .stat-blue {
            background: #e9edff;
            color: #5265d8;
        }

        .stat-green {
            background: #e4f7ed;
            color: #198754;
        }

        .stat-orange {
            background: #fff1df;
            color: #d18b00;
        }

        .generation-stat-card span {
            display: block;
            color: var(--gp-muted);
            font-size: .82rem;
        }

        .generation-stat-card h3 {
            margin: 2px 0;
            color: var(--gp-text);
            font-size: 1.5rem;
            font-weight: 750;
        }

        .generation-stat-card .generation-stat-text {
            font-size: 1.1rem;
        }

        .generation-stat-card small {
            color: var(--gp-muted);
            font-size: .76rem;
        }

        /* CARTES */
        .generation-card {
            background: var(--gp-card);
            border: 1px solid var(--gp-border);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(25, 42, 70, .045);
        }

        .generation-card-header {
            min-height: 76px;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            border-bottom: 1px solid var(--gp-border);
        }

        .generation-card-header h5 {
            color: var(--gp-text);
            font-size: 1rem;
            font-weight: 700;
        }

        .generation-card-header small {
            color: var(--gp-muted);
            font-size: .78rem;
        }

        .generation-header-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--gp-soft);
            color: var(--gp-primary);
            font-size: 1.15rem;
        }

        .generation-card-body {
            padding: 24px;
        }

        /* INFORMATION */
        .generation-info {
            display: flex;
            gap: 13px;
            padding: 17px;
            background: var(--gp-soft);
            border: 1px solid var(--gp-border);
            border-radius: 11px;
        }

        .generation-info-icon {
            flex-shrink: 0;
            color: var(--gp-primary);
            font-size: 1.25rem;
        }

        .generation-info strong {
            display: block;
            color: var(--gp-text);
            margin-bottom: 5px;
            font-size: .9rem;
        }

        .generation-info p {
            color: var(--gp-muted);
            font-size: .83rem;
            line-height: 1.6;
        }

        /* SECTIONS */
        .generation-section-title {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 17px;
            color: var(--gp-primary);
            font-size: .92rem;
            font-weight: 750;
        }

        .generation-section-title i {
            font-size: 1.1rem;
        }

        .generation-divider {
            border-color: var(--gp-border);
            opacity: 1;
            margin: 24px 0;
        }

        /* FORMULAIRES */
        .generation-page .form-label {
            color: var(--gp-text);
            font-size: .87rem;
            font-weight: 650;
            margin-bottom: 8px;
        }

        .generation-page .form-control,
        .generation-page .form-select {
            min-height: 44px;
            color: var(--gp-text);
            background-color: var(--gp-card);
            border: 1px solid var(--gp-border);
            border-radius: 9px;
            font-size: .9rem;
        }

        .generation-page .form-control:focus,
        .generation-page .form-select:focus {
            border-color: var(--gp-primary);
            box-shadow: 0 0 0 .2rem rgba(82, 101, 216, .12);
        }

        .generation-page .form-text {
            display: block;
            color: var(--gp-muted);
            font-size: .76rem;
            margin-top: 6px;
        }

        .generation-page .invalid-feedback {
            font-size: .8rem;
        }

        .generation-empty-warning {
            color: #856404;
            font-size: .8rem;
        }

        /* PÉRIODE */
        .generation-period-preview {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 13px 16px;
            margin-bottom: 22px;
            color: var(--gp-primary);
            background: var(--gp-soft);
            border: 1px solid var(--gp-border);
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
        }

        /* ACTIONS */
        .generation-form-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
        }

        .generation-form-actions .btn {
            padding: 10px 17px;
            border-radius: 9px;
            font-size: .87rem;
            font-weight: 650;
        }

        /* TABLEAU */
        .generation-table {
            color: var(--gp-text);
            border-color: var(--gp-border);
        }

        .generation-table thead th {
            padding: 15px 13px;
            background: var(--gp-bg);
            color: var(--gp-muted);
            font-size: .77rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid var(--gp-border);
        }

        .generation-table tbody td {
            padding: 14px 13px;
            color: var(--gp-text);
            font-size: .87rem;
            border-color: var(--gp-border);
        }

        .generation-table tbody tr:hover td {
            background: var(--gp-soft);
        }

        .generation-row-number {
            display: inline-flex;
            width: 29px;
            height: 29px;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--gp-soft);
            color: var(--gp-primary);
            font-weight: 700;
            font-size: .8rem;
        }

        .generation-amount {
            color: var(--gp-primary) !important;
            white-space: nowrap;
        }

        .generation-validity {
            color: var(--gp-muted);
            font-size: .81rem;
            white-space: nowrap;
        }

        .generation-empty {
            color: var(--gp-muted);
        }

        .generation-empty>i {
            display: block;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .generation-empty h6 {
            color: var(--gp-text);
            font-weight: 700;
        }

        /* =========================
       MODE SOMBRE
    ========================= */
        html[data-app-theme="dark"] .generation-page {
            --gp-bg: #151c2b;
            --gp-card: #202a3b;
            --gp-text: #edf2fa;
            --gp-muted: #a8b5c8;
            --gp-border: #39465b;
            --gp-primary: #ad9fff;
            --gp-soft: #343052;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .generation-page .generation-card,
        html[data-app-theme="dark"] .generation-page .generation-stat-card {
            background: #202a3b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .generation-page .generation-card-header,
        html[data-app-theme="dark"] .generation-page .generation-table thead th,
        html[data-app-theme="dark"] .generation-page .generation-info,
        html[data-app-theme="dark"] .generation-page .generation-period-preview {
            background: #151c2b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .generation-page .form-control,
        html[data-app-theme="dark"] .generation-page .form-select {
            background-color: #151c2b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .generation-page .form-select option {
            background: #202a3b !important;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .generation-page .generation-table,
        html[data-app-theme="dark"] .generation-page .generation-table tbody tr,
        html[data-app-theme="dark"] .generation-page .generation-table tbody td {
            background-color: #202a3b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .generation-page .generation-table tbody tr:hover td {
            background: #343052 !important;
        }

        html[data-app-theme="dark"] .generation-page .generation-card-header h5,
        html[data-app-theme="dark"] .generation-page .generation-stat-card h3,
        html[data-app-theme="dark"] .generation-page .generation-info strong,
        html[data-app-theme="dark"] .generation-page .generation-section-title,
        html[data-app-theme="dark"] .generation-page .generation-empty h6 {
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .generation-page .generation-stat-icon,
        html[data-app-theme="dark"] .generation-page .generation-header-icon,
        html[data-app-theme="dark"] .generation-page .generation-row-number {
            background: #343052 !important;
            color: #c0b5ff !important;
        }

        /* =========================
       ULTRA PRO
    ========================= */
        html[data-app-theme="ultra-pro"] .generation-page {
            --gp-bg: #182337;
            --gp-card: #202d43;
            --gp-text: #eaf0fa;
            --gp-muted: #aab8ce;
            --gp-border: #34445e;
            --gp-primary: #7eb7ff;
            --gp-soft: #293d5c;
        }

        html[data-app-theme="ultra-pro"] .generation-page .generation-card,
        html[data-app-theme="ultra-pro"] .generation-page .generation-stat-card {
            background: #202d43;
            border-color: #34445e;
        }

        html[data-app-theme="ultra-pro"] .generation-page .generation-table thead th,
        html[data-app-theme="ultra-pro"] .generation-page .form-control,
        html[data-app-theme="ultra-pro"] .generation-page .form-select {
            background: #182337;
            color: #eaf0fa;
            border-color: #34445e;
        }

        /* =========================
       EMERALD
    ========================= */
        html[data-app-theme="emerald"] .generation-page {
            --gp-bg: #effaf5;
            --gp-card: #ffffff;
            --gp-text: #173f32;
            --gp-muted: #648477;
            --gp-border: #cfe9dc;
            --gp-primary: #13865d;
            --gp-soft: #dcf5e9;
        }

        html[data-app-theme="emerald"] .generation-page .generation-hero {
            background: linear-gradient(125deg, #08734e, #20a477);
        }

        /* =========================
       WARM
    ========================= */
        html[data-app-theme="warm"] .generation-page {
            --gp-bg: #fff8f0;
            --gp-card: #ffffff;
            --gp-text: #513b2d;
            --gp-muted: #927866;
            --gp-border: #f0dfce;
            --gp-primary: #c4773e;
            --gp-soft: #fbe8d7;
        }

        html[data-app-theme="warm"] .generation-page .generation-hero {
            background: linear-gradient(125deg, #a95d35, #d99559);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {

            .generation-hero {
                padding: 22px 18px;
            }

            .generation-hero h2 {
                font-size: 1.25rem;
            }

            .generation-card-body {
                padding: 17px;
            }

            .generation-card-header {
                padding: 14px 16px;
            }

            .generation-form-actions {
                flex-direction: column;
            }

            .generation-form-actions .btn {
                width: 100%;
            }

            .generation-table {
                min-width: 750px;
            }
        }
    </style>

@endsection
