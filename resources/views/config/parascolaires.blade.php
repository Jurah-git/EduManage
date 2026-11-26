
@extends('layouts.app')

@section('content')

@php
    $edition = $activiteEnEdition ?? null;

    $joursSemaine = [
        'lundi' => 'Lundi',
        'mardi' => 'Mardi',
        'mercredi' => 'Mercredi',
        'jeudi' => 'Jeudi',
        'vendredi' => 'Vendredi',
        'samedi' => 'Samedi',
        'dimanche' => 'Dimanche',
    ];

    $nombreActivites = $activites->count();
    $nombreActives = $activites->where('actif', true)->count();
    $nombreInactives = $nombreActivites - $nombreActives;

    $joursSelectionnes = old('jours', $edition?->jours ?? []);
@endphp

<div class="para-page">

    {{-- EN-TÊTE --}}
    <div class="para-header">
        <div>
            <div class="para-eyebrow">
                <i class="bi bi-sliders"></i>
                CONFIGURATION
            </div>

            <h2>
                <i class="bi bi-stars"></i>
                Activités parascolaires
            </h2>

            <p>Organisez et gérez les activités proposées aux élèves.</p>
        </div>

        <button type="button" class="para-main-btn" onclick="ouvrirModal()">
            <i class="bi bi-plus-lg"></i>
            Ajouter une activité
        </button>
    </div>

    {{-- MESSAGES --}}
    @if(session('success'))
        <div class="para-alert para-alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="para-alert para-alert-error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>Vérifiez les informations saisies :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- STATISTIQUES --}}
    <div class="para-stats">

        <div class="para-stat-card">
            <div class="para-stat-icon icon-blue">
                <i class="bi bi-collection"></i>
            </div>
            <div>
                <span>Total des activités</span>
                <strong>{{ $nombreActivites }}</strong>
            </div>
        </div>

        <div class="para-stat-card">
            <div class="para-stat-icon icon-green">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <span>Activités actives</span>
                <strong>{{ $nombreActives }}</strong>
            </div>
        </div>

        <div class="para-stat-card">
            <div class="para-stat-icon icon-orange">
                <i class="bi bi-pause-circle"></i>
            </div>
            <div>
                <span>Activités inactives</span>
                <strong>{{ $nombreInactives }}</strong>
            </div>
        </div>

    </div>

    {{-- LISTE DES ACTIVITÉS --}}
    <section class="para-list-section">

        <div class="para-list-header">
            <div>
                <h3>
                    <i class="bi bi-grid"></i>
                    Activités enregistrées
                </h3>
                <p>{{ $nombreActivites }} activité(s) au total</p>
            </div>
        </div>

        @if($activites->isEmpty())

            <div class="para-empty">
                <div class="para-empty-icon">
                    <i class="bi bi-stars"></i>
                </div>

                <h4>Aucune activité pour le moment</h4>

                <p>
                    Commencez par ajouter votre première activité parascolaire.
                </p>

                <button type="button" class="para-main-btn" onclick="ouvrirModal()">
                    <i class="bi bi-plus-lg"></i>
                    Ajouter une activité
                </button>
            </div>

        @else

            <div class="para-activities-grid">

                @foreach($activites as $activite)

                    <article class="para-activity-card">

                        <div class="para-activity-top">
                            <div class="para-activity-icon">
                                <i class="bi bi-stars"></i>
                            </div>

                            <span class="para-status-badge {{ $activite->actif ? 'status-active' : 'status-inactive' }}">
                                <i class="bi {{ $activite->actif ? 'bi-check-circle-fill' : 'bi-pause-circle-fill' }}"></i>
                                {{ $activite->actif ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="para-activity-content">

                            <span class="para-category">
                                {{ $activite->categorie }}
                            </span>

                            <h4>{{ $activite->nom }}</h4>

                            <p class="para-activity-description">
                                {{ $activite->description ?: 'Aucune description renseignée.' }}
                            </p>

                            <div class="para-activity-details">

                                <div>
                                    <i class="bi bi-calendar-week"></i>
                                    <span>
                                        @if($activite->jours && count($activite->jours))
                                            {{ collect($joursSemaine)->only($activite->jours)->values()->implode(', ') }}
                                        @else
                                            Jours non définis
                                        @endif
                                    </span>
                                </div>

                                <div>
                                    <i class="bi bi-clock"></i>
                                    <span>
                                        @if($activite->heure_debut && $activite->heure_fin)
                                            {{ substr($activite->heure_debut, 0, 5) }}
                                            -
                                            {{ substr($activite->heure_fin, 0, 5) }}
                                        @else
                                            Horaires non définis
                                        @endif
                                    </span>
                                </div>

                                <div>
                                    <i class="bi bi-cash-stack"></i>
                                    <span>
                                        @if($activite->periodicite === 'Gratuit')
                                            Gratuit
                                        @elseif($activite->tarif_indicatif !== null)
                                            {{ number_format((float) $activite->tarif_indicatif, 0, ',', ' ') }} Ar
                                            @if($activite->periodicite)
                                                / {{ $activite->periodicite }}
                                            @endif
                                        @else
                                            Tarif non défini
                                        @endif
                                    </span>
                                </div>

                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="para-activity-actions">

                            <a
                                href="{{ route('config.parascolaires.edit', $activite->id) }}"
                                class="para-action-btn action-edit"
                            >
                                <i class="bi bi-pencil-square"></i>
                                Modifier
                            </a>

                            <form action="{{ route('config.parascolaires.toggle', $activite->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="para-action-btn {{ $activite->actif ? 'action-pause' : 'action-enable' }}">
                                    <i class="bi {{ $activite->actif ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    {{ $activite->actif ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>

                            <form
                                action="{{ route('config.parascolaires.destroy', $activite->id) }}"
                                method="POST"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer cette activité ? Cette action est définitive.');"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="para-action-btn action-delete">
                                    <i class="bi bi-trash3"></i>
                                    Supprimer
                                </button>
                            </form>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </section>

    {{-- INFORMATION --}}
    <div class="para-information">
        <i class="bi bi-info-circle-fill"></i>
        <p>
            <strong>Information :</strong>
            les tarifs affichés sont indicatifs. La gestion des activités
            parascolaires est indépendante des frais d'écolage et des paiements.
        </p>
    </div>

</div>


{{-- =====================================
     POPUP AJOUT / MODIFICATION
===================================== --}}

<dialog class="para-modal" id="paraModal">

    <div class="para-modal-content">

        <div class="para-modal-header">
            <div class="para-modal-heading">
                <div class="para-heading-icon">
                    <i class="bi" id="paraModalIcon"
                       class="{{ $edition ? 'bi-pencil-square' : 'bi-plus-circle' }}"></i>
                </div>

                <div>
                    <h3 id="paraModalTitle">
                        {{ $edition ? 'Modifier une activité' : 'Nouvelle activité' }}
                    </h3>
                    <p>Renseignez les informations de l'activité.</p>
                </div>
            </div>

            <button type="button" class="para-modal-close" onclick="fermerModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form
            id="paraForm"
            action="{{ $edition ? route('config.parascolaires.update', $edition->id) : route('config.parascolaires.store') }}"
            method="POST"
        >
            @csrf

            @if($edition)
                @method('PUT')
            @endif

            <div class="para-form-grid">

                {{-- NOM --}}
                <div class="para-field">
                    <label for="nom">Nom de l'activité <span>*</span></label>

                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        value="{{ old('nom', $edition?->nom) }}"
                        placeholder="Ex : Football, Danse, Informatique..."
                        maxlength="150"
                        required
                    >
                </div>

                {{-- CATÉGORIE --}}
                <div class="para-field">
                    <label for="categorie">Catégorie <span>*</span></label>

                    <select id="categorie" name="categorie" required>
                        <option value="">Choisir une catégorie</option>

                        @foreach([
                            'Sport',
                            'Culture',
                            'Art',
                            'Musique',
                            'Informatique',
                            'Langues',
                            'Scientifique',
                            'Autre'
                        ] as $categorie)

                            <option
                                value="{{ $categorie }}"
                                @selected(old('categorie', $edition?->categorie) === $categorie)
                            >
                                {{ $categorie }}
                            </option>

                        @endforeach
                    </select>
                </div>

                {{-- DESCRIPTION --}}
                <div class="para-field para-field-full">
                    <label for="description">Description</label>

                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="Présentez brièvement cette activité..."
                    >{{ old('description', $edition?->description) }}</textarea>
                </div>

                {{-- TARIF --}}
                <div class="para-field">
                    <label for="tarif_indicatif">Tarif indicatif (Ar)</label>

                    <input
                        type="number"
                        id="tarif_indicatif"
                        name="tarif_indicatif"
                        value="{{ old('tarif_indicatif', $edition?->tarif_indicatif) }}"
                        min="0"
                        step="0.01"
                        placeholder="Ex : 10000"
                    >

                    <small>Ce tarif est informatif uniquement.</small>
                </div>

                {{-- PERIODICITÉ --}}
                <div class="para-field">
                    <label for="periodicite">Périodicité du tarif</label>

                    <select id="periodicite" name="periodicite">
                        <option value="">Non définie</option>

                        @foreach([
                            'Séance',
                            'Semaine',
                            'Mois',
                            'Trimestre',
                            'Année',
                            'Gratuit'
                        ] as $periodicite)

                            <option
                                value="{{ $periodicite }}"
                                @selected(old('periodicite', $edition?->periodicite) === $periodicite)
                            >
                                {{ $periodicite }}
                            </option>

                        @endforeach
                    </select>
                </div>

                {{-- JOURS --}}
                <div class="para-field para-field-full">
                    <label>Jours de l'activité</label>

                    <div class="para-days">

                        @foreach($joursSemaine as $valeur => $libelle)

                            <label class="para-day-option">
                                <input
                                    type="checkbox"
                                    name="jours[]"
                                    value="{{ $valeur }}"
                                    @checked(in_array($valeur, $joursSelectionnes ?? []))
                                >
                                <span>{{ $libelle }}</span>
                            </label>

                        @endforeach

                    </div>
                </div>

                {{-- HEURES --}}
                <div class="para-field">
                    <label for="heure_debut">Heure de début</label>

                    <input
                        type="time"
                        id="heure_debut"
                        name="heure_debut"
                        value="{{ old('heure_debut', $edition?->heure_debut ? substr($edition->heure_debut, 0, 5) : '') }}"
                    >
                </div>

                <div class="para-field">
                    <label for="heure_fin">Heure de fin</label>

                    <input
                        type="time"
                        id="heure_fin"
                        name="heure_fin"
                        value="{{ old('heure_fin', $edition?->heure_fin ? substr($edition->heure_fin, 0, 5) : '') }}"
                    >
                </div>

                {{-- STATUT --}}
                <div class="para-field para-field-full">
                    <label>Statut de l'activité</label>

                    <div class="para-status-input">
                        <input type="hidden" name="actif" value="0">

                        <label class="para-switch">
                            <input
                                type="checkbox"
                                name="actif"
                                value="1"
                                @checked((bool) old('actif', $edition?->actif ?? true))
                            >
                            <span class="para-switch-slider"></span>
                        </label>

                        <span>
                            Activité disponible
                            <small>Décochez pour enregistrer l'activité comme inactive.</small>
                        </span>
                    </div>
                </div>

            </div>

            <div class="para-form-footer">
                <button type="submit" class="para-submit-btn">
                    <i class="bi bi-check-lg"></i>
                    {{ $edition ? 'Enregistrer les modifications' : 'Enregistrer l’activité' }}
                </button>

                <button type="button" class="para-secondary-btn" onclick="fermerModal()">
                    Annuler
                </button>
            </div>

        </form>

    </div>

</dialog>


<style>
/* =========================================
   ACTIVITES PARASCOLAIRES
========================================= */

.para-page {
    --para-primary: #2563eb;
    --para-text: #17243b;
    --para-muted: #718096;
    --para-border: #e2e8f0;
    --para-surface: #ffffff;
    --para-background: #f1f5fb;
    --para-input: #ffffff;

    color: var(--para-text);
    width: 100%;
    font-family: "Segoe UI", Arial, sans-serif;
}

.para-page *,
.para-modal * {
    box-sizing: border-box;
}

/* HEADER */

.para-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 25px;
}

.para-eyebrow {
    color: var(--para-primary);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
}

.para-header h2 {
    color: var(--para-text);
    font-size: 25px;
    font-weight: 800;
    margin: 0;
}

.para-header h2 i {
    color: var(--para-primary);
}

.para-header p {
    color: var(--para-muted);
    font-size: 13px;
    margin: 7px 0 0;
}

/* BOUTONS */

.para-main-btn,
.para-submit-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    min-height: 43px;
    padding: 11px 17px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff !important;
    font-size: 12px;
    font-weight: 750;
    text-decoration: none;
    cursor: pointer;
    transition: .2s ease;
}

