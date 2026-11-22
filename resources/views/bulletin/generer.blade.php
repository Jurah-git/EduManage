@extends('layouts.app')

@section('content')
    @php
        $peutVoir = auth()->user()->aPermission('bulletins.afficher');
        $peutGenerer = auth()->user()->aPermission('bulletins.creer');
        $peutTelecharger = auth()->user()->aPermission('bulletins.telecharger');
        $peutImprimer = auth()->user()->aPermission('bulletins.imprimer');

        $afficherActions = $peutVoir || $peutGenerer || $peutTelecharger || $peutImprimer;

        // Liste unique des classes présentes pour alimenter le filtre
        $classesFiltre = collect($eleves)
            ->map(fn($e) => $e->classe->nom ?? null)
            ->filter()
            ->unique()
            ->sort()
            ->values();
    @endphp

    <style>
        .bulletin-page {
            background-color: #f8fafc;
            min-height: calc(100vh - 60px);
        }
        .card-modern {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
            background: #ffffff;
        }
        .periode-pill {
            cursor: pointer;
            user-select: none;
            transition: all 0.2s ease;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 8px 16px;
            background-color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            color: #334155;
        }
        .periode-pill:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        .periode-pill input[type="checkbox"]:checked + span {
            color: #1d4ed8;
            font-weight: 600;
        }
        .periode-pill:has(input[type="checkbox"]:checked) {
            border-color: #2563eb;
            background-color: #eff6ff;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.12);
        }
        .avatar-initials {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .table-modern thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 16px;
        }
        .table-modern tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }
        .table-modern tbody tr:hover {
            background-color: #f8fafc;
        }
        .badge-classe {
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.82rem;
        }
        .btn-action {
            border-radius: 6px;
            font-weight: 500;
            padding: 5px 11px;
            font-size: 0.82rem;
            transition: transform 0.1s ease;
        }
        .btn-action:active {
            transform: scale(0.97);
        }
        .filter-control {
            border-radius: 8px;
            font-size: 0.85rem;
        }
    </style>

    <div class="bulletin-page py-4">
        <div class="container-fluid px-4">

            {{-- EN-TÊTE DE PAGE --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        📄 Génération des bulletins
                    </h3>
                    <p class="text-muted small mb-0">
                        Sélectionnez une ou plusieurs périodes puis choisissez l'action souhaitée pour chaque élève.
                    </p>
                </div>
                <div>
                    <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                        Affichés : <strong id="compteurEleves">{{ count($eleves) }}</strong> / {{ count($eleves) }} élève(s)
                    </span>
                </div>
            </div>

            {{-- ALERTE PÉRIODE --}}
            <div id="alertePeriode" class="alert alert-danger border-0 shadow-sm rounded-3 align-items-center mb-4" style="display:none;" role="alert">
                <strong>⚠️ Action requise :</strong> Veuillez sélectionner au moins une période avant de continuer.
            </div>

            <form id="formBulletin" method="POST" action="{{ route('bulletin.afficher') }}">
                @csrf

                {{-- CARTE CHOIX DES PÉRIODES --}}
                <div class="card card-modern mb-4">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">
                            🗓️ Choix des périodes
                        </span>
                        <button type="button" id="btnTogglePeriodes" class="btn btn-link btn-sm text-decoration-none p-0 fw-semibold">
                            Tout cocher / décocher
                        </button>
                    </div>

                    <div class="card-body px-4 py-3">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($periodes as $periode)
                                <label class="periode-pill">
                                    <input type="checkbox" class="form-check-input mt-0" name="periodes[]" value="{{ $periode->id }}">
                                    <span>{{ $periode->nom }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- CARTE TABLEAU DES ÉLÈVES --}}
                <div class="card card-modern">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                            <span class="fw-bold text-dark">
                                🎓 Liste des élèves
                            </span>

                            {{-- RECHERCHE, FILTRES ET TRI --}}
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <input type="text" id="searchEleve" class="form-control form-control-sm filter-control px-3"
                                    style="min-width: 210px;" placeholder="🔍 Nom, prénom...">

                                <select id="filterClasse" class="form-select form-select-sm filter-control" style="width: auto;">
                                    <option value="">Toutes les classes</option>
                                    @foreach ($classesFiltre as $nomClasse)
                                        <option value="{{ mb_strtolower($nomClasse) }}">{{ $nomClasse }}</option>
                                    @endforeach
                                    <option value="__non_affecte__">Non affecté</option>
                                </select>

                                <select id="filterStatut" class="form-select form-select-sm filter-control" style="width: auto;">
                                    <option value="">Tous les statuts</option>
                                    <option value="disponible">Bulletin disponible</option>
                                    <option value="non_genere">Non généré</option>
                                </select>

                                <select id="sortEleves" class="form-select form-select-sm filter-control" style="width: auto;">
                                    <option value="az">Ordre : A → Z</option>
                                    <option value="za">Ordre : Z → A</option>
                                    <option value="dispo_first">Disponibles d'abord</option>
                                    <option value="non_genere_first">Non générés d'abord</option>
                                </select>

                                <button type="button" id="btnResetFiltres" class="btn btn-light btn-sm border filter-control text-secondary"
                                    title="Réinitialiser les filtres">
                                    ↺ Réinitialiser
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-modern mb-0" id="tableEleves">
                            <thead>
                                <tr>
                                    <th>Élève</th>
                                    <th>Classe</th>
                                    @if ($afficherActions)
                                        <th class="text-end">Actions</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($eleves as $eleve)
                                    @php
                                        $bulletin = \App\Models\Bulletin::where('eleve_id', $eleve->id)->latest()->first();
                                        $initiales = strtoupper(mb_substr($eleve->nom, 0, 1) . mb_substr($eleve->prenom, 0, 1));
                                        $nomComplet = trim($eleve->nom . ' ' . $eleve->prenom);
                                        $classeSlug = $eleve->classe ? mb_strtolower($eleve->classe->nom) : '__non_affecte__';
                                        $statutSlug = $bulletin ? 'disponible' : 'non_genere';
                                    @endphp

                                    <tr class="eleve-row"
                                        data-nom="{{ mb_strtolower($nomComplet) }}"
                                        data-classe="{{ $classeSlug }}"
                                        data-statut="{{ $statutSlug }}">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-initials">
                                                    {{ $initiales }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark">
                                                        {{ $eleve->nom }} {{ $eleve->prenom }}
                                                    </div>
                                                    @if($bulletin)
                                                        <small class="text-success" style="font-size: 0.75rem;">● Bulletin disponible</small>
                                                    @else
                                                        <small class="text-muted" style="font-size: 0.75rem;">○ Non généré</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @if($eleve->classe)
                                                <span class="badge-classe">{{ $eleve->classe->nom }}</span>
                                            @else
                                                <span class="badge bg-light text-secondary border">Non affecté</span>
                                            @endif
                                        </td>

                                        @if ($afficherActions)
                                            <td class="text-end">
                                                <div class="d-inline-flex flex-wrap justify-content-end gap-1">

                                                    {{-- GENERER --}}
                                                    @if ($peutGenerer)
                                                        <button type="submit" name="eleve_id" value="{{ $eleve->id }}"
                                                            class="btn btn-success btn-sm btn-action">
                                                            ⚙️ Générer
                                                        </button>
                                                    @endif

                                                    {{-- VOIR --}}
                                                    @if ($peutVoir)
                                                        <button type="button" class="btn btn-primary btn-sm btn-action btn-voir"
                                                            data-eleve="{{ $eleve->id }}">
                                                            👁 Voir
                                                        </button>
                                                    @endif

                                                    {{-- TELECHARGER --}}
                                                    @if ($peutTelecharger && $bulletin)
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-warning btn-sm btn-action dropdown-toggle text-dark" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                📥 Télécharger
                                                            </button>

                                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                                <li>
                                                                    <a href="#" class="dropdown-item py-2 btn-download-png"
                                                                        data-eleve="{{ $eleve->id }}">
                                                                        🖼 Format PNG
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item py-2 btn-download-pdf"
                                                                        data-eleve="{{ $eleve->id }}">
                                                                        📄 Format PDF
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    {{-- IMPRIMER --}}
                                                    @if ($peutImprimer)
                                                        <button type="button" class="btn btn-outline-danger btn-sm btn-action btn-print"
                                                            data-eleve="{{ $eleve->id }}">
                                                            🖨 Imprimer
                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $afficherActions ? 3 : 2 }}" class="text-center py-5 text-muted">
                                            Aucun élève trouvé.
                                        </td>
                                    </tr>
                                @endforelse

                                <tr id="aucunResultatFiltre" style="display:none;">
                                    <td colspan="{{ $afficherActions ? 3 : 2 }}" class="text-center py-5 text-muted">
                                        Aucun élève ne correspond aux filtres sélectionnés.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function getPeriodes() {
            let ids = [];

            document.querySelectorAll('input[name="periodes[]"]:checked')
                .forEach(cb => ids.push(cb.value));

            return ids.join(',');
        }

        function afficherErreurPeriode() {
            const alerte = document.getElementById('alertePeriode');
            alerte.style.display = 'block';
            alerte.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Filtrage + Tri combinés
        function appliquerFiltresEtTri() {
            const tbody = document.querySelector('#tableEleves tbody');
            if (!tbody) return;

            const rows = Array.from(tbody.querySelectorAll('tr.eleve-row'));
            const terme = (document.getElementById('searchEleve')?.value || '').toLowerCase().trim();
            const classeChoisie = document.getElementById('filterClasse')?.value || '';
            const statutChoisie = document.getElementById('filterStatut')?.value || '';
            const ordre = document.getElementById('sortEleves')?.value || 'az';

            // Tri des lignes
            rows.sort((a, b) => {
                const nomA = a.dataset.nom || '';
                const nomB = b.dataset.nom || '';
                const statutA = a.dataset.statut || '';
                const statutB = b.dataset.statut || '';

                if (ordre === 'az') {
                    return nomA.localeCompare(nomB, 'fr', { sensitivity: 'base' });
                }
                if (ordre === 'za') {
                    return nomB.localeCompare(nomA, 'fr', { sensitivity: 'base' });
                }
                if (ordre === 'dispo_first') {
                    if (statutA === statutB) return nomA.localeCompare(nomB, 'fr', { sensitivity: 'base' });
                    return statutA === 'disponible' ? -1 : 1;
                }
                if (ordre === 'non_genere_first') {
                    if (statutA === statutB) return nomA.localeCompare(nomB, 'fr', { sensitivity: 'base' });
                    return statutA === 'non_genere' ? -1 : 1;
                }
                return 0;
            });

            let visibles = 0;
            const emptyRow = document.getElementById('aucunResultatFiltre');

            rows.forEach(row => {
                tbody.appendChild(row);

                const nom = row.dataset.nom || '';
                const classe = row.dataset.classe || '';
                const statut = row.dataset.statut || '';

                const matchNom = !terme || nom.includes(terme) || classe.includes(terme);
                const matchClasse = !classeChoisie || classe === classeChoisie;
                const matchStatut = !statutChoisie || statut === statutChoisie;

                const afficher = matchNom && matchClasse && matchStatut;
                row.style.display = afficher ? '' : 'none';
                if (afficher) visibles++;
            });

            if (emptyRow) {
                emptyRow.style.display = visibles === 0 ? '' : 'none';
            }

            const compteur = document.getElementById('compteurEleves');
            if (compteur) {
                compteur.textContent = visibles;
            }
        }

        document.getElementById('searchEleve')?.addEventListener('input', appliquerFiltresEtTri);
        document.getElementById('filterClasse')?.addEventListener('change', appliquerFiltresEtTri);
        document.getElementById('filterStatut')?.addEventListener('change', appliquerFiltresEtTri);
        document.getElementById('sortEleves')?.addEventListener('change', appliquerFiltresEtTri);

        document.getElementById('btnResetFiltres')?.addEventListener('click', function() {
            document.getElementById('searchEleve').value = '';
            document.getElementById('filterClasse').value = '';
            document.getElementById('filterStatut').value = '';
            document.getElementById('sortEleves').value = 'az';
            appliquerFiltresEtTri();
        });

        // Appliquer le tri A -> Z au chargement
        appliquerFiltresEtTri();

        // Masquer l'alerte dès qu'une période est cochée
        document.querySelectorAll('input[name="periodes[]"]').forEach(cb => {
            cb.addEventListener('change', () => {
                if (getPeriodes()) {
                    document.getElementById('alertePeriode').style.display = 'none';
                }
            });
        });

        // Tout cocher / décocher
        document.getElementById('btnTogglePeriodes')?.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('input[name="periodes[]"]');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
            if (!allChecked) {
                document.getElementById('alertePeriode').style.display = 'none';
            }
        });

        // Vérification aussi lors du clic sur "Générer" (submit)
        document.getElementById('formBulletin').addEventListener('submit', function(e) {
            if (!getPeriodes()) {
                e.preventDefault();
                afficherErreurPeriode();
            }
        });

        document.querySelectorAll('.btn-voir').forEach(btn => {
            btn.addEventListener('click', function() {
                let periodes = getPeriodes();

                if (!periodes) {
                    afficherErreurPeriode();
                    return;
                }

                window.location.href =
                    '/bulletin/voir-direct?eleve_id=' +
                    this.dataset.eleve +
                    '&periodes=' + encodeURIComponent(periodes);
            });
        });

        document.querySelectorAll('.btn-print').forEach(btn => {
            btn.addEventListener('click', function() {
                let periodes = getPeriodes();

                if (!periodes) {
                    afficherErreurPeriode();
                    return;
                }

                window.open(
                    '/bulletin/print-direct?eleve_id=' +
                    this.dataset.eleve +
                    '&periodes=' + encodeURIComponent(periodes),
                    '_blank'
                );
            });
        });

        document.querySelectorAll('.btn-download-png').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                let periodes = getPeriodes();

                if (!periodes) {
                    afficherErreurPeriode();
                    return;
                }

                window.location.href =
                    '/bulletin/download-direct-png?eleve_id=' +
                    this.dataset.eleve +
                    '&periodes=' + encodeURIComponent(periodes);
            });
        });

        document.querySelectorAll('.btn-download-pdf').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                let periodes = getPeriodes();

                if (!periodes) {
                    afficherErreurPeriode();
                    return;
                }

                window.location.href =
                    '/bulletin/download-direct-pdf?eleve_id=' +
                    this.dataset.eleve +
                    '&periodes=' + encodeURIComponent(periodes);
            });
        });
    </script>
@endsection