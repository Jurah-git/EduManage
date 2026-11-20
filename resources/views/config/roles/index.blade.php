@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-shield-lock me-2"></i>Gestion des rôles
                </h2>
                <p class="text-muted mb-0">
                    Créez et gérez les rôles des utilisateurs d’EduManage.
                </p>
            </div>

            <a href="{{ route('config.roles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Nouveau rôle
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Rôles enregistrés</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nom du rôle</th>
                                <th>Permissions</th>
                                <th>Type</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>

                                    <td>
                                        <span class="fw-semibold">
                                            {{ $role->name }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge text-bg-info">
                                            {{ $role->permissions_count }}
                                        </span>
                                    </td>

                                    <td>
                                        @if (mb_strtolower($role->name) === 'administrateur')
                                            <span class="badge text-bg-danger">
                                                Administrateur principal
                                            </span>
                                        @else
                                            <span class="badge text-bg-secondary">
                                                Rôle personnalisé
                                            </span>
                                        @endif
                                    </td>


                                    <td class="text-end pe-4">
                                        @if (mb_strtolower($role->name) === 'administrateur')
                                            <span class="text-muted small">
                                                <i class="bi bi-shield-lock"></i>
                                                Tous les droits
                                            </span>
                                        @else
                                            <a href="{{ route('config.roles.permissions.edit', $role) }}"
                                                class="btn btn-sm btn-outline-primary mb-1">
                                                <i class="bi bi-shield-check"></i>
                                                Gérer les permissions
                                            </a>

                                            <form action="{{ route('config.roles.destroy', $role) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce rôle ?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger mb-1">
                                                    <i class="bi bi-trash"></i>
                                                    Supprimer
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-shield display-5 text-muted"></i>
                                        <p class="mt-3 mb-1 fw-semibold">
                                            Aucun rôle enregistré.
                                        </p>
                                        <p class="text-muted mb-3">
                                            Créez votre premier rôle personnalisé.
                                        </p>
                                        <a href="{{ route('config.roles.create') }}" class="btn btn-primary">
                                            Créer un rôle
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