.para-main-btn:hover,
.para-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 18px rgba(37,99,235,.22);
}

/* ALERTES */

.para-alert {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    padding: 14px 16px;
    border-radius: 11px;
    margin-bottom: 18px;
    font-size: 13px;
}

.para-alert-success {
    color: #166534;
    background: #dcfce7;
    border: 1px solid #bbf7d0;
}

.para-alert-error {
    color: #991b1b;
    background: #fee2e2;
    border: 1px solid #fecaca;
}

.para-alert ul {
    margin: 7px 0 0;
    padding-left: 18px;
}

/* STATISTIQUES */

.para-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 25px;
}

.para-stat-card {
    display: flex;
    align-items: center;
    gap: 14px;
    min-height: 95px;
    padding: 18px;
    border: 1px solid var(--para-border);
    border-radius: 15px;
    background: var(--para-surface);
    box-shadow: 0 4px 15px rgba(15,23,42,.035);
}

.para-stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 47px;
    height: 47px;
    flex-shrink: 0;
    border-radius: 13px;
    font-size: 20px;
}

.icon-blue { color: #2563eb; background: #dbeafe; }
.icon-green { color: #15803d; background: #dcfce7; }
.icon-orange { color: #c2410c; background: #ffedd5; }

.para-stat-card span {
    display: block;
    color: var(--para-muted);
    font-size: 11px;
    font-weight: 600;
}

.para-stat-card strong {
    display: block;
    margin-top: 5px;
    color: var(--para-text);
    font-size: 25px;
    font-weight: 800;
}

/* LISTE */

.para-list-section {
    margin-bottom: 24px;
}

.para-list-header {
    margin-bottom: 17px;
}

.para-list-header h3 {
    color: var(--para-text);
    font-size: 17px;
    font-weight: 800;
    margin: 0;
}

.para-list-header h3 i {
    color: var(--para-primary);
}

.para-list-header p {
    color: var(--para-muted);
    font-size: 11px;
    margin: 5px 0 0;
}

.para-activities-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

.para-activity-card {
    min-width: 0;
    padding: 18px;
    border: 1px solid var(--para-border);
    border-radius: 15px;
    background: var(--para-surface);
    box-shadow: 0 4px 15px rgba(15,23,42,.035);
    transition: .2s ease;
}

.para-activity-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 9px 24px rgba(15,23,42,.08);
}

.para-activity-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 15px;
}

.para-activity-icon,
.para-empty-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 43px;
    height: 43px;
    color: var(--para-primary);
    background: #dbeafe;
    border-radius: 12px;
    font-size: 20px;
}

