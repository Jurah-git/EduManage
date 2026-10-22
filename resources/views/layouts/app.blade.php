<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EduManage</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ================= BODY ================= */

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {

            position: fixed;

            top: 0;
            left: 0;

            width: 270px;

            height: 100vh;

            background:
                linear-gradient(180deg,
                    #0f172a 0%,
                    #111827 50%,
                    #1e293b 100%);

            color: white;

            display: flex;

            flex-direction: column;

            z-index: 1000;

            box-shadow:
                4px 0 20px rgba(0, 0, 0, 0.15);

            overflow: hidden;
        }

        /* HEADER */

        .sidebar-header {

            min-height: 80px;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 20px;

            border-bottom:
                1px solid rgba(255, 255, 255, 0.08);

            background:
                rgba(216, 66, 66, 0.03);

            backdrop-filter: blur(10px);
        }

        /* LOGO */

        .sidebar-header .app-logo {
            width: 48px;
            height: 48px;
            min-width: 48px;
            object-fit: contain;
            border-radius: 10px;
            background: #ffffff;
            padding: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.25s ease;
        }

        .sidebar-header .app-logo:hover {
            transform: scale(1.05);
        }

        /* TITLE */

        .sidebar-title {

            display: flex;
            flex-direction: column;
        }

        .sidebar-title h3 {

            margin: 0;

            font-size: 20px;

            font-weight: 700;

            color: white;
        }

        .sidebar-title span {

            font-size: 12px;

            color: #94a3b8;
        }

        /* MENU ZONE */

        .sidebar-menu {

            flex: 1;

            overflow-y: auto;

            overflow-x: hidden;

            padding: 15px 12px;
        }

        /* SCROLLBAR */

        .sidebar-menu::-webkit-scrollbar {

            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {

            background: #334155;

            border-radius: 10px;
        }

        /* MENU LINK */

        .sidebar-menu a {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            padding: 13px 15px;

            margin-bottom: 6px;

            color: #e2e8f0;

            text-decoration: none;

            border-radius: 14px;

            transition: all 0.25s ease;

            font-size: 14px;

            font-weight: 500;
        }

        /* HOVER */

        .sidebar-menu a:hover {

            background:
                linear-gradient(90deg,
                    rgba(59, 130, 246, 0.20),
                    rgba(59, 130, 246, 0.05));

            transform: translateX(4px);

            color: white;
        }

        /* ACTIVE */

        .sidebar-menu a.active {

            background:
                linear-gradient(90deg,
                    #2563eb,
                    #1d4ed8);

            color: white;

            box-shadow:
                0 6px 18px rgba(37, 99, 235, 0.35);
        }

        /* SUBMENU */

        .submenu {

            display: none;

            margin-left: 12px;

            margin-bottom: 10px;

            padding-left: 12px;

            border-left:
                2px solid rgba(255, 255, 255, 0.08);
        }

        /* SUBMENU LINKS */

        .submenu a {

            font-size: 13px;

            padding: 10px 12px;

            color: #cbd5e1;

            background: none;
        }

        .submenu a:hover {

            background:
                rgba(255, 255, 255, 0.05);

            transform: none;
        }

        /* ================= CONTENT ================= */

        .content {

            margin-left: 270px;

            min-height: 100vh;

            display: flex;

            flex-direction: column;

            background: #b8d2ec;
        }

        /* ================= TOPBAR ================= */


        /* ================= EN-TÊTE PROFESSIONNEL ================= */

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
            padding: 16px 28px;
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
            backdrop-filter: blur(12px);
        }

        .topbar h4 {
            margin: 0;
            color: #0f172a;
            font-size: 19px;
            font-weight: 750;
            letter-spacing: -0.3px;
        }

        .topbar p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 12px;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }


        /* SCHOOL */

        .school-name {

            font-size: 18px;

            font-weight: 700;

            color: #0f172a;
        }

        .school-meta {

            font-size: 13px;

            color: #64748b;
        }

        /* USER BOX */

        .user-box {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 8px 14px;

            border-radius: 14px;

            background: #f8fafc;

            border:
                1px solid #e2e8f0;
        }

        /* USER AVATAR */

        .avatar {

            width: 45px;
            height: 45px;

            border-radius: 50%;

            object-fit: cover;

            border: 3px solid white;

            box-shadow:
                0 4px 10px rgba(0, 0, 0, 0.12);
        }

        .student-avatar {

            width: 55px !important;

            height: 55px !important;

            min-width: 55px;

            min-height: 55px;

            max-width: 55px;

            max-height: 55px;

            border-radius: 50% !important;

            object-fit: cover;

            display: block;

            border: 3px solid #ffffff;

            box-shadow:
                0 4px 10px rgba(0, 0, 0, 0.15);

            transition: 0.3s;
        }

        .student-avatar:hover {

            transform: scale(1.08);

            box-shadow:
                0 8px 20px rgba(0, 0, 0, 0.25);
        }

        /* USERNAME */

        .username {

            font-size: 13px;

            font-weight: 600;

            color: #0f172a;
        }

        /* RIGHT */

        .topbar-right {

            display: flex;

            align-items: center;

            gap: 15px;
        }

        /* LOGOUT */

        .logout-btn {

            background:
                linear-gradient(90deg,
                    #ef4444,
                    #dc2626);

            color: white;

            padding: 10px 16px;

            border-radius: 12px;

            text-decoration: none;

            font-size: 13px;

            font-weight: 600;

            transition: 0.25s;
        }

        .logout-btn:hover {

            transform: translateY(-2px);

            color: white;

            box-shadow:
                0 8px 18px rgba(239, 68, 68, 0.35);
        }

        /* ================= SIDEBAR PROFESSIONNELLE ================= */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            height: 100vh;
            background: linear-gradient(180deg, #111827 0%, #172554 100%);
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            box-shadow: 4px 0 24px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        /* En-tête fixe */

        .sidebar-header {
            min-height: 84px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.09);
            background: rgba(255, 255, 255, 0.025);
        }

        .sidebar-title h3 {
            margin: 0;
            font-size: 21px;
            font-weight: 750;
            letter-spacing: 0.3px;
            color: #ffffff;
        }

        .sidebar-title span {
            display: block;
            margin-top: 4px;
            font-size: 11px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #94a3b8;
        }

        /* Zone de navigation */

        .sidebar-menu {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 18px 12px;
            scrollbar-width: thin;
            scrollbar-color: #475569 transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        /* Liens principaux et sous-menus */

        .sidebar-menu a {
            box-sizing: border-box;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 5px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar-menu a:hover {
            color: #ffffff;
            background: rgba(96, 165, 250, 0.13);
        }

        .sidebar-menu a.active {
            color: #ffffff;
            background: linear-gradient(100deg, #2563eb, #1d4ed8);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.22);
        }

        /* Sous-menus */

        .submenu {
            display: none;
            margin: 2px 0 12px 15px;
            padding-left: 10px;
            border-left: 1px solid rgba(148, 163, 184, 0.3);
        }

        .sidebar-menu .submenu a {
            padding: 10px 12px;
            margin-bottom: 3px;
            font-size: 12.5px;
            color: #aebdd0;
            border-radius: 8px;
        }

        .sidebar-menu .submenu a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.07);
        }
    </style>
</head>

<body>

    <div class="sidebar">

        <!-- HEADER FIXE -->
        <div class="sidebar-header">

            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo EduManage" class="app-logo">

            <div class="sidebar-title">

                <h3>EduManage</h3>

                <span>ERP Scolaire</span>

            </div>

        </div>

        <!-- MENUS SCROLLABLES -->
        <div class="sidebar-menu">

            <a href="{{ route('dashboard') }}">🏠 Accueil</a>

            <!-- CONFIG -->
            <a href="#" class="menu-toggle" data-target="config">⚙️ Configuration</a>
            <div id="config" class="submenu">
                <a href="{{ route('config.users.create') }}">Ajouter utilisateur</a> <a
                    href="{{ route('config.users.list') }}"> Liste des utilisateurs</a> <a
                    href="{{ route('config.pointage') }}"> Pointage</a> <a
                    href="{{ route('config.annees-scolaires.create') }}">
                    <i class="bi bi-calendar-plus"></i>
                    Ajouter année scolaire
                </a>

                <a href="{{ route('config.annees-scolaires.index') }}">
                    <i class="bi bi-calendar-check"></i>
                    Année scolaire en cours
                </a>
                <a href="{{ route('config.droit.inscription') }}"> Droit d'inscription</a> <a
                    href="{{ route('config.droit.reinscription') }}"> Droit de réinscription</a> <a
                    href="{{ route('config.mode.paiement') }}"> Mode de paiement</a> <a
                    href="{{ route('config.ecoles') }}"> Liste des écoles</a> <a
                    href="{{ route('config.test.niveau') }}"> Test de niveau</a> <a
                    href="{{ route('config.frais.divers') }}">Frais divers</a> <a
                    href="{{ route('config.parascolaires') }}"> Parascolaires</a> <a
                    href="{{ route('config.rang.matiere') }}"> Rang matière</a>
            </div>

            <!-- CLASSE -->
            <a href="#" class="menu-toggle" data-target="classe">📚 Classe</a>
            <div id="classe" class="submenu">
                <a href="{{ route('classes.create') }}">Ajouter</a>
                <a href="{{ route('classes.index') }}">Liste</a>
            </div>

            <!-- MATIERE -->

            <a href="#" class="menu-toggle" data-target="matiere">

                📖 Matière

            </a>

            <div id="matiere" class="submenu">

                <a href="{{ route('matieres.create') }}">

                    Ajouter matière

                </a>

                <a href="{{ route('matieres.index') }}">

                    Liste matières

                </a>

                <a href="{{ route('coefficients.index') }}">

                    Coefficients

                </a>

            </div>

            <!-- ELEVE -->
            <a href="#" class="menu-toggle" data-target="eleve">🎓 Élève</a>
            <div id="eleve" class="submenu">
                <a href="{{ route('eleves.create') }}">Ajouter</a>
                <a href="{{ route('eleves.index') }}">Liste</a>
            </div>


            <!-- ENSEIGNANTS -->
            <a href="#" class="menu-toggle" data-target="enseignant">
                👨‍🏫 Enseignants
            </a>

            <div id="enseignant" class="submenu">
                <a href="{{ route('enseignants.create') }}">Ajouter</a>
                <a href="{{ route('enseignants.index') }}">Liste</a>
            </div>


            <!-- SALLES DE CLASSE -->
            <a href="#" class="menu-toggle" data-target="salle">
                🚪 Salles de classe
            </a>

            <div id="salle" class="submenu">
                <a href="{{ route('salles.create') }}">Ajouter</a>
                <a href="{{ route('salles.index') }}">Liste des salles</a>
            </div>

            <!-- CAHIER -->
            <a href="#" class="menu-toggle" data-target="cahier">📘 Cahier</a>
            <div id="cahier" class="submenu">
                <a href="{{ route('cahier.create') }}">Ajouter</a>
                <a href="{{ route('cahier.index') }}">Liste</a>
            </div>

            <!-- EMPLOI DU TEMPS -->
            <a href="#" class="menu-toggle" data-target="emploi">📅 Emploi du temps</a>
            <div id="emploi" class="submenu">
                <a href="{{ route('emplois-temps.create') }}">Ajouter</a>
                <a href="{{ route('emplois-temps.index') }}">Liste</a>
            </div>


            <!-- LIVRE -->
            <a href="#" class="menu-toggle" data-target="livre">📚 Livre</a>
            <div id="livre" class="submenu">
                <a href="{{ route('livres.create') }}">Ajouter</a>
                <a href="{{ route('livres.index') }}">Liste</a>
            </div>

            <!-- BIBLIO -->
            <a href="#" class="menu-toggle" data-target="biblio">🏫 Bibliothèque</a>
            <div id="biblio" class="submenu">
                <a href="{{ route('biblio.index') }}">Accueil</a>
                <a href="{{ route('biblio.emprunt') }}">Emprunts</a>
            </div>

            <!-- PARENTS -->
            <a href="#" class="menu-toggle" data-target="parents">👨‍👩‍👧 Parents</a>
            <div id="parents" class="submenu">
                <a href="{{ route('parents.index') }}">Liste parents</a>
            </div>

            <!-- PERIODE -->
            <a href="#" class="menu-toggle" data-target="periode">📆 Gestion des périodes</a>
            <div id="periode" class="submenu">

                <a href="{{ route('periodes.create') }}">
                    Créer une période
                </a>

                <a href="{{ route('periodes.index') }}">
                    Toutes les périodes
                </a>

            </div>

            <!-- BULLETIN -->
            <!-- BULLETIN -->
            <a href="#" class="menu-toggle" data-target="bulletin">

                🧾 Bulletin

            </a>

            <div id="bulletin" class="submenu">

                <a href="{{ route('bulletin.saisie') }}">

                    Saisie des notes

                </a>

                <a href="{{ route('bulletin.generer') }}">

                    Générer bulletin

                </a>

            </div>

        </div>
    </div>


    <!-- ================= CONTENT ================= -->
    <div class="content">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>
                <div class="school-name">🏫 EduManage School</div>
                <div class="school-meta">📍 Antananarivo | 📞 +261 34 56 899 69</div>
            </div>

            <div class="topbar-right">

                <!-- USER -->
                <div class="user-box">

                    <img class="avatar"
                        src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->email) }}">

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
        document.querySelectorAll('.menu-toggle').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                let target = this.getAttribute('data-target');
                let submenu = document.getElementById(target);

                submenu.style.display =
                    submenu.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>

</body>

</html>
