@extends('layouts.app')

@section('content')
    <style>
        body {

            background: #eef2f7;

        }

        .container-bulletins {

            display: grid;

            gap: 20px;

            width: 100%;

            margin: auto;

            align-items: start;

        }

        .nb1 {

            grid-template-columns: minmax(850px, 950px);

            justify-content: center;

        }

        .nb2 {

            grid-template-columns: repeat(2, minmax(500px, 1fr));

        }

        .nb3 {

            grid-template-columns: repeat(3, minmax(360px, 1fr));

        }

        .bulletin {

            background: white;

            border-radius: 18px;

            overflow: hidden;

            box-shadow:

                0 10px 30px rgba(0, 0, 0, .08);

            border: 1px solid #d6dde8;

            display: flex;

            flex-direction: column;

            height: 100%;

        }

        .header-top {

            background:

                linear-gradient(135deg,

                    #123c8f,

                    #1d4ed8);

            color: white;

            padding: 18px;

        }

        .entete {

            display: flex;

            justify-content: space-between;

            align-items: center;

            font-size: 13px;

        }

        .ecole {

            text-align: center;

            flex: 1;

        }

        .ecole h2 {

            margin: 0;

            font-size: 22px;

            font-weight: 700;

        }

        .ecole p {

            margin: 0;

            font-size: 12px;

            opacity: .9;

        }

        .titre {

            background: #f1f5f9;

            padding: 12px;

            text-align: center;

            font-size: 18px;

            font-weight: 700;

            color: #123c8f;

            border-bottom: 1px solid #dbe4f0;

        }

        .infos {

            padding: 15px;

            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 10px;

        }

        .bloc-info {

            background: #f8fafc;

            padding: 10px;

            border-radius: 10px;

            border-left: 4px solid #123c8f;

            font-size: 13px;

        }

        .zone-table {

            padding: 15px;

        }

        .table-note {

            margin: 0;

            font-size: 12px;

        }

        .table-note th {

            background: #123c8f;

            color: white;

            text-align: center;

            font-size: 12px;

            vertical-align: middle;

        }

        .table-note td {

            text-align: center;

            vertical-align: middle;

            padding: 8px;

        }

        .resume {

            padding: 15px;

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 10px;

        }

        .card-resume {

            background: #f1f5f9;

            border-radius: 10px;

            padding: 10px;

            text-align: center;

            font-size: 12px;

            font-weight: bold;

        }

        .footer-sign {

            padding: 20px;

            margin-top: auto;

            display: flex;

            justify-content: space-between;

            font-size: 12px;

        }

        .sign {

            text-align: center;

            width: 140px;

        }

        .btn-print {

            margin-bottom: 20px;

        }

        @media(max-width:1500px) {

            .nb3 {

                grid-template-columns:

                    repeat(auto-fit,

                        minmax(420px,

                            1fr));

            }

        }

        @media(max-width:1200px) {

            .nb2,

            .nb3 {

                grid-template-columns: 1fr;

            }

        }

        @media print {

            body {

                background: white;

            }

            .btn-print {

                display: none;

            }

            .container-bulletins {

                gap: 10px;

            }

            .bulletin {

                page-break-inside: avoid;

                box-shadow: none;

            }

        }
    </style>

    <button onclick="window.print()" class="btn btn-success btn-print">

        🖨 Imprimer

    </button>

    <div class="container-bulletins nb{{ count($bulletins) }}">

        @foreach ($bulletins as $b)
            @php

                $total = 0;

                $coef = 0;

            @endphp

            <div class="bulletin">

                <div class="header-top">

                    <div class="entete">

                        <div>

                            <b>

                                République de Madagascar

                            </b>

                            <br>

                            Ministère Éducation

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

                <div class="zone-table">

                    <table class="table table-bordered table-note">

                        <thead>

                            <tr>

                                <th>Matière</th>

                                <th>Note J</th>

                                <th>Composition</th>

                                <th>Coef</th>

                                <th>Moy.</th>

                                <th>Appréciation</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($b['notes']->groupBy('matiere_id') as $grp)
                                @php

                                    $j = $grp->where('type', 'journalier')->first();

                                    $comp = $grp->where('type', 'composition')->first();

                                    $noteJ = $j ? $j->valeur : '-';

                                    $noteC = $comp ? $comp->valeur : '-';

                                    $valJ = $j ? $j->valeur : 0;

                                    $valC = $comp ? $comp->valeur : 0;

                                    $coefM = $j ? $j->coef : ($comp ? $comp->coef : 1);

                                    $moyBrute = $valJ + $valC > 0 ? ($valJ + $valC) / 2 : 0;

                                    $noteReelle = $coefM > 0 ? $moyBrute / $coefM : 0;

                                    $total += $moyBrute;

                                    $coef += $coefM;

                                    if ($noteReelle < 5) {
                                        $app = 'Très insuffisant';

                                        $color = 'darkred';
                                    } elseif ($noteReelle < 10) {
                                        $app = 'Insuffisant';

                                        $color = 'red';
                                    } elseif ($noteReelle < 12) {
                                        $app = 'Passable';

                                        $color = 'orange';
                                    } elseif ($noteReelle < 14) {
                                        $app = 'Assez bien';

                                        $color = '#c59d00';
                                    } elseif ($noteReelle < 17) {
                                        $app = 'Bien';

                                        $color = 'green';
                                    } else {
                                        $app = 'Très bien';

                                        $color = 'blue';
                                    }
                                @endphp

                                <tr>

                                    <td>

                                        {{ optional($j ?? $comp)->matiere->nom }}

                                    </td>

                                    <td>

                                        {{ $noteJ }}

                                    </td>

                                    <td>

                                        {{ $noteC }}

                                    </td>

                                    <td>

                                        {{ $coefM }}

                                    </td>

                                    <td>

                                        {{ number_format($noteReelle, 2) }}

                                    </td>

                                    <td style="color:{{ $color }}">

                                        <b>

                                            {{ $app }}

                                        </b>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

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

                        @if ($moyenne >= 10)
                            ADMIS
                        @else
                            AJOURNÉ
                        @endif

                    </div>

                </div>

                <div class="footer-sign">

                    <div class="sign">

                        Professeur principal

                        <br><br>

                        ____________

                    </div>

                    <div class="sign">

                        Proviseur

                        <br><br>

                        ____________

                    </div>

                </div>

            </div>
        @endforeach

    </div>
@endsection