.para-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 10px;
    border-radius: 30px;
    font-size: 10px;
    font-weight: 750;
}

.status-active { color: #15803d; background: #dcfce7; }
.status-inactive { color: #b45309; background: #fef3c7; }

.para-category {
    display: inline-block;
    padding: 5px 9px;
    color: var(--para-primary);
    background: #dbeafe;
    border-radius: 6px;
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
}

.para-activity-content h4 {
    color: var(--para-text);
    font-size: 17px;
    font-weight: 800;
    margin: 10px 0 6px;
}

.para-activity-description {
    min-height: 34px;
    color: var(--para-muted);
    font-size: 11px;
    line-height: 1.6;
    margin: 0 0 14px;
    overflow-wrap: anywhere;
}

.para-activity-details {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 13px 0;
    border-top: 1px solid var(--para-border);
}

.para-activity-details > div {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    color: var(--para-muted);
    font-size: 11px;
    line-height: 1.5;
}

.para-activity-details i {
    width: 15px;
    flex-shrink: 0;
    color: var(--para-primary);
    font-size: 13px;
}

/* ACTIONS */

.para-activity-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    padding-top: 13px;
    border-top: 1px solid var(--para-border);
}

.para-activity-actions form {
    margin: 0;
}

.para-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    min-height: 32px;
    padding: 7px 9px;
    border: 1px solid transparent;
    border-radius: 7px;
    font-size: 10px;
    font-weight: 750;
    text-decoration: none;
    cursor: pointer;
    transition: .2s;
}

