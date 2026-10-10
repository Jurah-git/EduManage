@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-door-open text-primary me-2"></i>{{ $salle->nom }}
                </h2>
                <p class="text-muted mb-0">Code : {{ $salle->code }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('salles.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
                <a href="{{ route('salles.edit', $salle) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Modifier
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Informations générales</h5>
            </div>

            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="text-muted small">Code de salle</div>
                        <div class="fw-semibold">{{ $salle->code }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Nom</div>
                        <div class="fw-semibold">{{ $salle->nom }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Bâtiment</div>
                        <div>{{ $salle->batiment ?: 'Non renseigné' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Étage</div>
                        <div>{{ $salle->etage ?: 'Non renseigné' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Capacité</div>
                        <div>{{ $salle->capacite }} élèves</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Type</div>
                        <div>{{ $salle->type }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Statut</div>
                        <div>{{ $salle->statut }}</div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small">Description</div>
                        <div>{{ $salle->description ?: 'Aucune description' }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
