@extends('layouts.app')

@section('content')

    <style>
        .matiere-edit-page {
            max-width: 1250px;
            margin: auto;
            padding: 24px;
            color: #243247;
        }

        .matiere-edit-hero {
            position: relative;
            overflow: hidden;
            padding: 30px 34px;
            border-radius: 20px;
            color: white;
            background: linear-gradient(120deg, #8a5a13, #d69b32 60%, #e9b95c);
            box-shadow: 0 12px 30px rgba(138, 90, 19, .16);
            margin-bottom: 25px;
        }

        .matiere-edit-hero::after {
            content: "\f044";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            right: 45px;
            top: 15px;
            font-size: 115px;
            opacity: .12;
            transform: rotate(-12deg);
        }

        .matiere-edit-hero h3 {
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .matiere-edit-hero p {
            margin: 0;
            opacity: .9;
            position: relative;
            z-index: 1;
        }

        .matiere-edit-card {
            background: white;
            border: 1px solid #e8edf4;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(20, 40, 70, .06);
            overflow: hidden;
        }

        .matiere-section-header {
            padding: 20px 25px;
            border-bottom: 1px solid #edf0f5;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .matiere-section-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff5df;
            color: #b77b19;
            font-size: 19px;
        }

        .matiere-section-header h5 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px;
        }

        .matiere-section-header p {
            margin: 0;
            color: #8491a5;
            font-size: 12px;
        }

        .matiere-form-body {
            padding: 27px;
        }

        .matiere-label {
            font-size: 13px;
            font-weight: 700;
            color: #34445b;
            margin-bottom: 9px;
        }

        .matiere-input {
            height: 49px;
            border-radius: 11px;
            border: 1px solid #dce3ed;
            padding: 10px 15px;
            font-size: 14px;
            transition: .2s;
        }

        .matiere-input:focus {
            border-color: #d69b32;
            box-shadow: 0 0 0 3px rgba(214, 155, 50, .12);
        }

        .matiere-stat {
            height: 100%;
            padding: 17px;
            border-radius: 13px;
            background: #fff9ed;
            border: 1px solid #f4e8cd;
        }

        .matiere-stat-label {
            font-size: 11px;
            color: #98753c;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .matiere-stat-value {
            font-size: 25px;
            font-weight: 800;
            color: #8a5a13;
            margin-top: 5px;
        }

        .matiere-help {
            color: #8a96a8;
            font-size: 12px;
            margin-top: 8px;
        }

        .classes-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .classes-search {
            position: relative;
            flex: 1;
            min-width: 220px;
            max-width: 360px;
        }

        .classes-search i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a1b4;
        }

        .classes-search input {
            width: 100%;
            height: 41px;
            padding: 8px 12px 8px 37px;
            border: 1px solid #e0e6ef;
            border-radius: 10px;
            outline: none;
            font-size: 13px;
        }

        .classes-search input:focus {
            border-color: #d69b32;
        }

        .class-selection-box {
            padding: 18px;
            border: 1px solid #e5ebf3;
            border-radius: 14px;
            background: #f9fbfe;
        }

        .class-item {
            height: 100%;
            padding: 13px 14px;
            background: white;
            border: 1px solid #e5eaf1;
            border-radius: 11px;
            transition: .2s;
        }

        .class-item:hover {
            border-color: #e5bd70;
            transform: translateY(-2px);
            box-shadow: 0 5px 13px rgba(150, 110, 35, .07);
        }

        .class-item.selected {
            border-color: #d69b32;
            background: #fff9ed;
        }

        .class-item .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            min-height: 22px;
        }

        .class-item .form-check-input {
            width: 17px;
            height: 17px;
            margin: 0;
            cursor: pointer;
            flex-shrink: 0;
        }

        .class-item .form-check-input:checked {
            background-color: #c58a26;
            border-color: #c58a26;
        }

        .class-item .form-check-label {
            font-size: 13px;
            font-weight: 700;
            color: #34445b;
            cursor: pointer;
            flex: 1;
        }

        .class-empty {
            display: none;
            text-align: center;
            padding: 30px;
            color: #8996a8;
            font-size: 13px;
        }

        .selection-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 13px 16px;
            background: #fff6e5;
            border-radius: 11px;
            margin-top: 16px;
        }

        .selection-summary strong {
            color: #946315;
            font-size: 13px;
        }

        .matiere-preview {
            margin-top: 22px;
            padding: 17px;
            border: 1px dashed #e5c887;
            border-radius: 13px;
            background: #fffdf8;
        }

        .matiere-preview-title {
            font-size: 11px;
            color: #98753c;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: .5px;
            margin-bottom: 10px;
        }

        .matiere-preview-name {
            font-size: 18px;
            font-weight: 800;
            color: #34445b;
            overflow-wrap: anywhere;
        }

        .matiere-form-footer {
            padding: 20px 27px;
            background: #fafbfd;
            border-top: 1px solid #edf0f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .matiere-btn {
            border-radius: 10px;
            padding: 11px 20px;
            font-size: 13px;
            font-weight: 700;
        }

        .matiere-btn-primary {
            color: white;
            border: 0;
            background: linear-gradient(120deg, #a66b16, #d69b32);
            box-shadow: 0 5px 12px rgba(166, 107, 22, .18);
        }

        .matiere-btn-primary:hover {
            color: white;
            opacity: .92;
            transform: translateY(-1px);
        }

        .matiere-btn-light {
            background: white;
            border: 1px solid #dfe6ef;
            color: #526176;
        }

        .matiere-btn-light:hover {
            background: #f2f5f9;
        }

        .matiere-alert {
            border-radius: 11px;
            font-size: 13px;
        }

        @media(max-width: 768px) {
            .matiere-edit-page {
                padding: 14px;
            }

            .matiere-edit-hero {
                padding: 24px;
            }

            .matiere-form-body {
                padding: 18px;
            }

            .matiere-form-footer {
                padding: 17px;
            }
        }
    </style>

    <div class="matiere-edit-page">

        {{-- EN-TÊTE --}}
        <div class="matiere-edit-hero">

            <div class="d-flex align-items-center gap-3 mb-2">
                <i class="fas fa-edit fa-2x"></i>

                <span class="small fw-bold text-uppercase">
                    Gestion pédagogique
                </span>
            </div>

            <h3>Modifier une matière</h3>

            <p>
                Actualisez les informations de la matière et gérez
                ses affectations aux différentes classes.
            </p>

        </div>

        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="alert alert-danger matiere-alert mb-4">

                <div class="fw-bold mb-2">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Vérifiez les informations saisies
                </div>

                <ul class="mb-0 ps-4">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif

        <form method="POST" action="{{ route('matieres.update', $matiere) }}">

            @csrf
            @method('PUT')

            <div class="matiere-edit-card">

                {{-- SECTION INFORMATIONS --}}
                <div class="matiere-section-header">

                    <div class="matiere-section-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>

                    <div>
                        <h5>Informations de la matière</h5>
                        <p>Modifiez le nom de la matière</p>
                    </div>

                </div>

                <div class="matiere-form-body">

                    <div class="row g-4">

                        <div class="col-lg-8">

                            <label class="matiere-label">
                                Nom de la matière
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nom" id="matiereNom" value="{{ old('nom', $matiere->nom) }}"
                                class="form-control matiere-input @error('nom') is-invalid @enderror"
                                placeholder="Exemple : Mathématiques, Français..." required autofocus>

                            @error('nom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="matiere-help">
                                <i class="fas fa-lightbulb me-1"></i>
                                Modifiez le nom tout en conservant une désignation claire.
                            </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="matiere-stat">

                                <div class="matiere-stat-label">
                                    Classes disponibles
                                </div>

                                <div class="matiere-stat-value">
                                    {{ $classes->count() }}
                                </div>

                                <div class="matiere-help">
                                    Nombre de classes enregistrées
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- APERÇU --}}
                    <div class="matiere-preview">

                        <div class="matiere-preview-title">
                            <i class="fas fa-eye me-1"></i>
                            Aperçu de la matière
                        </div>

                        <div class="matiere-preview-name" id="matierePreview">
                            {{ old('nom', $matiere->nom) }}
                        </div>

                    </div>

                </div>

                {{-- SECTION CLASSES --}}
                <div class="matiere-section-header">

                    <div class="matiere-section-icon">
                        <i class="fas fa-school"></i>
                    </div>

                    <div>
                        <h5>Affectation aux classes</h5>
                        <p>Les classes déjà associées à cette matière sont préselectionnées</p>
                    </div>

                </div>

                <div class="matiere-form-body">

                    <div class="classes-toolbar">

                        <div>
                            <div class="fw-bold" style="font-size:14px;">
                                Classes de l'établissement
                            </div>

                            <div class="text-muted small mt-1">
                                Cochez ou décochez les classes selon vos besoins.
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">

                            <button type="button" id="selectAll" class="btn btn-sm btn-success rounded-3">

                                <i class="fas fa-check-double me-1"></i>
                                Tout sélectionner

                            </button>

                            <button type="button" id="deselectAll" class="btn btn-sm btn-outline-danger rounded-3">

                                <i class="fas fa-times me-1"></i>
                                Tout désélectionner

                            </button>

                        </div>

                    </div>

                    {{-- RECHERCHE --}}
                    <div class="classes-search mb-3">

                        <i class="fas fa-search"></i>

                        <input type="text" id="searchClasses" placeholder="Rechercher une classe...">

                    </div>

                    {{-- LISTE DES CLASSES --}}
                    <div class="class-selection-box">

                        @if ($classes->count() > 0)
                            <div class="row g-3" id="classesContainer">

                                @foreach ($classes as $classe)
                                    @php
                                        $isSelected = in_array(
                                            $classe->id,
                                            old('classes', $matiere->classes->pluck('id')->toArray()),
                                        );
                                    @endphp

                                    <div class="col-12 col-md-6 col-xl-4 class-column"
                                        data-name="{{ strtolower($classe->nom) }}">

                                        <div class="class-item {{ $isSelected ? 'selected' : '' }}">

                                            <div class="form-check">

                                                <input type="checkbox" name="classes[]" value="{{ $classe->id }}"
                                                    class="form-check-input classe-checkbox" id="classe{{ $classe->id }}"
                                                    {{ $isSelected ? 'checked' : '' }}>

                                                <label class="form-check-label" for="classe{{ $classe->id }}">

                                                    <i class="fas fa-graduation-cap text-warning me-1"></i>
                                                    {{ $classe->nom }}

                                                </label>

                                            </div>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                            <div class="class-empty" id="classEmpty">

                                <i class="fas fa-search fa-2x mb-2 d-block"></i>

                                Aucune classe ne correspond à votre recherche.

                            </div>
                        @else
                            <div class="text-center py-4 text-muted">

                                <i class="fas fa-school fa-3x mb-3"></i>

                                <h6 class="fw-bold">
                                    Aucune classe disponible
                                </h6>

                                <p class="small mb-0">
                                    Créez d'abord une classe pour pouvoir
                                    l'associer à cette matière.
                                </p>

                            </div>
                        @endif

                    </div>

                    {{-- RÉSUMÉ --}}
                    <div class="selection-summary">

                        <div>
                            <i class="fas fa-check-circle text-warning me-2"></i>

                            <strong id="selectedCount">
                                0 classe sélectionnée
                            </strong>
                        </div>

                        <span class="small text-muted" id="selectionMessage">
                            Aucune classe sélectionnée
                        </span>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="matiere-form-footer">

                    <a href="{{ route('matieres.index') }}" class="btn matiere-btn matiere-btn-light">

                        <i class="fas fa-arrow-left me-2"></i>
                        Retour à la liste

                    </a>

                    <button type="submit" class="btn matiere-btn matiere-btn-primary">

                        <i class="fas fa-save me-2"></i>
                        Enregistrer les modifications

                    </button>

                </div>

            </div>

        </form>

    </div>

    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const checkboxes = document.querySelectorAll('.classe-checkbox');
            const selectedCount = document.getElementById('selectedCount');
            const selectionMessage = document.getElementById('selectionMessage');
            const searchInput = document.getElementById('searchClasses');
            const classColumns = document.querySelectorAll('.class-column');
            const classEmpty = document.getElementById('classEmpty');

            // COMPTEUR ET APERÇU DES SÉLECTIONS
            function updateSelection() {

                let selected = 0;

                checkboxes.forEach(function(checkbox) {

                    const card = checkbox.closest('.class-item');

                    if (checkbox.checked) {
                        selected++;
                        card.classList.add('selected');
                    } else {
                        card.classList.remove('selected');
                    }

                });

                selectedCount.textContent =
                    selected + (selected > 1 ?
                        ' classes sélectionnées' :
                        ' classe sélectionnée');

                selectionMessage.textContent = selected > 0 ?
                    'Cette matière sera associée à ' + selected + ' classe(s).' :
                    'Aucune classe sélectionnée';
            }

            // CHANGEMENT INDIVIDUEL
            checkboxes.forEach(function(checkbox) {

                checkbox.addEventListener('change', updateSelection);

            });

            // TOUT SÉLECTIONNER
            document.getElementById('selectAll').addEventListener('click', function() {

                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                });

                updateSelection();

            });

            // TOUT DÉSELECTIONNER
            document.getElementById('deselectAll').addEventListener('click', function() {

                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });

                updateSelection();

            });

            // RECHERCHE DES CLASSES
            searchInput.addEventListener('input', function() {

                const search = this.value.toLowerCase().trim();
                let visible = 0;

                classColumns.forEach(function(column) {

                    const match = column.dataset.name.includes(search);

                    column.style.display = match ? '' : 'none';

                    if (match) visible++;

                });

                classEmpty.style.display =
                    visible === 0 && classColumns.length > 0 ? 'block' : 'none';

            });

            // APERÇU DU NOM EN TEMPS RÉEL
            const nomInput = document.getElementById('matiereNom');
            const nomPreview = document.getElementById('matierePreview');

            nomInput.addEventListener('input', function() {

                nomPreview.textContent = this.value.trim() || 'Nom de la matière';

            });

            // INITIALISATION
            updateSelection();

        });
    </script>

@endsection
