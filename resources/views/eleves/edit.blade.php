@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-warning">

                <h4 class="mb-0">
                    ✏ Modifier élève
                </h4>

            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('eleves.update', $eleve) }}" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!--PHOTO-->
                        <div class="col-md-12 mb-4">

                            <label class="form-label fw-bold">
                                Photo élève
                            </label>

                            <input type="file" name="photo" class="form-control">

                        </div>

                        <!-- NOM -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nom
                            </label>

                            <input type="text" name="nom" value="{{ $eleve->nom }}" class="form-control" required>

                        </div>

                        <!-- PRENOM -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Prénom
                            </label>

                            <input type="text" name="prenom" value="{{ $eleve->prenom }}" class="form-control" required>

                        </div>

                        <!-- MATRICULE -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Matricule
                            </label>

                            <input type="text" name="matricule" value="{{ $eleve->matricule }}" class="form-control">

                        </div>

                        <!-- SEXE -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Sexe
                            </label>

                            <select name="sexe" class="form-control">

                                <option value="">
                                    Choisir
                                </option>

                                <option value="Masculin" {{ $eleve->sexe == 'Masculin' ? 'selected' : '' }}>
                                    Masculin
                                </option>

                                <option value="Féminin" {{ $eleve->sexe == 'Féminin' ? 'selected' : '' }}>
                                    Féminin
                                </option>

                            </select>

                        </div>

                        <!-- DATE -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Date naissance
                            </label>

                            <input type="date" name="date_naissance" value="{{ $eleve->date_naissance }}"
                                class="form-control">

                        </div>

                        <!-- CLASSE -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Classe
                            </label>

                            <select name="classe_id" class="form-control">

                                <option value="">
                                    Choisir classe
                                </option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}"
                                        {{ $eleve->classe_id == $classe->id ? 'selected' : '' }}>

                                        {{ $classe->nom }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>

                    <!-- BOUTON -->
                    <button class="btn btn-primary">

                        ✅ Modifier

                    </button>

                    <a href="{{ route('eleves.index') }}" class="btn btn-secondary">

                        Retour

                    </a>

                </form>

            </div>

        </div>

    </div>
@endsection
