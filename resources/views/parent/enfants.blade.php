
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="fas fa-user-graduate me-2"></i>
                Mes enfants
            </h2>

            <p class="text-muted mb-0">
                Consultez les informations scolaires de vos enfants.
            </p>
        </div>

        <a href="{{ route('parent.dashboard') }}"
           class="btn btn-outline-secondary mt-2">
            <i class="fas fa-arrow-left me-1"></i>
            Retour au tableau de bord
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                Liste de mes enfants
            </h5>
        </div>

        <div class="card-body">

            @if($eleves->isEmpty())

                <div class="alert alert-info mb-0">
                    Aucun enfant n'est associé à votre compte.
                </div>

            @else

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Matricule</th>
                                <th>Nom et prénom</th>
                                <th>Lien de parenté</th>
                                <th>Responsable légal</th>
                                <th>Contact principal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($eleves as $index => $eleve)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        {{ $eleve->matricule ?? 'Non renseigné' }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $eleve->nom }}
                                        {{ $eleve->prenom }}
                                    </td>

                                    <td>
                                        {{ $eleve->pivot->lien_parente ?? 'Non renseigné' }}
                                    </td>

                                    <td>
                                        @if($eleve->pivot->responsable_legal)
                                            <span class="badge bg-success">
                                                Oui
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Non
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($eleve->pivot->contact_principal)
                                            <span class="badge bg-success">
                                                Oui
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Non
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endif

        </div>
    </div>

</div>

@endsection
