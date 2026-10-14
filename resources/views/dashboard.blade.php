@extends('layouts.app')

@section('content')
    <style>
        .dashboard-page {
            background: #f4f7fc;
            min-height: 100vh;
            padding: 28px;
            color: #172b4d;
        }

        .dashboard-heading {
            margin-bottom: 28px;
        }

        .dashboard-heading h1 {
            font-size: 28px;
            font-weight: 750;
            color: #142b4f;
            margin-bottom: 8px;
        }

        .dashboard-subtitle {
            color: #718096;
            font-size: 14px;
            margin: 0;
        }

        .welcome-panel {
            background: linear-gradient(120deg, #142b4f, #244b7a);
            border-radius: 20px;
            padding: 30px;
            color: #fff;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(20, 43, 79, .12);
        }

        .welcome-panel h2 {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-panel p {
            color: #dce8f8;
            margin: 0;
            max-width: 560px;
            line-height: 1.7;
        }

        .welcome-icon {
            font-size: 72px;
            color: rgba(255, 255, 255, .15);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #142b4f;
            margin-bottom: 18px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e8edf5;
            border-radius: 16px;
            padding: 22px;
            height: 100%;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(20, 43, 79, .08);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .icon-blue {
            background: #e8f1ff;
            color: #245ca8;
        }

        .icon-green {
            background: #e5f7ef;
            color: #16845b;
        }

        .icon-purple {
            background: #f0eaff;
            color: #7250bb;
        }

        .icon-orange {
            background: #fff1df;
            color: #c77a19;
        }

        .stat-label {
            color: #748198;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-value {
            color: #142b4f;
            font-size: 32px;
            font-weight: 750;
            line-height: 1.2;
        }

        .stat-description {
            font-size: 12px;
            color: #8a96a9;
            margin-top: 8px;
        }

        .dashboard-panel {
            background: #fff;
            border: 1px solid #e8edf5;
            border-radius: 16px;
            padding: 24px;
            height: 100%;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 15px;
            text-decoration: none;
            color: #263b59;
            border: 1px solid #edf0f6;
            border-radius: 12px;
            margin-bottom: 12px;
            transition: background .2s, border-color .2s;
        }

        .quick-link:last-child {
            margin-bottom: 0;
        }

        .quick-link:hover {
            background: #f4f8ff;
            border-color: #cdddf7;
            color: #194d91;
        }

        .quick-link-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            background: #edf3fc;
            color: #234e84;
            border-radius: 12px;
            font-size: 19px;
        }

        .quick-link-title {
            font-weight: 650;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .quick-link-description {
            font-size: 12px;
            color: #8591a4;
        }

        .quick-link-arrow {
            margin-left: auto;
            color: #9aa7ba;
        }

        .dashboard-footer {
            text-align: center;
            padding: 25px 0 5px;
            color: #96a1b2;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .dashboard-page {
                padding: 16px;
            }

            .welcome-panel {
                padding: 23px;
            }

            .welcome-panel h2 {
                font-size: 21px;
            }

            .dashboard-heading h1 {
                font-size: 24px;
            }

            .stat-value {
                font-size: 27px;
            }
        }

        @media print {
            .dashboard-page {
                background: white;
            }
        }
    </style>

    <div class="dashboard-page">

        {{-- En-tête --}}
        <div class="dashboard-heading">
            <h1>Tableau de bord</h1>
            <p class="dashboard-subtitle">
                Vue d'ensemble de votre établissement scolaire.
            </p>
        </div>

        {{-- Bannière de bienvenue --}}
        <div class="welcome-panel">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="small mb-2" style="color:#bcd5f5;">
                        ESPACE D'ADMINISTRATION
                    </div>

                    <h2>
                        Bienvenue sur EduManage
                    </h2>

                    <p>
                        Gérez votre établissement scolaire depuis un espace
                        unique. Consultez vos effectifs et accédez rapidement
                        aux principales fonctionnalités.
                    </p>
                </div>

                <div class="col-md-3 text-center d-none d-md-block">
                    <i class="bi bi-mortarboard-fill welcome-icon"></i>
                </div>
            </div>
        </div>

        {{-- Statistiques --}}
        <h3 class="section-title">
            Vue d'ensemble
        </h3>

        <div class="row g-4 mb-4">

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-label">Élèves inscrits</div>
                        <div class="stat-icon icon-blue">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>

                    <div class="stat-value">
                        {{ number_format($totalEleves, 0, ',', ' ') }}
                    </div>

                    <div class="stat-description">
                        Effectif total des élèves
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-label">Classes</div>
                        <div class="stat-icon icon-green">
                            <i class="bi bi-building"></i>
                        </div>
                    </div>

                    <div class="stat-value">
                        {{ number_format($totalClasses, 0, ',', ' ') }}
                    </div>

                    <div class="stat-description">
                        Classes enregistrées
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-label">Enseignants</div>
                        <div class="stat-icon icon-purple">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                    </div>

                    <div class="stat-value">
                        {{ number_format($totalEnseignants, 0, ',', ' ') }}
                    </div>

                    <div class="stat-description">
                        Personnel enseignant enregistré
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-label">Utilisateurs</div>
                        <div class="stat-icon icon-orange">
                            <i class="bi bi-person-gear"></i>
                        </div>
                    </div>

                    <div class="stat-value">
                        {{ number_format($totalUsers, 0, ',', ' ') }}
                    </div>

                    <div class="stat-description">
                        Comptes utilisateurs enregistrés
                    </div>
                </div>
            </div>

        </div>

        {{-- Accès rapides --}}
        <div class="row g-4">

            <div class="col-12 col-lg-7">
                <div class="dashboard-panel">
                    <h3 class="section-title">
                        <i class="bi bi-lightning-charge me-2"></i>
                        Accès rapides
                    </h3>

                    <a href="{{ route('eleves.index') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>
                            <div class="quick-link-title">
                                Gestion des élèves
                            </div>
                            <div class="quick-link-description">
                                Consulter et gérer les dossiers des élèves
                            </div>
                        </div>

                        <i class="bi bi-chevron-right quick-link-arrow"></i>
                    </a>

                    <a href="{{ route('classes.index') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="bi bi-building"></i>
                        </div>

                        <div>
                            <div class="quick-link-title">
                                Gestion des classes
                            </div>
                            <div class="quick-link-description">
                                Consulter les classes de l'établissement
                            </div>
                        </div>

                        <i class="bi bi-chevron-right quick-link-arrow"></i>
                    </a>

                    <a href="{{ route('matieres.index') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="bi bi-journal-bookmark"></i>
                        </div>

                        <div>
                            <div class="quick-link-title">
                                Gestion des matières
                            </div>
                            <div class="quick-link-description">
                                Consulter les matières enseignées
                            </div>
                        </div>

                        <i class="bi bi-chevron-right quick-link-arrow"></i>
                    </a>

                    <a href="{{ route('emplois-temps.index') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="bi bi-calendar-week"></i>
                        </div>

                        <div>
                            <div class="quick-link-title">
                                Emploi du temps
                            </div>
                            <div class="quick-link-description">
                                Consulter et organiser les horaires des classes
                            </div>
                        </div>

                        <i class="bi bi-chevron-right quick-link-arrow"></i>
                    </a>

                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="dashboard-panel">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle me-2"></i>
                        Votre espace de gestion
                    </h3>

                    <div class="p-3 rounded-3 mb-3" style="background:#f2f6fc;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon icon-blue">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <div class="fw-bold">
                                    Gestion centralisée
                                </div>
                                <div class="small text-secondary">
                                    Retrouvez vos fonctionnalités dans le menu
                                    de navigation.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 mb-3" style="background:#f2f8f5;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon icon-green">
                                <i class="bi bi-calendar-check"></i>
                            </div>

                            <div>
                                <div class="fw-bold">
                                    Organisation scolaire
                                </div>
                                <div class="small text-secondary">
                                    Gérez les classes, les matières et les
                                    emplois du temps.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3" style="background:#f7f4fc;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon icon-purple">
                                <i class="bi bi-journal-text"></i>
                            </div>

                            <div>
                                <div class="fw-bold">
                                    Suivi pédagogique
                                </div>
                                <div class="small text-secondary">
                                    Accédez aux modules pédagogiques depuis
                                    la barre latérale.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="dashboard-footer">
            EduManage — Système de gestion scolaire
        </div>

    </div>
@endsection
