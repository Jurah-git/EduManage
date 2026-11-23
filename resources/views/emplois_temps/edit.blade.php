@extends('layouts.app')

@section('content')

    <div class="emplois-edit-page">

        <style>
            /* =====================================================
               EMPLOI DU TEMPS - MODIFICATION
            ===================================================== */

            .emplois-edit-page {
                --ee-bg: #f4f7fc;
                --ee-card: #ffffff;
                --ee-surface: #f8faff;
                --ee-text: #24344d;
                --ee-muted: #718096;
                --ee-border: #e3eaf3;
                --ee-primary: #3563e9;
                --ee-primary-dark: #244dc2;
                --ee-shadow: 0 10px 30px rgba(30, 55, 90, .07);
                --ee-input: #ffffff;
                --ee-info-bg: #edf5ff;
                --ee-info-border: #cfe2ff;
                --ee-info-text: #24558f;

                min-height: 100vh;
                padding: 26px;
                background: var(--ee-bg);
                color: var(--ee-text);
                transition: background .25s ease, color .25s ease;
            }

            /* =====================================================
               THÈME SOMBRE
            ===================================================== */

            html[data-app-theme="dark"] .emplois-edit-page {
                --ee-bg: #111827;
                --ee-card: #1e293b;
                --ee-surface: #263449;
                --ee-text: #e5edf8;
                --ee-muted: #a0aec0;
                --ee-border: #35465e;
                --ee-primary: #7095ff;
                --ee-primary-dark: #5479e8;
                --ee-shadow: 0 10px 30px rgba(0, 0, 0, .22);
                --ee-input: #172337;
                --ee-info-bg: #1c3555;
                --ee-info-border: #31547e;
                --ee-info-text: #c4dcff;
            }

            /* =====================================================
               THÈME ULTRA PRO
            ===================================================== */

            html[data-app-theme="ultra-pro"] .emplois-edit-page {
                --ee-bg: #101827;
                --ee-card: #182438;
                --ee-surface: #202f46;
                --ee-text: #edf3ff;
                --ee-muted: #a8b8d0;
                --ee-border: #34445c;
                --ee-primary: #8b9cff;
                --ee-primary-dark: #6d7ee9;
                --ee-shadow: 0 15px 35px rgba(0, 0, 0, .28);
                --ee-input: #121e30;
                --ee-info-bg: #203b5d;
                --ee-info-border: #3a5d88;
                --ee-info-text: #d5e6ff;
            }

            /* =====================================================
               THÈME EMERALD
            ===================================================== */

            html[data-app-theme="emerald"] .emplois-edit-page {
                --ee-bg: #eff8f4;
                --ee-card: #ffffff;
                --ee-surface: #f3faf6;
                --ee-text: #164536;
                --ee-muted: #66877a;
                --ee-border: #d5e9df;
                --ee-primary: #13865f;
                --ee-primary-dark: #0d6b4b;
                --ee-shadow: 0 10px 30px rgba(18, 100, 70, .08);
                --ee-input: #ffffff;
                --ee-info-bg: #e8f7ef;
                --ee-info-border: #bde6ce;
                --ee-info-text: #176442;
            }

            /* =====================================================
               THÈME WARM
            ===================================================== */

            html[data-app-theme="warm"] .emplois-edit-page {
                --ee-bg: #faf5ef;
                --ee-card: #fffdf9;
                --ee-surface: #fdf7ef;
                --ee-text: #59402f;
                --ee-muted: #927966;
                --ee-border: #eddfd0;
                --ee-primary: #b8753e;
                --ee-primary-dark: #955b2e;
                --ee-shadow: 0 10px 30px rgba(120, 75, 35, .08);
                --ee-input: #fffdf9;
                --ee-info-bg: #fff3e5;
                --ee-info-border: #f0d5b7;
                --ee-info-text: #875328;
            }

            /* =====================================================
               EN-TÊTE
            ===================================================== */

            .ee-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 18px;
                margin-bottom: 28px;
            }

            .ee-heading {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .ee-heading-icon {
                width: 58px;
                height: 58px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 17px;
                background: linear-gradient(135deg, var(--ee-primary), var(--ee-primary-dark));
                color: #fff;
                font-size: 25px;
                box-shadow: 0 7px 17px rgba(53, 99, 233, .2);
            }

            .ee-title {
                color: var(--ee-text);
                font-size: 25px;
                font-weight: 800;
                letter-spacing: -.5px;
                margin: 0 0 5px;
            }

            .ee-subtitle {
                color: var(--ee-muted);
                font-size: 13px;
                margin: 0;
            }

            .ee-back-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 11px 17px;
                border: 1px solid var(--ee-border);
                border-radius: 11px;
                background: var(--ee-card);
                color: var(--ee-text);
                font-size: 13px;
                font-weight: 700;
                text-decoration: none;
                transition: all .2s ease;
            }

            .ee-back-btn:hover {
                color: var(--ee-primary);
                border-color: var(--ee-primary);
                transform: translateY(-2px);
            }

            /* =====================================================
               CARTE PRINCIPALE
            ===================================================== */

            .ee-content {
                max-width: 1000px;
                margin: 0 auto;
            }

            .ee-card {
                overflow: hidden;
                border: 1px solid var(--ee-border);
                border-radius: 18px;
                background: var(--ee-card);
                box-shadow: var(--ee-shadow);
            }

            .ee-card-header {
                display: flex;
                align-items: center;
                gap: 13px;
                padding: 21px 26px;
                border-bottom: 1px solid var(--ee-border);
                background: var(--ee-surface);
            }

            .ee-card-header-icon {
                width: 39px;
                height: 39px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: rgba(53, 99, 233, .11);
                color: var(--ee-primary);
                font-size: 18px;
            }

            .ee-card-header h5 {
                color: var(--ee-text);
                font-size: 16px;
                font-weight: 800;
                margin: 0 0 3px;
            }

            .ee-card-header p {
                color: var(--ee-muted);
                font-size: 12px;
                margin: 0;
            }

            .ee-card-body {
                padding: 28px;
            }

            /* =====================================================
               ALERTES
            ===================================================== */

            .ee-error-alert {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 16px 19px;
                margin-bottom: 20px;
                border: 1px solid #f1bfc4;
                border-radius: 13px;
                background: #fff0f1;
                color: #842029;
                font-size: 13px;
            }

            .ee-error-alert>i {
                font-size: 18px;
                margin-top: 1px;
            }

            .ee-error-alert ul {
                padding-left: 19px;
                margin: 8px 0 0;
                font-size: 12px;
            }

            .ee-error-alert strong {
                font-weight: 800;
            }

            html[data-app-theme="dark"] .ee-error-alert,
            html[data-app-theme="ultra-pro"] .ee-error-alert {
                background: #42232a;
                border-color: #773d49;
                color: #ffd5da;
            }

            /* =====================================================
               FORMULAIRE
            ===================================================== */

            .ee-form-section {
                margin-bottom: 24px;
            }

            .ee-label {
                display: flex;
                align-items: center;
                gap: 7px;
                color: var(--ee-text);
                font-size: 13px;
                font-weight: 750;
                margin-bottom: 9px;
            }

            .ee-label i {
                color: var(--ee-primary);
                font-size: 15px;
            }

            .ee-required {
                color: #e05252;
                font-weight: 800;
            }

            .ee-input,
            .ee-select {
                width: 100%;
                min-height: 48px;
                padding: 11px 14px;
                border: 1px solid var(--ee-border);
                border-radius: 11px;
                outline: none;
                background-color: var(--ee-input);
                color: var(--ee-text);
                font-size: 13px;
                transition: border-color .2s, box-shadow .2s;
            }

            .ee-input::placeholder {
                color: var(--ee-muted);
                opacity: .8;
            }

            .ee-input:focus,
            .ee-select:focus {
                border-color: var(--ee-primary);
                box-shadow: 0 0 0 3px rgba(53, 99, 233, .12);
                background-color: var(--ee-input);
                color: var(--ee-text);
            }

            .ee-select option {
                background: var(--ee-card);
                color: var(--ee-text);
            }

            .ee-input.is-invalid,
            .ee-select.is-invalid {
                border-color: #dc3545;
            }

            .ee-invalid-feedback {
                display: block;
                margin-top: 6px;
                color: #dc3545;
                font-size: 12px;
            }

            .ee-help {
                display: block;
                margin-top: 7px;
                color: var(--ee-muted);
                font-size: 11px;
            }

            /* =====================================================
               INFORMATION COMPLÉMENTAIRE
            ===================================================== */

            .ee-info-box {
                display: flex;
                align-items: flex-start;
                gap: 13px;
                padding: 16px 18px;
                border: 1px solid var(--ee-info-border);
                border-radius: 13px;
                background: var(--ee-info-bg);
                color: var(--ee-info-text);
                margin-top: 5px;
            }

            .ee-info-icon {
                width: 38px;
                height: 38px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 11px;
                background: rgba(53, 99, 233, .12);
                font-size: 18px;
            }

            .ee-info-title {
                font-size: 13px;
                font-weight: 800;
                margin-bottom: 4px;
            }

            .ee-info-text {
                font-size: 12px;
                line-height: 1.6;
                margin: 0;
                opacity: .9;
            }

            /* =====================================================
               BOUTONS
            ===================================================== */

            .ee-form-footer {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                padding-top: 23px;
                margin-top: 27px;
                border-top: 1px solid var(--ee-border);
            }

            .ee-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                min-height: 44px;
                padding: 10px 19px;
                border-radius: 10px;
                font-size: 12px;
                font-weight: 750;
                text-decoration: none;
                cursor: pointer;
                transition: all .2s ease;
            }

            .ee-btn-cancel {
                border: 1px solid var(--ee-border);
                background: var(--ee-card);
                color: var(--ee-text);
            }

            .ee-btn-cancel:hover {
                border-color: var(--ee-muted);
                color: var(--ee-text);
                transform: translateY(-2px);
            }

            .ee-btn-save {
                border: 1px solid var(--ee-primary);
                background: linear-gradient(135deg, var(--ee-primary), var(--ee-primary-dark));
                color: #fff;
                box-shadow: 0 5px 13px rgba(53, 99, 233, .18);
            }

            .ee-btn-save:hover {
                color: #fff;
                filter: brightness(1.08);
                transform: translateY(-2px);
                box-shadow: 0 7px 17px rgba(53, 99, 233, .25);
            }

            /* =====================================================
               RESPONSIVE
            ===================================================== */

            @media (max-width: 768px) {
                .emplois-edit-page {
                    padding: 17px;
                }

                .ee-title {
                    font-size: 21px;
                }

                .ee-heading-icon {
                    width: 49px;
                    height: 49px;
                    font-size: 21px;
                }

                .ee-card-header {
                    padding: 17px;
                }

                .ee-card-body {
                    padding: 20px;
                }
            }

            @media (max-width: 480px) {
                .ee-header {
                    align-items: flex-start;
                }

                .ee-back-btn {
                    width: 100%;
                    justify-content: center;
                }

                .ee-form-footer {
                    flex-direction: column-reverse;
                    align-items: stretch;
                }

                .ee-btn {
                    width: 100%;
                }

                .ee-card-body {
                    padding: 16px;
                }
            }
        </style>

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}

        <div class="ee-header">

            <div class="ee-heading">

                <div class="ee-heading-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div>
                    <h2 class="ee-title">Modifier l'emploi du temps</h2>

                    <p class="ee-subtitle">
                        Modifiez les informations générales de cet emploi du temps.
                    </p>
                </div>

            </div>

            <a href="{{ route('emplois-temps.index') }}" class="ee-back-btn">
                <i class="bi bi-arrow-left"></i>
                Retour à la liste
            </a>

        </div>

        {{-- =====================================================
         MESSAGE D'ERREUR SESSION
    ====================================================== --}}

        @if (session('error'))
            <div class="ee-error-alert">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <div>
                    <strong>Une erreur est survenue</strong>
                    <div class="mt-1">{{ session('error') }}</div>
                </div>

            </div>
        @endif

        {{-- =====================================================
         ERREURS DE VALIDATION
    ====================================================== --}}

        @if ($errors->any())
            <div class="ee-error-alert">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <div>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        @endif

        {{-- =====================================================
         FORMULAIRE PRINCIPAL
    ====================================================== --}}

        <div class="ee-content">

            <div class="ee-card">

                {{-- En-tête de la carte --}}

                <div class="ee-card-header">

                    <div class="ee-card-header-icon">
                        <i class="bi bi-sliders"></i>
                    </div>

                    <div>
                        <h5>Informations générales</h5>
                        <p>Modifiez la classe, l'année scolaire et le titre.</p>
                    </div>

                </div>

                {{-- Corps de la carte --}}

                <div class="ee-card-body">

                    <form action="{{ route('emplois-temps.update', $emploiTemps) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            {{-- Classe --}}

                            <div class="col-md-6">

                                <div class="ee-form-section mb-0">

                                    <label for="classe_id" class="ee-label">
                                        <i class="bi bi-mortarboard"></i>
                                        Classe
                                        <span class="ee-required">*</span>
                                    </label>

                                    <select name="classe_id" id="classe_id"
                                        class="ee-select @error('classe_id') is-invalid @enderror" required>

                                        <option value="">
                                            -- Sélectionner une classe --
                                        </option>

                                        @foreach ($classes as $classe)
                                            <option value="{{ $classe->id }}"
                                                {{ old('classe_id', $emploiTemps->classe_id) == $classe->id ? 'selected' : '' }}>
                                                {{ $classe->nom }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('classe_id')
                                        <span class="ee-invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                    <small class="ee-help">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Classe concernée par cet emploi du temps.
                                    </small>

                                </div>

                            </div>

                            {{-- Année scolaire --}}

                            <div class="col-md-6">

                                <div class="ee-form-section mb-0">

                                    <label for="annee_scolaire_id" class="ee-label">
                                        <i class="bi bi-calendar3"></i>
                                        Année scolaire
                                        <span class="ee-required">*</span>
                                    </label>

                                    <select name="annee_scolaire_id" id="annee_scolaire_id"
                                        class="ee-select @error('annee_scolaire_id') is-invalid @enderror" required>

                                        <option value="">
                                            -- Sélectionner une année scolaire --
                                        </option>

                                        @foreach ($anneesScolaires as $annee)
                                            <option value="{{ $annee->id }}"
                                                {{ old('annee_scolaire_id', $emploiTemps->annee_scolaire_id) == $annee->id ? 'selected' : '' }}>
                                                {{ $annee->nom ?? ($annee->libelle ?? ($annee->annee ?? $annee->id)) }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('annee_scolaire_id')
                                        <span class="ee-invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                    <small class="ee-help">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Année scolaire associée à cet emploi du temps.
                                    </small>

                                </div>

                            </div>

                            {{-- Titre --}}

                            <div class="col-12">

                                <div class="ee-form-section mb-0">

                                    <label for="titre" class="ee-label">
                                        <i class="bi bi-card-heading"></i>
                                        Titre de l'emploi du temps
                                        <span class="text-muted fw-normal">(facultatif)</span>
                                    </label>

                                    <input type="text" name="titre" id="titre"
                                        class="ee-input @error('titre') is-invalid @enderror"
                                        value="{{ old('titre', $emploiTemps->titre) }}"
                                        placeholder="Ex. : Emploi du temps de la classe de 6ème" maxlength="255">

                                    @error('titre')
                                        <span class="ee-invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                    <small class="ee-help">
                                        <i class="bi bi-lightbulb me-1"></i>
                                        Vous pouvez modifier le titre ou laisser ce champ vide.
                                    </small>

                                </div>

                            </div>

                        </div>

                        {{-- Information complémentaire --}}

                        <div class="ee-info-box mt-4">

                            <div class="ee-info-icon">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>

                            <div>

                                <div class="ee-info-title">
                                    À propos de la modification
                                </div>

                                <p class="ee-info-text">
                                    Les modifications seront enregistrées après validation.
                                    Les créneaux horaires de cet emploi du temps ne sont pas
                                    modifiés directement par ce formulaire.
                                </p>

                            </div>

                        </div>

                        {{-- Boutons d'action --}}

                        <div class="ee-form-footer">

                            <a href="{{ route('emplois-temps.show', $emploiTemps) }}" class="ee-btn ee-btn-cancel">
                                <i class="bi bi-x-lg"></i>
                                Annuler
                            </a>

                            <button type="submit" class="ee-btn ee-btn-save">
                                <i class="bi bi-check2-circle"></i>
                                Enregistrer les modifications
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
