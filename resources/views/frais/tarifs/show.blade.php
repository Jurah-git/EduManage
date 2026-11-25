@extends('layouts.app')

@section('content')
    <div class="container py-3">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="mb-1"><i class="bi bi-file-earmark-text"></i> Détails du tarif</h2>
                <p class="text-muted mb-0">Informations détaillées du tarif scolaire.</p>
            </div>

            <div class="d-flex gap-2">
                @if (auth()->user()->aPermission('frais.tarifs_gerer'))
                    <a href="{{ route('frais.tarifs.edit', $tarif->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </a>
                @endif

                <a href="{{ route('frais.tarifs.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <strong><i class="bi bi-cash-stack"></i> Informations générales</strong>
            </div>

            <div class="card-body">
                <div class="row g-4">

                    <div class="col-md-6">
                        <span class="text-muted d-block">Type de frais</span>
                        <strong>{{ $tarif->typeFrais->nom ?? '—' }}</strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted d-block">Année scolaire</span>
                        <strong>{{ $tarif->anneeScolaire->nom ?? '—' }}</strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted d-block">Classe</span>
                        <strong>{{ $tarif->classe->nom ?? '—' }}</strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted d-block">Montant du tarif</span>
                        <strong class="text-primary fs-5">
                            {{ number_format((float) $tarif->montant, 0, ',', ' ') }} Ar
                        </strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted d-block">Date de début</span>
                        <strong>
                            {{ $tarif->date_debut ? \Carbon\Carbon::parse($tarif->date_debut)->format('d/m/Y') : 'Non définie' }}
                        </strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted d-block">Date de fin</span>
                        <strong>
                            {{ $tarif->date_fin ? \Carbon\Carbon::parse($tarif->date_fin)->format('d/m/Y') : 'Non définie' }}
                        </strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted d-block">Statut</span>
                        @if ($tarif->actif)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-secondary">Inactif</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <strong><i class="bi bi-people"></i> Frais générés pour les élèves</strong>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    Nombre de lignes de frais associées :
                    <strong>{{ $tarif->elevesFrais->count() }}</strong>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Libellé</th>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Montant dû</th>
                                <th>Statut</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($tarif->elevesFrais as $frais)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $frais->libelle }}</td>
                                    <td>{{ $frais->mois ?: '—' }}</td>
                                    <td>{{ $frais->annee ?: '—' }}</td>
                                    <td>{{ number_format((float) $frais->montant_du, 0, ',', ' ') }} Ar</td>
                                    <td>
                                        @if ($frais->statut === 'paye')
                                            <span class="badge bg-success">Payé</span>
                                        @elseif($frais->statut === 'partiel')
                                            <span class="badge bg-warning text-dark">Partiellement payé</span>
                                        @else
                                            <span class="badge bg-danger">Impayé</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Aucun frais n'a encore été généré pour ce tarif.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
