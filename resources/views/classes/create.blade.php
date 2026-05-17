@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h4>📚 Ajouter classe</h4>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('classes.store') }}">

                @csrf

                <div class="mb-3">

                    <label>Nom classe</label>

                    <input
                        type="text"
                        name="nom"
                        class="form-control"
                        required>

                </div>

                

                <button class="btn btn-success">
                    ✅ Enregistrer
                </button>

            </form>

        </div>

    </div>

</div>

@endsection