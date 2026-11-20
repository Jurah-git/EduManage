@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="card shadow border-0">

            <div class="card-header bg-dark text-white">

                <h4 class="mb-0">
                    📚 Coefficients par matière
                </h4>

            </div>

            <div class="card-body">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>Matière</th>

                            @if (auth()->user()->aPermission('coefficients.modifier'))
                                <th width="180">Action</th>
                            @endif
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($matieres as $matiere)
                            <tr>

                                <td>
                                    {{ $matiere->nom }}
                                </td>

                                @if (auth()->user()->aPermission('coefficients.modifier'))
                                    <td>

                                        <a href="{{ route('coefficients.edit', $matiere->id) }}"
                                            class="btn btn-primary btn-sm">

                                            Configurer

                                        </a>

                                    </td>
                                @endif

                            </tr>

                        @empty

                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    Aucune matière trouvée.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
