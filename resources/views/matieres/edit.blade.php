@extends('layouts.app')

@section('content')

    <style>
        /* =====================================================
           MATIÈRE - MODIFICATION
        ===================================================== */

        .matiere-edit-page {
            --mc-primary: #b77b19;
            --mc-primary-rgb: 183, 123, 25;
            --mc-accent: #dfa83e;
            --mc-text: #26364d;
            --mc-muted: #8491a5;
            --mc-border: #e8edf4;
            --mc-surface: #ffffff;
            --mc-soft: #f8fafc;
            --mc-input-bg: #ffffff;
            --mc-label: #34445b;
            --mc-item: #ffffff;
            --mc-item-selected: #fff8e9;
            --mc-summary: #fff6e5;
            --mc-footer: #fafbfd;

            max-width: 1250px;
            margin: auto;
            padding: 24px;
            color: var(--mc-text);
        }

        /* =====================================================
           THÈME SOMBRE
        ===================================================== */

        html[data-app-theme="dark"] .matiere-edit-page {
            --mc-primary: #e2aa48;
            --mc-primary-rgb: 226, 170, 72;
            --mc-accent: #f1c36d;
            --mc-text: #e7edf7;
            --mc-muted: #a0aec1;
            --mc-border: #304057;
            --mc-surface: #19283c;
            --mc-soft: #142238;
            --mc-input-bg: #101e31;
            --mc-label: #e0e8f3;
            --mc-item: #1c2c42;
            --mc-item-selected: #3a3020;
            --mc-summary: #302a1d;
            --mc-footer: #142238;
        }

        /* =====================================================
           THÈME ULTRA PRO
        ===================================================== */

        html[data-app-theme="ultra-pro"] .matiere-edit-page {
            --mc-primary: #60a5fa;
            --mc-primary-rgb: 96, 165, 250;
            --mc-accent: #22d3ee;
            --mc-text: #e8f0fc;
            --mc-muted: #9bacc4;
            --mc-border: #293d59;
            --mc-surface: #14243b;
            --mc-soft: #102037;
            --mc-input-bg: #0d1b30;
            --mc-label: #e5eefb;
            --mc-item: #192c46;
            --mc-item-selected: #1d3b5e;
            --mc-summary: #173654;
            --mc-footer: #102037;
        }

        /* =====================================================
           THÈME EMERALD
        ===================================================== */

        html[data-app-theme="emerald"] .matiere-edit-page {
            --mc-primary: #15966d;
            --mc-primary-rgb: 21, 150, 109;
            --mc-accent: #35b98c;
            --mc-item-selected: #e9f8f1;
            --mc-summary: #eaf8f1;
        }

        html[data-app-theme="dark"][data-app-theme="emerald"] .matiere-edit-page {
            --mc-item-selected: #173e34;
            --mc-summary: #173e34;
        }

        /* =====================================================
           THÈME WARM
        ===================================================== */

        html[data-app-theme="warm"] .matiere-edit-page {
            --mc-primary: #c46b45;
            --mc-primary-rgb: 196, 107, 69;
            --mc-accent: #e6a06e;
            --mc-item-selected: #fff1e9;
            --mc-summary: #fff0e8;
        }

        /* =====================================================
           BANDEAU PRINCIPAL
        ===================================================== */

        .matiere-edit-hero {
            position: relative;
            overflow: hidden;
            padding: 30px 34px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(120deg,
                    #8a5a13,
                    #c58a26 58%,
                    #e9b95c);
            box-shadow: 0 12px 30px rgba(138, 90, 19, .16);
            margin-bottom: 25px;
        }

        html[data-app-theme="ultra-pro"] .matiere-edit-hero {
            background: linear-gradient(120deg, #102746, #17618b 60%, #168eaa);
        }

        html[data-app-theme="emerald"] .matiere-edit-hero {
            background: linear-gradient(120deg, #075c47, #15966d 60%, #42bd91);
        }

        html[data-app-theme="warm"] .matiere-edit-hero {
            background: linear-gradient(120deg, #8f4933, #c46b45 60%, #e6a06e);
        }

        .matiere-edit-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            right: -55px;
            top: -100px;
            border: 35px solid rgba(255, 255, 255, .10);
            border-radius: 50%;
            pointer-events: none;
        }

        .matiere-edit-hero::before {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            right: 145px;
            bottom: -80px;
            border: 20px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            pointer-events: none;
        }

        .matiere-edit-hero h3 {
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            letter-spacing: -.4px;
        }

        .matiere-edit-hero p {
            margin: 0;
            opacity: .92;
            position: relative;
            z-index: 1;
            font-size: 14px;
            max-width: 650px;
            line-height: 1.7;
        }

        .matiere-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 800;
            text-transform: uppercase;
            opacity: .92;
        }

        .matiere-hero-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .17);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 13px;
            font-size: 20px;
        }

        /* =====================================================
           CARTE PRINCIPALE
        ===================================================== */

        .matiere-edit-card {
            background: var(--mc-surface);
            border: 1px solid var(--mc-border);
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(20, 40, 70, .06);
            overflow: hidden;
        }

        html[data-app-theme="dark"] .matiere-edit-card,
        html[data-app-theme="ultra-pro"] .matiere-edit-card {
            box-shadow: 0 12px 30px rgba(0, 0, 0, .18);
        }

        .matiere-section-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--mc-border);
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .matiere-section-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(var(--mc-primary-rgb), .12);
            color: var(--mc-primary);
            font-size: 19px;
            flex-shrink: 0;
        }

        .matiere-section-header h5 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px;
            color: var(--mc-text);
        }

        .matiere-section-header p {
            margin: 0;
            color: var(--mc-muted);
            font-size: 12px;
        }

        .matiere-form-body {
            padding: 27px;
        }

        /* =====================================================
           CHAMPS DU FORMULAIRE
        ===================================================== */

        .matiere-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--mc-label);
            margin-bottom: 9px;
        }

        .matiere-input {
            height: 49px;
            border-radius: 11px;
            border: 1px solid var(--mc-border);
            padding: 10px 15px;
            font-size: 14px;
            transition: .2s;
            background: var(--mc-input-bg);
            color: var(--mc-text);
        }

        .matiere-input::placeholder {
            color: var(--mc-muted);
            opacity: .8;
        }

        .matiere-input:focus {
            border-color: var(--mc-primary);
            background: var(--mc-input-bg);
            color: var(--mc-text);
            box-shadow: 0 0 0 3px rgba(var(--mc-primary-rgb), .13);
        }

        .matiere-input.is-invalid {
            border-color: #dc3545;
        }

        .matiere-help {
            color: var(--mc-muted);
            font-size: 12px;
            margin-top: 8px;
            line-height: 1.6;
        }

        /* =====================================================
           STATISTIQUE
        ===================================================== */

        .matiere-stat {
            height: 100%;
            padding: 17px;
            border-radius: 13px;
            background: rgba(var(--mc-primary-rgb), .08);
            border: 1px solid rgba(var(--mc-primary-rgb), .18);
        }

        .matiere-stat-label {
            font-size: 11px;
            color: var(--mc-primary);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .matiere-stat-value {
            font-size: 27px;
            font-weight: 800;
            color: var(--mc-primary);
            margin-top: 5px;
        }

        /* =====================================================
           APERÇU
        ===================================================== */

        .matiere-preview {
            margin-top: 22px;
            padding: 17px;
            border: 1px dashed rgba(var(--mc-primary-rgb), .55);
            border-radius: 13px;
            background: var(--mc-soft);
        }

        .matiere-preview-title {
            font-size: 11px;
            color: var(--mc-primary);
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: .5px;
            margin-bottom: 10px;
        }

        .matiere-preview-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--mc-text);
            overflow-wrap: anywhere;
        }

        /* =====================================================
           BARRE DES CLASSES
        ===================================================== */

        .classes-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .classes-toolbar-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--mc-text);
        }

        .classes-toolbar-description {
            color: var(--mc-muted);
            font-size: 12px;
            margin-top: 4px;
        }

        .classes-toolbar .btn {
            font-size: 12px;
            font-weight: 700;
            padding: 8px 12px;
            border-radius: 9px;
        }

        /* =====================================================
           RECHERCHE
        ===================================================== */

        .classes-search {
            position: relative;
            width: 100%;
            max-width: 390px;
        }

        .classes-search>i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--mc-muted);
            z-index: 2;
        }

        .classes-search input {
            width: 100%;
            height: 43px;
            padding: 8px 12px 8px 38px;
            border: 1px solid var(--mc-border);
            border-radius: 10px;
            outline: none;
            font-size: 13px;
            background: var(--mc-input-bg);
            color: var(--mc-text);
            transition: .2s;
        }

        .classes-search input::placeholder {
            color: var(--mc-muted);
        }

        .classes-search input:focus {
            border-color: var(--mc-primary);
            box-shadow: 0 0 0 3px rgba(var(--mc-primary-rgb), .10);
        }

        /* =====================================================
           LISTE DES CLASSES
        ===================================================== */

        .class-selection-box {
            padding: 18px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            background: var(--mc-soft);
        }

        .class-item {
            height: 100%;
            padding: 13px 14px;
            background: var(--mc-item);
            border: 1px solid var(--mc-border);
            border-radius: 11px;
            transition: .2s;
        }

        .class-item:hover {
            border-color: var(--mc-primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 13px rgba(var(--mc-primary-rgb), .09);
        }

        .class-item.selected {
            border-color: var(--mc-primary);
            background: var(--mc-item-selected);
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
            border-color: #aab5c5;
        }

        .class-item .form-check-input:checked {
            background-color: var(--mc-primary);
            border-color: var(--mc-primary);
        }

        .class-item .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(var(--mc-primary-rgb), .16);
        }

        .class-item .form-check-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--mc-label);
            cursor: pointer;
            flex: 1;
            overflow-wrap: anywhere;
        }

        .class-item .form-check-label i {
            color: var(--mc-primary) !important;
        }

        .class-empty {
            display: none;
            text-align: center;
            padding: 30px;
            color: var(--mc-muted);
            font-size: 13px;
        }

        .class-empty i {
            color: var(--mc-muted);
        }

        .class-empty-state {
            color: var(--mc-muted);
        }

        .class-empty-state h6 {
            color: var(--mc-text);
        }

        /* =====================================================
           RÉSUMÉ DES SÉLECTIONS
        ===================================================== */

        .selection-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 13px 16px;
            background: var(--mc-summary);
            border: 1px solid rgba(var(--mc-primary-rgb), .14);
            border-radius: 11px;
            margin-top: 16px;
        }

        .selection-summary strong {
            color: var(--mc-primary);
            font-size: 13px;
        }

        .selection-summary>span {
            color: var(--mc-muted);
            font-size: 12px;
        }

        /* =====================================================
           PIED DU FORMULAIRE
        ===================================================== */

        .matiere-form-footer {
            padding: 20px 27px;
            background: var(--mc-footer);
            border-top: 1px solid var(--mc-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .matiere-btn {
            border-radius: 10px;
            padding: 11px 20px;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .matiere-btn-primary {
            color: white;
            border: 0;
            background: linear-gradient(120deg,
                    var(--mc-primary),
                    var(--mc-accent));
            box-shadow: 0 5px 12px rgba(var(--mc-primary-rgb), .20);
        }

        .matiere-btn-primary:hover {
            color: white;
            filter: brightness(1.06);
            transform: translateY(-1px);
        }

        .matiere-btn-light {
            background: var(--mc-surface);
            border: 1px solid var(--mc-border);
            color: var(--mc-text);
        }

        .matiere-btn-light:hover {
            background: var(--mc-soft);
            color: var(--mc-text);
            border-color: var(--mc-primary);
        }

        .matiere-btn:focus-visible {
            outline: 3px solid rgba(var(--mc-primary-rgb), .25);
            outline-offset: 3px;
        }

        /* =====================================================
           ALERTES
        ===================================================== */

        .matiere-alert {
            border-radius: 11px;
            font-size: 13px;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 768px) {
            .matiere-edit-page {
                padding: 14px;
            }

            .matiere-edit-hero {
                padding: 23px;
            }

            .matiere-edit-hero h3 {
                font-size: 22px;
            }

            .matiere-form-body {
                padding: 18px;
            }

            .matiere-section-header {
                padding: 17px 18px;
            }

            .matiere-form-footer {
                padding: 17px;
            }

            .matiere-form-footer .btn {
                width: 100%;
                text-align: center;
            }

            .classes-toolbar {
                align-items: flex-start;
            }

            .classes-search {
                max-width: 100%;
            }

            .selection-summary {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="matiere-edit-page">

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}

        <div class="matiere-edit-hero">

            <div class="matiere-hero-label mb-3">
                <div class="matiere-hero-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <span>Gestion pédagogique</span>
            </div>

            <h3>Modifier une matière</h3>

            <p>
                Actualisez les informations de la matière et gérez
                ses affectations aux différentes classes de votre établissement.
            </p>

        </div>

        {{-- =====================================================
         ERREURS DE VALIDATION
    ====================================================== --}}

        @if ($errors->any())
            <div class="alert alert-danger matiere-alert mb-4">

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

        <form method="POST" action="{{ route('matieres.update', $matiere) }}">

            @csrf
            @method('PUT')

            <div class="matiere-edit-card">

                {{-- =================================================
                 INFORMATIONS DE LA MATIÈRE
            ================================================== --}}

                <div class="matiere-section-header">

                    <div class="matiere-section-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>
                        <h5>Informations de la matière</h5>
                        <p>Modifiez le nom et vérifiez son aperçu</p>
                    </div>

                </div>

                <div class="matiere-form-body">

                    <div class="row g-4">

                        <div class="col-lg-8">

                            <label for="matiereNom" class="matiere-label">
                                Nom de la matière
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nom" id="matiereNom" value="{{ old('nom', $matiere->nom) }}"
                                class="form-control matiere-input @error('nom') is-invalid @enderror"
                                placeholder="Exemple : Mathématiques, Français..." required autofocus>

                            @error('nom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="matiere-help">
                                <i class="bi bi-lightbulb me-1"></i>
                                Modifiez le nom tout en conservant une désignation claire.
                            </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="matiere-stat">

                                <div class="matiere-stat-label">
                                    Classes disponibles
                                </div>

                                <div class="matiere-stat-value">
                                    {{ $classes->count() }}
                                </div>

                                <div class="matiere-help">
                                    Nombre de classes enregistrées
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- APERÇU DU NOM --}}

                    <div class="matiere-preview">

                        <div class="matiere-preview-title">
                            <i class="bi bi-eye me-1"></i>
                            Aperçu de la matière
                        </div>

                        <div class="matiere-preview-name" id="matierePreview">
                            {{ old('nom', $matiere->nom) }}
                        </div>

                    </div>

                </div>

                {{-- =================================================
                 AFFECTATION AUX CLASSES
            ================================================== --}}

                <div class="matiere-section-header">

                    <div class="matiere-section-icon">
                        <i class="bi bi-building"></i>
                    </div>

                    <div>
                        <h5>Affectation aux classes</h5>
                        <p>Les classes déjà associées à cette matière sont présélectionnées</p>
                    </div>

                </div>

                <div class="matiere-form-body">

                    {{-- BARRE D'ACTIONS --}}

                    <div class="classes-toolbar">

                        <div>
                            <div class="classes-toolbar-title">
                                Classes de l'établissement
                            </div>

                            <div class="classes-toolbar-description">
                                Cochez ou décochez les classes selon vos besoins.
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">

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

                    <div class="classes-search mb-3">

                        <i class="bi bi-search"></i>

                        <input type="text" id="searchClasses" placeholder="Rechercher une classe..." autocomplete="off">

                    </div>

                    {{-- LISTE DES CLASSES --}}

                    <div class="class-selection-box">

                        @if ($classes->count() > 0)
                            <div class="row g-3" id="classesContainer">

                                @foreach ($classes as $classe)
                                    @php
                                        $isSelected = in_array(
                                            $classe->id,
                                            old('classes', $matiere->classes->pluck('id')->toArray()),
                                        );
                                    @endphp

                                    <div class="col-12 col-md-6 col-xl-4 class-column"
                                        data-name="{{ strtolower($classe->nom) }}">

                                        <div class="class-item {{ $isSelected ? 'selected' : '' }}">

                                            <div class="form-check">

                                                <input type="checkbox" name="classes[]" value="{{ $classe->id }}"
                                                    class="form-check-input classe-checkbox" id="classe{{ $classe->id }}"
                                                    {{ $isSelected ? 'checked' : '' }}>

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

                                <i class="bi bi-search fs-2 mb-2 d-block"></i>

                                Aucune classe ne correspond à votre recherche.

                            </div>
                        @else
                            <div class="text-center py-4 class-empty-state">

                                <i class="bi bi-building fs-1 mb-3 d-block"></i>

                                <h6 class="fw-bold">
                                    Aucune classe disponible
                                </h6>

                                <p class="small mb-0">
                                    Créez d'abord une classe pour pouvoir
                                    l'associer à cette matière.
                                </p>

                            </div>
                        @endif

                    </div>

                    {{-- RÉSUMÉ DES SÉLECTIONS --}}

                    <div class="selection-summary">

                        <div>
                            <i class="bi bi-check-circle-fill me-2" style="color:var(--mc-primary);"></i>

                            <strong id="selectedCount">
                                0 classe sélectionnée
                            </strong>
                        </div>

                        <span id="selectionMessage">
                            Aucune classe sélectionnée
                        </span>

                    </div>

                </div>

                {{-- =================================================
                 ACTIONS
            ================================================== --}}

                <div class="matiere-form-footer">

                    <a href="{{ route('matieres.index') }}" class="btn matiere-btn matiere-btn-light">
                        <i class="bi bi-arrow-left me-2"></i>
                        Retour à la liste
                    </a>

                    <button type="submit" class="btn matiere-btn matiere-btn-primary">
                        <i class="bi bi-floppy me-2"></i>
                        Enregistrer les modifications
                    </button>

                </div>

            </div>

        </form>

    </div>

    {{-- =========================================================
     JAVASCRIPT
========================================================= --}}

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

            const nomInput = document.getElementById('matiereNom');
            const nomPreview = document.getElementById('matierePreview');

            // =====================================================
            // COMPTEUR ET MISE À JOUR DES SÉLECTIONS
            // =====================================================

            function updateSelection() {

                let selected = 0;

                checkboxes.forEach(function(checkbox) {

                    const card = checkbox.closest('.class-item');

                    if (checkbox.checked) {

                        selected++;

                        if (card) {
                            card.classList.add('selected');
                        }

                    } else {

                        if (card) {
                            card.classList.remove('selected');
                        }

                    }

                });

                if (selectedCount) {

                    selectedCount.textContent =
                        selected + (
                            selected > 1 ?
                            ' classes sélectionnées' :
                            ' classe sélectionnée'
                        );

                }

                if (selectionMessage) {

                    selectionMessage.textContent = selected > 0 ?
                        'Cette matière sera associée à ' + selected + ' classe(s).' :
                        'Aucune classe sélectionnée';

                }

            }

            // =====================================================
            // CHANGEMENT INDIVIDUEL
            // =====================================================

            checkboxes.forEach(function(checkbox) {

                checkbox.addEventListener('change', updateSelection);

            });

            // =====================================================
            // TOUT SÉLECTIONNER
            // =====================================================

            if (selectAllButton) {

                selectAllButton.addEventListener('click', function() {

                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = true;
                    });

                    updateSelection();

                });

            }

            // =====================================================
            // TOUT DÉSELECTIONNER
            // =====================================================

            if (deselectAllButton) {

                deselectAllButton.addEventListener('click', function() {

                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });

                    updateSelection();

                });

            }

            // =====================================================
            // RECHERCHE DES CLASSES
            // =====================================================

            if (searchInput) {

                searchInput.addEventListener('input', function() {

                    const search = this.value.toLowerCase().trim();

                    let visible = 0;

                    classColumns.forEach(function(column) {

                        const match = column.dataset.name.includes(search);

                        column.style.display = match ? '' : 'none';

                        if (match) {
                            visible++;
                        }

                    });

                    if (classEmpty) {

                        classEmpty.style.display =
                            visible === 0 && classColumns.length > 0 ?
                            'block' :
                            'none';

                    }

                });

            }

            // =====================================================
            // APERÇU DU NOM EN TEMPS RÉEL
            // =====================================================

            if (nomInput && nomPreview) {

                nomInput.addEventListener('input', function() {

                    nomPreview.textContent =
                        this.value.trim() || 'Nom de la matière';

                });

            }

            // =====================================================
            // INITIALISATION
            // =====================================================

            updateSelection();

        });
    </script>

@endsection
