<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class AdminMessagerieController extends Controller
{
    /**
     * Afficher toutes les conversations des parents.
     */
    public function index()
    {
        $conversations = Conversation::with([
            'parent.user',
            'dernierMessage.expediteur',
        ])
            ->withCount([
                'messages as messages_non_lus' => function ($query) {
                    $query->where('sender_id', '!=', auth()->id())
                        ->whereNull('read_at');
                },
            ])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('admin.messagerie.index', compact(
            'conversations'
        ));
    }

    /**
     * Consulter une conversation.
     */
    public function show(Conversation $conversation)
    {
        $conversation->load([
            'parent.user',
            'messages.expediteur',
        ]);

        // Marquer les messages du parent comme lus.
        $conversation->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        $messages = $conversation->messages()
            ->with('expediteur')
            ->orderBy('created_at')
            ->get();

        return view('admin.messagerie.show', compact(
            'conversation',
            'messages'
        ));
    }

    /**
     * Répondre à un parent.
     */
    public function repondre(
        Request $request,
        Conversation $conversation
    ) {
        $request->validate([
            'contenu' => [
                'required',
                'string',
                'min:1',
                'max:3000',
            ],
        ]);

        $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'contenu' => $request->contenu,
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        return redirect()
            ->route('admin.messagerie.show', $conversation)
            ->with('success', 'Votre réponse a été envoyée.');
    }
}
