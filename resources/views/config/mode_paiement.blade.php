@extends('layouts.app')

@section('content')

    @php
        $icones = [
            'especes' => 'bi-cash-stack',
            'virement' => 'bi-bank',
            'cheque' => 'bi-receipt',
        ];

        $actifs = count(array_filter($modes, fn($mode) => $mode['actif'] ?? false));
    @endphp

    <div class="container-fluid py-4 payment-settings">

        {{-- EN-TÊTE --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Modes de paiement</h3>
                <p class="text-secondary mb-0">
                    Configurez les moyens de paiement acceptés par votre établissement.
                </p>
            </div>

            <div class="payment-counter">
                <span class="counter-number">{{ $actifs }}</span>
                <span class="counter-label">Mode(s) activé(s)</span>
            </div>
        </div>

        {{-- MESSAGES --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Vérifiez les informations :</strong>
                <ul class="mb-0 mt-2">
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

            <div class="row g-3">

                @foreach ($modes as $key => $mode)
                    <div class="col-12 col-md-6 col-xl-4">

                        <div class="payment-card h-100">

                            {{-- LOGO ET NOM --}}
                            <div class="d-flex align-items-center gap-3 mb-3">

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

                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1">
                                        {{ $mode['nom'] }}
                                    </h5>

                                    <p class="text-secondary small mb-0">
                                        {{ $mode['description'] }}
                                    </p>
                                </div>

                            </div>

                            {{-- ACTIVATION --}}
                            <div class="payment-toggle mb-3">

                                <input type="hidden" name="modes[{{ $key }}][actif]" value="0">

                                <div class="form-check form-switch">

                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="mode_{{ $key }}" name="modes[{{ $key }}][actif]"
                                        value="1" {{ $mode['actif'] ?? false ? 'checked' : '' }}>

                                    <label class="form-check-label fw-semibold" for="mode_{{ $key }}">
                                        Activer ce mode
                                    </label>

                                </div>
                            </div>

                            {{-- INFORMATIONS --}}
                            <label class="form-label small fw-semibold" for="details_{{ $key }}">
                                Informations complémentaires
                            </label>

                            <input type="text" class="form-control" id="details_{{ $key }}"
                                name="modes[{{ $key }}][details]" value="{{ $mode['details'] ?? '' }}"
                                maxlength="255" placeholder="Numéro, compte ou information...">

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- ENREGISTREMENT --}}
            <div class="payment-save-area mt-4">

                <div>
                    <div class="fw-semibold">
                        Enregistrer la configuration
                    </div>

                    <small class="text-secondary">
                        Les modifications seront sauvegardées pour votre établissement.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-check-lg me-2"></i>
                    Enregistrer
                </button>

            </div>

        </form>

    </div>

    {{-- STYLES --}}
    <style>
        /* BASE */

        .payment-settings {
            color: var(--bs-body-color);
            background: transparent;
        }

        /* COMPTEUR */

        .payment-counter {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border: 1px solid var(--bs-border-color);
            border-radius: 12px;
            background: var(--bs-tertiary-bg);
        }

        .counter-number {
            font-size: 25px;
            font-weight: 800;
            color: var(--bs-primary);
        }

        .counter-label {
            font-size: 13px;
            color: var(--bs-secondary-color);
        }

        /* CARTES */

        .payment-card {
            padding: 22px;
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            background: var(--bs-body-bg);
            color: var(--bs-body-color);
            transition: border-color .2s, transform .2s;
        }

        .payment-card:hover {
            border-color: var(--bs-primary);
            transform: translateY(-2px);
        }

        /* ICÔNES CLASSIQUES */

        .payment-icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: var(--bs-primary-bg-subtle);
            color: var(--bs-primary);
            font-size: 25px;
            flex-shrink: 0;
        }

        /* LOGOS MOBILE MONEY */

        .payment-brand-logo {
            width: 75px;
            height: 58px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 800;
            line-height: 1;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
        }

        .payment-brand-logo small {
            font-size: 9px;
            margin-top: 5px;
            font-weight: 600;
        }

        /* MVOLA */

        .logo-mvola {
            color: #159447;
            font-size: 20px;
        }

        .logo-mvola span {
            color: #e7a72b;
        }

        /* ORANGE MONEY */

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

        /* AIRTEL MONEY */

        .logo-airtel {
            color: #e32636;
            font-size: 19px;
        }

        .logo-airtel small {
            font-size: 11px;
            color: #e32636;
        }

        /* ACTIVATION */

        .payment-toggle {
            padding: 12px;
            border-radius: 10px;
            background: var(--bs-tertiary-bg);
        }

        .payment-toggle .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .payment-toggle .form-check-input {
            float: none;
            margin: 0;
            cursor: pointer;
        }

        .payment-toggle .form-check-label {
            color: var(--bs-body-color);
            cursor: pointer;
        }

        /* CHAMPS */

        .payment-card .form-label {
            color: var(--bs-body-color);
        }

        .payment-card .form-control {
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            border: 1px solid var(--bs-border-color);
        }

        .payment-card .form-control::placeholder {
            color: var(--bs-secondary-color);
            opacity: .8;
        }

        .payment-card .form-control:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 .2rem rgba(var(--bs-primary-rgb), .15);
        }

        /* ENREGISTREMENT */

        .payment-save-area {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px;
            border: 1px solid var(--bs-border-color);
            border-radius: 14px;
            background: var(--bs-tertiary-bg);
        }

        /* RESPONSIVE */

        @media (max-width: 576px) {

            .payment-card {
                padding: 17px;
            }

            .payment-save-area {
                align-items: stretch;
                flex-direction: column;
            }

            .payment-save-area button {
                width: 100%;
            }

        }
    </style>

@endsection
