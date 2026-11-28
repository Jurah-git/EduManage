
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- EN-TÊTE --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-megaphone text-primary me-2"></i>
                Gestion des annonces
            </h2>

            <p class="text-muted mb-0">
                Créez et gérez les communications de votre établissement.
            </p>
        </div>

        <a href="{{ route('annonces.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nouvelle annonce
        </a>

    </div>

    {{-- MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- STATISTIQUES --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total des annonces</p>
                            <h3 class="fw-bold mb-0">{{ $annonces->total() }}</h3>
                        </div>
                        <i class="bi bi-megaphone fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Publiées sur cette page</p>
                            <h3 class="fw-bold mb-0">
                                {{ $annonces->getCollection()->where('statut', 'publie')->count() }}
                            </h3>
                        </div>
                        <i class="bi bi-check-circle fs-1 text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Brouillons sur cette page</p>
                            <h3 class="fw-bold mb-0">
                                {{ $annonces->getCollection()->where('statut', 'brouillon')->count() }}
                            </h3>
                        </div>
                        <i class="bi bi-file-earmark-text fs-1 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLEAU --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-transparent py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Liste des annonces
            </h5>
        </div>

        <div class="card-body p-0">

            @if($annonces->count() > 0)

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Public</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($annonces as $annonce)

                                <tr>

                                    <td>
                                        <strong>{{ $annonce->titre }}</strong>
                                        <div class="small text-muted">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($annonce->contenu), 65) }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ ucfirst($annonce->categorie) }}
                                    </td>

                                    <td>
                                        @if($annonce->public_cible === 'parents')
                                            <span class="badge bg-info-subtle text-info">Parents</span>
                                        @else
                                            <span class="badge bg-primary-subtle text-primary">Tous</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($annonce->statut === 'publie')
                                            <span class="badge bg-success">Publiée</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Brouillon</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $annonce->date_publication?->format('d/m/Y H:i') ?? '—' }}
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end gap-1 flex-wrap">

                                            <a href="{{ route('annonces.edit', $annonce) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Modifier">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            @if($annonce->statut === 'brouillon')

                                                <form action="{{ route('annonces.publier', $annonce) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-success"
                                                            title="Publier">
                                                        <i class="bi bi-send"></i>
                                                    </button>
                                                </form>

                                            @else

                                                <form action="{{ route('annonces.depublier', $annonce) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-warning"
                                                            title="Retirer de la publication">
                                                        <i class="bi bi-eye-slash"></i>
                                                    </button>
                                                </form>

                                            @endif

                                            <form action="{{ route('annonces.destroy', $annonce) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette annonce ?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>

            @else

                <div class="text-center py-5">

                    <i class="bi bi-megaphone text-muted"
                       style="font-size: 3rem;"></i>

                    <h5 class="fw-bold mt-3">
                        Aucune annonce enregistrée
                    </h5>

                    <p class="text-muted">
                        Commencez par créer votre première annonce.
                    </p>

                    <a href="{{ route('annonces.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Créer une annonce
                    </a>

                </div>

            @endif

        </div>

        @if($annonces->hasPages())
            <div class="card-footer bg-transparent">
                {{ $annonces->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
