```blade
@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- En-tête --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="mb-0">

                <i class="bi bi-calendar3"></i>

                Détail de l'année scolaire

            </h2>


            <a href="{{ route('config.annees-scolaires.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>

                Retour

            </a>

        </div>


        {{-- Carte principale --}}

        <div class="card shadow">

            <div class="card-header bg-primary text-white">

                <i class="bi bi-calendar-check"></i>

                <strong>
                    {{ $anneeScolaire->nom }}
                </strong>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- Nom --}}

                    <div class="col-md-4 mb-4">

                        <div class="border rounded p-3 h-100">

                            <div class="text-muted mb-1">

                                <i class="bi bi-calendar3"></i>

                                Année scolaire

                            </div>

                            <h4 class="mb-0">

                                {{ $anneeScolaire->nom }}

                            </h4>

                        </div>

                    </div>


                    {{-- Date début --}}

                    <div class="col-md-4 mb-4">

                        <div class="border rounded p-3 h-100">

                            <div class="text-muted mb-1">

                                <i class="bi bi-calendar-event"></i>

                                Date de début

                            </div>

                            <h5 class="mb-0">

                                {{ \Carbon\Carbon::parse($anneeScolaire->date_debut)->format('d/m/Y') }}

                            </h5>

                        </div>

                    </div>


                    {{-- Date fin --}}

                    <div class="col-md-4 mb-4">

                        <div class="border rounded p-3 h-100">

                            <div class="text-muted mb-1">

                                <i class="bi bi-calendar-event"></i>

                                Date de fin

                            </div>

                            <h5 class="mb-0">

                                {{ \Carbon\Carbon::parse($anneeScolaire->date_fin)->format('d/m/Y') }}

                            </h5>

                        </div>

                    </div>


                    {{-- État --}}

                    <div class="col-md-12 mb-3">

                        <div class="border rounded p-3">

                            <div class="text-muted mb-2">

                                <i class="bi bi-info-circle"></i>

                                État de l'année scolaire

                            </div>


                            @if ($anneeScolaire->active)
                                <span class="badge bg-success fs-6">

                                    <i class="bi bi-check-circle"></i>

                                    Année scolaire en cours

                                </span>
                            @else
                                <span class="badge bg-secondary fs-6">

                                    <i class="bi bi-dash-circle"></i>

                                    Année scolaire inactive

                                </span>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- Actions --}}

                <div class="mt-4">

                    <a href="{{ route('config.annees-scolaires.edit', $anneeScolaire) }}" class="btn btn-warning">

                        <i class="bi bi-pencil-square"></i>

                        Modifier

                    </a>


                    @if (!$anneeScolaire->active)
                        <form action="{{ route('config.annees-scolaires.activer', $anneeScolaire) }}" method="POST"
                            class="d-inline">

                            @csrf

                            @method('PATCH')

                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Voulez-vous définir cette année scolaire comme année en cours ?')">

                                <i class="bi bi-check-circle"></i>

                                Définir comme année en cours

                            </button>

                        </form>
                    @endif


                    <a href="{{ route('config.annees-scolaires.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        Retour à la liste

                    </a>

                </div>

            </div>

        </div>

    </div>
@endsection
```
