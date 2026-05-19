@extends('layouts.app')

@section('content')
    <h3>

        📚 Coefficients par matière

    </h3>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Matière</th>

                <th>Action</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($matieres as $matiere)
                <tr>

                    <td>

                        {{ $matiere->nom }}

                    </td>

                    <td>

                        <a href="{{ route(
                            'coefficients.edit',
                        
                            $matiere->id,
                        ) }}"
                            class="btn btn-primary">

                            Configurer

                        </a>

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>
@endsection
