@csrf

<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Nom de la salle <span class="text-danger">*</span></label>
        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
            value="{{ old('nom', $salle->nom ?? '') }}" placeholder="Ex. Salle A1" required>
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Capacité (nombre d'élèves) <span class="text-danger">*</span></label>
        <input type="number" name="capacite" min="1" max="10000"
            class="form-control @error('capacite') is-invalid @enderror"
            value="{{ old('capacite', $salle->capacite ?? 40) }}" required>
        @error('capacite')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Bâtiment</label>
        <input type="text" name="batiment" class="form-control @error('batiment') is-invalid @enderror"
            value="{{ old('batiment', $salle->batiment ?? '') }}" placeholder="Ex. Bâtiment A">
        @error('batiment')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Étage</label>
        <input type="text" name="etage" class="form-control @error('etage') is-invalid @enderror"
            value="{{ old('etage', $salle->etage ?? '') }}" placeholder="Ex. Rez-de-chaussée">
        @error('etage')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Type de salle <span class="text-danger">*</span></label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            @foreach (['Ordinaire', 'Laboratoire', 'Informatique', 'Autre'] as $type)
                <option value="{{ $type }}" @selected(old('type', $salle->type ?? 'Ordinaire') === $type)>
                    {{ $type }}
                </option>
            @endforeach
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Statut <span class="text-danger">*</span></label>
        <select name="statut" class="form-select @error('statut') is-invalid @enderror" required>
            @foreach (['Disponible', 'Maintenance', 'Indisponible'] as $statut)
                <option value="{{ $statut }}" @selected(old('statut', $salle->statut ?? 'Disponible') === $statut)>
                    {{ $statut }}
                </option>
            @endforeach
        </select>
        @error('statut')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
            placeholder="Informations complémentaires sur la salle">{{ old('description', $salle->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('salles.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-x-circle me-1"></i> Annuler
    </a>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i> {{ $bouton ?? 'Enregistrer' }}
    </button>
</div>
