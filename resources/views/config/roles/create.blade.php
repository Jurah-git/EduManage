@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('config.roles.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>

            <div>
                <h2 class="fw-bold mb-1">Créer un rôle</h2>
                <p class="text-muted mb-0">
                    Ajoutez un rôle personnalisé à EduManage.
                </p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-plus me-2"></i>
                            Informations du rôle
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Veuillez corriger les erreurs :</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('config.roles.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    Nom du rôle <span class="text-danger">*</span>
                                </label>

                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Ex. : Enseignant, Comptable, Secrétaire" maxlength="100" required
                                    autofocus>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="form-text">
                                    Choisissez un nom clair. Vous pourrez ensuite
                                    définir les permissions de ce rôle.
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Le rôle <strong>Administrateur</strong> est réservé
                                et ne peut pas être recréé depuis ce formulaire.
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('config.roles.index') }}" class="btn btn-light border">
                                    Annuler
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Créer le rôle
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
