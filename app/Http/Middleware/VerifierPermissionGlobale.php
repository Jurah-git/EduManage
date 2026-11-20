<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifierPermissionGlobale
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401, 'Vous devez vous connecter.');
        }

        // Accès complet pour l'administrateur principal.
        if (
            (int) $user->id === 1 ||
            $user->hasRole('Administrateur')
        ) {
            return $next($request);
        }

        $route     = $request->route();
        $routeName = $route?->getName();
        $method    = strtoupper($request->method());

        if (! $routeName) {
            abort(403, 'Cette route ne possède aucune autorisation définie.');
        }

        /*
         * Les routes d'authentification et du compte personnel
         * ne doivent pas être bloquées par les permissions métier.
         */
        $routesPubliquesPourUtilisateurConnecte = [
            'logout',
            'password.confirm',
            'password.update',
            'verification.send',
            'verification.notice',
            'verification.verify',
        ];

        if (in_array($routeName, $routesPubliquesPourUtilisateurConnecte, true)) {
            return $next($request);
        }

        // La configuration et les rôles restent réservés à l'administrateur.
        if (
            str_starts_with($routeName, 'config.') ||
            str_starts_with($routeName, 'users.')
        ) {
            abort(403, 'Cette fonctionnalité est réservée à l’administrateur.');
        }

        /*
         * Association explicite entre les noms de routes
         * et les modules de permissions.
         */
        $prefixes = [
            'eleves'        => 'eleves',
            'classes'       => 'classes',
            'matieres'      => 'matieres',
            'enseignants'   => 'enseignants',
            'bulletin'      => 'bulletins',
            'cahier'        => 'cahier_texte',
            'emplois-temps' => 'emploi_temps',
            'livres'        => 'bibliotheque',
            'biblio'        => 'bibliotheque',
            'parents'       => 'parents',
            'periodes'      => 'periodes',
            'coefficients'  => 'coefficients',
            'salles'        => 'salles',
        ];

        $module = null;

        foreach ($prefixes as $prefix => $modulePermission) {
            if (
                $routeName === $prefix ||
                str_starts_with($routeName, $prefix . '.')
            ) {
                $module = $modulePermission;
                break;
            }
        }

        if (! $module) {
            abort(403, 'Aucune permission n’est définie pour cette route.');
        }

        /*
         * Déterminer l'action à partir du nom de route et de la méthode.
         * Les opérations particulières sont traitées avant les règles générales.
         */
        $action = match (true) {
            str_ends_with($routeName, '.publier'),
            str_ends_with($routeName, '.activer'),
            str_ends_with($routeName, '.verifier')    => 'valider',

            str_ends_with($routeName, '.create')      => 'creer',
            str_ends_with($routeName, '.edit')        => 'modifier',

            $method === 'DELETE'                      => 'supprimer',
            in_array($method, ['PUT', 'PATCH'], true) => 'modifier',

            /*
             * Une requête POST n'est pas automatiquement une création.
             * Les routes personnalisées sont traitées explicitement ci-dessous.
             */
            $routeName === 'bulletin.generer',
            $routeName === 'bulletin.saisie',
            $routeName === 'bulletin.eleve',
            $routeName === 'bulletin.voirDirect',
            $routeName === 'bulletin.voirImage',
            $routeName === 'bulletin.downloadDirect',
            $routeName === 'bulletin.downloadDirectPdf',
            $routeName === 'bulletin.downloadDirectPng',
            $routeName === 'bulletin.downloadPdf',
            $routeName === 'bulletin.downloadImage',
            $routeName === 'bulletin.printDirect',
            $routeName === 'bulletin.printImage',
            $routeName === 'coefficients.edit'        => 'voir',

            $routeName === 'bulletin.store',
            $routeName === 'bulletin.saveImage',
            $routeName === 'bulletin.afficher'        => 'creer',

            $routeName === 'coefficients.save'        => 'modifier',

            $method === 'POST'                        => 'creer',

            default                                   => 'voir',
        };

        $permission = $module . '.' . $action;

        if (! $user->aPermission($permission)) {
            abort(
                403,
                'Vous n’avez pas la permission nécessaire : ' . $permission
            );
        }

        return $next($request);
    }
}