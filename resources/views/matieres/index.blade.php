@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow border-0">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                📖 Liste des matières
            </h4>

            <a
                href="{{ route('matieres.create') }}"
                class="btn btn-primary btn-sm">

                ➕ Ajouter

            </a>

        </div>

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Code</th>

                        <th>Matière</th>


                        <th>Classes</th>


                        <th width="220">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($matieres as $matiere)

                        <tr>

                            <!-- CODE -->

                            <td>

                                <span class="badge bg-primary">

                                    {{ $matiere->code }}

                                </span>

                            </td>

                            <!-- NOM -->

                            <td>

                                <strong>

                                    {{ $matiere->nom }}

                                </strong>

                            </td>


                            <!-- CLASSES -->

                            <td>

                                @foreach($matiere->classes as $classe)

                                    <span class="badge bg-info text-dark mb-1">

                                        {{ $classe->nom }}

                                    </span>

                                @endforeach

                            </td>


                            <!-- ACTIONS -->

                            <td>

                                <div class="d-flex gap-2">

                                    <!-- EDIT -->

                                    <a
                                        href="{{ route('matieres.edit', $matiere) }}"
                                        class="btn btn-warning btn-sm">

                                        Modifier

                                    </a>

                                    <!-- DELETE -->

                                    <form
                                        action="{{ route('matieres.destroy', $matiere) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Supprimer cette matière ?')"
                                            class="btn btn-danger btn-sm">

                                            Supprimer

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted">

                                Aucune matière trouvée

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection