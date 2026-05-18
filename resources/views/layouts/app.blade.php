<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EduManage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .sidebar-header img {

            width: 42px;
            height: 42px;

            border-radius: 12px;

            object-fit: cover;

            box-shadow:
                0 4px 10px rgba(0, 0, 0, 0.25);
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

        .topbar {

            position: sticky;

            top: 0;

            z-index: 900;

            background: white;

            padding: 14px 25px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            border-bottom:
                1px solid #e2e8f0;

            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.04);
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
    </style>
</head>

<body>

    <div class="sidebar">

        <!-- HEADER FIXE -->
        <div class="sidebar-header">

            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png">

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
                    href="{{ route('config.pointage') }}"> Pointage</a> <a href="{{ route('config.annee.create') }}">
                    Ajouter année scolaire</a> <a href="{{ route('config.annee.current') }}"> Année scolaire en
                    cours</a> <a href="{{ route('config.droit.inscription') }}"> Droit d'inscription</a> <a
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
            <a href="#" class="menu-toggle" data-target="matiere">📖 Matière</a>
            <div id="matiere" class="submenu">
                <a href="{{ route('matieres.create') }}">Ajouter</a>
                <a href="{{ route('matieres.index') }}">Liste</a>
            </div>

            <!-- ELEVE -->
            <a href="#" class="menu-toggle" data-target="eleve">🎓 Élève</a>
            <div id="eleve" class="submenu">
                <a href="{{ route('eleves.create') }}">Ajouter</a>
                <a href="{{ route('eleves.index') }}">Liste</a>
            </div>

            <!-- CAHIER -->
            <a href="#" class="menu-toggle" data-target="cahier">📘 Cahier</a>
            <div id="cahier" class="submenu">
                <a href="{{ route('cahier.create') }}">Ajouter</a>
                <a href="{{ route('cahier.index') }}">Liste</a>
            </div>

            <!-- EMPLOI -->
            <a href="#" class="menu-toggle" data-target="emploi">📅 Emploi</a>
            <div id="emploi" class="submenu">
                <a href="{{ route('emploi.create') }}">Ajouter</a>
                <a href="{{ route('emploi.index') }}">Liste</a>
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
            <a href="#" class="menu-toggle" data-target="bulletin">🧾 Bulletin</a>

            <div id="bulletin" class="submenu">

                <a href="{{ route('bulletin.saisie') }}">Saisie des notes</a>

               

               

            </div>

        </div>
    </div>


    <!-- ================= CONTENT ================= -->
    <div class="content">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>
                <div class="school-name">🏫 EduManage School</div>
                <div class="school-meta">📍 Antananarivo | 📞 +261 34 00 000 00</div>
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
