@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <!-- HEADER -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                🎓 Liste des élèves
            </h4>

            <a href="{{ route('eleves.create') }}"
               class="btn btn-primary btn-sm">

                ➕ Ajouter

            </a>

        </div>

        <!-- BODY -->
        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <!-- FILTRES -->
            <form method="GET"
                  action="{{ route('eleves.index') }}"
                  class="mb-4">

                <div class="row g-3">

                    <!-- NOM -->
                    <div class="col-md-2">

                        <input
                            type="text"
                            name="nom"
                            value="{{ request('nom') }}"
                            class="form-control"
                            placeholder="Nom">

                    </div>

                    <!-- PRENOM -->
                    <div class="col-md-2">

                        <input
                            type="text"
                            name="prenom"
                            value="{{ request('prenom') }}"
                            class="form-control"
                            placeholder="Prénom">

                    </div>

                    <!-- CLASSE -->
                    <div class="col-md-2">

                        <select
                            name="classe_id"
                            class="form-control">

                            <option value="">
                                Toutes classes
                            </option>

                            @foreach($classes as $classe)

                                <option
                                    value="{{ $classe->id }}"
                                    {{ request('classe_id') == $classe->id ? 'selected' : '' }}>

                                    {{ $classe->nom }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- NUMERO -->
                    <div class="col-md-2">

                        <input
                            type="number"
                            name="numero_classe"
                            value="{{ request('numero_classe') }}"
                            class="form-control"
                            placeholder="Numéro">

                    </div>

                    <!-- TRI -->
                    <div class="col-md-2">

                        <select
                            name="sort"
                            class="form-control">

                            <option value="nom_asc">
                                Nom A → Z
                            </option>

                            <option value="nom_desc"
                                {{ request('sort') == 'nom_desc' ? 'selected' : '' }}>

                                Nom Z → A

                            </option>

                            <option value="prenom_asc"
                                {{ request('sort') == 'prenom_asc' ? 'selected' : '' }}>

                                Prénom A → Z

                            </option>

                            <option value="prenom_desc"
                                {{ request('sort') == 'prenom_desc' ? 'selected' : '' }}>

                                Prénom Z → A

                            </option>

                            <option value="numero_asc"
                                {{ request('sort') == 'numero_asc' ? 'selected' : '' }}>

                                Numéro ↑

                            </option>

                            <option value="numero_desc"
                                {{ request('sort') == 'numero_desc' ? 'selected' : '' }}>

                                Numéro ↓

                            </option>

                        </select>

                    </div>

                    <!-- BUTTON -->
                    <div class="col-md-2 d-grid">

                        <button class="btn btn-primary">

                            🔍 Filtrer

                        </button>

                    </div>

                </div>

            </form>

            <!-- TABLE -->
            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Classe</th>
                        <th>Sexe</th>
                        <th>Numéro</th>
                        <th>Matricule</th>
                        <th width="220">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($eleves as $eleve)

                        <tr>

                            <!-- PHOTO -->
                            <td style="width:80px;">

                                @if($eleve->photo)

                                    <img
                                        src="{{ asset('storage/' . $eleve->photo) }}"
                                        class="student-avatar">

                                @else

                                    <img
                                        src="https://ui-avatars.com/api/?name={{ urlencode($eleve->nom . ' ' . $eleve->prenom) }}&background=0D8ABC&color=fff"
                                        class="student-avatar">

                                @endif

                            </td>

                            <!-- NOM -->
                            <td>

                                <strong>
                                    {{ $eleve->nom }}
                                </strong>

                            </td>

                            <!-- PRENOM -->
                            <td>

                                {{ $eleve->prenom }}

                            </td>

                            <!-- CLASSE -->
                            <td>

                                <span class="badge bg-primary">

                                    {{ $eleve->classe->nom ?? '-' }}

                                </span>

                            </td>

                            <!-- SEXE -->
                            <td>

                                {{ $eleve->sexe }}

                            </td>

                            <!-- NUMERO -->
                            <td>

                                <span class="badge bg-dark">

                                    N° {{ $eleve->numero_classe }}

                                </span>

                            </td>

                            <!-- MATRICULE -->
                            <td>

                                <span class="badge bg-secondary">

                                    {{ $eleve->matricule }}

                                </span>

                            </td>

                            <!-- ACTIONS -->
                            <td>

                                <div class="d-flex gap-2">

                                    <!-- SHOW -->
                                    <a href="{{ route('eleves.show', $eleve) }}"
                                       class="btn btn-info btn-sm text-white">

                                        Voir

                                    </a>

                                    <!-- EDIT -->
                                    <a href="{{ route('eleves.edit', $eleve) }}"
                                       class="btn btn-warning btn-sm">

                                        Modifier

                                    </a>

                                    <!-- DELETE -->
                                    <form action="{{ route('eleves.destroy', $eleve) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Supprimer cet élève ?')"
                                            class="btn btn-danger btn-sm">

                                            Supprimer

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center text-muted">

                                Aucun élève trouvé

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection