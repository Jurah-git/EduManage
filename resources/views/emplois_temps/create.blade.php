@extends('layouts.app')

@section('content')

    <div class="emplois-create-page">

        <style>
            /* =====================================================
               EMPLOI DU TEMPS - CRÉATION
            ===================================================== */

            .emplois-create-page {
                --ec-bg: #f4f7fc;
                --ec-card: #ffffff;
                --ec-surface: #f8faff;
                --ec-text: #24344d;
                --ec-muted: #718096;
                --ec-border: #e3eaf3;
                --ec-primary: #3563e9;
                --ec-primary-dark: #244dc2;
                --ec-shadow: 0 10px 30px rgba(30, 55, 90, .07);
                --ec-input: #ffffff;
                --ec-info-bg: #edf5ff;
                --ec-info-border: #cfe2ff;
                --ec-info-text: #24558f;

                min-height: 100vh;
                padding: 26px;
                background: var(--ec-bg);
                color: var(--ec-text);
                transition: background .25s ease, color .25s ease;
            }

            /* =====================================================
               THÈME SOMBRE
            ===================================================== */

            html[data-app-theme="dark"] .emplois-create-page {
                --ec-bg: #111827;
                --ec-card: #1e293b;
                --ec-surface: #263449;
                --ec-text: #e5edf8;
                --ec-muted: #a0aec0;
                --ec-border: #35465e;
                --ec-primary: #7095ff;
                --ec-primary-dark: #5479e8;
                --ec-shadow: 0 10px 30px rgba(0, 0, 0, .22);
                --ec-input: #172337;
                --ec-info-bg: #1c3555;
                --ec-info-border: #31547e;
                --ec-info-text: #c4dcff;
            }

            /* =====================================================
               THÈME ULTRA PRO
            ===================================================== */

            html[data-app-theme="ultra-pro"] .emplois-create-page {
                --ec-bg: #101827;
                --ec-card: #182438;
                --ec-surface: #202f46;
                --ec-text: #edf3ff;
                --ec-muted: #a8b8d0;
                --ec-border: #34445c;
                --ec-primary: #8b9cff;
                --ec-primary-dark: #6d7ee9;
                --ec-shadow: 0 15px 35px rgba(0, 0, 0, .28);
                --ec-input: #121e30;
                --ec-info-bg: #203b5d;
                --ec-info-border: #3a5d88;
                --ec-info-text: #d5e6ff;
            }

            /* =====================================================
               THÈME EMERALD
            ===================================================== */

            html[data-app-theme="emerald"] .emplois-create-page {
                --ec-bg: #eff8f4;
                --ec-card: #ffffff;
                --ec-surface: #f3faf6;
                --ec-text: #164536;
                --ec-muted: #66877a;
                --ec-border: #d5e9df;
                --ec-primary: #13865f;
                --ec-primary-dark: #0d6b4b;
                --ec-shadow: 0 10px 30px rgba(18, 100, 70, .08);
                --ec-input: #ffffff;
                --ec-info-bg: #e8f7ef;
                --ec-info-border: #bde6ce;
                --ec-info-text: #176442;
            }

            /* =====================================================
               THÈME WARM
            ===================================================== */

            html[data-app-theme="warm"] .emplois-create-page {
                --ec-bg: #faf5ef;
                --ec-card: #fffdf9;
                --ec-surface: #fdf7ef;
                --ec-text: #59402f;
                --ec-muted: #927966;
                --ec-border: #eddfd0;
                --ec-primary: #b8753e;
                --ec-primary-dark: #955b2e;
                --ec-shadow: 0 10px 30px rgba(120, 75, 35, .08);
                --ec-input: #fffdf9;
                --ec-info-bg: #fff3e5;
                --ec-info-border: #f0d5b7;
                --ec-info-text: #875328;
            }

            /* =====================================================
               EN-TÊTE
            ===================================================== */

            .ec-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 18px;
                margin-bottom: 28px;
            }

            .ec-heading {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .ec-heading-icon {
                width: 58px;
                height: 58px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 17px;
                background: linear-gradient(135deg, var(--ec-primary), var(--ec-primary-dark));
                color: #fff;
                font-size: 25px;
                box-shadow: 0 7px 17px rgba(53, 99, 233, .2);
            }

            .ec-title {
                color: var(--ec-text);
                font-size: 25px;
                font-weight: 800;
                letter-spacing: -.5px;
                margin: 0 0 5px;
            }

            .ec-subtitle {
                color: var(--ec-muted);
                font-size: 13px;
                margin: 0;
            }

            .ec-back-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 11px 17px;
                border: 1px solid var(--ec-border);
                border-radius: 11px;
                background: var(--ec-card);
                color: var(--ec-text);
                font-size: 13px;
                font-weight: 700;
                text-decoration: none;
                transition: all .2s ease;
            }

            .ec-back-btn:hover {
                color: var(--ec-primary);
                border-color: var(--ec-primary);
                transform: translateY(-2px);
            }

            /* =====================================================
               CONTENU PRINCIPAL
            ===================================================== */

            .ec-content {
                max-width: 920px;
                margin: 0 auto;
            }

            .ec-card {
                overflow: hidden;
                border: 1px solid var(--ec-border);
                border-radius: 18px;
                background: var(--ec-card);
                box-shadow: var(--ec-shadow);
            }

            .ec-card-header {
                display: flex;
                align-items: center;
                gap: 13px;
                padding: 21px 26px;
                border-bottom: 1px solid var(--ec-border);
                background: var(--ec-surface);
            }

            .ec-card-header-icon {
                width: 39px;
                height: 39px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: rgba(53, 99, 233, .11);
                color: var(--ec-primary);
                font-size: 18px;
            }

            .ec-card-header h5 {
                color: var(--ec-text);
                font-size: 16px;
                font-weight: 800;
                margin: 0 0 3px;
            }

            .ec-card-header p {
                color: var(--ec-muted);
                font-size: 12px;
                margin: 0;
            }

            .ec-card-body {
                padding: 28px;
            }

            /* =====================================================
               FORMULAIRE
            ===================================================== */

            .ec-form-section {
                margin-bottom: 25px;
            }

            .ec-label {
                display: flex;
                align-items: center;
                gap: 7px;
                color: var(--ec-text);
                font-size: 13px;
                font-weight: 750;
                margin-bottom: 9px;
            }

            .ec-label i {
                color: var(--ec-primary);
                font-size: 15px;
            }

            .ec-required {
                color: #e05252;
                font-weight: 800;
            }

            .ec-input,
            .ec-select {
                width: 100%;
                min-height: 48px;
                padding: 11px 14px;
                border: 1px solid var(--ec-border);
                border-radius: 11px;
                outline: none;
                background-color: var(--ec-input);
                color: var(--ec-text);
                font-size: 13px;
                transition: border-color .2s, box-shadow .2s;
            }

            .ec-input::placeholder {
                color: var(--ec-muted);
                opacity: .8;
            }

            .ec-input:focus,
            .ec-select:focus {
                border-color: var(--ec-primary);
                box-shadow: 0 0 0 3px rgba(53, 99, 233, .12);
                background-color: var(--ec-input);
                color: var(--ec-text);
            }

            .ec-select option {
                background: var(--ec-card);
                color: var(--ec-text);
            }

            .ec-input.is-invalid,
            .ec-select.is-invalid {
                border-color: #dc3545;
            }

            .ec-invalid-feedback {
                display: block;
                margin-top: 6px;
                color: #dc3545;
                font-size: 12px;
            }

            .ec-help {
                display: block;
                margin-top: 7px;
                color: var(--ec-muted);
                font-size: 11px;
            }

            /* =====================================================
               BLOC STATUT
            ===================================================== */

            .ec-status-box {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                padding: 17px 19px;
                border: 1px solid var(--ec-info-border);
                border-radius: 13px;
                background: var(--ec-info-bg);
                color: var(--ec-info-text);
            }

            .ec-status-icon {
                width: 39px;
                height: 39px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 11px;
                background: rgba(53, 99, 233, .12);
                font-size: 18px;
            }

            .ec-status-title {
                font-size: 13px;
                font-weight: 800;
                margin-bottom: 4px;
            }

            .ec-status-description {
                font-size: 12px;
                line-height: 1.6;
                margin: 0;
                opacity: .9;
            }

            .ec-draft-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                margin-top: 9px;
                padding: 5px 10px;
                border-radius: 20px;
                background: rgba(220, 160, 35, .15);
                color: #b47a13;
                font-size: 10px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .4px;
            }

            /* =====================================================
               ERREURS
            ===================================================== */

            .ec-errors {
                padding: 17px 20px;
                margin-bottom: 22px;
                border: 1px solid #f1bfc4;
                border-radius: 13px;
                background: #fff0f1;
                color: #842029;
            }

            .ec-errors strong {
                font-size: 13px;
            }

            .ec-errors ul {
                padding-left: 20px;
                margin: 9px 0 0;
                font-size: 12px;
            }

            html[data-app-theme="dark"] .ec-errors,
            html[data-app-theme="ultra-pro"] .ec-errors {
                background: #42232a;
                border-color: #773d49;
                color: #ffd5da;
            }

            /* =====================================================
               ACTIONS
            ===================================================== */

            .ec-form-footer {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                padding-top: 23px;
                margin-top: 26px;
                border-top: 1px solid var(--ec-border);
            }

            .ec-btn {
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

            .ec-btn-cancel {
                border: 1px solid var(--ec-border);
                background: var(--ec-card);
                color: var(--ec-text);
            }

            .ec-btn-cancel:hover {
                border-color: var(--ec-muted);
                color: var(--ec-text);
                transform: translateY(-2px);
            }

            .ec-btn-save {
                border: 1px solid var(--ec-primary);
                background: linear-gradient(135deg, var(--ec-primary), var(--ec-primary-dark));
                color: #fff;
                box-shadow: 0 5px 13px rgba(53, 99, 233, .18);
            }

            .ec-btn-save:hover {
                color: #fff;
                filter: brightness(1.08);
                transform: translateY(-2px);
                box-shadow: 0 7px 17px rgba(53, 99, 233, .25);
            }

            /* =====================================================
               RESPONSIVE
            ===================================================== */

            @media (max-width: 768px) {
                .emplois-create-page {
                    padding: 17px;
                }

                .ec-title {
                    font-size: 21px;
                }

                .ec-heading-icon {
                    width: 49px;
                    height: 49px;
                    font-size: 21px;
                }

                .ec-card-header {
                    padding: 17px;
                }

                .ec-card-body {
                    padding: 20px;
                }
            }

            @media (max-width: 480px) {
                .ec-header {
                    align-items: flex-start;
                }

                .ec-back-btn {
                    width: 100%;
                    justify-content: center;
                }

                .ec-form-footer {
                    flex-direction: column-reverse;
                    align-items: stretch;
                }

                .ec-btn {
                    width: 100%;
                }

                .ec-card-body {
                    padding: 16px;
                }
            }
        </style>

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}

        <div class="ec-header">

            <div class="ec-heading">

                <div class="ec-heading-icon">
                    <i class="bi bi-calendar-plus"></i>
                </div>

                <div>
                    <h2 class="ec-title">Nouvel emploi du temps</h2>

                    <p class="ec-subtitle">
                        Créez et configurez un emploi du temps pour une classe.
                    </p>
                </div>

            </div>

            <a href="{{ route('emplois-temps.index') }}" class="ec-back-btn">
                <i class="bi bi-arrow-left"></i>
                Retour à la liste
            </a>

        </div>

        {{-- =====================================================
         ERREURS DE VALIDATION
    ====================================================== --}}

        @if ($errors->any())
            <div class="ec-errors">

                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                </div>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{-- =====================================================
         FORMULAIRE
    ====================================================== --}}

        <div class="ec-content">

            <div class="ec-card">

                {{-- En-tête de la carte --}}

                <div class="ec-card-header">

                    <div class="ec-card-header-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>

                    <div>
                        <h5>Informations générales</h5>
                        <p>Renseignez les informations principales de l'emploi du temps.</p>
                    </div>

                </div>

                {{-- Corps --}}

                <div class="ec-card-body">

                    <form action="{{ route('emplois-temps.store') }}" method="POST">

                        @csrf

                        {{-- Classe --}}

                        <div class="ec-form-section">

                            <label for="classe_id" class="ec-label">
                                <i class="bi bi-mortarboard"></i>
                                Classe
                                <span class="ec-required">*</span>
                            </label>

                            <select name="classe_id" id="classe_id"
                                class="ec-select @error('classe_id') is-invalid @enderror" required>

                                <option value="">-- Sélectionner une classe --</option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}" @selected(old('classe_id') == $classe->id)>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach

                            </select>

                            @error('classe_id')
                                <span class="ec-invalid-feedback">{{ $message }}</span>
                            @enderror

                            <small class="ec-help">
                                <i class="bi bi-lightbulb me-1"></i>
                                Sélectionnez la classe concernée par cet emploi du temps.
                            </small>

                        </div>

                        {{-- Année scolaire --}}

                        <div class="ec-form-section">

                            <label for="annee_scolaire_id" class="ec-label">
                                <i class="bi bi-calendar3"></i>
                                Année scolaire
                                <span class="ec-required">*</span>
                            </label>

                            <select name="annee_scolaire_id" id="annee_scolaire_id"
                                class="ec-select @error('annee_scolaire_id') is-invalid @enderror" required>

                                <option value="">-- Sélectionner une année scolaire --</option>

                                @foreach ($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id') == $annee->id)>
                                        {{ $annee->nom ?? ($annee->libelle ?? ($annee->annee ?? $annee->id)) }}
                                    </option>
                                @endforeach

                            </select>

                            @error('annee_scolaire_id')
                                <span class="ec-invalid-feedback">{{ $message }}</span>
                            @enderror

                            <small class="ec-help">
                                <i class="bi bi-lightbulb me-1"></i>
                                Indiquez l'année scolaire à laquelle cet emploi du temps appartient.
                            </small>

                        </div>

                        {{-- Titre --}}

                        <div class="ec-form-section">

                            <label for="titre" class="ec-label">
                                <i class="bi bi-card-heading"></i>
                                Titre de l'emploi du temps
                            </label>

                            <input type="text" name="titre" id="titre"
                                class="ec-input @error('titre') is-invalid @enderror" value="{{ old('titre') }}"
                                placeholder="Ex. : Emploi du temps 6ème A" maxlength="255">

                            @error('titre')
                                <span class="ec-invalid-feedback">{{ $message }}</span>
                            @enderror

                            <small class="ec-help">
                                <i class="bi bi-info-circle me-1"></i>
                                Ce champ est facultatif. Vous pouvez le laisser vide.
                            </small>

                        </div>

                        {{-- Statut initial --}}

                        <div class="ec-status-box">

                            <div class="ec-status-icon">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>

                            <div>

                                <div class="ec-status-title">
                                    Statut initial : Brouillon
                                </div>

                                <p class="ec-status-description">
                                    L'emploi du temps sera enregistré en brouillon.
                                    Vous pourrez ensuite ajouter les créneaux horaires,
                                    vérifier les informations et publier l'emploi du temps.
                                </p>

                                <span class="ec-draft-badge">
                                    <i class="bi bi-pencil-square"></i>
                                    Non publié
                                </span>

                            </div>

                        </div>

                        {{-- Boutons --}}

                        <div class="ec-form-footer">

                            <a href="{{ route('emplois-temps.index') }}" class="ec-btn ec-btn-cancel">
                                <i class="bi bi-x-lg"></i>
                                Annuler
                            </a>

                            <button type="submit" class="ec-btn ec-btn-save">
                                <i class="bi bi-check2-circle"></i>
                                Enregistrer l'emploi du temps
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
