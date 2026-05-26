@extends('layouts.app')

@section('content')
    <h3>

        📄 Bulletin :

        {{ $eleve->nom }}

        {{ $eleve->prenom }}

    </h3>

    <form id="form-bulletin">

        @csrf

        <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">

        @foreach ($periodes as $periode)
            <div>

                <label>

                    <input type="checkbox" name="periodes[]" value="{{ $periode->id }}">

                    {{ $periode->nom }}

                </label>

            </div>
        @endforeach

        <br>

        <button class="btn btn-success">

            Générer

        </button>

    </form>

    <div id="popup"></div>

    <script>
        document

            .getElementById(

                'form-bulletin'

            )

            .addEventListener(

                'submit',

                function(e) {

                    e.preventDefault();

                    fetch(

                            '{{ route('bulletin.verifier') }}',

                            {

                                method: 'POST',

                                body: new FormData(
                                    this
                                ),

                                headers: {

                                    'X-CSRF-TOKEN':

                                        document

                                        .querySelector(

                                            'meta[name="csrf-token"]'

                                        )

                                        .content

                                }

                            }

                        )

                        .then(
                            r => r.json()
                        )

                        .then(data => {

                            if (

                                !data.success

                            ) {

                                document

                                    .getElementById(
                                        'popup'
                                    )

                                    .innerHTML =

                                    `

<div class="alert alert-danger">

Période non enregistrée

<br><br>

<button

onclick="location.reload()"

class="btn btn-secondary"

>

OK

</button>

<a

href="/bulletin/saisie"

class="btn btn-danger"

>

Enregistrer période

</a>

</div>

`;

                            } else {

                                let fd =

                                    new FormData(
                                        this
                                    );

                                fetch(

                                        '{{ route('bulletin.afficher') }}',

                                        {

                                            method: 'POST',

                                            body: fd,

                                            headers: {

                                                'X-CSRF-TOKEN':

                                                    document

                                                    .querySelector(

                                                        'meta[name="csrf-token"]'

                                                    )

                                                    .content

                                            }

                                        }

                                    )

                                    .then(
                                        r => r.text()
                                    )

                                    .then(html => {

                                        document.body.innerHTML =

                                            html;

                                    });

                            }

                        });

                });
    </script>
@endsection
