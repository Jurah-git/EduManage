@extends('layouts.app')

@section('content')

    <style>
        /* =========================================================
       MATIERE CREATE - VARIABLES
    ========================================================= */

        .matiere-create-page {
            --mc-surface: #ffffff;
            --mc-surface-soft: #f7f9fc;
            --mc-text: #34445b;
            --mc-heading: #243b59;
            --mc-muted: #8794a7;
            --mc-border: #e6ebf2;
            --mc-primary: #2868aa;
            --mc-primary-soft: #eaf2ff;
            --mc-shadow: 0 8px 25px rgba(20, 40, 70, .06);

            padding: 24px;
            max-width: 1250px;
            margin: auto;
            color: var(--mc-text);
        }

        /* =========================================================
       HERO
    ========================================================= */

        .matiere-hero {
            position: relative;
            overflow: hidden;
            padding: 30px 34px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(120deg, #173b70, #2563a6 60%, #0e9b9a);
            box-shadow: 0 12px 30px rgba(23, 59, 112, .18);
            margin-bottom: 25px;
        }

        .matiere-hero::after {
            content: "\f02d";
            font-family: "bootstrap-icons";
            font-weight: normal;
            position: absolute;
            right: 45px;
            top: 15px;
            font-size: 115px;
            opacity: .10;
            transform: rotate(-12deg);
            pointer-events: none;
        }

        .matiere-hero-content {
            position: relative;
            z-index: 1;
        }

        .matiere-hero-icon {
            width: 49px;
            height: 49px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .2);
            font-size: 23px;
        }

        .matiere-hero-eyebrow {
            font-size: 10px;
            letter-spacing: 1.8px;
            font-weight: 800;
            color: rgba(255, 255, 255, .8);
        }

        .matiere-hero h3 {
            font-size: 25px;
            font-weight: 800;
            margin: 12px 0 8px;
            position: relative;
            z-index: 1;
            color: white;
        }

        .matiere-hero p {
            margin: 0;
            opacity: .85;
            font-size: 13px;
            position: relative;
            z-index: 1;
            max-width: 650px;
        }

        /* =========================================================
       BREADCRUMB
    ========================================================= */

        .matiere-breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: -7px 0 20px;
            color: var(--mc-muted);
            font-size: 12px;
        }

        .matiere-breadcrumb i {
            font-size: 10px;
        }

        .matiere-breadcrumb strong {
            color: var(--mc-primary);
        }

        /* =========================================================
       ALERTES
    ========================================================= */

        .matiere-alert {
            border-radius: 11px;
            font-size: 13px;
            padding: 15px 18px;
            border: 1px solid #f1c9c9;
            background: #fff1f0;
            color: #b93832;
        }

        .matiere-alert .alert-heading {
            font-size: 13px;
        }

        .matiere-alert ul {
            margin-top: 7px;
        }

        /* =========================================================
       CARTE PRINCIPALE
    ========================================================= */

        .matiere-form-card {
            background: var(--mc-surface);
            border: 1px solid var(--mc-border);
            border-radius: 18px;
            box-shadow: var(--mc-shadow);
            overflow: hidden;
        }

        /* =========================================================
       EN-TÊTES DES SECTIONS
    ========================================================= */

        .matiere-section-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--mc-border);
            display: flex;
            align-items: center;
            gap: 13px;
            background: var(--mc-surface);
        }

        .matiere-section-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--mc-primary-soft);
            color: var(--mc-primary);
            font-size: 19px;
            flex-shrink: 0;
        }

        .matiere-section-header h5 {
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 4px;
            color: var(--mc-heading);
        }

        .matiere-section-header p {
            margin: 0;
            color: var(--mc-muted);
            font-size: 11px;
        }

        /* =========================================================
       CORPS DU FORMULAIRE
    ========================================================= */

        .matiere-form-body {
            padding: 27px;
        }

        .matiere-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--mc-text);
            margin-bottom: 9px;
        }

        .matiere-input {
            height: 49px;
            border-radius: 11px;
            border: 1px solid var(--mc-border);
            padding: 10px 15px;
            font-size: 13px;
            background: var(--mc-surface);
            color: var(--mc-text);
            transition: .2s;
        }

        .matiere-input::placeholder {
            color: var(--mc-muted);
            opacity: .8;
        }

        .matiere-input:focus {
            border-color: #3478c5;
            box-shadow: 0 0 0 3px rgba(52, 120, 197, .10);
            background: var(--mc-surface);
            color: var(--mc-text);
        }

        .matiere-help {
            color: var(--mc-muted);
            font-size: 11px;
            margin-top: 8px;
        }

        /* =========================================================
       STATISTIQUE CLASSES DISPONIBLES
    ========================================================= */

        .matiere-stat {
            height: 100%;
            padding: 18px;
            border-radius: 13px;
            background: var(--mc-surface-soft);
            border: 1px solid var(--mc-border);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .matiere-stat-label {
            font-size: 10px;
            color: var(--mc-muted);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .matiere-stat-value {
            font-size: 27px;
            font-weight: 800;
            color: var(--mc-heading);
            margin-top: 5px;
        }

        .matiere-stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--mc-primary-soft);
            color: var(--mc-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 17px;
        }

        /* =========================================================
       BARRE DES CLASSES
    ========================================================= */

        .classes-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 17px;
        }

        .classes-toolbar-title {
            font-size: 13px;
            font-weight: 800;
            color: var(--mc-heading);
        }

        .classes-toolbar-subtitle {
            color: var(--mc-muted);
            font-size: 11px;
            margin-top: 4px;
        }

        .classes-toolbar-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .classes-toolbar-actions button {
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            padding: 8px 12px;
        }

        /* =========================================================
       RECHERCHE
    ========================================================= */

        .classes-search {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin-bottom: 15px;
        }

        .classes-search>i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--mc-muted);
            font-size: 13px;
        }

        .classes-search input {
            width: 100%;
            height: 42px;
            padding: 8px 13px 8px 39px;
            border: 1px solid var(--mc-border);
            border-radius: 10px;
            outline: none;
            font-size: 12px;
            background: var(--mc-surface);
            color: var(--mc-text);
            transition: .2s;
        }

        .classes-search input::placeholder {
            color: var(--mc-muted);
        }

        .classes-search input:focus {
            border-color: #3478c5;
            box-shadow: 0 0 0 3px rgba(52, 120, 197, .09);
        }

        /* =========================================================
       ZONE DE SÉLECTION
    ========================================================= */

        .class-selection-box {
            padding: 18px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            background: var(--mc-surface-soft);
        }

        .class-column {
            transition: .2s;
        }

        .class-item {
            height: 100%;
            padding: 14px;
            background: var(--mc-surface);
            border: 1px solid var(--mc-border);
            border-radius: 11px;
            transition: .2s;
            cursor: pointer;
        }

        .class-item:hover {
            border-color: #8bb6e8;
            transform: translateY(-2px);
            box-shadow: 0 5px 13px rgba(40, 90, 150, .07);
        }

        .class-item.selected {
            border-color: #3982cf;
            background: var(--mc-primary-soft);
            box-shadow: 0 0 0 1px rgba(57, 130, 207, .08);
        }

        .class-item .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            min-height: 22px;
        }

        .class-item .form-check-input {
            width: 17px;
            height: 17px;
            margin: 0;
            cursor: pointer;
            flex-shrink: 0;
            accent-color: var(--mc-primary);
        }

        .class-item .form-check-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--mc-text);
            cursor: pointer;
            flex: 1;
        }

        .class-item .form-check-label i {
            color: var(--mc-primary) !important;
        }

        .class-empty {
            display: none;
            text-align: center;
            padding: 30px;
            color: var(--mc-muted);
            font-size: 12px;
        }

        .class-empty i {
            color: var(--mc-primary);
        }

        /* =========================================================
       RÉSUMÉ DE SÉLECTION
    ========================================================= */

        .selection-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 13px 16px;
            background: var(--mc-primary-soft);
            border: 1px solid var(--mc-border);
            border-radius: 11px;
            margin-top: 16px;
        }

        .selection-summary strong {
            color: var(--mc-primary);
            font-size: 12px;
        }

        .selection-summary>span {
            color: var(--mc-muted);
            font-size: 11px;
        }

        .selection-summary-icon {
            color: #299769;
            margin-right: 7px;
        }

        /* =========================================================
       ÉTAT SANS CLASSE
    ========================================================= */

        .matiere-no-classes {
            text-align: center;
            padding: 35px 15px;
            color: var(--mc-muted);
        }

        .matiere-no-classes-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 13px;
            border-radius: 18px;
            background: var(--mc-primary-soft);
            color: var(--mc-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .matiere-no-classes h6 {
            font-size: 14px;
            font-weight: 800;
            color: var(--mc-heading);
        }

        .matiere-no-classes p {
            font-size: 11px;
            margin-bottom: 0;
        }

        /* =========================================================
       FOOTER
    ========================================================= */

        .matiere-form-footer {
            padding: 20px 27px;
            background: var(--mc-surface-soft);
            border-top: 1px solid var(--mc-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .matiere-btn {
            border-radius: 10px;
            padding: 11px 19px;
            font-size: 12px;
            font-weight: 700;
            transition: .2s;
        }

        .matiere-btn-primary {
            color: white;
            border: 0;
            background: linear-gradient(120deg, #2563a6, #168e9b);
            box-shadow: 0 5px 12px rgba(37, 99, 166, .18);
        }

        .matiere-btn-primary:hover {
            color: white;
            opacity: .92;
            transform: translateY(-2px);
        }

        .matiere-btn-light {
            background: var(--mc-surface);
            border: 1px solid var(--mc-border);
            color: var(--mc-text);
        }

        .matiere-btn-light:hover {
            background: var(--mc-surface-soft);
            color: var(--mc-heading);
            transform: translateY(-1px);
        }

        /* =========================================================
       MODE SOMBRE
    ========================================================= */

        html[data-app-theme="dark"] .matiere-create-page {
            --mc-surface: #1b2637;
            --mc-surface-soft: #222f42;
            --mc-text: #dce5f1;
            --mc-heading: #f0f5fc;
            --mc-muted: #a0aec0;
            --mc-border: #344257;
            --mc-primary: #76b8f5;
            --mc-primary-soft: #263e59;
            --mc-shadow: 0 8px 25px rgba(0, 0, 0, .2);
        }

        html[data-app-theme="dark"] .matiere-hero {
            background: linear-gradient(120deg, #14243c, #1d456b 60%, #17616a);
            border: 1px solid rgba(148, 190, 230, .13);
        }

        html[data-app-theme="dark"] .matiere-alert {
            background: #462a2d;
            border-color: #714044;
            color: #ffaaa5;
        }

        html[data-app-theme="dark"] .class-item.selected {
            background: #263e59;
            border-color: #579bd8;
        }

        html[data-app-theme="dark"] .classes-toolbar-actions .btn-success {
            background: #1f664d;
            border-color: #287c5d;
        }

        html[data-app-theme="dark"] .classes-toolbar-actions .btn-outline-danger {
            color: #ff9d9d;
            border-color: #87474d;
        }

        html[data-app-theme="dark"] .matiere-stat-icon {
            background: #263e59;
            color: #83bdf2;
        }

        /* =========================================================
       MODE ULTRA PRO
    ========================================================= */

        html[data-app-theme="ultra-pro"] .matiere-create-page {
            --mc-surface: #111d31;
            --mc-surface-soft: #17263d;
            --mc-text: #dbe8f7;
            --mc-heading: #f3f8ff;
            --mc-muted: #91a5bf;
            --mc-border: #293d59;
            --mc-primary: #56b9f5;
            --mc-primary-soft: #1d3c5b;
            --mc-shadow: 0 8px 30px rgba(0, 0, 0, .22);
        }

        html[data-app-theme="ultra-pro"] .matiere-hero {
            background: linear-gradient(120deg, #09182d, #123d66 60%, #087c89);
            border: 1px solid rgba(91, 190, 255, .18);
        }

        html[data-app-theme="ultra-pro"] .matiere-alert {
            background: #462a2d;
            border-color: #714044;
            color: #ffaaa5;
        }

        html[data-app-theme="ultra-pro"] .class-item.selected {
            background: #1d3c5b;
            border-color: #56a6e5;
        }

        html[data-app-theme="ultra-pro"] .matiere-stat-icon {
            background: #1c3c5e;
            color: #72c5ff;
        }

        html[data-app-theme="ultra-pro"] .classes-toolbar-actions .btn-success {
            background: #17664f;
            border-color: #287c5d;
        }

        html[data-app-theme="ultra-pro"] .classes-toolbar-actions .btn-outline-danger {
            color: #ff9d9d;
            border-color: #87474d;
        }

        /* =========================================================
       THÈME EMERALD
    ========================================================= */

        html[data-app-theme="emerald"] .matiere-create-page {
            --mc-primary: #168568;
            --mc-primary-soft: #e6f6f0;
        }

        html[data-app-theme="emerald"] .matiere-hero {
            background: linear-gradient(120deg, #075b4a, #13866b 60%, #36a58a);
        }

        /* =========================================================
       THÈME WARM
    ========================================================= */

        html[data-app-theme="warm"] .matiere-create-page {
            --mc-primary: #a66a35;
            --mc-primary-soft: #fbf0e4;
        }

        html[data-app-theme="warm"] .matiere-hero {
            background: linear-gradient(120deg, #70452e, #a66a35 60%, #c28b56);
        }

        /* =========================================================
       RESPONSIVE
    ========================================================= */

        @media(max-width: 768px) {

            .matiere-create-page {
                padding: 14px;
            }

            .matiere-hero {
                padding: 24px;
            }

            .matiere-hero h3 {
                font-size: 21px;
            }

            .matiere-form-body {
                padding: 18px;
            }

            .matiere-form-footer {
                padding: 17px;
            }

            .matiere-section-header {
                padding: 17px 18px;
            }

            .classes-toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .classes-toolbar-actions {
                width: 100%;
            }

            .classes-toolbar-actions button {
                flex: 1;
            }

            .classes-search {
                max-width: 100%;
            }
        }

        @media(max-width: 480px) {

            .matiere-hero {
                padding: 20px;
            }

            .matiere-hero h3 {
                font-size: 19px;
            }

            .matiere-hero::after {
                right: 10px;
                font-size: 85px;
            }

            .matiere-form-body {
                padding: 15px;
            }

            .class-selection-box {
                padding: 11px;
            }

            .matiere-form-footer {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .matiere-form-footer .matiere-btn {
                width: 100%;
                justify-content: center;
            }

            .selection-summary {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>


    <div class="matiere-create-page">

        {{-- EN-TÊTE --}}
        <div class="matiere-hero">

            <div class="matiere-hero-content">

                <div class="d-flex align-items-center gap-3">
                    <div class="matiere-hero-icon">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>

                    <span class="matiere-hero-eyebrow">
                        GESTION PÉDAGOGIQUE
                    </span>
                </div>

                <h3>Ajouter une nouvelle matière</h3>

                <p>
                    Configurez les informations de la matière et choisissez
                    les classes auxquelles elle sera enseignée.
                </p>

            </div>

        </div>

        {{-- FIL D'ARIANE --}}
        <div class="matiere-breadcrumb">
            <i class="bi bi-house-door"></i>
            <span>Accueil</span>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('matieres.index') }}" class="text-decoration-none" style="color:inherit;">
                Matières
            </a>
            <i class="bi bi-chevron-right"></i>
            <strong>Ajouter</strong>
        </div>

        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="alert matiere-alert mb-4">
                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    Vérifiez les informations saisies
                </div>

                <ul class="mb-0 ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('matieres.store') }}">
            @csrf

            <div class="matiere-form-card">

                {{-- SECTION INFORMATIONS --}}
                <div class="matiere-section-header">

                    <div class="matiere-section-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>
                        <h5>Informations de la matière</h5>
                        <p>Renseignez le nom de la matière à créer</p>
                    </div>

                </div>

                <div class="matiere-form-body">

                    <div class="row g-4">

                        <div class="col-lg-8">

                            <label for="nom" class="matiere-label">
                                Nom de la matière
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nom" id="nom"
                                class="form-control matiere-input @error('nom') is-invalid @enderror"
                                value="{{ old('nom') }}" placeholder="Exemple : Mathématiques, Français, Physique..."
                                maxlength="100" required autofocus>

                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="matiere-help">
                                <i class="bi bi-lightbulb me-1"></i>
                                Utilisez un nom clair et facilement identifiable.
                            </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="matiere-stat">

                                <div class="matiere-stat-icon">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>

                                <div class="matiere-stat-label">
                                    Classes disponibles
                                </div>

                                <div class="matiere-stat-value">
                                    {{ $classes->count() }}
                                </div>

                                <div class="matiere-help">
                                    Classes enregistrées dans l'établissement
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- SECTION CLASSES --}}
                <div class="matiere-section-header">

                    <div class="matiere-section-icon">
                        <i class="bi bi-building-fill"></i>
                    </div>

                    <div>
                        <h5>Affectation aux classes</h5>
                        <p>Sélectionnez les classes concernées par cette matière</p>
                    </div>

                </div>

                <div class="matiere-form-body">

                    <div class="classes-toolbar">

                        <div>
                            <div class="classes-toolbar-title">
                                Classes de l'établissement
                            </div>

                            <div class="classes-toolbar-subtitle">
                                Vous pouvez sélectionner plusieurs classes.
                            </div>
                        </div>

                        <div class="classes-toolbar-actions">

                            <button type="button" id="selectAll" class="btn btn-sm btn-success">

                                <i class="bi bi-check2-all me-1"></i>
                                Tout sélectionner

                            </button>

                            <button type="button" id="deselectAll" class="btn btn-sm btn-outline-danger">

                                <i class="bi bi-x-lg me-1"></i>
                                Tout désélectionner

                            </button>

                        </div>

                    </div>

                    {{-- RECHERCHE --}}
                    @if ($classes->count() > 0)
                        <div class="classes-search">

                            <i class="bi bi-search"></i>

                            <input type="text" id="searchClasses" placeholder="Rechercher une classe..."
                                autocomplete="off" aria-label="Rechercher une classe">

                        </div>
                    @endif

                    {{-- LISTE DES CLASSES --}}
                    <div class="class-selection-box">

                        @if ($classes->count() > 0)
                            <div class="row g-3" id="classesContainer">

                                @foreach ($classes as $classe)
                                    <div class="col-12 col-md-6 col-xl-4 class-column"
                                        data-name="{{ strtolower($classe->nom) }}">

                                        <div class="class-item">

                                            <div class="form-check">

                                                <input type="checkbox" name="classes[]" value="{{ $classe->id }}"
                                                    class="form-check-input classe-checkbox" id="classe{{ $classe->id }}"
                                                    {{ in_array($classe->id, old('classes', [])) ? 'checked' : '' }}>

                                                <label class="form-check-label" for="classe{{ $classe->id }}">

                                                    <i class="bi bi-mortarboard-fill me-1"></i>
                                                    {{ $classe->nom }}

                                                </label>

                                            </div>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                            <div class="class-empty" id="classEmpty">
                                <i class="bi bi-search fs-3 mb-2 d-block"></i>
                                Aucune classe ne correspond à votre recherche.
                            </div>
                        @else
                            <div class="matiere-no-classes">

                                <div class="matiere-no-classes-icon">
                                    <i class="bi bi-building-x"></i>
                                </div>

                                <h6>Aucune classe disponible</h6>

                                <p>
                                    Veuillez d'abord créer une classe avant
                                    d'affecter cette matière.
                                </p>

                            </div>
                        @endif

                    </div>

                    {{-- RÉSUMÉ SÉLECTION --}}
                    <div class="selection-summary">

                        <div>
                            <i class="bi bi-check-circle-fill selection-summary-icon"></i>
                            <strong id="selectedCount">0 classe sélectionnée</strong>
                        </div>

                        <span id="selectionMessage">
                            Aucune classe sélectionnée
                        </span>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="matiere-form-footer">

                    <a href="{{ route('matieres.index') }}" class="btn matiere-btn matiere-btn-light">

                        <i class="bi bi-arrow-left me-2"></i>
                        Retour à la liste

                    </a>

                    <button type="submit" class="btn matiere-btn matiere-btn-primary">

                        <i class="bi bi-floppy-fill me-2"></i>
                        Enregistrer la matière

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const checkboxes = document.querySelectorAll('.classe-checkbox');
            const selectedCount = document.getElementById('selectedCount');
            const selectionMessage = document.getElementById('selectionMessage');
            const searchInput = document.getElementById('searchClasses');
            const classColumns = document.querySelectorAll('.class-column');
            const classEmpty = document.getElementById('classEmpty');

            const selectAllButton = document.getElementById('selectAll');
            const deselectAllButton = document.getElementById('deselectAll');

            /* =====================================================
               MISE À JOUR DE LA SÉLECTION
            ===================================================== */

            function updateSelection() {

                let selected = 0;

                checkboxes.forEach(function(checkbox) {

                    const card = checkbox.closest('.class-item');

                    if (checkbox.checked) {
                        selected++;
                        card.classList.add('selected');
                    } else {
                        card.classList.remove('selected');
                    }

                });

                if (selectedCount) {
                    selectedCount.textContent =
                        selected + (selected > 1 ?
                            ' classes sélectionnées' :
                            ' classe sélectionnée');
                }

                if (selectionMessage) {
                    selectionMessage.textContent = selected > 0 ?
                        'La matière sera affectée à ' + selected + ' classe(s).' :
                        'Aucune classe sélectionnée';
                }
            }

            /* =====================================================
               SÉLECTION INDIVIDUELLE
            ===================================================== */

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateSelection);
            });

            /* =====================================================
               TOUT SÉLECTIONNER
            ===================================================== */

            if (selectAllButton) {

                selectAllButton.addEventListener('click', function() {

                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = true;
                    });

                    updateSelection();

                });

            }

            /* =====================================================
               TOUT DÉSELECTIONNER
            ===================================================== */

            if (deselectAllButton) {

                deselectAllButton.addEventListener('click', function() {

                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });

                    updateSelection();

                });

            }

            /* =====================================================
               RECHERCHE DES CLASSES
            ===================================================== */

            if (searchInput) {

                searchInput.addEventListener('input', function() {

                    const search = this.value.toLowerCase().trim();
                    let visible = 0;

                    classColumns.forEach(function(column) {

                        const name = column.dataset.name || '';
                        const match = name.includes(search);

                        column.style.display = match ? '' : 'none';

                        if (match) visible++;

                    });

                    if (classEmpty) {
                        classEmpty.style.display =
                            visible === 0 && classColumns.length > 0 ?
                            'block' :
                            'none';
                    }

                });

            }

            /* =====================================================
               INITIALISATION
            ===================================================== */

            updateSelection();

        });
    </script>

@endsection
