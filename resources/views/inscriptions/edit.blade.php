@extends('layouts.app')

@section('content')

    <div class="edit-inscription-page">

        <style>
            /* =====================================================
               INSCRIPTIONS - MODIFICATION PREMIUM
            ===================================================== */

            .edit-inscription-page {
                --edit-bg: #f4f7fc;
                --edit-card: #ffffff;
                --edit-text: #263445;
                --edit-muted: #7b8795;
                --edit-border: #e5ebf2;
                --edit-input: #ffffff;
                --edit-input-text: #263445;
                --edit-soft: #f7f9fc;
                padding: 25px;
                min-height: 100vh;
                color: var(--edit-text);
                background: var(--edit-bg);
            }

            .edit-inscription {
                max-width: 1250px;
                margin: auto;
            }

            /* HEADER */

            .edit-topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                flex-wrap: wrap;
                margin-bottom: 23px;
            }

            .edit-topbar h2 {
                font-size: 25px;
                font-weight: 850;
                color: var(--edit-text);
                margin: 0 0 6px;
            }

            .edit-topbar p {
                color: var(--edit-muted);
                font-size: 13px;
                margin: 0;
            }

            .edit-back-btn {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                padding: 11px 16px;
                background: var(--edit-card);
                border: 1px solid var(--edit-border);
                color: var(--edit-text) !important;
                border-radius: 11px;
                text-decoration: none;
                font-size: 13px;
                font-weight: 750;
                transition: .2s;
            }

            .edit-back-btn:hover {
                transform: translateY(-2px);
                border-color: #60a5fa;
            }

            /* BANNER */

            .edit-header {
                position: relative;
                overflow: hidden;
                display: flex;
                align-items: center;
                gap: 18px;
                padding: 25px 28px;
                border-radius: 17px;
                margin-bottom: 23px;
                color: white;
                background: linear-gradient(120deg, #172f50, #2563a6, #347fc2);
                box-shadow: 0 8px 24px rgba(20, 50, 85, .13);
            }

            .edit-header-icon {
                width: 57px;
                height: 57px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 15px;
                background: rgba(255, 255, 255, .15);
                font-size: 27px;
            }

            .edit-header h3 {
                font-weight: 850;
                font-size: 19px;
                margin: 0 0 6px;
            }

            .edit-header p {
                margin: 0;
                font-size: 13px;
                opacity: .85;
            }

            .edit-reference {
                margin-left: auto;
                padding: 9px 13px;
                background: rgba(255, 255, 255, .15);
                border: 1px solid rgba(255, 255, 255, .2);
                border-radius: 10px;
                font-size: 12px;
                font-weight: 800;
                white-space: nowrap;
            }

            /* CARDS */

            .edit-card {
                background: var(--edit-card);
                border: 1px solid var(--edit-border);
                border-radius: 16px;
                box-shadow: 0 4px 15px rgba(30, 50, 80, .035);
                margin-bottom: 20px;
                overflow: hidden;
            }

            .edit-card-header {
                display: flex;
                align-items: center;
                gap: 13px;
                padding: 19px 23px;
                border-bottom: 1px solid var(--edit-border);
            }

            .edit-card-icon {
                width: 43px;
                height: 43px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                font-size: 20px;
            }

            .edit-icon-blue {
                background: #eff6ff;
                color: #2563eb;
            }

            .edit-icon-purple {
                background: #f5f3ff;
                color: #7c3aed;
            }

            .edit-icon-orange {
                background: #fff7ed;
                color: #ea580c;
            }

            .edit-card-header h5 {
                margin: 0 0 4px;
                font-size: 15px;
                font-weight: 850;
                color: var(--edit-text);
            }

            .edit-card-header p {
                margin: 0;
                color: var(--edit-muted);
                font-size: 12px;
            }

            .edit-card-body {
                padding: 23px;
            }

            /* FIELDS */

            .edit-field {
                margin-bottom: 21px;
            }

            .edit-field:last-child {
                margin-bottom: 0;
            }

            .edit-label {
                display: block;
                font-size: 12px;
                font-weight: 800;
                margin-bottom: 8px;
                color: var(--edit-text);
            }

            .edit-required {
                color: #ef4444;
            }

            .edit-control {
                display: block;
                width: 100%;
                min-height: 46px;
                border: 1px solid var(--edit-border);
                border-radius: 10px;
                padding: 10px 13px;
                background: var(--edit-input);
                color: var(--edit-input-text);
                outline: none;
                font-size: 13px;
                transition: .2s;
            }

            .edit-control:focus {
                border-color: #347fc2;
                box-shadow: 0 0 0 3px rgba(52, 127, 194, .11);
            }

            .edit-control option {
                background: var(--edit-card);
                color: var(--edit-text);
            }

            textarea.edit-control {
                min-height: 120px;
                resize: vertical;
            }

            .edit-control.is-invalid {
                border-color: #ef4444;
            }

            .edit-error {
                color: #dc3545;
                font-size: 11px;
                margin-top: 6px;
            }

            .edit-help {
                color: var(--edit-muted);
                font-size: 11px;
                margin-top: 6px;
            }

            /* STUDENT */

            .edit-student {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 17px;
                border-radius: 13px;
                background: var(--edit-soft);
                border: 1px solid var(--edit-border);
                margin-bottom: 23px;
            }

            .edit-student-avatar {
                width: 54px;
                height: 54px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: #dbeafe;
                color: #2563eb;
                font-size: 21px;
                font-weight: 850;
            }

            .edit-student-info {
                flex: 1;
                min-width: 0;
            }

            .edit-student-info strong {
                display: block;
                font-size: 15px;
                font-weight: 850;
                color: var(--edit-text);
                margin-bottom: 5px;
            }

            .edit-student-info span {
                color: var(--edit-muted);
                font-size: 12px;
            }

            .edit-student-tag {
                padding: 6px 10px;
                background: rgba(37, 99, 235, .1);
                color: #2563eb;
                border-radius: 20px;
                font-size: 10px;
                font-weight: 850;
                white-space: nowrap;
            }

            /* TYPE */

            .edit-type {
                display: flex;
                align-items: center;
                gap: 13px;
                padding: 17px;
                border-radius: 12px;
                background: #eff6ff;
                border: 1px solid #d7e7fb;
            }

            .edit-type-icon {
                width: 39px;
                height: 39px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                background: rgba(37, 99, 235, .10);
                border-radius: 10px;
                font-size: 19px;
            }

            .edit-type strong {
                display: block;
                font-size: 14px;
                color: #245d96;
                margin-bottom: 5px;
            }

            .edit-type span {
                font-size: 12px;
                color: #65778d;
            }

            /* ACTIONS */

            .edit-actions {
                display: flex;
                justify-content: flex-end;
                gap: 11px;
                flex-wrap: wrap;
                padding: 20px;
                background: var(--edit-card);
                border: 1px solid var(--edit-border);
                border-radius: 15px;
                margin-top: 5px;
            }

            .edit-btn {
                border: 0;
                border-radius: 10px;
                padding: 12px 19px;
                font-size: 13px;
                font-weight: 800;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                cursor: pointer;
                transition: .2s;
            }

            .edit-btn:hover {
                transform: translateY(-2px);
            }

            .edit-btn-primary {
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                color: white;
                box-shadow: 0 5px 13px rgba(37, 99, 235, .17);
            }

            .edit-btn-primary:hover {
                color: white;
                box-shadow: 0 7px 18px rgba(37, 99, 235, .23);
            }

            .edit-btn-secondary {
                background: var(--edit-soft);
                color: var(--edit-text);
                border: 1px solid var(--edit-border);
            }

            /* ALERT */

            .edit-validation-alert {
                border-radius: 12px;
                margin-bottom: 20px;
            }

            /* DARK MODE */

            html[data-app-theme="dark"] .edit-inscription-page {
                --edit-bg: #0f172a;
                --edit-card: #182338;
                --edit-text: #e5edf8;
                --edit-muted: #94a3b8;
                --edit-border: #2b3a52;
                --edit-input: #111c30;
                --edit-input-text: #e2e8f0;
                --edit-soft: #1b2b43;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-back-btn {
                background: #182338;
                color: #e2e8f0 !important;
                border-color: #334155;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-card {
                box-shadow: 0 5px 18px rgba(0, 0, 0, .12);
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-student {
                background: #1b2b43;
                border-color: #334b69;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-student-info strong {
                color: #f1f5f9;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-student-info span {
                color: #a5b4c8;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-type {
                background: #172b45;
                border-color: #29496e;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-type strong {
                color: #93c5fd;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-type span {
                color: #a5b4c8;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-type-icon {
                background: #233b5d;
            }

            html[data-app-theme="dark"] .edit-inscription-page .edit-btn-secondary {
                background: #24344c;
                border-color: #3b4d66;
                color: #e2e8f0;
            }

            html[data-app-theme="dark"] .edit-inscription-page .alert-danger {
                background: #451f2b;
                border-color: #7f293b;
                color: #fecdd3;
            }

            html[data-app-theme="dark"] .edit-inscription-page .alert-danger li {
                color: #fecdd3;
            }

            /* RESPONSIVE */

            @media(max-width: 768px) {
                .edit-inscription-page {
                    padding: 13px;
                }

                .edit-topbar h2 {
                    font-size: 21px;
                }

                .edit-header {
                    padding: 19px;
                }

                .edit-header-icon {
                    width: 47px;
                    height: 47px;
                    font-size: 22px;
                }

                .edit-header h3 {
                    font-size: 16px;
                }

                .edit-reference {
                    margin-left: 0;
                }

                .edit-card-header,
                .edit-card-body {
                    padding: 16px;
                }

                .edit-student {
                    align-items: flex-start;
                    flex-wrap: wrap;
                }

                .edit-student-tag {
                    margin-left: 68px;
                }

                .edit-actions {
                    flex-direction: column-reverse;
                }

                .edit-btn {
                    width: 100%;
                }
            }
        </style>

        <div class="edit-inscription">

            {{-- EN-TÊTE --}}
            <div class="edit-topbar">
                <div>
                    <h2>✏️ Modifier une inscription</h2>
                    <p>Gestion et mise à jour du dossier administratif de l'élève.</p>
                </div>

                <a href="{{ route('inscriptions.index') }}" class="edit-back-btn">
                    ← Retour aux inscriptions
                </a>
            </div>

            {{-- BANNIÈRE --}}
            <div class="edit-header">
                <div class="edit-header-icon">📝</div>

                <div>
                    <h3>Modification du dossier d'inscription</h3>
                    <p>Vérifiez les informations avant d'enregistrer les modifications.</p>
                </div>

                <div class="edit-reference">
                    DOSSIER N° {{ $inscription->id }}
                </div>
            </div>

            {{-- ERREURS --}}
            @if ($errors->any())
                <div class="alert alert-danger edit-validation-alert">
                    <strong>⚠️ Veuillez corriger les erreurs suivantes :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('inscriptions.update', $inscription->id) }}">
                @csrf
                @method('PUT')

                {{-- ==========================================
                 1. INFORMATIONS DE L'ÉLÈVE
            =========================================== --}}
                <div class="edit-card">

                    <div class="edit-card-header">
                        <div class="edit-card-icon edit-icon-blue">👨‍🎓</div>
                        <div>
                            <h5>Informations de l'élève</h5>
                            <p>Sélectionnez l'élève concerné par cette inscription.</p>
                        </div>
                    </div>

                    <div class="edit-card-body">

                        <div class="edit-student" id="editStudentInfo">
                            <div class="edit-student-avatar" id="editStudentAvatar">👨‍🎓</div>

                            <div class="edit-student-info">
                                <strong>{{ $inscription->eleve->nom ?? '' }}
                                    {{ $inscription->eleve->prenom ?? '' }}</strong>
                                <span>
                                    Matricule : {{ $inscription->eleve->matricule ?? 'Non renseigné' }}
                                </span>
                            </div>

                            <span class="edit-student-tag">ÉLÈVE SÉLECTIONNÉ</span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="edit_eleve_id">
                                Élève <span class="edit-required">*</span>
                            </label>

                            <select name="eleve_id" id="edit_eleve_id"
                                class="edit-control @error('eleve_id') is-invalid @enderror" required>

                                @foreach ($eleves as $eleve)
                                    <option value="{{ $eleve->id }}" data-matricule="{{ $eleve->matricule }}"
                                        data-nom="{{ $eleve->nom }}" data-prenom="{{ $eleve->prenom }}"
                                        data-deja-inscrit="{{ in_array($eleve->id, $elevesAvecHistorique) ? 'oui' : 'non' }}"
                                        {{ old('eleve_id', $inscription->eleve_id) == $eleve->id ? 'selected' : '' }}>
                                        {{ $eleve->nom }} {{ $eleve->prenom }} — {{ $eleve->matricule }}
                                    </option>
                                @endforeach

                            </select>

                            @error('eleve_id')
                                <div class="edit-error">{{ $message }}</div>
                            @enderror

                            <div class="edit-help">
                                Le changement d'élève actualise automatiquement les informations affichées.
                            </div>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label">Type d'inscription automatique</label>

                            <div class="edit-type">
                                <div class="edit-type-icon">🔄</div>

                                <div>
                                    <strong id="edit_type_titre">Chargement...</strong>
                                    <span id="edit_type_description">
                                        Type déterminé selon l'historique de l'élève.
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ==========================================
                 2. DÉTAILS DE L'INSCRIPTION
            =========================================== --}}
                <div class="edit-card">

                    <div class="edit-card-header">
                        <div class="edit-card-icon edit-icon-purple">📋</div>
                        <div>
                            <h5>Détails de l'inscription</h5>
                            <p>Année scolaire, classe, date et statut du dossier.</p>
                        </div>
                    </div>

                    <div class="edit-card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="edit-field">
                                    <label class="edit-label" for="edit_classe_id">
                                        Classe <span class="edit-required">*</span>
                                    </label>

                                    <select name="classe_id" id="edit_classe_id"
                                        class="edit-control @error('classe_id') is-invalid @enderror" required>

                                        @foreach ($classes as $classe)
                                            <option value="{{ $classe->id }}"
                                                {{ old('classe_id', $inscription->classe_id) == $classe->id ? 'selected' : '' }}>
                                                {{ $classe->nom }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('classe_id')
                                        <div class="edit-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="edit-field">
                                    <label class="edit-label" for="edit_annee_scolaire_id">
                                        Année scolaire <span class="edit-required">*</span>
                                    </label>

                                    <select name="annee_scolaire_id" id="edit_annee_scolaire_id"
                                        class="edit-control @error('annee_scolaire_id') is-invalid @enderror" required>

                                        @foreach ($anneesScolaires as $annee)
                                            <option value="{{ $annee->id }}"
                                                {{ old('annee_scolaire_id', $inscription->annee_scolaire_id) == $annee->id ? 'selected' : '' }}>
                                                {{ $annee->nom }} {{ $annee->active ? '(Active)' : '' }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('annee_scolaire_id')
                                        <div class="edit-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="edit-field">
                                    <label class="edit-label" for="edit_date_inscription">
                                        Date d'inscription <span class="edit-required">*</span>
                                    </label>

                                    <input type="date" name="date_inscription" id="edit_date_inscription"
                                        class="edit-control @error('date_inscription') is-invalid @enderror"
                                        value="{{ old('date_inscription', $inscription->date_inscription?->format('Y-m-d')) }}"
                                        required>

                                    @error('date_inscription')
                                        <div class="edit-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="edit-field">
                                    <label class="edit-label" for="edit_statut">
                                        Statut <span class="edit-required">*</span>
                                    </label>

                                    <select name="statut" id="edit_statut"
                                        class="edit-control @error('statut') is-invalid @enderror" required>

                                        <option value="en_attente"
                                            {{ old('statut', $inscription->statut) == 'en_attente' ? 'selected' : '' }}>
                                            En attente
                                        </option>

                                        <option value="validee"
                                            {{ old('statut', $inscription->statut) == 'validee' ? 'selected' : '' }}>
                                            Validée
                                        </option>

                                        <option value="annulee"
                                            {{ old('statut', $inscription->statut) == 'annulee' ? 'selected' : '' }}>
                                            Annulée
                                        </option>

                                    </select>

                                    @error('statut')
                                        <div class="edit-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- ==========================================
                 3. FRAIS ET OBSERVATIONS
            =========================================== --}}
                <div class="edit-card">

                    <div class="edit-card-header">
                        <div class="edit-card-icon edit-icon-orange">💰</div>
                        <div>
                            <h5>Informations financières et observations</h5>
                            <p>Montant des frais et informations complémentaires.</p>
                        </div>
                    </div>

                    <div class="edit-card-body">

                        <div class="edit-field">
                            <label class="edit-label" for="edit_frais_inscription">
                                Frais d'inscription (Ar)
                            </label>

                            <input type="number" name="frais_inscription" id="edit_frais_inscription"
                                class="edit-control @error('frais_inscription') is-invalid @enderror" min="0"
                                step="0.01" value="{{ old('frais_inscription', $inscription->frais_inscription) }}"
                                placeholder="0">

                            <div class="edit-help">
                                Indiquez le montant des frais d'inscription. Saisissez 0 si aucun frais n'est demandé.
                            </div>

                            @error('frais_inscription')
                                <div class="edit-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="edit_observations">
                                Observations administratives
                            </label>

                            <textarea name="observations" id="edit_observations" class="edit-control @error('observations') is-invalid @enderror"
                                placeholder="Ajouter une observation...">{{ old('observations', $inscription->observations) }}</textarea>

                            @error('observations')
                                <div class="edit-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="edit-actions">

                    <a href="{{ route('inscriptions.show', $inscription->id) }}" class="edit-btn edit-btn-secondary">
                        ← Annuler
                    </a>

                    <button type="submit" class="edit-btn edit-btn-primary">
                        💾 Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>
    </div>

    {{-- =====================================================
     JAVASCRIPT : TYPE AUTOMATIQUE ET ÉLÈVE SÉLECTIONNÉ
===================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selectEleve = document.getElementById('edit_eleve_id');

            const titre = document.getElementById('edit_type_titre');
            const description = document.getElementById('edit_type_description');

            const studentInfo = document.getElementById('editStudentInfo');
            const studentAvatar = document.getElementById('editStudentAvatar');

            if (!selectEleve || !titre || !description || !studentInfo) {
                return;
            }

            function actualiserType() {

                const option = selectEleve.options[selectEleve.selectedIndex];

                if (!option || !option.value) {
                    titre.textContent = 'Aucun élève sélectionné';
                    description.textContent = 'Veuillez sélectionner un élève.';
                    return;
                }

                const dejaInscrit = option.dataset.dejaInscrit === 'oui';

                if (dejaInscrit) {
                    titre.textContent = '🔄 Réinscription';
                    description.textContent =
                        'Cet élève possède déjà un historique dans l’établissement.';
                } else {
                    titre.textContent = '🆕 Nouvelle inscription';
                    description.textContent =
                        'Cet élève sera inscrit pour la première fois dans l’établissement.';
                }

                const nom = option.dataset.nom || '';
                const prenom = option.dataset.prenom || '';
                const matricule = option.dataset.matricule || 'Non renseigné';

                const strong = studentInfo.querySelector('strong');
                const span = studentInfo.querySelector('span');

                if (strong) {
                    strong.textContent = nom + ' ' + prenom;
                }

                if (span) {
                    span.textContent = 'Matricule : ' + matricule;
                }

                if (studentAvatar) {
                    studentAvatar.textContent = prenom.charAt(0).toUpperCase() || '👨‍🎓';
                }
            }

            selectEleve.addEventListener('change', actualiserType);

            // Initialisation avec l'élève déjà sélectionné
            actualiserType();

        });
    </script>

@endsection
