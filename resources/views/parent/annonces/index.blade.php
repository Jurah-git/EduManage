 @extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- EN-TÊTE --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-megaphone-fill me-2 text-warning"></i>
                Annonces et communications
            </h2>
            <p class="text-muted mb-0">
                Retrouvez les informations et communications de votre établissement.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge rounded-pill bg-primary px-3 py-2">
                {{ $annonces->total() }} annonce(s)
            </span>
        </div>
    </div>

    {{-- LISTE DES ANNONCES --}}
    @forelse($annonces as $annonce)

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">

                    <div>
                        @php
                            $couleurs = [
                                'information' => 'primary',
                                'evenement' => 'success',
                                'reunion' => 'warning',
                                'urgence' => 'danger',
                                'autre' => 'secondary',
                            ];

                            $categorie = strtolower($annonce->categorie ?? 'autre');
                            $couleur = $couleurs[$categorie] ?? 'secondary';
                        @endphp

                        <span class="badge bg-{{ $couleur }} rounded-pill px-3 py-2">
                            {{ ucfirst($annonce->categorie ?? 'Information') }}
                        </span>
                    </div>

                    <small class="text-muted">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $annonce->date_publication?->format('d/m/Y à H:i') ?? $annonce->created_at?->format('d/m/Y') }}
                    </small>

                </div>

                <h4 class="fw-bold mb-2">
                    {{ $annonce->titre }}
                </h4>

                <p class="text-muted mb-3">
                    {{ \Illuminate\Support\Str::limit(strip_tags($annonce->contenu), 220) }}
                </p>

                <a href="{{ route('parent.annonces.show', $annonce->id) }}"
                   class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-eye me-2"></i>
                    Lire l'annonce
                </a>

            </div>
        </div>

    @empty

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">

                <div class="mb-3">
                    <i class="bi bi-megaphone text-muted" style="font-size: 3.5rem;"></i>
                </div>

                <h4 class="fw-bold">Aucune annonce disponible</h4>

                <p class="text-muted mb-0">
                    Les nouvelles communications de l'école apparaîtront ici.
                </p>

            </div>
        </div>

    @endforelse

    {{-- PAGINATION --}}
    @if($annonces->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $annonces->links() }}
        </div>
    @endif

</div>

@endsection