.action-edit { color: #1d4ed8; background: #dbeafe; }
.action-pause { color: #b45309; background: #fef3c7; }
.action-enable { color: #15803d; background: #dcfce7; }
.action-delete { color: #b91c1c; background: #fee2e2; }

.para-action-btn:hover {
    filter: brightness(.96);
}

/* AUCUNE ACTIVITÉ */

.para-empty {
    padding: 45px 20px;
    border: 1px dashed var(--para-border);
    border-radius: 15px;
    text-align: center;
    background: var(--para-surface);
}

.para-empty-icon {
    width: 65px;
    height: 65px;
    margin: 0 auto 15px;
    border-radius: 18px;
    font-size: 27px;
}

.para-empty h4 {
    color: var(--para-text);
    font-size: 16px;
}

.para-empty p {
    color: var(--para-muted);
    font-size: 12px;
    margin-bottom: 20px;
}

/* INFORMATION */

.para-information {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    padding: 15px;
    border: 1px solid #bfdbfe;
    border-radius: 11px;
    color: #1e40af;
    background: #eff6ff;
}

.para-information p {
    margin: 0;
    font-size: 11px;
    line-height: 1.6;
}

/* =====================================
   POPUP
===================================== */

.para-modal {
    width: min(850px, calc(100% - 30px));
    max-width: 850px;
    max-height: 90vh;
    padding: 0;
    border: 1px solid var(--para-border);
    border-radius: 17px;
    color: var(--para-text);
    background: var(--para-surface);
    overflow: auto;
}

.para-modal::backdrop {
    background: rgba(5,12,25,.75);
    backdrop-filter: blur(5px);
}

.para-modal-content {
    padding: 23px;
}

.para-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 23px;
    padding-bottom: 17px;
    border-bottom: 1px solid var(--para-border);
}

.para-modal-heading {
    display: flex;
    align-items: center;
    gap: 13px;
}

.para-heading-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    flex-shrink: 0;
    color: var(--para-primary);
    background: #dbeafe;
    border-radius: 12px;
    font-size: 20px;
}

.para-modal-header h3 {
    color: var(--para-text);
    font-size: 16px;
    font-weight: 800;
    margin: 0;
}

.para-modal-header p {
    color: var(--para-muted);
    font-size: 11px;
    margin: 5px 0 0;
}

.para-modal-close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    flex-shrink: 0;
    border: 1px solid var(--para-border);
    border-radius: 9px;
    color: var(--para-text);
    background: var(--para-background);
    cursor: pointer;
}

/* FORMULAIRE */

.para-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 19px;
}

