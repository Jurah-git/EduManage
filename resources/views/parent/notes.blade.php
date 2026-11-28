
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- EN-TÊTE --}}
    <div class="mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-graduation-cap me-2 text-primary"></i>
            Notes et bulletins
        </h2>

        <p class="text-muted">
            Consultez les résultats scolaires de vos enfants.
        </p>
    </div>

    {{-- SÉLECTION DE L'ENFANT --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <form method="GET" action="{{ route('parent.notes.index') }}">

                <label class="form-label fw-semibold">
                    Sélectionner un enfant
                </label>

                <div class="d-flex gap-2 flex-wrap">

                    <select name="enfant"
                            class="form-select"
                            style="max-width:400px"
                            onchange="this.form.submit()">

                        @forelse($eleves as $eleve)

                            <option value="{{ $eleve->id }}"
                                @selected($enfant && $enfant->id == $eleve->id)>

                                {{ $eleve->prenom }} {{ $eleve->nom }}

                            </option>

                        @empty

                            <option value="">
                                Aucun enfant associé
                            </option>

                        @endforelse

                    </select>

                </div>
            </form>

            @if($enfant)

                <div class="mt-3 text-muted">
                    <i class="fas fa-user-graduate me-1"></i>

                    Élève :
                    <strong>
                        {{ $enfant->prenom }} {{ $enfant->nom }}
                    </strong>

                    @if($enfant->classe)
                        | Classe : {{ $enfant->classe->nom }}
                    @endif
                </div>

            @endif

        </div>
    </div>

    @if(!$enfant)

        <div class="alert alert-info rounded-4">
            Aucun enfant n'est associé à votre compte parent.
        </div>

    @else

        {{-- NOTES --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-transparent border-0 p-4">

                <h4 class="fw-bold mb-1">
                    <i class="fas fa-book-open text-primary me-2"></i>
                    Résultats scolaires
                </h4>

                <p class="text-muted mb-0">
                    Notes journalières et compositions.
                </p>

            </div>

            <div class="card-body p-4">

                @if($notes->isEmpty())

                    <div class="text-center py-4">

                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>

                        <p class="text-muted">
                            Aucune note disponible pour cet enfant.
                        </p>

                    </div>

                @else

                    @foreach($notes->groupBy(function ($note) {
                        return $note->periode
                            ? $note->periode->nom
                            : 'Période non définie';
                    }) as $periodeNom => $notesPeriode)

                        <h5 class="fw-bold mt-3 mb-3">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                            {{ $periodeNom }}
                        </h5>

                        <div class="table-responsive mb-4">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>
                                        <th>Matière</th>
                                        <th>Évaluation</th>
                                        <th>Note</th>
                                        <th>Coefficient</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($notesPeriode as $note)

                                        <tr>

                                            <td class="fw-semibold">
                                                {{ $note->matiere->nom ?? 'Matière inconnue' }}
                                            </td>

                                            <td>

                                                @if($note->type === 'composition')

                                                    <span class="badge bg-primary">
                                                        Composition
                                                    </span>

                                                @else

                                                    <span class="badge bg-info text-dark">
                                                        Journalier
                                                    </span>

                                                @endif

                                            </td>

                                            <td>

                                                <strong>
                                                    {{ rtrim(rtrim(number_format($note->valeur, 2, '.', ''), '0'), '.') }}
                                                    /
                                                    {{ rtrim(rtrim(number_format($note->base, 2, '.', ''), '0'), '.') }}
                                                </strong>

                                            </td>

                                            <td>
                                                {{ $note->coef }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endforeach

                @endif

            </div>
        </div>

        {{-- BULLETINS --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-transparent border-0 p-4">

                <h4 class="fw-bold mb-1">
                    <i class="fas fa-file-pdf text-danger me-2"></i>
                    Bulletins scolaires
                </h4>

                <p class="text-muted mb-0">
                    Bulletins enregistrés par l'établissement.
                </p>

            </div>

            <div class="card-body p-4">

                @if($bulletins->isEmpty())

                    <div class="text-center py-4">

                        <i class="fas fa-file-circle-xmark fa-3x text-muted mb-3"></i>

                        <p class="text-muted">
                            Aucun bulletin disponible pour cet enfant.
                        </p>

                    </div>

                @else

                    <div class="row g-4">

                        @foreach($bulletins as $bulletin)

                            <div class="col-12 col-md-6 col-xl-4">

                                <div class="border rounded-4 p-3 h-100">

                                    <div class="d-flex justify-content-between align-items-center mb-3">

                                        <strong>
                                            Bulletin #{{ $bulletin->id }}
                                        </strong>

                                        <span class="badge bg-success">
                                            Disponible
                                        </span>

                                    </div>

                                    <div class="mb-3">

                                        @forelse($bulletin->periode_noms as $periodeNom)

                                            <span class="badge bg-light text-dark border me-1 mb-1">
                                                {{ $periodeNom }}
                                            </span>

                                        @empty

                                            <span class="text-muted small">
                                                Période non précisée
                                            </span>

                                        @endforelse

                                    </div>

                                    @if($bulletin->image_src)

                                        <a href="{{ $bulletin->image_src }}"
                                           target="_blank"
                                           rel="noopener noreferrer">

                                            <img
                                                src="{{ $bulletin->image_src }}"
                                                alt="Bulletin scolaire"
                                                class="img-fluid rounded border"
                                                style="width:100%; max-height:450px; object-fit:contain;"
                                            >

                                        </a>

                                        <p class="text-muted small mt-2">
                                            Cliquez sur l'image pour l'ouvrir.
                                        </p>

                                    @else

                                        <div class="alert alert-warning">
                                            Image du bulletin indisponible.
                                        </div>

                                    @endif

                                    <div class="text-muted small mt-3">
                                        Enregistré le :
                                        {{ $bulletin->created_at?->format('d/m/Y') }}
                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>
        </div>

    @endif

</div>

@endsection
