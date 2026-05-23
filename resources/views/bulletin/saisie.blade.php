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

                            <button class="btn btn-primary"
                                onclick="loadEleve(

                        {{ $eleve->id }}

                        )">

                                Saisir

                            </button>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    <div id="zone"></div>

    <div id="popup-save" class="popup-save">

        <div class="popup-box">

            <h5>

                ✅ Enregistrement réussi

            </h5>

            <p id="popup-text">

            </p>

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
        function loadEleve(id) {

            document
                .getElementById(
                    'liste-eleves'
                )

                .style.display = 'none';

            fetch(

                    '/bulletin/eleve/' + id

                )

                .then(
                    r => r.text()
                )

                .then(html => {

                    document
                        .getElementById(
                            'zone'
                        )

                        .innerHTML = html;

                    initNotes();

                    initSaveForms();

                    calculTable(
                        'note-journalier'
                    );

                    calculTable(
                        'note-composition'
                    );

                });

        }

        function closePopup() {

            document
                .getElementById(
                    'popup-save'
                )
                .style.display = 'none';

        }

        function showPopup(txt) {

            document
                .getElementById(
                    'popup-text'
                )
                .innerHTML = txt;

            document
                .getElementById(
                    'popup-save'
                )
                .style.display = 'flex';

        }

        function appreciation(noteReelle) {

            if (noteReelle < 5)
                return {
                    texte: "Très insuffisant",
                    couleur: "#8B0000"
                };

            if (noteReelle >= 5 && noteReelle < 10)
                return {
                    texte: "Insuffisant",
                    couleur: "red"
                };

            if (noteReelle >= 10 && noteReelle < 12)
                return {
                    texte: "Passable",
                    couleur: "orange"
                };

            if (noteReelle >= 12 && noteReelle < 14)
                return {
                    texte: "Assez bien",
                    couleur: "#c59d00"
                };

            if (noteReelle >= 14 && noteReelle < 17)
                return {
                    texte: "Bien",
                    couleur: "green"
                };

            if (noteReelle >= 17 && noteReelle <= 20)
                return {
                    texte: "Très bien",
                    couleur: "#0066cc"
                };

            return {
                texte: "Erreur",
                couleur: "black"
            };

        }

        function calculTable(type) {

            let notes =
                document.querySelectorAll(
                    '.' + type
                );

            let total = 0;

            let totalCoef = 0;

            notes.forEach(input => {

                let row =
                    input.closest(
                        'tr'
                    );

                let note =
                    parseFloat(
                        input.value
                    ) || 0;

                let coef =
                    parseFloat(

                        row
                        .querySelector(
                            '.coef'
                        )
                        .value

                    ) || 0;

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

                type ==
                'note-journalier'

                ?

                'journalier'

                :

                'composition';

            document
                .getElementById(
                    'total-' + suffixe
                )
                .innerHTML =
                total.toFixed(2);

            document
                .getElementById(
                    'coef-' + suffixe
                )
                .innerHTML =
                totalCoef;

            document
                .getElementById(
                    'moyenne-' + suffixe
                )
                .innerHTML =
                moyenne.toFixed(2);

        }

        function initNotes() {

            document

                .querySelectorAll(

                    '.note-journalier,.note-composition,.coef'

                )

                .forEach(el => {

                    el.addEventListener(

                        'input',

                        () => {

                            calculTable(
                                'note-journalier'
                            );

                            calculTable(
                                'note-composition'
                            );

                        }

                    );

                });

            // CALCUL IMMEDIAT AU CHARGEMENT

            calculTable(
                'note-journalier'
            );

            calculTable(
                'note-composition'
            );

        }

        function initSaveForms() {

            let forms =
                document.querySelectorAll(
                    '#form-journalier,#form-composition'
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

                                form.action,

                                {

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
                                r => r.json()
                            )

                            .then(data => {

                                let nom =
                                    form.dataset.nom;

                                let prenom =
                                    form.dataset.prenom;

                                showPopup(

                                    'Les notes de <b>'

                                    +

                                    nom

                                    +

                                    ' '

                                    +

                                    prenom

                                    +

                                    '</b> ont été enregistrées'

                                );

                            })

                            .catch(err => {

                                console.log(err);

                                alert(
                                    'Erreur enregistrement'
                                );

                            });

                    });

            });

        }

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
