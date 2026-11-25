@extends('layouts.app')

@section('content')
    @php
        $user = auth()->user();

        $peutVoir = $user->aPermission('parents.voir');
        $peutCreer = $user->aPermission('parents.creer');
        $peutModifier = $user->aPermission('parents.modifier');
        $peutSupprimer = $user->aPermission('parents.supprimer');

        $afficherActions = $peutVoir || $peutModifier || $peutSupprimer;
    @endphp

    <div class="container-fluid px-3 px-md-4 py-4 parents-page">

        {{-- EN-TÊTE --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1 page-title">
                    <i class="bi bi-people-fill me-2"></i>
                    Gestion des parents
                </h2>
                <p class="text-secondary mb-0">
                    Annuaire des parents et responsables légaux.
                </p>
            </div>

            @if ($peutCreer)
                <a href="{{ route('parents.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Ajouter un parent
                </a>
            @endif
        </div>

        {{-- MESSAGE --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- BARRE DE RECHERCHE --}}
        <div class="directory-header mb-3">
            <div>
                <h5 class="fw-bold mb-1">Annuaire des parents</h5>
                <small class="text-secondary">
                    {{ $parents->total() }} parent(s) enregistré(s)
                </small>
            </div>

            <div class="directory-search">
                <i class="bi bi-search"></i>
                <input type="search" id="rechercheParent" placeholder="Rechercher un parent..." autocomplete="off">
            </div>
        </div>

        {{-- ANNUAIRE --}}
        <div class="directory-list" id="listeParents">

            @forelse ($parents as $parent)
                @php
                    $nomComplet = trim($parent->nom . ' ' . $parent->prenom);

                    // Préparation du numéro WhatsApp
                    $telephoneWhatsApp = preg_replace('/\D+/', '', (string) $parent->telephone);

                    if (str_starts_with($telephoneWhatsApp, '00')) {
                        $telephoneWhatsApp = substr($telephoneWhatsApp, 2);
                    } elseif (str_starts_with($telephoneWhatsApp, '0')) {
                        $telephoneWhatsApp = '261' . substr($telephoneWhatsApp, 1);
                    }

                    $messageWhatsApp =
                        'Bonjour ' .
                        $parent->prenom .
                        ' ' .
                        $parent->nom .
                        ', nous vous contactons concernant la scolarité de votre enfant.';

                    $lienWhatsApp = $telephoneWhatsApp
                        ? 'https://wa.me/' . $telephoneWhatsApp . '?text=' . rawurlencode($messageWhatsApp)
                        : null;

                    $messageEmail =
                        'Bonjour ' .
                        $parent->prenom .
                        ' ' .
                        $parent->nom .
                        ",\n\n" .
                        "Nous vous contactons concernant la scolarité de votre enfant.\n\n" .
                        "Cordialement,\nAdministration de l'établissement.";

                    $lienEmail = $parent->email
                        ? 'mailto:' .
                            $parent->email .
                            '?subject=' .
                            rawurlencode('Communication de l’établissement') .
                            '&body=' .
                            rawurlencode($messageEmail)
                        : null;
                @endphp

                <article class="directory-item"
                    data-search="{{ mb_strtolower($nomComplet . ' ' . $parent->telephone . ' ' . $parent->email . ' ' . $parent->profession, 'UTF-8') }}">

                    {{-- IDENTITÉ --}}
                    <div class="directory-identity">

                        <div class="directory-avatar">
                            {{ strtoupper(mb_substr($parent->prenom ?? '', 0, 1)) }}{{ strtoupper(mb_substr($parent->nom ?? '', 0, 1)) }}
                        </div>

                        <div class="identity-content">
                            <div class="identity-heading">
                                <h6 class="directory-name">{{ $nomComplet }}</h6>
                                <span class="directory-reference">#{{ $parent->id }}</span>
                            </div>

                            <div class="directory-contact-info">
                                <span>
                                    <i class="bi bi-telephone"></i>
                                    {{ $parent->telephone ?: 'Téléphone non renseigné' }}
                                </span>

                                <span>
                                    <i class="bi bi-envelope"></i>
                                    {{ $parent->email ?: 'E-mail non renseigné' }}
                                </span>

                                @if ($parent->profession)
                                    <span>
                                        <i class="bi bi-briefcase"></i>
                                        {{ $parent->profession }}
                                    </span>
                                @endif
                            </div>

                            {{-- CONTACT DIRECT --}}
                            <div class="directory-buttons">
                                @if ($lienWhatsApp)
                                    <a href="{{ $lienWhatsApp }}" target="_blank" rel="noopener noreferrer"
                                        class="directory-btn whatsapp-btn">
                                        <i class="bi bi-whatsapp"></i>
                                        WhatsApp
                                    </a>
                                @else
                                    <span class="directory-btn unavailable-btn">
                                        <i class="bi bi-whatsapp"></i>
                                        WhatsApp indisponible
                                    </span>
                                @endif

                                @if ($lienEmail)
                                    <a href="{{ $lienEmail }}" class="directory-btn email-btn">
                                        <i class="bi bi-envelope-fill"></i>
                                        E-mail
                                    </a>
                                @else
                                    <span class="directory-btn unavailable-btn">
                                        <i class="bi bi-envelope"></i>
                                        E-mail indisponible
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ENFANTS ET ACTIONS --}}
                    <div class="directory-side">

                        <div class="children-info">
                            <span class="children-count">
                                {{ $parent->eleves_count ?? 0 }}
                            </span>
                            <span>Enfant(s)</span>
                        </div>

                        @if ($afficherActions)
                            <div class="directory-actions">

                                @if ($peutVoir)
                                    <a href="{{ route('parents.show', $parent) }}" class="directory-action"
                                        title="Consulter">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                @endif

                                @if ($peutModifier)
                                    <a href="{{ route('parents.edit', $parent) }}" class="directory-action"
                                        title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endif

                                @if ($peutSupprimer)
                                    <form action="{{ route('parents.destroy', $parent) }}" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cette fiche parent ?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="directory-action delete-action" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        @endif
                    </div>
                </article>

            @empty

                <div class="directory-empty">
                    <i class="bi bi-people"></i>
                    <h5>Aucun parent enregistré</h5>
                    <p>Commencez par ajouter la première fiche parent.</p>

                    @if ($peutCreer)
                        <a href="{{ route('parents.create') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus me-2"></i>
                            Ajouter un parent
                        </a>
                    @endif
                </div>
            @endforelse

            <div id="aucunResultat" class="directory-empty" style="display:none;">
                <i class="bi bi-search"></i>
                <h5>Aucun résultat</h5>
                <p>Aucun parent ne correspond à votre recherche.</p>
            </div>

        </div>

        {{-- PAGINATION --}}
        @if ($parents->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $parents->links() }}
            </div>
        @endif

    </div>

    <style>
        .parents-page {
            color: var(--bs-body-color);
        }

        .page-title,
        .directory-name {
            color: var(--bs-emphasis-color);
        }

        .parents-page .btn-primary {
            border-radius: 9px;
            font-weight: 600;
        }

        /* EN-TÊTE */

        .directory-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .directory-search {
            display: flex;
            align-items: center;
            gap: 10px;
            width: min(100%, 330px);
            padding: 10px 13px;
            border: 1px solid var(--bs-border-color);
            border-radius: 9px;
            background: var(--bs-body-bg);
        }

        .directory-search i {
            color: var(--bs-secondary-color);
        }

        .directory-search input {
            width: 100%;
            border: 0;
            outline: none;
            background: transparent;
            color: var(--bs-body-color);
        }

        .directory-search input::placeholder {
            color: var(--bs-secondary-color);
        }

        /* GRILLE ANNUAIRE */

        .directory-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 32px;
        }

        .directory-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            min-width: 0;
            padding: 21px 4px;
            border-bottom: 1px solid var(--bs-border-color);
        }

        .directory-identity {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            flex: 1;
            min-width: 0;
        }

        .directory-avatar {
            width: 46px;
            height: 46px;
            min-width: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--bs-tertiary-bg);
            color: var(--bs-emphasis-color);
            font-size: 14px;
            font-weight: 700;
        }

        .identity-content {
            min-width: 0;
        }

        .identity-heading {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            margin-bottom: 7px;
        }

        .directory-name {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .directory-reference {
            color: var(--bs-secondary-color);
            font-size: 11px;
        }

        .directory-contact-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
            color: var(--bs-secondary-color);
            font-size: 12px;
        }

        .directory-contact-info span {
            overflow-wrap: anywhere;
        }

        .directory-contact-info i {
            width: 17px;
            margin-right: 4px;
        }

        /* BOUTONS CONTACT */

        .directory-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 12px;
        }

        .directory-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            transition: .2s ease;
        }

        .whatsapp-btn {
            color: #16834a;
            background: rgba(37, 211, 102, .12);
        }

        .whatsapp-btn:hover {
            color: #fff;
            background: #16834a;
        }

        .email-btn {
            color: #2866b1;
            background: rgba(47, 128, 237, .12);
        }

        .email-btn:hover {
            color: #fff;
            background: #2866b1;
        }

        .unavailable-btn {
            color: var(--bs-secondary-color);
            background: var(--bs-tertiary-bg);
            opacity: .75;
        }

        /* ENFANTS ET ACTIONS */

        .directory-side {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .children-info {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--bs-secondary-color);
            font-size: 11px;
            white-space: nowrap;
        }

        .children-count {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-width: 25px;
            height: 25px;
            padding: 0 6px;
            border-radius: 20px;
            background: var(--bs-tertiary-bg);
            color: var(--bs-emphasis-color);
            font-weight: 700;
        }

        .directory-actions {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .directory-actions form {
            margin: 0;
        }

        .directory-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 31px;
            height: 31px;
            border: 0;
            border-radius: 7px;
            background: var(--bs-tertiary-bg);
            color: var(--bs-body-color);
            text-decoration: none;
            cursor: pointer;
        }

        .directory-action:hover {
            background: var(--bs-secondary-bg);
            color: var(--bs-emphasis-color);
        }

        .delete-action {
            color: #dc3545;
        }

        .delete-action:hover {
            color: white;
            background: #dc3545;
        }

        /* ÉTAT VIDE */

        .directory-empty {
            grid-column: 1 / -1;
            padding: 55px 15px;
            text-align: center;
            color: var(--bs-secondary-color);
        }

        .directory-empty>i {
            display: block;
            margin-bottom: 12px;
            font-size: 40px;
        }

        .directory-empty h5 {
            color: var(--bs-emphasis-color);
            font-weight: 700;
        }

        /* RESPONSIVE */

        @media (max-width: 1100px) {
            .directory-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .directory-header {
                align-items: stretch;
            }

            .directory-search {
                width: 100%;
            }

            .directory-item {
                gap: 8px;
                padding: 18px 0;
            }

            .directory-identity {
                gap: 9px;
            }

            .directory-avatar {
                width: 38px;
                height: 38px;
                min-width: 38px;
                font-size: 12px;
            }

            .directory-name {
                font-size: 13px;
            }

            .directory-contact-info {
                font-size: 11px;
            }

            .directory-btn {
                padding: 7px 8px;
                font-size: 10px;
            }

            .directory-side {
                gap: 9px;
            }

            .children-info {
                flex-direction: column;
                gap: 3px;
                font-size: 10px;
            }
        }

        /* =========================================
       FICHES PARENTS - DESIGN ENCADRÉ
    ========================================= */

        .directory-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .directory-item {
            padding: 20px;
            border: 1px solid var(--bs-border-color);
            border-radius: 14px;
            background: var(--bs-secondary-bg);
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
            transition: border-color .2s ease, transform .2s ease;
        }

        .directory-item:hover {
            border-color: var(--bs-primary);
            transform: translateY(-2px);
        }

        /* Textes principaux */

        .directory-name {
            color: var(--bs-emphasis-color) !important;
            font-weight: 700;
        }

        .directory-contact-info {
            color: var(--bs-body-color) !important;
        }

        .directory-reference,
        .children-info {
            color: var(--bs-secondary-color) !important;
        }

        /* Avatar */

        .directory-avatar {
            background: var(--bs-tertiary-bg);
            color: var(--bs-emphasis-color);
            border: 1px solid var(--bs-border-color);
        }

        /* Informations enfants et actions */

        .children-count,
        .directory-action {
            background: var(--bs-tertiary-bg);
            color: var(--bs-emphasis-color);
            border: 1px solid var(--bs-border-color);
        }

        /* Recherche */

        .directory-search {
            background: var(--bs-secondary-bg);
            border-color: var(--bs-border-color);
        }

        .directory-search input {
            color: var(--bs-emphasis-color);
        }

        .directory-search input::placeholder {
            color: var(--bs-secondary-color);
            opacity: 1;
        }

        /* Boutons de contact */

        .whatsapp-btn {
            background: rgba(37, 211, 102, .15);
            color: #16834a;
        }

        .email-btn {
            background: rgba(47, 128, 237, .15);
            color: #2866b1;
        }

        /* Mode sombre */

        html[data-app-theme="dark"] .directory-item,
        html[data-bs-theme="dark"] .directory-item {
            background: #202938;
            border-color: #39465a;
        }

        html[data-app-theme="dark"] .directory-name,
        html[data-bs-theme="dark"] .directory-name {
            color: #ffffff !important;
        }

        html[data-app-theme="dark"] .directory-contact-info,
        html[data-bs-theme="dark"] .directory-contact-info {
            color: #d1d9e6 !important;
        }

        html[data-app-theme="dark"] .directory-reference,
        html[data-bs-theme="dark"] .directory-reference,
        html[data-app-theme="dark"] .children-info,
        html[data-bs-theme="dark"] .children-info {
            color: #b9c5d6 !important;
        }

        html[data-app-theme="dark"] .directory-avatar,
        html[data-bs-theme="dark"] .directory-avatar {
            background: #303d50;
            border-color: #46546a;
            color: #ffffff;
        }

        html[data-app-theme="dark"] .directory-action,
        html[data-bs-theme="dark"] .directory-action {
            background: #303d50;
            border-color: #46546a;
            color: #ffffff;
        }

        html[data-app-theme="dark"] .directory-search,
        html[data-bs-theme="dark"] .directory-search {
            background: #202938;
            border-color: #46546a;
        }

        html[data-app-theme="dark"] .directory-search input,
        html[data-bs-theme="dark"] .directory-search input {
            color: #ffffff;
        }

        /* Téléphone */

        @media (max-width: 576px) {
            .directory-list {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .directory-item {
                padding: 16px;
                border-radius: 12px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recherche = document.getElementById('rechercheParent');
            const liste = document.getElementById('listeParents');
            const aucunResultat = document.getElementById('aucunResultat');

            if (!recherche || !liste) return;

            recherche.addEventListener('input', function() {
                const terme = this.value.toLocaleLowerCase('fr').trim();
                const fiches = liste.querySelectorAll('.directory-item');

                let resultats = 0;

                fiches.forEach(function(fiche) {
                    const texte = fiche.dataset.search || '';
                    const correspond = texte.includes(terme);

                    fiche.style.display = correspond ? '' : 'none';

                    if (correspond) resultats++;
                });

                if (aucunResultat) {
                    aucunResultat.style.display =
                        resultats === 0 && fiches.length > 0 ? '' : 'none';
                }
            });
        });
    </script>
@endsection
