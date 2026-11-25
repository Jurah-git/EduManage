@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4">

        {{-- En-tête --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-cash-coin text-primary"></i>
                    Nouvel encaissement
                </h3>
                <p class="text-muted mb-0">
                    Enregistrer un paiement en espèces et générer automatiquement un reçu.
                </p>
            </div>

            <a href="{{ route('frais.paiements.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Retour aux paiements
            </a>
        </div>

        {{-- Messages d'erreur --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    Veuillez corriger les erreurs suivantes :
                </div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Sélection de l'élève --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-person-search text-primary"></i>
                    Sélection de l'élève
                </h5>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('frais.paiements.create') }}">

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-9">
                            <label class="form-label fw-semibold">
                                Élève
                            </label>

                            <select name="eleve_id" class="form-select" required>
                                <option value="">-- Sélectionner un élève --</option>

                                @foreach ($eleves as $eleve)
                                    <option value="{{ $eleve->id }}"
                                        {{ $eleveSelectionne && $eleveSelectionne->id == $eleve->id ? 'selected' : '' }}>
                                        {{ $eleve->nom }} {{ $eleve->prenom }}
                                        — {{ $eleve->matricule }}
                                        — {{ $eleve->classe->nom ?? 'Sans classe' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i>
                                Afficher les frais
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        @if ($eleveSelectionne)

            {{-- Informations de l'élève --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">

                        @if ($eleveSelectionne->photo)
                            <img src="{{ asset('storage/' . $eleveSelectionne->photo) }}" alt="Photo de l'élève"
                                class="rounded-circle border" style="width:75px;height:75px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary
                                    d-flex align-items-center justify-content-center"
                                style="width:75px;height:75px;">
                                <i class="bi bi-person-fill fs-1"></i>
                            </div>
                        @endif

                        <div>
                            <h5 class="fw-bold mb-1">
                                {{ $eleveSelectionne->nom }}
                                {{ $eleveSelectionne->prenom }}
                            </h5>

                            <div class="text-muted">
                                <span class="me-3">
                                    <i class="bi bi-card-text"></i>
                                    {{ $eleveSelectionne->matricule }}
                                </span>

                                <span>
                                    <i class="bi bi-mortarboard"></i>
                                    {{ $eleveSelectionne->classe->nom ?? '-' }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @if ($frais->isNotEmpty())
                {{-- Formulaire de paiement --}}
                <form method="POST" action="{{ route('frais.paiements.store') }}" id="formPaiement">

                    @csrf

                    <input type="hidden" name="eleve_id" value="{{ $eleveSelectionne->id }}">

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="fw-bold mb-0">
                                    <i class="bi bi-receipt text-primary"></i>
                                    Frais restant à payer
                                </h5>

                                <span class="badge bg-primary">
                                    {{ $frais->count() }} frais disponible(s)
                                </span>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                Saisissez le montant que l'élève règle pour chaque frais.
                                Vous pouvez effectuer un paiement partiel ou total.
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Frais</th>
                                            <th>Période</th>
                                            <th>Échéance</th>
                                            <th class="text-end">Montant dû</th>
                                            <th class="text-end">Déjà payé</th>
                                            <th class="text-end">Reste à payer</th>
                                            <th style="min-width:170px;">Montant encaissé</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($frais as $ligne)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">
                                                        {{ $ligne->tarifFrais->typeFrais->nom ?? $ligne->libelle }}
                                                    </div>

                                                    <small class="text-muted">
                                                        {{ $ligne->libelle }}
                                                    </small>
                                                </td>

                                                <td>
                                                    {{ $ligne->cle_periode ?? '-' }}
                                                </td>

                                                <td>
                                                    {{ $ligne->date_echeance ? $ligne->date_echeance->format('d/m/Y') : '-' }}
                                                </td>

                                                <td class="text-end">
                                                    {{ number_format($ligne->montant_du, 0, ',', ' ') }} Ar
                                                </td>

                                                <td class="text-end text-success">
                                                    {{ number_format($ligne->montant_paye, 0, ',', ' ') }} Ar
                                                </td>

                                                <td class="text-end fw-bold text-danger">
                                                    {{ number_format($ligne->reste_a_payer, 0, ',', ' ') }} Ar
                                                </td>

                                                <td>
                                                    <input type="number" name="frais[{{ $ligne->id }}]"
                                                        class="form-control montant-encaisse" min="0"
                                                        max="{{ $ligne->reste_a_payer }}" step="0.01" placeholder="0"
                                                        value="{{ old('frais.' . $ligne->id) }}"
                                                        data-reste="{{ $ligne->reste_a_payer }}">
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                    {{-- Informations du paiement --}}
                    <div class="row g-4">

                        <div class="col-lg-7">

                            <div class="card border-0 shadow-sm h-100">

                                <div class="card-header bg-white py-3">
                                    <h5 class="fw-bold mb-0">
                                        <i class="bi bi-clipboard-check text-primary"></i>
                                        Informations du paiement
                                    </h5>
                                </div>

                                <div class="card-body">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Date du paiement
                                        </label>

                                        <input type="date" name="date_paiement" class="form-control"
                                            value="{{ old('date_paiement', now()->format('Y-m-d')) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Mode de paiement
                                        </label>

                                        <input type="text" class="form-control" value="Espèces" disabled>

                                        <small class="text-muted">
                                            Les encaissements sont effectués uniquement en espèces.
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Observations
                                        </label>

                                        <textarea name="observations" class="form-control" rows="3" placeholder="Observations éventuelles...">{{ old('observations') }}</textarea>
                                    </div>

                                </div>
                            </div>

                        </div>

                        {{-- Total --}}
                        <div class="col-lg-5">

                            <div class="card border-0 shadow-sm h-100">

                                <div class="card-header bg-white py-3">
                                    <h5 class="fw-bold mb-0">
                                        <i class="bi bi-calculator text-primary"></i>
                                        Récapitulatif
                                    </h5>
                                </div>

                                <div class="card-body d-flex flex-column">

                                    <div class="mb-3">
                                        <p class="text-muted mb-1">
                                            Nombre de frais sélectionnés
                                        </p>

                                        <h5 class="fw-bold" id="nombreFrais">
                                            0
                                        </h5>
                                    </div>

                                    <hr>

                                    <div class="mb-3">
                                        <p class="text-muted mb-1">
                                            Montant total encaissé
                                        </p>

                                        <h3 class="fw-bold text-success" id="totalEncaisse">
                                            0 Ar
                                        </h3>
                                    </div>

                                    <div class="alert alert-warning mt-auto">
                                        <i class="bi bi-info-circle"></i>
                                        Après validation, le paiement sera enregistré
                                        et un reçu sera automatiquement généré.
                                    </div>

                                    <button type="submit" class="btn btn-success btn-lg w-100" id="btnValider">

                                        <i class="bi bi-check-circle"></i>
                                        Valider l'encaissement
                                    </button>

                                </div>
                            </div>

                        </div>

                    </div>

                </form>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">

                        <i class="bi bi-check-circle text-success fs-1"></i>

                        <h5 class="fw-bold mt-3">
                            Aucun frais à encaisser
                        </h5>

                        <p class="text-muted mb-0">
                            Cet élève n'a actuellement aucun frais impayé ou partiellement payé.
                        </p>

                    </div>
                </div>
            @endif

        @endif

    </div>

    {{-- Calcul automatique du total --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const champs = document.querySelectorAll('.montant-encaisse');
            const totalElement = document.getElementById('totalEncaisse');
            const nombreElement = document.getElementById('nombreFrais');
            const formulaire = document.getElementById('formPaiement');

            function calculerTotal() {

                let total = 0;
                let nombre = 0;

                champs.forEach(function(champ) {

                    const montant = parseFloat(champ.value) || 0;

                    if (montant > 0) {
                        total += montant;
                        nombre++;
                    }
                });

                if (totalElement) {
                    totalElement.textContent =
                        new Intl.NumberFormat('fr-FR').format(total) + ' Ar';
                }

                if (nombreElement) {
                    nombreElement.textContent = nombre;
                }
            }

            champs.forEach(function(champ) {

                champ.addEventListener('input', function() {

                    const montant = parseFloat(this.value) || 0;
                    const reste = parseFloat(this.dataset.reste);

                    if (montant > reste) {
                        this.setCustomValidity(
                            'Le montant ne peut pas dépasser le reste à payer.'
                        );
                    } else {
                        this.setCustomValidity('');
                    }

                    calculerTotal();
                });

            });

            if (formulaire) {
                formulaire.addEventListener('submit', function(event) {

                    let total = 0;

                    champs.forEach(function(champ) {
                        total += parseFloat(champ.value) || 0;
                    });

                    if (total <= 0) {
                        event.preventDefault();
                        alert('Veuillez saisir au moins un montant à encaisser.');
                        return;
                    }

                    const bouton = document.getElementById('btnValider');

                    if (bouton) {
                        bouton.disabled = true;
                        bouton.innerHTML =
                            '<span class="spinner-border spinner-border-sm"></span> Enregistrement en cours...';
                    }

                });
            }

            calculerTotal();

        });
    </script>

@endsection
