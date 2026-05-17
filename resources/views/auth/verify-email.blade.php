<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Email Verification | EduManage</title>

    <!-- Bootstrap LOCAL -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- FontAwesome LOCAL -->
    <link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            min-height:100vh;

            font-family:'Segoe UI',sans-serif;

            background:
                linear-gradient(135deg,
                    #0f172a 0%,
                    #1e293b 45%,
                    #2563eb 100%);

            overflow-y:auto;
        }

        html,
        body{
            min-height:100%;
        }

        /* WRAPPER */
        .verify-wrapper{

            min-height:100vh;

            display:flex;

            justify-content:center;
            align-items:center;

            padding:40px 15px;
        }

        /* CARD */
        .verify-card{

            width:100%;
            max-width:650px;

            background:white;

            border-radius:18px;

            overflow:hidden;

            box-shadow:
                0 20px 60px rgba(0,0,0,0.25);
        }

        /* HEADER */
        .verify-header{

            background:
                linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);

            padding:35px 30px;

            text-align:center;

            color:white;
        }

        .logo-circle{

            width:90px;
            height:90px;

            border-radius:50%;

            background:rgba(255,255,255,0.15);

            margin:auto;

            display:flex;
            justify-content:center;
            align-items:center;

            font-size:38px;

            margin-bottom:18px;

            border:3px solid rgba(255,255,255,0.2);
        }

        .brand-title{

            font-size:32px;

            font-weight:800;

            margin-bottom:5px;
        }

        .brand-subtitle{

            font-size:14px;

            opacity:0.9;
        }

        /* BODY */
        .verify-body{

            padding:35px;
        }

        /* INFO BOX */
        .verify-info{

            background:#eff6ff;

            border-left:5px solid #2563eb;

            padding:18px;

            border-radius:12px;

            color:#334155;

            line-height:1.8;

            margin-bottom:25px;
        }

        /* SUCCESS */
        .success-message{

            background:#dcfce7;

            border:1px solid #bbf7d0;

            color:#166534;

            padding:14px;

            border-radius:12px;

            margin-bottom:20px;

            font-weight:600;
        }

        /* BUTTON GROUP */
        .button-group{

            display:flex;

            gap:15px;

            flex-wrap:wrap;
        }

        /* BUTTON */
        .verify-btn{

            flex:1;

            min-width:220px;

            height:54px;

            border:none;

            border-radius:12px;

            background:
                linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);

            color:white;

            font-size:15px;

            font-weight:700;

            transition:0.3s;
        }

        .verify-btn:hover{

            transform:translateY(-2px);

            box-shadow:
                0 10px 25px rgba(37,99,235,0.35);
        }

        /* LOGOUT */
        .logout-btn{

            flex:1;

            min-width:220px;

            height:54px;

            border:none;

            border-radius:12px;

            background:
                linear-gradient(135deg,
                    #ef4444,
                    #dc2626);

            color:white;

            font-size:15px;

            font-weight:700;

            transition:0.3s;
        }

        .logout-btn:hover{

            transform:translateY(-2px);

            box-shadow:
                0 10px 25px rgba(239,68,68,0.35);
        }

        /* FOOTER */
        .footer-text{

            margin-top:25px;

            text-align:center;

            color:#64748b;

            font-size:13px;
        }

        /* MOBILE */
        @media(max-width:576px){

            .verify-body{
                padding:25px;
            }

            .verify-header{
                padding:30px 20px;
            }

            .brand-title{
                font-size:26px;
            }

            .logo-circle{

                width:75px;
                height:75px;

                font-size:30px;
            }

            .button-group{
                flex-direction:column;
            }
        }

    </style>

</head>

<body>

    <div class="verify-wrapper">

        <div class="verify-card">

            <!-- HEADER -->
            <div class="verify-header">

                <div class="logo-circle">

                    <i class="fa-solid fa-envelope-circle-check"></i>

                </div>

                <div class="brand-title">

                    EduManage

                </div>

                <div class="brand-subtitle">

                    Vérification de votre adresse e-mail

                </div>

            </div>

            <!-- BODY -->
            <div class="verify-body">

                <!-- INFO -->
                <div class="verify-info">

                    <strong>Bienvenue sur EduManage 🎓</strong>

                    <br><br>

                    Avant d'accéder à votre plateforme scolaire,
                    veuillez confirmer votre adresse e-mail
                    en cliquant sur le lien que nous venons
                    d'envoyer dans votre boîte mail.

                    <br><br>

                    Si vous n'avez pas reçu l'e-mail,
                    cliquez simplement sur le bouton
                    ci-dessous pour recevoir un nouveau lien.

                </div>

                <!-- SUCCESS -->
                @if (session('status') == 'verification-link-sent')

                    <div class="success-message">

                        ✅ Un nouveau lien de vérification
                        a été envoyé avec succès.

                    </div>

                @endif

                <!-- BUTTONS -->
                <div class="button-group">

                    <!-- RESEND -->
                    <form method="POST"
                          action="{{ route('verification.send') }}"
                          style="flex:1;">

                        @csrf

                        <button type="submit"
                                class="verify-btn">

                            <i class="fa-solid fa-paper-plane"></i>

                            Renvoyer le lien

                        </button>

                    </form>

                    <!-- LOGOUT -->
                    <form method="POST"
                          action="{{ route('logout') }}"
                          style="flex:1;">

                        @csrf

                        <button type="submit"
                                class="logout-btn">

                            <i class="fa-solid fa-right-from-bracket"></i>

                            Déconnexion

                        </button>

                    </form>

                </div>

                <!-- FOOTER -->
                <div class="footer-text">

                    © {{ date('Y') }} EduManage • ERP scolaire professionnel

                </div>

            </div>

        </div>

    </div>

</body>

</html>