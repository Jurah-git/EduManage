@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4">

        <style>
            .edit-inscription {
                max-width: 1200px;
                margin: auto;
                color: #263445;
            }

            .edit-header {
                background: linear-gradient(120deg, #172f50, #2563a6);
                color: white;
                border-radius: 18px;
                padding: 28px 32px;
                margin-bottom: 25px;
                box-shadow: 0 8px 25px rgba(20, 50, 85, .13);
            }

            .edit-header h3 {
                font-weight: 750;
                margin: 0 0 8px;
            }

            .edit-header p {
                margin: 0;
                opacity: .85;
            }

            .edit-card {
                background: white;
                border: 1px solid #e8edf3;
                border-radius: 16px;
                box-shadow: 0 5px 20px rgba(30, 50, 80, .05);
                margin-bottom: 22px;
                overflow: hidden;
            }

            .edit-card-header {
                padding: 19px 23px;
                border-bottom: 1px solid #edf0f4;
            }

            .edit-card-header h5 {
                margin: 0;
                font-size: 16px;
                font-weight: 750;
            }

            .edit-card-header p {
                margin: 5px 0 0;
                color: #7b8795;
                font-size: 13px;
            }

            .edit-card-body {
                padding: 24px;
            }

            .edit-label {
                display: block;
                font-size: 13px;
                font-weight: 700;
                margin-bottom: 8px;
                color: #34445a;
            }

            .edit-control {
                width: 100%;
                min-height: 46px;
                border: 1px solid #dce3ec;
                border-radius: 10px;
                padding: 10px 13px;
                background: #fff;
                color: #263445;
                outline: none;
                transition: .2s;
            }

            .edit-control:focus {
                border-color: #347fc2;
                box-shadow: 0 0 0 3px rgba(52, 127, 194, .10);
            }

            textarea.edit-control {
                min-height: 115px;
                resize: vertical;
            }

            .edit-field {
                margin-bottom: 21px;
            }

            .edit-type {
                padding: 17px;
                border-radius: 12px;
                background: #f0f6ff;
                border: 1px solid #d7e7fb;
            }

            .edit-type strong {
                display: block;
                font-size: 15px;
                color: #245d96;
                margin-bottom: 5px;
            }

            .edit-type span {
                font-size: 13px;
                color: #65778d;
            }

            .edit-student {
                background: #f7f9fc;
                border: 1px solid #e7edf4;
                padding: 17px;
                border-radius: 12px;
                margin-bottom: 22px;
            }

            .edit-student strong {
                display: block;
                font-size: 16px;
                margin-bottom: 5px;
            }

            .edit-student span {
                color: #758398;
                font-size: 13px;
            }

            .edit-actions {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                flex-wrap: wrap;
                padding-top: 18px;
            }

            .edit-btn {
                border: 0;
                border-radius: 10px;
                padding: 12px 20px;
                font-weight: 700;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .edit-btn-primary {
                background: #2469a8;
                color: white;
            }

            .edit-btn-primary:hover {
                background: #18558e;
                color: white;
            }

            .edit-btn-secondary {
                background: #edf1f5;
                color: #44546a;
            }

            .edit-required {
                color: #dc3545;
            }

            .edit-error {
                color: #dc3545;
                font-size: 12px;
                margin-top: 6px;
            }

            @media(max-width: 768px) {
                .edit-header {
                    padding: 22px;
                }

                .edit-card-body {
                    padding: 17px;
                }
            }
        </style>

        <div class="edit-inscription">

            {{-- EN-TÊTE --}}
            <div class="edit-header">
                <h3>✏️ Modifier une inscription</h3>
                <p>
                    Modification du dossier d'inscription
                    N° {{ $inscription->id }}.
                </p>
            </div>

            {{-- ERREURS --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
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

                {{-- INFORMATIONS ÉLÈVE --}}
                <div class="edit-card">

                    <div class="edit-card-header">
                        <h5>👨‍🎓 Informations de l'élève</h5>
                        <p>Sélectionnez l'élève concerné par cette inscription.</p>
                    </div>

                    <div class="edit-card-body">

                        <div class="edit-student" id="editStudentInfo">
                            <strong>{{ $inscription->eleve->nom ?? '' }}
                                {{ $inscription->eleve->prenom ?? '' }}</strong>
                            <span>
                                Matricule :
                                {{ $inscription->eleve->matricule ?? 'Non renseigné' }}
                            </span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label">
                                Élève <span class="edit-required">*</span>
                            </label>

                            <select name="eleve_id" id="edit_eleve_id" class="edit-control" required>

                                @foreach ($eleves as $eleve)
                                    <option value="{{ $eleve->id }}" data-matricule="{{ $eleve->matricule }}"
                                        data-nom="{{ $eleve->nom }}" data-prenom="{{ $eleve->prenom }}"
                                        data-deja-inscrit="{{ in_array($eleve->id, $elevesAvecHistorique) ? 'oui' : 'non' }}"
                                        {{ old('eleve_id', $inscription->eleve_id) == $eleve->id ? 'selected' : '' }}>

                                        {{ $eleve->nom }} {{ $eleve->prenom }}
                                        — {{ $eleve->matricule }}
                                    </option>
                                @endforeach

                            </select>

                            @error('eleve_id')
                                <div class="edit-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="edit-field">
                            <label class="edit-label">Type d'inscription automatique</label>

                            <div class="edit-type">
                                <strong id="edit_type_titre">Chargement...</strong>
                                <span id="edit_type_description">
                                    Type déterminé selon l'historique de l'élève.
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- DÉTAILS INSCRIPTION --}}
                <div class="edit-card">

                    <div class="edit-card-header">
                        <h5>📋 Détails de l'inscription</h5>
                        <p>Année scolaire, classe et date d'inscription.</p>
                    </div>

                    <div class="edit-card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="edit-field">
                                    <label class="edit-label">
                                        Classe <span class="edit-required">*</span>
                                    </label>

                                    <select name="classe_id" class="edit-control" required>
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
                                    <label class="edit-label">
                                        Année scolaire <span class="edit-required">*</span>
                                    </label>

                                    <select name="annee_scolaire_id" class="edit-control" required>

                                        @foreach ($anneesScolaires as $annee)
                                            <option value="{{ $annee->id }}"
                                                {{ old('annee_scolaire_id', $inscription->annee_scolaire_id) == $annee->id ? 'selected' : '' }}>
                                                {{ $annee->nom }}
                                                {{ $annee->active ? '(Active)' : '' }}
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
                                    <label class="edit-label">
                                        Date d'inscription <span class="edit-required">*</span>
                                    </label>

                                    <input type="date" name="date_inscription" class="edit-control"
                                        value="{{ old('date_inscription', $inscription->date_inscription?->format('Y-m-d')) }}"
                                        required>

                                    @error('date_inscription')
                                        <div class="edit-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="edit-field">
                                    <label class="edit-label">
                                        Statut <span class="edit-required">*</span>
                                    </label>

                                    <select name="statut" class="edit-control" required>
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

                {{-- FRAIS ET OBSERVATIONS --}}
                <div class="edit-card">

                    <div class="edit-card-header">
                        <h5>💰 Informations financières et observations</h5>
                        <p>Montant des frais et informations complémentaires.</p>
                    </div>

                    <div class="edit-card-body">

                        <div class="edit-field">
                            <label class="edit-label">Frais d'inscription</label>

                            <input type="number" name="frais_inscription" class="edit-control" min="0"
                                step="0.01" value="{{ old('frais_inscription', $inscription->frais_inscription) }}">

                            @error('frais_inscription')
                                <div class="edit-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="edit-field">
                            <label class="edit-label">Observations</label>

                            <textarea name="observations" class="edit-control" placeholder="Ajouter une observation...">{{ old('observations', $inscription->observations) }}</textarea>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selectEleve = document.getElementById('edit_eleve_id');

            const titre = document.getElementById('edit_type_titre');

            const description = document.getElementById('edit_type_description');

            const studentInfo = document.getElementById('editStudentInfo');

            function actualiserType() {

                const option = selectEleve.options[selectEleve.selectedIndex];

                if (!option || !option.value) {
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

                studentInfo.querySelector('strong').textContent =
                    option.dataset.nom + ' ' + option.dataset.prenom;

                studentInfo.querySelector('span').textContent =
                    'Matricule : ' + option.dataset.matricule;
            }

            selectEleve.addEventListener('change', actualiserType);

            actualiserType();

        });
    </script>

@endsection
