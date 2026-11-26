
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- EN-TÊTE --}}
    <div class="mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-clipboard-list me-2 text-primary"></i>
            Mes demandes d'inscription
        </h2>

        <p class="text-muted">
            Consultez les demandes d'inscription aux activités
            parascolaires de vos enfants.
        </p>
    </div>

    {{-- MESSAGE DE SUCCÈS --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLEAU DES DEMANDES --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Historique de mes demandes
            </h5>
        </div>

        <div class="card-body">

            @if($demandes->isNotEmpty())

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Enfant</th>
                                <th>Activité</th>
                                <th>Année scolaire</th>
                                <th>Date de demande</th>
                                <th>Tarif indicatif</th>
                                <th>Statut</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($demandes as $demande)

                                <tr>

                                    <td class="fw-semibold">
                                        {{ $demande->eleve->prenom ?? '' }}
                                        {{ $demande->eleve->nom ?? '' }}
                                    </td>

                                    <td>
                                        {{ $demande->activite->nom ?? 'Activité indisponible' }}
                                    </td>

                                    <td>
                                        {{ $demande->anneeScolaire->nom ?? 'Non renseignée' }}
                                    </td>

                                    <td>
                                        {{ $demande->date_demande?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>
                                        {{ number_format((float) $demande->tarif_applique, 0, ',', ' ') }}
                                        Ar
                                    </td>

                                    <td>

                                        @if($demande->statut === 'en_attente')
                                            <span class="badge bg-warning text-dark">
                                                En attente
                                            </span>

                                        @elseif($demande->statut === 'acceptee')
                                            <span class="badge bg-success">
                                                Acceptée
                                            </span>

                                        @elseif($demande->statut === 'refusee')
                                            <span class="badge bg-danger">
                                                Refusée
                                            </span>

                                        @elseif($demande->statut === 'annulee')
                                            <span class="badge bg-secondary">
                                                Annulée
                                            </span>

                                        @else
                                            <span class="badge bg-light text-dark">
                                                {{ $demande->statut }}
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>

                    <h5 class="fw-bold">
                        Aucune demande pour le moment
                    </h5>

                    <p class="text-muted">
                        Vous n'avez pas encore envoyé de demande
                        d'inscription à une activité parascolaire.
                    </p>

                    <a href="{{ route('parent.activites.index') }}"
                       class="btn btn-primary">

                        <i class="fas fa-futbol me-1"></i>
                        Découvrir les activités

                    </a>

                </div>

            @endif

        </div>

    </div>

    {{-- RETOUR --}}
    <div class="mt-3">

        <a href="{{ route('parent.activites.index') }}"
           class="btn btn-outline-primary">

            <i class="fas fa-arrow-left me-1"></i>
            Retour aux activités

        </a>

    </div>

</div>

@endsection
