@extends('layouts.app')

@section('content')
    @php
        $dashboardUser = Auth::user();
        $dashboardName = $dashboardUser->name ?? 'Administrateur';
        $dashboardInitials = collect(explode(' ', trim($dashboardName)))
            ->filter()
            ->take(2)
            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
            ->implode('');
    @endphp

    <style>
        /* =========================================================
       EDUMANAGE DASHBOARD — BASE
    ========================================================= */

        .dashboard-page {
            --dash-bg: #f0f3f8;
            --dash-card: #ffffff;
            --dash-card-soft: #f7f9fc;
            --dash-border: #e3e9f1;
            --dash-text: #24344d;
            --dash-heading: #18283e;
            --dash-muted: #8b99ad;
            --dash-muted-2: #65758d;
            --dash-hover: #f2f6fc;
            --dash-shadow: 0 3px 12px rgba(15, 23, 42, .04);

            background: var(--dash-bg);
            color: var(--dash-text);
            min-height: 100vh;
            padding: 22px;
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 12px;
            transition: background .25s, color .25s;
        }

        .dashboard-page * {
            box-sizing: border-box;
        }

        .dashboard-page h1,
        .dashboard-page h2,
        .dashboard-page h3,
        .dashboard-page h4,
        .dashboard-page p {
            margin-top: 0;
        }

        .dashboard-page h1 {
            color: var(--dash-heading);
            font-size: 23px;
            font-weight: 750;
            margin-bottom: 5px;
        }

        .dashboard-page h2 {
            color: var(--dash-heading);
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 13px;
        }

        .dashboard-page h3 {
            color: var(--dash-heading);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .dashboard-subtitle {
            color: var(--dash-muted);
            font-size: 11px;
            margin-bottom: 18px;
        }

        .dashboard-heading {
            margin-bottom: 16px;
        }

        .dash-panel {
            background: var(--dash-card);
            border: 1px solid var(--dash-border);
            border-radius: 10px;
            box-shadow: var(--dash-shadow);
            padding: 14px;
            height: 100%;
            min-width: 0;
            transition: background .25s, border-color .25s, box-shadow .25s;
        }

        .dash-panel-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 12px;
        }

        .dash-panel-title h3 {
            margin: 0;
        }

        .dash-panel-title .small-action {
            color: var(--dash-muted);
            font-size: 10px;
            text-decoration: none;
        }

        .dash-panel-title .small-action:hover {
            color: #4e8df5;
        }

        /* =========================================================
       GRILLE PRINCIPALE
    ========================================================= */

        .dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(0, 1.08fr) minmax(0, .95fr);
            gap: 12px;
        }

        .dashboard-grid>* {
            min-width: 0;
        }

        /* =========================================================
       PROFIL + MINI STATISTIQUES
    ========================================================= */

        .profile-stats-area {
            display: grid;
            grid-template-columns: minmax(115px, .9fr) minmax(0, 1fr);
            gap: 8px;
            min-height: 150px;
        }

        .profile-card {
            border-radius: 10px;
            background: linear-gradient(145deg, #7551dc 0%, #5940bc 55%, #4834a6 100%);
            color: #fff;
            padding: 12px 8px;
            text-align: center;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }

        .profile-card::before {
            content: "";
            position: absolute;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
            top: -45px;
            right: -45px;
        }

        .profile-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #c5b3ff, #9c84f5);
            border: 2px solid rgba(255, 255, 255, .65);
            color: #fff;
            font-size: 17px;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
            position: relative;
        }

        .profile-name {
            font-size: 11px;
            font-weight: 700;
            line-height: 1.3;
            overflow-wrap: anywhere;
            margin-bottom: 5px;
        }

        .profile-role {
            color: #e5dcff;
            font-size: 9px;
            margin-bottom: 8px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 9px;
            color: #f1ebff;
        }

        .profile-info span {
            background: rgba(255, 255, 255, .12);
            border-radius: 5px;
            padding: 4px;
        }

        .mini-stat-stack {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .mini-stat {
            background: var(--dash-card-soft);
            border: 1px solid var(--dash-border);
            border-radius: 8px;
            padding: 9px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            min-height: 0;
        }

        .mini-stat-icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .mini-stat-label {
            color: var(--dash-muted);
            font-size: 9px;
            margin-bottom: 3px;
        }

        .mini-stat-value {
            font-size: 17px;
            font-weight: 750;
            color: var(--dash-heading);
            line-height: 1;
        }

        .mini-stat-value small {
            font-size: 9px;
            font-weight: 500;
            color: var(--dash-muted);
        }

        /* =========================================================
       COULEURS DES ICÔNES
    ========================================================= */

        .dash-blue {
            background: #e6efff;
            color: #4881df;
        }

        .dash-purple {
            background: #f0e8ff;
            color: #8959dc;
        }

        .dash-green {
            background: #e2f7ed;
            color: #29a879;
        }

        .dash-orange {
            background: #fff0e2;
            color: #e48b3a;
        }

        .dash-cyan {
            background: #e2f7fb;
            color: #32a9c5;
        }

        .dash-red {
            background: #ffe8e8;
            color: #dc6666;
        }

        /* =========================================================
       ASSIDUITÉ — GRAPHIQUE CIRCULAIRE
    ========================================================= */

        .attendance-panel {
            display: flex;
            flex-direction: column;
        }

        .attendance-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .attendance-ring {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            margin: 3px auto 12px;
            background: conic-gradient(#4f7df3 0% 25%,
                    #9b38ed 25% 50%,
                    #ff9d24 50% 75%,
                    #35b978 75% 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .attendance-ring::before {
            content: "";
            position: absolute;
            width: 69px;
            height: 69px;
            border-radius: 50%;
            background: var(--dash-card);
            transition: background .25s;
        }

        .attendance-ring-inner {
            position: relative;
            text-align: center;
            z-index: 1;
        }

        .attendance-ring-inner strong {
            display: block;
            font-size: 17px;
            color: var(--dash-heading);
            font-weight: 800;
        }

        .attendance-ring-inner span {
            display: block;
            font-size: 8px;
            color: var(--dash-muted);
        }

        .attendance-legend {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 7px;
            margin-top: auto;
        }

        .attendance-legend-item {
            border-top: 1px solid var(--dash-border);
            padding-top: 8px;
            font-size: 9px;
            color: var(--dash-muted-2);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .attendance-legend-item strong {
            color: var(--dash-heading);
            font-size: 12px;
            margin-left: auto;
        }

        .legend-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        /* =========================================================
       COURS DU JOUR
    ========================================================= */

        .class-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .class-item {
            display: grid;
            grid-template-columns: 35px minmax(0, 1fr) auto;
            align-items: center;
            gap: 8px;
            padding: 8px;
            background: var(--dash-card-soft);
            border: 1px solid var(--dash-border);
            border-radius: 8px;
        }

        .class-time {
            font-size: 9px;
            color: var(--dash-muted);
            text-align: center;
            line-height: 1.4;
        }

        .class-time strong {
            display: block;
            color: var(--dash-heading);
            font-size: 10px;
        }

        .class-name {
            color: var(--dash-heading);
            font-weight: 700;
            font-size: 10px;
            margin-bottom: 3px;
        }

        .class-meta {
            color: var(--dash-muted);
            font-size: 9px;
        }

        .class-status {
            padding: 4px 6px;
            border-radius: 5px;
            font-size: 8px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-completed {
            background: #e1f6ea;
            color: #258958;
        }

        .status-pending {
            background: #fff0e2;
            color: #c57a28;
        }

        .status-cancelled {
            background: #ffe6e7;
            color: #d0545c;
        }

        /* =========================================================
       EXAM RESULTS
    ========================================================= */

        .exam-table-wrap {
            overflow-x: auto;
        }

        .exam-table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
            font-size: 9px;
        }

        .exam-table th {
            padding: 8px 6px;
            color: var(--dash-muted);
            font-weight: 700;
            border-bottom: 1px solid var(--dash-border);
            text-align: left;
        }

        .exam-table td {
            padding: 8px 6px;
            border-bottom: 1px solid var(--dash-border);
            color: var(--dash-text);
        }

        .exam-table tr:last-child td {
            border-bottom: none;
        }

        .exam-table tbody tr:hover {
            background: var(--dash-hover);
        }

        .exam-code {
            color: #46a789 !important;
            font-weight: 700;
        }

        .grade-pill {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 5px;
            font-size: 8px;
            font-weight: 700;
        }

        .grade-good {
            color: #21966a;
            background: #e2f6ed;
        }

        .grade-average {
            color: #d08a32;
            background: #fff1de;
        }

        .grade-low {
            color: #d45b68;
            background: #ffe8ea;
        }

        /* =========================================================
       CALENDRIER
    ========================================================= */

        .calendar-panel {
            display: flex;
            flex-direction: column;
        }

        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .calendar-month {
            color: var(--dash-heading);
            font-size: 11px;
            font-weight: 700;
        }

        .calendar-nav {
            display: flex;
            gap: 4px;
        }

        .calendar-nav button {
            width: 23px;
            height: 23px;
            border: 1px solid var(--dash-border);
            background: var(--dash-card-soft);
            color: var(--dash-text);
            border-radius: 6px;
            cursor: pointer;
            font-size: 10px;
        }

        .calendar-nav button:hover {
            background: var(--dash-hover);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px;
            text-align: center;
        }

        .calendar-day-name {
            color: var(--dash-muted);
            font-size: 8px;
            padding: 5px 0;
            font-weight: 700;
        }

        .calendar-day {
            min-height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            font-size: 9px;
            color: var(--dash-text);
        }

        .calendar-day.empty {
            visibility: hidden;
        }

        .calendar-day.today {
            background: #2eae95;
            color: #fff;
            font-weight: 800;
        }

        .calendar-day.has-event:not(.today) {
            position: relative;
        }

        .calendar-day.has-event:not(.today)::after {
            content: "";
            position: absolute;
            bottom: 2px;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #4c8af4;
        }

        .calendar-day:hover:not(.empty) {
            background: var(--dash-hover);
        }

        .calendar-day.today:hover {
            background: #239a83;
        }

        .calendar-note {
            color: var(--dash-muted);
            font-size: 9px;
            margin-top: 9px;
        }

        /* =========================================================
       LEAVE STATUS
    ========================================================= */

        .leave-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .leave-item {
            padding: 9px;
            border: 1px solid var(--dash-border);
            background: var(--dash-card-soft);
            border-radius: 8px;
        }

        .leave-item-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 5px;
            margin-bottom: 5px;
        }

        .leave-name {
            font-size: 10px;
            color: var(--dash-heading);
            font-weight: 700;
        }

        .leave-date {
            color: var(--dash-muted);
            font-size: 9px;
        }

        .leave-type {
            color: var(--dash-muted-2);
            font-size: 9px;
        }

        .leave-badge {
            border-radius: 5px;
            padding: 3px 6px;
            font-size: 8px;
            font-weight: 700;
        }

        .leave-approved {
            color: #25936a;
            background: #e2f6ed;
        }

        .leave-pending {
            color: #c27a2e;
            background: #fff1de;
        }

        /* =========================================================
       NOTICE BOARD
    ========================================================= */

        .notice-list {
            display: flex;
            flex-direction: column;
            gap: 0;
            max-height: 305px;
            overflow-y: auto;
        }

        .notice-item {
            display: flex;
            gap: 9px;
            padding: 10px 0;
            border-bottom: 1px solid var(--dash-border);
        }

        .notice-item:last-child {
            border-bottom: none;
        }

        .notice-avatar {
            width: 31px;
            height: 31px;
            border-radius: 50%;
            background: #e9edff;
            color: #6477cf;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .notice-content {
            min-width: 0;
        }

        .notice-name {
            color: var(--dash-heading);
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .notice-text {
            color: var(--dash-muted-2);
            font-size: 9px;
            line-height: 1.5;
            margin-bottom: 4px;
        }

        .notice-date {
            color: var(--dash-muted);
            font-size: 8px;
        }

        /* =========================================================
       UPCOMING EVENTS
    ========================================================= */

        .event-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .event-item {
            display: flex;
            gap: 9px;
            padding: 9px;
            border: 1px solid var(--dash-border);
            border-radius: 8px;
            background: var(--dash-card-soft);
        }

        .event-date-box {
            width: 36px;
            min-width: 36px;
            height: 38px;
            border-radius: 8px;
            background: #eaf0ff;
            color: #4775d5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .event-date-box strong {
            font-size: 13px;
            line-height: 1;
        }

        .event-date-box span {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .event-content {
            min-width: 0;
            flex: 1;
        }

        .event-title {
            font-size: 10px;
            font-weight: 700;
            color: var(--dash-heading);
            margin-bottom: 3px;
        }

        .event-meta {
            color: var(--dash-muted);
            font-size: 9px;
            margin-bottom: 3px;
        }

        .event-description {
            color: var(--dash-muted-2);
            font-size: 9px;
            line-height: 1.4;
        }

        .event-view {
            color: #4e83df;
            font-size: 9px;
            font-weight: 700;
            text-decoration: none;
            align-self: center;
            white-space: nowrap;
        }

        .event-view:hover {
            text-decoration: underline;
        }

        /* =========================================================
       FOOTER
    ========================================================= */

        .dashboard-footer {
            text-align: center;
            color: var(--dash-muted);
            font-size: 9px;
            padding: 18px 0 4px;
        }

        /* =========================================================
       DARK MODE — ADAPTATION DU THÈME EXISTANT
    ========================================================= */

        html[data-app-theme="dark"] .dashboard-page {
            --dash-bg: #1b2637;
            --dash-card: #253246;
            --dash-card-soft: #202d40;
            --dash-border: #34445c;
            --dash-text: #d5deec;
            --dash-heading: #edf3fc;
            --dash-muted: #91a2bb;
            --dash-muted-2: #b2bfd1;
            --dash-hover: #2d3b50;
            --dash-shadow: 0 3px 14px rgba(0, 0, 0, .12);
        }

        html[data-app-theme="dark"] .dashboard-page .dash-panel,
        html[data-app-theme="dark"] .dashboard-page .stat-card,
        html[data-app-theme="dark"] .dashboard-page .mini-stat,
        html[data-app-theme="dark"] .dashboard-page .class-item,
        html[data-app-theme="dark"] .dashboard-page .leave-item,
        html[data-app-theme="dark"] .dashboard-page .event-item {
            background-color: var(--dash-card);
            border-color: var(--dash-border);
        }

        html[data-app-theme="dark"] .dashboard-page .mini-stat,
        html[data-app-theme="dark"] .dashboard-page .class-item,
        html[data-app-theme="dark"] .dashboard-page .leave-item,
        html[data-app-theme="dark"] .dashboard-page .event-item {
            background-color: var(--dash-card-soft);
        }

        html[data-app-theme="dark"] .dashboard-page .exam-table th,
        html[data-app-theme="dark"] .dashboard-page .exam-table td,
        html[data-app-theme="dark"] .dashboard-page .notice-item {
            border-color: var(--dash-border);
        }

        html[data-app-theme="dark"] .dashboard-page .exam-table tbody tr:hover {
            background: var(--dash-hover);
        }

        html[data-app-theme="dark"] .dashboard-page .attendance-ring::before {
            background: var(--dash-card);
        }

        html[data-app-theme="dark"] .dashboard-page .calendar-nav button {
            background: var(--dash-card-soft);
            color: var(--dash-text);
            border-color: var(--dash-border);
        }

        html[data-app-theme="dark"] .dashboard-page .calendar-day {
            color: var(--dash-text);
        }

        html[data-app-theme="dark"] .dashboard-page .calendar-day.today {
            background: #22a88b;
            color: #fff;
        }

        html[data-app-theme="dark"] .dashboard-page .calendar-day:hover:not(.empty) {
            background: var(--dash-hover);
        }

        html[data-app-theme="dark"] .dashboard-page .calendar-day.today:hover {
            background: #168b72;
        }

        html[data-app-theme="dark"] .dashboard-page .dash-blue {
            background: #293f61;
            color: #8cb9ff;
        }

        html[data-app-theme="dark"] .dashboard-page .dash-purple {
            background: #3d315c;
            color: #c4a2ff;
        }

        html[data-app-theme="dark"] .dashboard-page .dash-green {
            background: #26483e;
            color: #80d6ae;
        }

        html[data-app-theme="dark"] .dashboard-page .dash-orange {
            background: #51402e;
            color: #ffc27e;
        }

        html[data-app-theme="dark"] .dashboard-page .dash-cyan {
            background: #244653;
            color: #7bd8f0;
        }

        html[data-app-theme="dark"] .dashboard-page .dash-red {
            background: #53333d;
            color: #ff9eae;
        }

        html[data-app-theme="dark"] .dashboard-page .status-completed {
            background: #254b3c;
            color: #85d7ac;
        }

        html[data-app-theme="dark"] .dashboard-page .status-pending {
            background: #4d402f;
            color: #ffc37f;
        }

        html[data-app-theme="dark"] .dashboard-page .status-cancelled {
            background: #52343e;
            color: #ff9eac;
        }

        html[data-app-theme="dark"] .dashboard-page .grade-good {
            background: #254b3c;
            color: #85d7ac;
        }

        html[data-app-theme="dark"] .dashboard-page .grade-average {
            background: #4d402f;
            color: #ffc37f;
        }

        html[data-app-theme="dark"] .dashboard-page .grade-low {
            background: #52343e;
            color: #ff9eac;
        }

        html[data-app-theme="dark"] .dashboard-page .leave-approved {
            background: #254b3c;
            color: #85d7ac;
        }

        html[data-app-theme="dark"] .dashboard-page .leave-pending {
            background: #4d402f;
            color: #ffc37f;
        }

        html[data-app-theme="dark"] .dashboard-page .event-date-box {
            background: #293f61;
            color: #8cb9ff;
        }

        html[data-app-theme="dark"] .dashboard-page .notice-avatar {
            background: #3b3456;
            color: #c2a5ff;
        }

        html[data-app-theme="dark"] .dashboard-page .attendance-legend-item strong {
            color: var(--dash-heading);
        }

        /* =========================================================
       RESPONSIVE
    ========================================================= */

        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            }

            .dashboard-grid>.attendance-panel {
                grid-column: auto;
            }
        }

        @media (max-width: 850px) {
            .dashboard-page {
                padding: 14px;
            }

            .dashboard-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .dashboard-grid>* {
                grid-column: auto !important;
            }

            .profile-stats-area {
                min-height: 165px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-page {
                padding: 10px;
            }

            .profile-stats-area {
                grid-template-columns: 115px minmax(0, 1fr);
            }

            .dash-panel {
                padding: 11px;
            }
        }

        @media print {
            .dashboard-page {
                background: #fff !important;
                color: #000 !important;
            }
        }
    </style>

    <div class="dashboard-page">

        {{-- ================= TITRE ================= --}}
        <div class="dashboard-heading">
            <h1>Dashboard</h1>
            <p class="dashboard-subtitle">
                Tableau de bord administratif — vue d'ensemble de votre établissement.
            </p>
        </div>

        {{-- ================= GRILLE PRINCIPALE ================= --}}
        <div class="dashboard-grid">

            {{-- PROFIL + STATISTIQUES --}}
            <div class="dash-panel">

                <div class="profile-stats-area">

                    {{-- Carte profil --}}
                    <div class="profile-card">
                        <div class="profile-avatar">
                            {{ $dashboardInitials ?: 'AD' }}
                        </div>

                        <div class="profile-name">
                            {{ $dashboardName }}
                        </div>

                        <div class="profile-role">
                            {{ ucfirst($dashboardUser->role ?? 'Administrateur') }}
                        </div>

                        <div class="profile-info">
                            <span>
                                <i class="bi bi-building me-1"></i>
                                EduManage
                            </span>
                            <span>
                                <i class="bi bi-person-check me-1"></i>
                                Mon profil
                            </span>
                        </div>
                    </div>

                    {{-- Petites statistiques --}}
                    <div class="mini-stat-stack">

                        <div class="mini-stat">
                            <div class="mini-stat-icon dash-purple">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div>
                                <div class="mini-stat-label">Événements</div>
                                <div class="mini-stat-value">10</div>
                            </div>
                        </div>

                        <div class="mini-stat">
                            <div class="mini-stat-icon dash-orange">
                                <i class="bi bi-bell"></i>
                            </div>
                            <div>
                                <div class="mini-stat-label">Notifications</div>
                                <div class="mini-stat-value">15</div>
                            </div>
                        </div>

                        <div class="mini-stat">
                            <div class="mini-stat-icon dash-cyan">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <div>
                                <div class="mini-stat-label">Présence</div>
                                <div class="mini-stat-value">90<small>%</small></div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Effectifs --}}
                <div class="mt-3 pt-3 border-top" style="border-color:var(--dash-border)!important;">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small" style="color:var(--dash-muted);">
                            Effectifs de l'établissement
                        </span>
                        <i class="bi bi-people" style="color:var(--dash-muted);"></i>
                    </div>

                    <div class="row g-2">

                        <div class="col-6">
                            <div class="mini-stat">
                                <div class="mini-stat-icon dash-blue">
                                    <i class="bi bi-mortarboard"></i>
                                </div>
                                <div>
                                    <div class="mini-stat-label">Élèves</div>
                                    <div class="mini-stat-value">
                                        {{ number_format($totalEleves, 0, ',', ' ') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mini-stat">
                                <div class="mini-stat-icon dash-green">
                                    <i class="bi bi-door-open"></i>
                                </div>
                                <div>
                                    <div class="mini-stat-label">Classes</div>
                                    <div class="mini-stat-value">
                                        {{ number_format($totalClasses, 0, ',', ' ') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mini-stat">
                                <div class="mini-stat-icon dash-purple">
                                    <i class="bi bi-person-workspace"></i>
                                </div>
                                <div>
                                    <div class="mini-stat-label">Enseignants</div>
                                    <div class="mini-stat-value">
                                        {{ number_format($totalEnseignants, 0, ',', ' ') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mini-stat">
                                <div class="mini-stat-icon dash-orange">
                                    <i class="bi bi-person-gear"></i>
                                </div>
                                <div>
                                    <div class="mini-stat-label">Comptes</div>
                                    <div class="mini-stat-value">
                                        {{ number_format($totalUsers, 0, ',', ' ') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- ASSIDUITÉ --}}
            <div class="dash-panel attendance-panel">

                <div class="attendance-top">
                    <h3>Attendance</h3>

                    <select class="form-select form-select-sm"
                        style="width:75px;font-size:9px;background:var(--dash-card-soft);color:var(--dash-text);border-color:var(--dash-border);">
                        <option>Weekly</option>
                        <option>Monthly</option>
                    </select>
                </div>

                <div class="attendance-ring">
                    <div class="attendance-ring-inner">
                        <strong>90%</strong>
                        <span>Présence</span>
                    </div>
                </div>

                <div class="attendance-legend">
                    <div class="attendance-legend-item">
                        <span class="legend-dot" style="background:#4f7df3"></span>
                        Présents
                        <strong>200</strong>
                    </div>

                    <div class="attendance-legend-item">
                        <span class="legend-dot" style="background:#9b38ed"></span>
                        Absents
                        <strong>172</strong>
                    </div>

                    <div class="attendance-legend-item">
                        <span class="legend-dot" style="background:#ff9d24"></span>
                        Retards
                        <strong>100</strong>
                    </div>

                    <div class="attendance-legend-item">
                        <span class="legend-dot" style="background:#35b978"></span>
                        Excusés
                        <strong>300</strong>
                    </div>
                </div>

            </div>

            {{-- COURS DU JOUR --}}
            <div class="dash-panel">

                <div class="dash-panel-title">
                    <h3>Today's Class</h3>
                    <a href="#" class="small-action">Voir tout</a>
                </div>

                <div class="class-list">

                    <div class="class-item">
                        <div class="class-time">
                            <strong>08:00</strong>
                            09:00
                        </div>
                        <div>
                            <div class="class-name">Anglais</div>
                            <div class="class-meta">Classe 6e · Salle A-01</div>
                        </div>
                        <span class="class-status status-completed">Terminé</span>
                    </div>

                    <div class="class-item">
                        <div class="class-time">
                            <strong>09:00</strong>
                            10:00
                        </div>
                        <div>
                            <div class="class-name">Physique</div>
                            <div class="class-meta">Classe 5e · Salle B-02</div>
                        </div>
                        <span class="class-status status-pending">En cours</span>
                    </div>

                    <div class="class-item">
                        <div class="class-time">
                            <strong>10:00</strong>
                            11:00
                        </div>
                        <div>
                            <div class="class-name">Mathématiques</div>
                            <div class="class-meta">Classe 4e · Salle A-03</div>
                        </div>
                        <span class="class-status status-pending">À venir</span>
                    </div>

                    <div class="class-item">
                        <div class="class-time">
                            <strong>11:00</strong>
                            12:00
                        </div>
                        <div>
                            <div class="class-name">Chimie</div>
                            <div class="class-meta">Classe 3e · Salle C-01</div>
                        </div>
                        <span class="class-status status-pending">À venir</span>
                    </div>

                </div>
            </div>

            {{-- EXAM RESULTS --}}
            <div class="dash-panel" style="grid-column:span 2;">

                <div class="dash-panel-title">
                    <h3>Exam Results</h3>
                    <a href="#" class="small-action">Tous les résultats</a>
                </div>

                <div class="exam-table-wrap">
                    <table class="exam-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Élève</th>
                                <th>Matière</th>
                                <th>Classe</th>
                                <th>Note</th>
                                <th>Moyenne</th>
                                <th>Résultat</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="exam-code">AC1205</td>
                                <td>Claire Test</td>
                                <td>English</td>
                                <td>A</td>
                                <td>85%</td>
                                <td>14.2</td>
                                <td><span class="grade-pill grade-good">Réussi</span></td>
                            </tr>

                            <tr>
                                <td class="exam-code">AC1206</td>
                                <td>Jean Example</td>
                                <td>Community</td>
                                <td>B</td>
                                <td>80%</td>
                                <td>12.8</td>
                                <td><span class="grade-pill grade-good">Réussi</span></td>
                            </tr>

                            <tr>
                                <td class="exam-code">AC1207</td>
                                <td>Marie Test</td>
                                <td>Anglais</td>
                                <td>A</td>
                                <td>72%</td>
                                <td>11.4</td>
                                <td><span class="grade-pill grade-average">Moyen</span></td>
                            </tr>

                            <tr>
                                <td class="exam-code">AC1208</td>
                                <td>Claude Example</td>
                                <td>Mathématiques</td>
                                <td>B</td>
                                <td>60%</td>
                                <td>9.5</td>
                                <td><span class="grade-pill grade-average">Moyen</span></td>
                            </tr>

                            <tr>
                                <td class="exam-code">AC1209</td>
                                <td>Sarah Test</td>
                                <td>Comptabilité</td>
                                <td>A</td>
                                <td>90%</td>
                                <td>16.2</td>
                                <td><span class="grade-pill grade-good">Réussi</span></td>
                            </tr>

                            <tr>
                                <td class="exam-code">AC1210</td>
                                <td>Paul Example</td>
                                <td>Physique</td>
                                <td>B</td>
                                <td>55%</td>
                                <td>8.4</td>
                                <td><span class="grade-pill grade-low">Échec</span></td>
                            </tr>

                            <tr>
                                <td class="exam-code">AC1211</td>
                                <td>Alex Test</td>
                                <td>Anglais</td>
                                <td>A</td>
                                <td>78%</td>
                                <td>12.5</td>
                                <td><span class="grade-pill grade-good">Réussi</span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-2"
                    style="color:var(--dash-muted);font-size:9px;">
                    <span>Affichage de 7 résultats</span>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm py-0 px-2" disabled
                            style="font-size:9px;border:1px solid var(--dash-border;color:var(--dash-muted);">‹</button>
                        <span>1</span>
                        <button class="btn btn-sm py-0 px-2"
                            style="font-size:9px;border:1px solid var(--dash-border;color:var(--dash-muted);">›</button>
                    </div>
                </div>

            </div>

            {{-- CALENDRIER --}}
            <div class="dash-panel calendar-panel">

                <div class="dash-panel-title">
                    <h3>Calendar</h3>
                </div>

                <div class="calendar-header">
                    <div class="calendar-month" id="dashboard-calendar-month"></div>

                    <div class="calendar-nav">
                        <button type="button" id="dashboard-calendar-prev" aria-label="Mois précédent">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" id="dashboard-calendar-next" aria-label="Mois suivant">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="calendar-grid" id="dashboard-calendar-grid"></div>

                <div class="calendar-note">
                    <i class="bi bi-dot text-primary"></i>
                    Dates importantes et événements
                </div>
            </div>

            {{-- LEAVE STATUS --}}
            <div class="dash-panel">

                <div class="dash-panel-title">
                    <h3>Leave Status</h3>
                    <select class="form-select form-select-sm"
                        style="width:82px;font-size:9px;background:var(--dash-card-soft);color:var(--dash-text);border-color:var(--dash-border);">
                        <option>Today</option>
                        <option>This week</option>
                        <option>This month</option>
                    </select>
                </div>

                <div class="leave-list">

                    <div class="leave-item">
                        <div class="leave-item-top">
                            <span class="leave-name">Emergency Leave</span>
                            <span class="leave-badge leave-pending">En attente</span>
                        </div>
                        <div class="leave-date">14 Nov. 2026</div>
                        <div class="leave-type">Motif : raisons personnelles</div>
                    </div>

                    <div class="leave-item">
                        <div class="leave-item-top">
                            <span class="leave-name">Medical Leave</span>
                            <span class="leave-badge leave-approved">Approuvé</span>
                        </div>
                        <div class="leave-date">12 Nov. 2026</div>
                        <div class="leave-type">Motif : consultation</div>
                    </div>

                    <div class="leave-item">
                        <div class="leave-item-top">
                            <span class="leave-name">New Well</span>
                            <span class="leave-badge leave-pending">En attente</span>
                        </div>
                        <div class="leave-date">10 Nov. 2026</div>
                        <div class="leave-type">Motif : demande de congé</div>
                    </div>

                    <div class="leave-item">
                        <div class="leave-item-top">
                            <span class="leave-name">Medical Leave</span>
                            <span class="leave-badge leave-approved">Approuvé</span>
                        </div>
                        <div class="leave-date">08 Nov. 2026</div>
                        <div class="leave-type">Motif : consultation</div>
                    </div>

                    <div class="leave-item">
                        <div class="leave-item-top">
                            <span class="leave-name">Emergency Leave</span>
                            <span class="leave-badge leave-pending">En attente</span>
                        </div>
                        <div class="leave-date">05 Nov. 2026</div>
                        <div class="leave-type">Motif : raisons personnelles</div>
                    </div>

                </div>
            </div>

            {{-- NOTICE BOARD --}}
            <div class="dash-panel">

                <div class="dash-panel-title">
                    <h3>Notice Board</h3>
                    <a href="#" class="small-action"><i class="bi bi-three-dots"></i></a>
                </div>

                <div class="notice-list">

                    <div class="notice-item">
                        <div class="notice-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="notice-content">
                            <div class="notice-name">Admin</div>
                            <div class="notice-text">
                                La réunion pédagogique se tiendra vendredi.
                                Merci de préparer les documents nécessaires.
                            </div>
                            <div class="notice-date">22 Nov. 2026</div>
                        </div>
                    </div>

                    <div class="notice-item">
                        <div class="notice-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="notice-content">
                            <div class="notice-name">Directeur</div>
                            <div class="notice-text">
                                Les enseignants sont invités à compléter les notes
                                avant la fin de la période.
                            </div>
                            <div class="notice-date">20 Nov. 2026</div>
                        </div>
                    </div>

                    <div class="notice-item">
                        <div class="notice-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="notice-content">
                            <div class="notice-name">Administration</div>
                            <div class="notice-text">
                                Pensez à vérifier les dossiers d'inscription
                                des nouveaux élèves.
                            </div>
                            <div class="notice-date">18 Nov. 2026</div>
                        </div>
                    </div>

                    <div class="notice-item">
                        <div class="notice-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="notice-content">
                            <div class="notice-name">Vie scolaire</div>
                            <div class="notice-text">
                                Les activités sportives auront lieu samedi matin.
                            </div>
                            <div class="notice-date">16 Nov. 2026</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- UPCOMING EVENTS --}}
            <div class="dash-panel">

                <div class="dash-panel-title">
                    <h3>Upcoming Events</h3>
                    <a href="#" class="small-action">Tous</a>
                </div>

                <div class="event-list">

                    <div class="event-item">
                        <div class="event-date-box">
                            <strong>24</strong>
                            <span>Nov</span>
                        </div>
                        <div class="event-content">
                            <div class="event-title">Réunion pédagogique</div>
                            <div class="event-meta">
                                <i class="bi bi-clock me-1"></i>10:00 – 12:00
                            </div>
                            <div class="event-description">
                                Salle de réunion · Personnel enseignant
                            </div>
                        </div>
                        <a href="#" class="event-view">Voir</a>
                    </div>

                    <div class="event-item">
                        <div class="event-date-box">
                            <strong>27</strong>
                            <span>Nov</span>
                        </div>
                        <div class="event-content">
                            <div class="event-title">Évaluation trimestrielle</div>
                            <div class="event-meta">
                                <i class="bi bi-clock me-1"></i>08:00 – 16:00
                            </div>
                            <div class="event-description">
                                Début des évaluations de fin de période
                            </div>
                        </div>
                        <a href="#" class="event-view">Voir</a>
                    </div>

                    <div class="event-item">
                        <div class="event-date-box">
                            <strong>30</strong>
                            <span>Nov</span>
                        </div>
                        <div class="event-content">
                            <div class="event-title">Activité sportive</div>
                            <div class="event-meta">
                                <i class="bi bi-clock me-1"></i>14:00 – 16:00
                            </div>
                            <div class="event-description">
                                Terrain de sport · Toutes les classes
                            </div>
                        </div>
                        <a href="#" class="event-view">Voir</a>
                    </div>

                    <div class="event-item">
                        <div class="event-date-box">
                            <strong>05</strong>
                            <span>Déc</span>
                        </div>
                        <div class="event-content">
                            <div class="event-title">Cérémonie scolaire</div>
                            <div class="event-meta">
                                <i class="bi bi-clock me-1"></i>09:00 – 11:00
                            </div>
                            <div class="event-description">
                                Cour principale · Communauté scolaire
                            </div>
                        </div>
                        <a href="#" class="event-view">Voir</a>
                    </div>

                </div>
            </div>

        </div>

        <div class="dashboard-footer">
            EduManage · Système de gestion scolaire
        </div>

    </div>

    {{-- =========================================================
     CALENDRIER DYNAMIQUE
========================================================= --}}
    <script>
        (function() {
            const grid = document.getElementById('dashboard-calendar-grid');
            const monthLabel = document.getElementById('dashboard-calendar-month');
            const previousButton = document.getElementById('dashboard-calendar-prev');
            const nextButton = document.getElementById('dashboard-calendar-next');

            if (!grid || !monthLabel || !previousButton || !nextButton) return;

            const today = new Date();
            let displayedMonth = new Date(today.getFullYear(), today.getMonth(), 1);

            // Quelques dates d'événements d'exemple
            const eventDates = [5, 12, 18, 24, 27];

            const monthNames = [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ];

            const dayNames = ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di'];

            function renderCalendar() {
                const year = displayedMonth.getFullYear();
                const month = displayedMonth.getMonth();

                monthLabel.textContent = monthNames[month] + ' ' + year;
                grid.innerHTML = '';

                dayNames.forEach(day => {
                    const header = document.createElement('div');
                    header.className = 'calendar-day-name';
                    header.textContent = day;
                    grid.appendChild(header);
                });

                // Premier jour du mois (lundi = 0)
                let firstDay = new Date(year, month, 1).getDay();
                firstDay = (firstDay + 6) % 7;

                const daysInMonth = new Date(year, month + 1, 0).getDate();

                for (let i = 0; i < firstDay; i++) {
                    const empty = document.createElement('div');
                    empty.className = 'calendar-day empty';
                    grid.appendChild(empty);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const cell = document.createElement('div');
                    cell.className = 'calendar-day';
                    cell.textContent = day;

                    const isToday =
                        year === today.getFullYear() &&
                        month === today.getMonth() &&
                        day === today.getDate();

                    if (isToday) {
                        cell.classList.add('today');
                    }

                    if (eventDates.includes(day)) {
                        cell.classList.add('has-event');
                        cell.title = 'Événement prévu';
                    }

                    grid.appendChild(cell);
                }
            }

            previousButton.addEventListener('click', function() {
                displayedMonth.setMonth(displayedMonth.getMonth() - 1);
                renderCalendar();
            });

            nextButton.addEventListener('click', function() {
                displayedMonth.setMonth(displayedMonth.getMonth() + 1);
                renderCalendar();
            });

            renderCalendar();
        })();
    </script>
@endsection
