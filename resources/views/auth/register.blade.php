<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Inscription | EduManage</title>

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
            CARD
        ========================= */

        .register-wrapper{

            width:100%;
            max-width:1000px;

            display:grid;
            grid-template-columns: 1fr 1fr;

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

            padding:60px 50px;

            position:relative;

            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .left-side::before{

            content:'';

            position:absolute;

            width:320px;
            height:320px;

            background:rgba(255,255,255,0.08);

            border-radius:50%;

            top:-120px;
            right:-100px;
        }

        .left-side::after{

            content:'';

            position:absolute;

            width:220px;
            height:220px;

            background:rgba(255,255,255,0.05);

            border-radius:50%;

            bottom:-80px;
            left:-60px;
        }

        .logo-box{

            position:relative;
            z-index:2;
        }

        .logo-circle{

            width:95px;
            height:95px;

            border-radius:20px;

            background:rgba(255,255,255,0.18);

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

            color:rgba(255,255,255,0.85);

            line-height:1.7;
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

            background:rgba(255,255,255,0.15);

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

            margin-bottom:35px;
        }

        .form-label{

            font-weight:600;

            color:#334155;

            margin-bottom:8px;
        }

        .input-group-custom{

            position:relative;
        }

        .input-group-custom i.left-icon{

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

        /* PASSWORD */

        .password-input{

            padding-right:55px;
        }

        .toggle-password{

            position:absolute;

            right:15px;
            top:50%;

            transform:translateY(-50%);

            border:none;
            background:none;

            color:#64748b;

            cursor:pointer;

            z-index:11;
        }

        .toggle-password:hover{

            color:#2563eb;
        }

        /* BUTTON */

        .register-btn{

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

            font-weight:700;
            font-size:16px;

            transition:0.3s;
        }

        .register-btn:hover{

            transform:translateY(-2px);

            box-shadow:
                0 12px 25px rgba(37,99,235,0.28);
        }

        .login-link{

            text-align:center;

            margin-top:20px;
        }

        .login-link a{

            text-decoration:none;

            color:#2563eb;

            font-weight:600;
        }

        .login-link a:hover{

            text-decoration:underline;
        }

        .error-text{

            color:#dc2626;

            font-size:13px;

            margin-top:6px;
        }

        .footer-text{

            text-align:center;

            margin-top:30px;

            color:#94a3b8;

            font-size:13px;
        }

        /* =========================
            RESPONSIVE
        ========================= */

        @media(max-width:900px){

            .register-wrapper{

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

    <div class="register-wrapper">

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

                    Plateforme ERP scolaire moderne
                    pour la gestion intelligente
                    des élèves, classes et matières.

                </div>

                <div class="feature-list">

                    <div class="feature-item">

                        <div class="feature-icon">

                            <i class="fa-solid fa-users"></i>

                        </div>

                        Gestion complète des élèves

                    </div>

                    <div class="feature-item">

                        <div class="feature-icon">

                            <i class="fa-solid fa-school"></i>

                        </div>

                        Organisation des classes

                    </div>

                    <div class="feature-item">

                        <div class="feature-icon">

                            <i class="fa-solid fa-book"></i>

                        </div>

                        Gestion des matières scolaires

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="right-side">

            <div class="form-title">

                Créer un compte

            </div>

            <div class="form-subtitle">

                Créez votre compte administrateur EduManage

            </div>

            <form method="POST"
                  action="{{ route('register') }}">

                @csrf

                <!-- NAME -->
                <div class="mb-4">

                    <label class="form-label">

                        Nom complet

                    </label>

                    <div class="input-group-custom">

                        <i class="fa-solid fa-user left-icon"></i>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Entrer votre nom"
                               value="{{ old('name') }}"
                               required>

                    </div>

                    @error('name')
                        <div class="error-text">

                            {{ $message }}

                        </div>
                    @enderror

                </div>

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
                               placeholder="Entrer votre email"
                               value="{{ old('email') }}"
                               required>

                    </div>

                    @error('email')
                        <div class="error-text">

                            {{ $message }}

                        </div>
                    @enderror

                </div>

                <!-- PASSWORD -->
                <div class="mb-4">

                    <label class="form-label">

                        Mot de passe

                    </label>

                    <div class="input-group-custom">

                        <i class="fa-solid fa-lock left-icon"></i>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control password-input"
                               placeholder="Entrer mot de passe"
                               required>

                        <button type="button"
                                class="toggle-password"
                                onclick="togglePassword('password','eye1')">

                            <i class="fa-solid fa-eye"
                               id="eye1"></i>

                        </button>

                    </div>

                    @error('password')
                        <div class="error-text">

                            {{ $message }}

                        </div>
                    @enderror

                </div>

                <!-- CONFIRM -->
                <div class="mb-4">

                    <label class="form-label">

                        Confirmation mot de passe

                    </label>

                    <div class="input-group-custom">

                        <i class="fa-solid fa-lock left-icon"></i>

                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control password-input"
                               placeholder="Confirmer mot de passe"
                               required>

                        <button type="button"
                                class="toggle-password"
                                onclick="togglePassword('password_confirmation','eye2')">

                            <i class="fa-solid fa-eye"
                               id="eye2"></i>

                        </button>

                    </div>

                </div>

                <!-- BTN -->
                <button type="submit"
                        class="register-btn">

                    <i class="fa-solid fa-user-plus"></i>

                    Créer le compte

                </button>

                <!-- LOGIN -->
                <div class="login-link">

                    Déjà inscrit ?

                    <a href="{{ route('login') }}">

                        Se connecter

                    </a>

                </div>

            </form>

            <div class="footer-text">

                © {{ date('Y') }} EduManage
                • ERP scolaire professionnel

            </div>

        </div>

    </div>

    <script>

        function togglePassword(inputId, eyeId){

            const input =
                document.getElementById(inputId);

            const eye =
                document.getElementById(eyeId);

            if(input.type === 'password'){

                input.type = 'text';

                eye.classList.remove('fa-eye');

                eye.classList.add('fa-eye-slash');

            }else{

                input.type = 'password';

                eye.classList.remove('fa-eye-slash');

                eye.classList.add('fa-eye');
            }
        }

    </script>

</body>

</html>