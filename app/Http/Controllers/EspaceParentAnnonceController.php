<?php
namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class EspaceParentAnnonceController extends Controller
{
    /**
     * Liste des annonces publiées accessibles aux parents.
     */
    public function index()
    {
        $annonces = Annonce::query()
            ->where('statut', 'publie')
            ->whereIn('public_cible', ['tous', 'parents'])
            ->whereNotNull('date_publication')
            ->where('date_publication', '<=', now())
            ->orderByDesc('date_publication')
            ->paginate(10);

        return view('parent.annonces.index', compact('annonces'));
    }

    /**
     * Lire une annonce publiée.
     */
    public function show(Annonce $annonce)
    {
        abort_unless(
            $annonce->statut === 'publie'
            && in_array($annonce->public_cible, ['tous', 'parents'], true)
            && $annonce->date_publication !== null
            && $annonce->date_publication->lte(now()),
            404
        );
        $parent = request()->user()->parentEleve;

abort_unless($parent, 403, 'Accès réservé aux parents.');

\App\Models\AnnonceParentLue::updateOrCreate(
    [
        'annonce_id' => $annonce->id,
        'parent_id' => $parent->id,
    ],
    [
        'read_at' => now(),
    ]
);

        return view('parent.annonces.show', compact('annonce'));
    }
}
