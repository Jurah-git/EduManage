@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Modifier une salle
                </h2>
                <p class="text-muted mb-0">
                    Code : <strong>{{ $salle->code }}</strong>
                </p>
            </div>

            <a href="{{ route('salles.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('salles.update', $salle) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('salles._form', [
                        'salle' => $salle,
                        'bouton' => 'Enregistrer les modifications',
                    ])
                </form>
            </div>
        </div>

    </div>
@endsection
