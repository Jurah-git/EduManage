@extends('layouts.app')

@section('content')
    @php
        $nombreBulletins = count($bulletins);
        $layoutBulletins = 'nb' . min($nombreBulletins, 4);

        // Identifiants des périodes sélectionnées
        $periodesIds = collect($bulletins)
            ->pluck('periode.id')
            ->filter()
            ->map(fn($id) => (int) $id)
            ->unique()
            ->sort()
            ->values()
            ->implode(',');

        // Vérifier si l'image existe déjà dans la base de données
        $imageEnregistree = \App\Models\Bulletin::where('eleve_id', $eleve->id)
            ->where('periodes_ids', $periodesIds)
            ->whereNotNull('image_base64')
            ->where('image_base64', '!=', '')
            ->exists();
    @endphp

    <div class="affichage-bulletin-page">

        <style>
            /* =========================================================
                                                                                               AFFICHAGE BULLETIN - ULTRA PRO
                                                                                            ========================================================= */

            .affichage-bulletin-page {
                --ab-bg: #f1f5fb;
                --ab-card: #ffffff;
                --ab-soft: #f6f8fc;
                --ab-text: #1d2b42;
                --ab-muted: #6c7c92;
                --ab-border: #dfe7f1;
                --ab-primary: #2563eb;
                --ab-primary-dark: #173f91;
                --ab-primary-soft: #eaf1ff;
                --ab-success: #15803d;
                --ab-success-soft: #e8f8ef;
                --ab-danger: #dc2626;
                --ab-danger-soft: #fff0f0;
                --ab-warning: #d97706;
                --ab-warning-soft: #fff6e6;
                --ab-shadow: 0 10px 35px rgba(15, 35, 75, .08);

                background: var(--ab-bg);
                color: var(--ab-text);
                min-height: 100vh;
                padding: 26px;
                border-radius: 20px;
                font-family: inherit;
                transition: background .25s, color .25s;
            }

            .affichage-bulletin-page *,
            .affichage-bulletin-page *::before,
            .affichage-bulletin-page *::after {
                box-sizing: border-box;
            }

            /* =========================================================
                                                                                               THEMES
                                                                                            ========================================================= */

            html[data-app-theme="dark"] .affichage-bulletin-page {
                --ab-bg: #101827;
                --ab-card: #1b2638;
                --ab-soft: #202f45;
                --ab-text: #e7edf7;
                --ab-muted: #9aabc2;
                --ab-border: #34445b;
                --ab-primary: #75a7ff;
                --ab-primary-dark: #244f98;
                --ab-primary-soft: #233a5b;
                --ab-success: #4ade80;
                --ab-success-soft: #183c2c;
                --ab-danger: #f87171;
                --ab-danger-soft: #48252b;
                --ab-warning: #fbbf24;
                --ab-warning-soft: #453620;
                --ab-shadow: 0 12px 35px rgba(0, 0, 0, .22);
            }

            html[data-app-theme="ultra-pro"] .affichage-bulletin-page {
                --ab-bg: #0b1220;
                --ab-card: #151f32;
                --ab-soft: #1b2940;
                --ab-text: #e6edf8;
                --ab-muted: #91a4bf;
                --ab-border: #2c3c55;
                --ab-primary: #60a5fa;
                --ab-primary-dark: #173f91;
                --ab-primary-soft: #1b3151;
                --ab-success: #34d399;
                --ab-success-soft: #153b32;
                --ab-danger: #fb7185;
                --ab-danger-soft: #472532;
                --ab-warning: #fbbf24;
                --ab-warning-soft: #443620;
                --ab-shadow: 0 15px 45px rgba(0, 0, 0, .32);
            }

            html[data-app-theme="emerald"] .affichage-bulletin-page {
                --ab-bg: #eaf4ef;
                --ab-card: #ffffff;
                --ab-soft: #f0f8f4;
                --ab-text: #173a30;
                --ab-muted: #668277;
                --ab-border: #d3e7db;
                --ab-primary: #059669;
                --ab-primary-dark: #065f46;
                --ab-primary-soft: #e0f5eb;
                --ab-success: #047857;
                --ab-success-soft: #ddf5e9;
                --ab-danger: #dc2626;
                --ab-danger-soft: #fff0f0;
                --ab-warning: #b7791c;
                --ab-warning-soft: #fff4dc;
                --ab-shadow: 0 10px 35px rgba(16, 70, 48, .08);
            }

            html[data-app-theme="warm"] .affichage-bulletin-page {
                --ab-bg: #f6f0e7;
                --ab-card: #fffdf9;
                --ab-soft: #faf4eb;
                --ab-text: #49372a;
                --ab-muted: #927c64;
                --ab-border: #eadccc;
                --ab-primary: #b77932;
                --ab-primary-dark: #78451e;
                --ab-primary-soft: #f6ead9;
                --ab-success: #43815b;
                --ab-success-soft: #e9f3e8;
                --ab-danger: #c64848;
                --ab-danger-soft: #fbeaea;
                --ab-warning: #c27a20;
                --ab-warning-soft: #fff2dc;
                --ab-shadow: 0 10px 35px rgba(86, 60, 30, .08);
            }

            /* =========================================================
                                                                                               TOP ACTION BAR
                                                                                            ========================================================= */

            .ab-toolbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 16px;
                margin-bottom: 24px;
            }

            .ab-toolbar-left {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .ab-toolbar-icon {
                width: 52px;
                height: 52px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--ab-primary-soft);
                color: var(--ab-primary);
                font-size: 24px;
                flex-shrink: 0;
            }

            .ab-toolbar-title {
                margin: 0;
                font-weight: 800;
                font-size: 23px;
                color: var(--ab-text);
                letter-spacing: -.4px;
            }

            .ab-toolbar-subtitle {
                color: var(--ab-muted);
                margin: 4px 0 0;
                font-size: 13px;
            }

            .ab-toolbar-actions {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }

            .ab-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                border: none;
                border-radius: 11px;
                padding: 11px 16px;
                font-weight: 700;
                font-size: 13px;
                cursor: pointer;
                transition: .2s ease;
                text-decoration: none;
            }

            .ab-btn-save {
                color: #fff !important;
                background: linear-gradient(135deg, #f59e0b, #d97706);
                box-shadow: 0 4px 12px rgba(217, 119, 6, .2);
            }

            .ab-btn-save:hover {
                transform: translateY(-2px);
                filter: brightness(1.05);
                color: white;
            }

            .ab-btn-print {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 11px 18px;
                border-radius: 12px;
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                color: #fff !important;
                border: 1px solid #1d4ed8;
                font-weight: 700;
                font-size: 13px;
                box-shadow: 0 4px 12px rgba(37, 99, 235, .20);
                transition: all .25s ease;
            }

            .ab-btn-print:hover {
                background: linear-gradient(135deg, #1d4ed8, #1e40af);
                color: #fff !important;
                transform: translateY(-2px);
                box-shadow: 0 7px 16px rgba(37, 99, 235, .25);
            }

            .ab-btn-print:active {
                transform: translateY(0);
            }

            .ab-btn-print:disabled {
                opacity: .6;
                cursor: not-allowed;
                transform: none;
            }

            .ab-btn-print:hover {
                background: var(--ab-soft);
            }

            /* =========================================================
                                                                                               SUMMARY TOP CARDS
                                                                                            ========================================================= */

            .ab-summary-top {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 15px;
                margin-bottom: 25px;
            }

            .ab-summary-stat {
                background: var(--ab-card);
                border: 1px solid var(--ab-border);
                border-radius: 15px;
                padding: 17px 19px;
                box-shadow: var(--ab-shadow);
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .ab-stat-icon {
                width: 43px;
                height: 43px;
                border-radius: 13px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 19px;
                flex-shrink: 0;
            }

            .ab-stat-icon.blue {
                background: var(--ab-primary-soft);
                color: var(--ab-primary);
            }

            .ab-stat-icon.green {
                background: var(--ab-success-soft);
                color: var(--ab-success);
            }

            .ab-stat-icon.orange {
                background: var(--ab-warning-soft);
                color: var(--ab-warning);
            }

            .ab-stat-label {
                font-size: 12px;
                color: var(--ab-muted);
                font-weight: 600;
                margin-bottom: 4px;
            }

            .ab-stat-value {
                font-size: 21px;
                color: var(--ab-text);
                font-weight: 800;
                line-height: 1.2;
            }

            /* =========================================================
                                                                                               BULLETIN GRID
                                                                                            ========================================================= */

            .container-bulletins {
                display: grid;
                gap: 22px;
                width: 100%;
                align-items: start;
                margin: auto;
            }

            .container-bulletins.nb1 {
                grid-template-columns: minmax(0, 920px);
                justify-content: center;
            }

            .container-bulletins.nb2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .container-bulletins.nb3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .container-bulletins.nb4 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            /* =========================================================
                                                                                               BULLETIN CARD
                                                                                            ========================================================= */

            .ab-bulletin {
                background: var(--ab-card);
                border: 1px solid var(--ab-border);
                border-radius: 19px;
                overflow: hidden;
                box-shadow: var(--ab-shadow);
                display: flex;
                flex-direction: column;
                min-width: 0;
                transition: transform .2s, box-shadow .2s;
            }

            .ab-bulletin:hover {
                transform: translateY(-2px);
            }

            /* =========================================================
                                                                                               SCHOOL HEADER
                                                                                            ========================================================= */

            .ab-header-top {
                background: linear-gradient(135deg, #112f69, #1d4ed8 65%, #3b82f6);
                color: #fff;
                padding: 20px 18px;
                position: relative;
                overflow: hidden;
            }

            .ab-header-top::after {
                content: "";
                position: absolute;
                width: 180px;
                height: 180px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .06);
                top: -100px;
                right: -35px;
                pointer-events: none;
            }

            html[data-app-theme="dark"] .ab-header-top,
            html[data-app-theme="ultra-pro"] .ab-header-top {
                background: linear-gradient(135deg, #102039, #1c3b68 65%, #2454a2);
            }

            html[data-app-theme="emerald"] .ab-header-top {
                background: linear-gradient(135deg, #064e3b, #047857 65%, #10b981);
            }

            html[data-app-theme="warm"] .ab-header-top {
                background: linear-gradient(135deg, #6b3f1d, #a16207 65%, #d97706);
            }

            .ab-entete {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 12px;
                position: relative;
                z-index: 1;
            }

            .ab-republique,
            .ab-annee {
                font-size: 11px;
                line-height: 1.65;
                opacity: .95;
                min-width: 95px;
            }

            .ab-annee {
                text-align: right;
            }

            .ab-ecole {
                text-align: center;
                flex: 1;
                min-width: 0;
            }

            .ab-ecole h2 {
                margin: 0;
                font-size: 21px;
                font-weight: 900;
                letter-spacing: .8px;
                line-height: 1.3;
            }

            .ab-ecole p {
                margin: 5px 0 0;
                font-size: 11px;
                opacity: .88;
            }

            .ab-school-tag {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 9px;
                margin-top: 7px;
                border-radius: 30px;
                border: 1px solid rgba(255, 255, 255, .25);
                background: rgba(255, 255, 255, .10);
                font-size: 9px;
                font-weight: 700;
                letter-spacing: .6px;
            }

            /* =========================================================
                                                                                               TITLE
                                                                                            ========================================================= */

            .ab-titre {
                background: var(--ab-primary-soft);
                padding: 13px;
                text-align: center;
                font-size: 16px;
                font-weight: 900;
                color: var(--ab-primary);
                border-bottom: 1px solid var(--ab-border);
                letter-spacing: .5px;
            }

            .ab-titre small {
                display: block;
                font-size: 10px;
                margin-top: 3px;
                opacity: .75;
                font-weight: 600;
            }

            /* =========================================================
                                                                                               STUDENT INFORMATION
                                                                                            ========================================================= */

            .ab-infos {
                padding: 17px;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 11px;
            }

            .ab-bloc-info {
                background: var(--ab-soft);
                padding: 12px;
                border-radius: 11px;
                border: 1px solid var(--ab-border);
                border-left: 4px solid var(--ab-primary);
                font-size: 12px;
                min-width: 0;
            }

            .ab-info-label {
                display: block;
                color: var(--ab-muted);
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .55px;
                margin-bottom: 5px;
            }

            .ab-info-value {
                color: var(--ab-text);
                font-weight: 800;
                overflow-wrap: anywhere;
            }

            /* =========================================================
                                                                                               TABLE
                                                                                            ========================================================= */

            .ab-zone-table {
                padding: 0 17px 17px;
                overflow-x: auto;
            }

            .ab-table-note {
                width: 100%;
                margin: 0;
                border-collapse: separate;
                border-spacing: 0;
                border: 1px solid var(--ab-border);
                border-radius: 10px;
                overflow: hidden;
                font-size: 11px;
                color: var(--ab-text);
                background: var(--ab-card);
            }

            .ab-table-note th {
                background: #163b82;
                color: #fff;
                text-align: center;
                font-size: 10px;
                vertical-align: middle;
                padding: 11px 8px;
                border: none;
                white-space: nowrap;
                font-weight: 800;
            }

            html[data-app-theme="dark"] .ab-table-note th,
            html[data-app-theme="ultra-pro"] .ab-table-note th {
                background: #253f63;
            }

            html[data-app-theme="emerald"] .ab-table-note th {
                background: #086047;
            }

            html[data-app-theme="warm"] .ab-table-note th {
                background: #80501f;
            }

            .ab-table-note td {
                text-align: center;
                vertical-align: middle;
                padding: 10px 7px;
                border-color: var(--ab-border);
                background: var(--ab-card);
                color: var(--ab-text);
            }

            .ab-table-note tbody tr:nth-child(even) td {
                background: var(--ab-soft);
            }

            .ab-table-note tbody tr:hover td {
                background: var(--ab-primary-soft);
            }

            .ab-matiere {
                text-align: left !important;
                font-weight: 700;
            }

            .ab-note-value {
                font-weight: 800;
            }

            .ab-note-moyenne {
                display: inline-block;
                background: var(--ab-primary-soft);
                color: var(--ab-primary);
                padding: 4px 8px;
                border-radius: 7px;
                font-weight: 900;
            }

            .ab-appreciation {
                font-weight: 800;
                font-size: 10px;
            }

            /* =========================================================
                                                                                               RESULT SUMMARY
                                                                                            ========================================================= */

            .ab-resume {
                padding: 0 17px 17px;
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 10px;
            }

            .ab-card-resume {
                background: var(--ab-soft);
                border: 1px solid var(--ab-border);
                border-radius: 11px;
                padding: 13px 8px;
                text-align: center;
                font-size: 10px;
                font-weight: 800;
                color: var(--ab-muted);
                min-width: 0;
            }

            .ab-card-resume .resume-label {
                display: block;
                font-size: 9px;
                letter-spacing: .5px;
                margin-bottom: 7px;
            }

            .ab-card-resume .resume-value {
                font-size: 16px;
                font-weight: 900;
                color: var(--ab-text);
            }

            .ab-card-resume.average {
                background: var(--ab-primary-soft);
                border-color: var(--ab-primary);
            }

            .ab-card-resume.average .resume-value {
                color: var(--ab-primary);
            }

            .ab-decision {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                border-radius: 30px;
                padding: 6px 10px;
                font-size: 10px;
                font-weight: 900;
            }

            .ab-decision.admis {
                color: var(--ab-success);
                background: var(--ab-success-soft);
            }

            .ab-decision.ajourne {
                color: var(--ab-danger);
                background: var(--ab-danger-soft);
            }

            /* =========================================================
                                                                                               SIGNATURE
                                                                                            ========================================================= */

            .ab-footer-sign {
                padding: 20px 17px;
                margin-top: auto;
                display: flex;
                justify-content: space-between;
                gap: 20px;
                border-top: 1px dashed var(--ab-border);
                color: var(--ab-muted);
                font-size: 10px;
            }

            .ab-sign {
                text-align: center;
                flex: 1;
                font-weight: 700;
            }

            .ab-sign-line {
                margin: 28px auto 0;
                width: 80%;
                border-bottom: 1px solid var(--ab-muted);
            }

            .ab-footer-note {
                text-align: center;
                padding: 10px 15px 15px;
                font-size: 9px;
                color: var(--ab-muted);
            }

            /* =========================================================
                                                                                               RESPONSIVE
                                                                                            ========================================================= */

            @media(max-width: 1500px) {
                .container-bulletins.nb3 {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media(max-width: 1200px) {

                .container-bulletins.nb2,
                .container-bulletins.nb3,
                .container-bulletins.nb4 {
                    grid-template-columns: 1fr;
                }

                .container-bulletins.nb1 {
                    grid-template-columns: minmax(0, 1fr);
                }
            }

            @media(max-width: 650px) {
                .affichage-bulletin-page {
                    padding: 12px;
                    border-radius: 12px;
                }

                .ab-toolbar {
                    align-items: flex-start;
                }

                .ab-toolbar-title {
                    font-size: 19px;
                }

                .ab-toolbar-actions {
                    width: 100%;
                }

                .ab-toolbar-actions .ab-btn {
                    flex: 1;
                }

                .ab-summary-top {
                    grid-template-columns: 1fr;
                    gap: 9px;
                }

                .ab-summary-stat {
                    padding: 12px;
                }

                .ab-entete {
                    gap: 6px;
                }

                .ab-republique,
                .ab-annee {
                    font-size: 9px;
                    min-width: 65px;
                }

                .ab-ecole h2 {
                    font-size: 16px;
                }

                .ab-ecole p {
                    font-size: 10px;
                }

                .ab-infos {
                    gap: 8px;
                    padding: 12px;
                }

                .ab-bloc-info {
                    padding: 9px;
                    font-size: 11px;
                }

                .ab-zone-table {
                    padding: 0 10px 12px;
                }

                .ab-table-note {
                    font-size: 10px;
                }

                .ab-table-note th,
                .ab-table-note td {
                    padding: 8px 5px;
                }

                .ab-resume {
                    padding: 0 10px 12px;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .ab-footer-sign {
                    padding: 15px 10px;
                }
            }

            /* =========================================================
                                                                                               PRINT
                                                                                            ========================================================= */

            @media print {
                .affichage-bulletin-page {
                    background: white !important;
                    color: #111827 !important;
                    padding: 0 !important;
                    border-radius: 0 !important;
                }

                .ab-toolbar,
                .ab-summary-top {
                    display: none !important;
                }

                .container-bulletins {
                    gap: 10px !important;
                }

                .ab-bulletin {
                    page-break-inside: avoid;
                    break-inside: avoid;
                    box-shadow: none !important;
                    border: 1px solid #d1d5db !important;
                    transform: none !important;
                }

                .ab-header-top {
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }

                .ab-titre,
                .ab-table-note th,
                .ab-card-resume,
                .ab-decision {
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }

                .ab-table-note td {
                    color: #111827 !important;
                }
            }

            /* =====================================================
                                                               BOUTON RETOUR
                                                            ===================================================== */
            .ab-btn-back {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 11px 18px;
                border-radius: 12px;
                background: var(--ab-soft);
                color: var(--ab-text);
                border: 1px solid var(--ab-border);
                text-decoration: none;
                font-weight: 700;
                transition: all 0.25s ease;
            }

            .ab-btn-back:hover {
                transform: translateY(-2px);
                background: var(--ab-primary-soft);
                color: var(--ab-primary);
                border-color: var(--ab-primary);
            }

            /* =====================================================
                                                       BARRE D'ACTIONS
                                                    ===================================================== */

            .ab-toolbar-actions {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                flex-wrap: wrap;
                gap: 10px;
            }

            /* Bouton retour */
            .ab-btn-back {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 11px 18px;
                border-radius: 12px;
                background: var(--ab-soft);
                color: var(--ab-text);
                border: 1px solid var(--ab-border);
                text-decoration: none;
                font-weight: 700;
                transition: all .25s ease;
            }

            .ab-btn-back:hover {
                transform: translateY(-2px);
                background: var(--ab-primary-soft);
                color: var(--ab-primary);
                border-color: var(--ab-primary);
            }

            /* Bouton téléchargement */
            .ab-btn-download {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 11px 18px;
                border-radius: 12px;
                background: #198754;
                color: #fff;
                border: 1px solid #198754;
                font-weight: 700;
                transition: all .25s ease;
            }

            .ab-btn-download:hover,
            .ab-btn-download:focus {
                background: #146c43;
                color: #fff;
                transform: translateY(-2px);
            }

            /* Menu dropdown */
            .ab-download-menu {
                min-width: 200px;
                padding: 8px;
                border-radius: 12px;
                border: 1px solid var(--ab-border);
                background: var(--ab-card);
                box-shadow: var(--ab-shadow);
            }

            .ab-download-menu .dropdown-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 11px 12px;
                border-radius: 8px;
                color: var(--ab-text);
                font-weight: 600;
                transition: all .2s ease;
            }

            .ab-download-menu .dropdown-item:hover {
                background: var(--ab-primary-soft);
                color: var(--ab-primary);
            }

            .ab-download-menu .bi-filetype-png {
                color: #198754;
                font-size: 1.15rem;
            }

            .ab-download-menu .bi-filetype-pdf {
                color: #dc3545;
                font-size: 1.15rem;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .ab-toolbar-actions {
                    justify-content: flex-start;
                }

                .ab-toolbar-actions .ab-btn {
                    flex: 1 1 auto;
                }
            }

            /* INSTRUCTION D'ENREGISTREMENT */

            .ab-save-instruction {
                display: flex;
                align-items: center;
                gap: 10px;
                max-width: 340px;
                padding: 10px 13px;
                border: 1px solid #bfdbfe;
                border-left: 4px solid #2563eb;
                border-radius: 10px;
                background: #eff6ff;
                color: #1e40af;
            }

            .ab-save-instruction>i {
                flex-shrink: 0;
                font-size: 21px;
                color: #2563eb;
            }

            .ab-save-instruction div {
                display: flex;
                flex-direction: column;
                gap: 3px;
            }

            .ab-save-instruction strong {
                font-size: 11px;
                font-weight: 800;
            }

            .ab-save-instruction span {
                font-size: 10px;
                line-height: 1.5;
            }

            @media (max-width: 1100px) {
                .ab-save-instruction {
                    max-width: 100%;
                }
            }

            /* =====================================================
                                       POPUP IMAGE NON ENREGISTRÉE
                                    ===================================================== */

            .ab-save-modal {
                position: fixed;
                inset: 0;
                z-index: 99999;
                display: none;
                align-items: center;
                justify-content: center;
                padding: 20px;
                background: rgba(15, 23, 42, .65);
                backdrop-filter: blur(5px);
            }

            .ab-save-modal.show {
                display: flex;
            }

            .ab-save-modal-content {
                width: 100%;
                max-width: 430px;
                padding: 30px;
                border-radius: 20px;
                background: #fff;
                color: #1e293b;
                text-align: center;
                box-shadow: 0 25px 70px rgba(0, 0, 0, .25);
                animation: abModalAppear .25s ease;
            }

            .ab-save-modal-icon {
                width: 70px;
                height: 70px;
                margin: 0 auto 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: #fff4df;
                color: #d97706;
                font-size: 32px;
            }

            .ab-save-modal-content h3 {
                font-size: 20px;
                font-weight: 800;
                margin-bottom: 12px;
            }

            .ab-save-modal-content p {
                color: #64748b;
                font-size: 14px;
                line-height: 1.7;
                margin-bottom: 22px;
            }

            .ab-save-modal-close {
                border: none;
                border-radius: 10px;
                padding: 11px 25px;
                background: #2563eb;
                color: white;
                font-weight: 700;
                cursor: pointer;
            }

            .ab-save-modal-close:hover {
                background: #1d4ed8;
            }

            @keyframes abModalAppear {
                from {
                    opacity: 0;
                    transform: translateY(15px) scale(.96);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            html[data-app-theme="dark"] .ab-save-modal-content,
            html[data-app-theme="ultra-pro"] .ab-save-modal-content {
                background: #1b2638;
                color: #e7edf7;
            }

            html[data-app-theme="dark"] .ab-save-modal-content p,
            html[data-app-theme="ultra-pro"] .ab-save-modal-content p {
                color: #aab8ca;
            }
        </style>

        {{-- =========================================================
                    BARRE DE COMMANDE
        ========================================================== --}}

        <div class="ab-toolbar">

            <div class="ab-toolbar-left">
                <div class="ab-toolbar-icon">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>

                <div>
                    <h2 class="ab-toolbar-title">Bulletins de notes</h2>
                    <p class="ab-toolbar-subtitle">
                        Consultation et sauvegarde des bulletins scolaires
                    </p>
                </div>
            </div>

            {{-- INSTRUCTION D'ENREGISTREMENT --}}
            <div class="ab-save-instruction">
                <i class="bi bi-info-circle-fill"></i>

                <div>
                    <strong>Important : enregistrement obligatoire</strong>
                    <span>
                        Enregistrez d'abord l'image du bulletin avant de procéder
                        à son impression ou à son téléchargement.
                    </span>
                </div>
            </div>

            <div class="ab-toolbar-actions">

                <a href="{{ route('bulletin.generer') }}" class="ab-btn ab-btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Retour à la liste
                </a>

                <button type="button" class="ab-btn ab-btn-save" onclick="saveBulletin()">
                    <i class="bi bi-cloud-arrow-up"></i>
                    Enregistrer image
                </button>

                <button type="button" class="ab-btn ab-btn-print" onclick="imprimerBulletinBase64()">
                    <i class="bi bi-printer"></i>
                    Imprimer
                </button>

                {{-- TÉLÉCHARGER --}}
                <div class="dropdown ab-download-dropdown">

                    <button type="button" class="ab-btn ab-btn-download dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <i class="bi bi-download"></i>
                        Télécharger

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end ab-download-menu">

                        <li>
                            <a class="dropdown-item" onclick="return verifierImageEnregistree(event)"
                                href="{{ url('/bulletin/download-direct-png') }}?eleve_id={{ $eleve->id }}&periodes={{ implode(',', collect($bulletins)->pluck('periode.id')->toArray()) }}">
                                <i class="bi bi-filetype-png"></i>
                                Télécharger PNG
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" onclick="return verifierImageEnregistree(event)"
                                href="{{ url('/bulletin/download-direct-pdf') }}?eleve_id={{ $eleve->id }}&periodes={{ implode(',', collect($bulletins)->pluck('periode.id')->toArray()) }}">
                                <i class="bi bi-filetype-pdf"></i>
                                Télécharger PDF
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>

        {{-- =========================================================
             STATISTIQUES
        ========================================================== --}}

        <div class="ab-summary-top">

            <div class="ab-summary-stat">
                <div class="ab-stat-icon blue">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                    <div class="ab-stat-label">Bulletins affichés</div>
                    <div class="ab-stat-value">{{ $nombreBulletins }}</div>
                </div>
            </div>

            <div class="ab-summary-stat">
                <div class="ab-stat-icon green">
                    <i class="bi bi-calendar3"></i>
                </div>
                <div>
                    <div class="ab-stat-label">Année scolaire</div>
                    <div class="ab-stat-value">{{ date('Y') }} - {{ date('Y') + 1 }}</div>
                </div>
            </div>

            <div class="ab-summary-stat">
                <div class="ab-stat-icon orange">
                    <i class="bi bi-mortarboard"></i>
                </div>
                <div>
                    <div class="ab-stat-label">Établissement</div>
                    <div class="ab-stat-value" style="font-size:17px;">Lycée EduManage</div>
                </div>
            </div>

        </div>

        {{-- =========================================================
             CONTENEUR DES BULLETINS
        ========================================================== --}}

        <div id="containerBulletins" class="container-bulletins {{ $layoutBulletins }}">

            @foreach ($bulletins as $b)
                @php
                    $total = 0;
                    $coef = 0;
                @endphp

                <div class="ab-bulletin">

                    {{-- En-tête école --}}
                    <div class="ab-header-top">

                        <div class="ab-entete">

                            <div class="ab-republique">
                                <b>République de Madagascar</b>
                                <br>
                                Ministère de l'Éducation
                            </div>

                            <div class="ab-ecole">
                                <h2>LYCÉE EDUMANAGE</h2>
                                <p>Antananarivo</p>

                                <span class="ab-school-tag">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    Établissement scolaire
                                </span>
                            </div>

                            <div class="ab-annee">
                                <b>Année scolaire</b>
                                <br>
                                {{ date('Y') }} - {{ date('Y') + 1 }}
                            </div>

                        </div>

                    </div>

                    {{-- Titre bulletin --}}
                    <div class="ab-titre">
                        BULLETIN DE NOTES
                        <small>{{ $b['periode']->nom }}</small>
                    </div>

                    {{-- Informations élève --}}
                    <div class="ab-infos">

                        <div class="ab-bloc-info">
                            <span class="ab-info-label">
                                <i class="bi bi-person"></i> Nom et prénom
                            </span>
                            <span class="ab-info-value">
                                {{ $eleve->nom }} {{ $eleve->prenom }}
                            </span>
                        </div>

                        <div class="ab-bloc-info">
                            <span class="ab-info-label">
                                <i class="bi bi-people"></i> Classe
                            </span>
                            <span class="ab-info-value">
                                {{ $eleve->classe->nom ?? 'Non affecté' }}
                            </span>
                        </div>

                        <div class="ab-bloc-info">
                            <span class="ab-info-label">
                                <i class="bi bi-card-text"></i> Matricule
                            </span>
                            <span class="ab-info-value">
                                {{ $eleve->matricule ?? $eleve->id }}
                            </span>
                        </div>

                        <div class="ab-bloc-info">
                            <span class="ab-info-label">
                                <i class="bi bi-calendar-event"></i> Date d'édition
                            </span>
                            <span class="ab-info-value">
                                {{ date('d/m/Y') }}
                            </span>
                        </div>

                    </div>

                    {{-- Tableau des notes --}}
                    <div class="ab-zone-table">

                        <table class="table table-bordered ab-table-note">

                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Note J</th>
                                    <th>Composition</th>
                                    <th>Coef.</th>
                                    <th>Moy.</th>
                                    <th>Appréciation</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($b['notes']->groupBy('matiere_id') as $grp)
                                    @php
                                        $j = $grp->where('type', 'journalier')->first();
                                        $comp = $grp->where('type', 'composition')->first();

                                        $noteJ = $j ? $j->valeur : '-';
                                        $noteC = $comp ? $comp->valeur : '-';

                                        $valJ = $j ? $j->valeur : 0;
                                        $valC = $comp ? $comp->valeur : 0;

                                        $coefM = $j ? $j->coef : ($comp ? $comp->coef : 1);

                                        $moyBrute = $valJ + $valC > 0 ? ($valJ + $valC) / 2 : 0;
                                        $noteReelle = $coefM > 0 ? $moyBrute / $coefM : 0;

                                        $total += $moyBrute;
                                        $coef += $coefM;

                                        if ($noteReelle < 5) {
                                            $app = 'Très insuffisant';
                                            $color = '#991b1b';
                                        } elseif ($noteReelle < 10) {
                                            $app = 'Insuffisant';
                                            $color = '#dc2626';
                                        } elseif ($noteReelle < 12) {
                                            $app = 'Passable';
                                            $color = '#d97706';
                                        } elseif ($noteReelle < 14) {
                                            $app = 'Assez bien';
                                            $color = '#ca8a04';
                                        } elseif ($noteReelle < 17) {
                                            $app = 'Bien';
                                            $color = '#15803d';
                                        } else {
                                            $app = 'Très bien';
                                            $color = '#2563eb';
                                        }
                                    @endphp

                                    <tr>

                                        <td class="ab-matiere">
                                            {{ optional($j ?? $comp)->matiere->nom ?? 'Matière inconnue' }}
                                        </td>

                                        <td class="ab-note-value">
                                            {{ $noteJ }}
                                        </td>

                                        <td class="ab-note-value">
                                            {{ $noteC }}
                                        </td>

                                        <td>
                                            {{ $coefM }}
                                        </td>

                                        <td>
                                            <span class="ab-note-moyenne">
                                                {{ number_format($noteReelle, 2) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="ab-appreciation" style="color:{{ $color }}">
                                                {{ $app }}
                                            </span>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                    {{-- Calcul résumé --}}
                    @php
                        $moyenne = $coef > 0 ? $total / $coef : 0;
                        $admis = $moyenne >= 10;
                    @endphp

                    {{-- Résultats --}}
                    <div class="ab-resume">

                        <div class="ab-card-resume">
                            <span class="resume-label">TOTAL POINTS</span>
                            <span class="resume-value">{{ number_format($total, 2) }}</span>
                        </div>

                        <div class="ab-card-resume">
                            <span class="resume-label">COEFFICIENTS</span>
                            <span class="resume-value">{{ $coef }}</span>
                        </div>

                        <div class="ab-card-resume average">
                            <span class="resume-label">MOYENNE GÉNÉRALE</span>
                            <span class="resume-value">{{ number_format($moyenne, 2) }}/20</span>
                        </div>

                        <div class="ab-card-resume">
                            <span class="resume-label">DÉCISION</span>
                            <span>
                                @if ($admis)
                                    <span class="ab-decision admis">
                                        <i class="bi bi-check-circle-fill"></i>
                                        ADMIS
                                    </span>
                                @else
                                    <span class="ab-decision ajourne">
                                        <i class="bi bi-x-circle-fill"></i>
                                        AJOURNÉ
                                    </span>
                                @endif
                            </span>
                        </div>

                    </div>

                    {{-- Signatures --}}
                    <div class="ab-footer-sign">

                        <div class="ab-sign">
                            Professeur principal
                            <div class="ab-sign-line"></div>
                        </div>

                        <div class="ab-sign">
                            Proviseur
                            <div class="ab-sign-line"></div>
                        </div>

                    </div>

                    <div class="ab-footer-note">
                        EduManage — Système de gestion scolaire
                    </div>

                </div>
            @endforeach

        </div>

    </div>

    {{-- POPUP IMAGE NON ENREGISTRÉE --}}
    <div class="ab-save-modal" id="abSaveModal">
        <div class="ab-save-modal-content">

            <div class="ab-save-modal-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <h3>Image non enregistrée !</h3>

            <p>
                L'image de ce bulletin n'est pas encore enregistrée.

                Veuillez d'abord cliquer sur
                <strong>« Enregistrer image »</strong>
                avant de procéder à l'impression ou au téléchargement.
            </p>

            <button type="button" class="ab-save-modal-close" onclick="fermerPopupEnregistrement()">
                <i class="bi bi-check-circle"></i>
                Compris
            </button>

        </div>
    </div>

    {{-- =============================================================
         HTML2CANVAS
    ============================================================== --}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        // =====================================================
        // ÉTAT DE L'ENREGISTREMENT DE L'IMAGE
        // =====================================================

        let imageEnregistree = @json($imageEnregistree);

        function verifierImageEnregistree(event) {
            if (!imageEnregistree) {
                if (event) {
                    event.preventDefault();
                }

                afficherPopupEnregistrement();
                return false;
            }

            return true;
        }

        // =====================================================
        // GESTION DU POPUP
        // =====================================================

        function afficherPopupEnregistrement() {
            const popup = document.getElementById('abSaveModal');

            if (popup) {
                popup.classList.add('show');
            }
        }

        function fermerPopupEnregistrement() {
            const popup = document.getElementById('abSaveModal');

            if (popup) {
                popup.classList.remove('show');
            }
        }

        // Fermer le popup en cliquant sur le fond
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('abSaveModal');

            if (popup && event.target === popup) {
                fermerPopupEnregistrement();
            }
        });

        // Fermer avec la touche Échap
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                fermerPopupEnregistrement();
            }
        });

        // =====================================================
        // ENREGISTRER L'IMAGE DU BULLETIN
        // =====================================================

        async function saveBulletin() {

            const zone = document.getElementById('containerBulletins');

            if (!zone) {
                alert('Zone des bulletins introuvable.');
                return;
            }

            if (typeof html2canvas === 'undefined') {
                alert('La bibliothèque de sauvegarde image n’a pas été chargée.');
                return;
            }

            const bouton = document.querySelector('.ab-btn-save');
            const texteOriginal = bouton ? bouton.innerHTML : '';

            try {

                if (bouton) {
                    bouton.disabled = true;
                    bouton.innerHTML =
                        '<i class="bi bi-hourglass-split"></i> Enregistrement...';
                }

                const canvas = await html2canvas(zone, {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#ffffff',
                    logging: false,
                    scrollX: 0,
                    scrollY: 0
                });

                const image = canvas.toDataURL('image/jpeg', 0.92);

                const response = await fetch("{{ route('bulletin.saveImage') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        eleve_id: "{{ $eleve->id }}",
                        image: image,
                        periodes_ids: "{{ $periodesIds }}"
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Erreur lors de la réponse du serveur.'
                    );
                }

                if (data.ok) {

                    // Autoriser immédiatement l'impression et le téléchargement
                    // sans recharger la page.
                    imageEnregistree = true;

                    // Fermer le popup s'il est ouvert
                    fermerPopupEnregistrement();

                    alert('✅ Bulletin enregistré avec succès !');

                } else {

                    alert(
                        data.message ||
                        'Erreur lors de l’enregistrement du bulletin.'
                    );

                }

            } catch (e) {

                console.error('Erreur sauvegarde bulletin :', e);

                alert(
                    '❌ Une erreur est survenue : ' +
                    (e.message || 'Erreur JavaScript')
                );

            } finally {

                if (bouton) {
                    bouton.disabled = false;
                    bouton.innerHTML = texteOriginal;
                }

            }
        }

        // =====================================================
        // IMPRESSION DU BULLETIN
        // =====================================================

        function imprimerBulletinBase64() {

            // Bloquer l'impression si l'image n'est pas enregistrée
            if (!verifierImageEnregistree()) {
                return;
            }

            const eleveId = "{{ $eleve->id }}";
            const periodes = "{{ $periodesIds }}";

            const url = "{{ url('/bulletin/print-direct') }}" +
                "?eleve_id=" + encodeURIComponent(eleveId) +
                "&periodes=" + encodeURIComponent(periodes);

            window.open(url, '_blank');
        }
    </script>
@endsection
