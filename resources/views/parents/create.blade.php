@extends('layouts.app')

@section('content')

    <div class="container-fluid px-3 px-md-4 py-4 parent-form-page">

        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1 page-title">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Ajouter un parent
                </h2>
                <p class="text-secondary mb-0">
                    Enregistrez les coordonnées et associez les enfants du parent.
                </p>
            </div>

            <a href="{{ route('parents.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Retour à la liste
            </a>
        </div>

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Veuillez corriger les erreurs suivantes :
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('parents.store') }}" method="POST">
            @csrf

            {{-- Informations personnelles --}}
            <div class="card border-0 shadow-sm form-card mb-4">

                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-person-vcard me-2"></i>
                        Informations personnelles
                    </h5>

                    <small class="text-secondary">
                        Les champs marqués d'un astérisque sont obligatoires.
                    </small>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="nom" class="form-label">
                                Nom <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="nom" name="nom"
                                class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required
                                maxlength="255">

                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="prenom" class="form-label">
                                Prénom <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="prenom" name="prenom"
                                class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}"
                                required maxlength="255">

                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telephone" class="form-label">
                                Téléphone principal
                            </label>

                            <input type="tel" id="telephone" name="telephone" class="form-control"
                                value="{{ old('telephone') }}" maxlength="30">
                        </div>

                        <div class="col-md-6">
                            <label for="telephone_secondaire" class="form-label">
                                Téléphone secondaire
                            </label>

                            <input type="tel" id="telephone_secondaire" name="telephone_secondaire" class="form-control"
                                value="{{ old('telephone_secondaire') }}" maxlength="30">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                Adresse e-mail
                            </label>

                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email') }}" maxlength="255">
                        </div>

                        <div class="col-md-6">
                            <label for="profession" class="form-label">
                                Profession
                            </label>

                            <input type="text" id="profession" name="profession" class="form-control"
                                value="{{ old('profession') }}" maxlength="255">
                        </div>

                        <div class="col-12">
                            <label for="adresse" class="form-label">
                                Adresse
                            </label>

                            <textarea id="adresse" name="adresse" rows="3" class="form-control" maxlength="2000">{{ old('adresse') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Enfants associés --}}
            <div class="card border-0 shadow-sm form-card mb-4">

                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-people-fill me-2"></i>
                        Enfants associés
                    </h5>

                    <small class="text-secondary">
                        Sélectionnez les élèves dont cette personne est le parent
                        ou le responsable légal.
                    </small>
                </div>

                <div class="card-body p-4">

                    <div class="alert alert-info border-0">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Vous pouvez associer plusieurs enfants à un même parent.
                        Cette association ne crée ni ne modifie les fiches des élèves.
                    </div>

                    <div class="mb-3">
                        <label for="rechercheEleve" class="form-label">
                            Rechercher un élève
                        </label>

                        <input type="search" id="rechercheEleve" class="form-control"
                            placeholder="Nom, prénom ou matricule...">
                    </div>

                    @if ($eleves->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-mortarboard display-5 text-secondary"></i>

                            <p class="mt-3 mb-0">
                                Aucun élève enregistré pour le moment.
                            </p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle" id="tableauEleves">

                                <thead>
                                    <tr>
                                        <th class="text-center">Associer</th>
                                        <th>Élève</th>
                                        <th>Matricule</th>
                                        <th>Lien de parenté</th>
                                        <th class="text-center">Responsable légal</th>
                                        <th class="text-center">Contact principal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($eleves as $eleve)
                                        <tr class="ligne-eleve">

                                            {{-- Case pour associer l'élève --}}
                                            <td class="text-center">
                                                <input type="checkbox" class="checkbox-visible choix-eleve"
                                                    name="eleves[{{ $eleve->id }}][id]" value="{{ $eleve->id }}"
                                                    id="eleve_{{ $eleve->id }}"
                                                    aria-label="Associer {{ $eleve->nom }} {{ $eleve->prenom }}"
                                                    {{ old('eleves.' . $eleve->id . '.id') ? 'checked' : '' }}>
                                            </td>

                                            {{-- Nom de l'élève --}}
                                            <td>
                                                <label for="eleve_{{ $eleve->id }}" class="fw-semibold nom-eleve">
                                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                                </label>
                                            </td>

                                            {{-- Matricule --}}
                                            <td>
                                                {{ $eleve->matricule ?: '—' }}
                                            </td>

                                            {{-- Lien de parenté --}}
                                            <td>
                                                <select class="form-select lien-parente"
                                                    name="eleves[{{ $eleve->id }}][lien_parente]"
                                                    aria-label="Lien de parenté pour {{ $eleve->nom }}" disabled>
                                                    <option value="Père"
                                                        {{ old('eleves.' . $eleve->id . '.lien_parente', 'Autre') === 'Père' ? 'selected' : '' }}>
                                                        Père
                                                    </option>

                                                    <option value="Mère"
                                                        {{ old('eleves.' . $eleve->id . '.lien_parente', 'Autre') === 'Mère' ? 'selected' : '' }}>
                                                        Mère
                                                    </option>

                                                    <option value="Tuteur"
                                                        {{ old('eleves.' . $eleve->id . '.lien_parente', 'Autre') === 'Tuteur' ? 'selected' : '' }}>
                                                        Tuteur
                                                    </option>

                                                    <option value="Autre"
                                                        {{ old('eleves.' . $eleve->id . '.lien_parente', 'Autre') === 'Autre' ? 'selected' : '' }}>
                                                        Autre
                                                    </option>
                                                </select>
                                            </td>

                                            {{-- Responsable légal --}}
                                            <td class="text-center">
                                                <input type="checkbox" class="checkbox-visible responsable-legal"
                                                    name="eleves[{{ $eleve->id }}][responsable_legal]" value="1"
                                                    aria-label="Responsable légal pour {{ $eleve->nom }}" disabled
                                                    {{ old('eleves.' . $eleve->id . '.responsable_legal') ? 'checked' : '' }}>
                                            </td>

                                            {{-- Contact principal --}}
                                            <td class="text-center">
                                                <input type="checkbox" class="checkbox-visible contact-principal"
                                                    name="eleves[{{ $eleve->id }}][contact_principal]" value="1"
                                                    aria-label="Contact principal pour {{ $eleve->nom }}" disabled
                                                    {{ old('eleves.' . $eleve->id . '.contact_principal') ? 'checked' : '' }}>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        <div id="aucunEleveTrouve" class="text-center text-secondary py-3 d-none">
                            Aucun élève ne correspond à votre recherche.
                        </div>
                    @endif

                </div>
            </div>

            {{-- Boutons --}}
            <div class="d-flex justify-content-end gap-2 flex-wrap mb-4">

                <a href="{{ route('parents.index') }}" class="btn btn-light border px-4">
                    Annuler
                </a>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Enregistrer le parent
                </button>

            </div>

        </form>
    </div>

    <style>
        /* Page */
        .parent-form-page {
            color: #243447;
        }

        .parent-form-page .page-title {
            color: #102a43;
        }

        .parent-form-page .form-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .parent-form-page .form-control,
        .parent-form-page .form-select {
            border-color: #dbe3ec;
            border-radius: 8px;
            padding: 10px 12px;
        }

        .parent-form-page .form-control:focus,
        .parent-form-page .form-select:focus {
            border-color: #526f91;
            box-shadow: 0 0 0 .2rem rgba(16, 42, 67, .10);
        }

        .parent-form-page .btn-primary {
            background: #102a43;
            border-color: #102a43;
            border-radius: 8px;
        }

        .parent-form-page .btn-primary:hover {
            background: #183f60;
            border-color: #183f60;
        }

        /* En-tête du tableau */
        #tableauEleves th {
            background: #f3f6fa;
            color: #526579;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        #tableauEleves td,
        #tableauEleves th {
            padding: 12px;
            vertical-align: middle;
        }

        /* CASES À COCHER VISIBLES */
        .parent-form-page #tableauEleves input.checkbox-visible {
            appearance: none;
            -webkit-appearance: none;

            display: inline-grid;
            place-content: center;

            width: 25px;
            height: 25px;
            min-width: 25px;
            margin: 0;

            background-color: #ffffff;
            border: 2px solid #34495e;
            border-radius: 5px;

            cursor: pointer;
            vertical-align: middle;

            transition: background-color .15s ease,
                border-color .15s ease,
                box-shadow .15s ease;
        }

        /* Fond bleu quand la case est cochée */
        .parent-form-page #tableauEleves input.checkbox-visible:checked {
            background-color: #174a78;
            border-color: #174a78;
        }

        /* Coche blanche */
        .parent-form-page #tableauEleves input.checkbox-visible:checked::after {
            content: "";
            width: 7px;
            height: 12px;
            border: solid #ffffff;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
            margin-top: -3px;
        }

        /* Focus visible */
        .parent-form-page #tableauEleves input.checkbox-visible:focus-visible {
            outline: 3px solid rgba(23, 74, 120, .25);
            outline-offset: 3px;
        }

        /* Case désactivée */
        .parent-form-page #tableauEleves input.checkbox-visible:disabled {
            background-color: #e8edf2;
            border-color: #b9c4d0;
            cursor: not-allowed;
        }

        /* Ligne sélectionnée */
        .ligne-eleve:has(.choix-eleve:checked) {
            background-color: #edf5ff;
        }

        .ligne-eleve {
            transition: background-color .15s ease;
        }

        .nom-eleve {
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const lignes = document.querySelectorAll('.ligne-eleve');
            const recherche = document.getElementById('rechercheEleve');
            const aucunTrouve = document.getElementById('aucunEleveTrouve');

            // Active ou désactive les options d'un élève
            function actualiserLigne(ligne) {
                const choix = ligne.querySelector('.choix-eleve');

                const controles = ligne.querySelectorAll(
                    '.lien-parente, .responsable-legal, .contact-principal'
                );

                controles.forEach(function(controle) {
                    controle.disabled = !choix.checked;
                });

                ligne.classList.toggle('eleve-selectionne', choix.checked);
            }

            // Initialisation des lignes
            lignes.forEach(function(ligne) {
                const choix = ligne.querySelector('.choix-eleve');

                actualiserLigne(ligne);

                choix.addEventListener('change', function() {
                    actualiserLigne(ligne);
                });
            });

            // Recherche par nom, prénom ou matricule
            if (recherche) {
                recherche.addEventListener('input', function() {
                    const terme = this.value
                        .toLocaleLowerCase('fr')
                        .trim();

                    let nombreVisible = 0;

                    lignes.forEach(function(ligne) {
                        const texte = ligne.textContent
                            .toLocaleLowerCase('fr');

                        const correspond = texte.includes(terme);

                        ligne.style.display = correspond ? '' : 'none';

                        if (correspond) {
                            nombreVisible++;
                        }
                    });

                    if (aucunTrouve) {
                        aucunTrouve.classList.toggle(
                            'd-none',
                            nombreVisible !== 0
                        );
                    }
                });
            }
        });
    </script>

@endsection
