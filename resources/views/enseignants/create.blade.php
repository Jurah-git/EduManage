@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-person-plus"></i> Ajouter un enseignant</h2>
            <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
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
            <div class="card-header bg-primary text-white">
                <i class="bi bi-person-vcard"></i> Informations de l'enseignant
            </div>

            <div class="card-body">
                <form action="{{ route('enseignants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('enseignants._form', ['enseignant' => new \App\Models\Enseignant()])

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Enregistrer l'enseignant
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
