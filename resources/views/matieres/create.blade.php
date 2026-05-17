@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                📚 Ajouter matière
            </h4>

        </div>

        <!-- BODY -->
        <div class="card-body">

            <form method="POST"
                  action="{{ route('matieres.store') }}">

                @csrf

                <!-- NOM -->
                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Nom matière
                    </label>

                    <input
                        type="text"
                        name="nom"
                        class="form-control"
                        
                        required>

                </div>

                <!-- CLASSES -->
                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <label class="form-label fw-bold mb-0">
                            Classes concernées
                        </label>

                        <!-- BUTTONS -->
                        <div class="d-flex gap-2">

                            <button
                                type="button"
                                id="selectAll"
                                class="btn btn-sm btn-success">

                                ✅ Tout sélectionner

                            </button>

                            <button
                                type="button"
                                id="deselectAll"
                                class="btn btn-sm btn-danger">

                                ❌ Tout désélectionner

                            </button>

                        </div>

                    </div>

                    <!-- BOX -->
                    <div class="border rounded p-3 bg-light">

                        <div class="row">

                            @foreach($classes as $classe)

                                <div class="col-md-4 mb-2">

                                    <div class="form-check">

                                        <input
                                            type="checkbox"
                                            name="classes[]"
                                            value="{{ $classe->id }}"
                                            class="form-check-input classe-checkbox"
                                            id="classe{{ $classe->id }}">

                                        <label
                                            class="form-check-label"
                                            for="classe{{ $classe->id }}">

                                            {{ $classe->nom }}

                                        </label>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

                <!-- BUTTON -->
                <button class="btn btn-primary">

                    💾 Enregistrer

                </button>

            </form>

        </div>

    </div>

</div>

<!-- JS -->
<script>

    /*
    |--------------------------------------------------------------------------
    | SELECT ALL
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('selectAll')
        .addEventListener('click', function () {

            document
                .querySelectorAll('.classe-checkbox')
                .forEach(function (checkbox) {

                    checkbox.checked = true;

                });

        });

    /*
    |--------------------------------------------------------------------------
    | DESELECT ALL
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('deselectAll')
        .addEventListener('click', function () {

            document
                .querySelectorAll('.classe-checkbox')
                .forEach(function (checkbox) {

                    checkbox.checked = false;

                });

        });

</script>

@endsection