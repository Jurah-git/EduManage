@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <h2><i class="bi bi-person-vcard"></i> Fiche de l'enseignant</h2>

            <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                Informations de l'enseignant
            </div>

            <div class="card-body">
                <div class="row align-items-center mb-4">
                    <div class="col-md-3 text-center mb-3">
                        @if ($enseignant->photo)
                            <img src="{{ asset('storage/' . $enseignant->photo) }}" alt="Photo de l'enseignant"
                                class="rounded-circle border shadow-sm" width="150" height="150"
                                style="object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center"
                                style="width:150px;height:150px;">
                                <i class="bi bi-person text-secondary" style="font-size:5rem;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-9">
                        <h3>{{ $enseignant->nom }} {{ $enseignant->prenom }}</h3>
                        <p class="text-muted mb-2">Matricule : {{ $enseignant->matricule }}</p>

                        @if ($enseignant->statut === 'actif')
                            <span class="badge bg-success">Enseignant actif</span>
                        @else
                            <span class="badge bg-secondary">Enseignant inactif</span>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th style="width:30%">Sexe</th>
                                <td>{{ $enseignant->sexe ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th>Date de naissance</th>
                                <td>{{ $enseignant->date_naissance?->format('d/m/Y') ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone</th>
                                <td>{{ $enseignant->telephone ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <td>{{ $enseignant->email ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th>Adresse</th>
                                <td>{{ $enseignant->adresse ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th>Diplôme</th>
                                <td>{{ $enseignant->diplome ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th>Spécialité</th>
                                <td>{{ $enseignant->specialite ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th>Date de recrutement</th>
                                <td>{{ $enseignant->date_recrutement?->format('d/m/Y') ?? '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('enseignants.edit', $enseignant) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </a>

                    <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
