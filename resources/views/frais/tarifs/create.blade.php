@extends('layouts.app')

@section('content')

    <style>
        /* =====================================================
       TARIFS - CREATION
    ===================================================== */

        .tarif-create {
            --tc-bg: #f4f6fb;
            --tc-card: #ffffff;
            --tc-text: #263449;
            --tc-muted: #718096;
            --tc-border: #e2e8f0;
            --tc-primary: #6256d9;
            --tc-soft: #eeecff;

            background: var(--tc-bg);
            color: var(--tc-text);
            padding: 22px;
            border-radius: 18px;
            min-height: 100%;
        }

        .tarif-create,
        .tarif-create * {
            box-sizing: border-box;
        }

        /* EN-TETE */

        .tarif-create .tc-hero {
            background: linear-gradient(120deg, #5145cd, #8274ee);
            padding: 27px 30px;
            border-radius: 18px;
            color: #fff;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px rgba(81, 69, 205, .18);
        }

        .tarif-create .tc-breadcrumb {
            font-size: 12px;
            margin-bottom: 13px;
            color: rgba(255, 255, 255, .75);
        }

        .tarif-create .tc-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .tarif-create .tc-hero h2 {
            font-size: 25px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .tarif-create .tc-hero p {
            font-size: 14px;
            color: rgba(255, 255, 255, .85);
            margin: 0;
        }

        .tarif-create .tc-hero .btn {
            border-radius: 10px;
            font-weight: 700;
            padding: 10px 17px;
        }

        /* CARTE */

        .tarif-create .tc-card {
            background: var(--tc-card);
            border: 1px solid var(--tc-border);
            border-radius: 17px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .04);
        }

        .tarif-create .tc-card-header {
            padding: 19px 22px;
            background: var(--tc-card);
            border-bottom: 1px solid var(--tc-border);
        }

        .tarif-create .tc-card-header h5 {
            font-size: 16px;
            font-weight: 800;
            color: var(--tc-text);
            margin: 0;
        }

        .tarif-create .tc-card-header small {
            display: block;
            color: var(--tc-muted);
            margin-top: 5px;
        }

        .tarif-create .tc-card-body {
            padding: 25px;
        }

        /* FORMULAIRE */

        .tarif-create .form-label {
            color: var(--tc-text);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .tarif-create .form-control,
        .tarif-create .form-select,
        .tarif-create .input-group-text {
            background-color: var(--tc-card);
            color: var(--tc-text);
            border-color: var(--tc-border);
            border-radius: 9px;
            min-height: 44px;
            font-size: 13px;
        }

        .tarif-create .form-control,
        .tarif-create .form-select {
            padding: 10px 12px;
        }

        .tarif-create .form-control::placeholder {
            color: var(--tc-muted);
            opacity: .8;
        }

        .tarif-create .form-control:focus,
        .tarif-create .form-select:focus {
            background-color: var(--tc-card);
            color: var(--tc-text);
            border-color: var(--tc-primary);
            box-shadow: 0 0 0 .2rem color-mix(in srgb, var(--tc-primary) 18%, transparent);
        }

        .tarif-create .input-group-text {
            display: flex;
            align-items: center;
            font-weight: 800;
            color: var(--tc-primary);
            background: var(--tc-soft);
            border-radius: 0 9px 9px 0;
        }

        .tarif-create .input-group .form-control {
            border-radius: 9px 0 0 9px;
        }

        .tarif-create .form-select option {
            background: var(--tc-card);
            color: var(--tc-text);
        }

        .tarif-create .form-check-label {
            color: var(--tc-text);
            font-size: 13px;
            font-weight: 650;
        }

        .tarif-create .form-check-input {
            cursor: pointer;
        }

        .tarif-create .form-check-input:checked {
            background-color: var(--tc-primary);
            border-color: var(--tc-primary);
        }

        .tarif-create .form-check-input:focus {
            border-color: var(--tc-primary);
            box-shadow: 0 0 0 .2rem color-mix(in srgb, var(--tc-primary) 20%, transparent);
        }

        .tarif-create .form-text {
            color: var(--tc-muted);
            font-size: 11px;
        }

        .tarif-create .invalid-feedback {
            font-size: 12px;
        }

        .tarif-create .is-invalid {
            border-color: #dc3545 !important;
        }

        /* SECTION */

        .tarif-create .tc-section-title {
            color: var(--tc-text);
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 17px;
        }

        .tarif-create .tc-section-title i {
            color: var(--tc-primary);
            margin-right: 7px;
        }

        .tarif-create .tc-divider {
            border-color: var(--tc-border);
            opacity: 1;
            margin: 24px 0;
        }

        /* INFORMATION */

        .tarif-create .tc-info {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 15px;
            background: var(--tc-soft);
            border: 1px solid var(--tc-border);
            border-radius: 12px;
            margin-bottom: 22px;
        }

        .tarif-create .tc-info i {
            color: var(--tc-primary);
            font-size: 19px;
            margin-top: 1px;
        }

        .tarif-create .tc-info strong {
            display: block;
            color: var(--tc-text);
            font-size: 12px;
            margin-bottom: 4px;
        }

        .tarif-create .tc-info p {
            color: var(--tc-muted);
            font-size: 12px;
            margin: 0;
            line-height: 1.6;
        }

        /* BOUTONS */

        .tarif-create .tc-btn {
            border-radius: 9px;
            font-weight: 700;
            padding: 10px 17px;
            font-size: 13px;
        }

        .tarif-create .tc-btn-primary {
            background: var(--tc-primary);
            border-color: var(--tc-primary);
            color: #fff;
        }

        .tarif-create .tc-btn-primary:hover {
            filter: brightness(.92);
            color: #fff;
        }

        /* ERREURS */

        .tarif-create .alert {
            border-radius: 12px;
        }

        /* =====================================================
       MODE SOMBRE
    ===================================================== */

        html[data-app-theme="dark"] .tarif-create {
            --tc-bg: #151c2b;
            --tc-card: #202a3b;
            --tc-text: #edf2fa;
            --tc-muted: #a8b5c8;
            --tc-border: #39465b;
            --tc-primary: #ad9fff;
            --tc-soft: #343052;

            background: #151c2b !important;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarif-create .tc-card,
        html[data-app-theme="dark"] .tarif-create .tc-card-header,
        html[data-app-theme="dark"] .tarif-create .tc-card-body {
            background: #202a3b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarif-create .tc-card-header h5,
        html[data-app-theme="dark"] .tarif-create .tc-section-title,
        html[data-app-theme="dark"] .tarif-create .form-label,
        html[data-app-theme="dark"] .tarif-create .form-check-label,
        html[data-app-theme="dark"] .tarif-create .tc-info strong {
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarif-create .tc-card-header small,
        html[data-app-theme="dark"] .tarif-create .form-text,
        html[data-app-theme="dark"] .tarif-create .tc-info p {
            color: #a8b5c8 !important;
        }

        html[data-app-theme="dark"] .tarif-create .form-control,
        html[data-app-theme="dark"] .tarif-create .form-select {
            background-color: #182234 !important;
            color: #edf2fa !important;
            border-color: #46536a !important;
            color-scheme: dark;
        }

        html[data-app-theme="dark"] .tarif-create .form-control::placeholder {
            color: #9baac0 !important;
        }

        html[data-app-theme="dark"] .tarif-create .form-select option {
            background: #182234 !important;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarif-create .input-group-text {
            background: #343052 !important;
            color: #c1b7ff !important;
            border-color: #46536a !important;
        }

        html[data-app-theme="dark"] .tarif-create .form-check-input {
            background-color: #354154;
            border-color: #718096;
        }

        html[data-app-theme="dark"] .tarif-create .form-check-input:checked {
            background-color: #7668db !important;
            border-color: #7668db !important;
        }

        html[data-app-theme="dark"] .tarif-create .tc-info {
            background: #293047 !important;
            border-color: #46536a !important;
        }

        html[data-app-theme="dark"] .tarif-create .tc-info i,
        html[data-app-theme="dark"] .tarif-create .tc-section-title i {
            color: #ad9fff !important;
        }

        html[data-app-theme="dark"] .tarif-create .tc-divider {
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarif-create .btn-outline-secondary {
            color: #d2dbea !important;
            border-color: #68768c !important;
        }

        html[data-app-theme="dark"] .tarif-create .btn-outline-secondary:hover {
            background: #354154 !important;
        }

        /* =====================================================
       ULTRA PRO
    ===================================================== */

        html[data-app-theme="ultra-pro"] .tarif-create {
            --tc-bg: #101827;
            --tc-card: #1b293d;
            --tc-text: #edf4ff;
            --tc-muted: #a4b4ca;
            --tc-border: #34445c;
            --tc-primary: #79bdff;
            --tc-soft: #243c59;
        }

        /* =====================================================
       EMERALD
    ===================================================== */

        html[data-app-theme="emerald"] .tarif-create {
            --tc-bg: #edf7f2;
            --tc-card: #ffffff;
            --tc-text: #173b30;
            --tc-muted: #638477;
            --tc-border: #d4e9df;
            --tc-primary: #13865c;
            --tc-soft: #dff5e9;
        }

        html[data-app-theme="emerald"] .tarif-create .tc-hero {
            background: linear-gradient(120deg, #087b54, #22a879);
        }

        /* =====================================================
       WARM
    ===================================================== */

        html[data-app-theme="warm"] .tarif-create {
            --tc-bg: #faf3eb;
            --tc-card: #fffdf9;
            --tc-text: #493629;
            --tc-muted: #967d68;
            --tc-border: #eadbcb;
            --tc-primary: #bd7541;
            --tc-soft: #f8e8d8;
        }

        html[data-app-theme="warm"] .tarif-create .tc-hero {
            background: linear-gradient(120deg, #a85d32, #d9955c);
        }

        /* =====================================================
       RESPONSIVE
    ===================================================== */

        @media(max-width: 768px) {
            .tarif-create {
                padding: 12px;
            }

            .tarif-create .tc-hero {
                padding: 22px;
            }

            .tarif-create .tc-hero h2 {
                font-size: 21px;
            }

            .tarif-create .tc-card-body {
                padding: 17px;
            }
        }
    </style>


    <div class="tarif-create">

        {{-- EN-TÊTE --}}
        <div class="tc-hero">

            <div class="tc-breadcrumb">
                <a href="{{ route('dashboard') }}">Tableau de bord</a>
                <span class="mx-2">/</span>
                Gestion financière
                <span class="mx-2">/</span>
                <a href="{{ route('frais.tarifs.index') }}">Tarifs scolaires</a>
                <span class="mx-2">/</span>
                Ajouter
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    <h2>
                        <i class="bi bi-plus-circle me-2"></i>
                        Ajouter un tarif scolaire
                    </h2>

                    <p>
                        Définissez le montant d'un frais pour une classe et une année scolaire.
                    </p>
                </div>

                <a href="{{ route('frais.tarifs.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour à la liste
                </a>

            </div>
        </div>


        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">

                <strong>
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Veuillez corriger les erreurs suivantes :
                </strong>

                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- INFORMATIONS --}}
        <div class="tc-info">
            <i class="bi bi-info-circle-fill"></i>

            <div>
                <strong>À savoir avant de créer un tarif</strong>

                <p>
                    Un tarif est associé à un type de frais, une année scolaire
                    et une classe. Vérifiez ces informations avant l'enregistrement
                    afin d'éviter les doublons.
                </p>
            </div>
        </div>


        {{-- FORMULAIRE --}}
        <div class="tc-card">

            <div class="tc-card-header">
                <h5>
                    <i class="bi bi-cash-stack me-2"></i>
                    Informations du tarif
                </h5>

                <small>
                    Les champs marqués d'un astérisque (*) sont obligatoires.
                </small>
            </div>


            <div class="tc-card-body">

                <form action="{{ route('frais.tarifs.store') }}" method="POST">
                    @csrf

                    {{-- CONFIGURATION DU TARIF --}}
                    <div class="tc-section-title">
                        <i class="bi bi-gear-fill"></i>
                        Configuration du tarif
                    </div>

                    <div class="row g-4">

                        {{-- TYPE DE FRAIS --}}
                        <div class="col-md-6">

                            <label for="type_frais_id" class="form-label">
                                Type de frais <span class="text-danger">*</span>
                            </label>

                            <select name="type_frais_id" id="type_frais_id"
                                class="form-select @error('type_frais_id') is-invalid @enderror" required>

                                <option value="">-- Choisir un type de frais --</option>

                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" @selected(old('type_frais_id') == $type->id)>
                                        {{ $type->nom }}
                                    </option>
                                @endforeach

                            </select>

                            @error('type_frais_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- ANNEE SCOLAIRE --}}
                        <div class="col-md-6">

                            <label for="annee_scolaire_id" class="form-label">
                                Année scolaire <span class="text-danger">*</span>
                            </label>

                            <select name="annee_scolaire_id" id="annee_scolaire_id"
                                class="form-select @error('annee_scolaire_id') is-invalid @enderror" required>

                                <option value="">-- Choisir une année scolaire --</option>

                                @foreach ($annees as $annee)
                                    <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id') == $annee->id)>
                                        {{ $annee->nom }}
                                        {{ $annee->active ? '(Active)' : '' }}
                                    </option>
                                @endforeach

                            </select>

                            @error('annee_scolaire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- CLASSE --}}
                        <div class="col-md-6">

                            <label for="classe_id" class="form-label">
                                Classe <span class="text-danger">*</span>
                            </label>

                            <select name="classe_id" id="classe_id"
                                class="form-select @error('classe_id') is-invalid @enderror" required>

                                <option value="">-- Choisir une classe --</option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}" @selected(old('classe_id') == $classe->id)>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach

                            </select>

                            @error('classe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- MONTANT --}}
                        <div class="col-md-6">

                            <label for="montant" class="form-label">
                                Montant <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <input type="number" name="montant" id="montant"
                                    class="form-control @error('montant') is-invalid @enderror"
                                    value="{{ old('montant') }}" min="0.01" step="0.01" placeholder="Ex. : 50000"
                                    required>

                                <span class="input-group-text">Ar</span>

                                @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-text">
                                Saisissez le montant en Ariary.
                            </div>

                        </div>

                    </div>


                    <hr class="tc-divider">


                    {{-- PERIODE DE VALIDITE --}}
                    <div class="tc-section-title">
                        <i class="bi bi-calendar-range"></i>
                        Période de validité du tarif
                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">

                            <label for="date_debut" class="form-label">
                                Date de début
                            </label>

                            <input type="date" name="date_debut" id="date_debut"
                                class="form-control @error('date_debut') is-invalid @enderror"
                                value="{{ old('date_debut') }}">

                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Date à partir de laquelle le tarif est applicable.
                            </div>

                        </div>


                        <div class="col-md-6">

                            <label for="date_fin" class="form-label">
                                Date de fin
                            </label>

                            <input type="date" name="date_fin" id="date_fin"
                                class="form-control @error('date_fin') is-invalid @enderror"
                                value="{{ old('date_fin') }}">

                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Laissez vide si aucune date de fin n'est définie.
                            </div>

                        </div>

                    </div>


                    <hr class="tc-divider">


                    {{-- STATUT --}}
                    <div class="tc-section-title">
                        <i class="bi bi-toggle-on"></i>
                        État du tarif
                    </div>

                    <div class="form-check form-switch">

                        <input type="checkbox" name="actif" id="actif" class="form-check-input" value="1"
                            @checked(old('actif', '1') == '1')>

                        <label for="actif" class="form-check-label">
                            Tarif actif
                        </label>

                        <div class="form-text">
                            Un tarif inactif ne sera pas utilisé pour la génération automatique des frais.
                        </div>

                    </div>


                    {{-- BOUTONS --}}
                    <hr class="tc-divider">

                    <div class="d-flex flex-wrap gap-2">

                        <button type="submit" class="btn tc-btn tc-btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Enregistrer le tarif
                        </button>

                        <a href="{{ route('frais.tarifs.index') }}" class="btn btn-outline-secondary tc-btn">
                            <i class="bi bi-x-circle me-1"></i>
                            Annuler
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
