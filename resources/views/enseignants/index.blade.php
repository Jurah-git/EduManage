@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- EN-TÊTE --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">👨‍🏫 Liste des enseignants</h3>

            @if (auth()->user()->aPermission('enseignants.creer'))
                <a href="{{ route('enseignants.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter un enseignant
                </a>
            @endif
        </div>

        {{-- MESSAGES --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- RECHERCHE --}}
        <form method="GET" action="{{ route('enseignants.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Rechercher un enseignant..."
                    value="{{ request('search') }}">

                <button class="btn btn-dark" type="submit">
                    <i class="bi bi-search"></i> Rechercher
                </button>

                <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Réinitialiser
                </a>
            </div>
        </form>

        {{-- TABLEAU --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    Enseignants enregistrés
                    <span class="badge bg-light text-dark">
                        {{ $enseignants->total() }}
                    </span>
                </h5>
            </div>

            <div class="card-body">

                @php
                    $show = auth()->user()->aPermission('enseignants.show');
                    $modifier = auth()->user()->aPermission('enseignants.modifier');
                    $supprimer = auth()->user()->aPermission('enseignants.supprimer');

                    $afficherActions = $show || $modifier || $supprimer;
                @endphp

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Photo</th>
                                <th>Matricule</th>
                                <th>Nom et prénom</th>
                                <th>Spécialité</th>
                                <th>Téléphone</th>
                                <th>Statut</th>

                                @if ($afficherActions)
                                    <th class="text-center">Actions</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($enseignants as $enseignant)
                                <tr>
                                    {{-- PHOTO --}}
                                    <td class="text-center">
                                        @if ($enseignant->photo)
                                            <img src="{{ asset('storage/' . $enseignant->photo) }}" alt="Photo"
                                                width="45" height="45" class="rounded-circle"
                                                style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                                style="width:45px;height:45px;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>{{ $enseignant->matricule }}</td>

                                    <td>
                                        <strong>{{ $enseignant->nom }} {{ $enseignant->prenom }}</strong>
                                    </td>

                                    <td>{{ $enseignant->specialite ?? '-' }}</td>

                                    <td>{{ $enseignant->telephone ?? '-' }}</td>

                                    <td>
                                        @if ($enseignant->statut == 'actif')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-danger">Inactif</span>
                                        @endif
                                    </td>

                                    {{-- ACTIONS --}}
                                    @if ($afficherActions)
                                        <td class="text-center">

                                            {{-- VOIR LA FICHE --}}
                                            @if ($show)
                                                <a href="{{ route('enseignants.show', $enseignant) }}"
                                                    class="btn btn-sm btn-info text-white" title="Voir la fiche">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif

                                            {{-- MODIFIER --}}
                                            @if ($modifier)
                                                <a href="{{ route('enseignants.edit', $enseignant) }}"
                                                    class="btn btn-sm btn-warning" title="Modifier">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endif

                                            {{-- SUPPRIMER --}}
                                            @if ($supprimer)
                                                <form action="{{ route('enseignants.destroy', $enseignant) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer cet enseignant ?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    @endif
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="{{ $afficherActions ? 7 : 6 }}" class="text-center py-4">
                                        <i class="bi bi-info-circle"></i>
                                        Aucun enseignant trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="mt-3">
                    {{ $enseignants->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
