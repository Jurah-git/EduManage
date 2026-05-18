@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">
        📄 Liste des notes
    </h3>

    <div class="card shadow border-0 rounded-4">

        <div class="card-body">

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>Élève</th>
                        <th>Matière</th>
                        <th>Type</th>
                        <th>Note</th>
                        <th>Coef</th>
                        <th>Base</th>
                        <th>Période</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($notes as $note)

                        <tr>

                            <td>
                                {{ $note->eleve->nom ?? '' }}
                            </td>

                            <td>
                                {{ $note->matiere->nom ?? '' }}
                            </td>

                            <td>
                                {{ ucfirst($note->type) }}
                            </td>

                            <td>
                                {{ $note->valeur }}
                            </td>

                            <td>
                                {{ $note->coefficient }}
                            </td>

                            <td>
                                {{ $note->note_sur }}
                            </td>

                            <td>
                                {{ $note->periode->nom ?? '' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection