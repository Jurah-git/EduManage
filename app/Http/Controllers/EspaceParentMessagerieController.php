<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class EspaceParentMessagerieController extends Controller
{
    /**
     * Afficher la conversation du parent connecté.
     */
    public function index(Request $request)
    {
        $parent = $request->user()->parentEleve;

        abort_unless($parent, 403, 'Accès réservé aux parents.');

        // Une seule conversation par parent.
        $conversation = Conversation::firstOrCreate([
            'parent_id' => $parent->id,
        ]);

        // Marquer comme lus les messages reçus.
        $conversation->messages()
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        // Charger les messages et leurs expéditeurs.
        $messages = $conversation->messages()
            ->with('expediteur')
            ->orderBy('created_at')
            ->get();

        return view('parent.messagerie.index', compact(
            'conversation',
            'messages'
        ));
    }

    /**
     * Envoyer un message à l'administration.
     */
    public function envoyer(Request $request)
    {
        $request->validate([
            'contenu' => [
                'required',
                'string',
                'min:1',
                'max:3000',
            ],
        ]);

        $parent = $request->user()->parentEleve;

        abort_unless($parent, 403, 'Accès réservé aux parents.');

        $conversation = Conversation::firstOrCreate([
            'parent_id' => $parent->id,
        ]);

        $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'contenu' => $request->contenu,
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        return redirect()
            ->route('parent.messagerie.index')
            ->with('success', 'Votre message a été envoyé.');
    }
}
