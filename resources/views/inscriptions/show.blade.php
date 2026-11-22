@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <style>
            .show-inscription {
                max-width: 1250px;
                margin: auto;
                color: #263445;
            }

            .show-header {
                background: linear-gradient(120deg, #172f50, #2874b9);
                color: white;
                border-radius: 18px;
                padding: 28px 32px;
                margin-bottom: 25px;
                box-shadow: 0 8px 25px rgba(20, 50, 85, .13);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 20px;
            }

            .show-header h3 {
                font-weight: 750;
                margin: 0 0 8px;
            }

            .show-header p {
                margin: 0;
                opacity: .85;
            }

            .show-reference {
                background: rgba(255, 255, 255, .13);
                border: 1px solid rgba(255, 255, 255, .2);
                border-radius: 12px;
                padding: 13px 18px;
                text-align: center;
            }

            .show-reference small {
                display: block;
                opacity: .8;
                margin-bottom: 4px;
            }

            .show-reference strong {
                font-size: 20px;
                letter-spacing: 1px;
            }

            .show-card {
                background: white;
                border: 1px solid #e8edf3;
                border-radius: 16px;
                box-shadow: 0 5px 20px rgba(30, 50, 80, .05);
                margin-bottom: 22px;
                overflow: hidden;
            }

            .show-card-header {
                padding: 19px 23px;
                border-bottom: 1px solid #edf0f4;
            }

            .show-card-header h5 {
                margin: 0;
                font-size: 16px;
                font-weight: 750;
            }

            .show-card-header p {
                margin: 5px 0 0;
                color: #7b8795;
                font-size: 13px;
            }

            .show-card-body {
                padding: 24px;
            }

            .student-profile {
                display: flex;
                align-items: center;
                gap: 20px;
                padding: 20px;
                background: #f7f9fc;
                border: 1px solid #e7edf4;
                border-radius: 14px;
            }

            .student-photo {
                width: 95px;
                height: 95px;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid white;
                box-shadow: 0 3px 12px rgba(0, 0, 0, .10);
                flex-shrink: 0;
            }

            .student-initial {
                width: 95px;
                height: 95px;
                border-radius: 50%;
                background: #dcecff;
                color: #2469a8;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 30px;
                font-weight: 800;
                flex-shrink: 0;
            }

            .student-profile h4 {
                font-weight: 800;
                margin: 0 0 7px;
            }

            .student-profile p {
                margin: 0 0 5px;
                color: #718096;
                font-size: 13px;
            }

            .info-item {
                padding: 15px;
                border: 1px solid #edf0f4;
                border-radius: 12px;
                height: 100%;
            }

            .info-label {
                display: block;
                color: #8290a2;
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 7px;
                text-transform: uppercase;
                letter-spacing: .4px;
            }

            .info-value {
                display: block;
                color: #263445;
                font-size: 15px;
                font-weight: 750;
                overflow-wrap: anywhere;
            }

            .status-badge {
                display: inline-block;
                padding: 7px 13px;
                border-radius: 30px;
                font-size: 12px;
                font-weight: 750;
            }

            .status-attente {
                color: #946200;
                background: #fff3cd;
            }

            .status-validee {
                color: #146c43;
                background: #d1e7dd;
            }

            .status-annulee {
                color: #b02a37;
                background: #f8d7da;
            }

            .type-badge {
                display: inline-block;
                padding: 7px 12px;
                border-radius: 8px;
                background: #eaf3ff;
                color: #2469a8;
                font-size: 12px;
                font-weight: 750;
            }

            .financial-box {
                padding: 22px;
                border-radius: 14px;
                background: linear-gradient(120deg, #edf6ff, #f7fbff);
                border: 1px solid #dceafa;
            }

            .financial-box span {
                display: block;
                color: #718096;
                font-size: 13px;
                margin-bottom: 8px;
            }

            .financial-box strong {
                color: #205d96;
                font-size: 27px;
                font-weight: 800;
            }

            .observation-box {
                background: #f8fafc;
                border: 1px solid #e8edf3;
                border-radius: 12px;
                padding: 18px;
                color: #526174;
                line-height: 1.7;
                white-space: pre-line;
            }

            .show-actions {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                flex-wrap: wrap;
                margin-top: 10px;
            }

            .show-btn {
                border: 0;
                border-radius: 10px;
                padding: 12px 19px;
                font-weight: 700;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
            }

            .show-btn-primary {
                background: #2469a8;
                color: white;
            }

            .show-btn-primary:hover {
                background: #18558e;
                color: white;
            }

            .show-btn-secondary {
                background: #edf1f5;
                color: #44546a;
            }

            .show-btn-secondary:hover {
                background: #dfe5ec;
                color: #263445;
            }

            @media(max-width: 600px) {
                .show-header {
                    padding: 22px;
                }

                .show-card-body {
                    padding: 17px;
                }

                .student-profile {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .show-reference {
                    width: 100%;
                }
            }

            @media print {
                body {
                    background: white !important;
                }

                .show-actions,
                .sidebar,
                .topbar {
                    display: none !important;
                }

                .show-inscription {
                    max-width: 100%;
                }

                .show-card,
                .show-header {
                    box-shadow: none;
                    break-inside: avoid;
                }
            }
        </style>

        <div class="show-inscription">

            {{-- EN-TÊTE --}}
            <div class="show-header">

                <div>
                    <h3>📋 Dossier d'inscription</h3>
                    <p>Consultation détaillée du dossier de l'élève.</p>
                </div>

                <div class="show-reference">
                    <small>NUMÉRO DU DOSSIER</small>
                    <strong>INS-{{ str_pad($inscription->id, 5, '0', STR_PAD_LEFT) }}</strong>
                </div>

            </div>

            {{-- PROFIL DE L'ÉLÈVE --}}
            <div class="show-card">

                <div class="show-card-header">
                    <h5>👨‍🎓 Identité de l'élève</h5>
                    <p>Informations personnelles de l'élève concerné.</p>
                </div>

                <div class="show-card-body">

                    <div class="student-profile">

                        @if ($inscription->eleve && $inscription->eleve->photo)
                            <img src="{{ asset('storage/' . $inscription->eleve->photo) }}" class="student-photo"
                                alt="Photo de l'élève">
                        @else
                            <div class="student-initial">
                                {{ strtoupper(substr($inscription->eleve->prenom ?? 'E', 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <h4>
                                {{ $inscription->eleve->nom ?? 'Élève inconnu' }}
                                {{ $inscription->eleve->prenom ?? '' }}
                            </h4>

                            <p>
                                Matricule :
                                <strong>{{ $inscription->eleve->matricule ?? 'Non renseigné' }}</strong>
                            </p>

                            <p>
                                Numéro dans la classe :
                                <strong>{{ $inscription->eleve->numero_classe ?? 'Non renseigné' }}</strong>
                            </p>
                        </div>

                    </div>

                    <div class="row g-3 mt-2">

                        <div class="col-md-4">
                            <div class="info-item">
                                <span class="info-label">Sexe</span>
                                <span class="info-value">
                                    {{ $inscription->eleve->sexe ?? 'Non renseigné' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-item">
                                <span class="info-label">Date de naissance</span>
                                <span class="info-value">
                                    {{ $inscription->eleve->date_naissance ? \Carbon\Carbon::parse($inscription->eleve->date_naissance)->format('d/m/Y') : 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-item">
                                <span class="info-label">Classe actuelle de l'élève</span>
                                <span class="info-value">
                                    {{ $inscription->eleve->classe->nom ?? 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- DÉTAILS DE L'INSCRIPTION --}}
            <div class="show-card">

                <div class="show-card-header">
                    <h5>📚 Informations de l'inscription</h5>
                    <p>Année scolaire, classe et statut du dossier.</p>
                </div>

                <div class="show-card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Type d'inscription</span>
                                <span class="info-value">
                                    @if ($inscription->type === 'reinscription')
                                        <span class="type-badge">🔄 Réinscription</span>
                                    @else
                                        <span class="type-badge">🆕 Nouvelle inscription</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Statut du dossier</span>
                                <span class="info-value">
                                    @if ($inscription->statut === 'validee')
                                        <span class="status-badge status-validee">✓ Validée</span>
                                    @elseif($inscription->statut === 'annulee')
                                        <span class="status-badge status-annulee">✕ Annulée</span>
                                    @else
                                        <span class="status-badge status-attente">◷ En attente</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Classe d'inscription</span>
                                <span class="info-value">
                                    {{ $inscription->classe->nom ?? 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Année scolaire</span>
                                <span class="info-value">
                                    {{ $inscription->anneeScolaire->nom ?? 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Date d'inscription</span>
                                <span class="info-value">
                                    {{ $inscription->date_inscription?->format('d/m/Y') ?? 'Non renseignée' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Numéro du dossier</span>
                                <span class="info-value">
                                    INS-{{ str_pad($inscription->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- INFORMATIONS FINANCIÈRES --}}
            <div class="show-card">

                <div class="show-card-header">
                    <h5>💰 Informations financières</h5>
                    <p>Montant des frais d'inscription enregistrés.</p>
                </div>

                <div class="show-card-body">

                    <div class="financial-box">
                        <span>Frais d'inscription</span>
                        <strong>
                            {{ number_format((float) $inscription->frais_inscription, 2, ',', ' ') }}
                            Ar
                        </strong>
                    </div>

                </div>
            </div>

            {{-- OBSERVATIONS --}}
            <div class="show-card">

                <div class="show-card-header">
                    <h5>📝 Observations</h5>
                    <p>Informations complémentaires relatives à ce dossier.</p>
                </div>

                <div class="show-card-body">

                    <div class="observation-box">
                        {{ $inscription->observations ?: 'Aucune observation enregistrée pour cette inscription.' }}
                    </div>

                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="show-actions">

                <a href="{{ route('inscriptions.index') }}" class="show-btn show-btn-secondary">
                    ← Retour à la liste
                </a>

                <button type="button" onclick="window.print()" class="show-btn show-btn-secondary">
                    🖨️ Imprimer
                </button>

                <a href="{{ route('inscriptions.edit', $inscription->id) }}" class="show-btn show-btn-primary">
                    ✏️ Modifier le dossier
                </a>

            </div>

        </div>

    </div>
@endsection
