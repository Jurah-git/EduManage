{{-- resources/views/auth/confirm-password.blade.php --}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Confirmation | EduManage</title>

    {{-- BOOTSTRAP LOCAL --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">

    {{-- FONT AWESOME LOCAL --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

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
        .confirm-container{

            width:100%;
            max-width:980px;

            background:white;

            border-radius:24px;

            overflow:hidden;

            box-shadow:
                0 15px 45px rgba(0,0,0,0.12);

            display:flex;
        }

        /* LEFT */
        .left-side{

            width:42%;

            background:
                linear-gradient(135deg,
                    #1d4ed8,
                    #2563eb,
                    #3b82f6);

            color:white;

            padding:50px 40px;

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

            width:90px;
            height:90px;

            border-radius:20px;

            background:rgba(255,255,255,0.15);

            display:flex;
            justify-content:center;
            align-items:center;

            font-size:38px;

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

        /* RIGHT */
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

        /* FORM */
        .form-label{

            font-weight:700;

            color:#1e293b;

            margin-bottom:8px;
        }

        .input-group{

            position:relative;
        }

        .input-icon{

            position:absolute;

            top:50%;
            left:16px;

            transform:translateY(-50%);

            color:#64748b;

            z-index:5;
        }

        .form-control{

            height:56px;

            border-radius:14px;

            border:1px solid #dbe3ee;

            background:#f8fafc;

            padding-left:48px;

            padding-right:50px;

            font-size:15px;

            transition:0.3s;
        }

        .form-control:focus{

            border-color:#2563eb;

            box-shadow:
                0 0 0 4px rgba(37,99,235,0.10);

            background:white;
        }

        /* EYE BUTTON */
        .toggle-password{

            position:absolute;

            right:15px;
            top:50%;

            transform:translateY(-50%);

            border:none;

            background:none;

            color:#64748b;

            z-index:10;

            cursor:pointer;
        }

        .toggle-password:hover{

            color:#2563eb;
        }

        /* BUTTON */
        .confirm-btn{

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

        .confirm-btn:hover{

            transform:translateY(-2px);

            box-shadow:
                0 12px 25px rgba(37,99,235,0.25);
        }

        /* ERROR */
        .error-text{

            color:#dc2626;

            font-size:14px;

            margin-top:8px;
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

            .confirm-container{

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

    <div class="confirm-container">

        {{-- LEFT --}}
        <div class="left-side">

            <div class="logo-box">

                <div class="logo-circle">

                    <i class="fa-solid fa-shield-halved"></i>

                </div>

                <div class="brand-title">

                    EduManage

                </div>

                <div class="brand-subtitle">

                    ERP scolaire moderne et sécurisé.<br>

                    Veuillez confirmer votre mot de passe
                    pour accéder à cette zone protégée.

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="right-side">

            <div class="page-title">

                Confirmation requise

            </div>

            <div class="page-text">

                Pour des raisons de sécurité,
                veuillez entrer votre mot de passe
                avant de continuer.

            </div>

            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('password.confirm') }}">

                @csrf

                {{-- PASSWORD --}}
                <div class="mb-4">

                    <label class="form-label">

                        Mot de passe

                    </label>

                    <div class="input-group">

                        <i class="fa-solid fa-lock input-icon"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Entrer votre mot de passe"
                            required
                            autocomplete="current-password">

                        <button type="button"
                                class="toggle-password"
                                onclick="togglePassword()">

                            <i class="fa-solid fa-eye"
                               id="eyeIcon"></i>

                        </button>

                    </div>

                    @error('password')

                        <div class="error-text">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        class="confirm-btn">

                    <i class="fa-solid fa-check"></i>

                    Confirmer le mot de passe

                </button>

            </form>

            {{-- FOOTER --}}
            <div class="footer-text">

                © {{ date('Y') }} EduManage • Sécurité avancée

            </div>

        </div>

    </div>

    {{-- SCRIPT --}}
    <script>

        function togglePassword(){

            const input =
                document.getElementById('password');

            const eye =
                document.getElementById('eyeIcon');

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