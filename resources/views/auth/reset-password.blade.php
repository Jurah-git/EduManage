{{-- resources/views/auth/reset-password.blade.php --}}

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Réinitialisation | EduManage</title>

    {{-- BOOTSTRAP LOCAL --}}
    <link rel="stylesheet"
          href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">

    {{-- FONT AWESOME LOCAL --}}
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

            font-family:'Segoe UI',sans-serif;

            background:#eef2f7;

            display:flex;
            justify-content:center;
            align-items:center;

            padding:30px 15px;
        }

        /* CONTAINER */
        .reset-container{

            width:100%;
            max-width:1100px;

            background:white;

            border-radius:24px;

            overflow:hidden;

            box-shadow:
                0 15px 45px rgba(0,0,0,0.12);

            display:flex;
        }

        /* LEFT SIDE */
        .left-side{

            width:42%;

            background:
                linear-gradient(135deg,
                    #1d4ed8,
                    #2563eb,
                    #3b82f6);

            color:white;

            padding:55px 40px;

            position:relative;

            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .left-side::before{

            content:'';

            position:absolute;

            width:240px;
            height:240px;

            border-radius:50%;

            background:rgba(255,255,255,0.08);

            top:-80px;
            right:-80px;
        }

        .left-side::after{

            content:'';

            position:absolute;

            width:200px;
            height:200px;

            border-radius:50%;

            background:rgba(255,255,255,0.05);

            bottom:-60px;
            left:-60px;
        }

        .logo-box{

            position:relative;
            z-index:5;
        }

        .logo-circle{

            width:95px;
            height:95px;

            border-radius:20px;

            background:rgba(255,255,255,0.15);

            display:flex;
            justify-content:center;
            align-items:center;

            font-size:40px;

            margin-bottom:25px;

            backdrop-filter:blur(10px);
        }

        .brand-title{

            font-size:38px;

            font-weight:800;

            margin-bottom:10px;
        }

        .brand-subtitle{

            font-size:15px;

            line-height:1.8;

            color:rgba(255,255,255,0.85);
        }

        /* RIGHT SIDE */
        .right-side{

            width:58%;

            padding:55px 45px;

            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .page-title{

            font-size:30px;

            font-weight:800;

            color:#0f172a;

            margin-bottom:10px;
        }

        .page-text{

            color:#64748b;

            margin-bottom:35px;

            line-height:1.7;
        }

        /* LABEL */
        .form-label{

            font-weight:700;

            color:#1e293b;

            margin-bottom:8px;
        }

        /* INPUT */
        .form-control{

            height:56px;

            border-radius:14px;

            border:1px solid #dbe3ee;

            background:#f8fafc;

            font-size:15px;

            transition:0.3s;
        }

        .form-control:focus{

            border-color:#2563eb;

            box-shadow:
                0 0 0 4px rgba(37,99,235,0.10);

            background:white;
        }

        /* PASSWORD GROUP */
        .password-group{

            position:relative;
        }

        .password-input{

            padding-right:50px;
        }

        /* EYE BUTTON */
        .toggle-password{

            position:absolute;

            top:50%;
            right:15px;

            transform:translateY(-50%);

            border:none;

            background:none;

            color:#64748b;

            cursor:pointer;

            z-index:10;
        }

        .toggle-password:hover{

            color:#2563eb;
        }

        /* BUTTON */
        .reset-btn{

            width:100%;

            height:56px;

            border:none;

            border-radius:14px;

            background:
                linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);

            color:white;

            font-weight:700;

            font-size:16px;

            transition:0.3s;

            margin-top:10px;
        }

        .reset-btn:hover{

            transform:translateY(-2px);

            box-shadow:
                0 12px 25px rgba(37,99,235,0.25);
        }

        /* LOGIN LINK */
        .back-login{

            text-align:center;

            margin-top:20px;
        }

        .back-login a{

            color:#2563eb;

            text-decoration:none;

            font-weight:700;
        }

        .back-login a:hover{

            color:#1d4ed8;
        }

        /* FOOTER */
        .footer-text{

            margin-top:25px;

            text-align:center;

            font-size:13px;

            color:#94a3b8;
        }

        /* MOBILE */
        @media(max-width:900px){

            .reset-container{

                flex-direction:column;
            }

            .left-side,
            .right-side{

                width:100%;
            }

            .left-side{

                padding:40px 30px;
            }

            .right-side{

                padding:40px 25px;
            }

            .brand-title{

                font-size:30px;
            }

            .page-title{

                font-size:25px;
            }
        }

    </style>

</head>

<body>

    <div class="reset-container">

        {{-- LEFT --}}
        <div class="left-side">

            <div class="logo-box">

                <div class="logo-circle">

                    <i class="fa-solid fa-key"></i>

                </div>

                <div class="brand-title">

                    EduManage

                </div>

                <div class="brand-subtitle">

                    Plateforme scolaire professionnelle.<br>

                    Réinitialisez votre mot de passe
                    pour sécuriser votre compte.

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="right-side">

            <div class="page-title">

                Nouveau mot de passe

            </div>

            <div class="page-text">

                Veuillez entrer votre adresse email
                ainsi qu’un nouveau mot de passe sécurisé.

            </div>

            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('password.store') }}">

                @csrf

                {{-- TOKEN --}}
                <input type="hidden"
                       name="token"
                       value="{{ $request->route('token') }}">

                {{-- EMAIL --}}
                <div class="mb-4">

                    <label class="form-label">

                        Adresse email

                    </label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $request->email) }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="Entrer votre adresse email">

                    <x-input-error :messages="$errors->get('email')"
                                   class="mt-2 text-danger" />

                </div>

                {{-- PASSWORD --}}
                <div class="mb-4">

                    <label class="form-label">

                        Nouveau mot de passe

                    </label>

                    <div class="password-group">

                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control password-input"
                               required
                               autocomplete="new-password"
                               placeholder="Entrer nouveau mot de passe">

                        <button type="button"
                                class="toggle-password"
                                onclick="togglePassword('password','eye1')">

                            <i class="fa-solid fa-eye"
                               id="eye1"></i>

                        </button>

                    </div>

                    <x-input-error :messages="$errors->get('password')"
                                   class="mt-2 text-danger" />

                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="mb-4">

                    <label class="form-label">

                        Confirmation mot de passe

                    </label>

                    <div class="password-group">

                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control password-input"
                               required
                               autocomplete="new-password"
                               placeholder="Confirmer mot de passe">

                        <button type="button"
                                class="toggle-password"
                                onclick="togglePassword('password_confirmation','eye2')">

                            <i class="fa-solid fa-eye"
                               id="eye2"></i>

                        </button>

                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')"
                                   class="mt-2 text-danger" />

                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        class="reset-btn">

                    <i class="fa-solid fa-rotate-right"></i>

                    Réinitialiser le mot de passe

                </button>

            </form>

            {{-- LOGIN --}}
            <div class="back-login">

                <a href="{{ route('login') }}">

                    ← Retour à la connexion

                </a>

            </div>

            {{-- FOOTER --}}
            <div class="footer-text">

                © {{ date('Y') }} EduManage • ERP scolaire professionnel

            </div>

        </div>

    </div>

    {{-- SCRIPT --}}
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