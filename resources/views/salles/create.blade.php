@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-door-open text-primary me-2"></i>Ajouter une salle
                </h2>
                <p class="text-muted mb-0">Enregistrer une nouvelle salle de classe.</p>
            </div>

            <a href="{{ route('salles.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Informations de la salle</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('salles.store') }}" method="POST">
                    @include('salles._form', [
                        'salle' => new \App\Models\Salle(),
                        'bouton' => 'Enregistrer la salle',
                    ])
                </form>
            </div>
        </div>

    </div>
@endsection
