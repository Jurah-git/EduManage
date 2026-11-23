<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EduManage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ==========================================
   EDUMANAGE — DESIGN PROFESSIONNEL
   Bleu marine, bleu royal et jaune doré
========================================== */

        /* ================= BODY ================= */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f1f5fb;
            color: #17243b;
        }

        /* ==========================================
   SIDEBAR
========================================== */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 1000;
            color: #e8efff;
            background: linear-gradient(165deg, #0b1933 0%, #061329 100%);
            border-right: 1px solid rgba(125, 161, 220, 0.12);
            box-shadow: 8px 0 30px rgba(2, 8, 23, 0.16);
        }

        /* ================= SIDEBAR HEADER ================= */

        .sidebar-header {
            flex-shrink: 0;
            min-height: 82px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 18px;
            border-bottom: 1px solid rgba(125, 161, 220, 0.22);
            background: rgba(255, 255, 255, 0.015);
        }

        .sidebar-header .app-logo {
            width: 43px;
            height: 43px;
            min-width: 43px;
            object-fit: contain;
            padding: 3px;
            border-radius: 9px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.25s ease;
        }

        .sidebar-header .app-logo:hover {
            transform: scale(1.05);
        }

        .sidebar-title {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .sidebar-title h3 {
            margin: 0;
            color: #ffffff;
            font-size: 19px;
            font-weight: 750;
            letter-spacing: -0.3px;
        }

        .sidebar-title span {
            display: block;
            margin-top: 4px;
            color: #8da7d5;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ==========================================
   SIDEBAR MENU
========================================== */

        .sidebar-menu {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 17px 12px 20px;
            scrollbar-width: thin;
            scrollbar-color: #30466b transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: #30466b;
            border-radius: 10px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: #526b96;
        }

        /* ================= SECTION TITLES ================= */

        .menu-section-title {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 2px 8px 10px;
            padding: 0 0 2px;
            color: #8ba5d3;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.25px;
            text-transform: uppercase;
        }

        .menu-section-admin {
            margin: 20px 3px 12px;
            padding: 15px 5px 0;
            border-top: 1px solid rgba(125, 161, 220, 0.25);
            font-size: 12px;
        }

        .menu-section-admin i {
            color: #ffc928;
            font-size: 18px;
        }

        /* ================= MAIN MENU LINKS ================= */

        .sidebar-menu>a,
        .sidebar-menu>a.sidebar-link {
            box-sizing: border-box;
            width: 100%;
            min-height: 42px;
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 3px 0;
            padding: 10px 11px;
            border-radius: 9px;
            color: #d4def3;
            background: transparent;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 500;
            line-height: 1.4;
            transition:
                background 0.2s ease,
                color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .sidebar-menu>a>i:first-child,
        .sidebar-menu>a.sidebar-link>i:first-child {
            width: 19px;
            min-width: 19px;
            color: #a8badb;
            font-size: 15px;
            text-align: center;
            transition: color 0.2s ease;
        }

        .sidebar-menu>a>span,
        .sidebar-menu>a.sidebar-link>span {
            flex: 1;
            min-width: 0;
        }

        /* Flèche des sous-menus */

        .sidebar-menu>a .menu-arrow {
            width: auto;
            min-width: auto;
            margin-left: auto;
            color: #7f9ed8;
            font-size: 11px;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        /* Survol */

        .sidebar-menu>a:hover {
            color: #ffffff;
            background: rgba(76, 119, 198, 0.15);
        }

        .sidebar-menu>a:hover>i:first-child {
            color: #ffc928;
        }

        /* Menu actif */

        .sidebar-menu>a.active {
            color: #ffffff;
            background: linear-gradient(100deg, #123f9d, #0c347a);
            box-shadow: inset 3px 0 0 #ffc928;
        }

        .sidebar-menu>a.active>i:first-child {
            color: #ffc928;
        }

        /* Flèche tournée si aria-expanded est activé */

        .sidebar-menu>a.menu-toggle[aria-expanded="true"] .menu-arrow {
            transform: rotate(90deg);
            color: #ffc928;
        }

        /* ==========================================
   SUBMENUS
========================================== */

        .sidebar-menu .submenu {
            display: none;
            margin: 3px 0 8px 21px;
            padding: 4px 0 4px 12px;
            border-left: 1px solid rgba(125, 161, 220, 0.28);
        }

        .sidebar-menu .submenu a {
            display: block;
            margin: 2px 0;
            padding: 9px 10px;
            border-radius: 7px;
            color: #9fb2d3;
            background: transparent;
            text-decoration: none;
            font-size: 11.5px;
            line-height: 1.4;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar-menu .submenu a:hover {
            color: #ffffff;
            background: rgba(76, 119, 198, 0.15);
        }

        .sidebar-menu .submenu a.active {
            color: #ffd34f;
            background: rgba(255, 201, 40, 0.08);
        }

        /* ==========================================
   CONTENT AREA
========================================== */

        .content {
            margin-left: 270px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f1f5fb;
        }

        /* Conteneur du contenu des pages */

        .content>.p-4 {
            flex: 1;
            padding: 26px !important;
        }

        /* ==========================================
   TOPBAR / HEADER
========================================== */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            min-height: 82px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 15px 26px;
            background: rgba(255, 255, 255, 0.97);
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
            backdrop-filter: blur(12px);
        }

        .topbar h4 {
            margin: 0;
            color: #0b1933;
            font-size: 19px;
            font-weight: 750;
            letter-spacing: -0.3px;
        }

        .topbar p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 12px;
        }

        /* Nom de l'établissement */

        .school-name {
            color: #0b1933;
            font-size: 17px;
            font-weight: 750;
        }

        .school-meta {
            margin-top: 4px;
            color: #64748b;
            font-size: 12px;
        }

        /* Informations utilisateur */

        .topbar .user-info,
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 7px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            transition: border-color 0.2s ease, background 0.2s ease;
        }

        .user-box:hover {
            border-color: #cbd8ed;
            background: #f1f5fb;
        }

        /* Avatar utilisateur */

        .avatar {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 3px 9px rgba(0, 0, 0, 0.12);
        }

        .username {
            color: #0b1933;
            font-size: 12.5px;
            font-weight: 650;
            overflow-wrap: anywhere;
        }

        /* ==========================================
   AVATAR ÉLÈVE
========================================== */

        .student-avatar {
            width: 55px !important;
            height: 55px !important;
            min-width: 55px;
            min-height: 55px;
            max-width: 55px;
            max-height: 55px;
            display: block;
            border: 3px solid #ffffff;
            border-radius: 50% !important;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .student-avatar:hover {
            transform: scale(1.06);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* ==========================================
   LOGOUT BUTTON
========================================== */

        .logout-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1px solid rgba(220, 38, 38, 0.12);
            border-radius: 10px;
            color: #ffffff;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            text-decoration: none;
            white-space: nowrap;
            font-size: 12px;
            font-weight: 650;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .logout-btn:hover {
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.24);
        }

        /* ==========================================
   RESPONSIVE
========================================== */

        @media (max-width: 992px) {
            .sidebar {
                width: 245px;
            }

            .content {
                margin-left: 245px;
            }

            .topbar {
                padding: 14px 18px;
                gap: 12px;
            }

            .content>.p-4 {
                padding: 18px !important;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 225px;
            }

            .content {
                margin-left: 225px;
            }

            .sidebar-menu>a,
            .sidebar-menu>a.sidebar-link {
                font-size: 11.5px;
                padding: 10px 9px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
                padding: 14px 16px;
            }

            .topbar-right {
                width: 100%;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 205px;
            }

            .content {
                margin-left: 205px;
            }

            .sidebar-header {
                padding: 12px;
                gap: 9px;
            }

            .sidebar-title h3 {
                font-size: 16px;
            }

            .sidebar-title span {
                font-size: 9px;
            }

            .sidebar-menu {
                padding-right: 8px;
                padding-left: 8px;
            }

            .content>.p-4 {
                padding: 12px !important;
            }

            .school-name {
                font-size: 15px;
            }

            .user-box {
                padding: 6px 8px;
            }

        }

        /* ===== FINITION PROFESSIONNELLE DU MENU ===== */

        .sidebar-menu>.sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            margin: 4px 10px;
            border-radius: 9px;
            color: #d5deed;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.25s ease, color 0.25s ease;
        }

        .sidebar-menu>.sidebar-link>i:first-child {
            width: 20px;
            text-align: center;
            font-size: 17px;
            color: #c3cddd;
            transition: color 0.25s ease;
        }

        /* Survol */
        .sidebar-menu>.sidebar-link:hover {
            background: rgba(230, 184, 74, 0.12);
            color: #f2cc70;
        }

        .sidebar-menu>.sidebar-link:hover>i:first-child {
            color: #f2cc70;
        }

        /* Flèches des sous-menus */
        .sidebar-menu .menu-arrow {
            margin-left: auto;
            font-size: 12px;
            color: #93a4bd;
            transition: transform 0.25s ease, color 0.25s ease;
        }

        /* Rotation de la flèche lorsque le menu est ouvert */
        .sidebar-menu .menu-toggle[aria-expanded="true"] .menu-arrow {
            transform: rotate(90deg);
            color: #f2cc70;
        }

        /* Titre des sections */
        .sidebar-menu .menu-section-title {
            padding: 18px 16px 8px;
            color: #8fa2bd;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Section administration */
        .sidebar-menu .menu-section-admin {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #f2cc70;
        }

        .sidebar-menu .menu-section-admin i {
            font-size: 13px;
        }

        /* Sous-menus */
        .sidebar-menu .submenu {
            padding: 3px 10px 8px 42px;
        }

        .sidebar-menu .submenu a {
            display: block;
            padding: 9px 10px;
            border-left: 2px solid rgba(242, 204, 112, 0.25);
            color: #b8c5d8;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s ease, background 0.2s ease;
        }

        .sidebar-menu .submenu a:hover {
            color: #f2cc70;
            background: rgba(230, 184, 74, 0.08);
            border-left-color: #f2cc70;
        }
    </style>
</head>

<body>

    <div class="sidebar">

        <!-- HEADER FIXE -->

        <div class="sidebar-header">

            @if (isset($ecole) && $ecole && $ecole->logo)
                <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo de l'école" class="app-logo">
            @else
                <div class="app-logo d-flex align-items-center justify-content-center"
                    style="background: linear-gradient(135deg, #34495e, #1abc9c);
                    color: white;
                    border-radius: 14px;
                    width: 55px;
                    height: 55px;
                    font-size: 27px;
                    flex-shrink: 0;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
            @endif

            <div class="sidebar-title">

                @if (isset($ecole) && $ecole && $ecole->nom_ecole)
                    <h3>{{ $ecole->nom_ecole }}</h3>
                    <span>ERP Scolaire</span>
                @endif

            </div>

        </div>


        <!-- MENUS SCROLLABLES -->

        <div class="sidebar-menu">

            <div class="menu-section-title">ESPACE PRINCIPAL</div>

            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="bi bi-grid"></i>
                <span>Tableau de bord</span>
            </a>
            @if (auth()->user()->aPermission('eleves.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="eleve">
                    <i class="bi bi-people"></i>
                    <span>Élèves</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="eleve" class="submenu">
                    <a href="{{ route('eleves.create') }}">Ajouter un élève</a>
                    <a href="{{ route('eleves.index') }}">Liste des élèves</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('inscriptions.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="inscriptions">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Inscriptions</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="inscriptions" class="submenu">

                    <a href="{{ route('inscriptions.index') }}">
                        <i class="bi bi-list-ul"></i>
                        Liste des inscriptions
                    </a>

                </div>
            @endif

            @if (auth()->user()->aPermission('classes.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="classe">
                    <i class="bi bi-mortarboard"></i>
                    <span>Classes et niveaux</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="classe" class="submenu">
                    <a href="{{ route('classes.create') }}">Ajouter une classe</a>
                    <a href="{{ route('classes.index') }}">Liste des classes</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('matieres.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="matiere">
                    <i class="bi bi-book"></i>
                    <span>Matières et programmes</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="matiere" class="submenu">
                    <a href="{{ route('matieres.create') }}">Ajouter une matière</a>
                    <a href="{{ route('matieres.index') }}">Liste des matières</a>
                    <a href="{{ route('coefficients.index') }}">Coefficients</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('enseignants.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="enseignant">
                    <i class="bi bi-person"></i>
                    <span>Enseignants</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="enseignant" class="submenu">
                    <a href="{{ route('enseignants.create') }}">Ajouter un enseignant</a>
                    <a href="{{ route('enseignants.index') }}">Liste des enseignants</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('emploi_temps.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="emploi">
                    <i class="bi bi-calendar-week"></i>
                    <span>Emploi du temps</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="emploi" class="submenu">
                    <a href="{{ route('emplois-temps.create') }}">Ajouter</a>
                    <a href="{{ route('emplois-temps.index') }}">Liste</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('notes.voir') || auth()->user()->aPermission('bulletins.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="bulletin">
                    <i class="bi bi-journal-check"></i>
                    <span>Notes et bulletins</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="bulletin" class="submenu">
                    <a href="{{ route('bulletin.saisie') }}">Saisie des notes</a>
                    <a href="{{ route('bulletin.generer') }}">Générer les bulletins</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('presences.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="presence">
                    <i class="bi bi-calendar-check"></i>
                    <span>Présences et discipline</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="presence" class="submenu">
                    <a href="{{ route('config.pointage') }}">Pointage</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('paiements.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="finances">
                    <i class="bi bi-wallet2"></i>
                    <span>Frais et écolages</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="finances" class="submenu">
                    <a href="{{ route('config.droit.inscription') }}">Droit d'inscription</a>
                    <a href="{{ route('config.droit.reinscription') }}">Droit de réinscription</a>
                    <a href="{{ route('config.mode.paiement') }}">Modes de paiement</a>
                    <a href="{{ route('config.frais.divers') }}">Frais divers</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('parents.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="communication">
                    <i class="bi bi-megaphone"></i>
                    <span>Annonces et communication</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="communication" class="submenu">
                    <a href="{{ route('parents.index') }}">Parents</a>
                </div>
            @endif

            @if (auth()->user()->aPermission('bibliotheque.voir'))
                <a href="#" class="sidebar-link menu-toggle" data-target="livre">
                    <i class="bi bi-journal-bookmark"></i>
                    <span>Livres et bibliothèque</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>

                <div id="livre" class="submenu">
                    <a href="{{ route('livres.create') }}">Ajouter un livre</a>
                    <a href="{{ route('livres.index') }}">Liste des livres</a>
                    <a href="{{ route('biblio.index') }}">Bibliothèque</a>
                    <a href="{{ route('biblio.emprunt') }}">Emprunts</a>
                </div>
            @endif

            @if (auth()->check() && auth()->id() === 1)

                <div class="menu-section-title menu-section-admin">
                    <i class="bi bi-shield-check"></i>
                    ADMINISTRATION
                </div>

                <a href="#" class="sidebar-link menu-toggle" data-target="config">
                    <i class="bi bi-people"></i>
                    <span>Utilisateurs</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="config" class="submenu">
                    <a href="{{ route('config.users.create') }}">Ajouter un utilisateur</a>
                    <a href="{{ route('config.users.list') }}">Liste des utilisateurs</a>
                </div>

                <a href="#" class="sidebar-link menu-toggle" data-target="permissions">
                    <i class="bi bi-shield-lock"></i>
                    <span>Rôles et permissions</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="permissions" class="submenu">
                    @if (auth()->check() && (int) auth()->id() === 1)
                        <a href="{{ route('config.roles.index') }}">
                            <i class="bi bi-shield-check"></i>
                            Gestion des rôles
                        </a>

                        <a href="{{ route('config.users.list') }}">
                            <i class="bi bi-people"></i>
                            Gestion des utilisateurs
                        </a>
                    @endif
                </div>

                <a href="#" class="sidebar-link menu-toggle" data-target="rapports">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Rapports et statistiques</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="rapports" class="submenu">
                    <a href="{{ route('dashboard') }}">Tableau de bord</a>
                </div>

                <a href="#" class="sidebar-link menu-toggle" data-target="parametres">
                    <i class="bi bi-gear"></i>
                    <span>Paramètres</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="parametres" class="submenu">
                    <a href="{{ route('config.ecole-identite') }}">
                        <i class="bi bi-building"></i> Identité de l'école
                    </a>
                    <a href="{{ route('config.annees-scolaires.create') }}">Ajouter une année scolaire</a>
                    <a href="{{ route('config.annees-scolaires.index') }}">Années scolaires</a>
                    <a href="{{ route('config.test.niveau') }}">Tests de niveau</a>
                    <a href="{{ route('config.parascolaires') }}">Activités parascolaires</a>
                    <a href="{{ route('config.rang.matiere') }}">Rang par matière</a>
                    <a href="{{ route('config.ecoles') }}">Liste des écoles</a>
                </div>

                <a href="#" class="sidebar-link menu-toggle" data-target="securite">
                    <i class="bi bi-database"></i>
                    <span>Sauvegardes et sécurité</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <div id="securite" class="submenu">
                    <a href="{{ route('config.users.list') }}">Gestion des accès</a>
                </div>



            @endif

        </div>

    </div>


    <!-- ================= CONTENT ================= -->
    <div class="content">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>
                <div class="school-name">
                    🏫 {{ $ecole?->nom_ecole ?: 'EduManage School' }}
                </div>

                <div class="school-meta">
                    @if ($ecole?->adresse)
                        📍 {{ $ecole->adresse }}
                    @endif

                    @if ($ecole?->telephone)
                        | 📞 {{ $ecole->telephone }}
                    @endif

                    @if ($ecole?->email)
                        | ✉️ {{ $ecole->email }}
                    @endif
                </div>
            </div>

            <div class="topbar-right">

                <!-- USER -->
                <div class="user-box">

                    <img class="avatar"
                        src="{{ Auth::user()->photo
                            ? asset('storage/' . Auth::user()->photo)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->email) }}"
                        alt="Photo de profil">

                    <span class="username">
                        {{ Auth::user()->email }}
                    </span>

                </div>

                <!-- LOGOUT -->
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="logout-btn">
                    🚪 Déconnexion
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="p-4">
            @yield('content')
        </div>

    </div>

    <!-- JS -->

    <script>
        (function() {
            function initMenus() {
                const menuToggles = document.querySelectorAll('.menu-toggle');

                menuToggles.forEach(function(item) {
                    if (item.dataset.menuInitialized === 'true') {
                        return;
                    }

                    item.dataset.menuInitialized = 'true';

                    const target = item.getAttribute('data-target');
                    const submenu = document.getElementById(target);

                    if (!submenu) return;

                    item.setAttribute('aria-expanded', 'false');
                    submenu.style.display = 'none';

                    item.addEventListener('click', function(event) {
                        event.preventDefault();

                        const isOpen = submenu.style.display === 'block';

                        menuToggles.forEach(function(otherItem) {
                            const otherTarget = otherItem.getAttribute('data-target');
                            const otherSubmenu = document.getElementById(otherTarget);

                            if (otherSubmenu && otherSubmenu !== submenu) {
                                otherSubmenu.style.display = 'none';
                                otherItem.setAttribute('aria-expanded', 'false');
                            }
                        });

                        if (isOpen) {
                            submenu.style.display = 'none';
                            item.setAttribute('aria-expanded', 'false');
                        } else {
                            submenu.style.display = 'block';
                            item.setAttribute('aria-expanded', 'true');
                        }
                    });
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initMenus, {
                    once: true
                });
            } else {
                initMenus();
            }

            window.addEventListener('pageshow', initMenus);
        })();
    </script>
    <!-- ======================================================
     SÉLECTEUR DE THÈMES (SIDEBAR TOUJOURS SOMBRE)
     Ajout non destructif — à placer juste avant </body>
====================================================== -->
    <style id="edumanage-themes-dark-sidebar">
        /* Verrouillage de la sidebar toujours sombre */
        html body .sidebar {
            background: linear-gradient(165deg, #0b1933 0%, #061329 100%) !important;
            color: #e8efff !important;
            border-right: 1px solid rgba(125, 161, 220, 0.14) !important;
        }

        /* Sélecteur dans la topbar */
        /* =====================================================
   MENU APPARENCE - EDUMANAGE
===================================================== */

        .theme-dropdown {
            position: relative;
        }

        .theme-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            height: 42px;
            padding: 0 16px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 12px;
            background: linear-gradient(135deg, #334155, #1e293b);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            transition: all .25s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .12);
        }

        .theme-btn:hover,
        .theme-btn:focus {
            background: linear-gradient(135deg, #475569, #334155);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(0, 0, 0, .16);
        }

        .theme-btn i {
            font-size: 16px;
        }

        .theme-menu {
            min-width: 210px;
            padding: 7px;
            margin-top: 8px !important;
            border: 1px solid #e5eaf1;
            border-radius: 13px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .16);
            z-index: 2000;
        }

        .theme-menu .dropdown-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            margin: 2px 0;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            color: #334155;
            transition: background .2s ease, color .2s ease;
        }

        .theme-menu .dropdown-item i {
            width: 18px;
            text-align: center;
            font-size: 16px;
        }

        .theme-menu .dropdown-item:hover {
            background: #edf3ff;
            color: #2563eb;
        }

        .theme-menu .dropdown-item.active-theme {
            background: #e8f0ff;
            color: #2563eb;
            font-weight: 700;
        }

        /* Adaptation du bouton dans le topbar sur petits écrans */
        @media (max-width: 768px) {
            .theme-btn {
                height: 38px;
                padding: 0 11px;
                font-size: 12px;
            }

            .theme-menu {
                min-width: 195px;
            }
        }

        .theme-select-wrap select {
            border: none;
            background: transparent;
            font-size: 12px;
            font-weight: 600;
            color: inherit;
            cursor: pointer;
            outline: none;
        }

        /* ==========================================
       1. MODE SOMBRE COMPLET (Contenu + Topbar)
    ========================================== */
        html[data-app-theme="dark"] body,
        html[data-app-theme="dark"] .content {
            background: #090e1a !important;
            color: #e2e8f0 !important;
        }

        html[data-app-theme="dark"] .topbar {
            background: rgba(13, 21, 38, 0.95) !important;
            border-bottom-color: #1e293b !important;
        }

        html[data-app-theme="dark"] .school-name,
        html[data-app-theme="dark"] .topbar h4,
        html[data-app-theme="dark"] .username {
            color: #f8fafc !important;
        }

        html[data-app-theme="dark"] .school-meta,
        html[data-app-theme="dark"] .topbar p {
            color: #94a3b8 !important;
        }

        html[data-app-theme="dark"] .user-box,
        html[data-app-theme="dark"] .theme-select-wrap {
            background: #162036 !important;
            border-color: #263554 !important;
            color: #f1f5f9 !important;
        }

        html[data-app-theme="dark"] .theme-select-wrap select option {
            background: #0f172a;
            color: #f8fafc;
        }

        html[data-app-theme="dark"] .content>.p-4 .card,
        html[data-app-theme="dark"] .content>.p-4 .modal-content {
            background-color: #111827 !important;
            color: #e2e8f0 !important;
            border-color: #1e293b !important;
        }

        html[data-app-theme="dark"] .content>.p-4 .table {
            color: #e2e8f0 !important;
            border-color: #1e293b !important;
        }

        html[data-app-theme="dark"] .content>.p-4 .form-control,
        html[data-app-theme="dark"] .content>.p-4 .form-select {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        /* ==========================================
       2. ULTRA PRO (Glassmorphism & Royal Gold)
    ========================================== */
        html[data-app-theme="ultra-pro"] body,
        html[data-app-theme="ultra-pro"] .content {
            background: #eef3fa !important;
            background-image: radial-gradient(circle at 15% 0%, rgba(37, 99, 235, 0.07), transparent 45%) !important;
        }

        html[data-app-theme="ultra-pro"] .topbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(14px);
            border-bottom-color: rgba(15, 23, 42, 0.08) !important;
        }

        html[data-app-theme="ultra-pro"] .user-box,
        html[data-app-theme="ultra-pro"] .theme-select-wrap {
            border-radius: 999px !important;
            border-color: rgba(37, 99, 235, 0.18) !important;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }

        html[data-app-theme="ultra-pro"] .avatar {
            border-color: #ffc928 !important;
        }

        html[data-app-theme="ultra-pro"] .content>.p-4 .card {
            border-radius: 14px !important;
            border-color: rgba(15, 23, 42, 0.07) !important;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.05) !important;
        }

        /* ==========================================
       3. ÉMERAUDE DOUX (Contenu apaisant)
    ========================================== */
        html[data-app-theme="emerald"] body,
        html[data-app-theme="emerald"] .content {
            background: #f0f7f4 !important;
        }

        html[data-app-theme="emerald"] .topbar {
            background: rgba(255, 255, 255, 0.95) !important;
            border-bottom-color: #d1e7dd !important;
        }

        html[data-app-theme="emerald"] .sidebar-menu>a.active {
            background: linear-gradient(100deg, #059669, #047857) !important;
            box-shadow: inset 3px 0 0 #6ee7b7 !important;
        }

        /* ==========================================
       4. CRÈME PRESTIGE (Chaud & Académique)
    ========================================== */
        html[data-app-theme="warm"] body,
        html[data-app-theme="warm"] .content {
            background: #faf7f2 !important;
        }

        html[data-app-theme="warm"] .topbar {
            background: rgba(255, 253, 250, 0.96) !important;
            border-bottom-color: #e7e0d5 !important;
        }

        html[data-app-theme="warm"] .sidebar-menu>a.active {
            background: linear-gradient(100deg, #b45309, #92400e) !important;
            box-shadow: inset 3px 0 0 #fde68a !important;
        }
    </style>

    <script id="edumanage-theme-dropdown-script">
        (function() {
            const KEY = 'edumanage_theme_choice';

            const themes = [{
                    id: 'default',
                    label: 'Clair Classique',
                    icon: 'bi-sun'
                },
                {
                    id: 'dark',
                    label: 'Mode Sombre',
                    icon: 'bi-moon'
                },
                {
                    id: 'ultra-pro',
                    label: 'Ultra Pro',
                    icon: 'bi-gem'
                },
                {
                    id: 'emerald',
                    label: 'Émeraude',
                    icon: 'bi-leaf'
                },
                {
                    id: 'warm',
                    label: 'Crème Prestige',
                    icon: 'bi-cup-hot'
                }
            ];

            function getSavedTheme() {
                try {
                    const saved = localStorage.getItem(KEY) || 'default';
                    return themes.some(t => t.id === saved) ? saved : 'default';
                } catch (e) {
                    return 'default';
                }
            }

            function applyTheme(themeId) {
                const validTheme = themes.some(t => t.id === themeId) ?
                    themeId :
                    'default';

                document.documentElement.setAttribute('data-app-theme', validTheme);

                try {
                    localStorage.setItem(KEY, validTheme);
                } catch (e) {}

                document.querySelectorAll('.theme-menu [data-theme]').forEach(item => {
                    item.classList.toggle(
                        'active-theme',
                        item.dataset.theme === validTheme
                    );
                });
            }

            function initThemeDropdown() {
                const topbarRight = document.querySelector('.topbar .topbar-right');

                if (!topbarRight) return;

                // Empêche la création de plusieurs boutons
                if (document.getElementById('edumanage-theme-dropdown')) {
                    applyTheme(getSavedTheme());
                    return;
                }

                const wrapper = document.createElement('div');
                wrapper.className = 'dropdown theme-dropdown';
                wrapper.id = 'edumanage-theme-dropdown';

                wrapper.innerHTML = `
            <button type="button"
                class="theme-btn dropdown-toggle"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                <i class="bi bi-palette2"></i>
                <span>Apparence</span>

            </button>

            <ul class="dropdown-menu dropdown-menu-end theme-menu">
                ${themes.map(theme => `
                        <li>
                            <button type="button"
                                class="dropdown-item"
                                data-theme="${theme.id}">
                                <i class="bi ${theme.icon}"></i>
                                <span>${theme.label}</span>
                            </button>
                        </li>
                    `).join('')}
            </ul>
        `;

                // Gestion du clic sur les thèmes
                wrapper.querySelectorAll('[data-theme]').forEach(item => {
                    item.addEventListener('click', function() {
                        const selectedTheme = this.dataset.theme;

                        // Appliquer le thème immédiatement
                        applyTheme(selectedTheme);

                        // Fermer le dropdown immédiatement
                        const toggle = wrapper.querySelector('.theme-btn');

                        if (window.bootstrap && toggle) {
                            const dropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
                            dropdown.hide();
                        }
                    });
                });

                // Ajouter le bouton dans la barre supérieure
                topbarRight.prepend(wrapper);

                // Restaurer le thème sauvegardé
                applyTheme(getSavedTheme());
            }

            function startTheme() {
                applyTheme(getSavedTheme());
                initThemeDropdown();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', startTheme, {
                    once: true
                });
            } else {
                startTheme();
            }

            window.addEventListener('pageshow', function() {
                applyTheme(getSavedTheme());
                initThemeDropdown();
            });

        })();
    </script>

</body>

</html>
