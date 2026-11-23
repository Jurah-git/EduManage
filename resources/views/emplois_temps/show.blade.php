@extends('layouts.app')

@section('content')

    <div class="emploi-show-page">

        <style>
            /* =====================================================
               EMPLOI DU TEMPS - FICHE DÉTAILLÉE
            ===================================================== */

            .emploi-show-page {
                --es-bg: #f4f7fc;
                --es-card: #ffffff;
                --es-surface: #f8faff;
                --es-text: #24344d;
                --es-muted: #718096;
                --es-border: #e3eaf3;
                --es-primary: #3563e9;
                --es-primary-dark: #244dc2;
                --es-input: #ffffff;
                --es-day-bg: #f8faff;
                --es-day-header: #e9efff;
                --es-day-header-text: #244a91;
                --es-empty: #a0aec0;
                --es-shadow: 0 10px 30px rgba(30, 55, 90, .07);

                min-height: 100vh;
                padding: 26px;
                background: var(--es-bg);
                color: var(--es-text);
                transition: background .25s ease, color .25s ease;
            }

            /* =====================================================
               MODE SOMBRE
            ===================================================== */

            html[data-app-theme="dark"] .emploi-show-page {
                --es-bg: #111827;
                --es-card: #1e293b;
                --es-surface: #263449;
                --es-text: #e5edf8;
                --es-muted: #a0aec0;
                --es-border: #35465e;
                --es-primary: #7095ff;
                --es-primary-dark: #5479e8;
                --es-input: #172337;
                --es-day-bg: #172337;
                --es-day-header: #293c5b;
                --es-day-header-text: #c7d8ff;
                --es-empty: #8191a8;
                --es-shadow: 0 10px 30px rgba(0, 0, 0, .22);
            }

            /* =====================================================
               ULTRA PRO
            ===================================================== */

            html[data-app-theme="ultra-pro"] .emploi-show-page {
                --es-bg: #101827;
                --es-card: #182438;
                --es-surface: #202f46;
                --es-text: #edf3ff;
                --es-muted: #a8b8d0;
                --es-border: #34445c;
                --es-primary: #8b9cff;
                --es-primary-dark: #6d7ee9;
                --es-input: #121e30;
                --es-day-bg: #17243a;
                --es-day-header: #293d5c;
                --es-day-header-text: #d5e2ff;
                --es-empty: #8293ac;
                --es-shadow: 0 15px 35px rgba(0, 0, 0, .28);
            }

            /* =====================================================
               EMERALD
            ===================================================== */

            html[data-app-theme="emerald"] .emploi-show-page {
                --es-bg: #eff8f4;
                --es-card: #ffffff;
                --es-surface: #f3faf6;
                --es-text: #164536;
                --es-muted: #66877a;
                --es-border: #d5e9df;
                --es-primary: #13865f;
                --es-primary-dark: #0d6b4b;
                --es-input: #ffffff;
                --es-day-bg: #f4faf6;
                --es-day-header: #dff2e7;
                --es-day-header-text: #176442;
                --es-empty: #8ba99b;
                --es-shadow: 0 10px 30px rgba(18, 100, 70, .08);
            }

            /* =====================================================
               WARM
            ===================================================== */

            html[data-app-theme="warm"] .emploi-show-page {
                --es-bg: #faf5ef;
                --es-card: #fffdf9;
                --es-surface: #fdf7ef;
                --es-text: #59402f;
                --es-muted: #927966;
                --es-border: #eddfd0;
                --es-primary: #b8753e;
                --es-primary-dark: #955b2e;
                --es-input: #fffdf9;
                --es-day-bg: #fdf8f1;
                --es-day-header: #f5e8d8;
                --es-day-header-text: #875328;
                --es-empty: #b29a85;
                --es-shadow: 0 10px 30px rgba(120, 75, 35, .08);
            }

            /* =====================================================
               EN-TÊTE
            ===================================================== */

            .es-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 18px;
                margin-bottom: 26px;
            }

            .es-heading {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .es-heading-icon {
                width: 58px;
                height: 58px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 17px;
                background: linear-gradient(135deg, var(--es-primary), var(--es-primary-dark));
                color: #fff;
                font-size: 25px;
                box-shadow: 0 7px 17px rgba(53, 99, 233, .2);
            }

            .es-title {
                color: var(--es-text);
                font-size: 25px;
                font-weight: 800;
                letter-spacing: -.5px;
                margin: 0 0 5px;
            }

            .es-subtitle {
                color: var(--es-muted);
                font-size: 13px;
                margin: 0;
            }

            .es-header-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 9px;
            }

            .es-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                min-height: 42px;
                padding: 10px 16px;
                border-radius: 10px;
                font-size: 12px;
                font-weight: 750;
                text-decoration: none;
                cursor: pointer;
                transition: all .2s ease;
            }

            .es-btn:hover {
                transform: translateY(-2px);
            }

            .es-btn-back {
                color: var(--es-text);
                background: var(--es-card);
                border: 1px solid var(--es-border);
            }

            .es-btn-back:hover {
                color: var(--es-primary);
                border-color: var(--es-primary);
            }

            .es-btn-print {
                color: var(--es-text);
                background: var(--es-card);
                border: 1px solid var(--es-border);
            }

            .es-btn-print:hover {
                color: var(--es-primary);
                border-color: var(--es-primary);
            }

            .es-btn-edit {
                color: #fff;
                background: linear-gradient(135deg, var(--es-primary), var(--es-primary-dark));
                border: 1px solid var(--es-primary);
            }

            .es-btn-edit:hover {
                color: #fff;
                filter: brightness(1.08);
            }

            /* =====================================================
               CARTES
            ===================================================== */

            .es-card {
                overflow: hidden;
                margin-bottom: 24px;
                border: 1px solid var(--es-border);
                border-radius: 17px;
                background: var(--es-card);
                box-shadow: var(--es-shadow);
            }

            .es-card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 12px;
                padding: 19px 23px;
                background: linear-gradient(135deg, var(--es-primary), var(--es-primary-dark));
                color: #fff;
            }

            .es-card-header h5 {
                margin: 0 0 4px;
                font-size: 15px;
                font-weight: 800;
            }

            .es-card-header small {
                color: rgba(255, 255, 255, .85);
                font-size: 11px;
            }

            .es-card-header-icon {
                display: flex;
                align-items: center;
                gap: 11px;
            }

            .es-header-icon-box {
                width: 39px;
                height: 39px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 11px;
                background: rgba(255, 255, 255, .17);
                font-size: 18px;
            }

            .es-card-body {
                padding: 24px;
            }

            /* =====================================================
               INFORMATIONS GÉNÉRALES
            ===================================================== */

            .es-info-item {
                height: 100%;
                padding: 16px;
                border: 1px solid var(--es-border);
                border-radius: 13px;
                background: var(--es-surface);
            }

            .es-info-label {
                display: flex;
                align-items: center;
                gap: 7px;
                margin-bottom: 9px;
                color: var(--es-muted);
                font-size: 11px;
                font-weight: 750;
                text-transform: uppercase;
                letter-spacing: .45px;
            }

            .es-info-label i {
                color: var(--es-primary);
                font-size: 15px;
            }

            .es-info-value {
                color: var(--es-text);
                font-size: 16px;
                font-weight: 800;
                overflow-wrap: anywhere;
            }

            .es-info-separator {
                border-color: var(--es-border);
                opacity: 1;
                margin: 23px 0;
            }

            .es-status-area {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 15px;
            }

            .es-status-label {
                color: var(--es-muted);
                font-size: 12px;
                font-weight: 700;
                margin-right: 8px;
            }

            .es-status-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 7px 12px;
                border-radius: 30px;
                font-size: 11px;
                font-weight: 800;
            }

            .es-status-published {
                background: #dcfce7;
                color: #166534;
            }

            .es-status-draft {
                background: #fff3cd;
                color: #946200;
            }

            .es-count-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 7px 12px;
                margin-left: 5px;
                border: 1px solid var(--es-border);
                border-radius: 30px;
                background: var(--es-surface);
                color: var(--es-text);
                font-size: 11px;
                font-weight: 750;
            }

            .es-status-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 9px;
            }

            .es-action-form {
                margin: 0;
            }

            .es-btn-publish {
                color: #fff;
                background: #168653;
                border: 1px solid #168653;
            }

            .es-btn-publish:hover {
                color: #fff;
                background: #116d43;
            }

            .es-btn-draft {
                color: #a66a0a;
                background: transparent;
                border: 1px solid #d9a441;
            }

            .es-btn-draft:hover {
                color: #fff;
                background: #bd8524;
            }

            /* =====================================================
               PLANNING HEBDOMADAIRE
            ===================================================== */

            .es-planning-body {
                padding: 20px;
            }

            .planning-grid {
                display: grid;
                grid-template-columns: repeat(6, minmax(0, 1fr));
                gap: 12px;
                align-items: stretch;
            }

            .planning-day {
                min-width: 0;
                overflow: hidden;
                border: 1px solid var(--es-border);
                border-radius: 12px;
                background: var(--es-day-bg);
            }

            .planning-day-header {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
                gap: 6px;
                padding: 13px 7px;
                border-bottom: 1px solid var(--es-border);
                background: var(--es-day-header);
                color: var(--es-day-header-text);
                font-size: 12px;
                font-weight: 800;
                text-align: center;
            }

            .planning-day-header i {
                font-size: 14px;
            }

            .day-count {
                display: inline-flex;
                justify-content: center;
                align-items: center;
                min-width: 21px;
                height: 21px;
                padding: 0 5px;
                border-radius: 20px;
                background: var(--es-card);
                color: var(--es-text);
                font-size: 10px;
            }

            .planning-day-body {
                display: flex;
                flex-direction: column;
                gap: 10px;
                min-height: 190px;
                padding: 9px;
            }

            /* =====================================================
               CARTES DE COURS
            ===================================================== */

            .course-card {
                padding: 12px;
                border: 1px solid color-mix(in srgb, var(--course-border) 30%, transparent);
                border-left: 4px solid var(--course-border);
                border-radius: 9px;
                background: var(--course-bg);
                color: var(--course-text);
                overflow-wrap: anywhere;
                transition: transform .2s ease, box-shadow .2s ease;
            }

            .course-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 13px rgba(0, 0, 0, .08);
            }

            .course-time {
                display: flex;
                align-items: center;
                gap: 5px;
                margin-bottom: 8px;
                font-size: 11px;
                font-weight: 800;
            }

            .course-subject {
                margin-bottom: 9px;
                font-size: 14px;
                font-weight: 800;
                line-height: 1.4;
            }

            .course-detail {
                display: flex;
                align-items: flex-start;
                gap: 6px;
                margin-top: 6px;
                font-size: 11px;
                line-height: 1.5;
            }

            .course-detail i {
                flex-shrink: 0;
                margin-top: 2px;
            }

            .course-delete-btn {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 7px;
                border: 1px solid #dc3545;
                border-radius: 7px;
                background: transparent;
                color: #dc3545;
                font-size: 11px;
                font-weight: 750;
                transition: all .2s ease;
                cursor: pointer;
            }

            .course-delete-btn:hover {
                background: #dc3545;
                color: #fff;
            }

            /* Adaptation des cours aux thèmes sombres */

            html[data-app-theme="dark"] .course-card,
            html[data-app-theme="ultra-pro"] .course-card {
                background: color-mix(in srgb, var(--course-border) 19%, var(--es-card));
                color: var(--es-text);
                border-color: var(--es-border);
                border-left: 4px solid var(--course-border);
            }

            html[data-app-theme="emerald"] .course-card {
                background: color-mix(in srgb, var(--course-border) 9%, var(--es-card));
                color: var(--es-text);
            }

            html[data-app-theme="warm"] .course-card {
                background: color-mix(in srgb, var(--course-border) 8%, var(--es-card));
                color: var(--es-text);
            }

            .empty-day {
                display: flex;
                flex: 1;
                min-height: 160px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 9px;
                color: var(--es-empty);
                font-size: 11px;
                font-weight: 600;
            }

            .empty-day i {
                font-size: 25px;
                opacity: .7;
            }

            .es-planning-legend {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-top: 17px;
                padding: 12px 14px;
                border: 1px solid var(--es-border);
                border-radius: 10px;
                background: var(--es-surface);
                color: var(--es-muted);
                font-size: 11px;
            }

            /* =====================================================
               ÉTAT VIDE
            ===================================================== */

            .es-empty-state {
                padding: 55px 20px;
                text-align: center;
            }

            .es-empty-icon {
                width: 75px;
                height: 75px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 18px;
                border-radius: 22px;
                background: var(--es-surface);
                color: var(--es-muted);
                font-size: 34px;
            }

            .es-empty-title {
                color: var(--es-text);
                font-size: 17px;
                font-weight: 800;
                margin-bottom: 7px;
            }

            .es-empty-text {
                color: var(--es-muted);
                font-size: 12px;
                margin: 0;
            }

            /* =====================================================
               FORMULAIRE D'AJOUT
            ===================================================== */

            .es-form-body {
                padding: 25px;
            }

            .es-form-label {
                display: flex;
                align-items: center;
                gap: 7px;
                margin-bottom: 8px;
                color: var(--es-text);
                font-size: 12px;
                font-weight: 750;
            }

            .es-form-label i {
                color: var(--es-primary);
                font-size: 14px;
            }

            .es-form-control {
                width: 100%;
                min-height: 45px;
                padding: 10px 12px;
                border: 1px solid var(--es-border);
                border-radius: 9px;
                outline: none;
                background: var(--es-input);
                color: var(--es-text);
                font-size: 12px;
                transition: all .2s ease;
            }

            .es-form-control:focus {
                border-color: var(--es-primary);
                box-shadow: 0 0 0 3px rgba(53, 99, 233, .12);
                background: var(--es-input);
                color: var(--es-text);
            }

            .es-form-control option {
                background: var(--es-card);
                color: var(--es-text);
            }

            .es-form-control.is-invalid {
                border-color: #dc3545;
            }

            .es-invalid-feedback {
                display: block;
                margin-top: 5px;
                color: #dc3545;
                font-size: 11px;
            }

            .es-form-info {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                padding: 13px 15px;
                margin-top: 22px;
                border: 1px solid var(--es-border);
                border-radius: 10px;
                background: var(--es-surface);
                color: var(--es-muted);
                font-size: 11px;
                line-height: 1.6;
            }

            .es-form-info i {
                color: var(--es-primary);
                font-size: 16px;
            }

            .es-form-footer {
                display: flex;
                justify-content: flex-end;
                margin-top: 22px;
            }

            .es-btn-add {
                min-height: 43px;
                padding: 10px 18px;
                border: 1px solid var(--es-primary);
                border-radius: 9px;
                background: linear-gradient(135deg, var(--es-primary), var(--es-primary-dark));
                color: #fff;
                font-size: 12px;
                font-weight: 750;
                transition: all .2s ease;
            }

            .es-btn-add:hover {
                color: #fff;
                filter: brightness(1.08);
                transform: translateY(-2px);
            }

            /* =====================================================
               ALERTES
            ===================================================== */

            .es-alert {
                display: flex;
                align-items: flex-start;
                gap: 11px;
                padding: 15px 18px;
                margin-bottom: 18px;
                border-radius: 12px;
                font-size: 12px;
            }

            .es-alert-success {
                border: 1px solid #a7dfbf;
                background: #e8f7ee;
                color: #17643b;
            }

            .es-alert-danger {
                border: 1px solid #f1bfc4;
                background: #fff0f1;
                color: #842029;
            }

            .es-alert-icon {
                font-size: 17px;
                flex-shrink: 0;
            }

            .es-alert ul {
                padding-left: 18px;
                margin: 8px 0 0;
            }

            html[data-app-theme="dark"] .es-alert-success,
            html[data-app-theme="ultra-pro"] .es-alert-success {
                background: #173d2c;
                border-color: #286344;
                color: #c0f0d1;
            }

            html[data-app-theme="dark"] .es-alert-danger,
            html[data-app-theme="ultra-pro"] .es-alert-danger {
                background: #42232a;
                border-color: #773d49;
                color: #ffd5da;
            }

            /* =====================================================
               RESPONSIVE
            ===================================================== */

            @media (max-width: 1400px) {
                .planning-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }

            @media (max-width: 768px) {
                .emploi-show-page {
                    padding: 17px;
                }

                .es-title {
                    font-size: 21px;
                }

                .es-heading-icon {
                    width: 49px;
                    height: 49px;
                    font-size: 21px;
                }

                .es-card-body,
                .es-planning-body,
                .es-form-body {
                    padding: 17px;
                }

                .planning-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .es-status-area {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .es-status-actions {
                    width: 100%;
                }
            }

            @media (max-width: 480px) {
                .es-header {
                    align-items: flex-start;
                }

                .es-header-actions {
                    width: 100%;
                }

                .es-header-actions .es-btn {
                    flex: 1;
                }

                .planning-grid {
                    grid-template-columns: minmax(0, 1fr);
                }

                .es-status-actions,
                .es-status-actions form,
                .es-status-actions button {
                    width: 100%;
                }

                .es-form-footer,
                .es-btn-add {
                    width: 100%;
                }
            }

            /* =====================================================
               IMPRESSION
            ===================================================== */

            @media print {

                @page {
                    size: landscape;
                    margin: 10mm;
                }

                html,
                body {
                    background: #fff !important;
                    color: #111 !important;
                }

                body {
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

                .emploi-show-page {
                    width: 100% !important;
                    min-height: auto !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    background: #fff !important;
                    color: #111 !important;
                }

                .es-card {
                    box-shadow: none !important;
                    border: 1px solid #ccc !important;
                    break-inside: avoid;
                    background: #fff !important;
                }

                .es-info-item {
                    background: #fff !important;
                    border-color: #ddd !important;
                }

                .es-info-label,
                .es-info-value {
                    color: #111 !important;
                }

                .es-card-header {
                    background: #315fbd !important;
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }

                .planning-grid {
                    grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
                    gap: 5px !important;
                }

                .planning-day {
                    min-width: 0 !important;
                    background: #fff !important;
                    border-color: #ccc !important;
                    break-inside: avoid;
                }

                .planning-day-header {
                    padding: 7px 3px !important;
                    background: #e9efff !important;
                    color: #244a91 !important;
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }

                .planning-day-body {
                    padding: 4px !important;
                }

                .course-card {
                    padding: 6px !important;
                    margin-bottom: 5px !important;
                    break-inside: avoid;
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }

                .course-subject {
                    font-size: 9px !important;
                }

                .course-time,
                .course-detail {
                    font-size: 8px !important;
                }

                .es-planning-legend {
                    color: #555 !important;
                }
            }
        </style>

        {{-- =====================================================
         DONNÉES DU PLANNING
    ====================================================== --}}

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

        {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}

        <div class="es-header no-print">

            <div class="es-heading">

                <div class="es-heading-icon">
                    <i class="bi bi-calendar-week"></i>
                </div>

                <div>
                    <h2 class="es-title">Emploi du temps</h2>

                    <p class="es-subtitle">
                        Planning hebdomadaire de la classe
                    </p>
                </div>

            </div>

            <div class="es-header-actions">

                <a href="{{ route('emplois-temps.index') }}" class="es-btn es-btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Retour
                </a>

                <button type="button" class="es-btn es-btn-print" onclick="window.print()">
                    <i class="bi bi-printer"></i>
                    Imprimer
                </button>

                @if ($emploiTemps->statut !== 'publie')
                    <a href="{{ route('emplois-temps.edit', $emploiTemps) }}" class="es-btn es-btn-edit">
                        <i class="bi bi-pencil-square"></i>
                        Modifier
                    </a>
                @endif

            </div>

        </div>

        {{-- =====================================================
         MESSAGES
    ====================================================== --}}

        @if (session('success'))
            <div class="es-alert es-alert-success no-print">

                <i class="bi bi-check-circle-fill es-alert-icon"></i>

                <div class="flex-grow-1">
                    {{ session('success') }}
                </div>

                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fermer">
                </button>

            </div>
        @endif

        @if (session('error'))
            <div class="es-alert es-alert-danger no-print">

                <i class="bi bi-exclamation-triangle-fill es-alert-icon"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>
        @endif

        @if ($errors->any())
            <div class="es-alert es-alert-danger no-print">

                <i class="bi bi-exclamation-triangle-fill es-alert-icon"></i>

                <div>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        @endif

        {{-- =====================================================
         INFORMATIONS GÉNÉRALES
    ====================================================== --}}

        <div class="es-card">

            <div class="es-card-body">

                <div class="row g-3">

                    {{-- Classe --}}

                    <div class="col-md-4">

                        <div class="es-info-item">

                            <div class="es-info-label">
                                <i class="bi bi-people"></i>
                                Classe
                            </div>

                            <div class="es-info-value">
                                {{ $emploiTemps->classe->nom ?? 'Non renseignée' }}
                            </div>

                        </div>

                    </div>

                    {{-- Année scolaire --}}

                    <div class="col-md-4">

                        <div class="es-info-item">

                            <div class="es-info-label">
                                <i class="bi bi-calendar3"></i>
                                Année scolaire
                            </div>

                            <div class="es-info-value">

                                @if ($emploiTemps->anneeScolaire)
                                    {{ $emploiTemps->anneeScolaire->nom ??
                                        ($emploiTemps->anneeScolaire->libelle ?? ($emploiTemps->anneeScolaire->annee ?? $emploiTemps->anneeScolaire->id)) }}
                                @else
                                    Non renseignée
                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- Titre --}}

                    <div class="col-md-4">

                        <div class="es-info-item">

                            <div class="es-info-label">
                                <i class="bi bi-file-text"></i>
                                Titre
                            </div>

                            <div class="es-info-value">
                                {{ $emploiTemps->titre ?: 'Emploi du temps de la classe' }}
                            </div>

                        </div>

                    </div>

                </div>

                <hr class="es-info-separator">

                {{-- Statut et actions --}}

                <div class="es-status-area">

                    <div class="d-flex flex-wrap align-items-center gap-2">

                        <span class="es-status-label">Statut :</span>

                        @if ($emploiTemps->statut === 'publie')
                            <span class="es-status-badge es-status-published">
                                <i class="bi bi-check-circle-fill"></i>
                                Publié
                            </span>
                        @else
                            <span class="es-status-badge es-status-draft">
                                <i class="bi bi-pencil-square"></i>
                                Brouillon
                            </span>
                        @endif

                        <span class="es-count-badge">
                            <i class="bi bi-clock"></i>
                            {{ $emploiTemps->creneaux->count() }} créneau(x)
                        </span>

                    </div>

                    <div class="es-status-actions no-print">

                        @if ($emploiTemps->statut === 'brouillon')
                            <form action="{{ route('emplois-temps.publier', $emploiTemps) }}" method="POST"
                                class="es-action-form"
                                onsubmit="return confirm('Voulez-vous publier cet emploi du temps ?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="es-btn es-btn-publish">
                                    <i class="bi bi-check-circle"></i>
                                    Publier l'emploi du temps
                                </button>

                            </form>
                        @else
                            <form action="{{ route('emplois-temps.brouillon', $emploiTemps) }}" method="POST"
                                class="es-action-form"
                                onsubmit="return confirm('Remettre cet emploi du temps en brouillon ?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="es-btn es-btn-draft">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                    Remettre en brouillon
                                </button>

                            </form>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        {{-- =====================================================
         PLANNING HEBDOMADAIRE
    ====================================================== --}}

        <div class="es-card">

            <div class="es-card-header">

                <div class="es-card-header-icon">

                    <div class="es-header-icon-box">
                        <i class="bi bi-calendar-week"></i>
                    </div>

                    <div>
                        <h5>Planning hebdomadaire</h5>
                        <small>Vue des cours du lundi au samedi</small>
                    </div>

                </div>

                <span class="badge bg-white text-primary rounded-pill px-3 py-2">
                    {{ $emploiTemps->creneaux->count() }} cours
                </span>

            </div>

            <div class="es-planning-body">

                @if ($emploiTemps->creneaux->isEmpty())
                    <div class="es-empty-state">

                        <div class="es-empty-icon">
                            <i class="bi bi-calendar-x"></i>
                        </div>

                        <div class="es-empty-title">
                            Aucun cours programmé
                        </div>

                        <p class="es-empty-text">
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

                                    <i class="bi bi-calendar-day"></i>

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
                                            style="
                                            --course-bg: {{ $couleur['fond'] }};
                                            --course-border: {{ $couleur['bord'] }};
                                            --course-text: {{ $couleur['texte'] }};
                                        ">

                                            {{-- Horaires --}}

                                            <div class="course-time">
                                                <i class="bi bi-clock"></i>

                                                {{ substr($creneau->heure_debut, 0, 5) }}

                                                –

                                                {{ substr($creneau->heure_fin, 0, 5) }}
                                            </div>

                                            {{-- Matière --}}

                                            <div class="course-subject">
                                                {{ $creneau->matiere->nom ?? 'Matière inconnue' }}
                                            </div>

                                            {{-- Enseignant --}}

                                            <div class="course-detail">
                                                <i class="bi bi-person"></i>

                                                <span>
                                                    {{ $creneau->enseignant->nom ?? 'Enseignant inconnu' }}
                                                    {{ $creneau->enseignant->prenom ?? '' }}
                                                </span>
                                            </div>

                                            {{-- Salle --}}

                                            <div class="course-detail">
                                                <i class="bi bi-door-open"></i>

                                                <span>
                                                    {{ $creneau->salle->nom ?? 'Salle inconnue' }}
                                                </span>
                                            </div>

                                            {{-- Suppression --}}

                                            @if ($emploiTemps->statut !== 'publie')
                                                <form
                                                    action="{{ route('emplois-temps.creneaux.destroy', [$emploiTemps, $creneau]) }}"
                                                    method="POST" class="mt-3 no-print"
                                                    onsubmit="return confirm('Supprimer ce créneau ?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="course-delete-btn">
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

                    <div class="es-planning-legend">
                        <i class="bi bi-info-circle"></i>

                        Les cours sont classés par heure de début dans chaque journée.
                    </div>
                @endif

            </div>

        </div>

        {{-- =====================================================
         FORMULAIRE D'AJOUT D'UN CRÉNEAU
    ====================================================== --}}

        @if ($emploiTemps->statut !== 'publie')
            <div class="es-card no-print">

                <div class="es-card-header">

                    <div class="es-card-header-icon">

                        <div class="es-header-icon-box">
                            <i class="bi bi-plus-circle"></i>
                        </div>

                        <div>
                            <h5>Ajouter un créneau horaire</h5>
                            <small>Complétez les informations du nouveau cours</small>
                        </div>

                    </div>

                </div>

                <div class="es-form-body">

                    <form action="{{ route('emplois-temps.creneaux.store', $emploiTemps) }}" method="POST">

                        @csrf

                        <div class="row g-3">

                            {{-- Matière --}}

                            <div class="col-md-4">

                                <label for="matiere_id" class="es-form-label">
                                    <i class="bi bi-book"></i>
                                    Matière
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="matiere_id" id="matiere_id"
                                    class="es-form-control @error('matiere_id') is-invalid @enderror" required>

                                    <option value="">Choisir une matière</option>

                                    @foreach ($matieres as $matiere)
                                        <option value="{{ $matiere->id }}"
                                            {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                            {{ $matiere->nom }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('matiere_id')
                                    <span class="es-invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>

                            {{-- Enseignant --}}

                            <div class="col-md-4">

                                <label for="enseignant_id" class="es-form-label">
                                    <i class="bi bi-person-badge"></i>
                                    Enseignant
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="enseignant_id" id="enseignant_id"
                                    class="es-form-control @error('enseignant_id') is-invalid @enderror" required>

                                    <option value="">Choisir un enseignant</option>

                                    @foreach ($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}"
                                            {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                            {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('enseignant_id')
                                    <span class="es-invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>

                            {{-- Salle --}}

                            <div class="col-md-4">

                                <label for="salle_id" class="es-form-label">
                                    <i class="bi bi-door-open"></i>
                                    Salle
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="salle_id" id="salle_id"
                                    class="es-form-control @error('salle_id') is-invalid @enderror" required>

                                    <option value="">Choisir une salle</option>

                                    @foreach ($salles as $salle)
                                        <option value="{{ $salle->id }}"
                                            {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                                            {{ $salle->nom }} ({{ $salle->code }})
                                        </option>
                                    @endforeach

                                </select>

                                @error('salle_id')
                                    <span class="es-invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>

                            {{-- Jour --}}

                            <div class="col-md-4">

                                <label for="jour" class="es-form-label">
                                    <i class="bi bi-calendar-day"></i>
                                    Jour
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="jour" id="jour"
                                    class="es-form-control @error('jour') is-invalid @enderror" required>

                                    <option value="">Choisir un jour</option>

                                    @foreach ($jours as $jour)
                                        <option value="{{ $jour }}" {{ old('jour') == $jour ? 'selected' : '' }}>
                                            {{ $jour }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('jour')
                                    <span class="es-invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>

                            {{-- Heure de début --}}

                            <div class="col-md-4">

                                <label for="heure_debut" class="es-form-label">
                                    <i class="bi bi-clock"></i>
                                    Heure de début
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="time" name="heure_debut" id="heure_debut"
                                    class="es-form-control @error('heure_debut') is-invalid @enderror"
                                    value="{{ old('heure_debut') }}" required>

                                @error('heure_debut')
                                    <span class="es-invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>

                            {{-- Heure de fin --}}

                            <div class="col-md-4">

                                <label for="heure_fin" class="es-form-label">
                                    <i class="bi bi-clock-history"></i>
                                    Heure de fin
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="time" name="heure_fin" id="heure_fin"
                                    class="es-form-control @error('heure_fin') is-invalid @enderror"
                                    value="{{ old('heure_fin') }}" required>

                                @error('heure_fin')
                                    <span class="es-invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>

                        {{-- Information sur les conflits --}}

                        <div class="es-form-info">

                            <i class="bi bi-info-circle-fill"></i>

                            <div>
                                Les conflits horaires sont vérifiés lors de l'enregistrement.
                                Vérifiez que l'enseignant et la salle sont disponibles aux horaires sélectionnés.
                            </div>

                        </div>

                        {{-- Bouton d'ajout --}}

                        <div class="es-form-footer">

                            <button type="submit" class="es-btn-add">
                                <i class="bi bi-plus-circle me-1"></i>
                                Ajouter le créneau
                            </button>

                        </div>

                    </form>

                </div>

            </div>
        @endif

    </div>

@endsection
