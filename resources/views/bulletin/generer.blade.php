@extends('layouts.app')

@section('content')
    <h3 class="mb-4">
        📄 Génération des bulletins
    </h3>

    <div id="alertePeriode" class="alert alert-danger" style="display:none;">

        Veuillez sélectionner au moins une période.

    </div>

    <form id="formBulletin" method="POST" action="{{ route('bulletin.afficher') }}">

        @csrf

        <div class="card mb-4">

            <div class="card-header">

                Choix des périodes

            </div>

            <div class="card-body">

                @foreach ($periodes as $periode)
                    <label class="me-4">

                        <input type="checkbox" name="periodes[]" value="{{ $periode->id }}">

                        {{ $periode->nom }}

                    </label>
                @endforeach

            </div>

        </div>

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Nom</th>

                    <th>Classe</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($eleves as $eleve)
                    @php

                        $bulletin = \App\Models\Bulletin::where('eleve_id', $eleve->id)->latest()->first();

                    @endphp

                    <tr>

                        <td>

                            {{ $eleve->nom }}

                            {{ $eleve->prenom }}

                        </td>

                        <td>

                            {{ $eleve->classe->nom }}

                        </td>

                        <td>
                            <button type="submit" name="eleve_id" value="{{ $eleve->id }}"
                                class="btn btn-success btn-sm">
                                Générer
                            </button>

                            <button type="button" class="btn btn-primary btn-sm btn-voir" data-eleve="{{ $eleve->id }}">
                                👁 Voir
                            </button>

                            @if ($bulletin)
                                <div class="dropdown d-inline-block">

                                    <button class="btn btn-warning btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">

                                        📥 Télécharger

                                    </button>

                                    <ul class="dropdown-menu">

                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('bulletin.downloadImage', $bulletin->id) }}">
                                                🖼 PNG
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('bulletin.downloadPdf', $bulletin->id) }}">
                                                📄 PDF
                                            </a>
                                        </li>

                                    </ul>

                                </div>
                            @endif

                            <button type="button" class="btn btn-danger btn-sm btn-print"
                                data-eleve="{{ $eleve->id }}">
                                🖨 Imprimer
                            </button>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </form>

    <script>
        function getPeriodes() {
            let ids = [];

            document
                .querySelectorAll(
                    'input[name="periodes[]"]:checked'
                )
                .forEach(cb => {
                    ids.push(cb.value);
                });

            return ids.join(',');
        }

        document.querySelectorAll('.btn-voir')
            .forEach(btn => {
                btn.addEventListener('click', function() {
                    let periodes = getPeriodes();

                    if (!periodes) {
                        alert(
                            'Choisissez au moins une période.'
                        );

                        return;
                    }

                    window.location.href =
                        '/bulletin/voir-direct' +
                        '?eleve_id=' +
                        this.dataset.eleve +
                        '&periodes=' +
                        periodes;
                });
            });

        document.querySelectorAll('.btn-download')
            .forEach(btn => {
                btn.addEventListener('click', function() {
                    let periodes = getPeriodes();

                    if (!periodes) {
                        alert(
                            'Choisissez au moins une période.'
                        );

                        return;
                    }

                    window.location.href =
                        '/bulletin/download-direct' +
                        '?eleve_id=' +
                        this.dataset.eleve +
                        '&periodes=' +
                        periodes;
                });
            });

        document.querySelectorAll('.btn-print')
            .forEach(btn => {
                btn.addEventListener('click', function() {
                    let periodes = getPeriodes();

                    if (!periodes) {
                        alert(
                            'Choisissez au moins une période.'
                        );

                        return;
                    }

                    window.open(
                        '/bulletin/print-direct' +
                        '?eleve_id=' +
                        this.dataset.eleve +
                        '&periodes=' +
                        periodes,
                        '_blank'
                    );
                });
            });
    </script>
@endsection
