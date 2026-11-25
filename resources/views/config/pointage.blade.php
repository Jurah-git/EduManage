@extends('layouts.app')

@section('content')
    @php
        $joursSelectionnes = old('jours_cours', $config->jours_cours ?? ['lun', 'mar', 'mer', 'jeu', 'ven']);
        $joursListe = [
            'lun' => 'Lundi',
            'mar' => 'Mardi',
            'mer' => 'Mercredi',
            'jeu' => 'Jeudi',
            'ven' => 'Vendredi',
            'sam' => 'Samedi',
        ];
        $modeActuel = old('mode_pointage', $config->mode_pointage ?? 'qr_badge');
    @endphp

    <div class="pointage-config-wrapper">
        {{-- En-tête de page --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="pointage-breadcrumb mb-1">
                    <i class="bi bi-calendar-check"></i>
                    <span>Présences et discipline • Configuration du pointage</span>
                </div>
                <h4 class="pointage-title mb-1">Paramètres de pointage scolaire</h4>
                <p class="pointage-subtitle mb-0">
                    Définissez les horaires d'entrée et de sortie, les marges de retard, les seuils d'absence et les jours
                    de classe.
                </p>
            </div>

            <a href="{{ route('dashboard') }}" class="btn btn-light border pointage-back-btn">
                <i class="bi bi-arrow-left me-1"></i> Tableau de bord
            </a>
        </div>

        {{-- Messages de retour --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 mb-4" role="alert">
                <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Veuillez corriger les
                    champs suivants :</div>
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Bandeau récapitulatif --}}
        <div class="card pointage-summary-card mb-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="pointage-icon-badge">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div class="small text-muted fw-semibold text-uppercase">Règle horaire active</div>
                        <div id="pointageResumeText" class="fw-bold pointage-resume-main">
                            Matin
                            {{ old('debut_matin', $config->debut_matin ?? '07:30') }}–{{ old('fin_matin', $config->fin_matin ?? '12:00') }}
                            · Après-midi
                            {{ old('debut_apres_midi', $config->debut_apres_midi ?? '14:00') }}–{{ old('fin_apres_midi', $config->fin_apres_midi ?? '17:00') }}
                            · Tolérance : <span
                                id="pointageResumeTol">{{ old('tolerance_retard', $config->tolerance_retard ?? 10) }}</span>
                            min
                        </div>
                    </div>
                </div>
                <span class="pointage-badge-active">
                    <i class="bi bi-dot"></i> Configuration active
                </span>
            </div>
        </div>

        {{-- Formulaire de configuration --}}
        <form id="pointageConfigForm" action="{{ route('config.pointage.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- Colonne gauche : Horaires & Jours --}}
                <div class="col-lg-7">
                    <div class="card pointage-card mb-4">
                        <div class="card-header pointage-card-header">
                            <i class="bi bi-alarm me-2 text-warning"></i>
                            <span>Horaires de l'établissement</span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="ouverture_portail" class="form-label fw-semibold">Ouverture du
                                        portail</label>
                                    <input type="time" id="ouverture_portail" name="ouverture_portail"
                                        class="form-control @error('ouverture_portail') is-invalid @enderror"
                                        value="{{ old('ouverture_portail', $config->ouverture_portail ?? '07:15') }}"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="debut_matin" class="form-label fw-semibold">Début des cours (matin)</label>
                                    <input type="time" id="debut_matin" name="debut_matin"
                                        class="form-control @error('debut_matin') is-invalid @enderror"
                                        value="{{ old('debut_matin', $config->debut_matin ?? '07:30') }}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="fin_matin" class="form-label fw-semibold">Fin des cours (matin)</label>
                                    <input type="time" id="fin_matin" name="fin_matin"
                                        class="form-control @error('fin_matin') is-invalid @enderror"
                                        value="{{ old('fin_matin', $config->fin_matin ?? '12:00') }}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="debut_apres_midi" class="form-label fw-semibold">Reprise des cours
                                        (après-midi)</label>
                                    <input type="time" id="debut_apres_midi" name="debut_apres_midi"
                                        class="form-control @error('debut_apres_midi') is-invalid @enderror"
                                        value="{{ old('debut_apres_midi', $config->debut_apres_midi ?? '14:00') }}"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="fin_apres_midi" class="form-label fw-semibold">Fin des cours (soir)</label>
                                    <input type="time" id="fin_apres_midi" name="fin_apres_midi"
                                        class="form-control @error('fin_apres_midi') is-invalid @enderror"
                                        value="{{ old('fin_apres_midi', $config->fin_apres_midi ?? '17:00') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card pointage-card">
                        <div class="card-header pointage-card-header">
                            <i class="bi bi-calendar3 me-2 text-warning"></i>
                            <span>Jours de classe</span>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-3">
                                Cochez les jours ouvrés de l'établissement pour le calcul des présences, retards et
                                absences.
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($joursListe as $code => $jourNom)
                                    <label class="pointage-day-option">
                                        <input type="checkbox" name="jours_cours[]" value="{{ $code }}"
                                            {{ in_array($code, $joursSelectionnes) ? 'checked' : '' }}>
                                        <span>{{ $jourNom }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Colonne droite : Retards, absences & options --}}
                <div class="col-lg-5">
                    <div class="card pointage-card h-100">
                        <div class="card-header pointage-card-header">
                            <i class="bi bi-sliders me-2 text-warning"></i>
                            <span>Règles de pointage et suivi</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="mb-3">
                                    <label for="tolerance_retard" class="form-label fw-semibold">Tolérance de retard
                                        (minutes)</label>
                                    <input type="number" id="tolerance_retard" name="tolerance_retard" min="0"
                                        max="60"
                                        class="form-control @error('tolerance_retard') is-invalid @enderror"
                                        value="{{ old('tolerance_retard', $config->tolerance_retard ?? 10) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="seuil_absence" class="form-label fw-semibold">Seuil d'absence injustifiée
                                        (minutes après début)</label>
                                    <input type="number" id="seuil_absence" name="seuil_absence" min="5"
                                        max="240" class="form-control @error('seuil_absence') is-invalid @enderror"
                                        value="{{ old('seuil_absence', $config->seuil_absence ?? 30) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="mode_pointage" class="form-label fw-semibold">Méthode de pointage</label>
                                    <select id="mode_pointage" name="mode_pointage" class="form-select">
                                        <option value="qr_badge" {{ $modeActuel === 'qr_badge' ? 'selected' : '' }}>Badge
                                            / QR Code élève ou personnel</option>
                                        <option value="appel_manuel"
                                            {{ $modeActuel === 'appel_manuel' ? 'selected' : '' }}>Appel / Saisie manuelle
                                            (Vie scolaire)</option>
                                        <option value="biometrie" {{ $modeActuel === 'biometrie' ? 'selected' : '' }}>
                                            Terminal / Empreinte</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="jours_justification" class="form-label fw-semibold">Délai de justification
                                        d'absence (jours)</label>
                                    <input type="number" id="jours_justification" name="jours_justification"
                                        min="0" max="30" class="form-control"
                                        value="{{ old('jours_justification', $config->jours_justification ?? 3) }}">
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="alerter_parents"
                                        name="alerter_parents" value="1"
                                        {{ old('alerter_parents', $config->alerter_parents ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="alerter_parents">
                                        Signaler les retards et absences aux parents
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inclure_bulletin"
                                        name="inclure_bulletin" value="1"
                                        {{ old('inclure_bulletin', $config->inclure_bulletin ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inclure_bulletin">
                                        Reporter le bilan d'assiduité sur les bulletins
                                    </label>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-top d-flex flex-wrap justify-content-between gap-2">
                                <button type="button" id="btnResetPointage" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Valeurs par défaut
                                </button>
                                <button type="submit" class="btn pointage-btn-save px-4">
                                    <i class="bi bi-check2-circle me-1"></i> Enregistrer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .pointage-breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 600;
            color: #123f9d;
        }

        .pointage-title {
            color: #0b1933;
            font-weight: 750;
            letter-spacing: -0.3px;
        }

        .pointage-subtitle {
            color: #64748b;
            font-size: 13px;
        }

        .pointage-card,
        .pointage-summary-card {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        }

        .pointage-card-header {
            background: #0b1933;
            color: #ffffff;
            font-weight: 650;
            font-size: 14px;
            padding: 13px 18px;
            border-radius: 12px 12px 0 0 !important;
        }

        .pointage-icon-badge {
            width: 44px;
            height: 44px;
            border-radius: 11px;
            background: rgba(18, 63, 157, 0.1);
            color: #123f9d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .pointage-resume-main {
            color: #0b1933;
            font-size: 14px;
        }

        .pointage-badge-active {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 999px;
            background: rgba(16, 185, 129, 0.14);
            color: #047857;
            font-size: 12px;
            font-weight: 700;
        }

        .pointage-btn-save {
            background: linear-gradient(100deg, #123f9d, #0c347a);
            color: #ffffff;
            font-weight: 650;
            border: none;
            border-radius: 9px;
        }

        .pointage-btn-save:hover {
            color: #ffc928;
            background: linear-gradient(100deg, #0c347a, #0b1933);
        }

        .pointage-day-option {
            cursor: pointer;
            user-select: none;
            margin: 0;
        }

        .pointage-day-option input {
            display: none;
        }

        .pointage-day-option span {
            display: inline-block;
            padding: 7px 14px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            background: #f8fafc;
            transition: all 0.2s ease;
        }

        .pointage-day-option input:checked+span {
            background: #123f9d;
            border-color: #123f9d;
            color: #ffffff;
            box-shadow: inset 0 -2px 0 #ffc928;
        }

        /* Compatibilité avec le mode sombre global de layouts.app */
        html[data-app-theme="dark"] .pointage-breadcrumb {
            color: #ffc928;
        }

        html[data-app-theme="dark"] .pointage-title,
        html[data-app-theme="dark"] .pointage-resume-main {
            color: #f8fafc;
        }

        html[data-app-theme="dark"] .pointage-subtitle {
            color: #94a3b8;
        }

        html[data-app-theme="dark"] .pointage-day-option span {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        html[data-app-theme="dark"] .pointage-day-option input:checked+span {
            background: #123f9d;
            border-color: #ffc928;
            color: #ffffff;
        }

        html[data-app-theme="dark"] .pointage-back-btn {
            background: #162036;
            border-color: #263554;
            color: #f1f5f9;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const debutMatin = document.getElementById('debut_matin');
            const finMatin = document.getElementById('fin_matin');
            const debutAm = document.getElementById('debut_apres_midi');
            const finAm = document.getElementById('fin_apres_midi');
            const tolerance = document.getElementById('tolerance_retard');
            const resumeText = document.getElementById('pointageResumeText');

            function rafraichirResume() {
                resumeText.innerHTML =
                    `Matin ${debutMatin.value || '--:--'}–${finMatin.value || '--:--'} ` +
                    `· Après-midi ${debutAm.value || '--:--'}–${finAm.value || '--:--'} ` +
                    `· Tolérance : <span id="pointageResumeTol">${tolerance.value || 0}</span> min`;
            }

            [debutMatin, finMatin, debutAm, finAm, tolerance].forEach(input => {
                input.addEventListener('input', rafraichirResume);
            });

            document.getElementById('btnResetPointage').addEventListener('click', function() {
                document.getElementById('ouverture_portail').value = '07:15';
                debutMatin.value = '07:30';
                finMatin.value = '12:00';
                debutAm.value = '14:00';
                finAm.value = '17:00';
                tolerance.value = '10';
                document.getElementById('seuil_absence').value = '30';
                document.getElementById('jours_justification').value = '3';
                document.getElementById('mode_pointage').value = 'qr_badge';
                document.getElementById('alerter_parents').checked = true;
                document.getElementById('inclure_bulletin').checked = true;

                document.querySelectorAll('input[name="jours_cours[]"]').forEach(cb => {
                    cb.checked = ['lun', 'mar', 'mer', 'jeu', 'ven'].includes(cb.value);
                });


                rafraichirResume();
            });
        });
    </script>
@endsection
