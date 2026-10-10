@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-door-open text-primary me-2"></i>Salles de classe
                </h2>
                <p class="text-muted mb-0">Gestion des salles de l'établissement.</p>
            </div>

            <a href="{{ route('salles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Ajouter une salle
            </a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('salles.index') }}" method="GET" class="row g-2">
                    <div class="col-md-7">
                        <input type="text" name="recherche" class="form-control"
                            placeholder="Rechercher par code, nom, bâtiment..." value="{{ request('recherche') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="statut" class="form-select">
                            <option value="">Tous les statuts</option>
                            @foreach (['Disponible', 'Maintenance', 'Indisponible'] as $statut)
                                <option value="{{ $statut }}" @selected(request('statut') === $statut)>
                                    {{ $statut }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-search me-1"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Nom de la salle</th>
                            <th>Bâtiment / Étage</th>
                            <th>Capacité</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($salles as $salle)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $salle->code }}</span></td>
                                <td class="fw-semibold">{{ $salle->nom }}</td>
                                <td>
                                    {{ $salle->batiment ?: '—' }}
                                    @if ($salle->etage)
                                        <div class="small text-muted">{{ $salle->etage }}</div>
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-people text-muted me-1"></i>
                                    {{ $salle->capacite }}
                                </td>
                                <td>{{ $salle->type }}</td>
                                <td>
                                    @php
                                        $couleur = match ($salle->statut) {
                                            'Disponible' => 'success',
                                            'Maintenance' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $couleur }}">
                                        {{ $salle->statut }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('salles.show', $salle) }}" class="btn btn-sm btn-outline-info"
                                            title="Détails">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('salles.edit', $salle) }}" class="btn btn-sm btn-outline-primary"
                                            title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('salles.destroy', $salle) }}" method="POST"
                                            onsubmit="return confirm('Voulez-vous vraiment supprimer cette salle ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Aucune salle enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($salles->hasPages())
                <div class="card-footer bg-white">
                    {{ $salles->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
