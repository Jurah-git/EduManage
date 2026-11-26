 @extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">👤 Créer un compte utilisateur</h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('config.users.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <h5 class="text-primary mb-3">🔐 Rôle et association</h5>

                <div class="mb-3">
                    <label class="form-label">Rôle du compte *</label>
                    <select name="role" id="roleUtilisateur" class="form-select" required>
                        <option value="">Sélectionner un rôle</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected(old('role') === $role->name)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="blocParent" style="display:none;">
                    <label class="form-label">Fiche parent à associer *</label>
                    <select name="parent_id" id="parent_id" class="form-select">
                        <option value="">Sélectionner un parent</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>
                                {{ $parent->nom }} {{ $parent->prenom }}
                                — {{ $parent->telephone ?? 'Sans téléphone' }}
                            </option>
                        @endforeach
                    </select>

                    @if ($parents->isEmpty())
                        <div class="alert alert-warning mt-2 mb-0">
                            Tous les parents possèdent déjà un compte ou aucune fiche parent n'est disponible.
                        </div>
                    @endif
                </div>

                <hr>

                <h5 class="text-primary mb-3">📷 Photo de profil</h5>
                <div class="mb-4">
                    <input type="file" name="photo" class="form-control"
                           accept="image/jpeg,image/png,image/webp">
                    <small class="text-muted">Formats : JPG, PNG ou WEBP. Maximum 2 Mo.</small>
                </div>

                <hr>

                <h5 class="text-primary mb-3">👤 Informations personnelles</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom complet *</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sexe</label>
                        <select name="sexe" class="form-select">
                            <option value="">Sélectionner</option>
                            <option value="Masculin" @selected(old('sexe') == 'Masculin')>Masculin</option>
                            <option value="Féminin" @selected(old('sexe') == 'Féminin')>Féminin</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance" class="form-control"
                               value="{{ old('date_naissance') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control"
                               value="{{ old('telephone') }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea name="adresse" class="form-control" rows="2">{{ old('adresse') }}</textarea>
                    </div>
                </div>

                <hr>

                <h5 class="text-primary mb-3">💼 Informations professionnelles</h5>
                <div class="mb-3">
                    <label class="form-label">Fonction</label>
                    <input type="text" name="fonction" class="form-control"
                           value="{{ old('fonction') }}"
                           placeholder="Ex : Administrateur de l'établissement">
                </div>

                <hr>

                <h5 class="text-primary mb-3">🔑 Informations de connexion</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Adresse e-mail *</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mot de passe *</label>
                        <input type="password" name="password" class="form-control"
                               minlength="8" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Statut du compte</label>
                        <select name="statut" class="form-select" required>
                            <option value="1" @selected(old('statut', '1') == '1')>Actif</option>
                            <option value="0" @selected(old('statut') == '0')>Inactif</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Créer utilisateur
                    </button>

                    <a href="{{ route('config.users.list') }}" class="btn btn-secondary">
                        Retour
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('roleUtilisateur');
    const blocParent = document.getElementById('blocParent');
    const parentSelect = document.getElementById('parent_id');

    function actualiserChamps() {
        const estParent = roleSelect.value === 'Parent';

        blocParent.style.display = estParent ? 'block' : 'none';
        parentSelect.required = estParent;

        if (!estParent) {
            parentSelect.value = '';
        }
    }

    roleSelect.addEventListener('change', actualiserChamps);
    actualiserChamps();
});
</script>

@endsection