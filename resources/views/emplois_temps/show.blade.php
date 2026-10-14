@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 emploi-page">

        {{-- EN-TÊTE --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 no-print">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-calendar-week text-primary"></i>
                    Emploi du temps
                </h2>
                <p class="text-muted mb-0">
                    Planning hebdomadaire de la classe
                </p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('emplois-temps.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>

                <button type="button" class="btn btn-outline-dark" onclick="window.print()">
                    <i class="bi bi-printer"></i> Imprimer
                </button>

                @if ($emploiTemps->statut !== 'publie')
                    <a href="{{ route('emplois-temps.edit', $emploiTemps) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </a>
                @endif
            </div>
        </div>

        {{-- MESSAGES --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show no-print">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger no-print">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger no-print">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

            $couleursCours = [
                ['fond' => '#e8f1ff', 'bord' => '#3674d9', 'texte' => '#174a8b'],
                ['fond' => '#e5f7ed', 'bord' => '#299764', 'texte' => '#17663a'],
                ['fond' => '#fff1df', 'bord' => '#e59b32', 'texte' => '#8a4b08'],
                ['fond' => '#f2eaff', 'bord' => '#9361d9', 'texte' => '#60349c'],
                ['fond' => '#ffe8ed', 'bord' => '#db5876', 'texte' => '#9e2948'],
                ['fond' => '#e1f6f6', 'bord' => '#299d9d', 'texte' => '#146b6b'],
            ];

            $creneauxParJour = $emploiTemps->creneaux->groupBy('jour');
        @endphp

        {{-- INFORMATIONS GÉNÉRALES --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-4 align-items-center">

                    <div class="col-md-4">
                        <div class="info-label">
                            <i class="bi bi-people me-1"></i> Classe
                        </div>
                        <div class="info-value">
                            {{ $emploiTemps->classe->nom ?? 'Non renseignée' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-label">
                            <i class="bi bi-calendar3 me-1"></i> Année scolaire
                        </div>
                        <div class="info-value">
                            @if ($emploiTemps->anneeScolaire)
                                {{ $emploiTemps->anneeScolaire->nom ??
                                    ($emploiTemps->anneeScolaire->libelle ?? ($emploiTemps->anneeScolaire->annee ?? $emploiTemps->anneeScolaire->id)) }}
                            @else
                                Non renseignée
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-label">
                            <i class="bi bi-file-text me-1"></i> Titre
                        </div>
                        <div class="info-value">
                            {{ $emploiTemps->titre ?: 'Emploi du temps de la classe' }}
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <span class="text-muted me-2">Statut :</span>

                        @if ($emploiTemps->statut === 'publie')
                            <span class="badge bg-success px-3 py-2">
                                <i class="bi bi-check-circle"></i> Publié
                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">
                                <i class="bi bi-pencil"></i> Brouillon
                            </span>
                        @endif

                        <span class="badge bg-light text-dark border ms-2">
                            {{ $emploiTemps->creneaux->count() }}
                            créneau(x)
                        </span>
                    </div>

                    <div class="d-flex flex-wrap gap-2 no-print">
                        @if ($emploiTemps->statut === 'brouillon')
                            <form action="{{ route('emplois-temps.publier', $emploiTemps) }}" method="POST"
                                onsubmit="return confirm('Voulez-vous publier cet emploi du temps ?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i>
                                    Publier l'emploi du temps
                                </button>
                            </form>
                        @else
                            <form action="{{ route('emplois-temps.brouillon', $emploiTemps) }}" method="POST"
                                onsubmit="return confirm('Remettre cet emploi du temps en brouillon ?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-outline-warning">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                    Remettre en brouillon
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- PLANNING HEBDOMADAIRE --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="mb-1">
                            <i class="bi bi-calendar-week me-2"></i>
                            Planning hebdomadaire
                        </h5>
                        <small>Vue des cours du lundi au samedi</small>
                    </div>

                    <span class="badge bg-white text-primary">
                        {{ $emploiTemps->creneaux->count() }} cours
                    </span>
                </div>
            </div>

            <div class="card-body p-3">
                @if ($emploiTemps->creneaux->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x display-4 text-muted"></i>
                        <h5 class="mt-3">Aucun cours programmé</h5>
                        <p class="text-muted mb-0">
                            Ajoutez des créneaux horaires pour construire le planning.
                        </p>
                    </div>
                @else
                    <div class="planning-grid">

                        @foreach ($jours as $jour)
                            @php
                                $coursDuJour = ($creneauxParJour->get($jour) ?? collect())->sortBy('heure_debut');
                            @endphp

                            <section class="planning-day">

                                <div class="planning-day-header">
                                    <i class="bi bi-calendar-day me-1"></i>
                                    {{ $jour }}
                                    <span class="day-count">
                                        {{ $coursDuJour->count() }}
                                    </span>
                                </div>

                                <div class="planning-day-body">

                                    @forelse($coursDuJour as $creneau)
                                        @php
                                            $couleur = $couleursCours[$loop->index % count($couleursCours)];
                                        @endphp

                                        <article class="course-card"
                                            style="--course-bg: {{ $couleur['fond'] }};
                                                    --course-border: {{ $couleur['bord'] }};
                                                    --course-text: {{ $couleur['texte'] }};">

                                            <div class="course-time">
                                                <i class="bi bi-clock"></i>
                                                {{ substr($creneau->heure_debut, 0, 5) }}
                                                –
                                                {{ substr($creneau->heure_fin, 0, 5) }}
                                            </div>

                                            <div class="course-subject">
                                                {{ $creneau->matiere->nom ?? 'Matière inconnue' }}
                                            </div>

                                            <div class="course-detail">
                                                <i class="bi bi-person"></i>
                                                {{ $creneau->enseignant->nom ?? 'Enseignant inconnu' }}
                                                {{ $creneau->enseignant->prenom ?? '' }}
                                            </div>

                                            <div class="course-detail">
                                                <i class="bi bi-door-open"></i>
                                                {{ $creneau->salle->nom ?? 'Salle inconnue' }}
                                            </div>

                                            @if ($emploiTemps->statut !== 'publie')
                                                <form
                                                    action="{{ route('emplois-temps.creneaux.destroy', [$emploiTemps, $creneau]) }}"
                                                    method="POST" class="mt-2 no-print"
                                                    onsubmit="return confirm('Supprimer ce créneau ?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                        <i class="bi bi-trash"></i>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @endif

                                        </article>
                                    @empty
                                        <div class="empty-day">
                                            <i class="bi bi-sun"></i>
                                            <span>Aucun cours</span>
                                        </div>
                                    @endforelse

                                </div>
                            </section>
                        @endforeach

                    </div>

                    <div class="planning-legend mt-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Les cours sont classés par heure de début dans chaque journée.
                    </div>
                @endif
            </div>
        </div>

        {{-- FORMULAIRE D'AJOUT --}}
        @if ($emploiTemps->statut !== 'publie')
            <div class="card border-0 shadow-sm mb-4 no-print">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>
                        Ajouter un créneau horaire
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('emplois-temps.creneaux.store', $emploiTemps) }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label for="matiere_id" class="form-label fw-semibold">
                                    Matière <span class="text-danger">*</span>
                                </label>

                                <select name="matiere_id" id="matiere_id"
                                    class="form-select @error('matiere_id') is-invalid @enderror" required>
                                    <option value="">Choisir une matière</option>

                                    @foreach ($matieres as $matiere)
                                        <option value="{{ $matiere->id }}"
                                            {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                            {{ $matiere->nom }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('matiere_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="enseignant_id" class="form-label fw-semibold">
                                    Enseignant <span class="text-danger">*</span>
                                </label>

                                <select name="enseignant_id" id="enseignant_id"
                                    class="form-select @error('enseignant_id') is-invalid @enderror" required>
                                    <option value="">Choisir un enseignant</option>

                                    @foreach ($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}"
                                            {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                            {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('enseignant_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="salle_id" class="form-label fw-semibold">
                                    Salle <span class="text-danger">*</span>
                                </label>

                                <select name="salle_id" id="salle_id"
                                    class="form-select @error('salle_id') is-invalid @enderror" required>
                                    <option value="">Choisir une salle</option>

                                    @foreach ($salles as $salle)
                                        <option value="{{ $salle->id }}"
                                            {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                                            {{ $salle->nom }} ({{ $salle->code }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('salle_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="jour" class="form-label fw-semibold">
                                    Jour <span class="text-danger">*</span>
                                </label>

                                <select name="jour" id="jour"
                                    class="form-select @error('jour') is-invalid @enderror" required>
                                    <option value="">Choisir un jour</option>

                                    @foreach ($jours as $jour)
                                        <option value="{{ $jour }}" {{ old('jour') == $jour ? 'selected' : '' }}>
                                            {{ $jour }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('jour')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="heure_debut" class="form-label fw-semibold">
                                    Heure de début <span class="text-danger">*</span>
                                </label>

                                <input type="time" name="heure_debut" id="heure_debut"
                                    class="form-control @error('heure_debut') is-invalid @enderror"
                                    value="{{ old('heure_debut') }}" required>

                                @error('heure_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="heure_fin" class="form-label fw-semibold">
                                    Heure de fin <span class="text-danger">*</span>
                                </label>

                                <input type="time" name="heure_fin" id="heure_fin"
                                    class="form-control @error('heure_fin') is-invalid @enderror"
                                    value="{{ old('heure_fin') }}" required>

                                @error('heure_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="alert alert-info mt-4 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Les conflits horaires sont vérifiés lors de l'enregistrement.
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                Ajouter le créneau
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>

    {{-- STYLES DU PLANNING --}}
    <style>
        .emploi-page .info-label {
            color: #6c757d;
            font-size: .875rem;
            margin-bottom: 6px;
        }

        .emploi-page .info-value {
            font-size: 1.05rem;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .planning-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(180px, 1fr));
            gap: 12px;
            align-items: stretch;
        }

        .planning-day {
            min-width: 0;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
            background: #f8f9fa;
        }

        .planning-day-header {
            background: #e9efff;
            color: #244a91;
            padding: 12px 8px;
            font-weight: 700;
            text-align: center;
            border-bottom: 1px solid #d6e1fb;
        }

        .day-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            height: 22px;
            padding: 0 5px;
            margin-left: 3px;
            border-radius: 20px;
            background: #ffffff;
            font-size: .75rem;
        }

        .planning-day-body {
            padding: 8px;
            min-height: 180px;
            height: 100%;
        }

        .course-card {
            background: var(--course-bg);
            color: var(--course-text);
            border-left: 4px solid var(--course-border);
            border-radius: 7px;
            padding: 10px;
            margin-bottom: 10px;
            overflow-wrap: anywhere;
        }

        .course-card:last-child {
            margin-bottom: 0;
        }

        .course-time {
            font-size: .78rem;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .course-subject {
            font-size: .95rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .course-detail {
            font-size: .78rem;
            margin-top: 5px;
        }

        .empty-day {
            display: flex;
            min-height: 150px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 8px;
            color: #adb5bd;
            font-size: .85rem;
        }

        .empty-day i {
            font-size: 1.5rem;
        }

        .planning-legend {
            color: #6c757d;
            font-size: .85rem;
        }

        @media (max-width: 1400px) {
            .planning-grid {
                grid-template-columns: repeat(3, minmax(180px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .planning-grid {
                grid-template-columns: repeat(2, minmax(150px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .planning-grid {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }

            body {
                background: #ffffff !important;
                font-size: 10px;
            }

            .no-print,
            .sidebar,
            .topbar,
            nav,
            .btn,
            form {
                display: none !important;
            }

            .emploi-page {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
                break-inside: avoid;
            }

            .planning-grid {
                grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
                gap: 5px;
            }

            .planning-day {
                min-width: 0 !important;
                break-inside: avoid;
            }

            .planning-day-header {
                padding: 6px 3px;
            }

            .planning-day-body {
                padding: 4px;
            }

            .course-card {
                padding: 5px;
                margin-bottom: 5px;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .course-subject {
                font-size: 9px;
            }

            .course-detail,
            .course-time {
                font-size: 8px;
            }

            .planning-legend {
                margin-top: 5px;
            }
        }
    </style>
@endsection
