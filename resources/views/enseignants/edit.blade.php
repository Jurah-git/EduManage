@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-pencil-square"></i> Modifier un enseignant</h2>
            <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Veuillez corriger les erreurs :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-warning">
                Modification de
                <strong>{{ $enseignant->prenom }} {{ $enseignant->nom }}</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('enseignants.update', $enseignant) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('enseignants._form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Enregistrer les modifications
                        </button>
                        <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
