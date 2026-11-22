@extends('layouts.app')

@section('content')

    <style>
        /* =========================================================
                                                                   INSCRIPTION - FORMULAIRE PREMIUM
                                                                ========================================================= */

        .ins-create {
            padding: 24px;
            color: #1e293b;
        }

        .ins-create-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .ins-create-header h2 {
            font-size: 26px;
            font-weight: 800;
            margin: 0 0 6px;
            color: #1e293b;
        }

        .ins-create-header p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .ins-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 16px;
            border: 1px solid #e2e8f0;
            background: #fff;
            border-radius: 11px;
            color: #475569 !important;
            text-decoration: none !important;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .ins-back-btn:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        /* BANNER */
        .ins-create-banner {
            display: flex;
            align-items: center;
            gap: 17px;
            padding: 22px;
            border-radius: 17px;
            margin-bottom: 23px;
            color: white;
            background: linear-gradient(120deg, #1e40af, #2563eb, #3b82f6);
            box-shadow: 0 8px 22px rgba(37, 99, 235, .15);
        }

        .ins-create-banner-icon {
            width: 57px;
            height: 57px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
            flex-shrink: 0;
        }

        .ins-create-banner h4 {
            font-size: 17px;
            font-weight: 800;
            margin: 0 0 5px;
        }

        .ins-create-banner p {
            font-size: 13px;
            opacity: .85;
            margin: 0;
        }

        /* ACTIVE YEAR */
        .ins-year-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            background: #fff;
            border: 1px solid #e6edf5;
            border-radius: 15px;
            padding: 18px 21px;
            margin-bottom: 22px;
        }

        .ins-year-label {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ins-year-icon {
            width: 43px;
            height: 43px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .ins-year-label small {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .ins-year-label strong {
            color: #1e293b;
            font-size: 15px;
        }

        .ins-year-status {
            background: #ecfdf5;
            color: #059669;
            border-radius: 20px;
            padding: 7px 12px;
            font-size: 11px;
            font-weight: 800;
        }

        /* FORM LAYOUT */
        .ins-create-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 300px;
            gap: 22px;
            align-items: start;
        }

        .ins-create-main {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* SECTION CARD */
        .ins-create-card {
            background: #fff;
            border: 1px solid #e7edf4;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .03);
        }

        .ins-create-card-header {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 19px 22px;
            border-bottom: 1px solid #edf1f6;
        }

        .ins-create-section-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .ins-section-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .ins-section-purple {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .ins-section-orange {
            background: #fff7ed;
            color: #ea580c;
        }

        .ins-create-card-header h5 {
            font-size: 15px;
            font-weight: 800;
            color: #1e293b;
            margin: 0 0 4px;
        }

        .ins-create-card-header p {
            font-size: 12px;
            color: #94a3b8;
            margin: 0;
        }

        .ins-create-card-body {
            padding: 22px;
        }

        /* FIELDS */
        .ins-create-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .ins-create-field.full {
            grid-column: 1 / -1;
        }

        .ins-create-field label {
            display: block;
            margin-bottom: 8px;
            color: #475569;
            font-size: 12px;
            font-weight: 800;
        }

        .ins-required {
            color: #ef4444;
        }

        .ins-create-input,
        .ins-create-select,
        .ins-create-textarea {
            width: 100%;
            border: 1px solid #dce4ed;
            background: #fff;
            color: #334155;
            border-radius: 10px;
            outline: none;
            font-size: 13px;
            transition: .2s;
        }

        .ins-create-input,
        .ins-create-select {
            height: 45px;
            padding: 0 13px;
        }

        .ins-create-textarea {
            padding: 13px;
            resize: vertical;
            min-height: 110px;
        }

        .ins-create-input:focus,
        .ins-create-select:focus,
        .ins-create-textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .09);
        }

        .ins-create-input.is-invalid,
        .ins-create-select.is-invalid,
        .ins-create-textarea.is-invalid {
            border-color: #ef4444;
        }

        .ins-field-help {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 6px;
        }

        .ins-field-error {
            font-size: 11px;
            color: #dc2626;
            margin-top: 6px;
        }

        /* STUDENT SELECT */
        .ins-student-note {
            background: #f8fafc;
            border: 1px dashed #dbe4ee;
            padding: 12px 14px;
            border-radius: 10px;
            margin-top: 14px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }

        /* TYPE SELECTION */
        .ins-type-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .ins-type-option {
            position: relative;
        }

        .ins-type-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .ins-type-option label {
            display: block;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            transition: .2s;
            height: 100%;
            margin: 0;
        }

        .ins-type-option label:hover {
            border-color: #93c5fd;
            background: #f8fbff;
        }

        .ins-type-option input:checked+label {
            border-color: #3b82f6;
            background: #eff6ff;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, .07);
        }

        .ins-type-option strong {
            display: block;
            color: #334155;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .ins-type-option span {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 500;
        }

        /* SUMMARY SIDEBAR */
        .ins-create-summary {
            position: sticky;
            top: 20px;
        }

        .ins-summary-card {
            background: #fff;
            border: 1px solid #e7edf4;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .035);
            overflow: hidden;
        }

        .ins-summary-header {
            padding: 19px;
            border-bottom: 1px solid #edf1f6;
        }

        .ins-summary-header h5 {
            margin: 0;
            color: #1e293b;
            font-size: 15px;
            font-weight: 800;
        }

        .ins-summary-header p {
            margin: 5px 0 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .ins-summary-body {
            padding: 19px;
        }

        .ins-summary-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 16px;
            font-size: 12px;
        }

        .ins-summary-row span {
            color: #94a3b8;
        }

        .ins-summary-row strong {
            color: #475569;
            text-align: right;
        }

        .ins-summary-divider {
            border: 0;
            border-top: 1px dashed #e2e8f0;
            margin: 17px 0;
        }

        .ins-summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            background: #f8fafc;
            border-radius: 11px;
            padding: 14px;
        }

        .ins-summary-total span {
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
        }

        .ins-summary-total strong {
            font-size: 18px;
            font-weight: 900;
            color: #1e293b;
        }

        /* ACTIONS */
        .ins-create-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 18px;
        }

        .ins-submit-btn {
            width: 100%;
            min-height: 46px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s;
            box-shadow: 0 5px 13px rgba(37, 99, 235, .17);
        }

        .ins-submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 18px rgba(37, 99, 235, .22);
        }

        .ins-cancel-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 44px;
            border: 1px solid #e2e8f0;
            border-radius: 11px;
            color: #64748b !important;
            background: white;
            text-decoration: none !important;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .ins-cancel-btn:hover {
            background: #f8fafc;
        }

        /* VALIDATION ALERT */
        .ins-validation-alert {
            border-radius: 12px;
            margin-bottom: 20px;
        }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .ins-create-layout {
                grid-template-columns: 1fr;
            }

            .ins-create-summary {
                position: static;
            }
        }

        @media (max-width: 650px) {
            .ins-create {
                padding: 12px;
            }

            .ins-create-header h2 {
                font-size: 22px;
            }

            .ins-create-banner {
                padding: 17px;
            }

            .ins-create-card-header,
            .ins-create-card-body {
                padding: 16px;
            }

            .ins-create-grid {
                grid-template-columns: 1fr;
            }

            .ins-create-field.full {
                grid-column: auto;
            }

            .ins-type-options {
                grid-template-columns: 1fr;
            }
        }


        /* =====================================
                                               SÉLECTION PROFESSIONNELLE DES ÉLÈVES
                                            ===================================== */

        .ins-selected-student {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px;
            background: #f5f9ff;
            border: 1px solid #dce9f8;
            border-radius: 14px;
            flex-wrap: wrap;
        }

        .ins-selected-avatar {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #dcecff;
            color: #2469a8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            font-weight: 800;
            overflow: hidden;
            flex-shrink: 0;
        }

        .ins-selected-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ins-selected-info {
            flex: 1;
            min-width: 150px;
        }

        .ins-selected-info strong {
            display: block;
            font-size: 16px;
            color: #263445;
            margin-bottom: 5px;
        }

        .ins-selected-info span {
            color: #718096;
            font-size: 13px;
        }

        .ins-change-student {
            border: 0;
            border-radius: 10px;
            padding: 11px 17px;
            background: #2469a8;
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .ins-change-student:hover {
            background: #18558e;
        }

        /* FENÊTRE MODALE */

        .ins-eleve-modal {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, .18);
        }

        .ins-modal-header {
            background: linear-gradient(120deg, #172f50, #2874b9);
            color: white;
            padding: 22px 25px;
        }

        .ins-modal-header h5 {
            font-weight: 800;
            margin-bottom: 5px;
        }

        .ins-modal-header p {
            margin: 0;
            opacity: .8;
            font-size: 13px;
        }

        .ins-eleve-modal .modal-body {
            padding: 22px;
        }

        .ins-modal-search {
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #dce3ec;
            border-radius: 11px;
            padding: 0 15px;
            margin-bottom: 20px;
            background: #f8fafc;
        }

        .ins-modal-search span {
            font-size: 18px;
        }

        .ins-modal-search input {
            width: 100%;
            height: 47px;
            border: 0;
            outline: none;
            background: transparent;
            color: #263445;
        }

        .ins-eleve-table {
            min-width: 850px;
        }

        .ins-eleve-table thead th {
            background: #f1f5f9;
            color: #536477;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 14px 12px;
        }

        .ins-eleve-table tbody td {
            padding: 12px;
            border-bottom: 1px solid #edf0f4;
            font-size: 13px;
        }

        .ins-eleve-row:hover {
            background: #f5f9ff;
        }

        .ins-modal-avatar {
            width: 43px;
            height: 43px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 7px rgba(0, 0, 0, .10);
        }

        .ins-modal-initial {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #dcecff;
            color: #2469a8;
            font-weight: 800;
            font-size: 17px;
        }

        .ins-eleve-modal .modal-footer {
            background: #f8fafc;
            border-top: 1px solid #edf0f4;
            padding: 15px 22px;
        }

        @media(max-width: 600px) {
            .ins-selected-student {
                align-items: flex-start;
            }

            .ins-change-student {
                width: 100%;
            }

            .ins-eleve-modal .modal-body {
                padding: 13px;
            }
        }


        /* ==========================================
                           TABLEAU ÉLÈVES - MENU DE SÉLECTION
                        ========================================== */

        #modalSelectionEleve .ins-eleve-table {
            width: 100%;
            min-width: 850px;
            border-collapse: separate;
            border-spacing: 0 7px;
            margin-bottom: 0;
        }

        #modalSelectionEleve .ins-eleve-table thead th {
            padding: 13px 14px;
            background: #f3f6fb;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            border: none;
            white-space: nowrap;
        }

        #modalSelectionEleve .ins-eleve-row {
            cursor: pointer;
            background: #ffffff;
            outline: 2px solid transparent;
            outline-offset: -2px;
            transition: background .2s ease,
                outline-color .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        #modalSelectionEleve .ins-eleve-row td {
            padding: 13px 14px;
            color: #334155;
            font-size: 13px;
            border-top: 1px solid #edf1f6;
            border-bottom: 1px solid #edf1f6;
            transition: background .2s ease;
        }

        #modalSelectionEleve .ins-eleve-row td:first-child {
            border-left: 1px solid #edf1f6;
            border-radius: 10px 0 0 10px;
        }

        #modalSelectionEleve .ins-eleve-row td:last-child {
            border-right: 1px solid #edf1f6;
            border-radius: 0 10px 10px 0;
        }

        /* Effet au passage du curseur */
        #modalSelectionEleve .ins-eleve-row:hover {
            background: #edf5ff;
            outline-color: #4389d8;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .10);
            transform: translateY(-1px);
        }

        #modalSelectionEleve .ins-eleve-row:hover td {
            background: #edf5ff;
            color: #174d83;
        }

        /* Effet clavier */
        #modalSelectionEleve .ins-eleve-row:focus {
            outline: 2px solid #2874b9;
            background: #edf5ff;
        }

        /* Photos */
        #modalSelectionEleve .ins-modal-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 7px rgba(15, 23, 42, .12);
        }

        #modalSelectionEleve .ins-modal-initial {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1d4ed8;
            font-size: 17px;
            font-weight: 800;
        }

        /* Texte des élèves */
        #modalSelectionEleve .ins-eleve-row strong {
            color: #1e293b;
            font-weight: 800;
        }

        /* Barre de recherche */
        #modalSelectionEleve .ins-modal-search {
            border: 1px solid #dce5f0;
            background: #f8fafc;
            border-radius: 12px;
            transition: border-color .2s, box-shadow .2s;
        }

        #modalSelectionEleve .ins-modal-search:focus-within {
            border-color: #4389d8;
            box-shadow: 0 0 0 3px rgba(67, 137, 216, .12);
        }

        /* Adaptation mobile */
        @media (max-width: 768px) {
            #modalSelectionEleve .ins-eleve-table {
                min-width: 850px;
            }

            #modalSelectionEleve .ins-eleve-row td {
                padding: 10px;
            }
        }
    </style>

    <div class="ins-create">

        {{-- HEADER --}}
        <div class="ins-create-header">

            <div>
                <h2>🎓 Nouvelle inscription</h2>

                <p>
                    Création d'un dossier administratif et affectation scolaire d'un élève.
                </p>
            </div>

            <a href="{{ route('inscriptions.index') }}" class="ins-back-btn">
                ← Retour à la liste
            </a>

        </div>

        {{-- BANNER --}}
        <div class="ins-create-banner">

            <div class="ins-create-banner-icon">
                🎓
            </div>

            <div>
                <h4>Bienvenue dans le formulaire d'inscription</h4>

                <p>
                    Sélectionnez un élève existant et renseignez les informations
                    de son inscription pour l'année scolaire.
                </p>
            </div>

        </div>

        {{-- ANNÉE SCOLAIRE ACTIVE --}}
        <div class="ins-year-card">

            <div class="ins-year-label">

                <div class="ins-year-icon">
                    📅
                </div>

                <div>
                    <small>ANNÉE SCOLAIRE ACTIVE</small>

                    <strong>
                        {{ $anneeScolaire->nom ?? 'Aucune année scolaire active' }}
                    </strong>
                </div>

            </div>

            @if ($anneeScolaire)
                <span class="ins-year-status">
                    ● Année active
                </span>
            @else
                <span class="badge bg-danger">
                    Aucune année active
                </span>
            @endif

        </div>

        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="alert alert-danger ins-validation-alert">

                <strong>⚠️ Vérifiez les informations du formulaire.</strong>

                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{-- FORMULAIRE --}}
        <form action="{{ route('inscriptions.store') }}" method="POST">

            @csrf

            <div class="ins-create-layout">

                {{-- COLONNE PRINCIPALE --}}
                <div class="ins-create-main">

                    {{-- =========================================
                     1. ÉLÈVE
                ========================================== --}}

                    <div class="ins-create-card">

                        <div class="ins-create-card-header">

                            <div class="ins-create-section-icon ins-section-blue">
                                👤
                            </div>

                            <div>
                                <h5>Identification de l'élève</h5>
                                <p>Recherchez et sélectionnez l'élève à inscrire.</p>
                            </div>

                        </div>

                        <div class="ins-create-card-body">

                            {{-- CHAMP CACHÉ POUR LE FORMULAIRE --}}
                            <input type="hidden" name="eleve_id" id="eleve_id" value="{{ old('eleve_id') }}">

                            {{-- ÉLÈVE SÉLECTIONNÉ --}}
                            <div id="eleveSelectionne" class="ins-selected-student">

                                <div class="ins-selected-avatar" id="eleveAvatar">
                                    👨‍🎓
                                </div>

                                <div class="ins-selected-info">
                                    <strong id="eleveNomAffiche">
                                        Aucun élève sélectionné
                                    </strong>

                                    <span id="eleveMatriculeAffiche">
                                        Veuillez choisir un élève dans la liste.
                                    </span>
                                </div>

                                <button type="button" class="ins-change-student" data-bs-toggle="modal"
                                    data-bs-target="#modalSelectionEleve">
                                    👥 Choisir un élève
                                </button>

                            </div>

                            @error('eleve_id')
                                <div class="ins-field-error">{{ $message }}</div>
                            @enderror

                            <div class="ins-student-note mt-3">
                                <span>ℹ️</span>
                                <div>
                                    Cette opération crée une inscription pour un élève existant.
                                    Elle ne crée pas de nouvelle fiche élève et ne modifie pas son matricule.
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- POPUP DE SÉLECTION DES ÉLÈVES --}}
                    <div class="modal fade" id="modalSelectionEleve" tabindex="-1" aria-hidden="true">

                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

                            <div class="modal-content ins-eleve-modal">

                                <div class="modal-header ins-modal-header">

                                    <div>
                                        <h5 class="modal-title">🎓 Sélectionner un élève</h5>
                                        <p>Recherchez l'élève concerné par cette inscription.</p>
                                    </div>

                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>

                                </div>

                                <div class="modal-body">

                                    {{-- RECHERCHE --}}
                                    <div class="ins-modal-search">
                                        <span>🔍</span>
                                        <input type="text" id="rechercheEleveModal"
                                            placeholder="Rechercher par nom, prénom ou matricule...">
                                    </div>

                                    {{-- TABLEAU DES ÉLÈVES --}}
                                    <div class="table-responsive">


                                        <table class="table align-middle ins-eleve-table">
                                            <thead>
                                                <tr>
                                                    <th>Photo</th>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th>Classe</th>
                                                    <th>Sexe</th>
                                                    <th>Numéro</th>
                                                    <th>Matricule</th>
                                                </tr>
                                            </thead>

                                            <tbody id="listeElevesModal">

                                                @foreach ($eleves as $eleve)
                                                    <tr class="ins-eleve-row" role="button" tabindex="0"
                                                        data-id="{{ $eleve->id }}" data-nom="{{ $eleve->nom }}"
                                                        data-prenom="{{ $eleve->prenom }}"
                                                        data-matricule="{{ $eleve->matricule }}"
                                                        data-photo="{{ $eleve->photo ? asset('storage/' . $eleve->photo) : '' }}"
                                                        data-deja-inscrit="{{ in_array($eleve->id, $elevesAvecHistorique) ? 'oui' : 'non' }}"
                                                        data-recherche="{{ strtolower($eleve->nom . ' ' . $eleve->prenom . ' ' . $eleve->matricule . ' ' . ($eleve->classe->nom ?? '')) }}">

                                                        <td>
                                                            @if ($eleve->photo)
                                                                <img src="{{ asset('storage/' . $eleve->photo) }}"
                                                                    class="ins-modal-avatar" alt="Photo de l'élève">
                                                            @else
                                                                <div class="ins-modal-avatar ins-modal-initial">
                                                                    {{ strtoupper(substr($eleve->prenom, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <strong>{{ $eleve->nom }}</strong>
                                                        </td>

                                                        <td>{{ $eleve->prenom }}</td>

                                                        <td>
                                                            <span class="badge bg-primary">
                                                                {{ $eleve->classe->nom ?? '-' }}
                                                            </span>
                                                        </td>

                                                        <td>{{ $eleve->sexe }}</td>

                                                        <td>
                                                            <span class="badge bg-dark">
                                                                N° {{ $eleve->numero_classe ?? '-' }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="badge bg-secondary">
                                                                {{ $eleve->matricule }}
                                                            </span>
                                                        </td>

                                                    </tr>
                                                @endforeach

                                                <tr id="aucunEleveTrouve" style="display:none;">
                                                    <td colspan="7" class="text-center text-muted py-4">
                                                        Aucun élève correspondant à votre recherche.
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <span class="text-muted me-auto">
                                        {{ count($eleves) }} élève(s) disponible(s)
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                     2. AFFECTATION SCOLAIRE
                ========================================== --}}
                    <div class="ins-create-card">

                        <div class="ins-create-card-header">

                            <div class="ins-create-section-icon ins-section-purple">
                                📚
                            </div>

                            <div>
                                <h5>Affectation scolaire</h5>

                                <p>
                                    Définissez la classe et les informations de l'inscription.
                                </p>
                            </div>

                        </div>

                        <div class="ins-create-card-body">

                            <div class="ins-create-grid">

                                {{-- ANNÉE SCOLAIRE --}}
                                <div class="ins-create-field full">

                                    <label>
                                        Année scolaire <span class="ins-required">*</span>
                                    </label>

                                    @if ($anneeScolaire)
                                        <input type="hidden" name="annee_scolaire_id"
                                            value="{{ old('annee_scolaire_id', $anneeScolaire->id) }}">

                                        <input type="text" class="ins-create-input" value="{{ $anneeScolaire->nom }}"
                                            readonly>
                                    @else
                                        <input type="hidden" name="annee_scolaire_id" value="">

                                        <div class="alert alert-warning mb-0">
                                            Vous devez activer une année scolaire
                                            avant de créer une inscription.
                                        </div>
                                    @endif

                                    @error('annee_scolaire_id')
                                        <div class="ins-field-error">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                {{-- CLASSE --}}
                                <div class="ins-create-field">

                                    <label for="classe_id">
                                        Classe attribuée <span class="ins-required">*</span>
                                    </label>

                                    <select name="classe_id" id="classe_id"
                                        class="ins-create-select @error('classe_id') is-invalid @enderror" required>

                                        <option value="">
                                            -- Choisir une classe --
                                        </option>

                                        @foreach ($classes as $classe)
                                            <option value="{{ $classe->id }}"
                                                {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                                {{ $classe->nom }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('classe_id')
                                        <div class="ins-field-error">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                {{-- DATE --}}
                                <div class="ins-create-field">

                                    <label for="date_inscription">
                                        Date d'inscription <span class="ins-required">*</span>
                                    </label>

                                    <input type="date" name="date_inscription" id="date_inscription"
                                        class="ins-create-input @error('date_inscription') is-invalid @enderror"
                                        value="{{ old('date_inscription', date('Y-m-d')) }}" required>

                                    @error('date_inscription')
                                        <div class="ins-field-error">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                {{-- TYPE D'INSCRIPTION AUTOMATIQUE --}}
                                <div class="ins-create-field full">

                                    <label>
                                        Type d'inscription
                                    </label>

                                    <div class="ins-type-options">

                                        <div class="ins-type-option" id="type_inscription_auto">

                                            <div class="ins-type-badge">

                                                <strong id="type_inscription_titre">
                                                    👤 Sélectionnez un élève
                                                </strong>

                                                <span id="type_inscription_description">
                                                    Le type d'inscription sera déterminé automatiquement.
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                    {{-- Champ caché : Laravel déterminera le type côté serveur --}}
                                    <input type="hidden" name="type" value="">

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- =========================================
                     3. FRAIS ET OBSERVATIONS
                ========================================== --}}
                    <div class="ins-create-card">

                        <div class="ins-create-card-header">

                            <div class="ins-create-section-icon ins-section-orange">
                                💰
                            </div>

                            <div>
                                <h5>Informations financières et administratives</h5>

                                <p>
                                    Renseignez les frais et les remarques éventuelles.
                                </p>
                            </div>

                        </div>

                        <div class="ins-create-card-body">

                            <div class="ins-create-grid">

                                {{-- FRAIS --}}
                                <div class="ins-create-field full">

                                    <label for="frais_inscription">
                                        Frais d'inscription (Ar)
                                    </label>

                                    <input type="number" name="frais_inscription" id="frais_inscription"
                                        class="ins-create-input @error('frais_inscription') is-invalid @enderror"
                                        value="{{ old('frais_inscription', 0) }}" min="0" step="0.01"
                                        placeholder="0">

                                    <div class="ins-field-help">
                                        Montant des frais d'inscription. Laissez 0 si aucun frais n'est demandé.
                                    </div>

                                    @error('frais_inscription')
                                        <div class="ins-field-error">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                {{-- OBSERVATIONS --}}
                                <div class="ins-create-field full">

                                    <label for="observations">
                                        Observations administratives
                                    </label>

                                    <textarea name="observations" id="observations"
                                        class="ins-create-textarea @error('observations') is-invalid @enderror" rows="4"
                                        placeholder="Informations complémentaires, remarques administratives...">{{ old('observations') }}</textarea>

                                    @error('observations')
                                        <div class="ins-field-error">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- COLONNE RÉCAPITULATIF --}}
                <div class="ins-create-summary">

                    <div class="ins-summary-card">

                        <div class="ins-summary-header">

                            <h5>📋 Récapitulatif</h5>

                            <p>Résumé du dossier à enregistrer.</p>

                        </div>

                        <div class="ins-summary-body">

                            <div class="ins-summary-row">
                                <span>Année scolaire</span>

                                <strong>
                                    {{ $anneeScolaire->nom ?? 'Non définie' }}
                                </strong>
                            </div>

                            <div class="ins-summary-row">
                                <span>Type de dossier</span>

                                <strong id="ins_summary_type">
                                    Nouvelle inscription
                                </strong>
                            </div>

                            <div class="ins-summary-row">
                                <span>Date</span>

                                <strong id="ins_summary_date">
                                    {{ date('d/m/Y') }}
                                </strong>
                            </div>

                            <div class="ins-summary-row">
                                <span>Classe choisie</span>

                                <strong id="ins_summary_classe">
                                    Non sélectionnée
                                </strong>
                            </div>

                            <hr class="ins-summary-divider">

                            <div class="ins-summary-total">
                                <span>Frais d'inscription</span>

                                <strong id="ins_summary_frais">
                                    0 Ar
                                </strong>
                            </div>

                            {{-- ACTIONS --}}
                            <div class="ins-create-actions">

                                <button type="submit" class="ins-submit-btn" {{ !$anneeScolaire ? 'disabled' : '' }}>
                                    ✓ Enregistrer l'inscription
                                </button>

                                <a href="{{ route('inscriptions.index') }}" class="ins-cancel-btn">
                                    Annuler
                                </a>

                            </div>

                        </div>

                    </div>

                    {{-- INFORMATION --}}
                    <div class="ins-student-note mt-3">

                        <span>🔐</span>

                        <div>
                            Le dossier sera enregistré avec le statut
                            <strong>En attente</strong>.
                            Il devra être validé ultérieurement.
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

    {{-- =========================================================
     RÉCAPITULATIF DYNAMIQUE
========================================================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ==========================================
            // 1. ÉLÉMENTS DU FORMULAIRE ET DU RÉSUMÉ
            // ==========================================

            const classeSelect = document.getElementById('classe_id');
            const dateInput = document.getElementById('date_inscription');
            const fraisInput = document.getElementById('frais_inscription');

            const summaryClasse = document.getElementById('ins_summary_classe');
            const summaryDate = document.getElementById('ins_summary_date');
            const summaryFrais = document.getElementById('ins_summary_frais');
            const summaryType = document.getElementById('ins_summary_type');

            // ==========================================
            // 2. ÉLÉMENTS DE SÉLECTION DE L'ÉLÈVE
            // ==========================================

            const modal = document.getElementById('modalSelectionEleve');
            const recherche = document.getElementById('rechercheEleveModal');
            const lignes = document.querySelectorAll('.ins-eleve-row');
            const aucunResultat = document.getElementById('aucunEleveTrouve');

            const champEleve = document.getElementById('eleve_id');
            const avatar = document.getElementById('eleveAvatar');
            const nomAffiche = document.getElementById('eleveNomAffiche');
            const matriculeAffiche = document.getElementById('eleveMatriculeAffiche');

            const typeTitre = document.getElementById('type_inscription_titre');
            const typeDescription = document.getElementById('type_inscription_description');

            // ==========================================
            // 3. RÉSUMÉ DE LA CLASSE
            // ==========================================

            function updateClasse() {

                const option = classeSelect.options[classeSelect.selectedIndex];

                summaryClasse.textContent =
                    option && option.value !== '' ?
                    option.text.trim() :
                    'Non sélectionnée';
            }

            // ==========================================
            // 4. RÉSUMÉ DE LA DATE
            // ==========================================

            function updateDate() {

                if (!dateInput.value) {
                    summaryDate.textContent = 'Non définie';
                    return;
                }

                const parts = dateInput.value.split('-');

                summaryDate.textContent =
                    parts.length === 3 ?
                    parts[2] + '/' + parts[1] + '/' + parts[0] :
                    dateInput.value;
            }

            // ==========================================
            // 5. RÉSUMÉ DES FRAIS
            // ==========================================

            function updateFrais() {

                const montant = parseFloat(fraisInput.value) || 0;

                summaryFrais.textContent =
                    new Intl.NumberFormat('fr-FR', {
                        maximumFractionDigits: 2
                    }).format(montant) + ' Ar';
            }

            // ==========================================
            // 6. TYPE D'INSCRIPTION AUTOMATIQUE
            // ==========================================

            function actualiserTypeInscription(dejaInscrit) {

                if (dejaInscrit) {

                    if (typeTitre) {
                        typeTitre.textContent = '🔄 Réinscription';
                    }

                    if (typeDescription) {
                        typeDescription.textContent =
                            'Cet élève possède déjà un historique dans l’établissement.';
                    }

                    if (summaryType) {
                        summaryType.textContent = 'Réinscription';
                    }

                } else {

                    if (typeTitre) {
                        typeTitre.textContent = '🆕 Nouvelle inscription';
                    }

                    if (typeDescription) {
                        typeDescription.textContent =
                            'Cet élève sera inscrit pour la première fois dans l’établissement.';
                    }

                    if (summaryType) {
                        summaryType.textContent = 'Nouvelle inscription';
                    }

                }
            }

            // ==========================================
            // 7. RECHERCHE DANS LA POPUP
            // ==========================================

            if (recherche) {

                recherche.addEventListener('input', function() {

                    const terme = this.value.toLowerCase().trim();

                    let nombreVisible = 0;

                    lignes.forEach(function(ligne) {

                        const contenu = ligne.dataset.recherche || '';

                        const correspond = contenu.includes(terme);

                        ligne.style.display = correspond ? '' : 'none';

                        if (correspond) {
                            nombreVisible++;
                        }

                    });

                    if (aucunResultat) {
                        aucunResultat.style.display =
                            nombreVisible === 0 ? '' : 'none';
                    }

                });

            }

            // ==========================================
            // 8. SÉLECTION D'UN ÉLÈVE
            // ==========================================



            function fermerPopupEleve() {
                const modalElement = document.getElementById('modalSelectionEleve');

                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                modalElement.setAttribute('aria-hidden', 'true');
                modalElement.removeAttribute('aria-modal');

                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');

                document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                    backdrop.remove();
                });
            }

            function selectionnerEleve(ligne) {

                const id = ligne.dataset.id;
                const nom = ligne.dataset.nom;
                const prenom = ligne.dataset.prenom;
                const matricule = ligne.dataset.matricule;
                const photo = ligne.dataset.photo;
                const dejaInscrit = ligne.dataset.dejaInscrit;

                // Enregistrer l'élève sélectionné
                champEleve.value = id;

                nomAffiche.textContent = nom + ' ' + prenom;
                matriculeAffiche.textContent = 'Matricule : ' + matricule;

                // Actualiser la photo ou l'avatar
                avatar.innerHTML = '';

                if (photo) {
                    const image = document.createElement('img');
                    image.src = photo;
                    image.alt = 'Photo de ' + prenom;
                    avatar.appendChild(image);
                } else {
                    avatar.textContent = prenom.charAt(0).toUpperCase();
                }

                // Actualiser le type d'inscription
                actualiserTypeInscription(dejaInscrit === 'oui');
                
                // Fermer le popup sans dépendre de Bootstrap
                fermerPopupEleve();
            }




            // Sélection au clic sur toute la ligne
            lignes.forEach(function(ligne) {
                ligne.addEventListener('click', function() {
                    selectionnerEleve(this);
                });

                // Sélection également avec Entrée ou Espace
                ligne.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        selectionnerEleve(this);
                    }
                });
            });


            // ==========================================
            // 9. RÉINITIALISER LA RECHERCHE À L'OUVERTURE
            // ==========================================

            if (modal) {

                modal.addEventListener('show.bs.modal', function() {

                    recherche.value = '';

                    lignes.forEach(function(ligne) {
                        ligne.style.display = '';
                    });

                    if (aucunResultat) {
                        aucunResultat.style.display = 'none';
                    }

                    setTimeout(function() {
                        recherche.focus();
                    }, 300);

                });

            }

            // ==========================================
            // 10. RESTAURER L'ÉLÈVE APRÈS UNE ERREUR
            // ==========================================


            const ancienEleveId = champEleve.value;

            if (ancienEleveId) {
                const ligneExistante = Array.from(lignes).find(function(ligne) {
                    return ligne.dataset.id === ancienEleveId;
                });

                if (ligneExistante) {
                    selectionnerEleve(ligneExistante);
                }
            }


            // ==========================================
            // 11. ÉVÉNEMENTS DU RÉSUMÉ
            // ==========================================

            classeSelect.addEventListener('change', updateClasse);
            dateInput.addEventListener('change', updateDate);
            fraisInput.addEventListener('input', updateFrais);

            // Initialisation
            updateClasse();
            updateDate();
            updateFrais();

        });
    </script>


@endsection
