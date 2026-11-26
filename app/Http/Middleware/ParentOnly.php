<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParentOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Vérifier que l'utilisateur est connecté.
        if (! $user) {
            abort(403, 'Vous devez être connecté.');
        }

        // Vérifier que l'utilisateur possède une fiche parent.
        if (! $user->parentEleve) {
            abort(403, 'Accès réservé aux comptes parents.');
        }

        return $next($request);
    }
}
