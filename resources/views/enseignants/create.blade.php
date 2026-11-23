@extends('layouts.app')

@section('content')

    <div class="enseignant-create-page">

        <style>
            /* =====================================================
                   ENSEIGNANTS - CREATION
                ===================================================== */

            .enseignant-create-page {
                --create-bg: #f3f6fc;
                --create-surface: #ffffff;
                --create-surface-soft: #f8faff;
                --create-text: #26364d;
                --create-heading: #172b4d;
                --create-muted: #78869b;
                --create-border: #e4eaf2;
                --create-primary: #2874d0;
                --create-primary-dark: #1759a9;
                --create-primary-soft: #eaf2ff;
                --create-shadow: 0 8px 28px rgba(30, 50, 80, .07);

                min-height: 100vh;
                padding: 26px;
                background: var(--create-bg);
                color: var(--create-text);
            }

            .enseignant-create-page *,
            .enseignant-create-page *::before,
            .enseignant-create-page *::after {
                box-sizing: border-box;
            }

            /* =====================================================
                   MODE SOMBRE
                ===================================================== */

            html[data-app-theme="dark"] .enseignant-create-page {
                --create-bg: #111827;
                --create-surface: #1e293b;
                --create-surface-soft: #263449;
                --create-text: #dce5f1;
                --create-heading: #f1f5f9;
                --create-muted: #a0aec0;
                --create-border: #35445b;
                --create-primary: #5799ef;
                --create-primary-dark: #83b5f8;
                --create-primary-soft: #263e5f;
                --create-shadow: 0 8px 28px rgba(0, 0, 0, .20);
            }

            /* =====================================================
                   ULTRA PRO
                ===================================================== */

            html[data-app-theme="ultra-pro"] .enseignant-create-page {
                --create-bg: #eef2f8;
                --create-surface: #ffffff;
                --create-surface-soft: #f5f7fb;
                --create-text: #29364b;
                --create-heading: #101d35;
                --create-muted: #748198;
                --create-border: #dce4ef;
                --create-primary: #315fa9;
                --create-primary-dark: #21477f;
                --create-primary-soft: #e8effb;
                --create-shadow: 0 12px 32px rgba(21, 42, 75, .10);
            }

            /* =====================================================
                   EMERALD
                ===================================================== */

            html[data-app-theme="emerald"] .enseignant-create-page {
                --create-bg: #edf7f3;
                --create-surface: #ffffff;
                --create-surface-soft: #f3faf7;
                --create-text: #23463d;
                --create-heading: #153c31;
                --create-muted: #718d82;
                --create-border: #d5e9df;
                --create-primary: #15966e;
                --create-primary-dark: #087653;
                --create-primary-soft: #e0f5ec;
                --create-shadow: 0 8px 28px rgba(20, 100, 75, .08);
            }

            /* =====================================================
                   WARM
                ===================================================== */

            html[data-app-theme="warm"] .enseignant-create-page {
                --create-bg: #f8f3ed;
                --create-surface: #fffdf9;
                --create-surface-soft: #faf5ed;
                --create-text: #554438;
                --create-heading: #392b20;
                --create-muted: #958474;
                --create-border: #eadfd2;
                --create-primary: #b77c40;
                --create-primary-dark: #94602d;
                --create-primary-soft: #f8ead8;
                --create-shadow: 0 8px 28px rgba(90, 60, 30, .07);
            }

            /* =====================================================
                   HERO
                ===================================================== */

            .enseignant-create-page .create-hero {
                position: relative;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                padding: 27px 30px;
                margin-bottom: 25px;
                border-radius: 20px;
                color: #ffffff;
                background: linear-gradient(120deg, #2874d0, #174c91);
                box-shadow: 0 10px 25px rgba(40, 100, 180, .18);
            }

            .enseignant-create-page .create-hero::before {
                content: "";
                position: absolute;
                width: 230px;
                height: 230px;
                right: 12%;
                top: -145px;
                border: 35px solid rgba(255, 255, 255, .10);
                border-radius: 50%;
            }

            .enseignant-create-page .create-hero-content {
                position: relative;
                z-index: 1;
            }

            .enseignant-create-page .create-hero h2 {
                margin: 0 0 8px;
                color: #ffffff;
                font-size: 25px;
                font-weight: 800;
            }

            .enseignant-create-page .create-hero p {
                margin: 0;
                color: rgba(255, 255, 255, .85);
                font-size: 14px;
            }

            .enseignant-create-page .create-hero-icon {
                position: relative;
                z-index: 1;
                width: 58px;
                height: 58px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-radius: 17px;
                background: rgba(255, 255, 255, .18);
                font-size: 27px;
            }

            .enseignant-create-page .create-back-btn {
                position: relative;
                z-index: 2;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                border: 1px solid rgba(255, 255, 255, .35);
                border-radius: 10px;
                color: #ffffff;
                background: rgba(255, 255, 255, .15);
                text-decoration: none;
                font-size: 13px;
                font-weight: 700;
                transition: .2s;
            }

            .enseignant-create-page .create-back-btn:hover {
                color: #ffffff;
                background: rgba(255, 255, 255, .28);
                transform: translateY(-2px);
            }

            /* =====================================================
                   CARTE PRINCIPALE
                ===================================================== */

            .enseignant-create-page .create-card {
                overflow: hidden;
                border: 1px solid var(--create-border);
                border-radius: 18px;
                background: var(--create-surface);
                box-shadow: var(--create-shadow);
            }

            .enseignant-create-page .create-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                padding: 19px 24px;
                border-bottom: 1px solid var(--create-border);
                background: var(--create-surface-soft);
            }

            .enseignant-create-page .create-card-heading {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .enseignant-create-page .create-card-icon {
                width: 41px;
                height: 41px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                color: var(--create-primary);
                background: var(--create-primary-soft);
                font-size: 20px;
            }

            .enseignant-create-page .create-card-header h5 {
                margin: 0;
                color: var(--create-heading);
                font-size: 16px;
                font-weight: 800;
            }

            .enseignant-create-page .create-card-header small {
                display: block;
                margin-top: 4px;
                color: var(--create-muted);
                font-size: 12px;
            }

            .enseignant-create-page .create-card-body {
                padding: 27px;
            }

            /* =====================================================
                   BANDEAU D'INFORMATION
                ===================================================== */

            .enseignant-create-page .create-info {
                display: flex;
                align-items: flex-start;
                gap: 13px;
                padding: 16px 18px;
                margin-bottom: 25px;
                border: 1px solid var(--create-border);
                border-radius: 12px;
                background: var(--create-primary-soft);
            }

            .enseignant-create-page .create-info-icon {
                flex-shrink: 0;
                color: var(--create-primary);
                font-size: 21px;
            }

            .enseignant-create-page .create-info strong {
                display: block;
                margin-bottom: 4px;
                color: var(--create-heading);
                font-size: 13px;
                font-weight: 800;
            }

            .enseignant-create-page .create-info p {
                margin: 0;
                color: var(--create-muted);
                font-size: 12px;
                line-height: 1.6;
            }

            /* =====================================================
                   FORMULAIRES
                ===================================================== */

            .enseignant-create-page .create-card-body .form-label {
                margin-bottom: 7px;
                color: var(--create-heading);
                font-size: 13px;
                font-weight: 700;
            }

            .enseignant-create-page .create-card-body .form-control,
            .enseignant-create-page .create-card-body .form-select {
                min-height: 43px;
                border: 1px solid var(--create-border);
                border-radius: 9px;
                background-color: var(--create-surface);
                color: var(--create-text);
                font-size: 13px;
                box-shadow: none;
            }

            .enseignant-create-page .create-card-body textarea.form-control {
                min-height: 100px;
            }

            .enseignant-create-page .create-card-body .form-control:focus,
            .enseignant-create-page .create-card-body .form-select:focus {
                border-color: var(--create-primary);
                box-shadow: 0 0 0 3px color-mix(in srgb, var(--create-primary) 15%, transparent);
            }

            .enseignant-create-page .create-card-body .form-control::placeholder {
                color: var(--create-muted);
                opacity: .8;
            }

            .enseignant-create-page .create-card-body .form-text {
                color: var(--create-muted);
                font-size: 11px;
            }

            .enseignant-create-page .create-card-body input[type="file"] {
                padding: 8px;
            }

            .enseignant-create-page .create-card-body input[type="file"]::file-selector-button {
                margin-right: 10px;
                padding: 6px 12px;
                border: none;
                border-radius: 7px;
                color: var(--create-primary);
                background: var(--create-primary-soft);
                font-size: 12px;
                font-weight: 700;
            }

            /* =====================================================
                   ALERTES
                ===================================================== */

            .enseignant-create-page .create-alert {
                padding: 16px 19px;
                margin-bottom: 20px;
                border-radius: 12px;
                font-size: 13px;
            }

            .enseignant-create-page .create-alert ul {
                padding-left: 20px;
            }

            .enseignant-create-page .create-alert li {
                margin-top: 4px;
            }

            /* =====================================================
                   PIED DU FORMULAIRE
                ===================================================== */

            .enseignant-create-page .create-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 12px;
                padding-top: 22px;
                margin-top: 25px;
                border-top: 1px solid var(--create-border);
            }

            .enseignant-create-page .create-footer-note {
                color: var(--create-muted);
                font-size: 12px;
            }

            .enseignant-create-page .create-footer-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .enseignant-create-page .create-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 10px 17px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 700;
                text-decoration: none;
                transition: .2s;
                cursor: pointer;
            }

            .enseignant-create-page .create-btn-save {
                color: #ffffff;
                border: 1px solid var(--create-primary);
                background: var(--create-primary);
                box-shadow: 0 5px 13px rgba(40, 100, 180, .15);
            }

            .enseignant-create-page .create-btn-save:hover {
                color: #ffffff;
                border-color: var(--create-primary-dark);
                background: var(--create-primary-dark);
                transform: translateY(-2px);
            }

            .enseignant-create-page .create-btn-cancel {
                color: var(--create-text);
                border: 1px solid var(--create-border);
                background: var(--create-surface);
            }

            .enseignant-create-page .create-btn-cancel:hover {
                color: var(--create-heading);
                background: var(--create-surface-soft);
            }

            /* =====================================================
                   RESPONSIVE
                ===================================================== */

            @media (max-width: 768px) {
                .enseignant-create-page {
                    padding: 15px;
                }

                .enseignant-create-page .create-hero {
                    padding: 22px;
                }

                .enseignant-create-page .create-hero h2 {
                    font-size: 20px;
                }

                .enseignant-create-page .create-card-body {
                    padding: 18px;
                }

                .enseignant-create-page .create-card-header {
                    padding: 16px;
                }

                .enseignant-create-page .create-footer {
                    align-items: stretch;
                    flex-direction: column;
                }

                .enseignant-create-page .create-footer-actions {
                    width: 100%;
                }

                .enseignant-create-page .create-footer-actions .create-btn {
                    flex: 1;
                }
            }

            @media (max-width: 480px) {
                .enseignant-create-page .create-hero-icon {
                    display: none;
                }

                .enseignant-create-page .create-hero {
                    align-items: flex-start;
                }

                .enseignant-create-page .create-info {
                    padding: 13px;
                }
            }
        </style>

        {{-- =====================================================
             BANDEAU PRINCIPAL
        ====================================================== --}}

        <div class="create-hero">

            <div class="create-hero-content">
                <h2>
                    <i class="bi bi-person-plus me-2"></i>
                    Ajouter un enseignant
                </h2>

                <p>
                    Enregistrez un nouvel enseignant dans votre établissement scolaire.
                </p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('enseignants.index') }}" class="create-back-btn">
                    <i class="bi bi-arrow-left"></i>
                    Retour à la liste
                </a>

                <div class="create-hero-icon">
                    <i class="bi bi-person-add"></i>
                </div>
            </div>

        </div>

        {{-- =====================================================
             ERREURS DE VALIDATION
        ====================================================== --}}

        @if ($errors->any())
            <div class="alert alert-danger create-alert">

                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{-- =====================================================
             CARTE DU FORMULAIRE
        ====================================================== --}}

        <div class="create-card">

            <div class="create-card-header">

                <div class="create-card-heading">

                    <div class="create-card-icon">
                        <i class="bi bi-person-vcard"></i>
                    </div>

                    <div>
                        <h5>Informations de l'enseignant</h5>
                        <small>Renseignez les informations nécessaires à la création de sa fiche</small>
                    </div>

                </div>

                <span class="badge rounded-pill px-3 py-2"
                    style="color: var(--create-primary); background: var(--create-primary-soft);">
                    <i class="bi bi-plus-circle me-1"></i>
                    Nouvelle fiche
                </span>

            </div>

            <div class="create-card-body">

                {{-- Informations complémentaires --}}

                <div class="create-info">

                    <div class="create-info-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>
                        <strong>Création d'une nouvelle fiche enseignant</strong>
                        <p>
                            Complétez les champs du formulaire avec les informations exactes.
                            Les champs obligatoires sont indiqués dans le formulaire.
                        </p>
                    </div>

                </div>

                {{-- Formulaire Laravel --}}

                <form action="{{ route('enseignants.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @include('enseignants._form', ['enseignant' => new \App\Models\Enseignant()])

                    {{-- Pied du formulaire --}}

                    <div class="create-footer">

                        <div class="create-footer-note">
                            <i class="bi bi-shield-check me-1"></i>
                            Vérifiez les informations avant de créer la fiche.
                        </div>

                        <div class="create-footer-actions">

                            <a href="{{ route('enseignants.index') }}" class="create-btn create-btn-cancel">
                                <i class="bi bi-x-circle"></i>
                                Annuler
                            </a>

                            <button type="submit" class="create-btn create-btn-save">
                                <i class="bi bi-check2-circle"></i>
                                Enregistrer l'enseignant
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
