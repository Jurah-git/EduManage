@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">

        {{-- EN-TÊTE --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-building"></i> Identité de l'école
                </h2>
                <p class="text-muted mb-0">
                    Gérer le nom, le logo et les coordonnées de votre établissement.
                </p>
            </div>
        </div>

        {{-- MESSAGE DE SUCCÈS --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">

            {{-- FORMULAIRE --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4 py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-pencil-square"></i> Informations de l'établissement
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('config.ecole-identite.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- NOM --}}
                            <div class="mb-3">
                                <label for="nom_ecole" class="form-label fw-semibold">
                                    Nom de l'école
                                </label>
                                <input type="text" name="nom_ecole" id="nom_ecole" class="form-control"
                                    value="{{ old('nom_ecole', $ecole->nom_ecole ?? '') }}"
                                    placeholder="Ex : EPP / CEG / Lycée ...">
                            </div>

                            {{-- ADRESSE --}}
                            <div class="mb-3">
                                <label for="adresse" class="form-label fw-semibold">
                                    Adresse
                                </label>
                                <input type="text" name="adresse" id="adresse" class="form-control"
                                    value="{{ old('adresse', $ecole->adresse ?? '') }}"
                                    placeholder="Adresse de l'établissement">
                            </div>

                            {{-- TÉLÉPHONE --}}
                            <div class="mb-3">
                                <label for="telephone" class="form-label fw-semibold">
                                    Téléphone
                                </label>
                                <input type="text" name="telephone" id="telephone" class="form-control"
                                    value="{{ old('telephone', $ecole->telephone ?? '') }}" placeholder="+261 ...">
                            </div>

                            {{-- EMAIL --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    Adresse e-mail
                                </label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $ecole->email ?? '') }}" placeholder="ecole@example.com">
                            </div>

                            {{-- LOGO --}}
                             <div class="mb-3">
                                <label for="logo" class="form-label fw-semibold">
                                    Logo de l'école
                                </label>

                                <input type="file" name="logo" id="logo" class="form-control"
                                    accept="image/png,image/jpeg,image/webp">

                                <small class="text-muted">
                                    Formats acceptés : JPG, PNG, WEBP. Maximum 2 Mo.
                                </small>

                                @if (!empty($ecole?->logo))
                                    <div class="mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="supprimer_logo"
                                                value="1" id="supprimer_logo">

                                            <label class="form-check-label text-danger fw-semibold" for="supprimer_logo">
                                                <i class="bi bi-trash"></i>
                                                Supprimer le logo actuel
                                            </label>
                                        </div>
                                    </div>
                                @endif
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Réinitialiser
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Enregistrer
                        </button>
                    </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- APERÇU DU LOGO --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white rounded-top-4 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-image"></i> Aperçu du logo
                    </h5>
                </div>

                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">

                    @if (!empty($ecole?->logo))
                        <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo de l'école" class="img-fluid mb-3"
                            style="max-height:180px; max-width:100%; object-fit:contain;">
                    @else
                        <div class="bg-light rounded-4 p-5 mb-3 text-muted">
                            <i class="bi bi-building" style="font-size: 5rem;"></i>
                        </div>
                        <p class="text-muted">Aucun logo enregistré</p>
                    @endif

                    <h5 class="fw-bold mt-2">
                        {{ $ecole->nom_ecole ?? 'Nom de votre école' }}
                    </h5>

                    <p class="text-muted small mb-0">
                        {{ $ecole->adresse ?? 'Adresse de l’établissement' }}
                    </p>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
