@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                👥 Liste des utilisateurs
            </h4>

            <a href="{{ route('config.users.create') }}"
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

                        
                        <th>Nom</th>
                        <th>Email</th>
                        <th width="150">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>

                            

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>

                                <form
                                    action="{{ route('config.users.delete', $user) }}"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Supprimer cet utilisateur ?')"
                                        class="btn btn-danger btn-sm">

                                        Supprimer

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center">

                                Aucun utilisateur trouvé

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection