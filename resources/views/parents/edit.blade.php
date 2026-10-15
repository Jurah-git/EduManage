@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4 parent-edit-page">

        {{-- En-tête --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1 page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Modifier un parent
                </h2>
                <p class="text-secondary mb-0">
                    Modifiez les coordonnées et les enfants associés à ce parent.
                </p>
            </div>

            <a href="{{ route('parents.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Retour à la liste
            </a>
        </div>

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
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

        <form action="{{ route('parents.update', $parent) }}" method="POST" id="formModifierParent">

            @csrf
            @method('PUT')

            {{-- Informations personnelles --}}
            <div class="card border-0 shadow-sm mb-4 form-card">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-person-vcard-fill me-2"></i>
                        Informations du parent
                    </h5>
                    <p class="text-secondary small mb-0">
                        Les champs marqués d'un astérisque sont obligatoires.
                    </p>
                </div>

                <div class="card-body p-4 pt-0">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="nom" class="form-label">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="nom" name="nom"
                                class="form-control @error('nom') is-invalid @enderror"
                                value="{{ old('nom', $parent->nom) }}" maxlength="255" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="prenom" class="form-label">
                                Prénom <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="prenom" name="prenom"
                                class="form-control @error('prenom') is-invalid @enderror"
                                value="{{ old('prenom', $parent->prenom) }}" maxlength="255" required>
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telephone" class="form-label">
                                Téléphone principal
                            </label>
                            <input type="text" id="telephone" name="telephone" class="form-control"
                                value="{{ old('telephone', $parent->telephone) }}" maxlength="30"
                                placeholder="Ex. : 034 00 000 00">
                        </div>

                        <div class="col-md-6">
                            <label for="telephone_secondaire" class="form-label">
                                Téléphone secondaire
                            </label>
                            <input type="text" id="telephone_secondaire" name="telephone_secondaire" class="form-control"
                                value="{{ old('telephone_secondaire', $parent->telephone_secondaire) }}" maxlength="30">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                Adresse e-mail
                            </label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $parent->email) }}" maxlength="255" placeholder="exemple@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="profession" class="form-label">
                                Profession
                            </label>
                            <input type="text" id="profession" name="profession" class="form-control"
                                value="{{ old('profession', $parent->profession) }}" maxlength="255">
                        </div>

                        <div class="col-12">
                            <label for="adresse" class="form-label">
                                Adresse complète
                            </label>
                            <textarea id="adresse" name="adresse" class="form-control" rows="3" maxlength="2000"
                                placeholder="Saisissez l'adresse du parent...">{{ old('adresse', $parent->adresse) }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Association des élèves --}}
            <div class="card border-0 shadow-sm mb-4 form-card">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-mortarboard-fill me-2"></i>
                                Enfants associés
                            </h5>
                            <p class="text-secondary small mb-0">
                                Cochez les élèves liés à ce parent.
                            </p>
                        </div>

                        <span class="badge rounded-pill children-count" id="compteurEleves">
                            {{ $parent->eleves->count() }} enfant(s)
                        </span>
                    </div>
                </div>

                <div class="card-body p-4 pt-0">

                    <div class="mb-3">
                        <input type="search" id="rechercheEleve" class="form-control"
                            placeholder="Rechercher un élève par nom ou matricule...">
                    </div>

                    @if ($eleves->isEmpty())
                        <div class="alert alert-warning mb-0">
                            Aucun élève n'est encore enregistré dans le système.
                        </div>
                    @else
                        <div class="student-list">

                            @foreach ($eleves as $eleve)
                                @php
                                    $ancienneAssociation = $parent->eleves->firstWhere('id', $eleve->id);

                                    $cleEleve = 'eleves.' . $eleve->id;

                                    $ancienneSelection = old($cleEleve . '.id');

                                    $selectionne = session()->hasOldInput('eleves')
                                        ? (string) $ancienneSelection === (string) $eleve->id
                                        : $ancienneAssociation !== null;

                                    $lienParente = old(
                                        $cleEleve . '.lien_parente',
                                        $ancienneAssociation?->pivot?->lien_parente ?? 'Autre',
                                    );

                                    $responsableLegal = session()->hasOldInput('eleves')
                                        ? old($cleEleve . '.responsable_legal') == '1'
                                        : (bool) ($ancienneAssociation?->pivot?->responsable_legal ?? true);

                                    $contactPrincipal = session()->hasOldInput('eleves')
                                        ? old($cleEleve . '.contact_principal') == '1'
                                        : (bool) ($ancienneAssociation?->pivot?->contact_principal ?? false);
                                @endphp

                                <div class="student-edit-item"
                                    data-eleve-search="{{ strtolower($eleve->nom . ' ' . $eleve->prenom . ' ' . ($eleve->matricule ?? '')) }}">

                                    <div class="d-flex align-items-start gap-3">

                                        <div class="student-icon">
                                            <i class="bi bi-person-fill"></i>
                                        </div>

                                        <div class="flex-grow-1">

                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input eleve-checkbox"
                                                    id="eleve_{{ $eleve->id }}"
                                                    name="eleves[{{ $eleve->id }}][id]" value="{{ $eleve->id }}"
                                                    {{ $selectionne ? 'checked' : '' }}>

                                                <label class="form-check-label fw-semibold"
                                                    for="eleve_{{ $eleve->id }}">
                                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                                </label>
                                            </div>

                                            <div class="small text-secondary mb-3">
                                                Matricule :
                                                {{ $eleve->matricule ?: 'Non renseigné' }}
                                            </div>

                                            <div class="row g-3 eleve-details" data-eleve-id="{{ $eleve->id }}">

                                                <div class="col-md-4">
                                                    <label for="lien_{{ $eleve->id }}" class="form-label small">
                                                        Lien de parenté
                                                    </label>

                                                    <select id="lien_{{ $eleve->id }}"
                                                        name="eleves[{{ $eleve->id }}][lien_parente]"
                                                        class="form-select form-select-sm lien-parente"
                                                        {{ $selectionne ? '' : 'disabled' }}>
                                                        <option value="Père"
                                                            {{ $lienParente === 'Père' ? 'selected' : '' }}>
                                                            Père
                                                        </option>
                                                        <option value="Mère"
                                                            {{ $lienParente === 'Mère' ? 'selected' : '' }}>
                                                            Mère
                                                        </option>
                                                        <option value="Tuteur"
                                                            {{ $lienParente === 'Tuteur' ? 'selected' : '' }}>
                                                            Tuteur
                                                        </option>
                                                        <option value="Autre"
                                                            {{ $lienParente === 'Autre' ? 'selected' : '' }}>
                                                            Autre
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 d-flex align-items-end">
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input option-eleve"
                                                            id="responsable_{{ $eleve->id }}"
                                                            name="eleves[{{ $eleve->id }}][responsable_legal]"
                                                            value="1" {{ $responsableLegal ? 'checked' : '' }}
                                                            {{ $selectionne ? '' : 'disabled' }}>
                                                        <label class="form-check-label small"
                                                            for="responsable_{{ $eleve->id }}">
                                                            Responsable légal
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 d-flex align-items-end">
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input option-eleve"
                                                            id="contact_{{ $eleve->id }}"
                                                            name="eleves[{{ $eleve->id }}][contact_principal]"
                                                            value="1" {{ $contactPrincipal ? 'checked' : '' }}
                                                            {{ $selectionne ? '' : 'disabled' }}>
                                                        <label class="form-check-label small"
                                                            for="contact_{{ $eleve->id }}">
                                                            Contact principal
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <div id="aucunEleveTrouve" class="text-center py-4 text-secondary d-none">
                            Aucun élève ne correspond à votre recherche.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex flex-wrap justify-content-end gap-2">
                <a href="{{ route('parents.index') }}" class="btn btn-light border px-4">
                    Annuler
                </a>

                <button type="submit" class="btn btn-primary px-4" id="btnEnregistrer">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>

    <style>
        .parent-edit-page {
            color: #243447;
        }

        .parent-edit-page .page-title {
            color: #102a43;
        }

        .parent-edit-page .form-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .parent-edit-page .form-control,
        .parent-edit-page .form-select {
            border-radius: 8px;
            padding: 10px 12px;
        }

        .parent-edit-page .form-control:focus,
        .parent-edit-page .form-select:focus {
            border-color: #567b9c;
            box-shadow: 0 0 0 0.2rem rgba(16, 42, 67, 0.1);
        }

        .parent-edit-page .btn-primary {
            background: #102a43;
            border-color: #102a43;
            border-radius: 8px;
        }

        .parent-edit-page .btn-primary:hover {
            background: #183f60;
            border-color: #183f60;
        }

        .children-count {
            background: #e7eef7;
            color: #102a43;
            padding: 8px 12px;
        }

        .student-edit-item {
            padding: 20px 0;
            border-bottom: 1px solid #edf1f5;
        }

        .student-edit-item:last-child {
            border-bottom: 0;
        }

        .student-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #f0f4f8;
            color: #102a43;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .eleve-details {
            transition: opacity 0.2s ease;
        }

        .eleve-details.details-disabled {
            opacity: 0.45;
        }

        .parent-edit-page .form-check-input {
            cursor: pointer;
        }

        .parent-edit-page .form-check-label {
            cursor: pointer;
        }

        @media (max-width: 576px) {
            .student-edit-item {
                padding: 16px 0;
            }
        }

        /* Cases à cocher dans la page de modification */
        .parent-edit-page input[type="checkbox"] {
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

        /* Fond bleu lorsque la case est cochée */
        .parent-edit-page input[type="checkbox"]:checked {
            background-color: #174a78;
            border-color: #174a78;
        }

        /* Coche blanche */
        .parent-edit-page input[type="checkbox"]:checked::after {
            content: "";
            width: 7px;
            height: 12px;
            border: solid #ffffff;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
            margin-top: -3px;
        }

        /* Contour visible au clavier */
        .parent-edit-page input[type="checkbox"]:focus-visible {
            outline: 3px solid rgba(23, 74, 120, .25);
            outline-offset: 3px;
        }

        /* Case désactivée */
        .parent-edit-page input[type="checkbox"]:disabled {
            background-color: #e8edf2;
            border-color: #b9c4d0;
            cursor: not-allowed;
        }

        /* Texte et alignement */
        .parent-edit-page .form-check-label {
            color: #243447;
            font-weight: 500;
            cursor: pointer;
        }

        .parent-edit-page .student-edit-item:has(.eleve-checkbox:checked) {
            background-color: #f0f6fc;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recherche = document.getElementById('rechercheEleve');
            const lignes = document.querySelectorAll('.student-edit-item');
            const compteur = document.getElementById('compteurEleves');
            const aucunTrouve = document.getElementById('aucunEleveTrouve');
            const formulaire = document.getElementById('formModifierParent');
            const bouton = document.getElementById('btnEnregistrer');

            function actualiserAssociation(ligne) {
                const checkbox = ligne.querySelector('.eleve-checkbox');
                const details = ligne.querySelector('.eleve-details');
                const controles = details.querySelectorAll('select, input');

                controles.forEach(function(controle) {
                    controle.disabled = !checkbox.checked;
                });

                details.classList.toggle('details-disabled', !checkbox.checked);
            }

            function actualiserCompteur() {
                let nombre = 0;

                document.querySelectorAll('.eleve-checkbox').forEach(function(checkbox) {
                    if (checkbox.checked) {
                        nombre++;
                    }
                });

                compteur.textContent = nombre + ' enfant(s)';
            }

            lignes.forEach(function(ligne) {
                const checkbox = ligne.querySelector('.eleve-checkbox');

                actualiserAssociation(ligne);

                checkbox.addEventListener('change', function() {
                    actualiserAssociation(ligne);
                    actualiserCompteur();
                });
            });

            if (recherche) {
                recherche.addEventListener('input', function() {
                    const terme = recherche.value.trim().toLowerCase();
                    let visibles = 0;

                    lignes.forEach(function(ligne) {
                        const texte = ligne.dataset.eleveSearch || '';
                        const correspond = texte.includes(terme);

                        ligne.classList.toggle('d-none', !correspond);

                        if (correspond) {
                            visibles++;
                        }
                    });

                    if (aucunTrouve) {
                        aucunTrouve.classList.toggle('d-none', visibles !== 0);
                    }
                });
            }

            actualiserCompteur();

            if (formulaire && bouton) {
                formulaire.addEventListener('submit', function() {
                    bouton.disabled = true;
                    bouton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2"></span>Enregistrement...';
                });
            }
        });
    </script>
@endsection
