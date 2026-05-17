<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion | EduManage</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            overflow-y: auto;
        }

        body {

            background:
                linear-gradient(135deg,
                    #0f172a,
                    #1e293b,
                    #334155);

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 30px;
        }

        /* CARD LOGIN */

        .login-container {

            width: 100%;
            max-width: 1050px;

            min-height: 620px;

            background: white;

            border-radius: 24px;

            overflow: hidden;

            display: flex;

            box-shadow:
                0 25px 70px rgba(0, 0, 0, 0.35);
        }

        /* LEFT */

        .login-left {

            width: 50%;

            background:
                linear-gradient(rgba(15, 23, 42, 0.88),
                    rgba(15, 23, 42, 0.88));

            color: white;

            padding: 60px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            position: relative;
        }

        /* LOGO */

        .logo-box {

            width: 95px;
            height: 95px;

            border-radius: 20px;

            background:
                linear-gradient(135deg,
                    #2563eb,
                    #7c3aed);

            display: flex;
            justify-content: center;
            align-items: center;

            margin-bottom: 30px;

            box-shadow:
                0 10px 30px rgba(37, 99, 235, 0.4);
        }

        .logo-box i {

            font-size: 42px;
        }

        .brand-title {

            font-size: 42px;
            font-weight: 800;

            margin-bottom: 10px;
        }

        .brand-subtitle {

            font-size: 17px;

            color: rgba(255, 255, 255, 0.8);

            line-height: 1.7;
        }

        /* FEATURES */

        .feature-list {

            margin-top: 40px;
        }

        .feature-item {

            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 18px;

            font-size: 15px;
        }

        .feature-item i {

            width: 35px;
            height: 35px;

            border-radius: 10px;

            background: rgba(255, 255, 255, 0.1);

            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* RIGHT */

        .login-right {

            width: 50%;

            padding: 60px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            background: #ffffff;
        }

        .login-title {

            font-size: 32px;
            font-weight: 700;

            color: #0f172a;

            margin-bottom: 8px;
        }

        .login-subtitle {

            color: #64748b;

            margin-bottom: 35px;
        }

        /* LABEL */

        .form-label {

            font-weight: 600;

            color: #334155;

            margin-bottom: 8px;
        }

        /* INPUT GROUP */

        .input-group-custom {

            position: relative;

            margin-bottom: 22px;
        }

        .input-group-custom i {

            position: absolute;

            top: 50%;
            left: 16px;

            transform: translateY(-50%);

            color: #64748b;
        }

        /* INPUT */

        .form-control {

            height: 55px;

            border-radius: 14px;

            padding-left: 48px;

            border: 1px solid #dbe2ea;

            transition: 0.3s;
        }

        .form-control:focus {

            border-color: #2563eb;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        /* PASSWORD BUTTON */

        .toggle-password {

            position: absolute;

            right: 16px;
            top: 50%;

            transform: translateY(-50%);

            background: transparent;
            border: none;

            color: #64748b;

            cursor: pointer;
        }

        /* REMEMBER */

        .remember-row {

            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 25px;
        }

        .remember-row label {

            font-size: 14px;
            color: #475569;
        }

        .forgot-link {

            font-size: 14px;

            text-decoration: none;

            color: #2563eb;

            font-weight: 600;
        }

        /* BUTTON */

        .login-btn {

            width: 100%;

            height: 55px;

            border: none;

            border-radius: 14px;

            background:
                linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);

            color: white;

            font-size: 16px;
            font-weight: 700;

            transition: 0.3s;
        }

        .login-btn:hover {

            transform: translateY(-2px);

            box-shadow:
                0 10px 25px rgba(37, 99, 235, 0.35);
        }

        /* FOOTER */

        .footer-text {

            margin-top: 30px;

            text-align: center;

            color: #64748b;

            font-size: 13px;
        }

        /* MOBILE */

        @media(max-width: 900px) {

            .login-container {

                flex-direction: column;

                min-height: auto;
            }

            .login-left,
            .login-right {

                width: 100%;
            }

            .login-left {

                padding: 40px;
            }

            .login-right {

                padding: 40px 30px;
            }
        }

        /* CREATE ACCOUNT */

        .create-account-btn {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 10px;

            margin-top: 12px;

            width: 100%;

            height: 52px;

            border-radius: 14px;

            text-decoration: none;

            font-weight: 700;

            color: #2563eb;

            border: 2px solid #2563eb;

            background: white;

            transition: 0.3s;
        }

        .create-account-btn:hover {

            background: #2563eb;

            color: white;

            transform: translateY(-2px);

            box-shadow:
                0 10px 25px rgba(37, 99, 235, 0.20);
        }
    </style>
</head>

<body>

    <div class="login-container">

        <!-- LEFT -->
        <div class="login-left">

            <div class="logo-box">

                <i class="fa-solid fa-graduation-cap"></i>

            </div>

            <div class="brand-title">

                EduManage

            </div>

            <div class="brand-subtitle">

                Plateforme professionnelle de gestion scolaire moderne,
                rapide et intelligente.

            </div>

            <div class="feature-list">

                <div class="feature-item">

                    <i class="fa-solid fa-user-graduate"></i>

                    Gestion des élèves

                </div>

                <div class="feature-item">

                    <i class="fa-solid fa-chalkboard"></i>

                    Gestion des classes

                </div>

                <div class="feature-item">

                    <i class="fa-solid fa-book"></i>

                    Gestion des matières

                </div>

                <div class="feature-item">

                    <i class="fa-solid fa-chart-column"></i>

                    Notes & statistiques

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="login-right">

            <div class="login-title">

                Connexion

            </div>

            <div class="login-subtitle">

                Connectez-vous à votre espace EduManage

            </div>

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <!-- EMAIL -->
                <label class="form-label">

                    Adresse email

                </label>

                <div class="input-group-custom">

                    <i class="fa-solid fa-envelope"></i>

                    <input type="email" name="email" class="form-control" placeholder="Entrer votre email" required
                        autofocus>

                </div>

                <!-- PASSWORD -->
                <label class="form-label">

                    Mot de passe

                </label>

                <div class="input-group-custom">

                    <i class="fa-solid fa-lock"></i>

                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Entrer votre mot de passe" required>

                    <button type="button" class="toggle-password" onclick="togglePassword()">

                        <i class="fa-solid fa-eye" id="eyeIcon"></i>

                    </button>

                </div>

                <!-- REMEMBER -->
                <div class="remember-row">

                    <div>

                        <input type="checkbox" name="remember" id="remember_me">

                        <label for="remember_me">

                            Se souvenir

                        </label>

                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">

                            Mot de passe oublié ?

                        </a>
                    @endif

                </div>

                <!-- BUTTON -->
                <button type="submit" class="login-btn">

                    <i class="fa-solid fa-right-to-bracket"></i>

                    Connexion

                </button>

            </form>

            <!-- REGISTER -->
            <div style="margin-top:18px; text-align:center;">

                <span style="color:#64748b; font-size:14px;">

                    Vous n'avez pas de compte ?

                </span>

                <br>

                <a href="{{ route('register') }}" class="create-account-btn">

                    <i class="fa-solid fa-user-plus"></i>

                    Créer un compte

                </a>

            </div>

            <!-- FOOTER -->
            <div class="footer-text">

                © {{ date('Y') }} EduManage —
                ERP scolaire professionnel

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {

            const password =
                document.getElementById('password');

            const eyeIcon =
                document.getElementById('eyeIcon');

            if (password.type === 'password') {

                password.type = 'text';

                eyeIcon.classList.remove('fa-eye');

                eyeIcon.classList.add('fa-eye-slash');

            } else {

                password.type = 'password';

                eyeIcon.classList.remove('fa-eye-slash');

                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>
