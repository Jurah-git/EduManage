
@extends('layouts.app')

@section('content')

<div class="classe-create-page">

    {{-- EN-TÊTE --}}
    <div class="classe-hero">

        <div class="classe-hero-content">
            <div class="classe-hero-icon">
                <i class="fas fa-school"></i>
            </div>

            <div>
                <span class="classe-eyebrow">GESTION SCOLAIRE</span>
                <h2>Créer une nouvelle classe</h2>
                <p>Configurez une nouvelle classe pour votre établissement.</p>
            </div>
        </div>

        <a href="{{ route('classes.index') }}" class="classe-back-btn">
            <i class="fas fa-arrow-left"></i>
            Retour aux classes
        </a>

    </div>

    {{-- FIL D'ARIANE --}}
    <div class="classe-breadcrumb">
        <i class="fas fa-home"></i>
        <span>Accueil</span>
        <i class="fas fa-chevron-right"></i>
        <span>Classes</span>
        <i class="fas fa-chevron-right"></i>
        <strong>Nouvelle classe</strong>
    </div>

    {{-- MESSAGES D'ERREUR --}}
    @if ($errors->any())
        <div class="classe-alert">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Vérifiez les informations saisies.</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="classe-create-grid">

        {{-- FORMULAIRE --}}
        <div class="classe-form-card">

            <div class="classe-card-heading">
                <div class="classe-heading-icon">
                    <i class="fas fa-edit"></i>
                </div>

                <div>
                    <h4>Informations de la classe</h4>
                    <p>Renseignez les informations nécessaires.</p>
                </div>

                <span class="classe-required">
                    <span></span> Champ obligatoire
                </span>
            </div>

            <div class="classe-form-body">

                <div class="classe-step">
                    <span class="classe-step-number">01</span>
                    <div>
                        <strong>Identification</strong>
                        <p>Définissez le nom de votre classe.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('classes.store') }}">
                    @csrf

                    <div class="classe-input-group">

                        <label for="nom">
                            Nom de la classe
                            <span class="text-danger">*</span>
                        </label>

                        <div class="classe-input-wrapper">
                            <div class="classe-input-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>

                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                class="classe-input @error('nom') is-invalid @enderror"
                                placeholder="Exemple : 6ème A, Terminale C..."
                                value="{{ old('nom') }}"
                                maxlength="100"
                                required
                                autofocus
                                autocomplete="off"
                            >
                        </div>

                        @error('nom')
                            <div class="classe-field-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="classe-input-help">
                            <i class="fas fa-info-circle"></i>
                            Choisissez un nom clair et facilement identifiable.
                        </small>

                    </div>

                    <div class="classe-tip">
                        <div class="classe-tip-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>

                        <div>
                            <strong>Conseil</strong>
                            <p>
                                Utilisez une nomenclature cohérente pour faciliter
                                l'organisation des élèves et le suivi pédagogique.
                            </p>
                        </div>
                    </div>

                    <div class="classe-form-footer">

                        <a href="{{ route('classes.index') }}"
                           class="classe-cancel-btn">
                            Annuler
                        </a>

                        <button type="submit" class="classe-submit-btn">
                            <i class="fas fa-check-circle"></i>
                            Enregistrer la classe
                        </button>

                    </div>

                </form>

            </div>
        </div>

        {{-- APERÇU --}}
        <div class="classe-preview-column">

            <div class="classe-preview-card">

                <div class="classe-preview-header">
                    <div>
                        <span>APERÇU EN DIRECT</span>
                        <h5>Votre nouvelle classe</h5>
                    </div>

                    <div class="classe-live-indicator">
                        <span></span> Live
                    </div>
                </div>

                <div class="classe-preview-content">

                    <div class="classe-preview-illustration">
                        <div class="classe-preview-circle">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="classe-preview-decoration decoration-one"></div>
                        <div class="classe-preview-decoration decoration-two"></div>
                    </div>

                    <span class="classe-preview-label">NOM DE LA CLASSE</span>

                    <h3 id="previewNom">
                        {{ old('nom') ?: 'Nom de votre classe' }}
                    </h3>

                    <div class="classe-preview-divider"></div>

                    <div class="classe-preview-info">

                        <div class="classe-info-item">
                            <div class="classe-info-icon blue">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <small>Effectif</small>
                                <strong>0 élève</strong>
                            </div>
                        </div>

                        <div class="classe-info-item">
                            <div class="classe-info-icon purple">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <small>Statut</small>
                                <strong>Nouvelle classe</strong>
                            </div>
                        </div>

                    </div>

                    <div class="classe-preview-note">
                        <i class="fas fa-info-circle"></i>
                        Cet aperçu est une simulation. Les informations définitives
                        seront enregistrées après validation.
                    </div>

                </div>
            </div>

            {{-- AIDE --}}
            <div class="classe-help-card">
                <div class="classe-help-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>

                <div>
                    <strong>Création sécurisée</strong>
                    <p>
                        Les informations seront soumises à la validation
                        de votre application avant leur enregistrement.
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

<style>
.classe-create-page {
    padding: 22px 25px 35px;
    color: #263449;
}

/* HERO */
.classe-hero {
    background: linear-gradient(115deg, #173b70, #2466a7 65%, #288b9c);
    border-radius: 18px;
    padding: 27px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    color: white;
    box-shadow: 0 9px 25px rgba(26, 74, 125, .17);
}

.classe-hero-content {
    display: flex;
    align-items: center;
    gap: 18px;
}

.classe-hero-icon {
    width: 62px;
    height: 62px;
    border-radius: 17px;
    background: rgba(255,255,255,.16);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 27px;
    border: 1px solid rgba(255,255,255,.2);
}

.classe-eyebrow {
    font-size: 10px;
    letter-spacing: 2px;
    font-weight: 800;
    opacity: .75;
}

.classe-hero h2 {
    font-size: 24px;
    font-weight: 800;
    margin: 4px 0;
}

.classe-hero p {
    margin: 0;
    color: rgba(255,255,255,.78);
    font-size: 13px;
}

.classe-back-btn {
    padding: 11px 16px;
    border: 1px solid rgba(255,255,255,.35);
    border-radius: 10px;
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: .25s;
    white-space: nowrap;
}

.classe-back-btn:hover {
    background: white;
    color: #1d568d;
}

/* BREADCRUMB */
.classe-breadcrumb {
    display: flex;
    align-items: center;
    gap: 11px;
    margin: 21px 0;
    font-size: 12px;
    color: #8491a3;
}

.classe-breadcrumb i {
    font-size: 10px;
}

.classe-breadcrumb strong {
    color: #2466a7;
}

/* GRID */
.classe-create-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.55fr) minmax(290px, .85fr);
    gap: 23px;
    align-items: start;
}

/* FORM CARD */
.classe-form-card,
.classe-preview-card {
    background: white;
    border: 1px solid #e9eef5;
    border-radius: 17px;
    box-shadow: 0 5px 22px rgba(31, 55, 85, .055);
    overflow: hidden;
}

.classe-card-heading {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 23px 25px;
    border-bottom: 1px solid #edf0f5;
}

.classe-heading-icon {
    width: 43px;
    height: 43px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eaf2fc;
    color: #2868aa;
    font-size: 18px;
}

.classe-card-heading h4 {
    font-size: 16px;
    font-weight: 800;
    margin: 0 0 4px;
}

.classe-card-heading p {
    margin: 0;
    color: #8995a6;
    font-size: 12px;
}

.classe-required {
    margin-left: auto;
    font-size: 10px;
    color: #8491a3;
    white-space: nowrap;
}

.classe-required span,
.classe-live-indicator span {
    display: inline-block;
    width: 7px;
    height: 7px;
    background: #e05252;
    border-radius: 50%;
    margin-right: 4px;
}

.classe-form-body {
    padding: 27px;
}

.classe-step {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 29px;
}

.classe-step-number {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    background: #edf4ff;
    color: #2868aa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 12px;
}

.classe-step strong {
    font-size: 13px;
    display: block;
}

.classe-step p {
    font-size: 11px;
    color: #8a96a6;
    margin: 3px 0 0;
}

/* INPUT */
.classe-input-group {
    margin-bottom: 23px;
}

.classe-input-group label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #35445a;
}

