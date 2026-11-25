@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4">

        {{-- En-tête --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-person-vcard text-primary"></i>
                    Situation financière de l'élève
                </h3>
                <p class="text-muted mb-0">
                    Détail des frais scolaires et de l'historique des paiements.
                </p>
            </div>

            <a href="{{ route('frais.situations.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Retour à la liste
            </a>
        </div>

        {{-- Informations de l'élève --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center g-3">

                    <div class="col-auto">
                        @if ($eleve->photo)
                            <img src="{{ asset('storage/' . $eleve->photo) }}" alt="Photo de l'élève"
                                class="rounded-circle border" style="width: 85px; height: 85px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary
                                    d-flex align-items-center justify-content-center"
                                style="width: 85px; height: 85px;">
                                <i class="bi bi-person-fill fs-1"></i>
                            </div>
                        @endif
                    </div>

                    <div class="col">
                        <h4 class="fw-bold mb-1">
                            {{ $eleve->nom }} {{ $eleve->prenom }}
                        </h4>

                        <div class="text-muted">
                            <span class="me-3">
                                <i class="bi bi-card-text"></i>
                                Matricule : {{ $eleve->matricule }}
                            </span>

                            <span>
                                <i class="bi bi-mortarboard"></i>
                                Classe : {{ $eleve->classe->nom ?? '-' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Résumé financier --}}
        <div class="row g-3 mb-4">

            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total des frais dus</p>
                            <h4 class="fw-bold text-primary mb-0">
                                {{ number_format($totalDu, 0, ',', ' ') }} Ar
                            </h4>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="bi bi-receipt text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total des paiements</p>
                            <h4 class="fw-bold text-success mb-0">
                                {{ number_format($totalPaye, 0, ',', ' ') }} Ar
                            </h4>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="bi bi-cash-stack text-success fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Reste à payer</p>
                            <h4 class="fw-bold text-danger mb-0">
                                {{ number_format($resteTotal, 0, ',', ' ') }} Ar
                            </h4>
                        </div>
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                            <i class="bi bi-exclamation-circle text-danger fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Détail des frais --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-list-ul text-primary"></i>
                        Détail des frais scolaires
                    </h5>

                    <span class="badge bg-primary">
                        {{ $frais->count() }} ligne(s)
                    </span>
                </div>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Frais</th>
                                <th>Période</th>
                                <th>Échéance</th>
                                <th class="text-end">Montant dû</th>
                                <th class="text-end">Montant payé</th>
                                <th class="text-end">Reste</th>
                                <th>Situation</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($frais as $ligne)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $ligne->tarifFrais->typeFrais->nom ?? $ligne->libelle }}
                                        </div>
                                        @if ($ligne->libelle)
                                            <small class="text-muted">
                                                {{ $ligne->libelle }}
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $ligne->cle_periode ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $ligne->date_echeance ? $ligne->date_echeance->format('d/m/Y') : '-' }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($ligne->montant_du, 0, ',', ' ') }} Ar
                                    </td>

                                    <td class="text-end text-success fw-semibold">
                                        {{ number_format($ligne->montant_paye, 0, ',', ' ') }} Ar
                                    </td>

                                    <td class="text-end text-danger fw-semibold">
                                        {{ number_format($ligne->reste_a_payer, 0, ',', ' ') }} Ar
                                    </td>

                                    <td>
                                        @if ($ligne->statut_calcule === 'paye')
                                            <span class="badge bg-success">Payé</span>
                                        @elseif($ligne->statut_calcule === 'partiel')
                                            <span class="badge bg-warning text-dark">Partiel</span>
                                        @else
                                            <span class="badge bg-danger">Impayé</span>
                                        @endif
                                    </td>
                                </tr>

                                {{-- Historique des paiements de cette ligne --}}
                                @if ($ligne->detailsPaiements->isNotEmpty())
                                    <tr class="table-light">
                                        <td colspan="7" class="p-3">

                                            <div class="fw-semibold mb-2">
                                                <i class="bi bi-clock-history"></i>
                                                Historique des paiements
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered bg-white mb-0">

                                                    <thead>
                                                        <tr>
                                                            <th>N° paiement</th>
                                                            <th>Date</th>
                                                            <th>Mode</th>
                                                            <th>Caissier</th>
                                                            <th class="text-end">Montant</th>
                                                            <th>Statut</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($ligne->detailsPaiements as $detail)
                                                            @php
                                                                $paiement = $detail->paiement;
                                                            @endphp

                                                            @if ($paiement)
                                                                <tr>
                                                                    <td>
                                                                        {{ $paiement->numero_paiement }}
                                                                    </td>

                                                                    <td>
                                                                        {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : '-' }}
                                                                    </td>

                                                                    <td>
                                                                        {{ ucfirst($paiement->mode_paiement) }}
                                                                    </td>

                                                                    <td>
                                                                        {{ $paiement->utilisateur->name ?? '-' }}
                                                                    </td>

                                                                    <td class="text-end">
                                                                        {{ number_format($detail->montant_paye, 0, ',', ' ') }}
                                                                        Ar
                                                                    </td>

                                                                    <td>
                                                                        @if ($paiement->statut === 'valide')
                                                                            <span class="badge bg-success">Validé</span>
                                                                        @else
                                                                            <span class="badge bg-danger">Annulé</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                                {{-- Motif d'annulation --}}
                                                                @if ($paiement->statut === 'annule' && $paiement->annulation)
                                                                    <tr>
                                                                        <td colspan="6">
                                                                            <small class="text-danger">
                                                                                <strong>Motif d'annulation :</strong>
                                                                                {{ $paiement->annulation->motif ?? '-' }}
                                                                            </small>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>

                                        </td>
                                    </tr>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Aucun frais n'a été généré pour cet élève.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        {{-- Retour --}}
        <div class="d-flex justify-content-end">
            <a href="{{ route('frais.situations.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Retour à la liste
            </a>
        </div>

    </div>

@endsection
