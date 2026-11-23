@extends('layouts.app')

@section('content')

    <div class="classe-edit-page">

        {{-- EN-TÊTE --}}
        <div class="classe-edit-hero">
            <div class="classe-edit-hero-content">
                <div class="classe-edit-hero-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div>
                    <span class="classe-edit-eyebrow">GESTION SCOLAIRE</span>
                    <h2>Modifier une classe</h2>
                    <p>Mettez à jour les informations de votre classe.</p>
                </div>
            </div>

            <a href="{{ route('classes.index') }}" class="classe-edit-back">
                <i class="bi bi-arrow-left"></i>
                Retour aux classes
            </a>
        </div>

        {{-- NAVIGATION --}}
        <div class="classe-edit-breadcrumb">
            <i class="bi bi-house-door"></i>
            <span>Accueil</span>
            <i class="bi bi-chevron-right"></i>
            <span>Classes</span>
            <i class="bi bi-chevron-right"></i>
            <strong>Modification</strong>
        </div>

        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="classe-edit-alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>Impossible de valider les informations.</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="classe-edit-grid">

            {{-- FORMULAIRE --}}
            <div class="classe-edit-form-card">

                <div class="classe-edit-card-header">
                    <div class="classe-edit-heading-icon">
                        <i class="bi bi-pen-fill"></i>
                    </div>

                    <div>
                        <h4>Informations de la classe</h4>
                        <p>Modifiez les informations nécessaires.</p>
                    </div>

                    <span class="classe-edit-badge">
                        <i class="bi bi-pencil"></i>
                        En modification
                    </span>
                </div>

                <div class="classe-edit-form-body">

                    {{-- IDENTIFIANT --}}
                    <div class="classe-edit-identity">

                        <div class="classe-edit-identity-icon">
                            <i class="bi bi-building"></i>
                        </div>

                        <div class="classe-edit-identity-details">
                            <small>CLASSE SÉLECTIONNÉE</small>
                            <strong>{{ $classe->nom }}</strong>
                        </div>

                        <div class="classe-edit-id">
                            ID #{{ $classe->id }}
                        </div>

                    </div>

                    {{-- ÉTAPE --}}
                    <div class="classe-edit-step">
                        <span>01</span>

                        <div>
                            <strong>Modifier le nom</strong>
                            <p>Renseignez le nouveau nom de la classe.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('classes.update', $classe) }}">

                        @csrf
                        @method('PUT')

                        <div class="classe-edit-input-group">

                            <label for="nom">
                                Nouveau nom de la classe
                                <span class="text-danger">*</span>
                            </label>

                            <div class="classe-edit-input-wrapper">

                                <div class="classe-edit-input-icon">
                                    <i class="bi bi-mortarboard"></i>
                                </div>

                                <input type="text" id="nom" name="nom" value="{{ old('nom', $classe->nom) }}"
                                    class="classe-edit-input @error('nom') is-invalid @enderror"
                                    placeholder="Exemple : Terminale C" maxlength="100" required autofocus
                                    autocomplete="off">

                            </div>

                            @error('nom')
                                <div class="classe-edit-field-error">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="classe-edit-help">
                                <i class="bi bi-info-circle"></i>
                                Le nouveau nom sera enregistré après validation.
                            </small>

                        </div>

                        {{-- COMPARAISON --}}
                        <div class="classe-edit-comparison">

                            <div class="classe-edit-comparison-item">
                                <small>ANCIEN NOM</small>
                                <strong>{{ $classe->nom }}</strong>
                            </div>

                            <div class="classe-edit-comparison-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>

                            <div class="classe-edit-comparison-item">
                                <small>NOUVEAU NOM</small>
                                <strong id="nouveauNom">
                                    {{ old('nom', $classe->nom) }}
                                </strong>
                            </div>

                        </div>

                        {{-- CONSEIL --}}
                        <div class="classe-edit-tip">

                            <div class="classe-edit-tip-icon">
                                <i class="bi bi-lightbulb-fill"></i>
                            </div>

                            <div>
                                <strong>À savoir</strong>
                                <p>
                                    La modification concerne le nom de la classe.
                                    Vérifiez les informations avant de confirmer.
                                </p>
                            </div>

                        </div>

                        {{-- BOUTONS --}}
                        <div class="classe-edit-form-footer">

                            <a href="{{ route('classes.index') }}" class="classe-edit-cancel">
                                <i class="bi bi-x-lg"></i>
                                Annuler
                            </a>

                            <button type="submit" class="classe-edit-submit">
                                <i class="bi bi-floppy-fill"></i>
                                Enregistrer les modifications
                            </button>

                        </div>

                    </form>

                </div>
            </div>

            {{-- APERÇU --}}
            <div class="classe-edit-preview-column">

                <div class="classe-edit-preview-card">

                    <div class="classe-edit-preview-header">

                        <div>
                            <span>APERÇU EN DIRECT</span>
                            <h5>Nouvelle présentation</h5>
                        </div>

                        <div class="classe-edit-live">
                            <span></span>
                            Live
                        </div>

                    </div>

                    <div class="classe-edit-preview-content">

                        <div class="classe-edit-illustration">

                            <div class="classe-edit-illustration-circle">
                                <i class="bi bi-building"></i>
                            </div>

                            <div class="classe-edit-decoration one"></div>
                            <div class="classe-edit-decoration two"></div>

                        </div>

                        <span class="classe-edit-preview-label">
                            NOM DE LA CLASSE
                        </span>

                        <h3 id="apercuClasse">
                            {{ old('nom', $classe->nom) }}
                        </h3>

                        <div class="classe-edit-preview-divider"></div>

                        <div class="classe-edit-preview-info">

                            <div class="classe-edit-info-item">

                                <div class="classe-edit-info-icon blue">
                                    <i class="bi bi-people-fill"></i>
                                </div>

                                <div>
                                    <small>Effectif</small>
                                    <strong>
                                        {{ $classe->eleves_count ?? $classe->eleves()->count() }}
                                        élève(s)
                                    </strong>
                                </div>

                            </div>

                            <div class="classe-edit-info-item">

                                <div class="classe-edit-info-icon purple">
                                    <i class="bi bi-fingerprint"></i>
                                </div>

                                <div>
                                    <small>Identifiant</small>
                                    <strong>#{{ $classe->id }}</strong>
                                </div>

                            </div>

                            <div class="classe-edit-info-item">

                                <div class="classe-edit-info-icon green">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>

                                <div>
                                    <small>État</small>
                                    <strong>Classe existante</strong>
                                </div>

                            </div>

                        </div>

                        <div class="classe-edit-preview-note">
                            <i class="bi bi-info-circle-fill"></i>
                            L'aperçu se met automatiquement à jour lorsque
                            vous modifiez le nom.
                        </div>

                    </div>

                </div>

                {{-- SÉCURITÉ --}}
                <div class="classe-edit-security">

                    <div class="classe-edit-security-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <div>
                        <strong>Modification sécurisée</strong>
                        <p>
                            Les données ne seront modifiées qu'après
                            validation du formulaire.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <style>
        /* =====================================================
       CLASSES - MODIFICATION
    ===================================================== */

        .classe-edit-page {
            --ce-card: #ffffff;
            --ce-text: #263449;
            --ce-muted: #8996a7;
            --ce-border: #e8edf4;
            --ce-soft: #f7f9fc;
            --ce-input: #fbfcfe;
            --ce-primary: #2868aa;
            --ce-shadow: 0 5px 22px rgba(31, 55, 85, .055);

            padding: 22px 25px 35px;
            color: var(--ce-text);
        }

        /* HERO */

        .classe-edit-hero {
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

        .classe-edit-hero-content {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
        }

        .classe-edit-hero-icon {
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

        .classe-edit-eyebrow {
            font-size: 10px;
            letter-spacing: 2px;
            font-weight: 800;
            opacity: .75;
        }

        .classe-edit-hero h2 {
            font-size: 24px;
            font-weight: 800;
            margin: 4px 0;
            color: white;
        }

        .classe-edit-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
        }

        .classe-edit-back {
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

        .classe-edit-back:hover {
            background: white;
            color: #1d568d;
        }

        /* BREADCRUMB */

        .classe-edit-breadcrumb {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 21px 0;
            font-size: 12px;
            color: var(--ce-muted);
            flex-wrap: wrap;
        }

        .classe-edit-breadcrumb i {
            font-size: 10px;
        }

        .classe-edit-breadcrumb strong {
            color: var(--ce-primary);
        }

        /* GRID */

        .classe-edit-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(290px, .85fr);
            gap: 23px;
            align-items: start;
        }

        /* CARDS */

        .classe-edit-form-card,
        .classe-edit-preview-card {
            background: var(--ce-card);
            border: 1px solid var(--ce-border);
            border-radius: 17px;
            box-shadow: var(--ce-shadow);
            overflow: hidden;
        }

        /* CARD HEADER */

        .classe-edit-card-header {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 23px 25px;
            border-bottom: 1px solid var(--ce-border);
        }

        .classe-edit-heading-icon {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff5df;
            color: #d39a2d;
            font-size: 18px;
        }

        .classe-edit-card-header h4 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px;
            color: var(--ce-text);
        }

        .classe-edit-card-header p {
            margin: 0;
            color: var(--ce-muted);
            font-size: 12px;
        }

        .classe-edit-badge {
            margin-left: auto;
            padding: 7px 10px;
            background: #fff5df;
            color: #b7811f;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* FORM */

        .classe-edit-form-body {
            padding: 27px;
        }

        /* IDENTITÉ */

        .classe-edit-identity {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: var(--ce-soft);
            border: 1px solid var(--ce-border);
            border-radius: 12px;
            margin-bottom: 27px;
        }

        .classe-edit-identity-icon {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #e6f0fc;
            color: #3478b6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .classe-edit-identity-details {
            min-width: 0;
        }

        .classe-edit-identity small {
            display: block;
            font-size: 9px;
            color: var(--ce-muted);
            letter-spacing: 1px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .classe-edit-identity strong {
            font-size: 13px;
            color: var(--ce-text);
            overflow-wrap: anywhere;
        }

        .classe-edit-id {
            margin-left: auto;
            background: var(--ce-card);
            border: 1px solid var(--ce-border);
            padding: 6px 9px;
            border-radius: 7px;
            color: var(--ce-muted);
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* STEP */

        .classe-edit-step {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 28px;
        }

        .classe-edit-step>span {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 11px;
            background: #fff5df;
            color: #c18c27;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12px;
        }

        .classe-edit-step strong {
            font-size: 13px;
            color: var(--ce-text);
        }

        .classe-edit-step p {
            font-size: 11px;
            color: var(--ce-muted);
            margin: 3px 0 0;
        }

        /* INPUT */

        .classe-edit-input-group {
            margin-bottom: 22px;
        }

        .classe-edit-input-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--ce-text);
        }

        .classe-edit-input-wrapper {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--ce-border);
            border-radius: 11px;
            background: var(--ce-input);
            overflow: hidden;
            transition: .25s;
        }

        .classe-edit-input-wrapper:focus-within {
            border-color: #4387cb;
            background: var(--ce-card);
            box-shadow: 0 0 0 4px rgba(67, 135, 203, .10);
        }

        .classe-edit-input-icon {
            width: 49px;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            color: #8294aa;
        }

        .classe-edit-input {
            width: 100%;
            height: 51px;
            border: none;
            outline: none;
            background: transparent;
            padding: 0 13px 0 0;
            font-size: 13px;
            color: var(--ce-text);
        }

        .classe-edit-input::placeholder {
            color: #aab5c3;
        }

        .classe-edit-input.is-invalid {
            color: #dc3545;
        }

        .classe-edit-help {
            display: block;
            color: var(--ce-muted);
            font-size: 11px;
            margin-top: 10px;
        }

        .classe-edit-help i {
            color: #4685c2;
            margin-right: 4px;
        }

        .classe-edit-field-error {
            color: #dc3545;
            font-size: 11px;
            margin-top: 8px;
        }

        /* COMPARAISON */

        .classe-edit-comparison {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 35px minmax(0, 1fr);
            align-items: center;
            gap: 9px;
            padding: 16px;
            background: var(--ce-soft);
            border: 1px solid var(--ce-border);
            border-radius: 12px;
        }

        .classe-edit-comparison-item {
            min-width: 0;
        }

        .classe-edit-comparison small {
            display: block;
            color: var(--ce-muted);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .8px;
            margin-bottom: 7px;
        }

        .classe-edit-comparison strong {
            display: block;
            color: var(--ce-text);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .classe-edit-comparison-arrow {
            color: #4387cb;
            text-align: center;
            font-size: 20px;
        }

        /* CONSEIL */

        .classe-edit-tip {
            display: flex;
            gap: 13px;
            padding: 16px;
            background: #fff9ec;
            border: 1px solid #f5ebd2;
            border-radius: 12px;
            margin-top: 23px;
        }

        .classe-edit-tip-icon {
            color: #e2a42d;
            font-size: 20px;
            flex-shrink: 0;
        }

        .classe-edit-tip strong {
            font-size: 12px;
            color: #916b24;
        }

        .classe-edit-tip p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #96866a;
            line-height: 1.6;
        }

        /* BOUTONS */

        .classe-edit-form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 11px;
            padding-top: 25px;
            margin-top: 26px;
            border-top: 1px solid var(--ce-border);
        }

        .classe-edit-cancel,
        .classe-edit-submit {
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

        .classe-edit-cancel {
            background: var(--ce-soft);
            border: 1px solid var(--ce-border);
            color: var(--ce-muted);
        }

        .classe-edit-cancel:hover {
            background: #e5e9ef;
            color: #35445a;
        }

        .classe-edit-submit {
            border: none;
            color: white;
            background: linear-gradient(110deg, #bd8421, #e0a83f);
            box-shadow: 0 5px 13px rgba(190, 137, 36, .2);
        }

        .classe-edit-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(190, 137, 36, .28);
        }

        /* APERÇU */

        .classe-edit-preview-column {
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .classe-edit-preview-header {
            padding: 20px 21px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--ce-border);
        }

        .classe-edit-preview-header span {
            color: var(--ce-muted);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .classe-edit-preview-header h5 {
            font-size: 15px;
            font-weight: 800;
            margin: 5px 0 0;
            color: var(--ce-text);
        }

        .classe-edit-live {
            background: #e9f8f0;
            color: #26935d;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .classe-edit-live span {
            display: inline-block;
            width: 7px;
            height: 7px;
            background: #2db777;
            border-radius: 50%;
            margin-right: 4px;
        }

        .classe-edit-preview-content {
            padding: 23px;
        }

        .classe-edit-illustration {
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

        .classe-edit-illustration-circle {
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

        .classe-edit-decoration {
            position: absolute;
            border-radius: 50%;
            background: rgba(67, 143, 194, .10);
        }

        .classe-edit-decoration.one {
            width: 120px;
            height: 120px;
            left: -30px;
            bottom: -65px;
        }

        .classe-edit-decoration.two {
            width: 90px;
            height: 90px;
            right: -15px;
            top: -35px;
        }

        .classe-edit-preview-label {
            font-size: 9px;
            letter-spacing: 1.5px;
            color: var(--ce-muted);
            font-weight: 800;
        }

        .classe-edit-preview-content h3 {
            font-size: 23px;
            font-weight: 800;
            color: var(--ce-text);
            margin: 8px 0 19px;
            overflow-wrap: anywhere;
        }

        .classe-edit-preview-divider {
            height: 1px;
            background: var(--ce-border);
            margin-bottom: 19px;
        }

        .classe-edit-preview-info {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .classe-edit-info-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .classe-edit-info-icon {
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .classe-edit-info-icon.blue {
            color: #3279b7;
            background: #eaf3fc;
        }

        .classe-edit-info-icon.purple {
            color: #8565bd;
            background: #f1edfb;
        }

        .classe-edit-info-icon.green {
            color: #269b68;
            background: #e9f8f0;
        }

        .classe-edit-info-item small {
            display: block;
            font-size: 10px;
            color: var(--ce-muted);
            margin-bottom: 3px;
        }

        .classe-edit-info-item strong {
            font-size: 12px;
            color: var(--ce-text);
        }

        .classe-edit-preview-note {
            margin-top: 23px;
            padding: 12px;
            background: var(--ce-soft);
            border: 1px solid var(--ce-border);
            border-radius: 9px;
            color: var(--ce-muted);
            font-size: 10px;
            line-height: 1.6;
        }

        .classe-edit-preview-note i {
            color: #4786c1;
            margin-right: 5px;
        }

        /* SÉCURITÉ */

        .classe-edit-security {
            display: flex;
            gap: 13px;
            padding: 17px;
            background: var(--ce-card);
            border: 1px solid var(--ce-border);
            border-radius: 14px;
            box-shadow: var(--ce-shadow);
        }

        .classe-edit-security-icon {
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

        .classe-edit-security strong {
            font-size: 12px;
            color: var(--ce-text);
        }

        .classe-edit-security p {
            color: var(--ce-muted);
            font-size: 10px;
            line-height: 1.6;
            margin: 5px 0 0;
        }

        /* ALERTES */

        .classe-edit-alert {
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

        .classe-edit-alert>i {
            font-size: 18px;
            flex-shrink: 0;
        }

        /* =====================================================
       MODE SOMBRE
    ===================================================== */

        html[data-app-theme="dark"] .classe-edit-page {
            --ce-card: #1c2738;
            --ce-text: #e5edf8;
            --ce-muted: #9aaac0;
            --ce-border: #344257;
            --ce-soft: #253247;
            --ce-input: #172235;
            --ce-primary: #79b8f2;
            --ce-shadow: 0 5px 22px rgba(0, 0, 0, .16);
        }

        html[data-app-theme="dark"] .classe-edit-heading-icon,
        html[data-app-theme="dark"] .classe-edit-step>span {
            background: #493c27;
            color: #f1c46b;
        }

        html[data-app-theme="dark"] .classe-edit-badge {
            background: #493c27;
            color: #f1c46b;
        }

        html[data-app-theme="dark"] .classe-edit-identity-icon {
            background: #263f5d;
            color: #8fc4fa;
        }

        html[data-app-theme="dark"] .classe-edit-input-wrapper:focus-within {
            background: #1c2738;
            border-color: #5799d5;
        }

        html[data-app-theme="dark"] .classe-edit-input {
            color: #edf4ff;
        }

        html[data-app-theme="dark"] .classe-edit-input::placeholder {
            color: #8191a7;
        }

        html[data-app-theme="dark"] .classe-edit-id {
            background: #1c2738;
            border-color: #43536a;
            color: #b2c1d5;
        }

        html[data-app-theme="dark"] .classe-edit-comparison {
            background: #172235;
        }

        html[data-app-theme="dark"] .classe-edit-comparison-arrow {
            color: #8fc4fa;
        }

        html[data-app-theme="dark"] .classe-edit-tip {
            background: #3d3425;
            border-color: #63502e;
        }

        html[data-app-theme="dark"] .classe-edit-tip strong {
            color: #f1cc7d;
        }

        html[data-app-theme="dark"] .classe-edit-tip p {
            color: #d0bd98;
        }

        html[data-app-theme="dark"] .classe-edit-illustration {
            background: linear-gradient(135deg, #263b56, #244747);
        }

        html[data-app-theme="dark"] .classe-edit-illustration-circle {
            background: #eaf3ff;
            color: #3179b5;
        }

        html[data-app-theme="dark"] .classe-edit-info-icon.blue {
            background: #263f5d;
            color: #8fc4fa;
        }

        html[data-app-theme="dark"] .classe-edit-info-icon.purple {
            background: #3a3154;
            color: #c2a6fa;
        }

        html[data-app-theme="dark"] .classe-edit-info-icon.green,
        html[data-app-theme="dark"] .classe-edit-security-icon {
            background: #244638;
            color: #75d6a5;
        }

        html[data-app-theme="dark"] .classe-edit-live {
            background: #244638;
            color: #75d6a5;
        }

        html[data-app-theme="dark"] .classe-edit-cancel:hover {
            background: #34445b;
            color: white;
        }

        /* =====================================================
       ULTRA PRO
    ===================================================== */

        html[data-app-theme="ultra-pro"] .classe-edit-page {
            --ce-card: #ffffff;
            --ce-text: #172b4d;
            --ce-muted: #71839c;
            --ce-border: #dce5f0;
            --ce-soft: #f0f4fa;
            --ce-input: #f8faff;
            --ce-primary: #315f9b;
            --ce-shadow: 0 8px 28px rgba(25, 50, 85, .09);
        }

        html[data-app-theme="ultra-pro"] .classe-edit-hero {
            background: linear-gradient(115deg, #101f3d, #254b7d 65%, #3a7198);
        }

        html[data-app-theme="ultra-pro"] .classe-edit-form-card,
        html[data-app-theme="ultra-pro"] .classe-edit-preview-card,
        html[data-app-theme="ultra-pro"] .classe-edit-security {
            border-color: #dce5f0;
            box-shadow: 0 8px 28px rgba(25, 50, 85, .09);
        }

        /* =====================================================
       EMERALD
    ===================================================== */

        html[data-app-theme="emerald"] .classe-edit-page {
            --ce-primary: #16866b;
        }

        html[data-app-theme="emerald"] .classe-edit-hero {
            background: linear-gradient(115deg, #075b50, #12866c 65%, #35a58a);
        }

        html[data-app-theme="emerald"] .classe-edit-submit {
            background: linear-gradient(110deg, #087c65, #27a58a);
        }

        html[data-app-theme="emerald"] .classe-edit-heading-icon,
        html[data-app-theme="emerald"] .classe-edit-step>span {
            background: #e6f7f1;
            color: #16866b;
        }

        html[data-app-theme="emerald"] .classe-edit-input-wrapper:focus-within {
            border-color: #29a58a;
            box-shadow: 0 0 0 4px rgba(41, 165, 138, .10);
        }

        html[data-app-theme="emerald"] .classe-edit-breadcrumb strong {
            color: #16866b;
        }

        /* =====================================================
       WARM
    ===================================================== */

        html[data-app-theme="warm"] .classe-edit-page {
            --ce-primary: #b66c3e;
        }

        html[data-app-theme="warm"] .classe-edit-hero {
            background: linear-gradient(115deg, #75442e, #b66c3e 65%, #ce9561);
        }

        html[data-app-theme="warm"] .classe-edit-submit {
            background: linear-gradient(110deg, #a75f38, #ce8954);
        }

        html[data-app-theme="warm"] .classe-edit-heading-icon,
        html[data-app-theme="warm"] .classe-edit-step>span {
            background: #fbefe5;
            color: #b66c3e;
        }

        html[data-app-theme="warm"] .classe-edit-input-wrapper:focus-within {
            border-color: #c98555;
            box-shadow: 0 0 0 4px rgba(201, 133, 85, .10);
        }

        html[data-app-theme="warm"] .classe-edit-breadcrumb strong {
            color: #b66c3e;
        }

        /* =====================================================
       RESPONSIVE
    ===================================================== */

        @media (max-width: 900px) {
            .classe-edit-grid {
                grid-template-columns: 1fr;
            }

            .classe-edit-preview-column {
                display: grid;
                grid-template-columns: 1fr 1fr;
                align-items: start;
            }
        }

        @media (max-width: 600px) {

            .classe-edit-page {
                padding: 13px;
            }

            .classe-edit-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 21px;
            }

            .classe-edit-hero h2 {
                font-size: 19px;
            }

            .classe-edit-hero-icon {
                width: 49px;
                height: 49px;
                font-size: 21px;
            }

            .classe-edit-back {
                width: 100%;
                text-align: center;
            }

            .classe-edit-preview-column {
                display: flex;
            }

            .classe-edit-card-header {
                flex-wrap: wrap;
                padding: 18px;
            }

            .classe-edit-badge {
                margin-left: 56px;
            }

            .classe-edit-form-body {
                padding: 19px;
            }

            .classe-edit-form-footer {
                flex-direction: column-reverse;
            }

            .classe-edit-cancel,
            .classe-edit-submit {
                width: 100%;
            }

            .classe-edit-comparison {
                grid-template-columns: 1fr;
                gap: 13px;
            }

            .classe-edit-comparison-arrow {
                transform: rotate(90deg);
            }

            .classe-edit-identity {
                flex-wrap: wrap;
            }

            .classe-edit-id {
                margin-left: auto;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const inputNom = document.getElementById('nom');
            const apercuClasse = document.getElementById('apercuClasse');
            const nouveauNom = document.getElementById('nouveauNom');

            if (inputNom) {

                function actualiserApercu() {

                    const nom = inputNom.value.trim();
                    const valeur = nom || 'Nom de votre classe';

                    if (apercuClasse) {
                        apercuClasse.textContent = valeur;
                    }

                    if (nouveauNom) {
                        nouveauNom.textContent = valeur;
                    }
                }

                inputNom.addEventListener('input', actualiserApercu);

                actualiserApercu();
            }

        });
    </script>

@endsection
