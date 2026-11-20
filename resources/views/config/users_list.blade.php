@extends('layouts.app')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm border-0">

            {{-- EN-TÊTE --}}
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap gap-2">

                <h4 class="mb-0">
                    <i class="bi bi-people-fill"></i>
                    Gestion des utilisateurs
                </h4>

                <a href="{{ route('config.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-plus-fill"></i>
                    Ajouter un utilisateur
                </a>

            </div>

            <div class="card-body">

                {{-- MESSAGE --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- TABLEAU --}}
                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Utilisateur</th>
                                <th>Téléphone</th>
                                <th>Fonction</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th>Date de création</th>
                                <th class="text-center">Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($users as $user)
                                <tr>

                                    {{-- PHOTO ET IDENTITÉ --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-2">

                                            @if ($user->photo)
                                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo"
                                                    class="rounded-circle" style="width:45px;height:45px;object-fit:cover;">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=34495e&color=fff"
                                                    alt="Avatar" class="rounded-circle" style="width:45px;height:45px;">
                                            @endif

                                            <div>
                                                <div class="fw-semibold">
                                                    {{ $user->name }}
                                                </div>

                                                <small class="text-muted">
                                                    {{ $user->email }}
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    {{-- TÉLÉPHONE --}}
                                    <td>
                                        {{ $user->telephone ?: 'Non renseigné' }}
                                    </td>

                                    {{-- FONCTION --}}
                                    <td>
                                        {{ $user->fonction ?: 'Non renseignée' }}
                                    </td>

                                    {{-- RÔLE --}}
                                    <td>
                                        @if ($user->id == 1)
                                            <span class="badge bg-danger">Administrateur principal</span>
                                        @else
                                            @forelse($user->getRoleNames() as $role)
                                                <span class="badge bg-primary">{{ $role }}</span>
                                            @empty
                                                <span class="badge bg-secondary">Sans rôle</span>
                                            @endforelse
                                        @endif
                                    </td>

                                    {{-- STATUT --}}
                                    <td>
                                        @if ($user->statut)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>

                                    {{-- DATE --}}
                                    <td>
                                        {{ $user->created_at?->format('d/m/Y') }}
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-center">

                                        <div class="d-flex justify-content-center align-items-center gap-2">

                                            {{-- MODIFIER --}}
                                            <a href="{{ route('config.users.edit', $user) }}"
                                                class="btn btn-warning btn-sm" title="Modifier">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- SUPPRIMER --}}
                                            <form action="{{ route('config.users.delete', $user) }}" method="POST"
                                                class="m-0">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')"
                                                    class="btn btn-danger btn-sm" title="Supprimer"
                                                    @disabled($user->id == 1)>
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Aucun utilisateur trouvé.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="text-muted small mt-2">
                    Nombre total d'utilisateurs : <strong>{{ $users->count() }}</strong>
                </div>

            </div>

        </div>

    </div>

@endsection
