
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | EduManage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --navy: #071b3a;
            --navy-light: #102e59;
            --blue: #174b91;
            --gold: #f5bd28;
            --gold-light: #ffda70;
            --text: #14213d;
            --muted: #718096;
            --border: #dce4ef;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background:
                radial-gradient(circle at 15% 10%, #183d70 0, transparent 35%),
                linear-gradient(135deg, #06152f, #163761);
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
        }

        .login-container {
            width: 100%;
            max-width: 1200px;
            min-height: 760px;
            display: grid;
            grid-template-columns: 46% 54%;
            overflow: hidden;
            background: #fff;
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 20px;
            box-shadow: 0 30px 90px rgba(0,0,0,.35);
        }

        /* PANNEAU GAUCHE */

        .login-left {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 55px 52px;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(circle at 100% 0%, rgba(48,91,151,.4), transparent 32%),
                linear-gradient(145deg, #0d2850, #061733 75%);
        }

        .login-left::before,
        .login-left::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,.055);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-left::before {
            width: 340px;
            height: 340px;
            top: -210px;
            right: -160px;
        }

        .login-left::after {
            width: 300px;
            height: 300px;
            bottom: -210px;
            left: -180px;
        }

        .brand-content {
            position: relative;
            z-index: 1;
        }

        .logo-box {
            width: 100%;
            min-height: 235px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
        }

        .app-logo {
            display: block;
            width: min(100%, 300px);
            height: 235px;
            object-fit: contain;
            filter: drop-shadow(0 12px 22px rgba(0,0,0,.24));
        }

        .brand-title {
            margin-bottom: 12px;
            color: #fff;
            font-size: clamp(34px, 3.2vw, 46px);
            font-weight: 800;
            letter-spacing: -1.5px;
            text-align: center;
        }

        .brand-title span {
            color: var(--gold);
        }

        .brand-subtitle {
            max-width: 390px;
            margin: 0 auto;
            color: #d5dfed;
            font-size: 15px;
            line-height: 1.8;
            text-align: center;
        }

        .gold-line {
            width: 55px;
            height: 3px;
            margin: 23px auto 30px;
            border-radius: 10px;
            background: var(--gold);
        }

        .feature-list {
            display: grid;
            gap: 20px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .feature-icon {
            flex: 0 0 48px;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 18px;
            border: 1px solid rgba(245,189,40,.65);
            border-radius: 12px;
            background: rgba(245,189,40,.07);
        }

        .feature-item strong {
            display: block;
            margin-bottom: 4px;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
        }

        .feature-item small {
            display: block;
            color: #bac9de;
            font-size: 12px;
            line-height: 1.5;
        }

        .brand-footer {
            margin-top: 35px;
            color: #aebed4;
            font-size: 12px;
            text-align: center;
        }

        .brand-footer i {
            margin-right: 6px;
            color: var(--gold);
        }

        /* PANNEAU DROIT */

        .login-right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 65px clamp(28px, 5.2vw, 76px);
            background: #fff;
        }

        .login-heading {
            margin-bottom: 38px;
            text-align: center;
        }

        .login-title {
            margin-bottom: 10px;
            color: var(--navy);
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .login-subtitle {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .heading-line {
            width: 55px;
            height: 3px;
            margin: 22px auto 0;
            border-radius: 5px;
            background: var(--gold);
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: #1c2d49;
            font-size: 13px;
            font-weight: 700;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 18px;
            z-index: 2;
            color: #71819a;
            transform: translateY(-50%);
        }

        .form-control {
            width: 100%;
            height: 58px;
            padding: 12px 48px;
            color: var(--text);
            font-size: 14px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: #fbfcfe;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .form-control::placeholder {
            color: #9aa7ba;
        }

        .form-control:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(23,75,145,.09);
            outline: none;
        }

        .password-input {
            padding-right: 50px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 16px;
            z-index: 3;
            padding: 6px;
            color: #71819a;
            border: 0;
            background: transparent;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .toggle-password:hover {
            color: var(--blue);
        }

        .remember-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 3px 0 28px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #56657b;
            font-size: 13px;
            cursor: pointer;
        }

        .remember-label input {
            width: 16px;
            height: 16px;
            accent-color: var(--blue);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--blue);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-link:hover {
            color: #b17b00;
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 11px;
            padding: 14px 20px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            border: 1px solid #214e8b;
            border-radius: 11px;
            background: linear-gradient(110deg, #174b91, #092751);
            box-shadow: 0 7px 18px rgba(9,39,81,.17);
            transition: transform .2s, box-shadow .2s;
            cursor: pointer;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(9,39,81,.25);
        }

        .login-btn i {
            color: var(--gold);
        }

        .register-separator {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 30px 0 22px;
            color: #8591a3;
            font-size: 13px;
        }

        .register-separator::before,
        .register-separator::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e0e6ef;
        }

        .register-text {
            margin-bottom: 15px;
            color: #758198;
            font-size: 13px;
            text-align: center;
        }

        .create-account-btn {
            width: 100%;
            min-height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 18px;
            color: #a87500;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid var(--gold);
            border-radius: 11px;
            background: #fff;
            transition: color .2s, background .2s, transform .2s;
        }

        .create-account-btn:hover {
            color: var(--navy);
            background: #fff7df;
            transform: translateY(-1px);
        }

        .create-account-btn i {
            color: #d69e00;
        }

        .footer-text {
            margin-top: 40px;
            color: #8b96a8;
            font-size: 11px;
            line-height: 1.7;
            text-align: center;
        }

        .alert {
            margin-bottom: 22px;
            font-size: 13px;
            border-radius: 10px;
        }

        .field-error {
            display: block;
            margin-top: 7px;
            color: #c62828;
            font-size: 12px;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {
            body {
                align-items: flex-start;
                padding: 20px;
            }

            .login-container {
                max-width: 580px;
                grid-template-columns: 1fr;
            }

            .login-left {
                padding: 35px 28px;
            }

            .logo-box {
                min-height: 150px;
                margin-bottom: 12px;
            }

            .app-logo {
                height: 150px;
                width: min(100%, 220px);
            }

            .brand-title {
                font-size: 34px;
            }

            .brand-subtitle {
                font-size: 13px;
            }

            .gold-line {
                margin: 18px auto 22px;
            }

            .feature-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
            }

            .feature-item {
                align-items: flex-start;
                gap: 10px;
            }

            .feature-icon {
                flex-basis: 40px;
                width: 40px;
                height: 40px;
                font-size: 15px;
            }

            .feature-item small {
                font-size: 11px;
            }

            .brand-footer {
                margin-top: 24px;
            }

            .login-right {
                padding: 42px 32px;
            }

            .login-heading {
                margin-bottom: 30px;
            }

            .login-title {
                font-size: 30px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .login-container {
                border-radius: 14px;
            }

            .login-left {
                padding: 28px 22px;
            }

            .feature-list {
                grid-template-columns: 1fr;
            }

            .login-right {
                padding: 35px 22px;
            }

            .remember-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .login-title {
                font-size: 28px;
            }

            .footer-text {
                margin-top: 28px;
            }
        }
    </style>
</head>

<body>
    <main class="login-container">

        <!-- PANNEAU GAUCHE : IDENTITÉ EDUMANAGE -->
        <section class="login-left">
            <div class="brand-content">

                <div class="logo-box">
                    <img
                        src="{{ asset('images/logo.jpeg') }}"
                        alt="Logo EduManage"
                        class="app-logo"
                    >
                </div>

                

                <p class="brand-subtitle">
                    La plateforme professionnelle pour une gestion scolaire
                    moderne, organisée et efficace.
                </p>

                <div class="gold-line"></div>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <strong>Gestion des élèves</strong>
                            <small>Suivi des inscriptions et informations des élèves.</small>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-chalkboard"></i>
                        </div>
                        <div>
                            <strong>Gestion des classes</strong>
                            <small>Organisation des classes et des niveaux scolaires.</small>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div>
                            <strong>Matières et emplois du temps</strong>
                            <small>Planification des cours et suivi pédagogique.</small>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <strong>Notes et statistiques</strong>
                            <small>Suivi des résultats et performances scolaires.</small>
                        </div>
                    </div>
                </div>

                <div class="brand-footer">
                    <i class="fa-solid fa-shield-halved"></i>
                    Une gestion scolaire centralisée et simplifiée
                </div>
            </div>
        </section>

        <!-- PANNEAU DROIT : FORMULAIRE -->
        <section class="login-right">

            <div class="login-heading">
                <h2 class="login-title">Connexion</h2>
                <p class="login-subtitle">
                    Connectez-vous à votre espace EduManage
                </p>
                <div class="heading-line"></div>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="form-label">Adresse email</label>
                    <div class="input-group-custom">
                        <i class="input-icon fa-solid fa-envelope"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="Entrez votre adresse email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div>
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group-custom">
                        <i class="input-icon fa-solid fa-lock"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control password-input"
                            placeholder="Entrez votre mot de passe"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Afficher le mot de passe"
                            aria-pressed="false"
                        >
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="remember-row">
                    <label for="remember_me" class="remember-label">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember_me"
                        >
                        Se souvenir de moi
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="forgot-link"
                        >
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <button type="submit" class="login-btn">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Se connecter
                </button>
            </form>

            @if (Route::has('register'))
                <div class="register-separator">ou</div>

                <p class="register-text">
                    Vous n'avez pas de compte ?
                </p>

                <a href="{{ route('register') }}" class="create-account-btn">
                    <i class="fa-solid fa-user-plus"></i>
                    Créer un compte
                </a>
            @endif

            <footer class="footer-text">
                &copy; {{ date('Y') }} EduManage —
                ERP scolaire professionnel
            </footer>

        </section>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordButton.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.classList.toggle('fa-eye', !isHidden);
            eyeIcon.classList.toggle('fa-eye-slash', isHidden);

            togglePasswordButton.setAttribute('aria-pressed', String(isHidden));
            togglePasswordButton.setAttribute(
                'aria-label',
                isHidden ? 'Masquer le mot de passe' : 'Afficher le mot de passe'
            );
        });
    </script>
</body>
</html>
