@extends('layouts.app')

@section('content')

    <h3>

        🧮 Coefficient :

        {{ $matiere->nom }}

    </h3>

    <form

        method="POST"

        action="{{ route(

        'coefficients.save',

        $matiere->id

        ) }}">

        @csrf

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>

                        Classe

                    </th>

                    <th>

                        Coefficient

                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach ($classes as $classe)

                    <tr>

                        <td>

                            {{ $classe->nom }}

                        </td>

                        <td>

                            <input

                                type="number"

                                min="1"

                                class="form-control"

                                name="coef[{{ $classe->id }}]"

                                value="{{

                                $coefficients[
                                $classe->id
                                ]

                                }}">

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <div class="d-flex gap-2">

            <button class="btn btn-success">

                💾 Enregistrer

            </button>

            <a

            href="{{ route(

            'coefficients.index'

            ) }}"

            class="btn btn-secondary">

                ⬅ Retour

            </a>

        </div>

    </form>

@endsection