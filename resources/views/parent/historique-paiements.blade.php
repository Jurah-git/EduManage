
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- EN-TÊTE --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-receipt text-primary me-2"></i>
                Historique des paiements
            </h2>

            <p class="text-muted mb-0">
                Consultez l'ensemble des paiements scolaires de vos enfants.
            </p>
        </div>

        <a href="{{ route('parent.dashboard') }}"
           class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-2"></i>
            Retour
        </a>
    </div>

    @php
        $paiementsValides = $paiements->where('statut', 'valide');

        $totalValide = $paiementsValides->sum('montant_total');

        $totalAnnule = $paiements
            ->where('statut', 'annule')
            ->sum('montant_total');
    @endphp

    {{-- CARTES STATISTIQUES --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-2">Nombre de paiements</p>
                            <h3 class="fw-bold mb-0">
                                {{ $paiements->count() }}
                            </h3>
                        </div>

                        <div class="rounded-3 bg-primary-subtle text-primary p-3">
                            <i class="fas fa-receipt fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-2">Paiements validés</p>
                            <h3 class="fw-bold text-success mb-0">
                                {{ $paiementsValides->count() }}
                            </h3>
                        </div>

                        <div class="rounded-3 bg-success-subtle text-success p-3">
                            <i class="fas fa-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-2">Total validé</p>
                            <h4 class="fw-bold text-success mb-0">
                                {{ number_format((float) $totalValide, 0, ',', ' ') }} Ar
                            </h4>
                        </div>

                        <div class="rounded-3 bg-success-subtle text-success p-3">
                            <i class="fas fa-wallet fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-2">Total annulé</p>
                            <h4 class="fw-bold text-danger mb-0">
                                {{ number_format((float) $totalAnnule, 0, ',', ' ') }} Ar
                            </h4>
                        </div>

                        <div class="rounded-3 bg-danger-subtle text-danger p-3">
                            <i class="fas fa-ban fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- LISTE DES PAIEMENTS PAR ENFANT --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-transparent border-bottom py-3">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-history text-primary me-2"></i>
                Détail de l'historique
            </h5>
        </div>

        <div class="card-body p-4">

            @forelse($eleves as $eleve)

                @php
                    $paiementsEleve = $paiements
                        ->where('eleve_id', $eleve->id);

                    $totalEleve = $paiementsEleve
                        ->where('statut', 'valide')
                        ->sum('montant_total');
                @endphp

                <div class="mb-4">

                    {{-- INFORMATIONS ENFANT --}}
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">

                        <div>
                            <h6 class="fw-bold mb-1">
                                <i class="fas fa-user-graduate text-primary me-2"></i>
                                {{ $eleve->nom }} {{ $eleve->prenom }}
                            </h6>

                            <small class="text-muted">
                                Classe :
                                {{ $eleve->classe->nom ?? 'Non renseignée' }}
                            </small>
                        </div>

                        <div class="text-end">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                {{ $paiementsEleve->count() }} paiement(s)
                            </span>

                            <div class="small text-success fw-bold mt-1">
                                Total validé :
                                {{ number_format((float) $totalEleve, 0, ',', ' ') }} Ar
                            </div>
                        </div>

                    </div>

                    {{-- TABLEAU --}}
                    @if($paiementsEleve->isEmpty())

                        <div class="border rounded-3 p-4 text-center">
                            <i class="fas fa-receipt text-muted fs-3 mb-2"></i>

                            <p class="text-muted mb-0">
                                Aucun paiement enregistré pour cet enfant.
                            </p>
                        </div>

                    @else

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">

                                <thead class="table-light">
                                    <tr>
                                        <th>Numéro</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Mode de paiement</th>
                                        <th>Frais concernés</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($paiementsEleve as $paiement)

                                        <tr>

                                            <td>
                                                <span class="fw-semibold">
                                                    {{ $paiement->numero_paiement }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="text-nowrap">
                                                    {{ $paiement->date_paiement
                                                        ? $paiement->date_paiement->format('d/m/Y H:i')
                                                        : '—' }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="fw-bold text-nowrap">
                                                    {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ar
                                                </span>
                                            </td>

                                            <td>
                                                {{ $paiement->mode_paiement
                                                    ? ucfirst(str_replace('_', ' ', $paiement->mode_paiement))
                                                    : '—' }}
                                            </td>

                                            <td>
                                                @forelse($paiement->details as $detail)

                                                    <div class="small mb-1">
                                                        <span class="fw-semibold">
                                                            {{ $detail->eleveFrais->libelle ?? 'Frais scolaire' }}
                                                        </span>

                                                        <div class="text-muted">
                                                            {{ number_format((float) $detail->montant_paye, 0, ',', ' ') }} Ar
                                                        </div>
                                                    </div>

                                                @empty

                                                    <span class="text-muted small">
                                                        Non détaillé
                                                    </span>

                                                @endforelse
                                            </td>

                                            <td>
                                                @if($paiement->statut === 'valide')

                                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Validé
                                                    </span>

                                                @else

                                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        Annulé
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

                @if(!$loop->last)
                    <hr class="my-4">
                @endif

            @empty

                <div class="text-center py-5">

                    <div class="mb-3">
                        <i class="fas fa-user-graduate text-muted" style="font-size: 55px;"></i>
                    </div>

                    <h5 class="fw-bold">
                        Aucun enfant associé
                    </h5>

                    <p class="text-muted mb-0">
                        Aucun enfant n'est actuellement lié à votre compte parent.
                    </p>

                </div>

            @endforelse

        </div>
    </div>

    {{-- NOTE --}}
    <div class="alert alert-info border-0 rounded-3 mt-4">
        <i class="fas fa-info-circle me-2"></i>
        Cette page est réservée à la consultation. Pour toute question concernant
        un paiement, veuillez contacter l'administration de l'établissement.
    </div>

</div>

@endsection
