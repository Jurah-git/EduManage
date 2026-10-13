@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar-week text-primary"></i>
                Détails de l'emploi du temps
            </h2>
            <p class="text-muted mb-0">
                {{ $emploiTemps->titre ?: 'Emploi du temps' }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('emplois-temps.index') }}"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>

            @if($emploiTemps->statut !== 'publie')
                <a href="{{ route('emplois-temps.edit', $emploiTemps) }}"
                   class="btn btn-outline-primary">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Impossible d'enregistrer le créneau :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="text-muted small">Classe</div>
                    <div class="fw-semibold">
                        {{ $emploiTemps->classe->nom ?? 'Non renseignée' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="text-muted small">Année scolaire</div>
                    <div class="fw-semibold">
                        {{ $emploiTemps->anneeScolaire->nom
                            ?? $emploiTemps->anneeScolaire->libelle
                            ?? $emploiTemps->anneeScolaire->annee
                            ?? $emploiTemps->anneeScolaire->id
                            ?? 'Non renseignée' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="text-muted small">Statut</div>
                    @if($emploiTemps->statut === 'publie')
                        <span class="badge bg-success">Publié</span>
                    @else
                        <span class="badge bg-secondary">Brouillon</span>
                    @endif
                </div>
            </div>

            @if($emploiTemps->statut === 'brouillon')
                <form action="{{ route('emplois-temps.publier', $emploiTemps) }}"
                      method="POST" class="mt-3"
                      onsubmit="return confirm('Voulez-vous publier cet emploi du temps ?')">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Publier l'emploi du temps
                    </button>
                </form>
            @else
                <form action="{{ route('emplois-temps.brouillon', $emploiTemps) }}"
                      method="POST" class="mt-3"
                      onsubmit="return confirm('Voulez-vous remettre cet emploi du temps en brouillon ?')">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="btn btn-outline-warning">
                        <i class="bi bi-arrow-counterclockwise"></i> Remettre en brouillon
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-calendar3"></i> Créneaux horaires
            </h5>
        </div>

        <div class="card-body p-0">
            @php
                $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                $creneauxParJour = $emploiTemps->creneaux->groupBy('jour');
            @endphp

            @if($emploiTemps->creneaux->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-calendar-x fs-1"></i>
                    <p class="mt-2 mb-0">Aucun créneau horaire enregistré.</p>
                </div>
            @else
                @foreach($jours as $jour)
                    @if(isset($creneauxParJour[$jour]) && $creneauxParJour[$jour]->isNotEmpty())
                        <div class="p-3 border-bottom">
                            <h6 class="fw-bold text-primary">{{ $jour }}</h6>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Horaire</th>
                                            <th>Matière</th>
                                            <th>Enseignant</th>
                                            <th>Salle</th>
                                            @if($emploiTemps->statut !== 'publie')
                                                <th class="text-end">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($creneauxParJour[$jour]->sortBy('heure_debut') as $creneau)
                                            <tr>
                                                <td class="text-nowrap">
                                                    {{ substr($creneau->heure_debut, 0, 5) }}
                                                    –
                                                    {{ substr($creneau->heure_fin, 0, 5) }}
                                                </td>
                                                <td>{{ $creneau->matiere->nom ?? '—' }}</td>
                                                <td>
                                                    {{ $creneau->enseignant->nom ?? '—' }}
                                                    {{ $creneau->enseignant->prenom ?? '' }}
                                                </td>
                                                <td>{{ $creneau->salle->nom ?? '—' }}</td>

                                                @if($emploiTemps->statut !== 'publie')
                                                    <td class="text-end">
                                                        <form
                                                            action="{{ route('emplois-temps.creneaux.destroy', [$emploiTemps, $creneau]) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Supprimer ce créneau ?')">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i>
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    @if($emploiTemps->statut !== 'publie')
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle"></i> Ajouter un créneau horaire
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('emplois-temps.creneaux.store', $emploiTemps) }}"
                      method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="matiere_id" class="form-label">Matière *</label>
                            <select name="matiere_id" id="matiere_id"
                                    class="form-select" required>
                                <option value="">Choisir une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}"
                                        {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="enseignant_id" class="form-label">Enseignant *</label>
                            <select name="enseignant_id" id="enseignant_id"
                                    class="form-select" required>
                                <option value="">Choisir un enseignant</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}"
                                        {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="salle_id" class="form-label">Salle *</label>
                            <select name="salle_id" id="salle_id"
                                    class="form-select" required>
                                <option value="">Choisir une salle</option>
                                @foreach($salles as $salle)
                                    <option value="{{ $salle->id }}"
                                        {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                                        {{ $salle->nom }} ({{ $salle->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="jour" class="form-label">Jour *</label>
                            <select name="jour" id="jour" class="form-select" required>
                                <option value="">Choisir un jour</option>
                                @foreach($jours as $jour)
                                    <option value="{{ $jour }}"
                                        {{ old('jour') == $jour ? 'selected' : '' }}>
                                        {{ $jour }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="heure_debut" class="form-label">Heure de début *</label>
                            <input type="time" name="heure_debut" id="heure_debut"
                                   class="form-control" value="{{ old('heure_debut') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="heure_fin" class="form-label">Heure de fin *</label>
                            <input type="time" name="heure_fin" id="heure_fin"
                                   class="form-control" value="{{ old('heure_fin') }}" required>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Ajouter le créneau
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
@endsection
