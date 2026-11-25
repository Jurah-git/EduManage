@extends('layouts.app')

@section('content')

    <div class="types-create-page">

        {{-- EN-TÊTE --}}
        <div class="types-create-hero">

            <div class="types-create-hero-content">

                <div class="types-create-breadcrumb">
                    <a href="{{ route('frais.types.index') }}">
                        Gestion des frais
                    </a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Ajouter un type</span>
                </div>

                <div class="types-create-heading">

                    <div class="types-create-hero-icon">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>

                    <div>
                        <h2>Ajouter un type de frais</h2>
                        <p>
                            Créez une nouvelle catégorie de frais scolaires.
                        </p>
                    </div>

                </div>

            </div>

            <a href="{{ route('frais.types.index') }}" class="types-create-back">
                <i class="bi bi-arrow-left"></i>
                Retour à la liste
            </a>

        </div>

        {{-- ERREURS DE VALIDATION --}}
        @if ($errors->any())
            <div class="types-create-alert">

                <div class="types-create-alert-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>

                    <ul>
                        @foreach ($errors->all() as $erreur)
                            <li>{{ $erreur }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        @endif

        <div class="types-create-layout">

            {{-- FORMULAIRE --}}
            <div class="types-create-main-card">

                <div class="types-create-card-header">

                    <div class="types-create-card-header-icon">
                        <i class="bi bi-tags-fill"></i>
                    </div>

                    <div>
                        <h4>Informations du type de frais</h4>
                        <p>
                            Renseignez les informations nécessaires à sa création.
                        </p>
                    </div>

                </div>

                <div class="types-create-card-body">

                    <form action="{{ route('frais.types.store') }}" method="POST" id="formTypeFrais">

                        @csrf

                        {{-- NOM --}}
                        <div class="types-create-field">

                            <label for="nom">
                                Nom du frais
                                <span class="required">*</span>
                            </label>

                            <div class="types-create-input-wrap">
                                <i class="bi bi-receipt"></i>

                                <input type="text" name="nom" id="nom"
                                    class="@error('nom') is-invalid @enderror" value="{{ old('nom') }}"
                                    placeholder="Ex. : Écolage, Droit d'inscription, Transport..." maxlength="150" required>
                            </div>

                            @error('nom')
                                <div class="types-create-field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small>
                                Saisissez un nom clair et facilement identifiable.
                            </small>

                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="types-create-field">

                            <label for="description">
                                Description
                            </label>

                            <div class="types-create-textarea-wrap">
                                <i class="bi bi-card-text"></i>

                                <textarea name="description" id="description" rows="4" maxlength="1000"
                                    class="@error('description') is-invalid @enderror" placeholder="Description facultative du frais...">{{ old('description') }}</textarea>
                            </div>

                            @error('description')
                                <div class="types-create-field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small>
                                Facultatif. Maximum 1 000 caractères.
                            </small>

                        </div>

                        {{-- FREQUENCE --}}
                        <div class="types-create-field">

                            <label for="frequence">
                                Fréquence de facturation
                                <span class="required">*</span>
                            </label>

                            <div class="types-create-input-wrap">
                                <i class="bi bi-arrow-repeat"></i>

                                <select name="frequence" id="frequence" class="@error('frequence') is-invalid @enderror"
                                    required>

                                    <option value="">
                                        -- Choisir une fréquence --
                                    </option>

                                    <option value="unique" @selected(old('frequence') === 'unique')>
                                        Unique
                                    </option>

                                    <option value="mensuelle" @selected(old('frequence') === 'mensuelle')>
                                        Mensuelle
                                    </option>

                                    <option value="trimestrielle" @selected(old('frequence') === 'trimestrielle')>
                                        Trimestrielle
                                    </option>

                                    <option value="annuelle" @selected(old('frequence') === 'annuelle')>
                                        Annuelle
                                    </option>

                                </select>
                            </div>

                            @error('frequence')
                                <div class="types-create-field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small>
                                Détermine la périodicité de facturation des frais scolaires.
                            </small>

                        </div>

                        {{-- STATUT --}}
                        <div class="types-create-status-box">

                            <div class="types-create-status-icon">
                                <i class="bi bi-toggle-on"></i>
                            </div>

                            <div class="types-create-status-content">
                                <strong>Activation du type de frais</strong>
                                <p>
                                    Un type actif peut être utilisé dans la configuration
                                    des tarifs scolaires.
                                </p>
                            </div>

                            <label class="types-create-switch">
                                <input type="checkbox" name="actif" id="actif" value="1"
                                    @checked(old('actif', '1') == '1')>

                                <span class="types-create-switch-slider"></span>
                            </label>

                        </div>

                        <div class="types-create-status-indicator" id="statutTexte">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Ce type de frais sera créé comme actif.</span>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="types-create-actions">

                            <button type="submit" class="types-create-submit">
                                <i class="bi bi-check2-circle"></i>
                                Enregistrer le type de frais
                            </button>

                            <a href="{{ route('frais.types.index') }}" class="types-create-cancel">
                                <i class="bi bi-x-circle"></i>
                                Annuler
                            </a>

                        </div>

                    </form>

                </div>

            </div>

            {{-- PANNEAU LATERAL --}}
            <div class="types-create-sidebar">

                <div class="types-create-side-card">

                    <div class="types-create-side-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <h5>Comprendre les fréquences</h5>

                    <p>
                        Choisissez la fréquence correspondant à la manière
                        dont le frais doit être facturé.
                    </p>

                    <div class="types-create-frequency-list">

                        <div class="types-create-frequency-item">
                            <span class="frequency-dot purple"></span>
                            <div>
                                <strong>Unique</strong>
                                <small>Facturé une seule fois.</small>
                            </div>
                        </div>

                        <div class="types-create-frequency-item">
                            <span class="frequency-dot blue"></span>
                            <div>
                                <strong>Mensuelle</strong>
                                <small>Facturé chaque mois.</small>
                            </div>
                        </div>

                        <div class="types-create-frequency-item">
                            <span class="frequency-dot orange"></span>
                            <div>
                                <strong>Trimestrielle</strong>
                                <small>Facturé chaque trimestre.</small>
                            </div>
                        </div>

                        <div class="types-create-frequency-item">
                            <span class="frequency-dot green"></span>
                            <div>
                                <strong>Annuelle</strong>
                                <small>Facturé une fois par année scolaire.</small>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="types-create-side-card types-create-tip-card">

                    <div class="types-create-tip-icon">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>

                    <h5>Conseil de configuration</h5>

                    <p>
                        Par exemple :
                    </p>

                    <ul>
                        <li>Écolage : mensuelle.</li>
                        <li>Frais d'inscription : unique.</li>
                        <li>Frais de réinscription : annuelle.</li>
                        <li>Frais de transport : selon votre organisation.</li>
                    </ul>

                    <p class="mb-0">
                        Après la création du type, vous pourrez configurer
                        les montants dans la rubrique des tarifs scolaires.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <style>
        /* =====================================================
       TYPES DE FRAIS - CREATE
    ===================================================== */

        .types-create-page {
            --tc-bg: #f5f7fb;
            --tc-card: #ffffff;
            --tc-text: #253247;
            --tc-muted: #748094;
            --tc-border: #e5eaf1;
            --tc-primary: #4f46e5;
            --tc-primary-soft: #eef0ff;
            --tc-shadow: 0 8px 28px rgba(28, 39, 60, .055);

            padding: 22px;
            color: var(--tc-text);
        }

        /* DARK */
        html[data-app-theme="dark"] .types-create-page {
            --tc-bg: #151b28;
            --tc-card: #202a3a;
            --tc-text: #e7edf7;
            --tc-muted: #a5b1c3;
            --tc-border: #354257;
            --tc-primary: #9b9aff;
            --tc-primary-soft: #34334f;
            --tc-shadow: 0 8px 28px rgba(0, 0, 0, .18);
        }

        /* ULTRA PRO */
        html[data-app-theme="ultra-pro"] .types-create-page {
            --tc-bg: #101827;
            --tc-card: #192538;
            --tc-text: #edf4ff;
            --tc-muted: #a8b8ce;
            --tc-border: #34445c;
            --tc-primary: #60a5fa;
            --tc-primary-soft: #263d5b;
            --tc-shadow: 0 8px 28px rgba(0, 0, 0, .2);
        }

        /* EMERALD */
        html[data-app-theme="emerald"] .types-create-page {
            --tc-bg: #f0f8f4;
            --tc-card: #ffffff;
            --tc-text: #174b37;
            --tc-muted: #668878;
            --tc-border: #d5e9de;
            --tc-primary: #059669;
            --tc-primary-soft: #e2f5eb;
            --tc-shadow: 0 8px 28px rgba(16, 100, 65, .06);
        }

        /* WARM */
        html[data-app-theme="warm"] .types-create-page {
            --tc-bg: #fbf5ee;
            --tc-card: #fffdf9;
            --tc-text: #55402e;
            --tc-muted: #927d69;
            --tc-border: #eadfd1;
            --tc-primary: #c17b42;
            --tc-primary-soft: #f8ebdc;
            --tc-shadow: 0 8px 28px rgba(120, 75, 35, .06);
        }

        /* HERO */
        .types-create-hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 27px 30px;
            margin-bottom: 25px;
            border-radius: 18px;
            color: #fff;
            background: linear-gradient(120deg, #3730a3, #6366f1 60%, #818cf8);
            box-shadow: 0 12px 30px rgba(79, 70, 229, .18);
        }

        .types-create-breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 17px;
            color: rgba(255, 255, 255, .75);
            font-size: 12px;
        }

        .types-create-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .types-create-breadcrumb a:hover {
            text-decoration: underline;
        }

        .types-create-heading {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .types-create-hero-icon {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: rgba(255, 255, 255, .17);
            font-size: 24px;
        }

        .types-create-heading h2 {
            color: #fff;
            font-size: 23px;
            font-weight: 800;
            margin: 0 0 5px;
        }

        .types-create-heading p {
            color: rgba(255, 255, 255, .8);
            font-size: 13px;
            margin: 0;
        }

        .types-create-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 15px;
            border: 1px solid rgba(255, 255, 255, .4);
            border-radius: 10px;
            color: #fff;
            background: rgba(255, 255, 255, .12);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s;
        }

        .types-create-back:hover {
            color: #fff;
            background: rgba(255, 255, 255, .22);
        }

        /* ALERTES */
        .types-create-alert {
            display: flex;
            gap: 13px;
            padding: 16px 18px;
            margin-bottom: 22px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            color: #991b1b;
            background: #fef2f2;
        }

        .types-create-alert-icon {
            font-size: 21px;
        }

        .types-create-alert strong {
            font-size: 13px;
        }

        .types-create-alert ul {
            margin: 8px 0 0;
            padding-left: 18px;
            font-size: 12px;
        }

        /* LAYOUT */
        .types-create-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 310px;
            gap: 20px;
            align-items: start;
        }

        .types-create-main-card,
        .types-create-side-card {
            border: 1px solid var(--tc-border);
            border-radius: 15px;
            background: var(--tc-card);
            box-shadow: var(--tc-shadow);
            overflow: hidden;
        }

        /* FORM HEADER */
        .types-create-card-header {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 19px 23px;
            border-bottom: 1px solid var(--tc-border);
        }

        .types-create-card-header-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--tc-primary);
            background: var(--tc-primary-soft);
            border-radius: 12px;
            font-size: 19px;
        }

        .types-create-card-header h4 {
            color: var(--tc-text);
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 4px;
        }

        .types-create-card-header p {
            color: var(--tc-muted);
            font-size: 11px;
            margin: 0;
        }

        .types-create-card-body {
            padding: 24px;
        }

        /* CHAMPS */
        .types-create-field {
            margin-bottom: 22px;
        }

        .types-create-field>label {
            display: block;
            color: var(--tc-text);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .types-create-field .required {
            color: #ef4444;
        }

        .types-create-input-wrap,
        .types-create-textarea-wrap {
            position: relative;
        }

        .types-create-input-wrap>i,
        .types-create-textarea-wrap>i {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 1;
            color: var(--tc-muted);
            font-size: 15px;
            pointer-events: none;
        }

        .types-create-input-wrap input,
        .types-create-input-wrap select,
        .types-create-textarea-wrap textarea {
            width: 100%;
            border: 1px solid var(--tc-border);
            border-radius: 10px;
            outline: none;
            color: var(--tc-text);
            background: var(--tc-bg);
            font-family: inherit;
            font-size: 13px;
            transition: .2s;
        }

        .types-create-input-wrap input,
        .types-create-input-wrap select {
            min-height: 46px;
            padding: 10px 13px 10px 42px;
        }

        .types-create-input-wrap select {
            cursor: pointer;
        }

        .types-create-textarea-wrap textarea {
            min-height: 115px;
            padding: 13px 14px 13px 42px;
            resize: vertical;
        }

        .types-create-input-wrap input:focus,
        .types-create-input-wrap select:focus,
        .types-create-textarea-wrap textarea:focus {
            border-color: var(--tc-primary);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--tc-primary) 15%, transparent);
        }

        .types-create-input-wrap input.is-invalid,
        .types-create-input-wrap select.is-invalid,
        .types-create-textarea-wrap textarea.is-invalid {
            border-color: #dc3545;
        }

        .types-create-field small {
            display: block;
            color: var(--tc-muted);
            font-size: 11px;
            margin-top: 7px;
        }

        .types-create-field-error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 6px;
        }

        /* STATUT */
        .types-create-status-box {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 16px;
            margin-top: 7px;
            border: 1px solid var(--tc-border);
            border-radius: 12px;
            background: var(--tc-bg);
        }

        .types-create-status-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 11px;
            color: var(--tc-primary);
            background: var(--tc-primary-soft);
            font-size: 20px;
        }

        .types-create-status-content {
            flex: 1;
        }

        .types-create-status-content strong {
            display: block;
            color: var(--tc-text);
            font-size: 13px;
            margin-bottom: 4px;
        }

        .types-create-status-content p {
            color: var(--tc-muted);
            font-size: 11px;
            margin: 0;
            line-height: 1.5;
        }

        /* SWITCH */
        .types-create-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
            cursor: pointer;
        }

        .types-create-switch input {
            width: 0;
            height: 0;
            opacity: 0;
        }

        .types-create-switch-slider {
            position: absolute;
            inset: 0;
            border-radius: 30px;
            background: #94a3b8;
            transition: .25s;
        }

        .types-create-switch-slider::before {
            position: absolute;
            content: "";
            width: 20px;
            height: 20px;
            left: 3px;
            top: 3px;
            border-radius: 50%;
            background: #fff;
            transition: .25s;
        }

        .types-create-switch input:checked+.types-create-switch-slider {
            background: #16a34a;
        }

        .types-create-switch input:checked+.types-create-switch-slider::before {
            transform: translateX(22px);
        }

        .types-create-switch input:focus-visible+.types-create-switch-slider {
            outline: 3px solid var(--tc-primary);
            outline-offset: 3px;
        }

        .types-create-status-indicator {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 10px;
            color: #15803d;
            font-size: 11px;
            font-weight: 700;
        }

        .types-create-status-indicator.inactive {
            color: var(--tc-muted);
        }

        /* ACTIONS */
        .types-create-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 22px;
            margin-top: 22px;
            border-top: 1px solid var(--tc-border);
        }

        .types-create-submit,
        .types-create-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 43px;
            padding: 10px 17px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: .2s;
            cursor: pointer;
        }

        .types-create-submit {
            border: 0;
            color: #fff;
            background: linear-gradient(120deg, #4338ca, #6366f1);
        }

        .types-create-submit:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, .2);
        }

        .types-create-cancel {
            color: var(--tc-text);
            border: 1px solid var(--tc-border);
            background: var(--tc-bg);
        }

        .types-create-cancel:hover {
            color: var(--tc-primary);
            border-color: var(--tc-primary);
        }

        /* PANNEAU LATERAL */
        .types-create-sidebar {
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .types-create-side-card {
            padding: 21px;
        }

        .types-create-side-icon,
        .types-create-tip-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 19px;
            margin-bottom: 13px;
        }

        .types-create-side-icon {
            color: var(--tc-primary);
            background: var(--tc-primary-soft);
        }

        .types-create-side-card h5 {
            color: var(--tc-text);
            font-size: 14px;
            font-weight: 800;
            margin: 0 0 8px;
        }

        .types-create-side-card>p {
            color: var(--tc-muted);
            font-size: 11px;
            line-height: 1.7;
            margin-bottom: 15px;
        }

        .types-create-frequency-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--tc-border);
        }

        .types-create-frequency-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .frequency-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .frequency-dot.purple {
            background: #8b5cf6;
        }

        .frequency-dot.blue {
            background: #3b82f6;
        }

        .frequency-dot.orange {
            background: #f97316;
        }

        .frequency-dot.green {
            background: #16a34a;
        }

        .types-create-frequency-item strong {
            display: block;
            color: var(--tc-text);
            font-size: 12px;
            margin-bottom: 3px;
        }

        .types-create-frequency-item small {
            display: block;
            color: var(--tc-muted);
            font-size: 10px;
        }

        /* CONSEIL */
        .types-create-tip-card {
            border-color: var(--tc-border);
        }

        .types-create-tip-icon {
            color: #c2410c;
            background: #ffedd5;
        }

        .types-create-tip-card ul {
            padding-left: 18px;
            color: var(--tc-muted);
            font-size: 11px;
            line-height: 1.9;
        }

        /* RESPONSIVE */
        @media (max-width: 1000px) {
            .types-create-layout {
                grid-template-columns: minmax(0, 1fr) 260px;
            }
        }

        @media (max-width: 800px) {
            .types-create-layout {
                grid-template-columns: 1fr;
            }

            .types-create-sidebar {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .types-create-page {
                padding: 12px;
            }

            .types-create-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 21px;
            }

            .types-create-back {
                width: 100%;
                justify-content: center;
            }

            .types-create-heading h2 {
                font-size: 19px;
            }

            .types-create-card-body {
                padding: 17px;
            }

            .types-create-sidebar {
                grid-template-columns: 1fr;
            }

            .types-create-actions {
                flex-direction: column;
            }

            .types-create-submit,
            .types-create-cancel {
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const actif = document.getElementById('actif');
            const statutTexte = document.getElementById('statutTexte');

            function actualiserStatut() {
                if (!actif || !statutTexte) return;

                if (actif.checked) {
                    statutTexte.classList.remove('inactive');
                    statutTexte.innerHTML =
                        '<i class="bi bi-check-circle-fill"></i><span>Ce type de frais sera créé comme actif.</span>';
                } else {
                    statutTexte.classList.add('inactive');
                    statutTexte.innerHTML =
                        '<i class="bi bi-pause-circle-fill"></i><span>Ce type de frais sera créé comme inactif.</span>';
                }
            }

            if (actif) {
                actif.addEventListener('change', actualiserStatut);
                actualiserStatut();
            }

        });
    </script>

@endsection
