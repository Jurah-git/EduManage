@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="card shadow border-0 rounded-4">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white py-3">

                <h4 class="mb-0">
                    🎓 Ajouter élève
                </h4>

            </div>

            <!-- BODY -->
            <div class="card-body p-4">

                <form method="POST" action="{{ route('eleves.store') }}" enctype="multipart/form-data">

                    @csrf

                    <div class="row">

                        <!-- PHOTO -->
                        <div class="col-md-12 mb-4">

                            <label class="form-label fw-bold">
                                Photo élève
                            </label>

                            <input type="file" name="photo" class="form-control form-control-lg">

                        </div>

                        <!-- NOM -->
                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-bold">
                                Nom
                            </label>

                            <input type="text" name="nom" class="form-control form-control-lg" required>

                        </div>

                        <!-- PRENOM -->
                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-bold">
                                Prénom
                            </label>

                            <input type="text" name="prenom" class="form-control form-control-lg" required>

                        </div>

                        <!-- SEXE -->
                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-bold">
                                Sexe
                            </label>

                            <select name="sexe" class="form-select form-select-lg">

                                <option value="">
                                    Choisir sexe
                                </option>

                                <option value="Masculin">
                                    Masculin
                                </option>

                                <option value="Féminin">
                                    Féminin
                                </option>

                            </select>

                        </div>

                        <!-- DATE -->
                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-bold">
                                Date naissance
                            </label>

                            <input type="date" name="date_naissance" class="form-control form-control-lg">

                        </div>

                        <!-- CLASSE -->
                        <div class="col-md-12 mb-4">

                            <label class="form-label fw-bold">
                                Classe
                            </label>

                            <select name="classe_id" class="form-select form-select-lg" required>

                                <option value="">
                                    Choisir classe
                                </option>

                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}">

                                        {{ $classe->nom }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>

                    <!-- INFO AUTO -->
                    <div class="alert alert-info">

                        ℹ️ Le matricule et le numéro de classe
                        seront générés automatiquement.

                    </div>

                    <!-- BUTTONS -->
                    <div class="d-flex gap-2">

                        <button class="btn btn-success btn-lg">

                            ✅ Enregistrer

                        </button>

                        <a href="{{ route('eleves.index') }}" class="btn btn-secondary btn-lg">

                            Retour

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
