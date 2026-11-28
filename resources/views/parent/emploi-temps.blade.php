
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4 parent-emploi-page">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar-week me-2"></i>
                Emploi du temps
            </h2>
            <p class="text-muted mb-0">
                Consultez les horaires scolaires de vos enfants.
            </p>
        </div>

        <a href="{{ route('parent.dashboard') }}"
           class="btn btn-outline-secondary rounded-3">
            <i class="bi bi-arrow-left me-1"></i>
            Retour au tableau de bord
        </a>
    </div>

    @php
        $couleurs = [
            'Lundi' => '#2563eb',
            'Mardi' => '#7c3aed',
            'Mercredi' => '#0891b2',
            'Jeudi' => '#059669',
            'Vendredi' => '#d97706',
            'Samedi' => '#db2777',
        ];
    @endphp

    @forelse($eleves as $eleve)

        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

            <div class="card-header border-0 p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-person-circle me-2"></i>
                            {{ $eleve->prenom }} {{ $eleve->nom }}
                        </h5>

                        <div class="text-muted small">
                            Matricule : {{ $eleve->matricule ?? 'Non renseigné' }}
                            <span class="mx-2">|</span>
                            Classe : {{ $eleve->classe->nom ?? 'Non renseignée' }}
                        </div>
                    </div>

                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                        {{ $eleve->classe?->emploisTemps->count() ?? 0 }}
                        emploi(s) publié(s)
                    </span>

                </div>
            </div>

            <div class="card-body p-3 p-md-4">

                @php
                    $emplois = $eleve->classe?->emploisTemps ?? collect();
                @endphp

                @forelse($emplois as $emploi)

                    <div class="mb-4">

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <div>
                                <h6 class="fw-bold mb-1">
                                    {{ $emploi->titre ?: 'Emploi du temps de la classe' }}
                                </h6>

                                <small class="text-muted">
                                    Année scolaire :
                                    {{ $emploi->anneeScolaire->nom ?? 'Non renseignée' }}
                                </small>
                            </div>

                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>
                                Publié
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle emploi-table">

                                <thead>
                                    <tr>
                                        <th style="min-width:110px">Jour</th>
                                        <th style="min-width:150px">Horaires</th>
                                        <th style="min-width:160px">Matière</th>
                                        <th style="min-width:170px">Enseignant</th>
                                        <th style="min-width:110px">Salle</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($jours as $jour)

                                        @php
                                            $creneauxJour = $emploi->creneaux
                                                ->where('jour', $jour)
                                                ->sortBy('heure_debut');
                                        @endphp

                                        @if($creneauxJour->isNotEmpty())

                                            @foreach($creneauxJour as $creneau)

                                                <tr>
                                                    @if($loop->first)
                                                        <th rowspan="{{ $creneauxJour->count() }}"
                                                            class="jour-cell"
                                                            style="border-left:4px solid {{ $couleurs[$jour] }}">
                                                            {{ $jour }}
                                                        </th>
                                                    @endif

                                                    <td class="fw-semibold">
                                                        {{ \Illuminate\Support\Str::substr($creneau->heure_debut, 0, 5) }}
                                                        -
                                                        {{ \Illuminate\Support\Str::substr($creneau->heure_fin, 0, 5) }}
                                                    </td>

                                                    <td>
                                                        <div class="fw-semibold">
                                                            {{ $creneau->matiere->nom ?? 'Matière non renseignée' }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        {{ $creneau->enseignant->nom ?? 'Non renseigné' }}
                                                    </td>

                                                    <td>
                                                        <span class="badge bg-secondary-subtle text-secondary">
                                                            {{ $creneau->salle->nom ?? 'Non renseignée' }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            @endforeach

                                        @endif

                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        @if($emploi->creneaux->isEmpty())
                            <div class="alert alert-light border">
                                Aucun créneau n'est enregistré.
                            </div>
                        @endif

                    </div>

                @empty

                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x display-4 text-muted"></i>
                        <h6 class="fw-bold mt-3">Aucun emploi du temps publié</h6>
                        <p class="text-muted mb-0">
                            L'administration n'a pas encore publié
                            l'emploi du temps de cette classe.
                        </p>
                    </div>

                @endforelse

            </div>
        </div>

    @empty

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="bi bi-people display-4 text-muted"></i>
                <h5 class="fw-bold mt-3">Aucun enfant associé</h5>
                <p class="text-muted mb-0">
                    Aucun élève n'est actuellement lié à votre compte parent.
                </p>
            </div>
        </div>

    @endforelse

</div>

<style>
.parent-emploi-page .card {
    background: var(--bs-body-bg);
    color: var(--bs-body-color);
}

.parent-emploi-page .card-header {
    background: var(--bs-tertiary-bg);
}

.parent-emploi-page .emploi-table {
    margin-bottom: 0;
    color: var(--bs-body-color);
}

.parent-emploi-page .emploi-table th {
    background: var(--bs-tertiary-bg);
    font-size: .85rem;
    white-space: nowrap;
}

.parent-emploi-page .emploi-table td,
.parent-emploi-page .emploi-table th {
    padding: 12px;
}

.parent-emploi-page .jour-cell {
    vertical-align: middle;
    min-width: 110px;
}

.parent-emploi-page .badge {
    font-weight: 600;
}

html[data-app-theme="dark"] .parent-emploi-page .card,
html[data-app-theme="dark"] .parent-emploi-page .emploi-table {
    color: #e5e7eb;
}

html[data-app-theme="dark"] .parent-emploi-page .card-header,
html[data-app-theme="dark"] .parent-emploi-page .emploi-table th {
    background: #17243a;
}

html[data-app-theme="dark"] .parent-emploi-page .emploi-table td {
    background: #101c30;
}

html[data-app-theme="dark"] .parent-emploi-page .alert {
    background: #17243a;
    color: #e5e7eb;
}
</style>

@endsection
