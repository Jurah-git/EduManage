@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-sm border-0">

            <!-- HEADER -->
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    📚 Liste des classes
                </h4>

                @if (auth()->user()->aPermission('classes.creer'))
                    <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">
                        ➕ Ajouter
                    </a>
                @endif

            </div>

            <!-- BODY -->
            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Nom classe</th>
                            <th width="200">Élèves</th>

                            @if (auth()->user()->aPermission('classes.modifier') || auth()->user()->aPermission('classes.supprimer'))
                                <th width="220">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($classes as $classe)
                            <tr>

                                <td>
                                    <strong>
                                        {{ $classe->nom }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $classe->eleves_count ?? 0 }}
                                        élève(s)
                                    </span>
                                </td>

                                @if (auth()->user()->aPermission('classes.modifier') || auth()->user()->aPermission('classes.supprimer'))
                                    <td>
                                        <div class="d-flex gap-2">

                                            <!-- MODIFIER -->
                                            @if (auth()->user()->aPermission('classes.modifier'))
                                                <a href="{{ route('classes.edit', $classe) }}"
                                                    class="btn btn-warning btn-sm">
                                                    Modifier
                                                </a>
                                            @endif

                                            <!-- DELETE -->
                                            @if (auth()->user()->aPermission('classes.supprimer'))
                                                <form action="{{ route('classes.destroy', $classe) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button onclick="return confirm('Supprimer cette classe ?')"
                                                        class="btn btn-danger btn-sm">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                @endif

                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Aucune classe trouvée
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
