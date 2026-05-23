@extends('layouts.app')

@section('content')
    <h3>

        📄 Générer bulletin

    </h3>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>

                    Nom

                </th>

                <th>

                    Classe

                </th>

                <th>

                    Action

                </th>

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

                        <a href="{{ route(
                            'bulletin.choix',
                        
                            $eleve->id,
                        ) }}" class="btn btn-primary">

                            Choisir périodes

                        </a>

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>
@endsection
