@extends('layouts.app')

@section('content')

    <div class="types-edit-page">

        {{-- EN-TÊTE --}}
        <div class="types-edit-hero">

            <div class="types-edit-hero-content">

                <div class="types-edit-breadcrumb">
                    <a href="{{ route('frais.types.index') }}">
                        Gestion des frais
                    </a>
                    <i class="bi bi-chevron-right"></i>
                    <a href="{{ route('frais.types.show', $type->id) }}">
                        Détail du type
                    </a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Modification</span>
                </div>

                <div class="types-edit-heading">

                    <div class="types-edit-hero-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div>
                        <h2>Modifier un type de frais</h2>
                        <p>
                            Modifiez les informations et les paramètres de facturation.
                        </p>
                    </div>

                </div>

            </div>

            <a href="{{ route('frais.types.index') }}" class="types-edit-back">
                <i class="bi bi-arrow-left"></i>
                Retour à la liste
            </a>

        </div>

        {{-- ERREURS DE VALIDATION --}}
        @if ($errors->any())
            <div class="types-edit-alert">

                <div class="types-edit-alert-icon">
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

        <div class="types-edit-layout">

            {{-- FORMULAIRE --}}
            <div class="types-edit-main-card">

                <div class="types-edit-card-header">

                    <div class="types-edit-card-header-icon">
                        <i class="bi bi-tags-fill"></i>
                    </div>

                    <div>
                        <h4>Informations du type de frais</h4>
                        <p>
                            Modifiez les informations générales ci-dessous.
                        </p>
                    </div>

                </div>

                <div class="types-edit-card-body">

                    <form action="{{ route('frais.types.update', $type->id) }}" method="POST" id="formTypeFrais">

                        @csrf
                        @method('PUT')

                        {{-- NOM --}}
                        <div class="types-edit-field">

                            <label for="nom">
                                Nom du frais
                                <span class="required">*</span>
                            </label>

                            <div class="types-edit-input-wrap">
                                <i class="bi bi-receipt"></i>

                                <input type="text" name="nom" id="nom"
                                    class="@error('nom') is-invalid @enderror" value="{{ old('nom', $type->nom) }}"
                                    maxlength="150" placeholder="Ex : Frais de scolarité" required>
                            </div>

                            @error('nom')
                                <div class="types-edit-field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small>
                                Donnez un nom clair et facilement identifiable.
                            </small>

                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="types-edit-field">

                            <label for="description">
                                Description
                            </label>

                            <div class="types-edit-textarea-wrap">
                                <i class="bi bi-card-text"></i>

                                <textarea name="description" id="description" rows="4" maxlength="1000"
                                    class="@error('description') is-invalid @enderror" placeholder="Décrivez brièvement ce type de frais...">{{ old('description', $type->description) }}</textarea>
                            </div>

                            @error('description')
                                <div class="types-edit-field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small>
                                Facultatif. Maximum 1 000 caractères.
                            </small>

                        </div>

                        {{-- FREQUENCE --}}
                        <div class="types-edit-field">

                            <label for="frequence">
                                Fréquence de facturation
                                <span class="required">*</span>
                            </label>

                            <div class="types-edit-input-wrap">
                                <i class="bi bi-arrow-repeat"></i>

                                <select name="frequence" id="frequence" class="@error('frequence') is-invalid @enderror"
                                    required>

                                    <option value="">
                                        -- Choisir une fréquence --
                                    </option>

                                    <option value="unique" @selected(old('frequence', $type->frequence) === 'unique')>
                                        Unique
                                    </option>

                                    <option value="mensuelle" @selected(old('frequence', $type->frequence) === 'mensuelle')>
                                        Mensuelle
                                    </option>

                                    <option value="trimestrielle" @selected(old('frequence', $type->frequence) === 'trimestrielle')>
                                        Trimestrielle
                                    </option>

                                    <option value="annuelle" @selected(old('frequence', $type->frequence) === 'annuelle')>
                                        Annuelle
                                    </option>

                                </select>
                            </div>

                            @error('frequence')
                                <div class="types-edit-field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small>
                                Détermine la périodicité de génération des frais scolaires.
                            </small>

                        </div>

                        {{-- STATUT --}}
                        <div class="types-edit-status-box">

                            <div class="types-edit-status-icon">
                                <i class="bi bi-toggle-on"></i>
                            </div>

                            <div class="types-edit-status-content">
                                <strong>Activation du type de frais</strong>
                                <p>
                                    Un type actif peut être utilisé dans la configuration
                                    des tarifs scolaires.
                                </p>
                            </div>

                            <label class="types-edit-switch">
                                <input type="checkbox" name="actif" id="actif" value="1"
                                    @checked(old('actif', $type->actif))>

                                <span class="types-edit-switch-slider"></span>
                            </label>

                        </div>

                        <div class="types-edit-status-indicator" id="statutTexte">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Ce type de frais est actif.</span>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="types-edit-actions">

                            <button type="submit" class="types-edit-submit">
                                <i class="bi bi-check2-circle"></i>
                                Enregistrer les modifications
                            </button>

                            <a href="{{ route('frais.types.index') }}" class="types-edit-cancel">
                                <i class="bi bi-x-circle"></i>
                                Annuler
                            </a>

                        </div>

                    </form>

                </div>

            </div>

            {{-- PANNEAU LATERAL --}}
            <div class="types-edit-sidebar">

                <div class="types-edit-side-card">

                    <div class="types-edit-side-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <h5>Informations importantes</h5>

                    <p>
                        La fréquence détermine comment les frais sont organisés
                        dans le système.
                    </p>

                    <div class="types-edit-frequency-list">

                        <div class="types-edit-frequency-item">
                            <span class="frequency-dot purple"></span>
                            <div>
                                <strong>Unique</strong>
                                <small>Facturé une seule fois.</small>
                            </div>
                        </div>

                        <div class="types-edit-frequency-item">
                            <span class="frequency-dot blue"></span>
                            <div>
                                <strong>Mensuelle</strong>
                                <small>Facturé chaque mois.</small>
                            </div>
                        </div>

                        <div class="types-edit-frequency-item">
                            <span class="frequency-dot orange"></span>
                            <div>
                                <strong>Trimestrielle</strong>
                                <small>Facturé chaque trimestre.</small>
                            </div>
                        </div>

                        <div class="types-edit-frequency-item">
                            <span class="frequency-dot green"></span>
                            <div>
                                <strong>Annuelle</strong>
                                <small>Facturé une fois par année scolaire.</small>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="types-edit-side-card types-edit-warning-card">

                    <div class="types-edit-warning-icon">
                        <i class="bi bi-shield-exclamation"></i>
                    </div>

                    <h5>Attention aux modifications</h5>

                    <p>
                        Modifier la fréquence d'un type de frais déjà utilisé
                        dans des tarifs scolaires peut affecter la cohérence
                        de votre configuration financière.
                    </p>

                    <p class="mb-0">
                        Vérifiez les tarifs associés avant de modifier ce paramètre.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <style>
        /* =====================================================
       TYPES DE FRAIS - EDIT
    ===================================================== */

        .types-edit-page {
            --te-bg: #f5f7fb;
            --te-card: #ffffff;
            --te-text: #253247;
            --te-muted: #748094;
            --te-border: #e5eaf1;
            --te-primary: #4f46e5;
            --te-primary-soft: #eef0ff;
            --te-shadow: 0 8px 28px rgba(28, 39, 60, .055);

            padding: 22px;
            color: var(--te-text);
        }

        /* DARK */
        html[data-app-theme="dark"] .types-edit-page {
            --te-bg: #151b28;
            --te-card: #202a3a;
            --te-text: #e7edf7;
            --te-muted: #a5b1c3;
            --te-border: #354257;
            --te-primary: #9b9aff;
            --te-primary-soft: #34334f;
            --te-shadow: 0 8px 28px rgba(0, 0, 0, .18);
        }

        /* ULTRA PRO */
        html[data-app-theme="ultra-pro"] .types-edit-page {
            --te-bg: #101827;
            --te-card: #192538;
            --te-text: #edf4ff;
            --te-muted: #a8b8ce;
            --te-border: #34445c;
            --te-primary: #60a5fa;
            --te-primary-soft: #263d5b;
            --te-shadow: 0 8px 28px rgba(0, 0, 0, .2);
        }

        /* EMERALD */
        html[data-app-theme="emerald"] .types-edit-page {
            --te-bg: #f0f8f4;
            --te-card: #ffffff;
            --te-text: #174b37;
            --te-muted: #668878;
            --te-border: #d5e9de;
            --te-primary: #059669;
            --te-primary-soft: #e2f5eb;
            --te-shadow: 0 8px 28px rgba(16, 100, 65, .06);
        }

        /* WARM */
        html[data-app-theme="warm"] .types-edit-page {
            --te-bg: #fbf5ee;
            --te-card: #fffdf9;
            --te-text: #55402e;
            --te-muted: #927d69;
            --te-border: #eadfd1;
            --te-primary: #c17b42;
            --te-primary-soft: #f8ebdc;
            --te-shadow: 0 8px 28px rgba(120, 75, 35, .06);
        }

        /* HERO */
        .types-edit-hero {
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

        .types-edit-breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 17px;
            color: rgba(255, 255, 255, .75);
            font-size: 12px;
            flex-wrap: wrap;
        }

        .types-edit-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .types-edit-breadcrumb a:hover {
            text-decoration: underline;
        }

        .types-edit-heading {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .types-edit-hero-icon {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: rgba(255, 255, 255, .17);
            font-size: 24px;
        }

        .types-edit-heading h2 {
            color: #fff;
            font-size: 23px;
            font-weight: 800;
            margin: 0 0 5px;
        }

        .types-edit-heading p {
            color: rgba(255, 255, 255, .8);
            font-size: 13px;
            margin: 0;
        }

        .types-edit-back {
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

        .types-edit-back:hover {
            color: #fff;
            background: rgba(255, 255, 255, .22);
        }

        /* ALERTES */
        .types-edit-alert {
            display: flex;
            gap: 13px;
            padding: 16px 18px;
            margin-bottom: 22px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            color: #991b1b;
            background: #fef2f2;
        }

        .types-edit-alert-icon {
            font-size: 21px;
        }

        .types-edit-alert strong {
            font-size: 13px;
        }

        .types-edit-alert ul {
            margin: 8px 0 0;
            padding-left: 18px;
            font-size: 12px;
        }

        /* LAYOUT */
        .types-edit-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 310px;
            gap: 20px;
            align-items: start;
        }

        .types-edit-main-card,
        .types-edit-side-card {
            border: 1px solid var(--te-border);
            border-radius: 15px;
            background: var(--te-card);
            box-shadow: var(--te-shadow);
            overflow: hidden;
        }

        /* FORM HEADER */
        .types-edit-card-header {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 19px 23px;
            border-bottom: 1px solid var(--te-border);
        }

        .types-edit-card-header-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--te-primary);
            background: var(--te-primary-soft);
            border-radius: 12px;
            font-size: 19px;
        }

        .types-edit-card-header h4 {
            color: var(--te-text);
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 4px;
        }

        .types-edit-card-header p {
            color: var(--te-muted);
            font-size: 11px;
            margin: 0;
        }

        .types-edit-card-body {
            padding: 24px;
        }

        /* FIELDS */
        .types-edit-field {
            margin-bottom: 22px;
        }

        .types-edit-field>label {
            display: block;
            color: var(--te-text);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .types-edit-field .required {
            color: #ef4444;
        }

        .types-edit-input-wrap,
        .types-edit-textarea-wrap {
            position: relative;
        }

        .types-edit-input-wrap>i,
        .types-edit-textarea-wrap>i {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 1;
            color: var(--te-muted);
            font-size: 15px;
            pointer-events: none;
        }

        .types-edit-input-wrap input,
        .types-edit-input-wrap select,
        .types-edit-textarea-wrap textarea {
            width: 100%;
            border: 1px solid var(--te-border);
            border-radius: 10px;
            outline: none;
            color: var(--te-text);
            background: var(--te-bg);
            font-family: inherit;
            font-size: 13px;
            transition: .2s;
        }

        .types-edit-input-wrap input,
        .types-edit-input-wrap select {
            min-height: 46px;
            padding: 10px 13px 10px 42px;
        }

        .types-edit-input-wrap select {
            cursor: pointer;
        }

        .types-edit-textarea-wrap textarea {
            min-height: 115px;
            padding: 13px 14px 13px 42px;
            resize: vertical;
        }

        .types-edit-input-wrap input:focus,
        .types-edit-input-wrap select:focus,
        .types-edit-textarea-wrap textarea:focus {
            border-color: var(--te-primary);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--te-primary) 15%, transparent);
        }

        .types-edit-input-wrap input.is-invalid,
        .types-edit-input-wrap select.is-invalid,
        .types-edit-textarea-wrap textarea.is-invalid {
            border-color: #dc3545;
        }

        .types-edit-field small {
            display: block;
            color: var(--te-muted);
            font-size: 11px;
            margin-top: 7px;
        }

        .types-edit-field-error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 6px;
        }

        /* STATUS */
        .types-edit-status-box {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 16px;
            margin-top: 7px;
            border: 1px solid var(--te-border);
            border-radius: 12px;
            background: var(--te-bg);
        }

        .types-edit-status-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 11px;
            color: var(--te-primary);
            background: var(--te-primary-soft);
            font-size: 20px;
        }

        .types-edit-status-content {
            flex: 1;
        }

        .types-edit-status-content strong {
            display: block;
            color: var(--te-text);
            font-size: 13px;
            margin-bottom: 4px;
        }

        .types-edit-status-content p {
            color: var(--te-muted);
            font-size: 11px;
            margin: 0;
            line-height: 1.5;
        }

        /* SWITCH */
        .types-edit-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
            cursor: pointer;
        }

        .types-edit-switch input {
            width: 0;
            height: 0;
            opacity: 0;
        }

        .types-edit-switch-slider {
            position: absolute;
            inset: 0;
            border-radius: 30px;
            background: #94a3b8;
            transition: .25s;
        }

        .types-edit-switch-slider::before {
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

        .types-edit-switch input:checked+.types-edit-switch-slider {
            background: #16a34a;
        }

        .types-edit-switch input:checked+.types-edit-switch-slider::before {
            transform: translateX(22px);
        }

        .types-edit-switch input:focus-visible+.types-edit-switch-slider {
            outline: 3px solid var(--te-primary);
            outline-offset: 3px;
        }

        .types-edit-status-indicator {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 10px;
            color: #15803d;
            font-size: 11px;
            font-weight: 700;
        }

        .types-edit-status-indicator.inactive {
            color: var(--te-muted);
        }

        /* ACTIONS */
        .types-edit-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 22px;
            margin-top: 22px;
            border-top: 1px solid var(--te-border);
        }

        .types-edit-submit,
        .types-edit-cancel {
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

        .types-edit-submit {
            border: 0;
            color: #fff;
            background: linear-gradient(120deg, #4338ca, #6366f1);
        }

        .types-edit-submit:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, .2);
        }

        .types-edit-cancel {
            color: var(--te-text);
            border: 1px solid var(--te-border);
            background: var(--te-bg);
        }

        .types-edit-cancel:hover {
            color: var(--te-primary);
            border-color: var(--te-primary);
        }

        /* PANNEAU LATERAL */
        .types-edit-sidebar {
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .types-edit-side-card {
            padding: 21px;
        }

        .types-edit-side-icon,
        .types-edit-warning-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 19px;
            margin-bottom: 13px;
        }

        .types-edit-side-icon {
            color: var(--te-primary);
            background: var(--te-primary-soft);
        }

        .types-edit-side-card h5 {
            color: var(--te-text);
            font-size: 14px;
            font-weight: 800;
            margin: 0 0 8px;
        }

        .types-edit-side-card>p {
            color: var(--te-muted);
            font-size: 11px;
            line-height: 1.7;
            margin-bottom: 15px;
        }

        .types-edit-frequency-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--te-border);
        }

        .types-edit-frequency-item {
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

        .types-edit-frequency-item strong {
            display: block;
            color: var(--te-text);
            font-size: 12px;
            margin-bottom: 3px;
        }

        .types-edit-frequency-item small {
            display: block;
            color: var(--te-muted);
            font-size: 10px;
        }

        .types-edit-warning-card {
            border-color: #f5d6a8;
        }

        .types-edit-warning-icon {
            color: #c2410c;
            background: #ffedd5;
        }

        .types-edit-warning-card h5 {
            color: var(--te-text);
        }

        /* RESPONSIVE */
        @media (max-width: 1000px) {
            .types-edit-layout {
                grid-template-columns: minmax(0, 1fr) 260px;
            }
        }

        @media (max-width: 800px) {
            .types-edit-layout {
                grid-template-columns: 1fr;
            }

            .types-edit-sidebar {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .types-edit-page {
                padding: 12px;
            }

            .types-edit-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 21px;
            }

            .types-edit-back {
                width: 100%;
                justify-content: center;
            }

            .types-edit-heading h2 {
                font-size: 19px;
            }

            .types-edit-card-body {
                padding: 17px;
            }

            .types-edit-sidebar {
                grid-template-columns: 1fr;
            }

            .types-edit-actions {
                flex-direction: column;
            }

            .types-edit-submit,
            .types-edit-cancel {
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
                        '<i class="bi bi-check-circle-fill"></i><span>Ce type de frais est actif.</span>';
                } else {
                    statutTexte.classList.add('inactive');
                    statutTexte.innerHTML =
                        '<i class="bi bi-pause-circle-fill"></i><span>Ce type de frais est inactif.</span>';
                }
            }

            if (actif) {
                actif.addEventListener('change', actualiserStatut);
                actualiserStatut();
            }

        });
    </script>

@endsection
