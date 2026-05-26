@extends('layouts.app')

@section('content')
    <style>
        .bulletin {

            background: white;

            padding: 35px;

            margin-bottom: 40px;

            border-radius: 15px;

            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);

            border: 2px solid #ddd;

        }

        .entete {

            display: flex;

            justify-content: space-between;

            align-items: center;

            border-bottom: 3px solid #1e3a8a;

            padding-bottom: 15px;

            margin-bottom: 20px;

        }

        .ecole {

            text-align: center;

            flex: 1;

        }

        .ecole h2 {

            margin: 0;

            color: #1e3a8a;

            font-weight: 700;

        }

        .ecole p {

            margin: 0;

            color: #555;

        }

        .titre {

            text-align: center;

            margin: 20px 0;

            background: #1e3a8a;

            color: white;

            padding: 10px;

            border-radius: 8px;

            font-size: 22px;

            font-weight: bold;

        }

        .infos {

            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 10px;

            margin-bottom: 20px;

        }

        .bloc-info {

            background: #f8fafc;

            padding: 10px;

            border-radius: 8px;

            border-left: 5px solid #1e3a8a;

        }

        .table-note th {

            background: #1e3a8a;

            color: white;

        }

        .resume {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 15px;

            margin-top: 20px;

        }

        .card-resume {

            background: #f1f5f9;

            padding: 15px;

            border-radius: 10px;

            text-align: center;

            font-weight: bold;

        }

        .footer-sign {

            margin-top: 50px;

            display: flex;

            justify-content: space-between;

        }

        .sign {

            text-align: center;

            width: 200px;

        }

        @media print {

            .btn-print {

                display: none;

            }

        }
    </style>

    <button onclick="window.print()" class="btn btn-success btn-print mb-3">

        🖨 Imprimer

    </button>

    @foreach ($bulletins as $b)
        @php

            $total = 0;

            $coef = 0;

        @endphp

        <div class="bulletin">

            <div class="entete">

                <div>

                    <b>

                        République de Madagascar

                    </b>

                    <br>

                    Ministère de l'Éducation

                </div>

                <div class="ecole">

                    <h2>

                        LYCÉE EDUMANAGE

                    </h2>

                    <p>

                        Antananarivo

                    </p>

                </div>

                <div>

                    Année :

                    {{ date('Y') }}

                </div>

            </div>

            <div class="titre">

                BULLETIN DE NOTES

                —

                {{ $b['periode']->nom }}

            </div>

            <div class="infos">

                <div class="bloc-info">

                    Nom :

                    <b>

                        {{ $eleve->nom }}

                        {{ $eleve->prenom }}

                    </b>

                </div>

                <div class="bloc-info">

                    Classe :

                    <b>

                        {{ $eleve->classe->nom }}

                    </b>

                </div>

                <div class="bloc-info">

                    Matricule :

                    <b>

                        {{ $eleve->id }}

                    </b>

                </div>

                <div class="bloc-info">

                    Date :

                    <b>

                        {{ date('d/m/Y') }}

                    </b>

                </div>

            </div>

            <table class="table table-bordered table-note">

                <thead>

                    <tr>

                        <th>

                            Matière

                        </th>

                        <th>

                            Note

                        </th>

                        <th>

                            Coef

                        </th>

                        <th>

                            Moy.

                        </th>

                        <th>

                            Appréciation

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($b['notes'] as $n)
                        @php

                            $noteReelle = $n->coef > 0 ? $n->valeur / $n->coef : 0;

                            $total += $n->valeur;

                            $coef += $n->coef;

                            if ($noteReelle < 5) {
                                $app = 'Très insuffisant';

                                $c = 'darkred';
                            } elseif ($noteReelle < 10) {
                                $app = 'Insuffisant';

                                $c = 'red';
                            } elseif ($noteReelle < 12) {
                                $app = 'Passable';

                                $c = 'orange';
                            } elseif ($noteReelle < 14) {
                                $app = 'Assez bien';

                                $c = '#c59d00';
                            } elseif ($noteReelle < 17) {
                                $app = 'Bien';

                                $c = 'green';
                            } else {
                                $app = 'Très bien';

                                $c = 'blue';
                            }

                        @endphp

                        <tr>

                            <td>

                                {{ $n->matiere->nom }}

                            </td>

                            <td>

                                {{ number_format($n->valeur, 2) }}

                            </td>

                            <td>

                                {{ $n->coef }}

                            </td>

                            <td>

                                {{ number_format($noteReelle, 2) }}

                            </td>

                            <td style="color:{{ $c }}">

                                <b>

                                    {{ $app }}

                                </b>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

            @php

                $moyenne = $coef > 0 ? $total / $coef : 0;

            @endphp

            <div class="resume">

                <div class="card-resume">

                    TOTAL

                    <br>

                    {{ number_format($total, 2) }}

                </div>

                <div class="card-resume">

                    COEF

                    <br>

                    {{ $coef }}

                </div>

                <div class="card-resume">

                    MOYENNE

                    <br>

                    {{ number_format($moyenne, 2) }}

                </div>

                <div class="card-resume">

                    RÉSULTAT

                    <br>

                    @if ($moyenne >= 10)
                        ADMIS
                    @else
                        AJOURNÉ
                    @endif

                </div>

            </div>

            <div class="footer-sign">

                <div class="sign">

                    Le professeur principal

                    <br><br><br>

                    ____________

                </div>

                <div class="sign">

                    Proviseur

                    <br><br><br>

                    ____________

                </div>

            </div>

        </div>
    @endforeach
@endsection
