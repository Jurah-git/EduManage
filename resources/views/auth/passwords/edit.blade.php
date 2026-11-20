
@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">
                <i class="bi bi-shield-lock"></i>
                Sécurité – Modifier mon mot de passe
            </h4>
        </div>

        <div class="card-body">

            @if ($errors->updatePassword->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->updatePassword->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    Votre mot de passe a été modifié avec succès.
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                {{-- ANCIEN MOT DE PASSE --}}
                <div class="mb-3">
                    <label class="form-label">Ancien mot de passe</label>

                    <div class="input-group">
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               class="form-control"
                               required
                               autocomplete="current-password"
                               placeholder="Saisir votre ancien mot de passe">

                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePassword('current_password', 'iconCurrent')">
                            <i class="bi bi-eye" id="iconCurrent"></i>
                        </button>
                    </div>
                </div>

                {{-- NOUVEAU MOT DE PASSE --}}
                <div class="mb-3">
                    <label class="form-label">Nouveau mot de passe</label>

                    <div class="input-group">
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               minlength="8"
                               required
                               autocomplete="new-password"
                               placeholder="Minimum 8 caractères">

                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePassword('password', 'iconNew')">
                            <i class="bi bi-eye" id="iconNew"></i>
                        </button>
                    </div>
                </div>

                {{-- CONFIRMATION --}}
                <div class="mb-4">
                    <label class="form-label">Confirmer le nouveau mot de passe</label>

                    <div class="input-group">
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               minlength="8"
                               required
                               autocomplete="new-password"
                               placeholder="Répéter le nouveau mot de passe">

                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePassword('password_confirmation', 'iconConfirm')">
                            <i class="bi bi-eye" id="iconConfirm"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Modifier mon mot de passe
                    </button>

                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Retour
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>

@endsection
