@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <!-- HEADER -->
        <div class="card-header bg-warning">

            <h4 class="mb-0">

                ✏ Modifier classe

            </h4>

        </div>

        <!-- BODY -->
        <div class="card-body">

            <form method="POST"
                  action="{{ route('classes.update', $classe) }}">

                @csrf
                @method('PUT')

                <!-- NOM -->
                <div class="mb-3">

                    <label class="form-label">

                        Nom classe

                    </label>

                    <input
                        type="text"
                        name="nom"
                        value="{{ $classe->nom }}"
                        class="form-control"
                        required>

                </div>

                <!-- BUTTONS -->
                <div class="d-flex gap-2">

                    <button class="btn btn-primary">

                        ✅ Modifier

                    </button>

                    <a href="{{ route('classes.index') }}"
                       class="btn btn-secondary">

                        Retour

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection