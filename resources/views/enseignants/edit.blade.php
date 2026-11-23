@extends('layouts.app')

@section('content')

    <div class="enseignant-edit-page">

        <style>
            /* =====================================================
                   ENSEIGNANTS - MODIFICATION
                ===================================================== */

            .enseignant-edit-page {
                --edit-bg: #f3f6fc;
                --edit-surface: #ffffff;
                --edit-surface-soft: #f8faff;
                --edit-text: #26364d;
                --edit-heading: #172b4d;
                --edit-muted: #78869b;
                --edit-border: #e4eaf2;
                --edit-accent: #d99a20;
                --edit-accent-dark: #b7790c;
                --edit-accent-soft: #fff5dc;
                --edit-shadow: 0 8px 28px rgba(30, 50, 80, .07);

                min-height: 100vh;
                padding: 26px;
                background: var(--edit-bg);
                color: var(--edit-text);
            }

            .enseignant-edit-page *,
            .enseignant-edit-page *::before,
            .enseignant-edit-page *::after {
                box-sizing: border-box;
            }

            /* =====================================================
                   MODE SOMBRE
                ===================================================== */

            html[data-app-theme="dark"] .enseignant-edit-page {
                --edit-bg: #111827;
                --edit-surface: #1e293b;
                --edit-surface-soft: #263449;
                --edit-text: #dce5f1;
                --edit-heading: #f1f5f9;
                --edit-muted: #a0aec0;
                --edit-border: #35445b;
                --edit-accent: #f0b642;
                --edit-accent-dark: #ffd16d;
                --edit-accent-soft: #493a20;
                --edit-shadow: 0 8px 28px rgba(0, 0, 0, .20);
            }

            /* =====================================================
                   ULTRA PRO
                ===================================================== */

            html[data-app-theme="ultra-pro"] .enseignant-edit-page {
                --edit-bg: #eef2f8;
                --edit-surface: #ffffff;
                --edit-surface-soft: #f5f7fb;
                --edit-text: #29364b;
                --edit-heading: #101d35;
                --edit-muted: #748198;
                --edit-border: #dce4ef;
                --edit-accent: #e0a126;
                --edit-accent-dark: #b77b12;
                --edit-accent-soft: #fff3d5;
                --edit-shadow: 0 12px 32px rgba(21, 42, 75, .10);
            }

            /* =====================================================
                   EMERALD
                ===================================================== */

            html[data-app-theme="emerald"] .enseignant-edit-page {
                --edit-bg: #edf7f3;
                --edit-surface: #ffffff;
                --edit-surface-soft: #f3faf7;
                --edit-text: #23463d;
                --edit-heading: #153c31;
                --edit-muted: #718d82;
                --edit-border: #d5e9df;
                --edit-accent: #15966e;
                --edit-accent-dark: #087653;
                --edit-accent-soft: #e0f5ec;
                --edit-shadow: 0 8px 28px rgba(20, 100, 75, .08);
            }

            /* =====================================================
                   WARM
                ===================================================== */

            html[data-app-theme="warm"] .enseignant-edit-page {
                --edit-bg: #f8f3ed;
                --edit-surface: #fffdf9;
                --edit-surface-soft: #faf5ed;
                --edit-text: #554438;
                --edit-heading: #392b20;
                --edit-muted: #958474;
                --edit-border: #eadfd2;
                --edit-accent: #c58a48;
                --edit-accent-dark: #9e6730;
                --edit-accent-soft: #f8ead8;
                --edit-shadow: 0 8px 28px rgba(90, 60, 30, .07);
            }

            /* =====================================================
                   HERO
                ===================================================== */

            .enseignant-edit-page .edit-hero {
                position: relative;
                overflow: hidden;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
                padding: 27px 30px;
                margin-bottom: 25px;
                border-radius: 20px;
                color: #ffffff;
                background: linear-gradient(120deg, #d69a25, #a96c12);
                box-shadow: 0 10px 25px rgba(180, 120, 20, .18);
            }

            .enseignant-edit-page .edit-hero::before {
                content: "";
                position: absolute;
                width: 230px;
                height: 230px;
                right: 10%;
                top: -145px;
                border: 35px solid rgba(255, 255, 255, .10);
                border-radius: 50%;
            }

            .enseignant-edit-page .edit-hero-content {
                position: relative;
                z-index: 1;
            }

            .enseignant-edit-page .edit-hero h2 {
                margin: 0 0 8px;
                font-size: 25px;
                font-weight: 800;
                color: #ffffff;
            }

            .enseignant-edit-page .edit-hero p {
                margin: 0;
                color: rgba(255, 255, 255, .85);
                font-size: 14px;
            }

            .enseignant-edit-page .edit-hero-icon {
                position: relative;
                z-index: 1;
                width: 58px;
                height: 58px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 17px;
                background: rgba(255, 255, 255, .18);
                font-size: 27px;
            }

            /* =====================================================
                   BOUTONS
                ===================================================== */

            .enseignant-edit-page .edit-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 10px 17px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 700;
                text-decoration: none;
                transition: all .2s ease;
                cursor: pointer;
            }

            .enseignant-edit-page .edit-btn-back {
                color: #ffffff;
                border: 1px solid rgba(255, 255, 255, .35);
                background: rgba(255, 255, 255, .15);
            }

            .enseignant-edit-page .edit-btn-back:hover {
                color: #ffffff;
                background: rgba(255, 255, 255, .27);
                transform: translateY(-2px);
            }

            .enseignant-edit-page .edit-btn-save {
                color: #ffffff;
                border: none;
                background: var(--edit-accent);
                box-shadow: 0 5px 13px rgba(180, 120, 20, .18);
            }

            .enseignant-edit-page .edit-btn-save:hover {
                color: #ffffff;
                background: var(--edit-accent-dark);
                transform: translateY(-2px);
            }

            .enseignant-edit-page .edit-btn-cancel {
                color: var(--edit-text);
                border: 1px solid var(--edit-border);
                background: var(--edit-surface);
            }

            .enseignant-edit-page .edit-btn-cancel:hover {
                color: var(--edit-heading);
                background: var(--edit-surface-soft);
                border-color: var(--edit-muted);
            }

            /* =====================================================
                   CARTE PRINCIPALE
                ===================================================== */

            .enseignant-edit-page .edit-card {
                overflow: hidden;
                border: 1px solid var(--edit-border);
                border-radius: 17px;
                background: var(--edit-surface);
                box-shadow: var(--edit-shadow);
            }

            .enseignant-edit-page .edit-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                padding: 19px 24px;
                border-bottom: 1px solid var(--edit-border);
                background: var(--edit-surface-soft);
            }

            .enseignant-edit-page .edit-card-title {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .enseignant-edit-page .edit-card-icon {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                color: var(--edit-accent-dark);
                background: var(--edit-accent-soft);
                font-size: 19px;
            }

            .enseignant-edit-page .edit-card-header h5 {
                margin: 0;
                color: var(--edit-heading);
                font-size: 16px;
                font-weight: 800;
            }

            .enseignant-edit-page .edit-card-header small {
                display: block;
                margin-top: 4px;
                color: var(--edit-muted);
                font-size: 12px;
            }

            .enseignant-edit-page .edit-card-body {
                padding: 27px;
            }

            /* =====================================================
                   INFORMATIONS ENSEIGNANT
                ===================================================== */

            .enseignant-edit-page .teacher-summary {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 17px;
                margin-bottom: 25px;
                border: 1px solid var(--edit-border);
                border-radius: 13px;
                background: var(--edit-surface-soft);
            }

            .enseignant-edit-page .teacher-avatar {
                width: 53px;
                height: 53px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                border-radius: 15px;
                color: var(--edit-accent-dark);
                background: var(--edit-accent-soft);
                font-size: 22px;
            }

            .enseignant-edit-page .teacher-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .enseignant-edit-page .teacher-summary strong {
                display: block;
                color: var(--edit-heading);
                font-size: 15px;
                font-weight: 800;
            }

            .enseignant-edit-page .teacher-summary small {
                display: block;
                margin-top: 4px;
                color: var(--edit-muted);
                font-size: 12px;
            }

            /* =====================================================
                   FORMULAIRES
                ===================================================== */

            .enseignant-edit-page .edit-card-body .form-label {
                margin-bottom: 7px;
                color: var(--edit-heading);
                font-size: 13px;
                font-weight: 700;
            }

            .enseignant-edit-page .edit-card-body .form-control,
            .enseignant-edit-page .edit-card-body .form-select {
                min-height: 43px;
                border: 1px solid var(--edit-border);
                border-radius: 9px;
                background-color: var(--edit-surface);
                color: var(--edit-text);
                font-size: 13px;
                box-shadow: none;
            }

            .enseignant-edit-page .edit-card-body textarea.form-control {
                min-height: 100px;
            }

            .enseignant-edit-page .edit-card-body .form-control:focus,
            .enseignant-edit-page .edit-card-body .form-select:focus {
                border-color: var(--edit-accent);
                box-shadow: 0 0 0 3px color-mix(in srgb, var(--edit-accent) 15%, transparent);
            }

            .enseignant-edit-page .edit-card-body .form-control::placeholder {
                color: var(--edit-muted);
                opacity: .8;
            }

            .enseignant-edit-page .edit-card-body .form-text {
                color: var(--edit-muted);
                font-size: 11px;
            }

            .enseignant-edit-page .edit-card-body input[type="file"] {
                padding: 8px;
            }

            .enseignant-edit-page .edit-card-body input[type="file"]::file-selector-button {
                margin-right: 10px;
                padding: 6px 12px;
                border: none;
                border-radius: 7px;
                color: var(--edit-accent-dark);
                background: var(--edit-accent-soft);
                font-size: 12px;
                font-weight: 700;
            }

            /* =====================================================
                   ALERTES
                ===================================================== */

            .enseignant-edit-page .edit-alert {
                padding: 16px 19px;
                margin-bottom: 20px;
                border-radius: 12px;
                font-size: 13px;
            }

            .enseignant-edit-page .edit-alert ul {
                padding-left: 20px;
            }

            .enseignant-edit-page .edit-alert li {
                margin-top: 4px;
            }

            /* =====================================================
                   PIED DU FORMULAIRE
                ===================================================== */

            .enseignant-edit-page .edit-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 12px;
                padding-top: 22px;
                margin-top: 25px;
                border-top: 1px solid var(--edit-border);
            }

            .enseignant-edit-page .edit-footer-note {
                color: var(--edit-muted);
                font-size: 12px;
            }

            .enseignant-edit-page .edit-footer-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            /* =====================================================
                   RESPONSIVE
                ===================================================== */

            @media (max-width: 768px) {
                .enseignant-edit-page {
                    padding: 15px;
                }

                .enseignant-edit-page .edit-hero {
                    padding: 22px;
                }

                .enseignant-edit-page .edit-hero h2 {
                    font-size: 20px;
                }

                .enseignant-edit-page .edit-card-body {
                    padding: 18px;
                }

                .enseignant-edit-page .edit-card-header {
                    padding: 16px;
                }

                .enseignant-edit-page .edit-footer {
                    align-items: stretch;
                    flex-direction: column;
                }

                .enseignant-edit-page .edit-footer-actions {
                    width: 100%;
                }

                .enseignant-edit-page .edit-footer-actions .edit-btn {
                    flex: 1;
                }
            }

            @media (max-width: 480px) {
                .enseignant-edit-page .edit-hero-icon {
                    display: none;
                }

                .enseignant-edit-page .edit-hero {
                    align-items: flex-start;
                }

                .enseignant-edit-page .teacher-summary {
                    align-items: flex-start;
                }
            }
        </style>

        {{-- =====================================================
             BANDEAU PRINCIPAL
        ====================================================== --}}

        <div class="edit-hero">

            <div class="edit-hero-content">
                <h2>
                    <i class="bi bi-pencil-square me-2"></i>
                    Modifier un enseignant
                </h2>

                <p>
                    Modifiez les informations personnelles et professionnelles de l'enseignant.
                </p>
            </div>

            <div class="d-flex align-items-center gap-3 position-relative">
                <a href="{{ route('enseignants.index') }}" class="edit-btn edit-btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Retour
                </a>

                <div class="edit-hero-icon">
                    <i class="bi bi-person-gear"></i>
                </div>
            </div>

        </div>

        {{-- =====================================================
             ERREURS DE VALIDATION
        ====================================================== --}}

        @if ($errors->any())
            <div class="alert alert-danger edit-alert">
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
             CARTE DE MODIFICATION
        ====================================================== --}}

        <div class="edit-card">

            <div class="edit-card-header">

                <div class="edit-card-title">
                    <div class="edit-card-icon">
                        <i class="bi bi-person-vcard"></i>
                    </div>

                    <div>
                        <h5>Informations de l'enseignant</h5>
                        <small>Modification de la fiche professionnelle</small>
                    </div>
                </div>

                <span class="badge rounded-pill px-3 py-2"
                    style="background: var(--edit-accent-soft); color: var(--edit-accent-dark);">
                    <i class="bi bi-pencil me-1"></i>
                    Modification
                </span>

            </div>

            <div class="edit-card-body">

                {{-- Résumé de l'enseignant --}}

                <div class="teacher-summary">

                    <div class="teacher-avatar">
                        @if ($enseignant->photo)
                            <img src="{{ asset('storage/' . $enseignant->photo) }}"
                                alt="Photo de {{ $enseignant->prenom }} {{ $enseignant->nom }}">
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif
                    </div>

                    <div>
                        <strong>
                            {{ $enseignant->prenom }} {{ $enseignant->nom }}
                        </strong>

                        <small>
                            <i class="bi bi-person-badge me-1"></i>
                            Matricule :
                            {{ $enseignant->matricule ?? 'Non renseigné' }}
                        </small>
                    </div>

                </div>

                {{-- Formulaire Laravel --}}

                <form action="{{ route('enseignants.update', $enseignant) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    @include('enseignants._form')

                    {{-- Pied du formulaire --}}

                    <div class="edit-footer">

                        <div class="edit-footer-note">
                            <i class="bi bi-info-circle me-1"></i>
                            Vérifiez les informations avant d'enregistrer.
                        </div>

                        <div class="edit-footer-actions">

                            <a href="{{ route('enseignants.index') }}" class="edit-btn edit-btn-cancel">
                                <i class="bi bi-x-circle"></i>
                                Annuler
                            </a>

                            <button type="submit" class="edit-btn edit-btn-save">
                                <i class="bi bi-check2-circle"></i>
                                Enregistrer les modifications
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
