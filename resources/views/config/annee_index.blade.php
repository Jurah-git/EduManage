```blade
@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                <i class="bi bi-calendar3"></i>
                Années scolaires
            </h2>

            <a href="{{ route('config.annees-scolaires.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Ajouter une année
            </a>

        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow">

            <div class="card-body">

                @if ($annees->count())
                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-dark">

                                <tr>
                                    <th>#</th>
                                    <th>Année scolaire</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>État</th>
                                    <th class="text-center">Actions</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($annees as $annee)
                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            <strong>
                                                {{ $annee->nom }}
                                            </strong>
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($annee->date_debut)->format('d/m/Y') }}
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($annee->date_fin)->format('d/m/Y') }}
                                        </td>

                                        <td>

                                            @if ($annee->active)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i>
                                                    Année en cours
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    Inactive
                                                </span>
                                            @endif

                                        </td>

                                        <td class="text-center">

                                            <a href="{{ route('config.annees-scolaires.show', $annee) }}"
                                                class="btn btn-sm btn-info" title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('config.annees-scolaires.edit', $annee) }}"
                                                class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            @if (!$annee->active)
                                                <form action="{{ route('config.annees-scolaires.activer', $annee) }}"
                                                    method="POST" class="d-inline">

                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        title="Définir comme année en cours"
                                                        onclick="return confirm('Voulez-vous définir cette année scolaire comme année en cours ?')">
                                                        <i class="bi bi-check2-circle"></i>
                                                    </button>

                                                </form>

                                                <form action="{{ route('config.annees-scolaires.destroy', $annee) }}"
                                                    method="POST" class="d-inline">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer cette année scolaire ?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                </form>
                                            @endif

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>
                @else
                    <div class="alert alert-info text-center mb-0">

                        <i class="bi bi-info-circle"></i>

                        Aucune année scolaire n'a encore été enregistrée.

                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection
```
