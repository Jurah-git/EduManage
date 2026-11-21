
@extends('layouts.app')

@section('content')

<div class="matieres-page">

    {{-- EN-TÊTE --}}
    <div class="matieres-hero">

        <div class="matieres-hero-content">
            <div class="matieres-hero-icon">
                <i class="fas fa-book-open"></i>
            </div>

            <div>
                <span class="matieres-eyebrow">GESTION PÉDAGOGIQUE</span>
                <h2>Gestion des matières</h2>
                <p>Consultez et gérez les matières de votre établissement.</p>
            </div>
        </div>

        @if(auth()->user()->aPermission('matieres.creer'))
            <a href="{{ route('matieres.create') }}" class="matieres-add-btn">
                <i class="fas fa-plus"></i>
                Ajouter une matière
            </a>
        @endif

    </div>

    {{-- NAVIGATION --}}
    <div class="matieres-breadcrumb">
        <i class="fas fa-home"></i>
        <span>Accueil</span>
        <i class="fas fa-chevron-right"></i>
        <strong>Matières</strong>
    </div>

    {{-- ALERTES --}}
    @if(session('success'))
        <div class="matieres-alert success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="matieres-alert danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- STATISTIQUES --}}
    <div class="matieres-stats">

        <div class="matieres-stat-card">
            <div class="matieres-stat-icon blue">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <span>Total des matières</span>
                <h3>{{ $matieres->total() }}</h3>
                <small>Matières enregistrées</small>
            </div>
        </div>

        <div class="matieres-stat-card">
            <div class="matieres-stat-icon purple">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <span>Classes associées</span>
                <h3>
                    {{ $matieres->getCollection()->sum(fn($matiere) => $matiere->classes->count()) }}
                </h3>
                <small>Associations sur cette page</small>
            </div>
        </div>

        <div class="matieres-stat-card">
            <div class="matieres-stat-icon green">
                <i class="fas fa-list-ol"></i>
            </div>
            <div>
                <span>Page actuelle</span>
                <h3>{{ $matieres->currentPage() }}</h3>
                <small>Sur {{ $matieres->lastPage() }} page(s)</small>
            </div>
        </div>

    </div>

    {{-- TABLEAU --}}
    <div class="matieres-card">

        {{-- HEADER --}}
        <div class="matieres-card-header">

            <div class="matieres-card-title">
                <div class="matieres-title-icon">
                    <i class="fas fa-list-ul"></i>
                </div>

                <div>
                    <h5>Liste des matières</h5>
                    <p>Retrouvez toutes les matières de votre établissement.</p>
                </div>
            </div>

            <span class="matieres-total-badge">
                <i class="fas fa-book"></i>
                {{ $matieres->total() }} matière(s)
            </span>

        </div>

        {{-- RECHERCHE --}}
        <div class="matieres-toolbar">

            <div class="matieres-search-wrapper">
                <i class="fas fa-search"></i>

                <input
                    type="text"
                    id="rechercheMatiere"
                    placeholder="Rechercher par code, matière ou classe..."
                    autocomplete="off">

                <button type="button"
                        id="effacerRecherche"
                        title="Effacer la recherche">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <span class="matieres-toolbar-info">
                <i class="fas fa-filter"></i>
                Recherche rapide
            </span>

        </div>

        {{-- TABLEAU SCROLLABLE --}}
        <div class="matieres-table-wrapper">

            <table class="matieres-table" id="tableMatieres">

                <thead>
                    <tr>
                        <th class="col-code">CODE</th>
                        <th class="col-matiere">MATIÈRE</th>
                        <th class="col-classes">CLASSES ASSOCIÉES</th>

                        @if(
                            auth()->user()->aPermission('matieres.modifier') ||
                            auth()->user()->aPermission('matieres.supprimer')
                        )
                            <th class="col-actions">ACTIONS</th>
                        @endif
                    </tr>
                </thead>

                <tbody>

                    @forelse($matieres as $matiere)

                        <tr class="matiere-row">

                            {{-- CODE --}}
                            <td>
                                <span class="matiere-code">
                                    <i class="fas fa-hashtag"></i>
                                    {{ $matiere->code }}
                                </span>
                            </td>

                            {{-- NOM --}}
                            <td>
                                <div class="matiere-name-cell">

                                    <div class="matiere-name-icon">
                                        <i class="fas fa-book-open"></i>
                                    </div>

                                    <div>
                                        <strong>{{ $matiere->nom }}</strong>
                                        <small>Matière pédagogique</small>
                                    </div>

                                </div>
                            </td>

                            {{-- CLASSES --}}
                            <td>
                                <div class="matiere-classes">

                                    @forelse($matiere->classes as $classe)

                                        <span class="matiere-class-badge">
                                            <i class="fas fa-users"></i>
                                            {{ $classe->nom }}
                                        </span>

                                    @empty

                                        <span class="matiere-no-class">
                                            <i class="fas fa-minus-circle"></i>
                                            Aucune classe associée
                                        </span>

                                    @endforelse

                                </div>
                            </td>

                            {{-- ACTIONS --}}
                            @if(
                                auth()->user()->aPermission('matieres.modifier') ||
                                auth()->user()->aPermission('matieres.supprimer')
                            )
                                <td>
                                    <div class="matiere-actions">

                                        @if(auth()->user()->aPermission('matieres.modifier'))

                                            <a href="{{ route('matieres.edit', $matiere) }}"
                                               class="matiere-action-btn edit"
                                               title="Modifier">

                                                <i class="fas fa-pen"></i>
                                            </a>

                                        @endif

                                        @if(auth()->user()->aPermission('matieres.supprimer'))

                                            <form action="{{ route('matieres.destroy', $matiere) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette matière ?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="matiere-action-btn delete"
                                                        title="Supprimer">

                                                    <i class="fas fa-trash-alt"></i>

                                                </button>

                                            </form>

                                        @endif

                                    </div>
                                </td>
                            @endif

                        </tr>

                    @empty

                        <tr>
                            <td colspan="{{ auth()->user()->aPermission('matieres.modifier') || auth()->user()->aPermission('matieres.supprimer') ? 4 : 3 }}"
                                class="matieres-empty">

                                <div class="matieres-empty-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>

                                <h5>Aucune matière enregistrée</h5>

                                <p>
                                    Les matières de votre établissement apparaîtront ici.
                                </p>

                                @if(auth()->user()->aPermission('matieres.creer'))
                                    <a href="{{ route('matieres.create') }}"
                                       class="matieres-empty-btn">
                                        <i class="fas fa-plus"></i>
                                        Ajouter une matière
                                    </a>
                                @endif

                            </td>
                        </tr>

                    @endforelse

                    {{-- RECHERCHE SANS RÉSULTAT --}}
                    <tr id="aucunResultat" style="display:none;">
                        <td colspan="{{ auth()->user()->aPermission('matieres.modifier') || auth()->user()->aPermission('matieres.supprimer') ? 4 : 3 }}"
                            class="matieres-empty">

                            <div class="matieres-empty-icon">
                                <i class="fas fa-search"></i>
                            </div>

                            <h5>Aucun résultat trouvé</h5>
                            <p>Essayez avec un autre mot-clé.</p>

                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        {{-- FOOTER --}}
        <div class="matieres-card-footer">

            <div class="matieres-pagination-info">

                @if($matieres->total() > 0)

                    Affichage de
                    <strong>{{ $matieres->firstItem() }}</strong>
                    à
                    <strong>{{ $matieres->lastItem() }}</strong>
                    sur
                    <strong>{{ $matieres->total() }}</strong>
                    matières

                @else
                    Aucune matière à afficher
                @endif

            </div>

            <div class="matieres-pagination-controls">

                {{-- NOMBRE PAR PAGE --}}
                <form method="GET"
                      action="{{ route('matieres.index') }}"
                      class="matieres-per-page">

                    <label for="per_page">Afficher</label>

                    <select name="per_page"
                            id="per_page"
                            onchange="this.form.submit()">

                        @foreach([10, 15, 25, 50] as $nombre)

                            <option value="{{ $nombre }}"
                                {{ (int) $perPage === $nombre ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>

                        @endforeach

                    </select>

                    <span>par page</span>

                </form>

                {{-- PAGINATION --}}
                <div class="matieres-pagination">
                    {{ $matieres->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>

    </div>

</div>


<style>

/* PAGE */
.matieres-page {
    padding: 22px 25px 35px;
    color: #263449;
}

/* HERO */
.matieres-hero {
    background: linear-gradient(115deg, #173b70, #2466a7 65%, #288b9c);
    border-radius: 18px;
    padding: 27px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    color: white;
    box-shadow: 0 9px 25px rgba(26,74,125,.17);
}

.matieres-hero-content {
    display: flex;
    align-items: center;
    gap: 18px;
}

.matieres-hero-icon {
    width: 62px;
    height: 62px;
    border-radius: 17px;
    background: rgba(255,255,255,.16);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 27px;
    border: 1px solid rgba(255,255,255,.2);
}

.matieres-eyebrow {
    font-size: 10px;
    letter-spacing: 2px;
    font-weight: 800;
    opacity: .75;
}

.matieres-hero h2 {
    font-size: 24px;
    font-weight: 800;
    margin: 4px 0;
}

.matieres-hero p {
    margin: 0;
    color: rgba(255,255,255,.78);
    font-size: 13px;
}

.matieres-add-btn {
    padding: 12px 17px;
    border-radius: 10px;
    background: white;
    color: #245f98;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 9px;
    transition: .25s;
    white-space: nowrap;
}

.matieres-add-btn:hover {
    background: #eaf3fc;
    color: #173b70;
    transform: translateY(-2px);
}

/* BREADCRUMB */
.matieres-breadcrumb {
    display: flex;
    align-items: center;
    gap: 11px;
    margin: 21px 0;
    font-size: 12px;
    color: #8491a3;
}

.matieres-breadcrumb i {
    font-size: 10px;
}

.matieres-breadcrumb strong {
    color: #2466a7;
}

/* ALERTES */
.matieres-alert {
    padding: 14px 17px;
    border-radius: 10px;
    margin-bottom: 17px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
}

.matieres-alert.success {
    color: #218052;
    background: #eaf8f0;
    border: 1px solid #cdebd9;
}

.matieres-alert.danger {
    color: #b93832;
    background: #fff1f0;
    border: 1px solid #f6d2cf;
}

/* STATISTIQUES */
.matieres-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 17px;
    margin-bottom: 22px;
}

.matieres-stat-card {
    background: white;
    border: 1px solid #e9eef5;
    border-radius: 15px;
    padding: 19px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 17px rgba(31,55,85,.045);
    transition: .25s;
}

.matieres-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(31,55,85,.08);
}

.matieres-stat-icon {
    width: 49px;
    height: 49px;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.matieres-stat-icon.blue {
    color: #347bb9;
    background: #eaf3fc;
}

.matieres-stat-icon.purple {
    color: #8666bd;
    background: #f1edfb;
}

.matieres-stat-icon.green {
    color: #299769;
    background: #e9f8f0;
}

.matieres-stat-card span {
    display: block;
    font-size: 11px;
    color: #8491a3;
    font-weight: 600;
}

.matieres-stat-card h3 {
    font-size: 23px;
    font-weight: 800;
    margin: 3px 0;
    color: #263c58;
}

.matieres-stat-card small {
    color: #a0aaba;
    font-size: 10px;
}

/* TABLE CARD */
.matieres-card {
    height: calc(100vh - 390px);
    min-height: 430px;
    max-height: 650px;
    background: white;
    border: 1px solid #e9eef5;
    border-radius: 17px;
    box-shadow: 0 5px 22px rgba(31,55,85,.055);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* HEADER */
.matieres-card-header {
    padding: 21px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #edf0f5;
    flex-shrink: 0;
}

.matieres-card-title {
    display: flex;
    align-items: center;
    gap: 13px;
}

.matieres-title-icon {
    width: 43px;
    height: 43px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eaf2fc;
    color: #2868aa;
    font-size: 18px;
}

.matieres-card-title h5 {
    font-size: 15px;
    font-weight: 800;
    margin: 0 0 4px;
}

.matieres-card-title p {
    font-size: 11px;
    color: #8995a6;
    margin: 0;
}

.matieres-total-badge {
    background: #edf4ff;
    color: #3478b6;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

/* RECHERCHE */
.matieres-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 15px 24px;
    border-bottom: 1px solid #edf0f5;
    flex-shrink: 0;
}

.matieres-search-wrapper {
    display: flex;
    align-items: center;
    width: min(450px, 100%);
    height: 41px;
    padding: 0 12px;
    border: 1px solid #e1e8f0;
    background: #fafbfd;
    border-radius: 9px;
    transition: .25s;
}

.matieres-search-wrapper:focus-within {
    border-color: #4387cb;
    background: white;
    box-shadow: 0 0 0 3px rgba(67,135,203,.09);
}

.matieres-search-wrapper > i {
    color: #8c9aad;
    font-size: 13px;
    margin-right: 10px;
}

.matieres-search-wrapper input {
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-size: 11px;
    color: #35445a;
}

.matieres-search-wrapper input::placeholder {
    color: #a3adba;
}

.matieres-search-wrapper button {
    border: none;
    background: transparent;
    color: #9aa6b5;
    cursor: pointer;
    display: none;
}

.matieres-toolbar-info {
    color: #94a0ae;
    font-size: 11px;
    white-space: nowrap;
}

.matieres-toolbar-info i {
    color: #4387cb;
    margin-right: 5px;
}

/* TABLEAU SCROLLABLE */
.matieres-table-wrapper {
    flex: 1;
    min-height: 0;
    overflow-y: auto;
    overflow-x: auto;
    position: relative;
}

.matieres-table-wrapper::-webkit-scrollbar {
    width: 7px;
    height: 7px;
}

.matieres-table-wrapper::-webkit-scrollbar-track {
    background: #f5f7fa;
}

.matieres-table-wrapper::-webkit-scrollbar-thumb {
    background: #c6d2e0;
    border-radius: 10px;
}

.matieres-table-wrapper::-webkit-scrollbar-thumb:hover {
    background: #8fa5bd;
}

.matieres-table {
    width: 100%;
    min-width: 720px;
    border-collapse: separate;
    border-spacing: 0;
}

.matieres-table thead {
    position: sticky;
    top: 0;
    z-index: 5;
}

.matieres-table thead th {
    background: #f4f7fb;
    color: #75849a;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .7px;
    padding: 16px 20px;
    border-bottom: 1px solid #e7edf4;
    white-space: nowrap;
}

.matieres-table tbody td {
    padding: 15px 20px;
    border-bottom: 1px solid #f0f2f6;
    vertical-align: middle;
    background: white;
}

.matieres-table tbody tr {
    transition: .2s;
}

.matieres-table tbody tr:hover td {
    background: #f8fbff;
}

.matieres-table tbody tr:last-child td {
    border-bottom: none;
}

.col-code {
    width: 155px;
}

.col-matiere {
    min-width: 190px;
}

.col-classes {
    min-width: 240px;
}

.col-actions {
    width: 120px;
    text-align: center;
}

/* CODE */
.matiere-code {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #edf4ff;
    color: #3478b6;
    padding: 7px 10px;
    border-radius: 7px;
    font-size: 11px;
    font-weight: 800;
}

.matiere-code i {
    font-size: 9px;
    opacity: .7;
}

/* NOM */
.matiere-name-cell {
    display: flex;
    align-items: center;
    gap: 11px;
}

.matiere-name-icon {
    width: 38px;
    height: 38px;
    background: #f0f5fb;
    color: #4781b7;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.matiere-name-cell strong {
    display: block;
    font-size: 12px;
    color: #35445a;
}

.matiere-name-cell small {
    display: block;
    font-size: 10px;
    color: #9aa5b3;
    margin-top: 4px;
}

/* CLASSES */
.matiere-classes {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    max-width: 360px;
}

.matiere-class-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 9px;
    background: #f0f8f5;
    color: #368668;
    border: 1px solid #dcefe6;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
}

.matiere-class-badge i {
    font-size: 9px;
}

.matiere-no-class {
    color: #a0aaba;
    font-size: 10px;
}

/* ACTIONS */
.matiere-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.matiere-actions form {
    margin: 0;
}

.matiere-action-btn {
    width: 33px;
    height: 33px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: .2s;
}

.matiere-action-btn.edit {
    background: #fff5df;
    color: #c18c27;
}

.matiere-action-btn.edit:hover {
    background: #f7e6bd;
    transform: translateY(-2px);
}

.matiere-action-btn.delete {
    background: #fff0ef;
    color: #d75c56;
}

.matiere-action-btn.delete:hover {
    background: #fbdad8;
    transform: translateY(-2px);
}

/* VIDE */
.matieres-empty {
    text-align: center;
    padding: 45px 20px !important;
}

.matieres-empty-icon {
    width: 65px;
    height: 65px;
    margin: 0 auto 15px;
    background: #f0f5fb;
    color: #8ba3bd;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
}

.matieres-empty h5 {
    font-size: 15px;
    font-weight: 800;
    color: #43536a;
}

.matieres-empty p {
    color: #98a4b3;
    font-size: 11px;
}

.matieres-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 8px;
    background: #2868aa;
    color: white;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
}

/* FOOTER */
.matieres-card-footer {
    padding: 15px 22px;
    border-top: 1px solid #edf0f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-shrink: 0;
    background: white;
}

.matieres-pagination-info {
    font-size: 11px;
    color: #8995a6;
}

.matieres-pagination-info strong {
    color: #35445a;
}

.matieres-pagination-controls {
    display: flex;
    align-items: center;
    gap: 18px;
}

.matieres-per-page {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 11px;
    color: #8995a6;
    white-space: nowrap;
    margin: 0;
}

.matieres-per-page select {
    border: 1px solid #e0e7ef;
    border-radius: 7px;
    padding: 6px 9px;
    background: #fafbfd;
    color: #35445a;
    outline: none;
    font-size: 11px;
}

.matieres-pagination nav {
    margin: 0;
}

.matieres-pagination .pagination {
    margin: 0;
    gap: 4px;
}

.matieres-pagination .page-link {
    border: 1px solid #e8edf3;
    border-radius: 7px !important;
    color: #60738a;
    font-size: 11px;
    padding: 7px 10px;
}

.matieres-pagination .page-item.active .page-link {
    background: #2868aa;
    border-color: #2868aa;
    color: white;
}

.matieres-pagination .page-link:hover {
    background: #edf4ff;
    color: #2868aa;
}

/* RESPONSIVE */
@media (max-width: 1000px) {
    .matieres-card {
        height: calc(100vh - 370px);
        min-height: 400px;
    }

    .matieres-card-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .matieres-pagination-controls {
        width: 100%;
        justify-content: space-between;
        flex-wrap: wrap;
    }
}

@media (max-width: 700px) {
    .matieres-page {
        padding: 13px;
    }

    .matieres-hero {
        align-items: flex-start;
        flex-direction: column;
        padding: 21px;
    }

    .matieres-hero h2 {
        font-size: 19px;
    }

    .matieres-hero-icon {
        width: 49px;
        height: 49px;
        font-size: 21px;
    }

    .matieres-stats {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .matieres-card {
        height: 600px;
        max-height: calc(100vh - 250px);
        min-height: 430px;
    }

    .matieres-card-header {
        padding: 17px;
    }

    .matieres-toolbar {
        padding: 13px 17px;
        align-items: flex-start;
        flex-direction: column;
    }

    .matieres-search-wrapper {
        width: 100%;
    }

    .matieres-toolbar-info {
        display: none;
    }

    .matieres-card-footer {
        padding: 14px;
    }

    .matieres-pagination-controls {
        align-items: flex-start;
        flex-direction: column;
        gap: 12px;
    }

    .matieres-pagination {
        max-width: 100%;
        overflow-x: auto;
    }
}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const recherche = document.getElementById('rechercheMatiere');
    const effacer = document.getElementById('effacerRecherche');
    const lignes = document.querySelectorAll('.matiere-row');
    const aucunResultat = document.getElementById('aucunResultat');

    if (!recherche) return;

    function filtrerMatieres() {

        const terme = recherche.value.toLowerCase().trim();

        let resultat = 0;

        lignes.forEach(function (ligne) {

            const correspond = ligne.textContent
                .toLowerCase()
                .includes(terme);

            ligne.style.display = correspond ? '' : 'none';

            if (correspond) resultat++;

        });

        if (aucunResultat) {
            aucunResultat.style.display =
                resultat === 0 && lignes.length > 0 ? '' : 'none';
        }

        if (effacer) {
            effacer.style.display = terme ? 'block' : 'none';
        }
    }

    recherche.addEventListener('input', filtrerMatieres);

    if (effacer) {
        effacer.addEventListener('click', function () {
            recherche.value = '';
            filtrerMatieres();
            recherche.focus();
        });
    }

});
</script>

@endsection
