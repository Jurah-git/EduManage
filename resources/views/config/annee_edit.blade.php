```blade
@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="mb-0">
                <i class="bi bi-pencil-square"></i>
                Modifier l'année scolaire
            </h2>

            <a href="{{ route('config.annees-scolaires.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>

        </div>


        <div class="card shadow">

            <div class="card-header bg-warning">

                <i class="bi bi-calendar3"></i>

                Modification de :
                <strong>{{ $anneeScolaire->nom }}</strong>

            </div>


            <div class="card-body">

                {{-- Messages d'erreur --}}

                @if ($errors->any())
                    <div class="alert alert-danger">

                        <div class="fw-bold mb-2">

                            <i class="bi bi-exclamation-triangle"></i>

                            Veuillez corriger les erreurs suivantes :
                        </div>

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                    </div>
                @endif


                {{-- Formulaire --}}

                <form action="{{ route('config.annees-scolaires.update', $anneeScolaire) }}" method="POST">

                    @csrf

                    @method('PUT')


                    <div class="row">

                        {{-- Année scolaire --}}

                        <div class="col-md-4 mb-3">

                            <label for="nom" class="form-label fw-bold">
                                Année scolaire
                            </label>

                            <input type="text" id="nom" name="nom"
                                class="form-control @error('nom') is-invalid @enderror"
                                value="{{ old('nom', $anneeScolaire->nom) }}" placeholder="Ex : 2025-2026" required>

                            @error('nom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Date de début --}}

                        <div class="col-md-4 mb-3">

                            <label for="date_debut" class="form-label fw-bold">
                                Date de début
                            </label>

                            <input type="date" id="date_debut" name="date_debut"
                                class="form-control @error('date_debut') is-invalid @enderror"
                                value="{{ old('date_debut', $anneeScolaire->date_debut->format('Y-m-d')) }}" required>

                            @error('date_debut')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Date de fin --}}

                        <div class="col-md-4 mb-3">

                            <label for="date_fin" class="form-label fw-bold">
                                Date de fin
                            </label>

                            <input type="date" id="date_fin" name="date_fin"
                                class="form-control @error('date_fin') is-invalid @enderror"
                                value="{{ old('date_fin', $anneeScolaire->date_fin->format('Y-m-d')) }}" required>

                            @error('date_fin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Information --}}

                    <div class="alert alert-info mt-3">

                        <i class="bi bi-info-circle"></i>

                        <strong>Information :</strong>

                        La date de fin doit être postérieure
                        à la date de début.

                    </div>


                    {{-- Boutons --}}

                    <div class="mt-4">

                        <button type="submit" class="btn btn-warning">

                            <i class="bi bi-save"></i>

                            Enregistrer les modifications

                        </button>


                        <a href="{{ route('config.annees-scolaires.index') }}" class="btn btn-secondary">

                            <i class="bi bi-x-circle"></i>

                            Annuler

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
```
