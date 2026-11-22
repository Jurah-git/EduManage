@extends('layouts.app')

@section('content')
    @php
        $classesFiltre = collect($eleves)->map(fn($e) => $e->classe->nom ?? null)->filter()->unique()->sort()->values();
    @endphp

    <style>
        .notes-page {
            background-color: #f8fafc;
            min-height: calc(100vh - 60px);
        }

        .card-modern {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
            background: #ffffff;
        }

        .avatar-initials {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .table-modern thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 16px;
        }

        .table-modern tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }

        .table-modern tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge-classe {
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.82rem;
        }

        .filter-control {
            border-radius: 8px;
            font-size: 0.85rem;
        }

        .btn-action {
            border-radius: 6px;
            font-weight: 500;
            padding: 6px 14px;
            font-size: 0.84rem;
            transition: transform 0.1s ease;
        }

        .btn-action:active {
            transform: scale(0.97);
        }

        /* =====================================================
               POPUP ENREGISTREMENT
            ====================================================== */
        .popup-save {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-box {
            background: white;
            padding: 30px;
            border-radius: 14px;
            min-width: 380px;
            max-width: 90%;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
        }

        .popup-erreur {
            border: 2px solid red !important;
        }

        .erreur-periode {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>

    <div class="notes-page py-4">
        <div class="container-fluid px-4">

            {{-- EN-TÊTE DE PAGE --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        📝 Saisie des notes
                    </h3>
                    <p class="text-muted small mb-0">
                        Sélectionnez un élève pour saisir ou consulter ses notes journalières et de composition.
                    </p>
                </div>
                <div>
                    <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                        Affichés : <strong id="compteurEleves">{{ count($eleves) }}</strong> / {{ count($eleves) }} élève(s)
                    </span>
                </div>
            </div>

            <div id="liste-eleves">
                <div class="card card-modern">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                            <span class="fw-bold text-dark">
                                🎓 Liste des élèves
                            </span>

                            {{-- RECHERCHE, FILTRE ET TRI --}}
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <input type="text" id="searchEleve"
                                    class="form-control form-control-sm filter-control px-3" style="min-width: 210px;"
                                    placeholder="🔍 Nom, prénom...">

                                <select id="filterClasse" class="form-select form-select-sm filter-control"
                                    style="width: auto;">
                                    <option value="">Toutes les classes</option>
                                    @foreach ($classesFiltre as $nomClasse)
                                        <option value="{{ mb_strtolower($nomClasse) }}">{{ $nomClasse }}</option>
                                    @endforeach
                                    <option value="__non_affecte__">Non affecté</option>
                                </select>

                                <select id="sortEleves" class="form-select form-select-sm filter-control"
                                    style="width: auto;">
                                    <option value="az">Ordre : A → Z</option>
                                    <option value="za">Ordre : Z → A</option>
                                    <option value="classe_az">Classe : A → Z</option>
                                </select>

                                <button type="button" id="btnResetFiltres"
                                    class="btn btn-light btn-sm border filter-control text-secondary"
                                    title="Réinitialiser les filtres">
                                    ↺ Réinitialiser
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-modern text-center mb-0" id="tableEleves">
                            <thead>
                                <tr>
                                    <th class="text-start">Nom</th>
                                    <th>Classe</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($eleves as $eleve)
                                    @php
                                        $initiales = strtoupper(
                                            mb_substr($eleve->nom, 0, 1) . mb_substr($eleve->prenom, 0, 1),
                                        );
                                        $nomComplet = trim($eleve->nom . ' ' . $eleve->prenom);
                                        $classeNom = $eleve->classe->nom ?? 'zzz_non_affecte';
                                        $classeSlug = $eleve->classe
                                            ? mb_strtolower($eleve->classe->nom)
                                            : '__non_affecte__';
                                    @endphp

                                    <tr class="eleve-row" data-nom="{{ mb_strtolower($nomComplet) }}"
                                        data-classe="{{ $classeSlug }}" data-classe-tri="{{ mb_strtolower($classeNom) }}">
                                        <td class="text-start">
                                            <div class="d-flex align-items-center justify-content-start gap-3">
                                                <div class="avatar-initials">
                                                    {{ $initiales }}
                                                </div>
                                                <div class="fw-semibold text-dark">
                                                    {{ $eleve->nom }}
                                                    {{ $eleve->prenom }}
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @if ($eleve->classe)
                                                <span class="badge-classe">{{ $eleve->classe->nom }}</span>
                                            @else
                                                <span class="badge bg-light text-secondary border">Non affecté</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm btn-action"
                                                onclick="loadEleve({{ $eleve->id }})">
                                                ✏️ Saisir
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            Aucun élève trouvé.
                                        </td>
                                    </tr>
                                @endforelse

                                <tr id="aucunResultatFiltre" style="display:none;">
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        Aucun élève ne correspond aux filtres sélectionnés.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- =====================================================
                         ZONE FORMULAIRE ELEVE
                    ====================================================== -->
            <div id="zone"></div>

        </div>
    </div>

    <!-- =====================================================
                 POPUP ENREGISTREMENT
            ====================================================== -->
    <div id="popup-save" class="popup-save">
        <div class="popup-box">
            <h5>
                ✅ Enregistrement réussi
            </h5>

            <p id="popup-text"></p>

            <button onclick="closePopup()" class="btn btn-success">
                OK
            </button>
        </div>
    </div>

    <script>
        // =====================================================
        // FILTRAGE ET TRI DE LA LISTE DES ELEVES
        // =====================================================

        function appliquerFiltresEtTri() {
            const tbody = document.querySelector('#tableEleves tbody');
            if (!tbody) return;

            const rows = Array.from(tbody.querySelectorAll('tr.eleve-row'));
            const terme = (document.getElementById('searchEleve')?.value || '').toLowerCase().trim();
            const classeChoisie = document.getElementById('filterClasse')?.value || '';
            const ordre = document.getElementById('sortEleves')?.value || 'az';

            rows.sort((a, b) => {
                const nomA = a.dataset.nom || '';
                const nomB = b.dataset.nom || '';
                const classeA = a.dataset.classeTri || '';
                const classeB = b.dataset.classeTri || '';

                if (ordre === 'az') {
                    return nomA.localeCompare(nomB, 'fr', {
                        sensitivity: 'base'
                    });
                }
                if (ordre === 'za') {
                    return nomB.localeCompare(nomA, 'fr', {
                        sensitivity: 'base'
                    });
                }
                if (ordre === 'classe_az') {
                    if (classeA === classeB) return nomA.localeCompare(nomB, 'fr', {
                        sensitivity: 'base'
                    });
                    return classeA.localeCompare(classeB, 'fr', {
                        sensitivity: 'base'
                    });
                }
                return 0;
            });

            let visibles = 0;
            const emptyRow = document.getElementById('aucunResultatFiltre');

            rows.forEach(row => {
                tbody.appendChild(row);

                const nom = row.dataset.nom || '';
                const classe = row.dataset.classe || '';

                const matchNom = !terme || nom.includes(terme) || classe.includes(terme);
                const matchClasse = !classeChoisie || classe === classeChoisie;

                const afficher = matchNom && matchClasse;
                row.style.display = afficher ? '' : 'none';
                if (afficher) visibles++;
            });

            if (emptyRow) {
                emptyRow.style.display = visibles === 0 ? '' : 'none';
            }

            const compteur = document.getElementById('compteurEleves');
            if (compteur) {
                compteur.textContent = visibles;
            }
        }

        document.getElementById('searchEleve')?.addEventListener('input', appliquerFiltresEtTri);
        document.getElementById('filterClasse')?.addEventListener('change', appliquerFiltresEtTri);
        document.getElementById('sortEleves')?.addEventListener('change', appliquerFiltresEtTri);

        document.getElementById('btnResetFiltres')?.addEventListener('click', function() {
            document.getElementById('searchEleve').value = '';
            document.getElementById('filterClasse').value = '';
            document.getElementById('sortEleves').value = 'az';
            appliquerFiltresEtTri();
        });

        // Appliquer le tri A -> Z au chargement
        appliquerFiltresEtTri();

        // =====================================================
        // CHARGER UN ELEVE
        // =====================================================

        function loadEleve(id) {

            document
                .getElementById('liste-eleves')
                .style.display = 'none';


            fetch('/bulletin/eleve/' + id)

                .then(r => r.text())

                .then(html => {

                    document
                        .getElementById('zone')
                        .innerHTML = html;


                    // IMPORTANT :
                    // Le partial notes_form.blade.php
                    // vient d'être injecté par AJAX.
                    //
                    // On initialise donc les événements
                    // APRES innerHTML.

                    initChargementNotes();

                    initNotes();

                    initSaveForms();


                    calculTable('note-journalier');

                    calculTable('note-composition');

                })

                .catch(error => {

                    console.error(error);

                    alert(
                        'Erreur lors du chargement de l’élève.'
                    );

                });

        }


        // =====================================================
        // INITIALISER LE CHARGEMENT DES NOTES
        // =====================================================

        function initChargementNotes() {

            const zoneNotes =
                document.getElementById(
                    'notes-existantes'
                );


            if (!zoneNotes) {

                console.log(
                    'Données des notes introuvables.'
                );

                return;

            }


            let notes = {};

            try {

                notes = JSON.parse(
                    zoneNotes.dataset.notes || '{}'
                );

            } catch (error) {

                console.error(
                    'Erreur lecture des notes :',
                    error
                );

                return;

            }


            // =================================================
            // PERIODE JOURNALIERE
            // =================================================

            const selectJournalier =
                document.querySelector(
                    '.periode-select-journalier'
                );


            if (selectJournalier) {

                selectJournalier.addEventListener(
                    'change',
                    function() {

                        const periodeId =
                            this.value;


                        const hidden =
                            document.querySelector(
                                '.periode-hidden-journalier'
                            );


                        if (hidden) {

                            hidden.value =
                                periodeId;

                        }


                        chargerNotesParPeriode(
                            notes,
                            periodeId,
                            'journalier'
                        );

                    }
                );

            }


            // =================================================
            // PERIODE COMPOSITION
            // =================================================

            const selectComposition =
                document.querySelector(
                    '.periode-select-composition'
                );


            if (selectComposition) {

                selectComposition.addEventListener(
                    'change',
                    function() {

                        const periodeId =
                            this.value;


                        const hidden =
                            document.querySelector(
                                '.periode-hidden-composition'
                            );


                        if (hidden) {

                            hidden.value =
                                periodeId;

                        }


                        chargerNotesParPeriode(
                            notes,
                            periodeId,
                            'composition'
                        );

                    }
                );

            }

        }


        // =====================================================
        // CHARGER NOTES D'UNE PERIODE
        // =====================================================

        function chargerNotesParPeriode(
            notes,
            periodeId,
            type
        ) {

            const classeInput =
                type === 'journalier' ?
                '.note-journalier' :
                '.note-composition';


            const inputs =
                document.querySelectorAll(
                    classeInput
                );


            // =================================================
            // AUCUNE PERIODE
            // =================================================

            if (!periodeId) {

                viderNotes(type);

                calculTable(
                    type === 'journalier' ?
                    'note-journalier' :
                    'note-composition'
                );

                return;

            }


            // =================================================
            // NOTES DE LA PERIODE
            // =================================================

            const notesPeriode =
                notes[periodeId];


            if (!notesPeriode) {

                viderNotes(type);

                calculTable(
                    type === 'journalier' ?
                    'note-journalier' :
                    'note-composition'
                );

                return;

            }


            // =================================================
            // NOTES DU TYPE
            // =================================================

            const notesType =
                notesPeriode[type];


            if (!notesType) {

                viderNotes(type);

                calculTable(
                    type === 'journalier' ?
                    'note-journalier' :
                    'note-composition'
                );

                return;

            }


            // =================================================
            // REMPLIR LES INPUTS
            // =================================================

            inputs.forEach(function(input) {

                const matiereId =
                    input.dataset.matiere;


                const note =
                    notesType[matiereId];


                const row =
                    input.closest('tr');


                if (!row) {

                    return;

                }


                const coef =
                    row.querySelector(
                        '.coef'
                    );


                const base =
                    row.querySelector(
                        'input[name*="[base]"]'
                    );


                if (note) {

                    // NOTE

                    input.value =
                        note.valeur ?? '';


                    // COEFFICIENT

                    if (coef) {

                        coef.value =
                            note.coef ?? coef.value;

                    }


                    // BASE

                    if (base) {

                        base.value =
                            note.base ?? 20;

                    }

                } else {

                    // Aucune note pour cette matière
                    // dans cette période.

                    input.value = '';


                    if (base) {

                        base.value = 20;

                    }

                }

            });


            // =================================================
            // RECALCUL IMMEDIAT
            // =================================================

            calculTable(
                type === 'journalier' ?
                'note-journalier' :
                'note-composition'
            );

        }


        // =====================================================
        // VIDER LES NOTES
        // =====================================================

        function viderNotes(type) {

            const classeInput =
                type === 'journalier' ?
                '.note-journalier' :
                '.note-composition';


            document
                .querySelectorAll(classeInput)
                .forEach(function(input) {

                    input.value = '';


                    const row =
                        input.closest('tr');


                    if (!row) {

                        return;

                    }


                    const base =
                        row.querySelector(
                            'input[name*="[base]"]'
                        );


                    if (base) {

                        base.value = 20;

                    }

                });

        }


        // =====================================================
        // POPUP
        // =====================================================

        function closePopup() {

            document
                .getElementById('popup-save')
                .style.display = 'none';

        }


        function showPopup(txt) {

            document
                .getElementById('popup-text')
                .innerHTML = txt;


            document
                .getElementById('popup-save')
                .style.display = 'flex';

        }


        // =====================================================
        // APPRECIATION
        // =====================================================

        function appreciation(noteReelle) {

            if (noteReelle < 5)

                return {
                    texte: "Très insuffisant",
                    couleur: "#8B0000"
                };


            if (
                noteReelle >= 5 &&
                noteReelle < 10
            )

                return {
                    texte: "Insuffisant",
                    couleur: "red"
                };


            if (
                noteReelle >= 10 &&
                noteReelle < 12
            )

                return {
                    texte: "Passable",
                    couleur: "orange"
                };


            if (
                noteReelle >= 12 &&
                noteReelle < 14
            )

                return {
                    texte: "Assez bien",
                    couleur: "#c59d00"
                };


            if (
                noteReelle >= 14 &&
                noteReelle < 17
            )

                return {
                    texte: "Bien",
                    couleur: "green"
                };


            if (
                noteReelle >= 17 &&
                noteReelle <= 20
            )

                return {
                    texte: "Très bien",
                    couleur: "#0066cc"
                };


            return {
                texte: "Erreur",
                couleur: "black"
            };

        }


        // =====================================================
        // CALCUL TABLE
        // =====================================================

        function calculTable(type) {

            let notes =
                document.querySelectorAll(
                    '.' + type
                );


            let total = 0;

            let totalCoef = 0;


            notes.forEach(input => {

                let row =
                    input.closest('tr');


                let note =
                    parseFloat(
                        input.value
                    ) || 0;


                let coefInput =
                    row.querySelector(
                        '.coef'
                    );


                let coef =
                    coefInput ?
                    parseFloat(
                        coefInput.value
                    ) || 0 :
                    0;


                total += note;

                totalCoef += coef;


                let noteReelle = 0;


                if (coef > 0)

                    noteReelle =
                    note / coef;


                let appr =
                    row.querySelector(
                        '.appr'
                    );


                if (appr) {

                    let a =
                        appreciation(
                            noteReelle
                        );


                    appr.innerHTML =
                        a.texte;


                    appr.style.color =
                        a.couleur;

                }

            });


            let moyenne = 0;


            if (totalCoef > 0)

                moyenne =
                total / totalCoef;


            let suffixe =

                type === 'note-journalier'

                ?
                'journalier'

                :
                'composition';


            const totalElement =
                document.getElementById(
                    'total-' + suffixe
                );


            const coefElement =
                document.getElementById(
                    'coef-' + suffixe
                );


            const moyenneElement =
                document.getElementById(
                    'moyenne-' + suffixe
                );


            if (totalElement)

                totalElement.innerHTML =
                total.toFixed(2);


            if (coefElement)

                coefElement.innerHTML =
                totalCoef.toFixed(2);


            if (moyenneElement)

                moyenneElement.innerHTML =
                moyenne.toFixed(2);

        }


        // =====================================================
        // INITIALISER LES INPUTS
        // =====================================================

        function initNotes() {

            document
                .querySelectorAll(
                    '.note-journalier, .note-composition, .coef'
                )

                .forEach(el => {

                    el.addEventListener(
                        'input',
                        function() {

                            calculTable(
                                'note-journalier'
                            );

                            calculTable(
                                'note-composition'
                            );

                        }
                    );

                });


            calculTable(
                'note-journalier'
            );


            calculTable(
                'note-composition'
            );

        }


        // =====================================================
        // ENREGISTRER LES FORMULAIRES
        // =====================================================

        function initSaveForms() {

            let forms =
                document.querySelectorAll(
                    '#form-journalier, #form-composition'
                );


            forms.forEach(form => {

                form.addEventListener(
                    'submit',
                    function(e) {

                        e.preventDefault();


                        let select =
                            form.querySelector(
                                'select'
                            );


                        let periode =
                            form.querySelector(
                                'input[name="periode_id"]'
                            );


                        document
                            .querySelectorAll(
                                '.erreur-periode'
                            )
                            .forEach(
                                x => x.remove()
                            );


                        select.classList.remove(
                            'popup-erreur'
                        );


                        if (!select.value) {

                            select.classList.add(
                                'popup-erreur'
                            );


                            let div =
                                document.createElement(
                                    'div'
                                );


                            div.className =
                                'erreur-periode';


                            div.innerHTML =
                                'Choisir une période';


                            select.after(div);


                            return;

                        }


                        periode.value =
                            select.value;


                        let fd =
                            new FormData(
                                form
                            );


                        fetch(
                                form.action, {
                                    method: 'POST',

                                    body: fd,

                                    headers: {

                                        'X-CSRF-TOKEN':

                                            document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            .content,

                                        'Accept': 'application/json'

                                    }

                                }
                            )

                            .then(
                                r => {

                                    if (!r.ok) {

                                        throw new Error(
                                            'Erreur HTTP ' +
                                            r.status
                                        );

                                    }

                                    return r.json();

                                }
                            )

                            .then(data => {

                                if (!data.success) {

                                    throw new Error(
                                        data.message ||
                                        'Erreur enregistrement'
                                    );

                                }


                                let nom =
                                    form.dataset.nom;


                                let prenom =
                                    form.dataset.prenom;


                                showPopup(

                                    'Les notes de <b>' +
                                    nom +
                                    ' ' +
                                    prenom +
                                    '</b> ont été enregistrées'

                                );

                            })

                            .catch(err => {

                                console.error(err);

                                alert(
                                    'Erreur enregistrement'
                                );

                            });

                    }
                );

            });

        }


        // =====================================================
        // RETOUR LISTE
        // =====================================================

        function retourListe() {

            document
                .getElementById(
                    'liste-eleves'
                )
                .style.display = 'block';


            document
                .getElementById(
                    'zone'
                )
                .innerHTML = '';

        }
    </script>
@endsection
