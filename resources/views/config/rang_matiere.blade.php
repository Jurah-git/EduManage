@extends('layouts.app')

@section('content')

    <div class="rang-page">

        <style>
            /* =====================================================
               VARIABLES ET STRUCTURE
            ===================================================== */

            .rang-page {
                --rang-card: #ffffff;
                --rang-text: #26364d;
                --rang-muted: #8793a5;
                --rang-border: #e8edf4;
                --rang-soft: #f7f9fc;
                --rang-row-hover: #f4f8fd;
                --rang-primary: #1765a9;
                --rang-shadow: 0 5px 22px rgba(31, 45, 61, .045);

                padding: 20px 24px;
                color: var(--rang-text);
            }

            /* =====================================================
               BANDEAU PRINCIPAL
            ===================================================== */

            .rang-hero {
                position: relative;
                overflow: hidden;
                padding: 25px 28px;
                margin-bottom: 20px;
                border-radius: 19px;
                color: #fff;
                background: linear-gradient(120deg, #102a56, #1765a9 55%, #13a8b8);
                box-shadow: 0 10px 28px rgba(23, 101, 169, .17);
            }

            .rang-hero::before {
                content: "";
                position: absolute;
                width: 220px;
                height: 220px;
                right: 7%;
                top: -130px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .07);
            }

            .rang-hero::after {
                content: "";
                position: absolute;
                width: 150px;
                height: 150px;
                right: 18%;
                bottom: -110px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .06);
            }

            .rang-hero-content {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            }

            .rang-hero-left {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .rang-hero-icon {
                width: 56px;
                height: 56px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 16px;
                background: rgba(255, 255, 255, .15);
                border: 1px solid rgba(255, 255, 255, .2);
                font-size: 24px;
            }

            .rang-hero h2 {
                margin: 0 0 6px;
                font-size: 24px;
                font-weight: 850;
                letter-spacing: -.5px;
            }

            .rang-hero p {
                margin: 0;
                color: rgba(255, 255, 255, .8);
                font-size: 13px;
            }

            .rang-hero-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 11px 16px;
                border-radius: 11px;
                background: rgba(255, 255, 255, .14);
                border: 1px solid rgba(255, 255, 255, .2);
                color: #fff;
                font-size: 12px;
                font-weight: 800;
                white-space: nowrap;
            }

            /* =====================================================
               ALERTES
            ===================================================== */

            .rang-alert {
                padding: 13px 16px;
                border: none;
                border-radius: 11px;
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 16px;
            }

            /* =====================================================
               CARTES PRINCIPALES
            ===================================================== */

            .rang-card {
                height: calc(100vh - 260px);
                min-height: 420px;
                display: flex;
                flex-direction: column;
                overflow: hidden;
                background: var(--rang-card);
                border: 1px solid var(--rang-border);
                border-radius: 17px;
                box-shadow: var(--rang-shadow);
            }

            .rang-card-header {
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                padding: 19px 22px;
                border-bottom: 1px solid var(--rang-border);
                background: var(--rang-card);
            }

            .rang-card-title h5 {
                margin: 0 0 5px;
                color: var(--rang-text);
                font-size: 16px;
                font-weight: 850;
            }

            .rang-card-title h5 i {
                color: var(--rang-primary);
            }

            .rang-card-title p {
                margin: 0;
                color: var(--rang-muted);
                font-size: 12px;
            }

            .rang-card-body {
                flex: 1;
                min-height: 0;
                overflow-y: auto;
                overflow-x: hidden;
                padding: 20px;
                scrollbar-width: thin;
                scrollbar-color: #bdc9d8 transparent;
            }

            .rang-card-body::-webkit-scrollbar {
                width: 7px;
            }

            .rang-card-body::-webkit-scrollbar-track {
                background: transparent;
            }

            .rang-card-body::-webkit-scrollbar-thumb {
                background: #bdc9d8;
                border-radius: 10px;
            }

            /* =====================================================
               BADGES
            ===================================================== */

            .rang-count {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                padding: 8px 12px;
                border-radius: 9px;
                background: #edf5ff;
                color: #1765a9;
                font-size: 11px;
                font-weight: 850;
                white-space: nowrap;
            }

            /* =====================================================
               LISTE DES CLASSES
            ===================================================== */

            .rang-class-list {
                display: flex;
                flex-direction: column;
                gap: 7px;
                padding: 12px;
            }

            .rang-class-link {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                padding: 12px 13px;
                border: 1px solid transparent;
                border-radius: 11px;
                text-decoration: none;
                color: var(--rang-text);
                transition: .2s;
            }

            .rang-class-link:hover {
                background: var(--rang-row-hover);
                color: var(--rang-primary);
                transform: translateX(3px);
            }

            .rang-class-link.active {
                background: #edf5ff;
                border-color: #d5e7fa;
                color: #1765a9;
                font-weight: 800;
            }

            .rang-class-left {
                display: flex;
                align-items: center;
                gap: 11px;
                min-width: 0;
            }

            .rang-class-icon {
                width: 39px;
                height: 39px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 11px;
                background: #edf5ff;
                color: #1765a9;
                font-size: 16px;
            }

            .rang-class-name {
                font-size: 12px;
                font-weight: 800;
            }

            .rang-class-arrow {
                color: var(--rang-muted);
                font-size: 12px;
            }

            /* =====================================================
               DESCRIPTION
            ===================================================== */

            .rang-instruction {
                display: flex;
                align-items: flex-start;
                gap: 11px;
                padding: 14px 16px;
                margin-bottom: 17px;
                border-radius: 11px;
                background: var(--rang-soft);
                border: 1px solid var(--rang-border);
                color: var(--rang-muted);
                font-size: 12px;
                line-height: 1.6;
            }

            .rang-instruction i {
                color: var(--rang-primary);
                font-size: 17px;
                margin-top: 1px;
            }

            .rang-instruction strong {
                color: var(--rang-text);
            }

            /* =====================================================
               LISTE DES MATIÈRES
            ===================================================== */

            .rang-list {
                display: flex;
                flex-direction: column;
                gap: 9px;
            }

            .rang-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                padding: 12px 15px;
                background: var(--rang-card);
                border: 1px solid var(--rang-border);
                border-radius: 12px;
                transition: background .2s, border-color .2s, transform .2s;
            }

            .rang-item:hover {
                background: var(--rang-row-hover);
                border-color: #cbddec;
            }

            .rang-item-left {
                display: flex;
                align-items: center;
                gap: 13px;
                min-width: 0;
            }

            .rang-number {
                width: 41px;
                height: 41px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 11px;
                background: #edf5ff;
                color: #1765a9;
                font-size: 13px;
                font-weight: 850;
            }

            .rang-matiere-name {
                display: block;
                color: var(--rang-text);
                font-size: 13px;
                font-weight: 850;
                overflow-wrap: anywhere;
            }

            .rang-matiere-label {
                display: block;
                margin-top: 4px;
                color: var(--rang-muted);
                font-size: 10px;
                font-weight: 600;
            }

            /* =====================================================
               BOUTONS DE DÉPLACEMENT
            ===================================================== */

            .rang-actions {
                display: flex;
                align-items: center;
                gap: 7px;
                flex-shrink: 0;
            }

            .rang-move-btn {
                width: 35px;
                height: 35px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid var(--rang-border);
                border-radius: 9px;
                background: var(--rang-soft);
                color: var(--rang-primary);
                font-size: 13px;
                transition: .2s;
                cursor: pointer;
            }

            .rang-move-btn:hover:not(:disabled) {
                background: #1765a9;
                border-color: #1765a9;
                color: #fff;
                transform: translateY(-2px);
            }

            .rang-move-btn:disabled {
                opacity: .3;
                cursor: not-allowed;
            }

            /* =====================================================
               BARRE D'ENREGISTREMENT
            ===================================================== */

            .rang-save-area {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                flex-wrap: wrap;
                margin-top: 20px;
                padding: 16px 18px;
                border: 1px solid var(--rang-border);
                border-radius: 12px;
                background: var(--rang-soft);
            }

            .rang-save-info {
                display: flex;
                align-items: center;
                gap: 11px;
                min-width: 0;
            }

            .rang-save-icon {
                width: 38px;
                height: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 10px;
                background: #e8f7ef;
                color: #198754;
                font-size: 16px;
            }

            .rang-save-info strong {
                display: block;
                color: var(--rang-text);
                font-size: 12px;
                font-weight: 850;
            }

            .rang-save-info small {
                display: block;
                margin-top: 3px;
                color: var(--rang-muted);
                font-size: 10px;
            }

            .rang-unsaved {
                display: none;
                align-items: center;
                gap: 5px;
                margin-top: 5px;
                color: #c58a19;
                font-size: 10px;
                font-weight: 800;
            }

            .rang-unsaved.visible {
                display: flex;
            }

            .btn-rang-save {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 11px 17px;
                border: none;
                border-radius: 9px;
                background: #1765a9;
                color: #fff;
                font-size: 12px;
                font-weight: 850;
                white-space: nowrap;
                transition: .2s;
            }

            .btn-rang-save:hover:not(:disabled) {
                background: #104c83;
                color: #fff;
                transform: translateY(-2px);
                box-shadow: 0 5px 14px rgba(23, 101, 169, .2);
            }

            .btn-rang-save:disabled {
                opacity: .45;
                cursor: not-allowed;
            }

            /* =====================================================
               ÉTAT VIDE
            ===================================================== */

            .rang-empty {
                padding: 60px 20px;
                text-align: center;
                color: var(--rang-muted);
            }

            .rang-empty-icon {
                width: 65px;
                height: 65px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 15px;
                border-radius: 17px;
                background: #edf5ff;
                color: #1765a9;
                font-size: 27px;
            }

            .rang-empty strong {
                display: block;
                margin-bottom: 7px;
                color: var(--rang-text);
                font-size: 14px;
                font-weight: 850;
            }

            .rang-empty span {
                font-size: 12px;
            }

            /* =====================================================
               MODE SOMBRE
            ===================================================== */

            html[data-app-theme="dark"] .rang-page,
            html[data-app-theme="ultra-pro"] .rang-page {
                --rang-card: #1e293b;
                --rang-text: #e5edf7;
                --rang-muted: #9aaabe;
                --rang-border: #334155;
                --rang-soft: #263449;
                --rang-row-hover: #293b52;
                --rang-primary: #93c5fd;
                --rang-shadow: 0 5px 22px rgba(0, 0, 0, .15);
            }

            html[data-app-theme="dark"] .rang-class-icon,
            html[data-app-theme="ultra-pro"] .rang-class-icon,
            html[data-app-theme="dark"] .rang-number,
            html[data-app-theme="ultra-pro"] .rang-number,
            html[data-app-theme="dark"] .rang-count,
            html[data-app-theme="ultra-pro"] .rang-count,
            html[data-app-theme="dark"] .rang-empty-icon,
            html[data-app-theme="ultra-pro"] .rang-empty-icon {
                background: #263f5d;
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .rang-class-link.active,
            html[data-app-theme="ultra-pro"] .rang-class-link.active {
                background: #263f5d;
                border-color: #365777;
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .rang-move-btn,
            html[data-app-theme="ultra-pro"] .rang-move-btn {
                background: #263449;
                border-color: #40516a;
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .rang-move-btn:hover:not(:disabled),
            html[data-app-theme="ultra-pro"] .rang-move-btn:hover:not(:disabled) {
                background: #1765a9;
                color: #fff;
            }

            html[data-app-theme="dark"] .rang-save-icon,
            html[data-app-theme="ultra-pro"] .rang-save-icon {
                background: #173e35;
                color: #75d6a7;
            }

            html[data-app-theme="dark"] .rang-card-body::-webkit-scrollbar-thumb,
            html[data-app-theme="ultra-pro"] .rang-card-body::-webkit-scrollbar-thumb {
                background: #475569;
            }

            /* =====================================================
               THÈME EMERALD
            ===================================================== */

            html[data-app-theme="emerald"] .rang-page {
                --rang-primary: #16865d;
            }

            html[data-app-theme="emerald"] .rang-count,
            html[data-app-theme="emerald"] .rang-class-icon,
            html[data-app-theme="emerald"] .rang-number,
            html[data-app-theme="emerald"] .rang-empty-icon {
                background: #e2f5eb;
                color: #16865d;
            }

            html[data-app-theme="emerald"] .rang-class-link.active {
                background: #e2f5eb;
                border-color: #c7e8d6;
                color: #16865d;
            }

            html[data-app-theme="emerald"] .btn-rang-save,
            html[data-app-theme="emerald"] .rang-move-btn:hover:not(:disabled) {
                background: #16865d;
                border-color: #16865d;
            }

            /* =====================================================
               THÈME WARM
            ===================================================== */

            html[data-app-theme="warm"] .rang-page {
                --rang-primary: #b66b37;
            }

            html[data-app-theme="warm"] .rang-count,
            html[data-app-theme="warm"] .rang-class-icon,
            html[data-app-theme="warm"] .rang-number,
            html[data-app-theme="warm"] .rang-empty-icon {
                background: #fff0df;
                color: #b66b37;
            }

            html[data-app-theme="warm"] .rang-class-link.active {
                background: #fff0df;
                border-color: #f2dcc4;
                color: #b66b37;
            }

            html[data-app-theme="warm"] .btn-rang-save,
            html[data-app-theme="warm"] .rang-move-btn:hover:not(:disabled) {
                background: #b66b37;
                border-color: #b66b37;
            }

            /* =====================================================
               RESPONSIVE
            ===================================================== */

            @media (max-width: 768px) {

                .rang-page {
                    padding: 14px;
                }

                .rang-hero {
                    padding: 19px;
                }

                .rang-hero h2 {
                    font-size: 20px;
                }

                .rang-hero p {
                    font-size: 11px;
                }

                .rang-hero-icon {
                    width: 46px;
                    height: 46px;
                    font-size: 20px;
                }

                .rang-hero-badge {
                    display: none;
                }

                .rang-card {
                    height: auto;
                    min-height: 350px;
                }

                .rang-card-header {
                    padding: 15px;
                }

                .rang-card-body {
                    padding: 15px;
                }

                .rang-item {
                    padding: 10px;
                    gap: 8px;
                }

                .rang-item-left {
                    gap: 9px;
                }

                .rang-number {
                    width: 35px;
                    height: 35px;
                }

                .rang-save-area {
                    align-items: stretch;
                }

                .btn-rang-save {
                    width: 100%;
                }
            }

            @media (max-width: 480px) {

                .rang-hero-content {
                    align-items: flex-start;
                }

                .rang-hero-left {
                    gap: 11px;
                }

                .rang-hero-icon {
                    width: 42px;
                    height: 42px;
                }

                .rang-hero h2 {
                    font-size: 18px;
                }

                .rang-card-header {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .rang-count {
                    align-self: flex-start;
                }

                .rang-matiere-name {
                    font-size: 12px;
                }

                .rang-move-btn {
                    width: 32px;
                    height: 32px;
                }
            }
        </style>


        {{-- =====================================================
         BANDEAU PRINCIPAL
    ====================================================== --}}

        <div class="rang-hero">

            <div class="rang-hero-content">

                <div class="rang-hero-left">

                    <div class="rang-hero-icon">
                        <i class="bi bi-sort-numeric-down"></i>
                    </div>

                    <div>
                        <h2>Ordre des matières</h2>

                        <p>
                            Organisez et personnalisez le classement des matières par classe.
                        </p>
                    </div>

                </div>

                <div class="rang-hero-badge">
                    <i class="bi bi-sliders"></i>
                    Configuration pédagogique
                </div>

            </div>

        </div>


        {{-- =====================================================
         ALERTES
    ====================================================== --}}

        @if (session('success'))
            <div class="alert alert-success rang-alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger rang-alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info rang-alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                {{ session('info') }}
            </div>
        @endif


        {{-- =====================================================
         CONTENU PRINCIPAL
    ====================================================== --}}

        <div class="row g-4">

            {{-- =================================================
             COLONNE DES CLASSES
        ================================================== --}}

            <div class="col-lg-3 col-md-4">

                <div class="rang-card">

                    <div class="rang-card-header">

                        <div class="rang-card-title">

                            <h5>
                                <i class="bi bi-buildings me-2"></i>
                                Liste des classes
                            </h5>

                            <p>
                                Sélectionnez une classe.
                            </p>

                        </div>

                        <span class="rang-count">
                            {{ $classes->count() }}
                        </span>

                    </div>


                    <div class="rang-card-body p-0">

                        <div class="rang-class-list">

                            @forelse($classes as $classe)
                                <a href="{{ route('config.rang_matiere', ['classe_id' => $classe->id]) }}"
                                    class="rang-class-link
                               {{ $classeSelectionnee && $classeSelectionnee->id == $classe->id ? 'active' : '' }}">

                                    <div class="rang-class-left">

                                        <div class="rang-class-icon">
                                            <i class="bi bi-mortarboard-fill"></i>
                                        </div>

                                        <span class="rang-class-name">
                                            {{ $classe->nom }}
                                        </span>

                                    </div>

                                    <i class="bi bi-chevron-right rang-class-arrow"></i>

                                </a>

                            @empty

                                <div class="rang-empty">

                                    <div class="rang-empty-icon">
                                        <i class="bi bi-building"></i>
                                    </div>

                                    <strong>Aucune classe disponible</strong>

                                    <span>
                                        Les classes apparaîtront ici.
                                    </span>

                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
             COLONNE DES MATIÈRES
        ================================================== --}}

            <div class="col-lg-9 col-md-8">

                <div class="rang-card">

                    @if ($classeSelectionnee)

                        {{-- HEADER MATIÈRES --}}

                        <div class="rang-card-header">

                            <div class="rang-card-title">

                                <h5>
                                    <i class="bi bi-book-half me-2"></i>
                                    Matières de {{ $classeSelectionnee->nom }}
                                </h5>

                                <p>
                                    Déplacez les matières et enregistrez votre classement.
                                </p>

                            </div>

                            <span class="rang-count">
                                <i class="bi bi-collection"></i>
                                {{ $classeSelectionnee->matieres->count() }} matière(s)
                            </span>

                        </div>


                        <div class="rang-card-body">

                            @if ($classeSelectionnee->matieres->isNotEmpty())
                                {{-- INSTRUCTIONS --}}

                                <div class="rang-instruction">

                                    <i class="bi bi-lightbulb-fill"></i>

                                    <div>
                                        Utilisez les flèches pour modifier l'ordre des matières.
                                        Les changements sont temporaires et ne seront enregistrés
                                        qu'après avoir cliqué sur <strong>Enregistrer l'ordre</strong>.
                                    </div>

                                </div>


                                {{-- FORMULAIRE --}}

                                <form method="POST" action="{{ route('config.rang_matiere.enregistrer') }}"
                                    id="ordreMatieresForm">

                                    @csrf

                                    <input type="hidden" name="classe_id" value="{{ $classeSelectionnee->id }}">


                                    {{-- LISTE DES MATIÈRES --}}

                                    <div id="listeMatieres" class="rang-list">

                                        @foreach ($classeSelectionnee->matieres as $matiere)
                                            <div class="rang-item matiere-item" data-id="{{ $matiere->id }}">

                                                <div class="rang-item-left">

                                                    <div class="rang-number numero-ordre">
                                                        {{ sprintf('%02d', $loop->iteration) }}
                                                    </div>

                                                    <div>

                                                        <span class="rang-matiere-name">
                                                            {{ $matiere->nom }}
                                                        </span>

                                                        <span class="rang-matiere-label">
                                                            Matière pédagogique
                                                        </span>

                                                    </div>

                                                </div>


                                                {{-- BOUTONS DE DÉPLACEMENT --}}

                                                <div class="rang-actions">

                                                    <button type="button" class="rang-move-btn btn-monter"
                                                        title="Déplacer vers le haut">

                                                        <i class="bi bi-chevron-up"></i>

                                                    </button>

                                                    <button type="button" class="rang-move-btn btn-descendre"
                                                        title="Déplacer vers le bas">

                                                        <i class="bi bi-chevron-down"></i>

                                                    </button>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>


                                    {{-- BARRE D'ENREGISTREMENT --}}

                                    <div class="rang-save-area">

                                        <div class="rang-save-info">

                                            <div class="rang-save-icon">
                                                <i class="bi bi-shield-check"></i>
                                            </div>

                                            <div>

                                                <strong>
                                                    Enregistrement du classement
                                                </strong>

                                                <small id="rangSavedText">
                                                    Aucun changement en attente.
                                                </small>

                                                <div class="rang-unsaved" id="rangUnsaved">
                                                    <i class="bi bi-exclamation-circle-fill"></i>
                                                    Modifications non enregistrées
                                                </div>

                                            </div>

                                        </div>


                                        <button type="submit" class="btn-rang-save" id="btnEnregistrer" disabled>

                                            <i class="bi bi-save2"></i>

                                            Enregistrer l'ordre

                                        </button>

                                    </div>

                                </form>
                            @else
                                <div class="rang-empty">

                                    <div class="rang-empty-icon">
                                        <i class="bi bi-journal-x"></i>
                                    </div>

                                    <strong>Aucune matière associée</strong>

                                    <span>
                                        Cette classe ne possède actuellement aucune matière.
                                    </span>

                                </div>
                            @endif

                        </div>
                    @else
                        {{-- AUCUNE CLASSE SÉLECTIONNÉE --}}

                        <div class="rang-card-header">

                            <div class="rang-card-title">
                                <h5>
                                    <i class="bi bi-book-half me-2"></i>
                                    Gestion du classement
                                </h5>

                                <p>
                                    Organisation des matières par classe.
                                </p>
                            </div>

                        </div>

                        <div class="rang-card-body">

                            <div class="rang-empty">

                                <div class="rang-empty-icon">
                                    <i class="bi bi-arrow-left-circle"></i>
                                </div>

                                <strong>Sélectionnez une classe</strong>

                                <span>
                                    Choisissez une classe à gauche pour afficher
                                    et organiser ses matières.
                                </span>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
     JAVASCRIPT : DÉPLACEMENT ET ENREGISTREMENT
========================================================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const liste = document.getElementById('listeMatieres');
            const formulaire = document.getElementById('ordreMatieresForm');

            const boutonEnregistrer = document.getElementById('btnEnregistrer');
            const indicateurModifie = document.getElementById('rangUnsaved');
            const texteEnregistre = document.getElementById('rangSavedText');

            if (!liste || !formulaire) {
                return;
            }

            // Mémoriser l'ordre initial
            const ordreInitial = Array.from(
                liste.querySelectorAll('.matiere-item')
            ).map(matiere => matiere.dataset.id);


            // Récupérer l'ordre actuel
            function obtenirOrdreActuel() {

                return Array.from(
                    liste.querySelectorAll('.matiere-item')
                ).map(matiere => matiere.dataset.id);

            }


            // Vérifier si l'ordre a réellement changé
            function ordreIdentique() {

                const ordreActuel = obtenirOrdreActuel();

                return ordreActuel.every((id, index) => {
                    return id === ordreInitial[index];
                });

            }


            // Actualiser les numéros et les boutons
            function actualiserOrdre() {

                const matieres = liste.querySelectorAll('.matiere-item');

                matieres.forEach((matiere, index) => {

                    const numero = matiere.querySelector('.numero-ordre');

                    const boutonMonter = matiere.querySelector('.btn-monter');

                    const boutonDescendre = matiere.querySelector('.btn-descendre');

                    numero.textContent = String(index + 1).padStart(2, '0');

                    boutonMonter.disabled = index === 0;

                    boutonDescendre.disabled = index === matieres.length - 1;

                });

                actualiserEtatEnregistrement();

            }


            // Gérer l'état du bouton Enregistrer
            function actualiserEtatEnregistrement() {

                const modifie = !ordreIdentique();

                boutonEnregistrer.disabled = !modifie;

                if (modifie) {

                    indicateurModifie.classList.add('visible');

                    texteEnregistre.textContent =
                        'Pensez à enregistrer votre nouveau classement.';

                } else {

                    indicateurModifie.classList.remove('visible');

                    texteEnregistre.textContent =
                        'Aucun changement en attente.';

                }

            }


            // Déplacer une matière vers le haut
            liste.addEventListener('click', function(event) {

                const bouton = event.target.closest('.btn-monter');

                if (!bouton || bouton.disabled) {
                    return;
                }

                const matiere = bouton.closest('.matiere-item');

                const precedente = matiere.previousElementSibling;

                if (precedente) {

                    liste.insertBefore(matiere, precedente);

                    actualiserOrdre();

                }

            });


            // Déplacer une matière vers le bas
            liste.addEventListener('click', function(event) {

                const bouton = event.target.closest('.btn-descendre');

                if (!bouton || bouton.disabled) {
                    return;
                }

                const matiere = bouton.closest('.matiere-item');

                const suivante = matiere.nextElementSibling;

                if (suivante) {

                    liste.insertBefore(suivante, matiere);

                    actualiserOrdre();

                }

            });


            // Envoyer les nouvelles positions au serveur
            formulaire.addEventListener('submit', function(event) {

                if (ordreIdentique()) {

                    event.preventDefault();

                    return;

                }

                // Supprimer les éventuels anciens champs
                formulaire.querySelectorAll('.ordre-cache').forEach(champ => {
                    champ.remove();
                });

                // Générer les champs ordre[]
                const matieres = liste.querySelectorAll('.matiere-item');

                matieres.forEach(matiere => {

                    const champ = document.createElement('input');

                    champ.type = 'hidden';

                    champ.name = 'ordre[]';

                    champ.value = matiere.dataset.id;

                    champ.classList.add('ordre-cache');

                    formulaire.appendChild(champ);

                });

                // Éviter les doubles clics
                boutonEnregistrer.disabled = true;

                boutonEnregistrer.innerHTML =
                    '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';

            });


            // Initialisation
            actualiserOrdre();

        });
    </script>

@endsection