.classe-input-wrapper {
    display: flex;
    align-items: center;
    border: 1.5px solid #dfe6ef;
    border-radius: 11px;
    background: #fbfcfe;
    overflow: hidden;
    transition: .25s;
}

.classe-input-wrapper:focus-within {
    border-color: #4387cb;
    background: white;
    box-shadow: 0 0 0 4px rgba(67,135,203,.10);
}

.classe-input-icon {
    width: 49px;
    display: flex;
    justify-content: center;
    color: #8294aa;
}

.classe-input {
    width: 100%;
    height: 51px;
    border: none;
    outline: none;
    background: transparent;
    padding: 0 13px 0 0;
    font-size: 13px;
    color: #273a52;
}

.classe-input::placeholder {
    color: #aab5c3;
}

.classe-input.is-invalid {
    color: #dc3545;
}

.classe-field-error {
    color: #dc3545;
    font-size: 11px;
    margin-top: 8px;
}

.classe-input-help {
    display: block;
    color: #94a0b0;
    font-size: 11px;
    margin-top: 10px;
}

.classe-input-help i {
    margin-right: 4px;
    color: #4685c2;
}

/* TIP */
.classe-tip {
    display: flex;
    gap: 13px;
    padding: 16px;
    background: #f0f6ff;
    border: 1px solid #e0ebfa;
    border-radius: 12px;
    margin-top: 28px;
}

.classe-tip-icon {
    color: #e7a52d;
    font-size: 20px;
}

.classe-tip strong {
    font-size: 12px;
    color: #315d91;
}

.classe-tip p {
    margin: 5px 0 0;
    font-size: 11px;
    color: #71839b;
    line-height: 1.6;
}

/* FOOTER */
.classe-form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 11px;
    padding-top: 25px;
    margin-top: 26px;
    border-top: 1px solid #edf0f5;
}

.classe-cancel-btn,
.classe-submit-btn {
    border-radius: 10px;
    padding: 12px 18px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: .25s;
    cursor: pointer;
}

