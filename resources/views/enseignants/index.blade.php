@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <h2 class="mb-0"><i class="bi bi-people"></i> Liste des enseignants</h2>

            <a href="{{ route('enseignants.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Ajouter un enseignant
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('enseignants.index') }}" method="GET" class="row g-2">
                    <div class="col-md-9">
                        <input type="search" name="recherche" class="form-control" value="{{ $recherche }}"
                            placeholder="Rechercher par matricule, nom, prénom, spécialité ou téléphone...">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-primary flex-fill" type="submit">
                            <i class="bi bi-search"></i> Rechercher
                        </button>
                        <a href="{{ route('enseignants.index') }}" class="btn btn-outline-secondary">
                            Effacer
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <span><i class="bi bi-table"></i> Enseignants enregistrés</span>
                <span>{{ $enseignants->total() }} résultat(s)</span>
            </div>

            <div class="card-body">
                @if ($enseignants->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Photo</th>
                                    <th>Matricule</th>
                                    <th>Nom et prénom</th>
                                    <th>Spécialité</th>
                                    <th>Téléphone</th>
                                    <th>Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($enseignants as $enseignant)
                                    <tr>
                                        <td class="text-center">
                                            @if ($enseignant->photo)
                                                <img src="{{ asset('storage/' . $enseignant->photo) }}" alt="Photo"
                                                    width="48" height="48" class="rounded-circle border"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center"
                                                    style="width:48px;height:48px;">
                                                    <i class="bi bi-person text-secondary fs-4"></i>
                                                </div>
                                            @endif
                                        </td>

                                        <td><strong>{{ $enseignant->matricule }}</strong></td>
                                        <td>{{ $enseignant->nom }} {{ $enseignant->prenom }}</td>
                                        <td>{{ $enseignant->specialite ?: '—' }}</td>
                                        <td>{{ $enseignant->telephone ?: '—' }}</td>

                                        <td>
                                            @if ($enseignant->statut === 'actif')
                                                <span class="badge bg-success">Actif</span>
                                            @else
                                                <span class="badge bg-secondary">Inactif</span>
                                            @endif
                                        </td>

                                        <td class="text-center text-nowrap">
                                            <a href="{{ route('enseignants.show', $enseignant) }}"
                                                class="btn btn-sm btn-info" title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('enseignants.edit', $enseignant) }}"
                                                class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('enseignants.destroy', $enseignant) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer cet enseignant ?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $enseignants->links() }}
                    </div>
                @else
                    <div class="alert alert-info text-center mb-0">
                        <i class="bi bi-info-circle"></i>
                        Aucun enseignant trouvé.
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
