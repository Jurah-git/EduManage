
@extends('layouts.app')

@section('content')

<style>
    .coeff-page {
        padding: 24px;
        max-width: 1450px;
        margin: auto;
        color: #26364b;
    }

    /* HERO */
    .coeff-hero {
        position: relative;
        overflow: hidden;
        padding: 30px 34px;
        border-radius: 20px;
        color: white;
        background: linear-gradient(120deg, #172c50, #24558a 60%, #168e91);
        box-shadow: 0 12px 30px rgba(23, 44, 80, .17);
        margin-bottom: 24px;
    }

    .coeff-hero::after {
        content: "\f1de";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        right: 45px;
        top: 10px;
        font-size: 120px;
        opacity: .10;
        transform: rotate(-12deg);
    }

    .coeff-hero h3 {
        font-weight: 800;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }

    .coeff-hero p {
        margin: 0;
        opacity: .85;
        font-size: 13px;
        position: relative;
        z-index: 1;
    }

    .coeff-hero-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 12px;
        opacity: .9;
    }

    /* STATS */
    .coeff-stat-card {
        background: white;
        border: 1px solid #e9edf3;
        border-radius: 15px;
        padding: 19px;
        height: 100%;
        box-shadow: 0 5px 18px rgba(20, 40, 70, .04);
        transition: .2s;
    }

    .coeff-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 22px rgba(20, 40, 70, .08);
    }

    .coeff-stat-icon {
        width: 43px;
        height: 43px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 13px;
    }

    .coeff-stat-number {
        font-size: 26px;
        font-weight: 800;
        color: #253d5b;
        line-height: 1.2;
    }

    .coeff-stat-label {
        font-size: 12px;
        color: #8290a4;
        margin-top: 5px;
        font-weight: 600;
    }

    /* TABLE CARD */
    .coeff-card {
        margin-top: 23px;
        background: white;
        border: 1px solid #e8edf4;
        border-radius: 17px;
        box-shadow: 0 8px 25px rgba(20, 40, 70, .05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 405px);
        min-height: 390px;
        max-height: 650px;
    }

    .coeff-card-header {
        padding: 21px 24px;
        border-bottom: 1px solid #edf0f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .coeff-card-title h5 {
        margin: 0 0 5px;
        font-weight: 800;
        font-size: 16px;
        color: #293d57;
    }

    .coeff-card-title p {
        margin: 0;
        font-size: 12px;
        color: #8a96a8;
    }

    .coeff-search {
        position: relative;
        width: 290px;
        max-width: 100%;
    }

    .coeff-search i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #98a4b5;
    }

    .coeff-search input {
        width: 100%;
        height: 42px;
        border: 1px solid #e0e6ef;
        border-radius: 10px;
        padding: 8px 12px 8px 37px;
        font-size: 13px;
        outline: none;
        transition: .2s;
    }

    .coeff-search input:focus {
        border-color: #3282a5;
        box-shadow: 0 0 0 3px rgba(50, 130, 165, .09);
    }

    /* TABLE */
    .coeff-table-wrapper {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        overflow-x: auto;
    }

    .coeff-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .coeff-table thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #f4f7fb;
        color: #617189;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 15px 22px;
        border-bottom: 1px solid #e6ebf2;
        white-space: nowrap;
    }

    .coeff-table tbody td {
        padding: 14px 22px;
        border-bottom: 1px solid #eff2f6;
        vertical-align: middle;
        font-size: 13px;
    }

    .coeff-table tbody tr {
        transition: background .15s;
    }

    .coeff-table tbody tr:hover {
        background: #f7faff;
    }

    .coeff-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .coeff-subject {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .coeff-subject-icon {
        width: 37px;
        height: 37px;
        border-radius: 11px;
        background: #eaf2ff;
        color: #326da8;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .coeff-subject-name {
        font-weight: 700;
        color: #34445b;
    }

    .coeff-configure-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 14px;
        border-radius: 9px;
        background: #eaf3ff;
        border: 1px solid #d5e6fb;
        color: #2766a6;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: .2s;
    }

    .coeff-configure-btn:hover {
        background: #2766a6;
        border-color: #2766a6;
        color: white;
        transform: translateY(-1px);
    }

    .coeff-empty {
        padding: 55px 20px !important;
        text-align: center;
        color: #8b98aa;
    }

    .coeff-empty i {
        display: block;
        font-size: 35px;
        margin-bottom: 13px;
        color: #bdc8d6;
    }

    /* FOOTER */
    .coeff-card-footer {
        padding: 15px 22px;
        border-top: 1px solid #edf0f5;
        background: #fafbfd;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .coeff-footer-info {
        font-size: 12px;
        color: #8793a5;
    }

    .coeff-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .coeff-pagination button {
        min-width: 32px;
        height: 32px;
        border: 1px solid #e0e6ef;
        background: white;
        border-radius: 7px;
        color: #617189;
        font-size: 12px;
        font-weight: 700;
        transition: .2s;
    }

    .coeff-pagination button:hover:not(:disabled),
    .coeff-pagination button.active {
        background: #245b91;
        border-color: #245b91;
        color: white;
    }

    .coeff-pagination button:disabled {
        opacity: .4;
        cursor: not-allowed;
    }

    .coeff-per-page {
        height: 32px;
        padding: 4px 9px;
        border: 1px solid #e0e6ef;
        border-radius: 7px;
        background: white;
        color: #526176;
        font-size: 12px;
        outline: none;
    }

    @media(max-width: 768px) {
        .coeff-page {
            padding: 14px;
        }

        .coeff-hero {
            padding: 24px;
        }

        .coeff-card {
            height: calc(100vh - 370px);
            min-height: 350px;
        }

        .coeff-card-header {
            padding: 17px;
        }

        .coeff-search {
            width: 100%;
        }

        .coeff-table thead th,
        .coeff-table tbody td {
            padding: 12px;
        }

        .coeff-card-footer {
            padding: 13px;
        }
    }