.classe-cancel-btn {
    background: #f2f4f7;
    color: #637184;
}

.classe-cancel-btn:hover {
    background: #e5e9ef;
    color: #35445a;
}

.classe-submit-btn {
    border: none;
    color: white;
    background: linear-gradient(110deg, #2465a8, #3189b0);
    box-shadow: 0 5px 13px rgba(37, 105, 168, .2);
}

.classe-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37, 105, 168, .28);
}

/* PREVIEW */
.classe-preview-column {
    display: flex;
    flex-direction: column;
    gap: 17px;
}

.classe-preview-header {
    padding: 20px 21px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #edf0f5;
}

.classe-preview-header span {
    color: #8190a4;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 1.5px;
}

.classe-preview-header h5 {
    font-size: 15px;
    font-weight: 800;
    margin: 5px 0 0;
}

.classe-live-indicator {
    background: #e9f8f0;
    color: #26935d;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
}

.classe-live-indicator span {
    background: #2db777;
}

.classe-preview-content {
    padding: 23px;
}

.classe-preview-illustration {
    height: 140px;
    background: linear-gradient(135deg, #eaf3ff, #e9f8f7);
    border-radius: 14px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    margin-bottom: 24px;
}

.classe-preview-circle {
    width: 82px;
    height: 82px;
    background: white;
    color: #3179b5;
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    box-shadow: 0 9px 25px rgba(49, 121, 181, .13);
    z-index: 1;
}

.classe-preview-decoration {
    position: absolute;
    border-radius: 50%;
    background: rgba(67, 143, 194, .10);
}

.decoration-one {
    width: 120px;
    height: 120px;
    left: -30px;
    bottom: -65px;
}

.decoration-two {
    width: 90px;
    height: 90px;
    right: -15px;
    top: -35px;
}

.classe-preview-label {
    font-size: 9px;
    letter-spacing: 1.5px;
    color: #96a2b1;
    font-weight: 800;
}

.classe-preview-content h3 {
    font-size: 23px;
    font-weight: 800;
    color: #253c59;
    margin: 8px 0 19px;
    overflow-wrap: anywhere;
}

.classe-preview-divider {
    height: 1px;
    background: #edf0f5;
    margin-bottom: 19px;
}

.classe-preview-info {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.classe-info-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.classe-info-icon {
    width: 39px;
    height: 39px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.classe-info-icon.blue {
    color: #3279b7;
    background: #eaf3fc;
}

.classe-info-icon.purple {
    color: #8565bd;
    background: #f1edfb;
}

.classe-info-item small {
    display: block;
    font-size: 10px;
    color: #95a0ae;
    margin-bottom: 3px;
}

.classe-info-item strong {
    font-size: 12px;
    color: #35445a;
}

.classe-preview-note {
    margin-top: 23px;
    padding: 12px;
    background: #f7f9fc;
    border-radius: 9px;
    color: #8996a7;
    font-size: 10px;
    line-height: 1.6;
}

.classe-preview-note i {
    color: #4786c1;
    margin-right: 5px;
}

/* HELP */
.classe-help-card {
    display: flex;
    gap: 13px;
    padding: 17px;
    background: white;
    border: 1px solid #e9eef5;
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(31,55,85,.04);
}

.classe-help-icon {
    width: 39px;
    height: 39px;
    background: #eaf8f1;
    color: #2d9b68;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    flex-shrink: 0;
}

.classe-help-card strong {
    font-size: 12px;
}

.classe-help-card p {
    color: #8996a7;
    font-size: 10px;
    line-height: 1.6;
    margin: 5px 0 0;
}

/* ALERT */
.classe-alert {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    background: #fff1f0;
    color: #b93832;
    border: 1px solid #f6d2cf;
    border-radius: 11px;
    padding: 15px 18px;
    margin-bottom: 20px;
    font-size: 12px;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .classe-create-grid {
        grid-template-columns: 1fr;
    }

    .classe-preview-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: start;
    }
}

@media (max-width: 600px) {
    .classe-create-page {
        padding: 13px;
    }

    .classe-hero {
        align-items: flex-start;
        flex-direction: column;
        padding: 21px;
    }

    .classe-hero h2 {
        font-size: 19px;
    }

    .classe-hero-icon {
        width: 49px;
        height: 49px;
        font-size: 21px;
    }

    .classe-preview-column {
        display: flex;
    }

    .classe-card-heading {
        flex-wrap: wrap;
        padding: 18px;
    }

    .classe-required {
        width: 100%;
        margin-left: 56px;
    }

    .classe-form-body {
        padding: 19px;
    }

    .classe-form-footer {
        flex-direction: column-reverse;
    }

    .classe-cancel-btn,
    .classe-submit-btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const inputNom = document.getElementById('nom');
    const previewNom = document.getElementById('previewNom');

    if (inputNom && previewNom) {

        function actualiserApercu() {
            const nom = inputNom.value.trim();

            previewNom.textContent = nom || 'Nom de votre classe';
        }

        inputNom.addEventListener('input', actualiserApercu);

        actualiserApercu();
    }

});
</script>

@endsection
