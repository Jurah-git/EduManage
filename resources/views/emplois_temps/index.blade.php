@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-calendar-week me-2 text-primary"></i>
                    Emplois du temps
                </h2>
                <p class="text-muted mb-0">
                    Gestion des emplois du temps par classe et par année scolaire.
                </p>
            </div>

            <a href="{{ route('emplois-temps.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Nouvel emploi du temps
            </a>
        </div>

        {{-- Message de succès --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Message d'erreur --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Filtres --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-funnel me-2"></i>Filtrer les emplois du temps
                </h6>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('emplois-temps.index') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label for="classe_id" class="form-label">Classe</label>
                            <select name="classe_id" id="classe_id" class="form-select">
                                <option value="">Toutes les classes</option>
                                @if (!empty($classes) && is_iterable($classes))
                                    @foreach (is_iterable($classes) ? $classes : [] as $classe)
                                        @php
                                            // Support objects, arrays or scalar values for $classe
                                            if (is_object($classe)) {
                                                $cValue = $classe->id ?? '';
                                                $cLabel = $classe->nom ?? ($classe->name ?? $cValue);
                                            } elseif (is_array($classe)) {
                                                $cValue = $classe['id'] ?? ($classe[0] ?? '');
                                                $cLabel = $classe['nom'] ?? ($classe['name'] ?? $cValue);
                                            } else {
                                                $cValue = $classe;
                                                $cLabel = $classe;
                                            }
                                        @endphp
                                        <option value="{{ $cValue }}" @selected(request('classe_id') == $cValue)>
                                            {{ $cLabel }}
                                        </option>
                                    @endforeach
                                @else
                                    {{-- Ensure template won't break if $classes is not iterable --}}
                                    <option value="">Aucune classe disponible</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="annee_scolaire_id" class="form-label">
                                Année scolaire
                            </label>
                            <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select">
                                <option value="">Toutes les années</option>
                                @if (!empty($anneesScolaires) && is_iterable($anneesScolaires))
                                    @foreach ($anneesScolaires as $annee)
                                        <option value="{{ $annee->id }}" @selected(request('annee_scolaire_id') == $annee->id)>
                                            {{ $annee->nom ?? ($annee->libelle ?? ($annee->annee ?? $annee->id)) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-select">
                                <option value="">Tous</option>
                                <option value="brouillon" @selected(request('statut') === 'brouillon')>
                                    Brouillon
                                </option>
                                <option value="publie" @selected(request('statut') === 'publie')>
                                    Publié
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-search"></i>
                                Filtrer
                            </button>
                            <a href="{{ route('emplois-temps.index') }}" class="btn btn-outline-secondary"
                                title="Réinitialiser">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between
                    align-items-center">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-list-ul me-2"></i>Liste des emplois du temps
                </h6>
                <span class="badge bg-light text-dark border">
                    {{ $emploisTemps->total() }} résultat(s)
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">N°</th>
                                <th>Classe</th>
                                <th>Année scolaire</th>
                                <th>Titre</th>
                                <th>Créneaux</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($emploisTemps as $emploi)
                                <tr>
                                    <td class="ps-3">
                                        {{ $emploisTemps->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <span class="fw-semibold">
                                            {{ $emploi->classe->nom ?? 'Classe supprimée' }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $emploi->anneeScolaire->nom ??
                                            ($emploi->anneeScolaire->libelle ?? ($emploi->anneeScolaire->annee ?? 'Année scolaire')) }}
                                    </td>

                                    <td>
                                        {{ $emploi->titre ?: 'Emploi du temps général' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $emploi->creneaux_count }} créneau(x)
                                        </span>
                                    </td>

                                    <td>
                                        @if ($emploi->statut === 'publie')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Publié
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-pencil me-1"></i>Brouillon
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('emplois-temps.show', $emploi) }}"
                                                class="btn btn-sm btn-outline-primary" title="Consulter">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            @if ($emploi->statut !== 'publie')
                                                <a href="{{ route('emplois-temps.edit', $emploi) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Modifier">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="{{ route('emplois-temps.destroy', $emploi) }}" method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cet emploi du temps ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                        <h6 class="mt-3 fw-bold">
                                            Aucun emploi du temps trouvé
                                        </h6>
                                        <p class="text-muted mb-3">
                                            Crée ton premier emploi du temps pour commencer.
                                        </p>
                                        <a href="{{ route('emplois-temps.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Créer un emploi du temps
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($emploisTemps->hasPages())
                <div class="card-footer bg-white">
                    {{ $emploisTemps->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
