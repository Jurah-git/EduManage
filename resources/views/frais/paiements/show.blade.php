@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Détail du paiement</h3>
                <p class="text-muted mb-0">
                    Consultation de l'encaissement et de son reçu.
                </p>
            </div>

            <a href="{{ route('frais.paiements.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>

        {{-- Message de confirmation --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Informations principales --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Informations du paiement</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <small class="text-muted">Numéro de paiement</small>
                        <div class="fw-bold">
                            {{ $paiement->numero_paiement }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Date du paiement</small>
                        <div class="fw-semibold">
                            {{ $paiement->date_paiement?->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Statut</small>
                        <div>
                            @if ($paiement->statut === 'valide')
                                <span class="badge bg-success">Validé</span>
                            @else
                                <span class="badge bg-danger">Annulé</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Mode de paiement</small>
                        <div class="fw-semibold">Espèces</div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Encaissé par</small>
                        <div class="fw-semibold">
                            {{ $paiement->utilisateur?->name ?? 'Non renseigné' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Montant total</small>
                        <div class="fw-bold text-success fs-5">
                            {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ar
                        </div>
                    </div>

                    @if ($paiement->observations)
                        <div class="col-12">
                            <small class="text-muted">Observations</small>
                            <div>{{ $paiement->observations }}</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Informations de l'élève --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Élève concerné</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <small class="text-muted">Nom et prénom</small>
                        <div class="fw-bold">
                            {{ $paiement->eleve?->nom }}
                            {{ $paiement->eleve?->prenom }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Matricule</small>
                        <div class="fw-semibold">
                            {{ $paiement->eleve?->matricule ?? 'Non renseigné' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Classe</small>
                        <div class="fw-semibold">
                            {{ $paiement->eleve?->classe?->nom ?? 'Non renseignée' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Détail des frais payés --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Détail des frais réglés</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Désignation</th>
                                <th>Période</th>
                                <th class="text-end pe-3">Montant payé</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($paiement->details as $detail)
                                <tr>
                                    <td class="ps-3">
                                        {{ $detail->eleveFrais?->libelle ?? 'Frais scolaire' }}
                                    </td>

                                    <td>
                                        {{ $detail->eleveFrais?->cle_periode ?? '-' }}
                                    </td>

                                    <td class="text-end pe-3 fw-semibold">
                                        {{ number_format((float) $detail->montant_paye, 0, ',', ' ') }} Ar
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">
                                        Aucun détail disponible.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot class="table-light">
                            <tr>
                                <th colspan="2" class="ps-3">TOTAL PAYÉ</th>
                                <th class="text-end pe-3 text-success">
                                    {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ar
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Reçu --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Reçu de paiement</h5>
            </div>

            <div class="card-body">
                @if ($paiement->recu)
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <div class="text-muted small">Numéro du reçu</div>
                            <div class="fw-bold fs-5">
                                {{ $paiement->recu->numero_recu }}
                            </div>

                            <div class="text-muted small mt-1">
                                Émis le :
                                {{ $paiement->recu->date_emission?->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        @if ($paiement->statut === 'valide')
                            <a href="{{ route('frais.recus.imprimer', $paiement->recu) }}" target="_blank"
                                class="btn btn-success">
                                <i class="bi bi-printer"></i>
                                Imprimer le reçu
                            </a>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        Aucun reçu n'est associé à ce paiement.
                    </div>
                @endif
            </div>
        </div>

        {{-- Annulation --}}
        @if ($paiement->statut === 'annule' && $paiement->annulation)
            <div class="alert alert-danger">
                <h6 class="fw-bold">Paiement annulé</h6>
                <p class="mb-1">
                    <strong>Motif :</strong>
                    {{ $paiement->annulation->motif }}
                </p>
                <p class="mb-1">
                    <strong>Date :</strong>
                    {{ $paiement->annulation->date_annulation?->format('d/m/Y H:i') }}
                </p>
                <p class="mb-0">
                    <strong>Annulé par :</strong>
                    {{ $paiement->annulation->utilisateur?->name ?? 'Non renseigné' }}
                </p>
            </div>
        @endif

        {{-- Bouton d'annulation --}}
        @if ($paiement->statut === 'valide' && auth()->user()->aPermission('frais.paiements_annuler'))
            <div class="card border-danger shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold text-danger">Annuler ce paiement</h6>

                    <form method="POST" action="{{ route('frais.paiements.annuler', $paiement) }}"
                        onsubmit="return confirm('Confirmer l’annulation de ce paiement ?')">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Motif obligatoire de l'annulation
                            </label>

                            <textarea name="motif" class="form-control" rows="3" required maxlength="1000"
                                placeholder="Indiquez le motif de l'annulation..."></textarea>

                            @error('motif')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger">
                            Annuler le paiement
                        </button>
                    </form>
                </div>
            </div>
        @endif

    </div>
@endsection
