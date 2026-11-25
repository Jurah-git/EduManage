@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">📊 Rapports financiers</h3>
                <p class="text-muted mb-0">Suivi des encaissements et des frais scolaires</p>
            </div>
            <a href="{{ route('frais.dashboard') }}" class="btn btn-outline-secondary">
                ← Retour au tableau de bord
            </a>
        </div>

        {{-- FILTRES --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-dark text-white fw-bold">
                🔎 Filtrer les rapports
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('frais.rapports.index') }}">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Année scolaire</label>
                            <select name="annee_scolaire_id" class="form-select">
                                <option value="">Toutes les années</option>
                                @foreach ($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}" @selected($filtres['annee_scolaire_id'] == $annee->id)>
                                        {{ $annee->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Classe</label>
                            <select name="classe_id" class="form-select">
                                <option value="">Toutes les classes</option>
                                @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}" @selected($filtres['classe_id'] == $classe->id)>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Caissier</label>
                            <select name="user_id" class="form-select">
                                <option value="">Tous les caissiers</option>
                                @foreach ($caissiers as $caissier)
                                    <option value="{{ $caissier->id }}" @selected($filtres['user_id'] == $caissier->id)>
                                        {{ $caissier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Date de début</label>
                            <input type="date" name="date_debut" class="form-control"
                                value="{{ $filtres['date_debut'] }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Date de fin</label>
                            <input type="date" name="date_fin" class="form-control" value="{{ $filtres['date_fin'] }}">
                        </div>

                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Appliquer
                            </button>

                            <a href="{{ route('frais.rapports.index') }}" class="btn btn-outline-secondary">
                                Réinitialiser
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- CARTES STATISTIQUES --}}
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total encaissé</div>
                        <h4 class="fw-bold text-success mt-2">
                            {{ number_format($totalEncaisse, 0, ',', ' ') }} Ar
                        </h4>
                        <small class="text-muted">
                            {{ $nombrePaiements }} paiement(s) concerné(s)
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Reste à payer</div>
                        <h4 class="fw-bold text-danger mt-2">
                            {{ number_format($totalImpayes, 0, ',', ' ') }} Ar
                        </h4>
                        <small class="text-muted">
                            Frais impayés et partiellement payés
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Frais impayés</div>
                        <h4 class="fw-bold text-warning mt-2">
                            {{ $nombreFraisImpayes }}
                        </h4>
                        <small class="text-muted">Frais sans règlement complet</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Paiements annulés</div>
                        <h4 class="fw-bold text-secondary mt-2">
                            {{ number_format($totalAnnule, 0, ',', ' ') }} Ar
                        </h4>
                        <small class="text-muted">
                            {{ $paiementsAnnules->count() }} paiement(s) annulé(s)
                        </small>
                    </div>
                </div>
            </div>

        </div>

        {{-- ENCAISSEMENTS JOURNALIERS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">
                📅 Encaissements par jour
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th class="text-end">Montant encaissé</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($encaissementsJournaliers as $ligne)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($ligne->date)->format('d/m/Y') }}</td>
                                <td class="text-end fw-bold text-success">
                                    {{ number_format($ligne->total, 0, ',', ' ') }} Ar
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">
                                    Aucun encaissement pour cette période.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ENCAISSEMENTS MENSUELS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">
                📈 Encaissements par mois
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mois</th>
                            <th class="text-end">Montant encaissé</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($encaissementsMensuels as $ligne)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $ligne->mois)->translatedFormat('F Y') }}
                                </td>
                                <td class="text-end fw-bold text-success">
                                    {{ number_format($ligne->total, 0, ',', ' ') }} Ar
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">
                                    Aucun encaissement pour cette période.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ENCAISSEMENTS PAR CLASSE ET CAISSIER --}}
        <div class="row g-4 mb-4">

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold">
                        🏫 Encaissements par classe
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Classe</th>
                                    <th class="text-end">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($encaissementsParClasse as $ligne)
                                    <tr>
                                        <td>{{ $ligne->nom }}</td>
                                        <td class="text-end fw-bold">
                                            {{ number_format($ligne->total, 0, ',', ' ') }} Ar
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            Aucune donnée disponible.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold">
                        👤 Encaissements par caissier
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Caissier</th>
                                    <th class="text-end">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($encaissementsParCaissier as $ligne)
                                    <tr>
                                        <td>{{ $ligne->name }}</td>
                                        <td class="text-end fw-bold">
                                            {{ number_format($ligne->total, 0, ',', ' ') }} Ar
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            Aucune donnée disponible.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- FRAIS IMPAYÉS ET PARTIELS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">
                ⚠️ Frais impayés et partiellement payés
                <span class="badge bg-warning text-dark ms-2">
                    {{ $fraisEnAttente->count() }}
                </span>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Frais</th>
                            <th class="text-end">Montant dû</th>
                            <th class="text-end">Déjà réglé</th>
                            <th class="text-end">Reste à payer</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fraisEnAttente as $frais)
                            <tr>
                                <td>
                                    {{ $frais->eleve->nom ?? '' }}
                                    {{ $frais->eleve->prenom ?? '' }}
                                </td>
                                <td>{{ $frais->eleve->classe->nom ?? '—' }}</td>
                                <td>{{ $frais->libelle }}</td>
                                <td class="text-end">
                                    {{ number_format($frais->montant_du, 0, ',', ' ') }} Ar
                                </td>
                                <td class="text-end text-success">
                                    {{ number_format($frais->montant_regle, 0, ',', ' ') }} Ar
                                </td>
                                <td class="text-end fw-bold text-danger">
                                    {{ number_format($frais->reste_a_payer, 0, ',', ' ') }} Ar
                                </td>
                                <td>
                                    @if ($frais->statut === 'partiel')
                                        <span class="badge bg-warning text-dark">Partiel</span>
                                    @else
                                        <span class="badge bg-danger">Impayé</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-success py-3">
                                    Aucun frais restant à payer.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAIEMENTS ANNULÉS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">
                🚫 Historique des paiements annulés
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>N° paiement</th>
                            <th>Date</th>
                            <th>Élève</th>
                            <th>Caissier</th>
                            <th class="text-end">Montant</th>
                            <th>Motif d'annulation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiementsAnnules as $paiement)
                            <tr>
                                <td>{{ $paiement->numero_paiement }}</td>
                                <td>{{ $paiement->date_paiement?->format('d/m/Y') }}</td>
                                <td>
                                    {{ $paiement->eleve->nom ?? '' }}
                                    {{ $paiement->eleve->prenom ?? '' }}
                                </td>
                                <td>{{ $paiement->utilisateur->name ?? '—' }}</td>
                                <td class="text-end text-danger fw-bold">
                                    {{ number_format($paiement->montant_total, 0, ',', ' ') }} Ar
                                </td>
                                <td>
                                    {{ $paiement->annulation->motif ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Aucun paiement annulé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
