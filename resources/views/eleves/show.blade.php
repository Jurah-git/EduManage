@extends('layouts.app')

@section('content')

<div class="container-fluid mt-4">

    <div class="card border-0 shadow-lg student-card overflow-hidden">

        <!-- HEADER -->
        <div class="student-header">

            <div>

                <h3 class="mb-1 fw-bold">
                    🎓 Fiche Élève
                </h3>

                <small class="text-light opacity-75">
                    Informations complètes de l'élève
                </small>

            </div>

            <div class="student-badge">

                {{ $eleve->matricule }}

            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-0">

            <div class="row g-0">

                <!-- LEFT PHOTO -->
                <div class="col-lg-4">

                    <div class="photo-section">

                        @if ($eleve->photo)

                            <img
                                src="{{ asset('storage/' . $eleve->photo) }}"
                                class="student-profile-photo">

                        @else

                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($eleve->nom . ' ' . $eleve->prenom) }}&background=0D8ABC&color=fff&size=300"
                                class="student-profile-photo">

                        @endif

                        <h4 class="student-name">

                            {{ $eleve->nom }}
                            {{ $eleve->prenom }}

                        </h4>

                        <div class="student-class">

                            📚
                            {{ $eleve->classe->nom ?? '-' }}

                        </div>

                    </div>

                </div>

                <!-- RIGHT INFOS -->
                <div class="col-lg-8">

                    <div class="info-section">

                        <div class="row">

                            <!-- MATRICULE -->
                            <div class="col-md-6 mb-4">

                                <div class="info-card">

                                    <div class="info-label">
                                        Matricule
                                    </div>

                                    <div class="info-value">
                                        {{ $eleve->matricule }}
                                    </div>

                                </div>

                            </div>

                            <!-- SEXE -->
                            <div class="col-md-6 mb-4">

                                <div class="info-card">

                                    <div class="info-label">
                                        Sexe
                                    </div>

                                    <div class="info-value">
                                        {{ $eleve->sexe }}
                                    </div>

                                </div>

                            </div>

                            <!-- DATE -->
                            <div class="col-md-6 mb-4">

                                <div class="info-card">

                                    <div class="info-label">
                                        Date naissance
                                    </div>

                                    <div class="info-value">
                                        {{ $eleve->date_naissance }}
                                    </div>

                                </div>

                            </div>

                            <!-- CLASSE -->
                            <div class="col-md-6 mb-4">

                                <div class="info-card">

                                    <div class="info-label">
                                        Classe
                                    </div>

                                    <div class="info-value">
                                        {{ $eleve->classe->nom ?? '-' }}
                                    </div>

                                </div>

                            </div>

                            <!-- NUMERO CLASSE -->
                            <div class="col-md-6 mb-4">

                                <div class="info-card">

                                    <div class="info-label">
                                        Numéro de classe
                                    </div>

                                    <div class="info-value">

                                        N°
                                        {{ $eleve->numero_classe }}

                                    </div>

                                </div>

                            </div>

                            <!-- CREATED -->
                            <div class="col-md-6 mb-4">

                                <div class="info-card">

                                    <div class="info-label">
                                        Date inscription
                                    </div>

                                    <div class="info-value">

                                        {{ $eleve->created_at->format('d/m/Y') }}

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- BUTTONS -->
                        <div class="mt-4 d-flex gap-2">

                            <a href="{{ route('eleves.edit', $eleve) }}"
                               class="btn btn-warning btn-lg">

                                ✏ Modifier

                            </a>

                            <a href="{{ route('eleves.index') }}"
                               class="btn btn-dark btn-lg">

                                ⬅ Retour

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

/* MAIN CARD */

.student-card{

    border-radius:25px;

    background:#ffffff;
}

/* HEADER */

.student-header{

    background:
        linear-gradient(
            135deg,
            #0f172a,
            #1e293b
        );

    color:white;

    padding:25px 35px;

    display:flex;

    justify-content:space-between;

    align-items:center;
}

/* BADGE */

.student-badge{

    background:rgba(255,255,255,0.15);

    padding:10px 18px;

    border-radius:12px;

    font-weight:bold;

    backdrop-filter:blur(10px);
}

/* LEFT */

.photo-section{

    height:100%;

    background:
        linear-gradient(
            180deg,
            #f8fafc,
            #eef2ff
        );

    display:flex;

    flex-direction:column;

    justify-content:center;

    align-items:center;

    padding:40px 20px;
}

/* PHOTO */

.student-profile-photo{

    width:220px;

    height:220px;

    border-radius:50%;

    object-fit:cover;

    border:8px solid white;

    box-shadow:
        0 15px 40px rgba(0,0,0,0.18);

    transition:0.3s;
}

.student-profile-photo:hover{

    transform:scale(1.03);
}

/* NAME */

.student-name{

    margin-top:25px;

    font-weight:700;

    color:#0f172a;

    text-align:center;
}

/* CLASS */

.student-class{

    margin-top:10px;

    background:#2563eb;

    color:white;

    padding:8px 18px;

    border-radius:50px;

    font-size:14px;

    font-weight:600;
}

/* RIGHT */

.info-section{

    padding:40px;
}

/* INFO CARD */

.info-card{

    background:#f8fafc;

    border-radius:18px;

    padding:20px;

    border:1px solid #e2e8f0;

    transition:0.3s;
}

.info-card:hover{

    transform:translateY(-3px);

    box-shadow:
        0 10px 25px rgba(0,0,0,0.08);
}

/* LABEL */

.info-label{

    font-size:13px;

    color:#64748b;

    margin-bottom:8px;

    font-weight:600;
}

/* VALUE */

.info-value{

    font-size:18px;

    font-weight:700;

    color:#0f172a;
}

/* RESPONSIVE */

@media(max-width:991px){

    .photo-section{

        padding:30px 15px;
    }

    .student-profile-photo{

        width:170px;
        height:170px;
    }

    .info-section{

        padding:25px;
    }

    .student-header{

        flex-direction:column;

        gap:15px;

        text-align:center;
    }
}

</style>

@endsection