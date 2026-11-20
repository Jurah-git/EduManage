@extends('layouts.app')

@section('content')

    <style>
        /* =========================================================
           EDUMANAGE PREMIUM — EDIT USER
        ========================================================= */

        .user-edit-page {
            --ue-primary: #304c68;
            --ue-primary-dark: #24364b;
            --ue-teal: #477d8c;
            --ue-bg: #f3f6f9;
            --ue-border: #e3e9ef;
            --ue-text: #29394b;
            --ue-muted: #7b8998;
            --ue-success: #258366;
            --ue-gold: #d5a85d;

            color: var(--ue-text);
        }

        /* Fond général */
        .user-edit-page .page-header {
            background: linear-gradient(135deg, #24364b, #395b76);
            border-radius: 20px;
            padding: 26px 30px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .user-edit-page .page-header::after {
            content: "";
            position: absolute;
            width: 210px;
            height: 210px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .045);
            right: -60px;
            top: -100px;
        }

        .user-edit-page .page-header::before {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
            right: 100px;
            bottom: -100px;
        }

        .user-edit-page .page-header h3 {
            color: #fff;
            font-weight: 700;
            letter-spacing: -.4px;
        }

        .user-edit-page .breadcrumb-text {
            color: rgba(255, 255, 255, .66);
            font-size: .82rem;
        }

        .user-edit-page .header-description {
            color: rgba(255, 255, 255, .72);
            font-size: .9rem;
        }

        .user-edit-page .header-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #e5c78d;
            font-size: 1.35rem;
        }

        .user-edit-page .btn-header-back {
            color: white;
            border: 1px solid rgba(255, 255, 255, .25);
            background: rgba(255, 255, 255, .08);
            border-radius: 11px;
            padding: 10px 16px;
            transition: .2s ease;
            position: relative;
            z-index: 2;
        }

        .user-edit-page .btn-header-back:hover {
            background: rgba(255, 255, 255, .17);
            color: white;
            transform: translateY(-1px);
        }

        /* Cartes */
        .user-edit-page .premium-card {
            background: #fff;
            border: 1px solid var(--ue-border);
            border-radius: 17px;
            box-shadow: 0 4px 18px rgba(38, 58, 78, .035);
            overflow: hidden;
            margin-bottom: 22px;
        }

        .user-edit-page .premium-card-header {
            padding: 22px 24px 16px;
            background: #fff;
            border-bottom: 1px solid #f0f3f6;
        }

        .user-edit-page .premium-card-body {
            padding: 23px 24px;
        }

        .user-edit-page .section-icon {
            width: 39px;
            height: 39px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #edf3f8;
            color: var(--ue-primary);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .user-edit-page .section-icon.teal {
            background: #eaf3f3;
            color: var(--ue-teal);
        }

        .user-edit-page .section-icon.gold {
            background: #fbf4e8;
            color: #b7893f;
        }

        .user-edit-page .section-icon.green {
            background: #eaf5ef;
            color: var(--ue-success);
        }

        .user-edit-page .section-title {
            font-weight: 700;
            color: #2b3e52;
            font-size: 1.02rem;
            margin-bottom: 3px;
        }

        .user-edit-page .section-subtitle {
            color: var(--ue-muted);
            font-size: .82rem;
            margin: 0;
        }

        /* Profil */
        .user-edit-page .profile-card {
            background: linear-gradient(180deg, #fff 0%, #fbfcfd 100%);
        }

        .user-edit-page .profile-cover {
            height: 82px;
            background: linear-gradient(135deg, #304c68, #477d8c);
            position: relative;
        }

        .user-edit-page .profile-cover::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            right: -30px;
            top: -45px;
        }

        .user-edit-page .profile-content {
            padding: 0 23px 24px;
            text-align: center;
        }

        .user-edit-page .profile-avatar-wrapper {
            margin-top: -48px;
            position: relative;
            display: inline-block;
            z-index: 2;
        }

        .user-edit-page .profile-avatar {
            width: 112px;
            height: 112px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            background: #e9eef3;
            box-shadow: 0 4px 15px rgba(30, 50, 70, .12);
        }

        .user-edit-page .avatar-camera {
            position: absolute;
            right: 3px;
            bottom: 7px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--ue-primary);
            color: white;
            border: 3px solid white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: .78rem;
        }

        .user-edit-page .profile-name {
            color: #2b3e52;
            font-size: 1.08rem;
            font-weight: 700;
            margin-top: 13px;
            margin-bottom: 4px;
            overflow-wrap: anywhere;
        }

        .user-edit-page .profile-email {
            color: var(--ue-muted);
            font-size: .82rem;
            overflow-wrap: anywhere;
        }

        .user-edit-page .profile-divider {
            height: 1px;
            background: #edf1f5;
            margin: 20px 0;
        }

        /* Formulaires */
        .user-edit-page .form-label {
            color: #415366;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .user-edit-page .form-control,
        .user-edit-page .form-select {
            border: 1px solid #dfe6ed;
            border-radius: 10px;
            min-height: 43px;
            font-size: .9rem;
            color: #33465a;
            background-color: #fff;
            transition: border-color .2s, box-shadow .2s;
        }

        .user-edit-page textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .user-edit-page .form-control::placeholder {
            color: #aab5c0;
            font-size: .85rem;
        }

        .user-edit-page .form-control:focus,
        .user-edit-page .form-select:focus {
            border-color: #7099b5;
            box-shadow: 0 0 0 3px rgba(71, 125, 140, .11);
        }

        .user-edit-page .input-group .form-control {
            border-radius: 10px 0 0 10px;
        }

        .user-edit-page .input-group .btn {
            border-color: #dfe6ed;
            border-radius: 0 10px 10px 0;
            color: #65798d;
            background: #f8fafc;
        }

        .user-edit-page .input-group .btn:hover {
            background: #edf3f7;
            color: var(--ue-primary);
        }

        .user-edit-page .form-text {
            color: #8492a1;
            font-size: .78rem;
        }

        /* Photo */
        .user-edit-page .photo-upload {
            border: 1px dashed #cbd7e1;
            border-radius: 12px;
            padding: 14px;
            background: #f8fafc;
            transition: .2s;
        }

        .user-edit-page .photo-upload:hover {
            border-color: #7295ae;
            background: #f3f7fa;
        }

        /* Statut */
        .user-edit-page .status-panel {
            padding: 14px;
            border-radius: 12px;
            background: #f7f9fb;
            border: 1px solid #edf1f5;
        }

        .user-edit-page .status-dot {
            width: 9px;
            height: 9px;
            display: inline-block;
            border-radius: 50%;
            background: #27a477;
            margin-right: 7px;
        }

        .user-edit-page .status-help {
            font-size: .78rem;
            color: var(--ue-muted);
            line-height: 1.5;
        }

        /* Rôles */
        .user-edit-page .role-badge {
            background: #edf3f8;
            color: #3d5c78;
            border: 1px solid #dce7f0;
            font-size: .78rem;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin: 3px 4px 3px 0;
        }

        .user-edit-page .role-info {
            background: #f7f9fb;
            border: 1px solid #edf1f5;
            border-radius: 10px;
            padding: 12px;
            color: #7b8998;
            font-size: .79rem;
            line-height: 1.5;
        }

        /* Sécurité */
        .user-edit-page .security-notice {
            background: #f1f6fa;
            border: 1px solid #e0ebf3;
            border-radius: 11px;
            color: #587188;
            font-size: .82rem;
            line-height: 1.6;
            padding: 13px 15px;
        }

        .user-edit-page .security-label {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .user-edit-page .security-divider {
            border: 0;
            border-top: 1px solid #edf1f5;
            margin: 22px 0;
        }

        .user-edit-page .password-optional {
            font-weight: 400;
            color: #99a5b1;
            font-size: .75rem;
        }

        /* Alertes */
        .user-edit-page .alert {
            border-radius: 12px;
            font-size: .87rem;
        }

        .user-edit-page .alert ul {
            padding-left: 20px;
        }

        /* Actions */
        .user-edit-page .action-card {
            background: #fff;
            border: 1px solid var(--ue-border);
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(38, 58, 78, .035);
        }

        .user-edit-page .btn-cancel {
            background: #f4f6f8;
            color: #586b7d;
            border: 1px solid #e3e9ef;
            border-radius: 10px;
            padding: 10px 17px;
            font-weight: 600;
            font-size: .87rem;
        }

        .user-edit-page .btn-cancel:hover {
            background: #e9eef2;
            color: #33495e;
        }

        .user-edit-page .btn-save {
            background: linear-gradient(135deg, #304c68, #477d8c);
            color: white;
            border: 0;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: .87rem;
            box-shadow: 0 4px 10px rgba(48, 76, 104, .18);
            transition: .2s;
        }

        .user-edit-page .btn-save:hover {
            background: linear-gradient(135deg, #24364b, #396b7b);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(48, 76, 104, .24);
        }

        /* Responsive */
        @media (max-width: 767.98px) {
            .user-edit-page .page-header {
                padding: 21px;
                border-radius: 15px;
            }

            .user-edit-page .premium-card-header {
                padding: 18px 18px 14px;
            }

            .user-edit-page .premium-card-body {
                padding: 18px;
            }

            .user-edit-page .page-header h3 {
                font-size: 1.25rem;
            }

            .user-edit-page .btn-save,
            .user-edit-page .btn-cancel {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="container-fluid px-3 px-md-4 py-4 user-edit-page">

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
        <div class="page-header mb-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 position-relative">

                <div class="d-flex align-items-start gap-3">

                    <div class="header-icon">
                        <i class="bi bi-person-gear"></i>
                    </div>

                    <div>
                        <div class="breadcrumb-text mb-2">
                            Configuration / Gestion des utilisateurs / Modification
                        </div>

                        <h3 class="mb-1">
                            Modifier un utilisateur
                        </h3>

                        <p class="header-description mb-0">
                            Gérez le profil, les informations et la sécurité du compte.
                        </p>
                    </div>

                </div>

                <a href="{{ route('config.users.list') }}" class="btn btn-header-back">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour à la liste
                </a>

            </div>
        </div>

        {{-- =====================================================
         ERREURS
    ====================================================== --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4">
                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Certaines informations nécessitent votre attention.
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- =====================================================
         FORMULAIRE
    ====================================================== --}}
        <form method="POST" action="{{ route('config.users.update', $user) }}" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- =================================================
                 COLONNE GAUCHE
            ================================================== --}}
                <div class="col-lg-4">

                    {{-- PROFIL --}}
                    <div class="premium-card profile-card">

                        <div class="profile-cover"></div>

                        <div class="profile-content">

                            <div class="profile-avatar-wrapper">

                                @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil"
                                        id="userPhotoPreview" class="profile-avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=34495e&color=fff&size=150"
                                        alt="Avatar" id="userPhotoPreview" class="profile-avatar">
                                @endif

                                <div class="avatar-camera">
                                    <i class="bi bi-camera-fill"></i>
                                </div>

                            </div>

                            <h5 class="profile-name">{{ $user->name }}</h5>
                            <div class="profile-email">{{ $user->email }}</div>

                            <div class="profile-divider"></div>

                            <div class="text-start">

                                <label class="form-label mb-2">
                                    <i class="bi bi-image me-1"></i>
                                    Photo de profil
                                </label>

                                <div class="photo-upload">

                                    <input type="file" name="photo" id="userPhotoInput" class="form-control"
                                        accept="image/jpeg,image/png,image/webp">

                                    <div class="form-text mt-2">
                                        Formats JPG, PNG ou WEBP. Taille maximale : 2 Mo.
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- STATUT --}}
                    <div class="premium-card">

                        <div class="premium-card-body">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="section-icon green">
                                    <i class="bi bi-toggle2-on"></i>
                                </div>

                                <div>
                                    <div class="section-title">État du compte</div>
                                    <div class="section-subtitle">Disponibilité du compte utilisateur</div>
                                </div>
                            </div>

                            <label class="form-label">Statut du compte</label>

                            <select name="statut" class="form-select" required>
                                <option value="1" @selected(old('statut', (string) (int) $user->statut) == '1')>
                                    Actif
                                </option>

                                <option value="0" @selected(old('statut', (string) (int) $user->statut) == '0')>
                                    Inactif
                                </option>
                            </select>

                            <div class="status-panel mt-3">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="status-dot"></span>
                                    <span class="fw-semibold small text-dark">Statut administratif</span>
                                </div>

                                <div class="status-help">
                                    Ce statut indique si le compte est déclaré actif ou inactif dans EduManage.
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- RÔLES --}}
                    <div class="premium-card">

                        <div class="premium-card-body">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="section-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <div>
                                    <div class="section-title">Rôles & permissions</div>
                                    <div class="section-subtitle">Accès attribués au compte</div>
                                </div>
                            </div>

                            @forelse($user->getRoleNames() as $role)
                                <span class="role-badge">
                                    <i class="bi bi-shield-fill-check"></i>
                                    {{ $role }}
                                </span>
                            @empty
                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                    Aucun rôle attribué
                                </span>
                            @endforelse

                            <div class="role-info mt-3">
                                <i class="bi bi-info-circle me-1"></i>
                                Les rôles et permissions existants sont conservés lors de cette modification.
                            </div>

                        </div>

                    </div>

                </div>

                {{-- =================================================
                 COLONNE DROITE
            ================================================== --}}
                <div class="col-lg-8">

                    {{-- INFORMATIONS PERSONNELLES --}}
                    <div class="premium-card">

                        <div class="premium-card-header">
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

                        <div class="premium-card-body">

                            <div class="row g-3">

                                {{-- NOM --}}
                                <div class="col-md-6">
                                    <label class="form-label">
                                        Nom complet <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}" placeholder="Nom et prénom" required>
                                </div>

                                {{-- SEXE --}}
                                <div class="col-md-6">
                                    <label class="form-label">Sexe</label>

                                    <select name="sexe" class="form-select">
                                        <option value="">Sélectionner</option>

                                        <option value="Masculin" @selected(old('sexe', $user->sexe) == 'Masculin')>
                                            Masculin
                                        </option>

                                        <option value="Féminin" @selected(old('sexe', $user->sexe) == 'Féminin')>
                                            Féminin
                                        </option>
                                    </select>
                                </div>

                                {{-- DATE --}}
                                <div class="col-md-6">
                                    <label class="form-label">Date de naissance</label>

                                    <input type="date" name="date_naissance" class="form-control"
                                        value="{{ old('date_naissance', $user->date_naissance?->format('Y-m-d')) }}">
                                </div>

                                {{-- TELEPHONE --}}
                                <div class="col-md-6">
                                    <label class="form-label">Téléphone</label>

                                    <input type="text" name="telephone" class="form-control"
                                        value="{{ old('telephone', $user->telephone) }}"
                                        placeholder="Ex. : 034 XX XXX XX">
                                </div>

                                {{-- ADRESSE --}}
                                <div class="col-12">
                                    <label class="form-label">Adresse</label>

                                    <textarea name="adresse" class="form-control" rows="3" placeholder="Adresse complète">{{ old('adresse', $user->adresse) }}</textarea>
                                </div>

                                {{-- FONCTION --}}
                                <div class="col-12">
                                    <label class="form-label">Fonction</label>

                                    <input type="text" name="fonction" class="form-control"
                                        value="{{ old('fonction', $user->fonction) }}"
                                        placeholder="Ex. : Directeur, Enseignant, Secrétaire...">
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- CONNEXION ET SECURITE --}}
                    <div class="premium-card">

                        <div class="premium-card-header">

                            <div class="d-flex align-items-center gap-3">

                                <div class="section-icon teal">
                                    <i class="bi bi-lock"></i>
                                </div>

                                <div>
                                    <div class="section-title">Connexion & sécurité</div>
                                    <p class="section-subtitle">
                                        Adresse e-mail et gestion du mot de passe.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="premium-card-body">

                            {{-- EMAIL --}}
                            <div class="mb-4">

                                <label class="form-label">
                                    Adresse e-mail <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"
                                        style="border-radius:10px 0 0 10px;color:#708397;">
                                        <i class="bi bi-envelope"></i>
                                    </span>

                                    <input type="email" name="email" class="form-control border-start-0"
                                        value="{{ old('email', $user->email) }}" required
                                        style="border-radius:0 10px 10px 0;">
                                </div>

                            </div>

                            <div class="security-notice mb-4">
                                <i class="bi bi-shield-lock-fill me-1"></i>
                                <strong>Modification sécurisée du mot de passe.</strong>
                                Laissez les trois champs vides si vous ne souhaitez pas changer le mot de passe.
                                Pour le modifier, saisissez le mot de passe actuel, puis le nouveau et sa confirmation.
                            </div>

                            {{-- MOT DE PASSE ACTUEL --}}
                            <div class="mb-3">

                                <label class="form-label security-label">
                                    <i class="bi bi-key text-muted"></i>
                                    Mot de passe actuel
                                    <span class="password-optional">(requis pour le changement)</span>
                                </label>

                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control" autocomplete="current-password"
                                        placeholder="Saisir le mot de passe actuel">

                                    <button type="button" class="btn"
                                        onclick="togglePassword('current_password', 'iconCurrentPassword')"
                                        title="Afficher ou masquer">
                                        <i class="bi bi-eye" id="iconCurrentPassword"></i>
                                    </button>
                                </div>

                                @error('current_password')
                                    <div class="text-danger small mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- NOUVEAU MOT DE PASSE --}}
                            <div class="mb-3">

                                <label class="form-label security-label">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                    Nouveau mot de passe
                                </label>

                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control"
                                        minlength="8" autocomplete="new-password" placeholder="Minimum 8 caractères">

                                    <button type="button" class="btn"
                                        onclick="togglePassword('password', 'iconPassword')" title="Afficher ou masquer">
                                        <i class="bi bi-eye" id="iconPassword"></i>
                                    </button>
                                </div>

                            </div>

                            {{-- CONFIRMATION --}}
                            <div class="mb-2">

                                <label class="form-label security-label">
                                    <i class="bi bi-check2-circle text-muted"></i>
                                    Confirmation du nouveau mot de passe
                                </label>

                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" minlength="8" autocomplete="new-password"
                                        placeholder="Répéter le nouveau mot de passe">

                                    <button type="button" class="btn"
                                        onclick="togglePassword('password_confirmation', 'iconConfirmation')"
                                        title="Afficher ou masquer">
                                        <i class="bi bi-eye" id="iconConfirmation"></i>
                                    </button>
                                </div>

                            </div>

                            <hr class="security-divider">

                            <div class="small text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Le nouveau mot de passe doit contenir au minimum 8 caractères.
                            </div>

                        </div>

                    </div>

                    {{-- =================================================
                     BOUTONS D'ACTION
                ================================================== --}}
                    <div class="action-card">

                        <div class="p-3 p-md-4 d-flex flex-wrap justify-content-between align-items-center gap-3">

                            <div class="small text-muted">
                                <i class="bi bi-pencil-square me-1"></i>
                                Vérifiez les informations avant d'enregistrer.
                            </div>

                            <div class="d-flex flex-wrap gap-2">

                                <a href="{{ route('config.users.list') }}" class="btn btn-cancel">
                                    <i class="bi bi-x-lg me-1"></i>
                                    Annuler
                                </a>

                                <button type="submit" class="btn btn-save">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    Enregistrer les modifications
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

    {{-- =========================================================
     JAVASCRIPT
========================================================== --}}
    <script>
        // Afficher / masquer les mots de passe
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        // Aperçu de la nouvelle photo avant enregistrement
        document.addEventListener('DOMContentLoaded', function() {
            const photoInput = document.getElementById('userPhotoInput');
            const photoPreview = document.getElementById('userPhotoPreview');

            if (photoInput && photoPreview) {
                photoInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];

                    if (!file) return;

                    if (!file.type.startsWith('image/')) {
                        alert('Veuillez sélectionner une image valide.');
                        photoInput.value = '';
                        return;
                    }

                    if (file.size > 2 * 1024 * 1024) {
                        alert('La photo ne doit pas dépasser 2 Mo.');
                        photoInput.value = '';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                });
            }
        });
    </script>

    {{-- POPUP DE CONFIRMATION --}}
    @if (session('success'))
        <div id="successModal" class="success-overlay">

            <div class="success-box">

                <div class="success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>

                <h3>Succès !</h3>

                <p>{{ session('success') }}</p>

                <button type="button" class="success-btn" onclick="closeSuccessModal()">
                    OK
                </button>

            </div>

        </div>

        <style>
            .success-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.65);
                backdrop-filter: blur(4px);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 99999;
                animation: overlayFade 0.3s ease;
            }

            .success-box {
                background: #ffffff;
                width: 400px;
                max-width: 90%;
                padding: 35px 30px;
                border-radius: 18px;
                text-align: center;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
                animation: popupScale 0.4s ease;
            }

            .success-icon {
                width: 75px;
                height: 75px;
                margin: 0 auto 15px;
                border-radius: 50%;
                background: #e8f8ef;
                color: #16a34a;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 40px;
                animation: iconPop 0.5s ease;
            }

            .success-box h3 {
                color: #1e293b;
                font-size: 24px;
                font-weight: 700;
                margin-bottom: 10px;
            }

            .success-box p {
                color: #64748b;
                font-size: 15px;
                margin-bottom: 25px;
            }

            .success-btn {
                background: #16a34a;
                color: white;
                border: none;
                padding: 11px 35px;
                border-radius: 8px;
                font-weight: 600;
                transition: 0.2s;
                cursor: pointer;
            }

            .success-btn:hover {
                background: #15803d;
                transform: translateY(-2px);
            }

            @keyframes overlayFade {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes popupScale {
                from {
                    transform: scale(0.8);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            @keyframes iconPop {
                0% {
                    transform: scale(0);
                }

                70% {
                    transform: scale(1.15);
                }

                100% {
                    transform: scale(1);
                }
            }
        </style>

        <script>
            function closeSuccessModal() {
                const modal = document.getElementById('successModal');

                if (modal) {
                    modal.style.opacity = '0';
                    modal.style.transition = 'opacity 0.3s ease';

                    setTimeout(() => {
                        modal.remove();
                    }, 300);
                }
            }
        </script>
    @endif
@endsection
