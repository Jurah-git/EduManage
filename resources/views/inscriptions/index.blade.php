@extends('layouts.app')

@section('content')
    <style>
        /* =========================================================
       INSCRIPTIONS - DESIGN
    ========================================================= */

        .ins-page {
            padding: 24px;
            color: #1e293b;
        }

        /* HEADER */
        .ins-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 28px;
        }

        .ins-header h2 {
            font-size: 27px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .ins-header p {
            color: #64748b;
            margin: 0;
            font-size: 14px;
        }

        .ins-btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 19px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white !important;
            text-decoration: none !important;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(37, 99, 235, .20);
            transition: .2s;
        }

        .ins-btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, .25);
        }

        /* STATISTICS */
        .ins-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }

        .ins-stat-card {
            background: #fff;
            border: 1px solid #e8edf4;
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .035);
            transition: .2s;
        }

        .ins-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(15, 23, 42, .07);
        }

        .ins-stat-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .ins-stat-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .ins-stat-green {
            background: #ecfdf5;
            color: #059669;
        }

        .ins-stat-orange {
            background: #fff7ed;
            color: #ea580c;
        }

        .ins-stat-purple {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .ins-stat-info span {
            display: block;
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .ins-stat-info h3 {
            margin: 0;
            font-size: 25px;
            font-weight: 800;
            color: #1e293b;
        }

        /* ALERTS */
        .ins-alert {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
        }

        /* FILTER CARD */
        .ins-filter-card {
            background: white;
            border: 1px solid #e8edf4;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 22px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .035);
        }

        .ins-filter-title {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 17px;
            color: #334155;
        }

        .ins-filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
            gap: 12px;
            align-items: end;
        }

        .ins-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 7px;
        }

        .ins-form-control {
            width: 100%;
            height: 43px;
            border: 1px solid #dce3ec;
            border-radius: 10px;
            padding: 0 12px;
            background: #fff;
            color: #334155;
            font-size: 13px;
            outline: none;
            transition: .2s;
        }

        .ins-form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .10);
        }

        .ins-filter-actions {
            display: flex;
            gap: 8px;
        }

        .ins-btn-filter {
            height: 43px;
            padding: 0 16px;
            border: none;
            border-radius: 10px;
            background: #1e293b;
            color: white;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
        }

        .ins-btn-reset {
            height: 43px;
            width: 43px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            border: 1px solid #dce3ec;
            color: #64748b;
            text-decoration: none;
            background: #fff;
        }

        /* TABLE CARD */
        .ins-table-card {
            background: white;
            border: 1px solid #e8edf4;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .035);
        }

        .ins-table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 22px;
            flex-wrap: wrap;
            gap: 10px;
            border-bottom: 1px solid #edf1f6;
        }

        .ins-table-header h5 {
            font-size: 16px;
            font-weight: 800;
            margin: 0;
            color: #1e293b;
        }

        .ins-table-header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #94a3b8;
        }

        .ins-count-badge {
            background: #eff6ff;
            color: #2563eb;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
        }

        .ins-table-scroll {
            max-height: 560px;
            overflow: auto;
        }

        .ins-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 950px;
        }

        .ins-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f8fafc;
            padding: 13px 16px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 800;
            color: #64748b;
            border-bottom: 1px solid #e8edf4;
            white-space: nowrap;
        }

        .ins-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f0f3f7;
            vertical-align: middle;
            font-size: 13px;
            color: #475569;
        }

        .ins-table tbody tr {
            transition: .15s;
        }

        .ins-table tbody tr:hover {
            background: #f8fbff;
        }

        .ins-student {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 200px;
        }

        .ins-student-photo {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #edf2f7;
            flex-shrink: 0;
        }

        .ins-student-name {
            font-weight: 800;
            color: #1e293b;
            font-size: 13px;
        }

        .ins-student-matricule {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 3px;
        }

        .ins-class-badge {
            display: inline-block;
            background: #f1f5f9;
            color: #475569;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .ins-year {
            font-weight: 700;
            color: #475569;
            white-space: nowrap;
        }

        .ins-type {
            font-size: 11px;
            font-weight: 700;
        }

        .ins-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .ins-status-attente {
            background: #fff7ed;
            color: #c2410c;
        }

        .ins-status-validee {
            background: #ecfdf5;
            color: #047857;
        }

        .ins-status-annulee {
            background: #fef2f2;
            color: #dc2626;
        }

        .ins-money {
            font-weight: 800;
            color: #1e293b;
            white-space: nowrap;
        }

        .ins-actions {
            display: flex;
            gap: 6px;
        }

        .ins-action-btn {
            width: 33px;
            height: 33px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5eaf1;
            background: #fff;
            text-decoration: none;
            cursor: pointer;
            transition: .15s;
            font-size: 13px;
        }

        .ins-action-view {
            color: #2563eb;
        }

        .ins-action-view:hover {
            background: #eff6ff;
        }

        .ins-action-edit {
            color: #d97706;
        }

        .ins-action-edit:hover {
            background: #fffbeb;
        }

        .ins-action-delete {
            color: #dc2626;
        }

        .ins-action-delete:hover {
            background: #fef2f2;
        }

        .ins-empty {
            padding: 60px 20px !important;
            text-align: center;
        }

        .ins-empty-icon {
            font-size: 42px;
            margin-bottom: 12px;
        }

        .ins-empty h5 {
            font-weight: 800;
            color: #334155;
        }

        .ins-empty p {
            color: #94a3b8;
            font-size: 13px;
        }

        /* PAGINATION */
        .ins-pagination {
            padding: 17px 22px;
            border-top: 1px solid #edf1f6;
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .ins-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ins-filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ins-filter-actions {
                grid-column: span 2;
            }
        }

        @media (max-width: 650px) {
            .ins-page {
                padding: 12px;
            }

            .ins-header h2 {
                font-size: 22px;
            }

            .ins-stats {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .ins-stat-card {
                padding: 13px;
                gap: 10px;
            }

            .ins-stat-icon {
                width: 42px;
                height: 42px;
                font-size: 19px;
            }

            .ins-stat-info h3 {
                font-size: 21px;
            }

            .ins-stat-info span {
                font-size: 11px;
            }

            .ins-filter-grid {
                grid-template-columns: 1fr;
            }

            .ins-filter-actions {
                grid-column: auto;
            }
        }
    </style>

    <div class="ins-page">

        {{-- HEADER --}}
        <div class="ins-header">

            <div>
                <h2>🎓 Gestion des inscriptions</h2>

                <p>
                    Gérez les inscriptions, réinscriptions et dossiers administratifs des élèves.
                </p>
            </div>

            <a href="{{ route('inscriptions.create') }}" class="ins-btn-add">
                <span>＋</span>
                Nouvelle inscription
            </a>

        </div>

        {{-- ALERTES --}}
        @if (session('success'))
            <div class="alert alert-success ins-alert">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger ins-alert">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        {{-- STATISTIQUES --}}
        <div class="ins-stats">

            <div class="ins-stat-card">
                <div class="ins-stat-icon ins-stat-blue">🎓</div>
                <div class="ins-stat-info">
                    <span>Total des inscriptions</span>
                    <h3>{{ $inscriptions->total() }}</h3>
                </div>
            </div>

            <div class="ins-stat-card">
                <div class="ins-stat-icon ins-stat-green">✓</div>
                <div class="ins-stat-info">
                    <span>Inscriptions validées</span>
                    <h3>
                        {{ $inscriptions->getCollection()->where('statut', 'validee')->count() }}
                    </h3>
                </div>
            </div>

            <div class="ins-stat-card">
                <div class="ins-stat-icon ins-stat-orange">⌛</div>
                <div class="ins-stat-info">
                    <span>En attente</span>
                    <h3>
                        {{ $inscriptions->getCollection()->where('statut', 'en_attente')->count() }}
                    </h3>
                </div>
            </div>

            <div class="ins-stat-card">
                <div class="ins-stat-icon ins-stat-purple">💰</div>
                <div class="ins-stat-info">
                    <span>Frais affichés</span>
                    <h3>
                        {{ number_format($inscriptions->getCollection()->sum('frais_inscription'), 0, ',', ' ') }}
                    </h3>
                </div>
            </div>

        </div>

        {{-- FILTRES --}}
        <div class="ins-filter-card">

            <div class="ins-filter-title">
                🔎 Recherche et filtres
            </div>

            <form method="GET" action="{{ route('inscriptions.index') }}">

                <div class="ins-filter-grid">

                    {{-- RECHERCHE --}}
                    <div class="ins-form-group">
                        <label>Nom, prénom ou matricule</label>

                        <input type="text" name="recherche" class="ins-form-control"
                            placeholder="Ex : Rakoto, ELV-2026..." value="{{ request('recherche') }}">
                    </div>

                    {{-- ANNÉE --}}
                    <div class="ins-form-group">
                        <label>Année scolaire</label>

                        <select name="annee_scolaire_id" class="ins-form-control">

                            <option value="">Toutes les années</option>

                            @foreach ($anneesScolaires as $annee)
                                <option value="{{ $annee->id }}"
                                    {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->nom }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- CLASSE --}}
                    <div class="ins-form-group">
                        <label>Classe</label>

                        <select name="classe_id" class="ins-form-control">

                            <option value="">Toutes les classes</option>

                            @foreach ($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- STATUT --}}
                    <div class="ins-form-group">
                        <label>Statut</label>

                        <select name="statut" class="ins-form-control">

                            <option value="">Tous les statuts</option>

                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>
                                En attente
                            </option>

                            <option value="validee" {{ request('statut') == 'validee' ? 'selected' : '' }}>
                                Validée
                            </option>

                            <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>
                                Annulée
                            </option>

                        </select>
                    </div>

                    {{-- BOUTONS --}}
                    <div class="ins-filter-actions">

                        <button type="submit" class="ins-btn-filter">
                            Filtrer
                        </button>

                        <a href="{{ route('inscriptions.index') }}" class="ins-btn-reset" title="Réinitialiser">
                            ↺
                        </a>

                    </div>

                </div>

            </form>

        </div>

        {{-- TABLEAU --}}
        <div class="ins-table-card">

            <div class="ins-table-header">

                <div>
                    <h5>📋 Liste des inscriptions</h5>

                    <p>
                        Consultez les dossiers d'inscription de votre établissement.
                    </p>
                </div>

                <span class="ins-count-badge">
                    {{ $inscriptions->total() }} dossier(s)
                </span>

            </div>

            <div class="ins-table-scroll">

                <table class="ins-table">

                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Frais</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($inscriptions as $inscription)
                            <tr>

                                {{-- ÉLÈVE --}}
                                <td>

                                    <div class="ins-student">

                                        @if ($inscription->eleve && $inscription->eleve->photo)
                                            <img src="{{ asset('storage/' . $inscription->eleve->photo) }}"
                                                class="ins-student-photo" alt="Photo">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(($inscription->eleve->nom ?? 'Élève') . ' ' . ($inscription->eleve->prenom ?? '')) }}&background=E8F0FE&color=2563EB&size=80"
                                                class="ins-student-photo" alt="Avatar">
                                        @endif

                                        <div>
                                            <div class="ins-student-name">
                                                {{ $inscription->eleve->nom ?? '—' }}
                                                {{ $inscription->eleve->prenom ?? '' }}
                                            </div>

                                            <span class="ins-student-matricule">
                                                {{ $inscription->eleve->matricule ?? 'Sans matricule' }}
                                            </span>
                                        </div>

                                    </div>

                                </td>

                                {{-- CLASSE --}}
                                <td>
                                    <span class="ins-class-badge">
                                        {{ $inscription->classe->nom ?? '—' }}
                                    </span>
                                </td>

                                {{-- ANNÉE --}}
                                <td>
                                    <span class="ins-year">
                                        {{ $inscription->anneeScolaire->nom ?? '—' }}
                                    </span>
                                </td>

                                {{-- TYPE --}}
                                <td>
                                    <span class="ins-type">
                                        {{ $inscription->type === 'nouvelle_inscription' ? 'Nouvelle' : 'Réinscription' }}
                                    </span>
                                </td>

                                {{-- DATE --}}
                                <td>
                                    {{ $inscription->date_inscription?->format('d/m/Y') ?? '—' }}
                                </td>

                                {{-- FRAIS --}}
                                <td>
                                    <span class="ins-money">
                                        {{ number_format((float) $inscription->frais_inscription, 0, ',', ' ') }} Ar
                                    </span>
                                </td>

                                {{-- STATUT --}}
                                <td>

                                    @if ($inscription->statut === 'validee')
                                        <span class="ins-status ins-status-validee">
                                            ● Validée
                                        </span>
                                    @elseif($inscription->statut === 'annulee')
                                        <span class="ins-status ins-status-annulee">
                                            ● Annulée
                                        </span>
                                    @else
                                        <span class="ins-status ins-status-attente">
                                            ● En attente
                                        </span>
                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td>

                                    <div class="ins-actions">

                                        <a href="{{ route('inscriptions.show', $inscription->id) }}"
                                            class="ins-action-btn ins-action-view" title="Voir">
                                            👁
                                        </a>

                                        <a href="{{ route('inscriptions.edit', $inscription->id) }}"
                                            class="ins-action-btn ins-action-edit" title="Modifier">
                                            ✎
                                        </a>

                                        @if ($inscription->statut !== 'validee')
                                            <form action="{{ route('inscriptions.destroy', $inscription->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer cette inscription ?');"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="ins-action-btn ins-action-delete"
                                                    title="Supprimer">
                                                    🗑
                                                </button>

                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="ins-empty">

                                    <div class="ins-empty-icon">📭</div>

                                    <h5>Aucune inscription trouvée</h5>

                                    <p>
                                        Aucun dossier ne correspond à votre recherche.
                                    </p>

                                    <a href="{{ route('inscriptions.create') }}" class="ins-btn-add">
                                        ＋ Créer une inscription
                                    </a>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            @if ($inscriptions->hasPages())
                <div class="ins-pagination">

                    {{ $inscriptions->links() }}

                </div>
            @endif

        </div>

    </div>
@endsection
