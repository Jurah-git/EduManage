
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-user-circle me-2"></i>
            Espace Parent
        </h2>

        <p class="text-muted">
            Bienvenue {{ $parent->prenom }} {{ $parent->nom }}.
            Consultez les informations scolaires de vos enfants.
        </p>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-id-card me-2"></i>
                Mes informations
            </h5>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>Nom :</strong> {{ $parent->nom }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Prénom :</strong> {{ $parent->prenom }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Téléphone :</strong>
                    {{ $parent->telephone ?? 'Non renseigné' }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Email :</strong>
                    {{ $parent->email ?? 'Non renseigné' }}
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-user-graduate me-2"></i>
                Mes enfants
            </h5>
        </div>

        <div class="card-body">

            @forelse($parent->eleves as $eleve)

                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>
                            <h5 class="fw-bold mb-1">
                                {{ $eleve->prenom }} {{ $eleve->nom }}
                            </h5>

                            <p class="text-muted mb-1">
                                Matricule :
                                {{ $eleve->matricule ?? 'Non renseigné' }}
                            </p>

                            <small class="text-muted">
                                Lien de parenté :
                                {{ $eleve->pivot->lien_parente ?? 'Non renseigné' }}
                            </small>
                        </div>

                        <span class="badge bg-success">
                            Élève associé
                        </span>

                    </div>
                </div>

            @empty

                <div class="alert alert-info mb-0">
                    Aucun enfant n'est actuellement associé à votre compte.
                </div>

            @endforelse

            <a href="{{ route('parent.enfants') }}"
               class="btn btn-primary mt-3">
                <i class="fas fa-eye me-1"></i>
                Voir tous mes enfants
            </a>

        </div>
    </div>

</div>

@endsection