.para-field {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.para-field-full {
    grid-column: 1 / -1;
}

.para-field > label {
    color: var(--para-text);
    font-size: 12px;
    font-weight: 750;
    margin-bottom: 8px;
}

.para-field > label span {
    color: #dc2626;
}

.para-field input:not([type="checkbox"]),
.para-field select,
.para-field textarea {
    width: 100%;
    min-height: 43px;
    padding: 11px 13px;
    border: 1px solid var(--para-border);
    border-radius: 9px;
    outline: none;
    color: var(--para-text);
    background: var(--para-input);
    font-family: inherit;
    font-size: 12px;
}

.para-field textarea {
    resize: vertical;
    min-height: 85px;
}

.para-field input:focus,
.para-field select:focus,
.para-field textarea:focus {
    border-color: var(--para-primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,.10);
}

.para-field small {
    color: var(--para-muted);
    font-size: 10px;
    margin-top: 6px;
}

/* JOURS */

.para-days {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
}

.para-day-option {
    position: relative;
    cursor: pointer;
}

.para-day-option input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.para-day-option span {
    display: block;
    padding: 9px 13px;
    border: 1px solid var(--para-border);
    border-radius: 8px;
    color: var(--para-muted);
    background: var(--para-input);
    font-size: 11px;
    font-weight: 650;
    transition: .2s;
}

.para-day-option input:checked + span {
    color: #1d4ed8;
    border-color: #93c5fd;
    background: #dbeafe;
}

.para-day-option input:focus-visible + span {
    outline: 2px solid var(--para-primary);
    outline-offset: 3px;
}

/* STATUT */

.para-status-input {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 13px;
    border: 1px solid var(--para-border);
    border-radius: 10px;
    background: var(--para-background);
}

.para-status-input > span {
    color: var(--para-text);
    font-size: 12px;
    font-weight: 700;
}

.para-status-input small {
    display: block;
    font-weight: 400;
}

.para-switch {
    position: relative;
    display: inline-block;
    width: 43px;
    height: 24px;
    flex-shrink: 0;
}

.para-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.para-switch-slider {
    position: absolute;
    inset: 0;
    cursor: pointer;
    border-radius: 30px;
    background: #cbd5e1;
    transition: .25s;
}

.para-switch-slider::before {
    position: absolute;
    content: "";
    width: 18px;
    height: 18px;
    left: 3px;
    top: 3px;
    border-radius: 50%;
    background: white;
    transition: .25s;
}

.para-switch input:checked + .para-switch-slider {
    background: #16a34a;
}

.para-switch input:checked + .para-switch-slider::before {
    transform: translateX(19px);
}

/* FOOTER FORMULAIRE */

.para-form-footer {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid var(--para-border);
}

.para-secondary-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 43px;
    padding: 10px 17px;
    border: 1px solid var(--para-border);
    border-radius: 9px;
    color: var(--para-text);
    background: var(--para-background);
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}