</style>

<div class="coeff-page">

    {{-- HERO --}}
    <div class="coeff-hero">

        <div class="coeff-hero-label">
            <i class="fas fa-sliders-h"></i>
            Paramètres pédagogiques
        </div>

        <h3>Gestion des coefficients</h3>

        <p>
            Configurez les coefficients de chaque matière pour organiser
            le calcul des moyennes et des résultats scolaires.
        </p>

    </div>

    {{-- STATISTIQUES --}}
    <div class="row g-3">

        <div class="col-md-4">

            <div class="coeff-stat-card">

                <div class="coeff-stat-icon"
                     style="background:#eaf2ff;color:#3478bd;">

                    <i class="fas fa-book"></i>

                </div>

                <div class="coeff-stat-number">
                    {{ $matieres->count() }}
                </div>

                <div class="coeff-stat-label">
                    Matières disponibles
                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="coeff-stat-card">

                <div class="coeff-stat-icon"
                     style="background:#e8f8f2;color:#15966b;">

                    <i class="fas fa-check-circle"></i>

                </div>

                <div class="coeff-stat-number" id="coeffVisibleCount">
                    {{ $matieres->count() }}
                </div>

                <div class="coeff-stat-label">
                    Matières affichées
                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="coeff-stat-card">

                <div class="coeff-stat-icon"
                     style="background:#fff4e5;color:#d28a27;">

                    <i class="fas fa-calculator"></i>

                </div>

                <div class="coeff-stat-number">
                    <i class="fas fa-cogs"></i>
                </div>

                <div class="coeff-stat-label">
                    Configuration des coefficients
                </div>

            </div>

        </div>

    </div>

    {{-- TABLEAU --}}
    <div class="coeff-card">

        <div class="coeff-card-header">

            <div class="coeff-card-title">

                <h5>
                    <i class="fas fa-list-ul text-primary me-2"></i>
                    Liste des matières
                </h5>

                <p>
                    Consultez les matières et accédez à leur configuration.
                </p>

            </div>

            <div class="coeff-search">

                <i class="fas fa-search"></i>

                <input
                    type="text"
                    id="searchMatiere"
                    placeholder="Rechercher une matière..."
                >

            </div>

        </div>

        <div class="coeff-table-wrapper">

            <table class="coeff-table">

                <thead>

                    <tr>

                        <th>Matière</th>

                        @if (auth()->user()->aPermission('coefficients.modifier'))

                            <th width="180" class="text-center">
                                Action
                            </th>

                        @endif

                    </tr>

                </thead>

                <tbody id="coeffTableBody">

                    @forelse ($matieres as $matiere)

                        <tr class="matiere-row"
                            data-name="{{ strtolower($matiere->nom) }}">

                            <td>

                                <div class="coeff-subject">

                                    <div class="coeff-subject-icon">
                                        <i class="fas fa-book-open"></i>
                                    </div>

                                    <span class="coeff-subject-name">
                                        {{ $matiere->nom }}
                                    </span>

                                </div>

                            </td>

                            @if (auth()->user()->aPermission('coefficients.modifier'))

                                <td class="text-center">

                                    <a
                                        href="{{ route('coefficients.edit', $matiere->id) }}"
                                        class="coeff-configure-btn">

                                        <i class="fas fa-sliders-h"></i>
                                        Configurer

                                    </a>

                                </td>

                            @endif

                        </tr>

                    @empty

                        <tr>

                            <td colspan="{{ auth()->user()->aPermission('coefficients.modifier') ? 2 : 1 }}"
                                class="coeff-empty">

                                <i class="fas fa-book-open"></i>

                                <strong class="d-block mb-1">
                                    Aucune matière trouvée
                                </strong>

                                <span>
                                    Les matières apparaîtront ici lorsqu'elles seront enregistrées.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                    <tr id="searchEmpty" style="display:none;">

                        <td colspan="{{ auth()->user()->aPermission('coefficients.modifier') ? 2 : 1 }}"
                            class="coeff-empty">

                            <i class="fas fa-search"></i>

                            <strong class="d-block mb-1">
                                Aucun résultat
                            </strong>

                            <span>
                                Aucune matière ne correspond à votre recherche.
                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        {{-- FOOTER --}}
        <div class="coeff-card-footer">

            <div class="d-flex align-items-center gap-3 flex-wrap">

                <span class="coeff-footer-info" id="coeffFooterInfo">
                    Affichage de {{ $matieres->count() }} matière(s)
                </span>

                <div class="d-flex align-items-center gap-2">

                    <span class="coeff-footer-info">
                        Afficher :
                    </span>

                    <select id="coeffPerPage" class="coeff-per-page">

                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="all">Tout</option>

                    </select>

                </div>

            </div>

            <div class="coeff-pagination" id="coeffPagination">

                <button type="button" id="coeffPrev" title="Précédent">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <span id="coeffPageNumbers" class="d-flex gap-1"></span>

                <button type="button" id="coeffNext" title="Suivant">
                    <i class="fas fa-chevron-right"></i>
                </button>

            </div>

        </div>

    </div>

