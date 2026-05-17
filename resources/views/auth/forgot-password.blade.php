<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Mot de passe oublié | EduManage</title>

    <!-- BOOTSTRAP LOCAL -->
    <link rel="stylesheet"
          href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    <!-- FONT AWESOME LOCAL -->
    <link rel="stylesheet"
          href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            min-height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            padding:40px 15px;

            overflow-y:auto;

            font-family:'Segoe UI',sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #0f172a,
                    #111827,
                    #1e293b
                );
        }

        /* =========================
            WRAPPER
        ========================= */

        .forgot-wrapper{

            width:100%;
            max-width:950px;

            display:grid;
            grid-template-columns:1fr 1fr;

            background:white;

            border-radius:24px;

            overflow:hidden;

            box-shadow:
                0 20px 60px rgba(0,0,0,0.35);
        }

        /* =========================
            LEFT
        ========================= */

        .left-side{

            background:
                linear-gradient(
                    160deg,
                    #2563eb,
                    #1d4ed8,
                    #1e40af
                );

            color:white;

            padding:60px 45px;

            position:relative;

            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .left-side::before{

            content:'';

            position:absolute;

            width:300px;
            height:300px;

            background:rgba(255,255,255,0.08);

            border-radius:50%;

            top:-100px;
            right:-80px;
        }

        .left-side::after{

            content:'';

            position:absolute;

            width:220px;
            height:220px;

            background:rgba(255,255,255,0.05);

            border-radius:50%;

            bottom:-80px;
            left:-50px;
        }

        .logo-box{

            position:relative;
            z-index:2;
        }

        .logo-circle{

            width:95px;
            height:95px;

            border-radius:22px;

            background:rgba(255,255,255,0.15);

            display:flex;
            justify-content:center;
            align-items:center;

            margin-bottom:25px;

            backdrop-filter:blur(10px);
        }

        .logo-circle i{

            font-size:42px;
            color:white;
        }

        .brand-title{

            font-size:42px;
            font-weight:800;

            margin-bottom:10px;
        }

        .brand-subtitle{

            font-size:17px;

            line-height:1.7;

            color:rgba(255,255,255,0.88);
        }

        .feature-list{

            margin-top:40px;

            display:flex;
            flex-direction:column;
            gap:18px;
        }

        .feature-item{

            display:flex;
            align-items:center;
            gap:15px;

            font-size:15px;
        }

        .feature-icon{

            width:38px;
            height:38px;

            border-radius:10px;

            background:rgba(255,255,255,0.14);

            display:flex;
            justify-content:center;
            align-items:center;
        }

        /* =========================
            RIGHT
        ========================= */

        .right-side{

            padding:55px 45px;

            background:#ffffff;
        }

        .form-title{

            font-size:30px;
            font-weight:700;

            color:#0f172a;

            margin-bottom:8px;
        }

        .form-subtitle{

            color:#64748b;

            line-height:1.7;

            margin-bottom:30px;
        }

        /* STATUS */

        .status-message{

            background:#dcfce7;

            border:1px solid #bbf7d0;

            color:#166534;

            padding:14px;

            border-radius:14px;

            margin-bottom:25px;

            font-size:14px;
        }

        /* LABEL */

        .form-label{

            font-weight:600;

            color:#334155;

            margin-bottom:8px;
        }

        /* INPUT */

        .input-group-custom{

            position:relative;
        }

        .left-icon{

            position:absolute;

            left:16px;
            top:50%;

            transform:translateY(-50%);

            color:#64748b;

            z-index:10;
        }

        .form-control{

            height:54px;

            border-radius:14px;

            border:1px solid #dbe2ea;

            padding-left:48px;

            font-size:15px;

            transition:0.3s;
        }

        .form-control:focus{

            border-color:#2563eb;

            box-shadow:
                0 0 0 4px rgba(37,99,235,0.12);
        }

        /* BUTTON */

        .forgot-btn{

            width:100%;
            height:55px;

            border:none;

            border-radius:14px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            color:white;

            font-size:16px;
            font-weight:700;

            transition:0.3s;
        }

        .forgot-btn:hover{

            transform:translateY(-2px);

            box-shadow:
                0 12px 25px rgba(37,99,235,0.28);
        }

        /* LOGIN */

        .login-link{

            text-align:center;

            margin-top:22px;
        }

        .login-link a{

            color:#2563eb;

            text-decoration:none;

            font-weight:600;
        }

        .login-link a:hover{

            text-decoration:underline;
        }

        /* ERROR */

        .error-text{

            color:#dc2626;

            font-size:13px;

            margin-top:6px;
        }

        /* FOOTER */

        .footer-text{

            text-align:center;

            margin-top:30px;

            color:#94a3b8;

            font-size:13px;
        }

        /* RESPONSIVE */

        @media(max-width:900px){

            .forgot-wrapper{

                grid-template-columns:1fr;
            }

            .left-side{

                display:none;
            }

            .right-side{

                padding:40px 25px;
            }
        }
    </style>

</head>

<body>

    <div class="forgot-wrapper">

        <!-- LEFT -->
        <div class="left-side">

            <div class="logo-box">

                <div class="logo-circle">

                    <i class="fa-solid fa-graduation-cap"></i>

                </div>

                <div class="brand-title">

                    EduManage

                </div>

                <div class="brand-subtitle">

                    Réinitialisez rapidement
                    votre mot de passe et
                    récupérez l’accès sécurisé
                    à votre ERP scolaire.

                </div>

                <div class="feature-list">

                    <div class="feature-item">

                        <div class="feature-icon">

                            <i class="fa-solid fa-shield-halved"></i>

                        </div>

                        Sécurité renforcée

                    </div>

                    <div class="feature-item">

                        <div class="feature-icon">

                            <i class="fa-solid fa-envelope"></i>

                        </div>

                        Envoi sécurisé par email

                    </div>

                    <div class="feature-item">

                        <div class="feature-icon">

                            <i class="fa-solid fa-lock"></i>

                        </div>

                        Protection des comptes admin

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="right-side">

            <div class="form-title">

                Mot de passe oublié

            </div>

            <div class="form-subtitle">

                Entrez votre adresse email
                pour recevoir un lien sécurisé
                de réinitialisation du mot de passe.

            </div>

            <!-- STATUS -->
            @if (session('status'))

                <div class="status-message">

                    {{ session('status') }}

                </div>

            @endif

            <!-- FORM -->
            <form method="POST"
                  action="{{ route('password.email') }}">

                @csrf

                <!-- EMAIL -->
                <div class="mb-4">

                    <label class="form-label">

                        Adresse email

                    </label>

                    <div class="input-group-custom">

                        <i class="fa-solid fa-envelope left-icon"></i>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               placeholder="Entrer votre email"
                               required
                               autofocus>

                    </div>

                    @error('email')

                        <div class="error-text">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

                <!-- BTN -->
                <button type="submit"
                        class="forgot-btn">

                    <i class="fa-solid fa-paper-plane"></i>

                    Envoyer le lien

                </button>

            </form>

            <!-- LOGIN -->
            <div class="login-link">

                <a href="{{ route('login') }}">

                    ← Retour à la connexion

                </a>

            </div>

            <div class="footer-text">

                © {{ date('Y') }} EduManage
                • ERP scolaire professionnel

            </div>

        </div>

    </div>

</body>

</html>