/* MODE SOMBRE */

html[data-app-theme="dark"] .para-page,
html[data-app-theme="dark"] .para-modal {
    --para-text: #e5eaf3;
    --para-muted: #a4b0c3;
    --para-border: #334155;
    --para-surface: #172235;
    --para-background: #111c2e;
    --para-input: #111c2e;
}

html[data-app-theme="dark"] .para-day-option span {
    background: #111c2e;
}

html[data-app-theme="dark"] .para-day-option input:checked + span {
    color: #bfdbfe;
    background: #1e3a5f;
    border-color: #3b82f6;
}

html[data-app-theme="dark"] .para-heading-icon,
html[data-app-theme="dark"] .para-activity-icon,
html[data-app-theme="dark"] .para-empty-icon {
    color: #93c5fd;
    background: #1e3a5f;
}

html[data-app-theme="dark"] .para-information {
    color: #bfdbfe;
    background: #172b47;
    border-color: #29466c;
}

html[data-app-theme="dark"] .para-alert-success {
    color: #bbf7d0;
    background: #123322;
    border-color: #245c3b;
}

html[data-app-theme="dark"] .para-alert-error {
    color: #fecaca;
    background: #3b1d25;
    border-color: #71313b;
}

/* AUTRES THÈMES */

html[data-app-theme="ultra-pro"] .para-page,
html[data-app-theme="ultra-pro"] .para-modal {
    --para-primary: #60a5fa;
}

html[data-app-theme="emerald"] .para-page,
html[data-app-theme="emerald"] .para-modal {
    --para-primary: #059669;
}

html[data-app-theme="warm"] .para-page,
html[data-app-theme="warm"] .para-modal {
    --para-primary: #d97706;
}

/* RESPONSIVE */

@media (max-width: 900px) {
    .para-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .para-activities-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .para-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .para-header h2 {
        font-size: 21px;
    }

    .para-header .para-main-btn {
        width: 100%;
    }

    .para-stats {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .para-stat-card {
        min-height: 75px;
    }

    .para-modal {
        max-height: 94vh;
    }

    .para-modal-content {
        padding: 15px;
    }

    .para-form-grid {
        grid-template-columns: 1fr;
    }

    .para-field-full {
        grid-column: auto;
    }

    .para-activity-actions {
        flex-direction: column;
    }

    .para-activity-actions form,
    .para-action-btn {
        width: 100%;
    }
}
</style>


<script>
function ouvrirModal() {
    const modal = document.getElementById('paraModal');

    if (modal && !modal.open) {
        modal.showModal();
    }
}

function fermerModal() {
    const modal = document.getElementById('paraModal');

    if (modal && modal.open) {
        modal.close();
    }
}

// Fermeture en cliquant sur le fond
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('paraModal');

    if (!modal) return;

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            fermerModal();
        }
    });

    // Réouverture automatique après validation échouée
    @if($edition || $errors->any())
        ouvrirModal();
    @endif

});
</script>

@endsection
