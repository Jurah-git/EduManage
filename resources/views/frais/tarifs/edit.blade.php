@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4 tarif-edit-page">

        {{-- =========================
         EN-TÊTE
    ========================== --}}
        <div class="tarif-edit-hero mb-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    <div class="tarif-breadcrumb mb-2">
                        <a href="{{ route('dashboard') }}">Tableau de bord</a>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('frais.tarifs.index') }}">Tarifs scolaires</a>
                        <i class="bi bi-chevron-right"></i>
                        <span>Modification</span>
                    </div>

                    <h2 class="mb-2">
                        <i class="bi bi-pencil-square me-2"></i>
                        Modifier un tarif scolaire
                    </h2>

                    <p class="mb-0">
                        Modifiez les informations et les paramètres de ce tarif.
                    </p>
                </div>

                <a href="{{ route('frais.tarifs.index') }}" class="btn btn-outline-light tarif-edit-back">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour aux tarifs
                </a>

            </div>
        </div>

        {{-- =========================
         ERREURS DE VALIDATION
    ========================== --}}
        @if ($errors->any())
            <div class="tarif-errors mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">

            {{-- =========================
             FORMULAIRE
        ========================== --}}
            <div class="col-12 col-xl-8">

                <div class="tarif-edit-card">

                    <div class="tarif-edit-card-header">
                        <div class="d-flex align-items-center gap-2">
                            <div class="tarif-edit-icon">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Informations du tarif</h5>
                                <small>Les champs marqués d'un * sont obligatoires.</small>
                            </div>
                        </div>

                        @if ($tarif->actif)
                            <span class="badge rounded-pill bg-success">
                                <i class="bi bi-check-circle me-1"></i> Actif
                            </span>
                        @else
                            <span class="badge rounded-pill bg-secondary">
                                <i class="bi bi-pause-circle me-1"></i> Inactif
                            </span>
                        @endif
                    </div>

                    <div class="tarif-edit-card-body">

                        <form action="{{ route('frais.tarifs.update', $tarif->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            {{-- ASSOCIATION DU TARIF --}}
                            <div class="tarif-section-title">
                                <i class="bi bi-diagram-3"></i>
                                Association du tarif
                            </div>

                            <div class="row g-3 mb-4">

                                {{-- TYPE DE FRAIS --}}
                                <div class="col-12 col-md-6">

                                    <label for="type_frais_id" class="form-label">
                                        Type de frais <span class="text-danger">*</span>
                                    </label>

                                    <select name="type_frais_id" id="type_frais_id"
                                        class="form-select @error('type_frais_id') is-invalid @enderror" required>

                                        <option value="">-- Choisir un type de frais --</option>

                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}" @selected(old('type_frais_id', $tarif->type_frais_id) == $type->id)>
                                                {{ $type->nom }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('type_frais_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                                {{-- ANNÉE SCOLAIRE --}}
                                <div class="col-12 col-md-6">

                                    <label for="annee_scolaire_id" class="form-label">
                                        Année scolaire <span class="text-danger">*</span>
                                    </label>

                                    <select name="annee_scolaire_id" id="annee_scolaire_id"
                                        class="form-select @error('annee_scolaire_id') is-invalid @enderror" required>

                                        <option value="">-- Choisir une année scolaire --</option>

                                        @foreach ($annees as $annee)
                                            <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id', $tarif->annee_scolaire_id) == $annee->id)>
                                                {{ $annee->nom }}
                                                {{ $annee->active ? '(Active)' : '' }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('annee_scolaire_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                                {{-- CLASSE --}}
                                <div class="col-12 col-md-6">

                                    <label for="classe_id" class="form-label">
                                        Classe <span class="text-danger">*</span>
                                    </label>

                                    <select name="classe_id" id="classe_id"
                                        class="form-select @error('classe_id') is-invalid @enderror" required>

                                        <option value="">-- Choisir une classe --</option>

                                        @foreach ($classes as $classe)
                                            <option value="{{ $classe->id }}" @selected(old('classe_id', $tarif->classe_id) == $classe->id)>
                                                {{ $classe->nom }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('classe_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>

                            <hr class="tarif-divider">

                            {{-- MONTANT ET PÉRIODE --}}
                            <div class="tarif-section-title">
                                <i class="bi bi-calendar-range"></i>
                                Montant et période de validité
                            </div>

                            <div class="row g-3 mb-4">

                                {{-- MONTANT --}}
                                <div class="col-12 col-md-6">

                                    <label for="montant" class="form-label">
                                        Montant du tarif <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">
                                        <input type="number" name="montant" id="montant"
                                            class="form-control @error('montant') is-invalid @enderror"
                                            value="{{ old('montant', $tarif->montant) }}" min="0.01" step="0.01"
                                            required>

                                        <span class="input-group-text">Ar</span>

                                        @error('montant')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <small class="form-text">
                                        Saisissez le montant en Ariary.
                                    </small>

                                </div>

                                {{-- DATE DÉBUT --}}
                                <div class="col-12 col-md-6">

                                    <label for="date_debut" class="form-label">
                                        Date de début
                                    </label>

                                    <input type="date" name="date_debut" id="date_debut"
                                        class="form-control @error('date_debut') is-invalid @enderror"
                                        value="{{ old('date_debut', $tarif->date_debut ? \Carbon\Carbon::parse($tarif->date_debut)->format('Y-m-d') : '') }}">

                                    @error('date_debut')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                                {{-- DATE FIN --}}
                                <div class="col-12 col-md-6">

                                    <label for="date_fin" class="form-label">
                                        Date de fin
                                    </label>

                                    <input type="date" name="date_fin" id="date_fin"
                                        class="form-control @error('date_fin') is-invalid @enderror"
                                        value="{{ old('date_fin', $tarif->date_fin ? \Carbon\Carbon::parse($tarif->date_fin)->format('Y-m-d') : '') }}">

                                    @error('date_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>

                            <hr class="tarif-divider">

                            {{-- STATUT --}}
                            <div class="tarif-section-title">
                                <i class="bi bi-toggle-on"></i>
                                État du tarif
                            </div>

                            <div class="tarif-status-box mb-4">

                                <div>
                                    <strong>Activer ce tarif</strong>
                                    <small>
                                        Un tarif actif peut être utilisé pour la génération des frais,
                                        selon les règles de validité configurées.
                                    </small>
                                </div>

                                <div class="form-check form-switch mb-0">
                                    <input type="checkbox" name="actif" id="actif" class="form-check-input"
                                        value="1" @checked(old('actif', $tarif->actif) == '1')>

                                    <label for="actif" class="form-check-label">
                                        <span id="tarif-status-label">
                                            {{ old('actif', $tarif->actif) ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </label>
                                </div>

                            </div>

                            {{-- ACTIONS --}}
                            <div class="tarif-form-actions">

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save me-1"></i>
                                    Enregistrer les modifications
                                </button>

                                <a href="{{ route('frais.tarifs.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Annuler
                                </a>

                            </div>

                        </form>

                    </div>
                </div>
            </div>

            {{-- =========================
             PANNEAU LATÉRAL
        ========================== --}}
            <div class="col-12 col-xl-4">

                <div class="tarif-edit-card mb-4">

                    <div class="tarif-edit-card-header">
                        <div class="d-flex align-items-center gap-2">
                            <div class="tarif-edit-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Informations utiles</h5>
                                <small>Conseils de modification</small>
                            </div>
                        </div>
                    </div>

                    <div class="tarif-edit-card-body">

                        <div class="tarif-help-item">
                            <div class="tarif-help-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div>
                                <strong>Type de frais</strong>
                                <p>
                                    Vérifiez que le type choisi correspond bien à la nature
                                    du montant facturé.
                                </p>
                            </div>
                        </div>

                        <div class="tarif-help-item">
                            <div class="tarif-help-icon">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div>
                                <strong>Année scolaire</strong>
                                <p>
                                    Associez le tarif à l'année scolaire concernée.
                                </p>
                            </div>
                        </div>

                        <div class="tarif-help-item">
                            <div class="tarif-help-icon">
                                <i class="bi bi-currency-exchange"></i>
                            </div>
                            <div>
                                <strong>Montant</strong>
                                <p>
                                    Vérifiez le montant avant de valider les modifications.
                                </p>
                            </div>
                        </div>

                        <div class="tarif-help-item">
                            <div class="tarif-help-icon">
                                <i class="bi bi-toggle-on"></i>
                            </div>
                            <div>
                                <strong>Statut du tarif</strong>
                                <p>
                                    Un tarif désactivé ne doit plus être proposé pour les
                                    nouvelles générations de frais.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- RAPPEL DU TARIF ACTUEL --}}
                <div class="tarif-current-card">

                    <div class="tarif-current-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>

                    <h6>Tarif actuellement enregistré</h6>

                    <div class="tarif-current-amount">
                        {{ number_format((float) $tarif->montant, 0, ',', ' ') }} Ar
                    </div>

                    <div class="tarif-current-detail">
                        {{ $tarif->typeFrais->nom ?? 'Type non défini' }}
                    </div>

                    <div class="tarif-current-detail">
                        {{ $tarif->classe->nom ?? 'Classe non définie' }}
                        ·
                        {{ $tarif->anneeScolaire->nom ?? 'Année non définie' }}
                    </div>

                    <hr>

                    <small>
                        <i class="bi bi-shield-check me-1"></i>
                        Vérifiez les informations avant l'enregistrement.
                    </small>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================
     JAVASCRIPT
========================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const actif = document.getElementById('actif');
            const label = document.getElementById('tarif-status-label');

            if (actif && label) {
                actif.addEventListener('change', function() {
                    label.textContent = this.checked ? 'Actif' : 'Inactif';
                });
            }

            // Vérification de cohérence des dates.
            const dateDebut = document.getElementById('date_debut');
            const dateFin = document.getElementById('date_fin');

            if (dateDebut && dateFin) {

                dateDebut.addEventListener('change', function() {
                    dateFin.min = this.value || '';
                });

                dateFin.addEventListener('change', function() {
                    dateDebut.max = this.value || '';
                });

                if (dateDebut.value) {
                    dateFin.min = dateDebut.value;
                }

                if (dateFin.value) {
                    dateDebut.max = dateFin.value;
                }
            }

        });
    </script>

    {{-- =========================
     STYLES
========================== --}}
    <style>
        .tarif-edit-page {
            --te-bg: #f4f7fb;
            --te-card: #ffffff;
            --te-text: #263449;
            --te-muted: #748198;
            --te-border: #e5eaf1;
            --te-primary: #5265d8;
            --te-soft: #eef1ff;
            color: var(--te-text);
        }

        /* EN-TÊTE */
        .tarif-edit-hero {
            padding: 28px 30px;
            color: #fff;
            border-radius: 18px;
            background: linear-gradient(125deg, #3347a8, #6879e8);
            box-shadow: 0 8px 24px rgba(52, 71, 168, .16);
        }

        .tarif-edit-hero h2 {
            font-size: 1.55rem;
            font-weight: 750;
        }

        .tarif-edit-hero p {
            color: rgba(255, 255, 255, .82);
        }

        .tarif-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            font-size: .82rem;
            color: rgba(255, 255, 255, .75);
        }

        .tarif-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .tarif-breadcrumb a:hover {
            text-decoration: underline;
        }

        .tarif-edit-back {
            border-radius: 9px;
            padding: 9px 15px;
            font-weight: 600;
        }

        /* ERREURS */
        .tarif-errors {
            padding: 17px 20px;
            color: #842029;
            background: #f8d7da;
            border: 1px solid #f1aeb5;
            border-radius: 12px;
        }

        .tarif-errors>div i {
            font-size: 1.1rem;
        }

        /* CARTES */
        .tarif-edit-card {
            height: 100%;
            background: var(--te-card);
            border: 1px solid var(--te-border);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(25, 42, 70, .045);
        }

        .tarif-edit-card-header {
            min-height: 76px;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            border-bottom: 1px solid var(--te-border);
        }

        .tarif-edit-card-header h5 {
            color: var(--te-text);
            font-size: 1rem;
            font-weight: 700;
        }

        .tarif-edit-card-header small {
            color: var(--te-muted);
            font-size: .78rem;
        }

        .tarif-edit-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--te-soft);
            color: var(--te-primary);
            font-size: 1.15rem;
        }

        .tarif-edit-card-body {
            padding: 24px;
        }

        /* TITRES DE SECTIONS */
        .tarif-section-title {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 18px;
            color: var(--te-primary);
            font-size: .92rem;
            font-weight: 750;
        }

        .tarif-section-title i {
            font-size: 1.1rem;
        }

        .tarif-divider {
            border-color: var(--te-border);
            opacity: 1;
            margin: 24px 0;
        }

        /* FORMULAIRES */
        .tarif-edit-page .form-label {
            color: var(--te-text);
            font-size: .87rem;
            font-weight: 650;
            margin-bottom: 8px;
        }

        .tarif-edit-page .form-control,
        .tarif-edit-page .form-select {
            min-height: 44px;
            color: var(--te-text);
            background-color: var(--te-card);
            border: 1px solid var(--te-border);
            border-radius: 9px;
            font-size: .9rem;
        }

        .tarif-edit-page .form-control:focus,
        .tarif-edit-page .form-select:focus {
            border-color: var(--te-primary);
            box-shadow: 0 0 0 .2rem rgba(82, 101, 216, .12);
        }

        .tarif-edit-page .input-group-text {
            min-width: 48px;
            justify-content: center;
            color: var(--te-muted);
            background: var(--te-bg);
            border-color: var(--te-border);
            font-weight: 650;
        }

        .tarif-edit-page .form-text {
            color: var(--te-muted);
            font-size: .76rem;
        }

        .tarif-edit-page .invalid-feedback {
            font-size: .8rem;
        }

        /* STATUT */
        .tarif-status-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 17px;
            border: 1px solid var(--te-border);
            border-radius: 11px;
            background: var(--te-bg);
        }

        .tarif-status-box strong {
            display: block;
            color: var(--te-text);
            font-size: .9rem;
            margin-bottom: 4px;
        }

        .tarif-status-box small {
            display: block;
            max-width: 450px;
            color: var(--te-muted);
            font-size: .78rem;
        }

        .tarif-edit-page .form-check-input {
            cursor: pointer;
            width: 2.5em;
            height: 1.3em;
        }

        .tarif-edit-page .form-check-label {
            color: var(--te-text);
            font-size: .82rem;
            font-weight: 650;
            margin-left: 5px;
        }

        /* BOUTONS */
        .tarif-form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 5px;
        }

        .tarif-form-actions .btn {
            padding: 10px 17px;
            border-radius: 9px;
            font-size: .87rem;
            font-weight: 650;
        }

        /* PANNEAU CONSEILS */
        .tarif-help-item {
            display: flex;
            gap: 13px;
            padding: 14px 0;
            border-bottom: 1px solid var(--te-border);
        }

        .tarif-help-item:first-child {
            padding-top: 0;
        }

        .tarif-help-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .tarif-help-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--te-primary);
            background: var(--te-soft);
            border-radius: 9px;
        }

        .tarif-help-item strong {
            display: block;
            color: var(--te-text);
            font-size: .87rem;
            margin-bottom: 4px;
        }

        .tarif-help-item p {
            color: var(--te-muted);
            font-size: .79rem;
            margin: 0;
            line-height: 1.5;
        }

        /* RAPPEL TARIF */
        .tarif-current-card {
            padding: 23px;
            border-radius: 15px;
            background: var(--te-soft);
            border: 1px solid var(--te-border);
            text-align: center;
        }

        .tarif-current-icon {
            display: inline-flex;
            width: 48px;
            height: 48px;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: var(--te-card);
            color: var(--te-primary);
            font-size: 1.35rem;
            margin-bottom: 12px;
        }

        .tarif-current-card h6 {
            color: var(--te-text);
            font-weight: 750;
        }

        .tarif-current-amount {
            color: var(--te-primary);
            font-size: 1.65rem;
            font-weight: 800;
            margin: 12px 0;
        }

        .tarif-current-detail {
            color: var(--te-muted);
            font-size: .82rem;
            margin-top: 5px;
        }

        .tarif-current-card hr {
            border-color: var(--te-border);
            opacity: 1;
            margin: 17px 0;
        }

        .tarif-current-card>small {
            color: var(--te-muted);
            font-size: .76rem;
        }

        /* =========================
       MODE SOMBRE
    ========================= */
        html[data-app-theme="dark"] .tarif-edit-page {
            --te-bg: #151c2b;
            --te-card: #202a3b;
            --te-text: #edf2fa;
            --te-muted: #a8b5c8;
            --te-border: #39465b;
            --te-primary: #ad9fff;
            --te-soft: #343052;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarif-edit-page .tarif-edit-card,
        html[data-app-theme="dark"] .tarif-edit-page .tarif-current-card {
            background: #202a3b !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarif-edit-page .tarif-edit-card-header,
        html[data-app-theme="dark"] .tarif-edit-page .tarif-status-box,
        html[data-app-theme="dark"] .tarif-edit-page .form-control,
        html[data-app-theme="dark"] .tarif-edit-page .form-select,
        html[data-app-theme="dark"] .tarif-edit-page .input-group-text {
            background-color: #151c2b !important;
            color: #edf2fa !important;
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarif-edit-page .form-select option {
            background: #202a3b !important;
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarif-edit-page .tarif-current-card {
            background: #343052 !important;
        }

        html[data-app-theme="dark"] .tarif-edit-page .tarif-current-icon {
            background: #202a3b !important;
        }

        html[data-app-theme="dark"] .tarif-edit-page .tarif-edit-card-header h5,
        html[data-app-theme="dark"] .tarif-edit-page .tarif-section-title,
        html[data-app-theme="dark"] .tarif-edit-page .form-label,
        html[data-app-theme="dark"] .tarif-edit-page .tarif-status-box strong,
        html[data-app-theme="dark"] .tarif-edit-page .tarif-help-item strong,
        html[data-app-theme="dark"] .tarif-edit-page .tarif-current-card h6 {
            color: #edf2fa !important;
        }

        html[data-app-theme="dark"] .tarif-edit-page .tarif-divider,
        html[data-app-theme="dark"] .tarif-edit-page .tarif-help-item,
        html[data-app-theme="dark"] .tarif-edit-page .tarif-current-card hr {
            border-color: #39465b !important;
        }

        html[data-app-theme="dark"] .tarif-edit-page .form-check-label {
            color: #edf2fa !important;
        }

        /* =========================
       ULTRA PRO
    ========================= */
        html[data-app-theme="ultra-pro"] .tarif-edit-page {
            --te-bg: #182337;
            --te-card: #202d43;
            --te-text: #eaf0fa;
            --te-muted: #aab8ce;
            --te-border: #34445e;
            --te-primary: #7eb7ff;
            --te-soft: #293d5c;
        }

        html[data-app-theme="ultra-pro"] .tarif-edit-page .tarif-edit-card {
            background: #202d43;
            border-color: #34445e;
        }

        html[data-app-theme="ultra-pro"] .tarif-edit-page .form-control,
        html[data-app-theme="ultra-pro"] .tarif-edit-page .form-select,
        html[data-app-theme="ultra-pro"] .tarif-edit-page .input-group-text,
        html[data-app-theme="ultra-pro"] .tarif-edit-page .tarif-status-box {
            background: #182337;
            color: #eaf0fa;
            border-color: #34445e;
        }

        /* =========================
       EMERALD
    ========================= */
        html[data-app-theme="emerald"] .tarif-edit-page {
            --te-bg: #effaf5;
            --te-card: #ffffff;
            --te-text: #173f32;
            --te-muted: #648477;
            --te-border: #cfe9dc;
            --te-primary: #13865d;
            --te-soft: #dcf5e9;
        }

        html[data-app-theme="emerald"] .tarif-edit-page .tarif-edit-hero {
            background: linear-gradient(125deg, #08734e, #20a477);
        }

        /* =========================
       WARM
    ========================= */
        html[data-app-theme="warm"] .tarif-edit-page {
            --te-bg: #fff8f0;
            --te-card: #ffffff;
            --te-text: #513b2d;
            --te-muted: #927866;
            --te-border: #f0dfce;
            --te-primary: #c4773e;
            --te-soft: #fbe8d7;
        }

        html[data-app-theme="warm"] .tarif-edit-page .tarif-edit-hero {
            background: linear-gradient(125deg, #a95d35, #d99559);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {

            .tarif-edit-hero {
                padding: 22px 18px;
            }

            .tarif-edit-hero h2 {
                font-size: 1.25rem;
            }

            .tarif-edit-card-body {
                padding: 17px;
            }

            .tarif-edit-card-header {
                padding: 14px 16px;
            }

            .tarif-status-box {
                align-items: flex-start;
                flex-direction: column;
            }

            .tarif-form-actions {
                flex-direction: column;
            }

            .tarif-form-actions .btn {
                width: 100%;
            }
        }
    </style>

@endsection
