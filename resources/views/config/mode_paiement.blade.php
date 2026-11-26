@extends('layouts.app')

@section('content')

    @php
        $icones = [
            'especes' => 'bi-cash-stack',
            'virement' => 'bi-bank',
            'cheque' => 'bi-receipt',
        ];

        $actifs = count(array_filter($modes, fn($mode) => $mode['actif'] ?? false));
        $totalModes = count($modes);
    @endphp

    <div class="container-fluid py-4 payment-settings">

        {{-- EN-TÊTE --}}
        <div class="payment-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <div class="payment-eyebrow">
                        <i class="bi bi-sliders2 me-2"></i>
                        CONFIGURATION FINANCIÈRE
                    </div>

                    <h2 class="fw-bold mb-2">Modes de paiement</h2>

                    <p class="mb-0">
                        Configurez les moyens de paiement acceptés par votre établissement.
                    </p>
                </div>

                <div class="payment-counter">
                    <div class="counter-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <div>
                        <div class="counter-number">{{ $actifs }} / {{ $totalModes }}</div>
                        <div class="counter-label">Modes activés</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MESSAGES --}}
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Vérifiez les informations
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULAIRE --}}
        <form action="{{ route('config.mode.paiement.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Moyens de paiement disponibles</h5>
                    <p class="payment-muted small mb-0">
                        Activez ou désactivez les moyens proposés par votre établissement.
                    </p>
                </div>

                <span class="payment-total-badge">
                    <i class="bi bi-grid me-1"></i>
                    {{ $totalModes }} modes configurables
                </span>
            </div>

            <div class="row g-3">

                @foreach ($modes as $key => $mode)
                    <div class="col-12 col-md-6 col-xl-4">

                        <div class="payment-card h-100">

                            {{-- EN-TÊTE DE LA CARTE --}}
                            <div class="d-flex align-items-center gap-3 mb-4">

                                @if ($key === 'mvola')
                                    <div class="payment-brand-logo logo-mvola">
                                        <div>MV<span>ola</span></div>
                                        <small>Mobile Money</small>
                                    </div>
                                @elseif($key === 'orange_money')
                                    <div class="payment-brand-logo logo-orange">
                                        <div class="orange-brand">
                                            <span class="orange-symbol">↗</span>
                                            <span>Orange</span>
                                        </div>
                                        <small>Money</small>
                                    </div>
                                @elseif($key === 'airtel_money')
                                    <div class="payment-brand-logo logo-airtel">
                                        <strong>airtel</strong>
                                        <small>money</small>
                                    </div>
                                @else
                                    <div class="payment-icon">
                                        <i class="bi {{ $icones[$key] ?? 'bi-wallet2' }}"></i>
                                    </div>
                                @endif

                                <div class="flex-grow-1 min-width-0">
                                    <h5 class="payment-name mb-1">
                                        {{ $mode['nom'] }}
                                    </h5>

                                    <p class="payment-description mb-0">
                                        {{ $mode['description'] }}
                                    </p>
                                </div>
                            </div>

                            {{-- STATUT --}}
                            <div class="payment-status mb-3">
                                <span class="status-label">État du mode</span>

                                @if ($mode['actif'] ?? false)
                                    <span class="payment-status-badge active">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Activé
                                    </span>
                                @else
                                    <span class="payment-status-badge inactive">
                                        <i class="bi bi-pause-circle-fill me-1"></i>
                                        Désactivé
                                    </span>
                                @endif
                            </div>

                            {{-- ACTIVATION --}}
                            <div class="payment-toggle mb-4">

                                <input type="hidden" name="modes[{{ $key }}][actif]" value="0">

                                <div class="form-check form-switch">

                                    <input class="form-check-input payment-switch" type="checkbox" role="switch"
                                        id="mode_{{ $key }}" name="modes[{{ $key }}][actif]"
                                        value="1" {{ $mode['actif'] ?? false ? 'checked' : '' }}>

                                    <label class="form-check-label fw-semibold" for="mode_{{ $key }}">
                                        Activer ce mode
                                    </label>

                                </div>
                            </div>

                            {{-- INFORMATIONS --}}
                            <div class="payment-details">
                                <label class="form-label fw-semibold" for="details_{{ $key }}">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Informations complémentaires
                                </label>

                                <input type="text" class="form-control" id="details_{{ $key }}"
                                    name="modes[{{ $key }}][details]"
                                    value="{{ old('modes.' . $key . '.details', $mode['details'] ?? '') }}" maxlength="255"
                                    placeholder="Numéro, compte ou information...">

                                <small class="payment-help">
                                    Exemple : numéro de compte ou référence de paiement.
                                </small>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- ENREGISTREMENT --}}
            <div class="payment-save-area mt-4">

                <div class="d-flex align-items-center gap-3">
                    <div class="save-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <div class="fw-bold">Enregistrer la configuration</div>
                        <small class="payment-muted">
                            Les modifications seront sauvegardées pour votre établissement.
                        </small>
                    </div>
                </div>

                <button type="submit" class="payment-save-button">
                    <i class="bi bi-check-lg me-2"></i>
                    Enregistrer les modifications
                </button>

            </div>

        </form>

    </div>

    {{-- STYLES --}}
    <style>
        /* =====================================================
               BASE
            ===================================================== */

        .payment-settings {
            color: var(--bs-body-color);
            background: transparent;
        }

        .payment-settings,
        .payment-settings * {
            box-sizing: border-box;
        }

        .payment-muted {
            color: var(--bs-secondary-color);
        }

        .payment-settings .min-width-0 {
            min-width: 0;
        }

        /* =====================================================
               HERO
            ===================================================== */

        .payment-hero {
            position: relative;
            overflow: hidden;
            padding: 28px 30px;
            border-radius: 19px;
            color: #fff;
            background: linear-gradient(120deg, #243b53, #2875a7);
            box-shadow: 0 8px 24px rgba(25, 55, 85, .14);
        }

        .payment-hero::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            right: -55px;
            top: -105px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07);
        }

        .payment-hero>div {
            position: relative;
            z-index: 1;
        }

        .payment-eyebrow {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            opacity: .8;
            margin-bottom: 9px;
        }

        .payment-hero h2 {
            font-size: 26px;
            letter-spacing: -.5px;
        }

        .payment-hero p {
            color: rgba(255, 255, 255, .78);
            font-size: 14px;
        }

        /* =====================================================
               COMPTEUR
            ===================================================== */

        .payment-counter {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 18px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 14px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(8px);
        }

        .counter-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, .17);
            font-size: 21px;
        }

        .counter-number {
            font-size: 23px;
            font-weight: 800;
            line-height: 1.2;
        }

        .counter-label {
            font-size: 11px;
            opacity: .8;
        }

        /* =====================================================
               BADGE TOTAL
            ===================================================== */

        .payment-total-badge {
            padding: 8px 12px;
            border-radius: 9px;
            background: var(--bs-tertiary-bg);
            border: 1px solid var(--bs-border-color);
            color: var(--bs-secondary-color);
            font-size: 12px;
            font-weight: 700;
        }

        /* =====================================================
               CARTES
            ===================================================== */

        .payment-card {
            padding: 23px;
            border: 1px solid var(--bs-border-color);
            border-radius: 17px;
            background: var(--bs-body-bg);
            color: var(--bs-body-color);
            box-shadow: 0 3px 12px rgba(0, 0, 0, .035);
            transition: border-color .2s, transform .2s, box-shadow .2s;
        }

        .payment-card:hover {
            border-color: var(--bs-primary);
            transform: translateY(-3px);
            box-shadow: 0 9px 23px rgba(0, 0, 0, .07);
        }

        .payment-name {
            font-size: 16px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .payment-description {
            color: var(--bs-secondary-color);
            font-size: 12px;
            line-height: 1.5;
        }

        /* =====================================================
               ICÔNES CLASSIQUES
            ===================================================== */

        .payment-icon {
            width: 61px;
            height: 61px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 15px;
            background: var(--bs-primary-bg-subtle);
            color: var(--bs-primary);
            font-size: 27px;
        }

        /* =====================================================
               LOGOS MOBILE MONEY
            ===================================================== */

        .payment-brand-logo {
            width: 78px;
            height: 61px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            font-weight: 800;
            line-height: 1;
        }

        .payment-brand-logo small {
            font-size: 9px;
            margin-top: 5px;
            font-weight: 700;
        }

        .logo-mvola {
            color: #159447;
            font-size: 20px;
        }

        .logo-mvola span {
            color: #e7a72b;
        }

        .logo-orange {
            color: #f47721;
            font-size: 14px;
        }

        .orange-brand {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .orange-symbol {
            font-size: 20px;
        }

        .logo-orange small {
            color: #f47721;
        }

        .logo-airtel {
            color: #e32636;
            font-size: 19px;
        }

        .logo-airtel small {
            font-size: 11px;
            color: #e32636;
        }

        /* =====================================================
               STATUT
            ===================================================== */

        .payment-status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding-bottom: 13px;
            border-bottom: 1px solid var(--bs-border-color);
        }

        .status-label {
            color: var(--bs-secondary-color);
            font-size: 12px;
            font-weight: 600;
        }

        .payment-status-badge {
            padding: 6px 10px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 800;
        }

        .payment-status-badge.active {
            color: #16834c;
            background: rgba(25, 175, 105, .12);
        }

        .payment-status-badge.inactive {
            color: #78818c;
            background: rgba(120, 129, 140, .12);
        }

        /* =====================================================
               ACTIVATION
            ===================================================== */

        .payment-toggle {
            padding: 13px 14px;
            border-radius: 11px;
            background: var(--bs-tertiary-bg);
        }

        .payment-toggle .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            min-height: 22px;
        }

        .payment-toggle .form-check-input {
            float: none;
            margin: 0;
            width: 2.4em;
            height: 1.25em;
            cursor: pointer;
            flex-shrink: 0;
        }

        .payment-toggle .form-check-label {
            color: var(--bs-body-color);
            font-size: 13px;
            cursor: pointer;
        }

        .payment-switch:checked {
            background-color: #159b63;
            border-color: #159b63;
        }

        /* =====================================================
               CHAMPS
            ===================================================== */

        .payment-details .form-label {
            color: var(--bs-body-color);
            font-size: 12px;
        }

        .payment-details .form-control {
            min-height: 43px;
            border: 1px solid var(--bs-border-color);
            border-radius: 9px;
            background: var(--bs-body-bg);
            color: var(--bs-body-color);
            font-size: 13px;
        }

        .payment-details .form-control::placeholder {
            color: var(--bs-secondary-color);
            opacity: .75;
        }

        .payment-details .form-control:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 .2rem rgba(var(--bs-primary-rgb), .15);
        }

        .payment-help {
            display: block;
            margin-top: 7px;
            color: var(--bs-secondary-color);
            font-size: 10px;
        }

        /* =====================================================
               ENREGISTREMENT
            ===================================================== */

        .payment-save-area {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 19px 22px;
            border: 1px solid var(--bs-border-color);
            border-radius: 15px;
            background: var(--bs-tertiary-bg);
        }

        .save-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 12px;
            background: var(--bs-success-bg-subtle);
            color: var(--bs-success);
            font-size: 22px;
        }

        .payment-save-button {
            padding: 12px 22px;
            border: 0;
            border-radius: 10px;
            color: #fff;
            background: linear-gradient(120deg, #2563a6, #1685bd);
            font-size: 13px;
            font-weight: 800;
            transition: .2s;
        }

        .payment-save-button:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 5px 13px rgba(37, 99, 166, .22);
        }

        /* =====================================================
               RESPONSIVE
            ===================================================== */

        @media (max-width: 576px) {
            .payment-hero {
                padding: 22px 18px;
            }

            .payment-hero h2 {
                font-size: 22px;
            }

            .payment-counter {
                width: 100%;
            }

            .payment-card {
                padding: 18px;
            }

            .payment-save-area {
                align-items: stretch;
                flex-direction: column;
                padding: 17px;
            }

            .payment-save-button {
                width: 100%;
            }
        }

        /* =====================================================
               THÈME SOMBRE
            ===================================================== */

        html[data-app-theme="dark"] .payment-card {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }

        html[data-app-theme="dark"] .payment-toggle,
        html[data-app-theme="dark"] .payment-save-area,
        html[data-app-theme="dark"] .payment-total-badge {
            background: #263449;
            border-color: #3a4b61;
        }

        html[data-app-theme="dark"] .payment-details .form-control,
        html[data-app-theme="dark"] .payment-brand-logo {
            background: #172235;
            border-color: #3a4b61;
            color: #e2e8f0;
        }

        html[data-app-theme="dark"] .payment-name,
        html[data-app-theme="dark"] .payment-toggle .form-check-label,
        html[data-app-theme="dark"] .payment-details .form-label {
            color: #e2e8f0;
        }

        html[data-app-theme="dark"] .payment-status {
            border-color: #3a4b61;
        }

        /* =====================================================
               THÈME ULTRA PRO
            ===================================================== */

        html[data-app-theme="ultra-pro"] .payment-card {
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .07);
        }

        html[data-app-theme="ultra-pro"] .payment-hero {
            background: linear-gradient(115deg, #111827, #334155);
        }

        html[data-app-theme="ultra-pro"] .payment-save-button {
            background: #1e293b;
            border-radius: 7px;
        }

        /* =====================================================
               THÈME ÉMERAUDE
            ===================================================== */

        html[data-app-theme="emerald"] .payment-hero {
            background: linear-gradient(120deg, #064e3b, #059669);
        }

        html[data-app-theme="emerald"] .payment-icon {
            background: rgba(16, 185, 129, .13);
            color: #059669;
        }

        html[data-app-theme="emerald"] .payment-save-button {
            background: linear-gradient(120deg, #047857, #10b981);
        }

        html[data-app-theme="emerald"] .payment-switch:checked {
            background-color: #059669;
            border-color: #059669;
        }

        /* =====================================================
               THÈME CRÈME PRESTIGE
            ===================================================== */

        html[data-app-theme="creme-prestige"] .payment-hero {
            background: linear-gradient(120deg, #55412d, #9b7950);
        }

        html[data-app-theme="creme-prestige"] .payment-card {
            background: #fffdf8;
            border-color: #e7dcc8;
            box-shadow: 0 5px 17px rgba(92, 69, 39, .07);
        }

        html[data-app-theme="creme-prestige"] .payment-toggle,
        html[data-app-theme="creme-prestige"] .payment-save-area {
            background: #f7f1e6;
            border-color: #e7dcc8;
        }

        html[data-app-theme="creme-prestige"] .payment-details .form-control {
            background: #fffdf8;
            border-color: #e7dcc8;
            color: #55412d;
        }

        html[data-app-theme="creme-prestige"] .payment-icon {
            background: #f2e8d6;
            color: #8b6b43;
        }

        html[data-app-theme="creme-prestige"] .payment-save-button {
            background: linear-gradient(120deg, #765a37, #aa895b);
        }
    </style>

    {{-- MISE À JOUR VISUELLE DU STATUT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.payment-switch').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const card = this.closest('.payment-card');
                    const badge = card.querySelector('.payment-status-badge');

                    if (this.checked) {
                        badge.className = 'payment-status-badge active';
                        badge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Activé';
                    } else {
                        badge.className = 'payment-status-badge inactive';
                        badge.innerHTML = '<i class="bi bi-pause-circle-fill me-1"></i> Désactivé';
                    }
                });
            });
        });
    </script>

@endsection
