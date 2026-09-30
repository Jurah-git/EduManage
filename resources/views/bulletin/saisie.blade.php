```blade
@extends('layouts.app')

@section('content')
    <h3>📝 Saisie des notes</h3>

    <div id="liste-eleves">

        <table class="table table-bordered text-center">

            <thead>

                <tr>
                    <th>Nom</th>
                    <th>Classe</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                @foreach ($eleves as $eleve)
                    <tr>

                        <td>
                            {{ $eleve->nom }}
                            {{ $eleve->prenom }}
                        </td>

                        <td>
                            {{ $eleve->classe->nom }}
                        </td>

                        <td>

                            <button class="btn btn-primary" onclick="loadEleve({{ $eleve->id }})">

                                Saisir

                            </button>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>


    <!-- =====================================================
             ZONE FORMULAIRE ELEVE
        ====================================================== -->

    <div id="zone"></div>


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


    <style>
        .popup-save {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, .4);

            display: none;

            justify-content: center;

            align-items: center;

            z-index: 9999;

        }


        .popup-box {

            background: white;

            padding: 30px;

            border-radius: 12px;

            min-width: 400px;

            text-align: center;

            box-shadow: 0 0 20px rgba(0, 0, 0, .2);

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


    <script>
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
```
