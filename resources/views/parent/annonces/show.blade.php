
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('parent.annonces.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Retour aux annonces
        </a>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4 p-lg-5">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                    {{ ucfirst($annonce->categorie) }}
                </span>

                <span class="badge bg-success">
                    <i class="bi bi-check-circle me-1"></i>
                    Publiée
                </span>

            </div>

            <h2 class="fw-bold mb-3">
                {{ $annonce->titre }}
            </h2>

            <div class="text-muted mb-4">
                <i class="bi bi-calendar3 me-1"></i>
                Publiée le
                {{ $annonce->date_publication?->format('d/m/Y à H:i') ?? 'Date non disponible' }}
            </div>

            <hr>

            <div class="py-3" style="line-height: 1.9; white-space: pre-line;">
                {{ $annonce->contenu }}
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">

                <small class="text-muted">
                    <i class="bi bi-building me-1"></i>
                    Communication officielle de l'école
                </small>

                <a href="{{ route('parent.annonces.index') }}"
                   class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour à la liste
                </a>

            </div>

        </div>
    </div>

</div>

@endsection
