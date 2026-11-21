@extends('layouts.app')

@section('content')

    <style>
        /* =========================================================
           EDUMANAGE PREMIUM — USER DETAILS
        ========================================================= */

        .user-show-page {
            --us-primary: #304c68;
            --us-teal: #477d8c;
            --us-border: #e3e9ef;
            --us-text: #29394b;
            --us-muted: #7b8998;
            --us-bg: #f3f6f9;

            color: var(--us-text);
        }

        /* HEADER */
        .user-show-page .show-header {
            background: linear-gradient(135deg, #24364b, #395b76);
            border-radius: 20px;
            padding: 26px 30px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .user-show-page .show-header::before,
        .user-show-page .show-header::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
            pointer-events: none;
        }

        .user-show-page .show-header::before {
            width: 220px;
            height: 220px;
            right: -60px;
            top: -100px;
        }

        .user-show-page .show-header::after {
            width: 140px;
            height: 140px;
            right: 120px;
            bottom: -100px;
        }

        .user-show-page .header-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .15);
            color: #e5c78d;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .user-show-page .breadcrumb-text {
            font-size: .82rem;
            color: rgba(255, 255, 255, .65);
        }

        .user-show-page .show-header h3 {
            color: #fff;
            font-weight: 700;
            letter-spacing: -.4px;
        }

        .user-show-page .header-description {
            font-size: .9rem;
            color: rgba(255, 255, 255, .72);
        }

        .user-show-page .btn-header {
            color: white;
            border: 1px solid rgba(255, 255, 255, .25);
            background: rgba(255, 255, 255, .08);
            border-radius: 11px;
            padding: 10px 16px;
            transition: .2s;
            position: relative;
            z-index: 2;
        }

        .user-show-page .btn-header:hover {
            color: white;
            background: rgba(255, 255, 255, .17);
            transform: translateY(-1px);
        }

        /* CARDS */
        .user-show-page .show-card {
            background: white;
            border: 1px solid var(--us-border);
            border-radius: 17px;
            box-shadow: 0 4px 18px rgba(38, 58, 78, .035);
            overflow: hidden;
            margin-bottom: 22px;
        }

        .user-show-page .show-card-header {
            padding: 21px 24px;
            border-bottom: 1px solid #f0f3f6;
        }

        .user-show-page .show-card-body {
            padding: 23px 24px;
        }

        .user-show-page .section-icon {
            width: 39px;
            height: 39px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #edf3f8;
            color: var(--us-primary);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .user-show-page .section-icon.teal {
            background: #eaf3f3;
            color: var(--us-teal);
        }

        .user-show-page .section-icon.gold {
            background: #fbf4e8;
            color: #b7893f;
        }

        .user-show-page .section-icon.green {
            background: #eaf5ef;
            color: #258366;
        }

        .user-show-page .section-title {
            font-size: 1.02rem;
            font-weight: 700;
            color: #2b3e52;
            margin-bottom: 3px;
        }

        .user-show-page .section-subtitle {
            color: var(--us-muted);
            font-size: .82rem;
            margin: 0;
        }

        /* PROFILE */
        .user-show-page .profile-card {
            background: linear-gradient(180deg, #fff 0%, #fbfcfd 100%);
        }

        .user-show-page .profile-cover {
            height: 100px;
            background: linear-gradient(135deg, #304c68, #477d8c);
            position: relative;
            overflow: hidden;
        }

        .user-show-page .profile-cover::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            right: -30px;
            top: -45px;
        }

        .user-show-page .profile-content {
            padding: 0 23px 25px;
            text-align: center;
        }

        .user-show-page .avatar-wrapper {
            margin-top: -55px;
            position: relative;
            display: inline-block;
            z-index: 2;
        }

        .user-show-page .profile-avatar {
            width: 122px;
            height: 122px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            background: #e9eef3;
            box-shadow: 0 4px 15px rgba(30, 50, 70, .12);
        }

        .user-show-page .profile-name {
            font-size: 1.18rem;
            font-weight: 700;
            color: #2b3e52;
            margin-top: 13px;
            margin-bottom: 5px;
            overflow-wrap: anywhere;
        }

        .user-show-page .profile-email {
            color: var(--us-muted);
            font-size: .84rem;
            overflow-wrap: anywhere;
        }

        .user-show-page .profile-divider {
            height: 1px;
            background: #edf1f5;
            margin: 20px 0;
        }

        .user-show-page .profile-meta {
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 11px 0;
            border-bottom: 1px solid #f0f3f6;
            font-size: .84rem;
        }

        .user-show-page .profile-meta:last-child {
            border-bottom: 0;
        }

        .user-show-page .meta-label {
            color: var(--us-muted);
        }

        .user-show-page .meta-value {
            color: #34495e;
            font-weight: 600;
            text-align: right;
            overflow-wrap: anywhere;
        }

        /* STATUS */
        .user-show-page .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 30px;
            padding: 8px 13px;
            font-size: .82rem;
            font-weight: 700;
        }

        .user-show-page .status-active {
            background: #e8f6ef;
            color: #21805d;
            border: 1px solid #cdebdc;
        }

        .user-show-page .status-inactive {
            background: #f0f2f5;
            color: #778392;
            border: 1px solid #e0e5eb;
        }

        .user-show-page .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
        }

        /* ROLE */
        .user-show-page .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #edf3f8;
            color: #3d5c78;
            border: 1px solid #dce7f0;
            font-size: .8rem;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 9px;
            margin: 3px 4px 3px 0;
        }

        .user-show-page .role-admin {
            background: #fff0ee;
            color: #b54e43;
            border-color: #f2d4d0;
        }

        /* INFORMATION */
        .user-show-page .info-item {
            height: 100%;
            padding: 15px;
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 12px;
            transition: .2s ease;
        }

        .user-show-page .info-item:hover {
            background: #f3f7fa;
            border-color: #dce6ef;
            transform: translateY(-1px);
        }

        .user-show-page .info-label {
            font-size: .77rem;
            color: var(--us-muted);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .user-show-page .info-value {
            font-size: .92rem;
            color: #34495e;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .user-show-page .info-value.empty {
            font-weight: 400;
            font-style: italic;
            color: #a0acb8;
        }

        .user-show-page .address-box {
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 12px;
            padding: 16px;
            font-size: .9rem;
            color: #43566a;
            line-height: 1.7;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* ACCOUNT */
        .user-show-page .account-box {
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 12px;
            padding: 16px;
        }

        .user-show-page .account-label {
            font-size: .78rem;
            color: var(--us-muted);
            margin-bottom: 6px;
        }

        .user-show-page .account-value {
            font-size: .9rem;
            font-weight: 600;
            color: #34495e;
            overflow-wrap: anywhere;
        }

        /* SECURITY */
        .user-show-page .security-notice {
            background: #f1f6fa;
            border: 1px solid #e0ebf3;
            border-radius: 11px;
            color: #587188;
            font-size: .82rem;
            line-height: 1.6;
            padding: 14px 15px;
        }

        /* ACTIONS */
        .user-show-page .action-card {
            background: white;
            border: 1px solid var(--us-border);
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(38, 58, 78, .035);
        }

        .user-show-page .btn-edit {
            background: linear-gradient(135deg, #304c68, #477d8c);
            color: white;
            border: 0;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: .87rem;
            transition: .2s;
        }

        .user-show-page .btn-edit:hover {
            background: linear-gradient(135deg, #24364b, #396b7b);
            color: white;
            transform: translateY(-1px);
        }

        .user-show-page .btn-cancel {
            background: #f4f6f8;
            color: #586b7d;
            border: 1px solid #e3e9ef;
            border-radius: 10px;
            padding: 10px 17px;
            font-weight: 600;
            font-size: .87rem;
        }

        .user-show-page .btn-cancel:hover {
            background: #e9eef2;
            color: #33495e;
        }

        /* RESPONSIVE */
        @media(max-width:767.98px) {
            .user-show-page .show-header {
                padding: 21px;
                border-radius: 15px;
            }

            .user-show-page .show-header h3 {
                font-size: 1.25rem;
            }

            .user-show-page .show-card-header {
                padding: 18px;
            }

            .user-show-page .show-card-body {
                padding: 18px;
            }

            .user-show-page .btn-edit,
            .user-show-page .btn-cancel {
                width: 100%;
                justify-content: center;
            }
        }
    </style>


    <div class="container-fluid px-3 px-md-4 py-4 user-show-page">

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
        <div class="show-header mb-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 position-relative">

                <div class="d-flex align-items-start gap-3">

                    <div class="header-icon">
                        <i class="bi bi-person-vcard"></i>
                    </div>

                    <div>
                        <div class="breadcrumb-text mb-2">
                            Configuration / Gestion des utilisateurs / Profil
                        </div>

                        <h3 class="mb-1">
                            Fiche utilisateur
                        </h3>

                        <p class="header-description mb-0">
                            Consultation détaillée des informations du compte.
                        </p>
                    </div>

                </div>

                <a href="{{ route('config.users.list') }}" class="btn btn-header">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour à la liste
                </a>

            </div>

        </div>


        {{-- =====================================================
         CONTENU PRINCIPAL
    ====================================================== --}}
        <div class="row g-4">

            {{-- COLONNE GAUCHE --}}
            <div class="col-lg-4">

                {{-- PROFIL --}}
                <div class="show-card profile-card">

                    <div class="profile-cover"></div>

                    <div class="profile-content">

                        <div class="avatar-wrapper">

                            @if ($user->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->photo))
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de {{ $user->name }}"
                                    class="profile-avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=34495e&color=fff&size=150"
                                    alt="Avatar de {{ $user->name }}" class="profile-avatar">
                            @endif

                        </div>

                        <h5 class="profile-name">
                            {{ $user->name }}
                        </h5>

                        <div class="profile-email">
                            <i class="bi bi-envelope me-1"></i>
                            {{ $user->email }}
                        </div>

                        <div class="profile-divider"></div>

                        {{-- IDENTIFIANT --}}
                        <div class="profile-meta">
                            <span class="meta-label">
                                <i class="bi bi-hash me-1"></i>Identifiant
                            </span>

                            <span class="meta-value">
                                #{{ $user->id }}
                            </span>
                        </div>

                        {{-- STATUT --}}
                        <div class="profile-meta">
                            <span class="meta-label">
                                <i class="bi bi-toggle2-on me-1"></i>Statut
                            </span>

                            @if ($user->statut)
                                <span class="status-badge status-active">
                                    <span class="status-indicator"></span>
                                    Actif
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <span class="status-indicator"></span>
                                    Inactif
                                </span>
                            @endif
                        </div>

                        {{-- ROLE --}}
                        <div class="profile-meta">
                            <span class="meta-label">
                                <i class="bi bi-shield-check me-1"></i>Rôle
                            </span>

                            <span class="meta-value">
                                @if ($user->id == 1)
                                    Administrateur principal
                                @elseif ($user->getRoleNames()->isNotEmpty())
                                    {{ $user->getRoleNames()->join(', ') }}
                                @else
                                    Aucun rôle
                                @endif
                            </span>
                        </div>

                    </div>

                </div>


                {{-- ROLES & PERMISSIONS --}}
                <div class="show-card">

                    <div class="show-card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>

                            <div>
                                <div class="section-title">Rôles & permissions</div>
                                <p class="section-subtitle">Attributions du compte</p>
                            </div>

                        </div>

                    </div>

                    <div class="show-card-body">

                        @if ($user->id == 1)
                            <span class="role-badge role-admin">
                                <i class="bi bi-shield-fill-check"></i>
                                Administrateur principal
                            </span>
                        @else
                            @forelse ($user->getRoleNames() as $role)
                                <span class="role-badge">
                                    <i class="bi bi-shield-fill-check"></i>
                                    {{ $role }}
                                </span>
                            @empty
                                <div class="text-muted small">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Aucun rôle attribué à ce compte.
                                </div>
                            @endforelse
                        @endif

                        <div class="security-notice mt-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Les rôles déterminent les accès disponibles pour cet utilisateur dans EduManage.
                        </div>

                    </div>

                </div>

            </div>


            {{-- COLONNE DROITE --}}
            <div class="col-lg-8">

                {{-- INFORMATIONS PERSONNELLES --}}
                <div class="show-card">

                    <div class="show-card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon">
                                <i class="bi bi-person-vcard"></i>
                            </div>

                            <div>
                                <div class="section-title">Informations personnelles</div>
                                <p class="section-subtitle">
                                    Identité et coordonnées de l'utilisateur.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="show-card-body">

                        <div class="row g-3">

                            {{-- NOM --}}
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="bi bi-person"></i>
                                        Nom complet
                                    </div>

                                    <div class="info-value">
                                        {{ $user->name ?: 'Non renseigné' }}
                                    </div>
                                </div>
                            </div>

                            {{-- SEXE --}}
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="bi bi-gender-ambiguous"></i>
                                        Sexe
                                    </div>

                                    <div class="info-value {{ !$user->sexe ? 'empty' : '' }}">
                                        {{ $user->sexe ?: 'Non renseigné' }}
                                    </div>
                                </div>
                            </div>

                            {{-- DATE NAISSANCE --}}
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="bi bi-calendar-heart"></i>
                                        Date de naissance
                                    </div>

                                    <div class="info-value {{ !$user->date_naissance ? 'empty' : '' }}">
                                        {{ $user->date_naissance ? \Carbon\Carbon::parse($user->date_naissance)->format('d/m/Y') : 'Non renseignée' }}
                                    </div>
                                </div>
                            </div>

                            {{-- TELEPHONE --}}
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="bi bi-telephone"></i>
                                        Téléphone
                                    </div>

                                    <div class="info-value {{ !$user->telephone ? 'empty' : '' }}">
                                        {{ $user->telephone ?: 'Non renseigné' }}
                                    </div>
                                </div>
                            </div>

                            {{-- FONCTION --}}
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="bi bi-briefcase"></i>
                                        Fonction
                                    </div>

                                    <div class="info-value {{ !$user->fonction ? 'empty' : '' }}">
                                        {{ $user->fonction ?: 'Non renseignée' }}
                                    </div>
                                </div>
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="bi bi-envelope"></i>
                                        Adresse e-mail
                                    </div>

                                    <div class="info-value">
                                        {{ $user->email ?: 'Non renseignée' }}
                                    </div>
                                </div>
                            </div>

                            {{-- ADRESSE --}}
                            <div class="col-12">
                                <div class="info-label mb-2">
                                    <i class="bi bi-geo-alt"></i>
                                    Adresse
                                </div>

                                <div class="address-box {{ !$user->adresse ? 'text-muted fst-italic' : '' }}">
                                    @if ($user->adresse)
                                        {{ $user->adresse }}
                                    @else
                                        Adresse non renseignée.
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- INFORMATIONS DU COMPTE --}}
                <div class="show-card">

                    <div class="show-card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon teal">
                                <i class="bi bi-clock-history"></i>
                            </div>

                            <div>
                                <div class="section-title">Informations du compte</div>
                                <p class="section-subtitle">
                                    Historique et données administratives.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="show-card-body">

                        <div class="row g-3">

                            {{-- ID --}}
                            <div class="col-md-4">
                                <div class="account-box h-100">
                                    <div class="account-label">
                                        Identifiant utilisateur
                                    </div>

                                    <div class="account-value">
                                        #{{ $user->id }}
                                    </div>
                                </div>
                            </div>

                            {{-- CREATION --}}
                            <div class="col-md-4">
                                <div class="account-box h-100">
                                    <div class="account-label">
                                        <i class="bi bi-calendar-plus me-1"></i>
                                        Créé le
                                    </div>

                                    <div class="account-value">
                                        {{ $user->created_at?->format('d/m/Y à H:i') ?? 'Inconnu' }}
                                    </div>
                                </div>
                            </div>

                            {{-- MODIFICATION --}}
                            <div class="col-md-4">
                                <div class="account-box h-100">
                                    <div class="account-label">
                                        <i class="bi bi-pencil me-1"></i>
                                        Dernière modification
                                    </div>

                                    <div class="account-value">
                                        {{ $user->updated_at?->format('d/m/Y à H:i') ?? 'Inconnue' }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- SECURITE --}}
                <div class="show-card">

                    <div class="show-card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon gold">
                                <i class="bi bi-lock"></i>
                            </div>

                            <div>
                                <div class="section-title">Sécurité & confidentialité</div>
                                <p class="section-subtitle">
                                    Protection des informations de connexion.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="show-card-body">

                        <div class="security-notice">
                            <i class="bi bi-shield-lock-fill me-1"></i>
                            <strong>Compte protégé.</strong>
                            Le mot de passe n'est jamais affiché sur cette page.
                            Pour toute modification des informations de connexion,
                            utilisez la fonction de modification du compte.
                        </div>

                    </div>

                </div>


                {{-- BOUTONS --}}
                <div class="action-card">

                    <div class="p-3 p-md-4 d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <div class="small text-muted">
                            <i class="bi bi-eye me-1"></i>
                            Mode consultation — aucune modification effectuée.
                        </div>

                        <div class="d-flex flex-wrap gap-2">

                            <a href="{{ route('config.users.list') }}" class="btn btn-cancel">
                                <i class="bi bi-arrow-left me-1"></i>
                                Retour
                            </a>

                            <a href="{{ route('config.users.edit', $user) }}" class="btn btn-edit">
                                <i class="bi bi-pencil-square me-1"></i>
                                Modifier ce profil
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
