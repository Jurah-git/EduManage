@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow border-0">

        <div class="card-header bg-warning">

            <h4 class="mb-0">
                ✏ Modifier matière
            </h4>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                method="POST"
                action="{{ route('matieres.update', $matiere) }}">

                @csrf
                @method('PUT')

                <div class="row">

                    <!-- NOM -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">

                            Nom matière

                        </label>

                        <input
                            type="text"
                            name="nom"
                            value="{{ $matiere->nom }}"
                            class="form-control"
                            required>

                    </div>

                    

                    

                    <!-- CLASSES -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label fw-bold">

                            Classes concernées

                        </label>

                        <div class="row">

                            @foreach($classes as $classe)

                                <div class="col-md-3 mb-2">

                                    <div class="form-check">

                                        <input
                                            type="checkbox"
                                            name="classes[]"
                                            value="{{ $classe->id }}"
                                            class="form-check-input"

                                            {{ $matiere->classes->contains($classe->id) ? 'checked' : '' }}>

                                        <label class="form-check-label">

                                            {{ $classe->nom }}

                                        </label>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

                <button class="btn btn-primary">

                    ✅ Modifier

                </button>

                <a
                    href="{{ route('matieres.index') }}"
                    class="btn btn-secondary">

                    Retour

                </a>

            </form>

        </div>

    </div>

</div>

@endsection