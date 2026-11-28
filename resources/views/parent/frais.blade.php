```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- EN-TÊTE --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-wallet text-primary me-2"></i>
                Frais et écolages
            </h2>
            <p class="text-muted mb-0">
                Situation financière de vos enfants.
            </p>
        </div>

        <a href="{{ route('parent.dashboard') }}"
           class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-2"></i>
            Retour
        </a>
    </div>

    @forelse($eleves as $eleve)

        @php
            $lignes = $fraisParEleve->get($eleve->id, collect());

            $totalDu = $lignes->sum(fn($f) => (float) $f->montant_du);
            $totalPaye = $lignes->sum(fn($f) => (float) $f->montant_paye);
            $reste = max(0, $totalDu - $totalPaye);
        @endphp

        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

            {{-- ENFANT --}}
            <div class="card-header bg-transparent border-bottom p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="fas fa-user-graduate text-primary me-2"></i>
                            {{ $eleve->nom }} {{ $eleve->prenom }}
                        </h5>

                        <small class="text-muted">
                            Matricule : {{ $eleve->matricule ?? 'Non renseigné' }}
                            @if($eleve->classe)
                                | Classe : {{ $eleve->classe->nom }}
                            @endif
                        </small>
                    </div>

                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                        {{ $lignes->count() }} frais
                    </span>
                </div>
            </div>

            <div class="card-body p-4">

                {{-- RÉSUMÉ --}}
                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <div class="rounded-3 p-3 bg-primary-subtle h-100">
                            <small class="text-muted">Total dû</small>
                            <h4 class="fw-bold text-primary mt-2 mb-0">
                                {{ number_format($totalDu, 0, ',', ' ') }} Ar
                            </h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="rounded-3 p-3 bg-success-subtle h-100">
                            <small class="text-muted">Total payé</small>
                            <h4 class="fw-bold text-success mt-2 mb-0">
                                {{ number_format($totalPaye, 0, ',', ' ') }} Ar
                            </h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="rounded-3 p-3 bg-warning-subtle h-100">
                            <small class="text-muted">Reste à payer</small>
                            <h4 class="fw-bold text-warning mt-2 mb-0">
                                {{ number_format($reste, 0, ',', ' ') }} Ar
                            </h4>
                        </div>
                    </div>

                </div>

                {{-- TABLEAU --}}
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-list-alt text-primary me-2"></i>
                    Détail des frais
                </h6>

                @if($lignes->isEmpty())

                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">
                            Aucun frais enregistré pour cet enfant.
                        </p>
                    </div>

                @else

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Libellé</th>
                                    <th>Échéance</th>
                                    <th class="text-end">Montant dû</th>
                                    <th class="text-end">Payé</th>
                                    <th class="text-end">Reste</th>
                                    <th class="text-center">Statut</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($lignes as $ligne)

                                    @php
                                        $enRetard = $ligne->date_echeance
                                            && $ligne->date_echeance->lt(now()->startOfDay())
                                            && $ligne->reste_a_payer > 0.009;
                                    @endphp

                                    <tr>
                                        <td>
                                            <span class="fw-semibold">
                                                {{ $ligne->libelle }}
                                            </span>

                                            @if($ligne->mois || $ligne->annee)
                                                <div class="small text-muted">
                                                    {{ $ligne->mois ? str_pad($ligne->mois, 2, '0', STR_PAD_LEFT).'/' : '' }}{{ $ligne->annee }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $ligne->date_echeance
                                                ? $ligne->date_echeance->format('d/m/Y')
                                                : '—' }}
                                        </td>

                                        <td class="text-end">
                                            {{ number_format((float)$ligne->montant_du, 0, ',', ' ') }} Ar
                                        </td>

                                        <td class="text-end text-success fw-semibold">
                                            {{ number_format((float)$ligne->montant_paye, 0, ',', ' ') }} Ar
                                        </td>

                                        <td class="text-end fw-bold">
                                            {{ number_format((float)$ligne->reste_a_payer, 0, ',', ' ') }} Ar
                                        </td>

                                        <td class="text-center">
                                            @if($ligne->statut_reel === 'paye')
                                                <span class="badge bg-success-subtle text-success rounded-pill">
                                                    Payé
                                                </span>
                                            @elseif($enRetard)
                                                <span class="badge bg-danger-subtle text-danger rounded-pill">
                                                    En retard
                                                </span>
                                            @elseif($ligne->statut_reel === 'partiel')
                                                <span class="badge bg-warning-subtle text-warning rounded-pill">
                                                    Partiel
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill">
                                                    Impayé
                                                </span>
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="2">TOTAL</td>
                                    <td class="text-end">
                                        {{ number_format($totalDu, 0, ',', ' ') }} Ar
                                    </td>
                                    <td class="text-end text-success">
                                        {{ number_format($totalPaye, 0, ',', ' ') }} Ar
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($reste, 0, ',', ' ') }} Ar
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                @endif

            </div>
        </div>

    @empty

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold">Aucun enfant associé</h5>
                <p class="text-muted mb-0">
                    Contactez l'administration de l'école.
                </p>
            </div>
        </div>

    @endforelse

    <div class="alert alert-info border-0 rounded-3">
        <i class="fas fa-info-circle me-2"></i>
        Cette page est réservée à la consultation.
        Pour toute question sur les frais, veuillez contacter l'administration.
    </div>

</div>
@endsection
```