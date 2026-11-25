 @extends('layouts.app')

 @section('content')
     @php
         $paiement = $recu->paiement;
         $eleve = $paiement->eleve;
         $ecole = $ecole ?? null;
     @endphp

     <div class="container py-4">

         {{-- Boutons --}}
         <div class="d-flex justify-content-between align-items-center mb-4 no-print">
             <a href="{{ route('frais.recus.index') }}" class="btn btn-outline-secondary">
                 <i class="bi bi-arrow-left"></i> Retour aux reçus
             </a>

             <button onclick="ouvrirImpression()" class="btn btn-primary">
                 <i class="bi bi-printer"></i> Imprimer le reçu
             </button>
         </div>

         {{-- Reçu --}}
         <div class="receipt-container mx-auto">

             {{-- En-tête établissement --}}
             <div class="receipt-header">
                 <div class="school-info">
                     @if ($ecole && !empty($ecole->logo))
                         <img src="{{ asset('storage/' . $ecole->logo) }}" alt="Logo de l'établissement"
                             class="school-logo">
                     @endif

                     <div class="school-info">


                         <div>
                             <h3>{{ $ecole->nom_ecole ?? 'Nom de votre école' }}</h3>

                             @if (!empty($ecole->adresse))
                                 <p>{{ $ecole->adresse }}</p>
                             @endif

                             @if (!empty($ecole->telephone))
                                 <p>Tél : {{ $ecole->telephone }}</p>
                             @endif

                             @if (!empty($ecole->email))
                                 <p>{{ $ecole->email }}</p>
                             @endif
                         </div>
                     </div>
                 </div>

                 <div class="receipt-title">
                     <h2>REÇU DE PAIEMENT</h2>
                     <p>N° {{ $recu->numero_recu }}</p>
                 </div>
             </div>

             <hr>

             {{-- Informations du reçu --}}
             <div class="row mb-2">
                 <div class="col-md-6">
                     <h6 class="section-title">INFORMATIONS DE L'ÉLÈVE</h6>

                     <p><strong>Nom et prénom :</strong>
                         {{ $eleve->nom ?? '' }} {{ $eleve->prenom ?? '' }}
                     </p>

                     <p><strong>Matricule :</strong>
                         {{ $eleve->matricule ?? '—' }}
                     </p>

                     <p><strong>Classe :</strong>
                         {{ $eleve->classe?->nom ?? '—' }}
                     </p>
                 </div>

                 <div class="col-md-6">
                     <h6 class="section-title">INFORMATIONS DU PAIEMENT</h6>

                     <p><strong>N° paiement :</strong>
                         {{ $paiement->numero_paiement }}
                     </p>

                     <p><strong>Date du paiement :</strong>
                         {{ $paiement->date_paiement?->format('d/m/Y H:i') ?? '—' }}
                     </p>

                     <p><strong>Date d'émission :</strong>
                         {{ $recu->date_emission?->format('d/m/Y H:i') ?? '—' }}
                     </p>

                     <p><strong>Mode de paiement :</strong>
                         {{ $paiement->mode_paiement === 'especes' ? 'Espèces' : $paiement->mode_paiement }}
                     </p>

                     <p><strong>Caissier :</strong>
                         {{ $paiement->utilisateur?->name ?? '—' }}
                     </p>
                 </div>
             </div>


             {{-- Détail des frais --}}
             <h6 class="section-title">DÉTAIL DES FRAIS PAYÉS</h6>

             <div class="table-responsive">
                 <table class="table table-bordered receipt-table">
                     <thead>
                         <tr>
                             <th>Désignation</th>
                             <th>Période</th>
                             <th class="text-end">Montant dû</th>
                             <th class="text-end">Payé sur ce reçu</th>
                             <th class="text-end">Reste à payer</th>
                         </tr>
                     </thead>

                     <tbody>
                         @foreach ($paiement->details as $detail)
                             @php
                                 $frais = $detail->eleveFrais;

                                 // Total de tous les paiements validés pour ce frais.
                                 $totalDejaPaye = $frais
                                     ? $frais
                                         ->detailsPaiements()
                                         ->whereHas('paiement', function ($query) {
                                             $query->where('statut', 'valide');
                                         })
                                         ->sum('montant_paye')
                                     : 0;

                                 $montantDu = (float) ($frais?->montant_du ?? 0);

                                 $resteAPayer = max(0, $montantDu - (float) $totalDejaPaye);
                             @endphp

                             <tr>
                                 <td>
                                     {{ $frais?->libelle ?? 'Frais scolaire' }}

                                     @if ($frais?->tarifFrais?->typeFrais)
                                         <br>
                                         <small class="text-muted">
                                             {{ $frais->tarifFrais->typeFrais->nom }}
                                         </small>
                                     @endif
                                 </td>

                                 <td>
                                     @if ($frais)
                                         {{ $frais->mois
                                             ? ucfirst(\Carbon\Carbon::create()->month((int) $frais->mois)->locale('fr')->monthName) . ' ' . $frais->annee
                                             : $frais->cle_periode ?? '—' }}
                                     @else
                                         —
                                     @endif
                                 </td>

                                 <td class="text-end">
                                     {{ number_format($montantDu, 0, ',', ' ') }} Ar
                                 </td>

                                 <td class="text-end fw-bold">
                                     {{ number_format((float) $detail->montant_paye, 0, ',', ' ') }} Ar
                                 </td>

                                 <td class="text-end fw-bold">
                                     @if ($resteAPayer > 0)
                                         <span class="text-danger">
                                             {{ number_format($resteAPayer, 0, ',', ' ') }} Ar
                                         </span>
                                         <br>
                                         <small class="text-danger">Partiel</small>
                                     @else
                                         <span class="text-success">0 Ar</span>
                                         <br>
                                         <small class="text-success">Soldé</small>
                                     @endif
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>

                     <tfoot>
                         <tr>
                             <th colspan="3" class="text-end">TOTAL ENCAISSÉ</th>
                             <th class="text-end">
                                 {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ar
                             </th>
                             <th></th>
                         </tr>
                     </tfoot>
                 </table>
             </div>


             {{-- Observations --}}
             @if ($recu->observations || $paiement->observations)
                 <div class="observations mt-3">
                     <strong>Observations :</strong>
                     {{ $recu->observations ?? $paiement->observations }}
                 </div>
             @endif

             <div class="amount-words mt-4">
                 <strong>Montant reçu :</strong>
                 {{ number_format((float) $paiement->montant_total, 0, ',', ' ') }} Ariary
             </div>

             {{-- Signatures --}}
             <div class="row signatures mt-3">
                 <div class="col-6 text-center">
                     <strong>Signature du caissier</strong>
                     <div class="signature-line"></div>
                     <small>{{ $paiement->utilisateur?->name ?? '' }}</small>
                 </div>

                 <div class="col-6 text-center">
                     <strong>Signature du responsable</strong>
                     <div class="signature-line"></div>
                 </div>
             </div>

             <div class="receipt-footer mt-5">
                 <p>Merci de votre confiance.</p>
                 <small>Document généré par EduManage</small>
             </div>

         </div>
     </div>

     <style>
         .receipt-container {
             max-width: 900px;
             background: white;
             padding: 40px;
             border: 1px solid #ddd;
             box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
             color: #222;
         }

         .receipt-header {
             display: flex;
             justify-content: space-between;
             align-items: center;
             gap: 20px;
         }

         .school-info {
             display: flex;
             align-items: center;
             gap: 15px;
         }

         .school-info h3 {
             font-size: 22px;
             font-weight: 800;
             margin-bottom: 8px;
         }

         .school-info p {
             margin: 2px 0;
             font-size: 13px;
         }

         .school-logo {
             width: 85px;
             height: 85px;
             object-fit: contain;
         }

         .receipt-title {
             text-align: right;
         }

         .receipt-title h2 {
             font-size: 20px;
             font-weight: 800;
             color: #24476b;
         }

         .receipt-title p {
             font-weight: 700;
             font-size: 14px;
         }

         .section-title {
             font-weight: 800;
             color: #24476b;
             border-bottom: 2px solid #24476b;
             padding-bottom: 7px;
             margin-bottom: 12px;
         }

         .receipt-container .row p {
             margin-bottom: 8px;
             font-size: 14px;
         }

         .receipt-table th {
             background: #eef2f6;
         }

         .receipt-table td,
         .receipt-table th {
             padding: 12px;
             vertical-align: middle;
         }

         .observations,
         .amount-words {
             padding: 12px;
             background: #f5f7fa;
             border-radius: 5px;
         }

         .signatures {
             min-height: 110px;
         }

         .signature-line {
             border-bottom: 1px solid #555;
             margin: 65px 20px 8px;
         }

         .receipt-footer {
             text-align: center;
             border-top: 1px solid #ddd;
             padding-top: 15px;
             color: #666;
         }

         @media print {
             @page {
                 size: A4 portrait;
                 margin: 12mm;
             }

             body {
                 background: white !important;
             }

             .no-print,
             nav,
             aside,
             .sidebar,
             .topbar {
                 display: none !important;
             }

             .container {
                 max-width: 100% !important;
                 width: 100% !important;
                 padding: 0 !important;
                 margin: 0 !important;
             }

             .receipt-container {
                 max-width: 100% !important;
                 border: none !important;
                 box-shadow: none !important;
                 padding: 10px !important;
             }

             .receipt-table {
                 font-size: 12px;
             }

             .receipt-container,
             .receipt-container * {
                 -webkit-print-color-adjust: exact !important;
                 print-color-adjust: exact !important;
             }
         }

         @media screen and (max-width: 768px) {
             .receipt-container {
                 padding: 20px;
             }

             .receipt-header {
                 flex-direction: column;
                 align-items: flex-start;
             }

             .receipt-title {
                 text-align: left;
             }
         }
     </style>
     <script>
         function ouvrirImpression() {
             const contenu = document.querySelector('.receipt-container').outerHTML;

             const fenetre = window.open('', '_blank');

             if (!fenetre) {
                 alert("Veuillez autoriser les fenêtres pop-up pour imprimer le reçu.");
                 return;
             }

             fenetre.document.write(`
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Reçu de paiement</title>

            <link rel="stylesheet"
                  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

            <style>
               @page {
                    size: A4 portrait;
                    margin: 8mm;
                }

                * {
                    box-sizing: border-box;
                }

                html, body {
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 100%;
                    font-family: Arial, sans-serif;
                    font-size: 11px;
                }

                .receipt-container {
                    width: 100% !important;
                    max-width: 100% !important;
                    margin: 0 !important;
                    padding: 5px !important;
                    border: none !important;
                    box-shadow: none !important;
                }

                .receipt-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 10px;
                }

                .school-info h3 {
                    font-size: 18px;
                    margin-bottom: 5px;
                }

                .school-info p {
                    font-size: 10px;
                    margin: 1px 0;
                }

                .school-logo {
                    width: 65px;
                    height: 65px;
                }

                .receipt-title h2 {
                    font-size: 17px;
                }

                .section-title {
                    font-size: 11px;
                    margin-bottom: 7px;
                    padding-bottom: 4px;
                }

                .receipt-container .row p {
                    font-size: 11px;
                    margin-bottom: 4px;
                }

                .receipt-table {
                    width: 100%;
                    font-size: 10px;
                    margin-bottom: 5px !important;
                }

                .receipt-table th,
                .receipt-table td {
                    padding: 6px !important;
                }

                .observations,
                .amount-words {
                    padding: 7px !important;
                    margin-top: 8px !important;
                }

                .signatures {
                    margin-top: 15px !important;
                    min-height: 0 !important;
                }

                .signature-line {
                    margin-top: 35px !important;
                    margin-bottom: 5px !important;
                }

                .receipt-footer {
                    margin-top: 15px !important;
                    padding-top: 7px !important;
                }

                .receipt-container,
                .receipt-container * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                tr, .signatures, .receipt-footer {
                    break-inside: avoid;
                    page-break-inside: avoid;
                }
            </style>
        </head>

        <body>
            ${contenu}

            <script>
                window.onload = function() {
                    window.print();
                };
            <\/script>
        </body>
        </html>
    `);

             fenetre.document.close();
         }
     </script>
 @endsection
