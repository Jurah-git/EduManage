 @extends('layouts.app')

 @section('content')
     <div class="container-fluid py-4">

         {{-- En-tête --}}
         <div class="d-flex justify-content-between align-items-center mb-4">
             <div>
                 <h3 class="fw-bold mb-1">🧾 Reçus de paiement</h3>
                 <p class="text-muted mb-0">
                     Liste des reçus émis pour les paiements enregistrés.
                 </p>
             </div>
         </div>

         {{-- Recherche --}}
         <div class="card shadow-sm border-0 mb-4">
             <div class="card-body">
                 <form method="GET" action="{{ route('frais.recus.index') }}">
                     <div class="row g-2">
                         <div class="col-md-9">
                             <input type="text" name="recherche" class="form-control"
                                 placeholder="Rechercher par numéro de reçu, paiement, nom ou matricule..."
                                 value="{{ request('recherche') }}">
                         </div>

                         <div class="col-md-3 d-flex gap-2">
                             <button type="submit" class="btn btn-primary flex-fill">
                                 <i class="bi bi-search"></i> Rechercher
                             </button>

                             <a href="{{ route('frais.recus.index') }}" class="btn btn-outline-secondary">
                                 Réinitialiser
                             </a>
                         </div>
                     </div>
                 </form>
             </div>
         </div>

         {{-- Tableau des reçus --}}
         <div class="card shadow-sm border-0">
             <div class="card-header bg-white py-3">
                 <div class="d-flex justify-content-between align-items-center">
                     <h5 class="mb-0 fw-bold">Historique des reçus</h5>
                     <span class="badge bg-primary">
                         {{ $recus->total() }} reçu(s)
                     </span>
                 </div>
             </div>

             <div class="card-body p-0">
                 <div class="table-responsive">
                     <table class="table table-hover align-middle mb-0">
                         <thead class="table-light">
                             <tr>
                                 <th class="ps-3">N° Reçu</th>
                                 <th>Élève</th>
                                 <th>Matricule</th>
                                 <th>N° Paiement</th>
                                 <th>Date d'émission</th>
                                 <th>Montant payé</th>
                                 <th>Mode</th>
                                 <th>Statut</th>
                                 <th class="text-center">Action</th>
                             </tr>
                         </thead>

                         <tbody>
                             @forelse($recus as $recu)
                                 @php
                                     $paiement = $recu->paiement;
                                     $eleve = $paiement?->eleve;
                                 @endphp

                                 <tr>
                                     <td class="ps-3">
                                         <span class="fw-bold text-primary">
                                             {{ $recu->numero_recu }}
                                         </span>
                                     </td>

                                     <td>
                                         @if ($eleve)
                                             {{ $eleve->nom }} {{ $eleve->prenom }}
                                         @else
                                             <span class="text-muted">Élève introuvable</span>
                                         @endif
                                     </td>

                                     <td>
                                         {{ $eleve?->matricule ?? '—' }}
                                     </td>

                                     <td>
                                         {{ $paiement?->numero_paiement ?? '—' }}
                                     </td>

                                     <td>
                                         {{ $recu->date_emission?->format('d/m/Y H:i') ?? '—' }}
                                     </td>

                                     <td class="fw-bold">
                                         {{ number_format((float) ($paiement?->montant_total ?? 0), 0, ',', ' ') }} Ar
                                     </td>

                                     <td>
                                         {{ $paiement?->mode_paiement === 'especes' ? 'Espèces' : $paiement?->mode_paiement ?? '—' }}
                                     </td>

                                     <td>
                                         @if ($paiement?->statut === 'valide')
                                             <span class="badge bg-success">Validé</span>
                                         @elseif($paiement?->statut === 'annule')
                                             <span class="badge bg-danger">Annulé</span>
                                         @else
                                             <span class="badge bg-secondary">Inconnu</span>
                                         @endif
                                     </td>

                                     <td class="text-center">
                                         @if ($paiement && $paiement->statut === 'valide')
                                             @if (auth()->user()->aPermission('frais.recus_imprimer'))
                                                 <a href="{{ route('frais.recus.imprimer', $recu) }}" 
                                                     class="btn btn-sm btn-outline-primary"
                                                     title="Afficher et imprimer le reçu">
                                                     <i class="bi bi-printer"></i> Imprimer
                                                 </a>
                                             @else
                                                 <span class="text-muted">Non autorisé</span>
                                             @endif
                                         @else
                                             <span class="text-muted">Indisponible</span>
                                         @endif
                                     </td>
                                 </tr>
                             @empty
                                 <tr>
                                     <td colspan="9" class="text-center py-5">
                                         <div class="text-muted">
                                             <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                                             <h6>Aucun reçu trouvé</h6>
                                             <p class="mb-0">
                                                 Les reçus seront affichés ici après validation des paiements.
                                             </p>
                                         </div>
                                     </td>
                                 </tr>
                             @endforelse
                         </tbody>
                     </table>
                 </div>
             </div>

             @if ($recus->hasPages())
                 <div class="card-footer bg-white">
                     {{ $recus->links() }}
                 </div>
             @endif
         </div>

     </div>
 @endsection
