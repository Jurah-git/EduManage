<div class="row">

    <div class="col-md-6 mb-3">
        <label for="nom" class="form-label fw-bold">Nom *</label>
        <input type="text" id="nom" name="nom" class="form-control @error('nom') is-invalid @enderror"
            value="{{ old('nom', $enseignant->nom ?? '') }}" required>
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="prenom" class="form-label fw-bold">Prénom *</label>
        <input type="text" id="prenom" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
            value="{{ old('prenom', $enseignant->prenom ?? '') }}" required>
        @error('prenom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @isset($enseignant)
        @if ($enseignant->exists)
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Matricule</label>
                <input type="text" class="form-control" value="{{ $enseignant->matricule }}" readonly>
                <div class="form-text">Le matricule ne peut pas être modifié.</div>
            </div>
        @endif
    @endisset

    <div class="col-md-6 mb-3">
        <label for="sexe" class="form-label fw-bold">Sexe</label>
        <select id="sexe" name="sexe" class="form-select @error('sexe') is-invalid @enderror">
            <option value="">Choisir...</option>
            <option value="Masculin" @selected(old('sexe', $enseignant->sexe ?? '') === 'Masculin')>
                Masculin
            </option>
            <option value="Féminin" @selected(old('sexe', $enseignant->sexe ?? '') === 'Féminin')>
                Féminin
            </option>
        </select>
        @error('sexe')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="date_naissance" class="form-label fw-bold">Date de naissance</label>
        <input type="date" id="date_naissance" name="date_naissance"
            class="form-control @error('date_naissance') is-invalid @enderror"
            value="{{ old('date_naissance', isset($enseignant) && $enseignant->date_naissance ? $enseignant->date_naissance->format('Y-m-d') : '') }}">
        @error('date_naissance')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="telephone" class="form-label fw-bold">Téléphone</label>
        <input type="text" id="telephone" name="telephone"
            class="form-control @error('telephone') is-invalid @enderror"
            value="{{ old('telephone', $enseignant->telephone ?? '') }}">
        @error('telephone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="email" class="form-label fw-bold">Adresse e-mail</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $enseignant->email ?? '') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="diplome" class="form-label fw-bold">Diplôme</label>
        <input type="text" id="diplome" name="diplome" class="form-control @error('diplome') is-invalid @enderror"
            value="{{ old('diplome', $enseignant->diplome ?? '') }}" placeholder="Ex. : Licence, Master...">
        @error('diplome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="specialite" class="form-label fw-bold">Spécialité</label>
        <input type="text" id="specialite" name="specialite"
            class="form-control @error('specialite') is-invalid @enderror"
            value="{{ old('specialite', $enseignant->specialite ?? '') }}" placeholder="Ex. : Mathématiques">
        @error('specialite')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="date_recrutement" class="form-label fw-bold">Date de recrutement</label>
        <input type="date" id="date_recrutement" name="date_recrutement"
            class="form-control @error('date_recrutement') is-invalid @enderror"
            value="{{ old('date_recrutement', isset($enseignant) && $enseignant->date_recrutement ? $enseignant->date_recrutement->format('Y-m-d') : '') }}">
        @error('date_recrutement')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="statut" class="form-label fw-bold">Statut *</label>
        <select id="statut" name="statut" class="form-select @error('statut') is-invalid @enderror" required>
            <option value="actif" @selected(old('statut', $enseignant->statut ?? 'actif') === 'actif')>
                Actif
            </option>
            <option value="inactif" @selected(old('statut', $enseignant->statut ?? 'actif') === 'inactif')>
                Inactif
            </option>
        </select>
        @error('statut')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mb-3">
        <label for="adresse" class="form-label fw-bold">Adresse</label>
        <textarea id="adresse" name="adresse" rows="3" class="form-control @error('adresse') is-invalid @enderror">{{ old('adresse', $enseignant->adresse ?? '') }}</textarea>
        @error('adresse')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="photo" class="form-label fw-bold">Photo de l'enseignant</label>
        <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp"
            class="form-control @error('photo') is-invalid @enderror">
        <div class="form-text">Formats JPG, PNG ou WEBP — 2 Mo maximum.</div>
        @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if (isset($enseignant) && $enseignant->photo)
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold d-block">Photo actuelle</label>
            <img src="{{ asset('storage/' . $enseignant->photo) }}"
                alt="Photo de {{ $enseignant->prenom }} {{ $enseignant->nom }}" class="rounded-circle border"
                width="100" height="100" style="object-fit: cover;">
            <div class="form-text">Sélectionne une nouvelle photo pour la remplacer.</div>
        </div>
    @endif

</div>
