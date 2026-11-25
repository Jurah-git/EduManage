@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        {{-- En-tête --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Liste des paiements</h3>
                <p class="text-muted mb-0">
                    Historique des encaissements effectués dans l'établissement.
                </p>
            </div>

            @if (auth()->user()->aPermission('frais.encaisser'))
                <a href="{{ route('frais.paiements.create') }}" class="btn btn-primary">
                    + Nouvel encaissement
                </a>
            @endif
        </div>

        {{-- Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Recherche et filtres --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('frais.paiements.index') }}">

                    <div class="row g-3 align-items-end">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Rechercher un paiement
                            </label>

                            <input type="text" name="recherche" class="form-control" value="{{ request('recherche') }}"
                                placeholder="Numéro de paiement, nom, prénom ou matricule...">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                Statut
                            </label>

                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>

                                <option value="valide" {{ request('statut') === 'valide' ? 'selected' : '' }}>
                                    Validé
                                </option>

                                <option value="annule" {{ request('statut') === 'annule' ? 'selected' : '' }}>
                                    Annulé
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                Rechercher
                            </button>

                            <a href="{{ route('frais.paiements.index') }}" class="btn btn-outline-secondary">
                                Réinitialiser
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Tableau des paiements --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Historique des encaissements</h5>

                <span class="badge bg-primary">
                    {{ $paiements->total() }} paiement(s)
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">N° Paiement</th>
                                <th>Élève</th>
                                <th>Classe</th>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Mode</th>
                                <th>Statut</th>
                                <th>Reçu</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($paiements as $paiement)
                                <tr>
                                    <td class="ps-3">
                                        <span class="fw-semibold">
                                            {{ $paiement->numero_paiement }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $paiement->eleve?->nom }}
                                            {{ $paiement->eleve?->prenom }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $paiement->eleve?->matricule }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ $paiement->eleve?->classe?->nom ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $paiement->date_paiement?->format('d/m/Y') }}
                                    </td>

                                    <td>
                                        <span class="fw-bold">
                                            {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ar
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            Espèces
                                        </span>
                                    </td>

                                    <td>
                                        @if ($paiement->statut === 'valide')
                                            <span class="badge bg-success">
                                                Validé
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Annulé
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($paiement->recu)
                                            <span class="text-success fw-semibold">
                                                {{ $paiement->recu->numero_recu }}
                                            </span>
                                        @else
                                            <span class="text-muted">Aucun reçu</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('frais.paiements.show', $paiement) }}"
                                                class="btn btn-sm btn-outline-primary" title="Voir les détails">
                                                Voir
                                            </a>

                                            @if ($paiement->recu && $paiement->statut === 'valide')
                                                <a href="{{ route('frais.recus.imprimer', $paiement->recu) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-success"
                                                    title="Imprimer le reçu">
                                                    Imprimer
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="mb-2 text-muted">
                                            Aucun paiement trouvé.
                                        </div>

                                        <small class="text-muted">
                                            Les paiements enregistrés apparaîtront ici.
                                        </small>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>

            {{-- Pagination --}}
            @if ($paiements->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                        <small class="text-muted">
                            Affichage de {{ $paiements->firstItem() }}
                            à {{ $paiements->lastItem() }}
                            sur {{ $paiements->total() }} paiement(s)
                        </small>

                        {{ $paiements->links() }}

                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
