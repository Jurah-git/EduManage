@extends('layouts.app')

@section('content')

<h3>
    📄 Bulletin :
    {{ $eleve->nom }}
    {{ $eleve->prenom }}
</h3>

<form id="form-bulletin"
      action="{{ route('bulletin.afficher') }}"
      method="POST">

    @csrf

    <input
        type="hidden"
        name="eleve_id"
        value="{{ $eleve->id }}"
    >

    @foreach($periodes as $periode)

        <div class="mb-2">

            <label>

                <input
                    type="checkbox"
                    name="periodes[]"
                    value="{{ $periode->id }}"
                >

                {{ $periode->nom }}

            </label>

        </div>

    @endforeach

    <br>

    <button type="submit" class="btn btn-success">

        Générer

    </button>

</form>

<div id="popup" class="mt-3"></div>

<script>

document
.getElementById('form-bulletin')
.addEventListener('submit', function(e)
{
    e.preventDefault();

    let form = this;

    let fd = new FormData(form);

    fetch(
        "{{ route('bulletin.verifier') }}",
        {
            method: "POST",

            body: fd,

            headers:
            {
                "X-CSRF-TOKEN":
                document
                .querySelector('meta[name="csrf-token"]')
                .content
            }
        }
    )

    .then(response => response.json())

    .then(data =>
    {
        if (!data.success)
        {
            document.getElementById('popup').innerHTML = `

                <div class="alert alert-danger">

                    Cette période ne possède aucune note.

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
                        Enregistrer les notes
                    </a>

                </div>

            `;
        }
        else
        {
            form.submit();
        }
    })

    .catch(error =>
    {
        console.error(error);

        alert('Erreur de vérification');
    });

});

</script>

@endsection