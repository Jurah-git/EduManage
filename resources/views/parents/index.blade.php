@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4 parents-page">

        {{-- En-tête --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1 page-title">
                    <i class="bi bi-people-fill me-2"></i>
                    Gestion des parents
                </h2>
                <p class="text-secondary mb-0">
                    Gérez les responsables légaux et leurs enfants.
                </p>
            </div>

            <a href="{{ route('parents.create') }}" class="btn btn-primary px-4">
                <i class="bi bi-person-plus-fill me-2"></i>
                Ajouter un parent
            </a>
        </div>

        {{-- Message de confirmation --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Carte principale --}}
        <div class="card border-0 shadow-sm parents-card">

            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h5 class="fw-bold mb-1">Liste des parents</h5>
                        <small class="text-secondary">
                            {{ $parents->total() }}
                            parent(s) enregistré(s)
                        </small>
                    </div>

                    <div class="input-group search-box">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" id="rechercheParent" class="form-control"
                            placeholder="Rechercher dans cette page...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0 parents-table">
                    <thead>
                        <tr>
                            <th>Parent</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Profession</th>
                            <th class="text-center">Enfants</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="tableauParents">
                        @forelse ($parents as $parent)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="parent-avatar">
                                            {{ strtoupper(mb_substr($parent->prenom, 0, 1)) }}{{ strtoupper(mb_substr($parent->nom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold parent-name">
                                                {{ $parent->nom }} {{ $parent->prenom }}
                                            </div>
                                            <small class="text-secondary">
                                                Parent #{{ $parent->id }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $parent->telephone ?: 'Non renseigné' }}</td>

                                <td>{{ $parent->email ?: 'Non renseigné' }}</td>

                                <td>{{ $parent->profession ?: 'Non renseignée' }}</td>

                                <td class="text-center">
                                    <span class="badge rounded-pill children-badge">
                                        {{ $parent->eleves_count }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('parents.show', $parent) }}"
                                            class="btn btn-sm btn-light action-btn" title="Consulter"
                                            aria-label="Consulter">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('parents.edit', $parent) }}"
                                            class="btn btn-sm btn-light action-btn" title="Modifier" aria-label="Modifier">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('parents.destroy', $parent) }}" method="POST"
                                            onsubmit="return confirm('Voulez-vous vraiment supprimer cette fiche parent ?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-light text-danger action-btn"
                                                title="Supprimer" aria-label="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-people display-5 text-secondary"></i>
                                    <h6 class="fw-bold mt-3">Aucun parent enregistré</h6>
                                    <p class="text-secondary mb-3">
                                        Commencez par ajouter la première fiche parent.
                                    </p>
                                    <a href="{{ route('parents.create') }}" class="btn btn-primary">
                                        <i class="bi bi-person-plus me-2"></i>
                                        Ajouter un parent
                                    </a>
                                </td>
                            </tr>
                        @endforelse

                        <tr id="aucunResultat" style="display:none">
                            <td colspan="6" class="text-center py-4 text-secondary">
                                Aucun parent ne correspond à votre recherche.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($parents->hasPages())
                <div class="card-footer bg-white border-0 p-4">
                    {{ $parents->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .parents-page {
            color: #243447;
        }

        .page-title {
            color: #102a43;
        }

        .parents-page .btn-primary {
            background: #102a43;
            border-color: #102a43;
            border-radius: 8px;
        }

        .parents-page .btn-primary:hover {
            background: #183f60;
            border-color: #183f60;
        }

        .parents-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .search-box {
            max-width: 320px;
        }

        .search-box .form-control,
        .search-box .input-group-text {
            border-color: #dbe3ec;
        }

        .parents-table thead th {
            background: #f3f6fa;
            color: #526579;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 15px 18px;
            white-space: nowrap;
        }

        .parents-table tbody td {
            padding: 15px 18px;
            border-color: #edf1f5;
        }

        .parents-table tbody tr:hover {
            background: #f8fbff;
        }

        .parent-avatar {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #e7eef7;
            color: #102a43;
            font-weight: 700;
        }

        .children-badge {
            background: #e7eef7;
            color: #102a43;
            font-size: 13px;
            padding: 7px 11px;
        }

        .action-btn {
            border: 1px solid #e3e9ef;
            border-radius: 7px;
        }

        .action-btn:hover {
            background: #eaf0f7;
        }

        @media (max-width: 768px) {
            .search-box {
                max-width: 100%;
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recherche = document.getElementById('rechercheParent');
            const tableau = document.getElementById('tableauParents');
            const aucuneLigne = document.getElementById('aucunResultat');

            if (!recherche || !tableau) return;

            recherche.addEventListener('input', function() {
                const terme = this.value
                    .toLocaleLowerCase('fr')
                    .trim();

                const lignes = tableau.querySelectorAll(
                    'tr:not(#aucunResultat)'
                );

                let resultats = 0;

                lignes.forEach(function(ligne) {
                    const texte = ligne.textContent
                        .toLocaleLowerCase('fr');

                    const correspond = texte.includes(terme);

                    ligne.style.display = correspond ? '' : 'none';

                    if (correspond) {
                        resultats++;
                    }
                });

                if (aucuneLigne) {
                    aucuneLigne.style.display =
                        resultats === 0 ? '' : 'none';
                }
            });
        });
    </script>
@endsection
