@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold">Espace Parent</h2>

        <p class="text-muted">
            Bienvenue {{ $parent->prenom }} {{ $parent->nom }}.
            Voici les informations concernant vos enfants.
        </p>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <div class="text-muted small">Mes enfants</div>
                <h3 class="fw-bold">{{ $eleves->count() }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <div class="text-muted small">Mon compte</div>
                <h5 class="fw-bold">Parent actif</h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <div class="text-muted small">Plateforme</div>
                <h5 class="fw-bold">EduManage</h5>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">
                Mes enfants inscrits
            </h5>
        </div>

        <div class="card-body">

            @forelse($eleves as $eleve)

                <div class="border rounded-3 p-3 mb-3">

                    <h6 class="fw-bold">
                        {{ $eleve->nom }} {{ $eleve->prenom }}
                    </h6>

                    <p class="text-muted mb-1">
                        Matricule :
                        {{ $eleve->matricule ?? 'Non renseigné' }}
                    </p>

                    <p class="text-muted mb-1">
                        Classe :
                        {{ $eleve->classe->nom ?? 'Non renseignée' }}
                    </p>

                    <span class="badge bg-success">
                        Élève associé à votre compte
                    </span>

                </div>

            @empty

                <p class="text-muted text-center">
                    Aucun élève associé à votre compte.
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection