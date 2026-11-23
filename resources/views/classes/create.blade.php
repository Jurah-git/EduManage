@extends('layouts.app')

@section('content')

    <div class="classe-create-page">

        {{-- EN-TÊTE --}}
        <div class="classe-hero">
            <div class="classe-hero-content">
                <div class="classe-hero-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>

                <div>
                    <span class="classe-eyebrow">GESTION SCOLAIRE</span>
                    <h2>Créer une nouvelle classe</h2>
                    <p>Configurez une nouvelle classe pour votre établissement.</p>
                </div>
            </div>

            <a href="{{ route('classes.index') }}" class="classe-back-btn">
                <i class="bi bi-arrow-left"></i>
                Retour aux classes
            </a>
        </div>

        {{-- FIL D'ARIANE --}}
        <div class="classe-breadcrumb">
            <i class="bi bi-house-door"></i>
            <span>Accueil</span>
            <i class="bi bi-chevron-right"></i>
            <span>Classes</span>
            <i class="bi bi-chevron-right"></i>
            <strong>Nouvelle classe</strong>
        </div>

        {{-- MESSAGES D'ERREUR --}}
        @if ($errors->any())
            <div class="classe-alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>Vérifiez les informations saisies.</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="classe-create-grid">

            {{-- FORMULAIRE --}}
            <div class="classe-form-card">

                <div class="classe-card-heading">
                    <div class="classe-heading-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div>
                        <h4>Informations de la classe</h4>
                        <p>Renseignez les informations nécessaires.</p>
                    </div>

                    <span class="classe-required">
                        <span></span> Champ obligatoire
                    </span>
                </div>

                <div class="classe-form-body">

                    <div class="classe-step">
                        <span class="classe-step-number">01</span>
                        <div>
                            <strong>Identification</strong>
                            <p>Définissez le nom de votre classe.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('classes.store') }}">
                        @csrf

                        <div class="classe-input-group">

                            <label for="nom">
                                Nom de la classe
                                <span class="text-danger">*</span>
                            </label>

                            <div class="classe-input-wrapper">
                                <div class="classe-input-icon">
                                    <i class="bi bi-mortarboard"></i>
                                </div>

                                <input type="text" id="nom" name="nom"
                                    class="classe-input @error('nom') is-invalid @enderror"
                                    placeholder="Exemple : 6ème A, Terminale C..." value="{{ old('nom') }}"
                                    maxlength="100" required autofocus autocomplete="off">
                            </div>

                            @error('nom')
                                <div class="classe-field-error">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="classe-input-help">
                                <i class="bi bi-info-circle"></i>
                                Choisissez un nom clair et facilement identifiable.
                            </small>

                        </div>

                        {{-- CONSEIL --}}
                        <div class="classe-tip">
                            <div class="classe-tip-icon">
                                <i class="bi bi-lightbulb-fill"></i>
                            </div>

                            <div>
                                <strong>Conseil</strong>
                                <p>
                                    Utilisez une nomenclature cohérente pour faciliter
                                    l'organisation des élèves et le suivi pédagogique.
                                </p>
                            </div>
                        </div>

                        {{-- BOUTONS --}}
                        <div class="classe-form-footer">

                            <a href="{{ route('classes.index') }}" class="classe-cancel-btn">
                                <i class="bi bi-x-lg"></i>
                                Annuler
                            </a>

                            <button type="submit" class="classe-submit-btn">
                                <i class="bi bi-check-circle-fill"></i>
                                Enregistrer la classe
                            </button>

                        </div>

                    </form>

                </div>
            </div>

            {{-- COLONNE APERÇU --}}
            <div class="classe-preview-column">

                <div class="classe-preview-card">

                    <div class="classe-preview-header">
                        <div>
                            <span>APERÇU EN DIRECT</span>
                            <h5>Votre nouvelle classe</h5>
                        </div>

                        <div class="classe-live-indicator">
                            <span></span> Live
                        </div>
                    </div>

                    <div class="classe-preview-content">

                        <div class="classe-preview-illustration">
                            <div class="classe-preview-circle">
                                <i class="bi bi-building"></i>
                            </div>

                            <div class="classe-preview-decoration decoration-one"></div>
                            <div class="classe-preview-decoration decoration-two"></div>
                        </div>

                        <span class="classe-preview-label">NOM DE LA CLASSE</span>

                        <h3 id="previewNom">
                            {{ old('nom') ?: 'Nom de votre classe' }}
                        </h3>

                        <div class="classe-preview-divider"></div>

                        <div class="classe-preview-info">

                            <div class="classe-info-item">
                                <div class="classe-info-icon blue">
                                    <i class="bi bi-people-fill"></i>
                                </div>

                                <div>
                                    <small>Effectif</small>
                                    <strong>0 élève</strong>
                                </div>
                            </div>

                            <div class="classe-info-item">
                                <div class="classe-info-icon purple">
                                    <i class="bi bi-calendar-check"></i>
                                </div>

                                <div>
                                    <small>Statut</small>
                                    <strong>Nouvelle classe</strong>
                                </div>
                            </div>

                        </div>

                        <div class="classe-preview-note">
                            <i class="bi bi-info-circle-fill"></i>
                            Cet aperçu est une simulation. Les informations définitives
                            seront enregistrées après validation.
                        </div>

                    </div>
                </div>

                {{-- AIDE --}}
                <div class="classe-help-card">
                    <div class="classe-help-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <strong>Création sécurisée</strong>
                        <p>
                            Les informations seront soumises à la validation
                            de votre application avant leur enregistrement.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <style>
        /* =====================================================
       CLASSES - CRÉATION
    ===================================================== */

        .classe-create-page {
            --cc-bg: #f4f7fc;
            --cc-card: #ffffff;
            --cc-text: #263449;
            --cc-muted: #8996a7;
            --cc-border: #e8edf4;
            --cc-soft: #f7f9fc;
            --cc-input: #fbfcfe;
            --cc-primary: #2868aa;
            --cc-shadow: 0 5px 22px rgba(31, 55, 85, .055);

            padding: 22px 25px 35px;
            color: var(--cc-text);
        }

        /* HERO */

        .classe-hero {
            background: linear-gradient(115deg, #173b70, #2466a7 65%, #288b9c);
            border-radius: 18px;
            padding: 27px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            color: white;
            box-shadow: 0 9px 25px rgba(26, 74, 125, .17);
        }

        .classe-hero-content {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
        }

        .classe-hero-icon {
            width: 62px;
            height: 62px;
            flex-shrink: 0;
            border-radius: 17px;
            background: rgba(255, 255, 255, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
            border: 1px solid rgba(255, 255, 255, .2);
        }

        .classe-eyebrow {
            font-size: 10px;
            letter-spacing: 2px;
            font-weight: 800;
            opacity: .75;
        }

        .classe-hero h2 {
            font-size: 24px;
            font-weight: 800;
            margin: 4px 0;
            color: white;
        }

        .classe-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
        }

        .classe-back-btn {
            padding: 11px 16px;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: .25s;
            white-space: nowrap;
        }

        .classe-back-btn:hover {
            background: white;
            color: #1d568d;
        }

        /* BREADCRUMB */

        .classe-breadcrumb {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 21px 0;
            font-size: 12px;
            color: var(--cc-muted);
            flex-wrap: wrap;
        }

        .classe-breadcrumb i {
            font-size: 10px;
        }

        .classe-breadcrumb strong {
            color: var(--cc-primary);
        }

        /* GRID */

        .classe-create-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(290px, .85fr);
            gap: 23px;
            align-items: start;
        }

        /* CARTES */

        .classe-form-card,
        .classe-preview-card {
            background: var(--cc-card);
            border: 1px solid var(--cc-border);
            border-radius: 17px;
            box-shadow: var(--cc-shadow);
            overflow: hidden;
        }

        /* EN-TÊTE FORMULAIRE */

        .classe-card-heading {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 23px 25px;
            border-bottom: 1px solid var(--cc-border);
        }

        .classe-heading-icon {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf2fc;
            color: #2868aa;
            font-size: 18px;
        }

        .classe-card-heading h4 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px;
            color: var(--cc-text);
        }

        .classe-card-heading p {
            margin: 0;
            color: var(--cc-muted);
            font-size: 12px;
        }

        .classe-required {
            margin-left: auto;
            font-size: 10px;
            color: var(--cc-muted);
            white-space: nowrap;
        }

        .classe-required span,
        .classe-live-indicator span {
            display: inline-block;
            width: 7px;
            height: 7px;
            background: #e05252;
            border-radius: 50%;
            margin-right: 4px;
        }

        /* CORPS FORMULAIRE */

        .classe-form-body {
            padding: 27px;
        }

        .classe-step {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 29px;
        }

        .classe-step-number {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 11px;
            background: #edf4ff;
            color: #2868aa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12px;
        }

        .classe-step strong {
            font-size: 13px;
            display: block;
            color: var(--cc-text);
        }

        .classe-step p {
            font-size: 11px;
            color: var(--cc-muted);
            margin: 3px 0 0;
        }

        /* INPUT */

        .classe-input-group {
            margin-bottom: 23px;
        }

        .classe-input-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--cc-text);
        }

        .classe-input-wrapper {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--cc-border);
            border-radius: 11px;
            background: var(--cc-input);
            overflow: hidden;
            transition: .25s;
        }

        .classe-input-wrapper:focus-within {
            border-color: #4387cb;
            background: var(--cc-card);
            box-shadow: 0 0 0 4px rgba(67, 135, 203, .10);
        }

        .classe-input-icon {
            width: 49px;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            color: #8294aa;
        }

        .classe-input {
            width: 100%;
            height: 51px;
            border: none;
            outline: none;
            background: transparent;
            padding: 0 13px 0 0;
            font-size: 13px;
            color: var(--cc-text);
        }

        .classe-input::placeholder {
            color: #aab5c3;
        }

        .classe-input.is-invalid {
            color: #dc3545;
        }

        .classe-field-error {
            color: #dc3545;
            font-size: 11px;
            margin-top: 8px;
        }

        .classe-input-help {
            display: block;
            color: var(--cc-muted);
            font-size: 11px;
            margin-top: 10px;
        }

        .classe-input-help i {
            margin-right: 4px;
            color: #4685c2;
        }

        /* CONSEIL */

        .classe-tip {
            display: flex;
            gap: 13px;
            padding: 16px;
            background: #f0f6ff;
            border: 1px solid #e0ebfa;
            border-radius: 12px;
            margin-top: 28px;
        }

        .classe-tip-icon {
            color: #e7a52d;
            font-size: 20px;
            flex-shrink: 0;
        }

        .classe-tip strong {
            font-size: 12px;
            color: #315d91;
        }

        .classe-tip p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #71839b;
            line-height: 1.6;
        }

        /* FOOTER */

        .classe-form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 11px;
            padding-top: 25px;
            margin-top: 26px;
            border-top: 1px solid var(--cc-border);
        }

        .classe-cancel-btn,
        .classe-submit-btn {
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: .25s;
            cursor: pointer;
        }

        .classe-cancel-btn {
            background: var(--cc-soft);
            color: var(--cc-muted);
            border: 1px solid var(--cc-border);
        }

        .classe-cancel-btn:hover {
            background: #e5e9ef;
            color: #35445a;
        }

        .classe-submit-btn {
            border: none;
            color: white;
            background: linear-gradient(110deg, #2465a8, #3189b0);
            box-shadow: 0 5px 13px rgba(37, 105, 168, .2);
        }

        .classe-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37, 105, 168, .28);
        }

        /* APERÇU */

        .classe-preview-column {
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .classe-preview-header {
            padding: 20px 21px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--cc-border);
        }

        .classe-preview-header span {
            color: var(--cc-muted);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .classe-preview-header h5 {
            font-size: 15px;
            font-weight: 800;
            margin: 5px 0 0;
            color: var(--cc-text);
        }

        .classe-live-indicator {
            background: #e9f8f0;
            color: #26935d;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .classe-live-indicator span {
            background: #2db777;
        }

        .classe-preview-content {
            padding: 23px;
        }

        .classe-preview-illustration {
            height: 140px;
            background: linear-gradient(135deg, #eaf3ff, #e9f8f7);
            border-radius: 14px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .classe-preview-circle {
            width: 82px;
            height: 82px;
            background: white;
            color: #3179b5;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            box-shadow: 0 9px 25px rgba(49, 121, 181, .13);
            z-index: 1;
        }

        .classe-preview-decoration {
            position: absolute;
            border-radius: 50%;
            background: rgba(67, 143, 194, .10);
        }

        .decoration-one {
            width: 120px;
            height: 120px;
            left: -30px;
            bottom: -65px;
        }

        .decoration-two {
            width: 90px;
            height: 90px;
            right: -15px;
            top: -35px;
        }

        .classe-preview-label {
            font-size: 9px;
            letter-spacing: 1.5px;
            color: var(--cc-muted);
            font-weight: 800;
        }

        .classe-preview-content h3 {
            font-size: 23px;
            font-weight: 800;
            color: var(--cc-text);
            margin: 8px 0 19px;
            overflow-wrap: anywhere;
        }

        .classe-preview-divider {
            height: 1px;
            background: var(--cc-border);
            margin-bottom: 19px;
        }

        .classe-preview-info {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .classe-info-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .classe-info-icon {
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .classe-info-icon.blue {
            color: #3279b7;
            background: #eaf3fc;
        }

        .classe-info-icon.purple {
            color: #8565bd;
            background: #f1edfb;
        }

        .classe-info-item small {
            display: block;
            font-size: 10px;
            color: var(--cc-muted);
            margin-bottom: 3px;
        }

        .classe-info-item strong {
            font-size: 12px;
            color: var(--cc-text);
        }

        .classe-preview-note {
            margin-top: 23px;
            padding: 12px;
            background: var(--cc-soft);
            border: 1px solid var(--cc-border);
            border-radius: 9px;
            color: var(--cc-muted);
            font-size: 10px;
            line-height: 1.6;
        }

        .classe-preview-note i {
            color: #4786c1;
            margin-right: 5px;
        }

        /* AIDE */

        .classe-help-card {
            display: flex;
            gap: 13px;
            padding: 17px;
            background: var(--cc-card);
            border: 1px solid var(--cc-border);
            border-radius: 14px;
            box-shadow: var(--cc-shadow);
        }

        .classe-help-icon {
            width: 39px;
            height: 39px;
            background: #eaf8f1;
            color: #2d9b68;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            flex-shrink: 0;
        }

        .classe-help-card strong {
            font-size: 12px;
            color: var(--cc-text);
        }

        .classe-help-card p {
            color: var(--cc-muted);
            font-size: 10px;
            line-height: 1.6;
            margin: 5px 0 0;
        }

        /* ALERTES */

        .classe-alert {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #fff1f0;
            color: #b93832;
            border: 1px solid #f6d2cf;
            border-radius: 11px;
            padding: 15px 18px;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .classe-alert>i {
            font-size: 18px;
            flex-shrink: 0;
        }

        /* =====================================================
       MODE SOMBRE
    ===================================================== */

        html[data-app-theme="dark"] .classe-create-page {
            --cc-bg: #111827;
            --cc-card: #1c2738;
            --cc-text: #e5edf8;
            --cc-muted: #9aaac0;
            --cc-border: #344257;
            --cc-soft: #253247;
            --cc-input: #172235;
            --cc-primary: #79b8f2;
            --cc-shadow: 0 5px 22px rgba(0, 0, 0, .16);
        }

        html[data-app-theme="dark"] .classe-heading-icon,
        html[data-app-theme="dark"] .classe-step-number {
            background: #263d5b;
            color: #8fc4fa;
        }

        html[data-app-theme="dark"] .classe-input-wrapper:focus-within {
            background: #1c2738;
            border-color: #5799d5;
        }

        html[data-app-theme="dark"] .classe-input {
            color: #edf4ff;
        }

        html[data-app-theme="dark"] .classe-input::placeholder {
            color: #8191a7;
        }

        html[data-app-theme="dark"] .classe-tip {
            background: #25354b;
            border-color: #3a506d;
        }

        html[data-app-theme="dark"] .classe-tip strong {
            color: #a9d0fa;
        }

        html[data-app-theme="dark"] .classe-tip p {
            color: #b2c1d5;
        }

        html[data-app-theme="dark"] .classe-cancel-btn:hover {
            background: #34445b;
            color: white;
        }

        html[data-app-theme="dark"] .classe-preview-illustration {
            background: linear-gradient(135deg, #263b56, #244747);
        }

        html[data-app-theme="dark"] .classe-preview-circle {
            background: #eaf3ff;
            color: #3179b5;
        }

        html[data-app-theme="dark"] .classe-info-icon.blue {
            background: #263f5d;
            color: #8fc4fa;
        }

        html[data-app-theme="dark"] .classe-info-icon.purple {
            background: #3a3154;
            color: #c2a6fa;
        }

        html[data-app-theme="dark"] .classe-help-icon {
            background: #244638;
            color: #75d6a5;
        }

        html[data-app-theme="dark"] .classe-live-indicator {
            background: #244638;
            color: #75d6a5;
        }

        /* =====================================================
       ULTRA PRO
    ===================================================== */

        html[data-app-theme="ultra-pro"] .classe-create-page {
            --cc-card: #ffffff;
            --cc-text: #172b4d;
            --cc-muted: #71839c;
            --cc-border: #dce5f0;
            --cc-soft: #f0f4fa;
            --cc-input: #f8faff;
            --cc-primary: #315f9b;
            --cc-shadow: 0 8px 28px rgba(25, 50, 85, .09);
        }

        html[data-app-theme="ultra-pro"] .classe-hero {
            background: linear-gradient(115deg, #101f3d, #254b7d 65%, #3a7198);
        }

        html[data-app-theme="ultra-pro"] .classe-submit-btn {
            background: linear-gradient(110deg, #173b70, #3678ad);
        }

        html[data-app-theme="ultra-pro"] .classe-form-card,
        html[data-app-theme="ultra-pro"] .classe-preview-card,
        html[data-app-theme="ultra-pro"] .classe-help-card {
            border-color: #dce5f0;
            box-shadow: 0 8px 28px rgba(25, 50, 85, .09);
        }

        /* =====================================================
       EMERALD
    ===================================================== */

        html[data-app-theme="emerald"] .classe-create-page {
            --cc-primary: #16866b;
        }

        html[data-app-theme="emerald"] .classe-hero {
            background: linear-gradient(115deg, #075b50, #12866c 65%, #35a58a);
        }

        html[data-app-theme="emerald"] .classe-submit-btn {
            background: linear-gradient(110deg, #087c65, #27a58a);
        }

        html[data-app-theme="emerald"] .classe-heading-icon,
        html[data-app-theme="emerald"] .classe-step-number {
            background: #e6f7f1;
            color: #16866b;
        }

        html[data-app-theme="emerald"] .classe-input-wrapper:focus-within {
            border-color: #29a58a;
            box-shadow: 0 0 0 4px rgba(41, 165, 138, .10);
        }

        /* =====================================================
       WARM
    ===================================================== */

        html[data-app-theme="warm"] .classe-create-page {
            --cc-primary: #b66c3e;
        }

        html[data-app-theme="warm"] .classe-hero {
            background: linear-gradient(115deg, #75442e, #b66c3e 65%, #ce9561);
        }

        html[data-app-theme="warm"] .classe-submit-btn {
            background: linear-gradient(110deg, #a75f38, #ce8954);
        }

        html[data-app-theme="warm"] .classe-heading-icon,
        html[data-app-theme="warm"] .classe-step-number {
            background: #fbefe5;
            color: #b66c3e;
        }

        html[data-app-theme="warm"] .classe-input-wrapper:focus-within {
            border-color: #c98555;
            box-shadow: 0 0 0 4px rgba(201, 133, 85, .10);
        }

        /* =====================================================
       RESPONSIVE
    ===================================================== */

        @media (max-width: 900px) {
            .classe-create-grid {
                grid-template-columns: 1fr;
            }

            .classe-preview-column {
                display: grid;
                grid-template-columns: 1fr 1fr;
                align-items: start;
            }
        }

        @media (max-width: 600px) {
            .classe-create-page {
                padding: 13px;
            }

            .classe-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 21px;
            }

            .classe-hero h2 {
                font-size: 19px;
            }

            .classe-hero-icon {
                width: 49px;
                height: 49px;
                font-size: 21px;
            }

            .classe-preview-column {
                display: flex;
            }

            .classe-card-heading {
                flex-wrap: wrap;
                padding: 18px;
            }

            .classe-required {
                width: 100%;
                margin-left: 56px;
            }

            .classe-form-body {
                padding: 19px;
            }

            .classe-form-footer {
                flex-direction: column-reverse;
            }

            .classe-cancel-btn,
            .classe-submit-btn {
                width: 100%;
            }

            .classe-back-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const inputNom = document.getElementById('nom');
            const previewNom = document.getElementById('previewNom');

            if (inputNom && previewNom) {

                function actualiserApercu() {
                    const nom = inputNom.value.trim();

                    previewNom.textContent = nom || 'Nom de votre classe';
                }

                inputNom.addEventListener('input', actualiserApercu);

                actualiserApercu();
            }

        });
    </script>

@endsection
