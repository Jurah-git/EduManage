@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        {{-- En-tête --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-wallet2 text-primary"></i>
                    Situations financières
                </h3>
                <p class="text-muted mb-0">
                    Consultez les frais scolaires, les paiements et les soldes des élèves.
                </p>
            </div>
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

        {{-- Indicateurs --}}
        @php
            $totalGeneralDu = $totalGeneralDu ?? 0;
            $totalGeneralPaye = $totalGeneralPaye ?? 0;
            $totalGeneralReste = $totalGeneralReste ?? 0;
        @endphp

        <div class="row g-3 mb-4">

            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Total des frais dus</p>
                            <h4 class="fw-bold mb-0 text-primary">
                                {{ number_format($totalGeneralDu, 0, ',', ' ') }} Ar
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
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Total des paiements</p>
                            <h4 class="fw-bold mb-0 text-success">
                                {{ number_format($totalGeneralPaye, 0, ',', ' ') }} Ar
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
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Reste total à payer</p>
                            <h4 class="fw-bold mb-0 text-danger">
                                {{ number_format($totalGeneralReste, 0, ',', ' ') }} Ar
                            </h4>
                        </div>
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                            <i class="bi bi-exclamation-circle text-danger fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Liste des élèves --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold mb-0">Liste des situations financières</h5>
                    <span class="badge bg-primary">
                        {{ $eleves->total() }} élève(s)
                    </span>
                </div>
            </div>

            <div class="card-body">

                {{-- Recherche et filtres --}}

                <form method="GET" action="{{ route('frais.situations.index') }}" class="row g-3 mb-4">

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Rechercher un élève</label>
                        <input type="text" name="recherche" class="form-control"
                            placeholder="Nom, prénom ou matricule..." value="{{ request('recherche') }}">
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Classe</label>
                        <select name="classe_id" class="form-select">
                            <option value="">Toutes les classes</option>
                            @foreach ($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Année scolaire</label>
                        <select name="annee" class="form-select">
                            <option value="">Toutes les années</option>
                            @foreach ($annees as $annee)
                                <option value="{{ $annee }}" {{ request('annee') == $annee ? 'selected' : '' }}>
                                    {{ $annee }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Situation</label>
                        <select name="statut" class="form-select">
                            <option value="">Toutes</option>
                            <option value="impaye" {{ request('statut') == 'impaye' ? 'selected' : '' }}>
                                Impayé
                            </option>
                            <option value="partiel" {{ request('statut') == 'partiel' ? 'selected' : '' }}>
                                Partiel
                            </option>
                            <option value="paye" {{ request('statut') == 'paye' ? 'selected' : '' }}>
                                Payé
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search"></i> Filtrer
                        </button>

                        <a href="{{ route('frais.situations.index') }}" class="btn btn-outline-secondary"
                            title="Réinitialiser">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>

                </form>


                {{-- Tableau --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Élève</th>
                                <th>Matricule</th>
                                <th>Classe</th>
                                <th class="text-end">Total dû</th>
                                <th class="text-end">Total payé</th>
                                <th class="text-end">Reste à payer</th>
                                <th>Situation</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($eleves as $eleve)
                                @php
                                    if ($eleve->total_du <= 0 && $eleve->total_paye <= 0) {
                                        $statut = 'aucun';
                                    } elseif ($eleve->reste_a_payer <= 0.009) {
                                        $statut = 'paye';
                                    } elseif ($eleve->total_paye > 0) {
                                        $statut = 'partiel';
                                    } else {
                                        $statut = 'impaye';
                                    }
                                @endphp

                                <tr>
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $eleve->nom }} {{ $eleve->prenom }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="text-muted">
                                            {{ $eleve->matricule }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $eleve->classe->nom ?? '-' }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($eleve->total_du, 0, ',', ' ') }} Ar
                                    </td>

                                    <td class="text-end text-success fw-semibold">
                                        {{ number_format($eleve->total_paye, 0, ',', ' ') }} Ar
                                    </td>

                                    <td class="text-end text-danger fw-semibold">
                                        {{ number_format($eleve->reste_a_payer, 0, ',', ' ') }} Ar
                                    </td>

                                    <td>
                                        @if ($statut === 'aucun')
                                            <span class="badge bg-secondary">Aucun frais</span>
                                        @elseif($statut === 'paye')
                                            <span class="badge bg-success">Payé</span>
                                        @elseif($statut === 'partiel')
                                            <span class="badge bg-warning text-dark">Partiel</span>
                                        @else
                                            <span class="badge bg-danger">Impayé</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('frais.situations.show', $eleve->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Voir la situation financière">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Aucun élève trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $eleves->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