</div>

{{-- JAVASCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchMatiere');
    const perPageSelect = document.getElementById('coeffPerPage');
    const rows = Array.from(document.querySelectorAll('.matiere-row'));

    const prevButton = document.getElementById('coeffPrev');
    const nextButton = document.getElementById('coeffNext');
    const pageNumbers = document.getElementById('coeffPageNumbers');

    const footerInfo = document.getElementById('coeffFooterInfo');
    const visibleCount = document.getElementById('coeffVisibleCount');
    const searchEmpty = document.getElementById('searchEmpty');

    let currentPage = 1;

    function getFilteredRows() {

        const search = searchInput.value.toLowerCase().trim();

        return rows.filter(function (row) {
            return row.dataset.name.includes(search);
        });

    }

    function renderTable() {

        const filteredRows = getFilteredRows();

        const perPage = perPageSelect.value === 'all'
            ? filteredRows.length || 1
            : parseInt(perPageSelect.value);

        const total = filteredRows.length;
        const totalPages = Math.max(1, Math.ceil(total / perPage));

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        const start = (currentPage - 1) * perPage;
        const end = Math.min(start + perPage, total);

        rows.forEach(function (row) {
            row.style.display = 'none';
        });

        filteredRows.slice(start, end).forEach(function (row) {
            row.style.display = '';
        });

        searchEmpty.style.display = total === 0 ? '' : 'none';

        visibleCount.textContent = total;

        footerInfo.textContent = total === 0
            ? 'Aucune matière à afficher'
            : 'Affichage de ' + (start + 1) + ' à ' + end +
              ' sur ' + total + ' matière(s)';

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {

        pageNumbers.innerHTML = '';

        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;

        if (getFilteredRows().length === 0 || totalPages <= 1) {
            return;
        }

        let pages = [];

        if (totalPages <= 5) {

            for (let i = 1; i <= totalPages; i++) {
                pages.push(i);
            }

        } else {

            pages.push(1);

            let start = Math.max(2, currentPage - 1);
            let end = Math.min(totalPages - 1, currentPage + 1);

            if (start > 2) {
                pages.push('...');
            }

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }

            if (end < totalPages - 1) {
                pages.push('...');
            }

            pages.push(totalPages);
        }

        pages.forEach(function (page) {

            if (page === '...') {

                const dots = document.createElement('span');
                dots.textContent = '...';
                dots.style.padding = '5px';
                dots.style.color = '#8793a5';

                pageNumbers.appendChild(dots);

                return;
            }

            const button = document.createElement('button');

            button.type = 'button';
            button.textContent = page;

            if (page === currentPage) {
                button.classList.add('active');
            }

            button.addEventListener('click', function () {
                currentPage = page;
                renderTable();
            });

            pageNumbers.appendChild(button);

        });

    }

    searchInput.addEventListener('input', function () {
        currentPage = 1;
        renderTable();
    });

    perPageSelect.addEventListener('change', function () {
        currentPage = 1;
        renderTable();
    });

    prevButton.addEventListener('click', function () {

        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }

    });

    nextButton.addEventListener('click', function () {

        currentPage++;
        renderTable();

    });

    renderTable();

});
</script>

@endsection
