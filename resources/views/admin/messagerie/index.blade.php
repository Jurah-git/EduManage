
@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <style>
        .admin-messages .conversation-card {
            border: 0;
            border-radius: 16px;
            transition: .2s;
        }

        .admin-messages .conversation-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(0,0,0,.09) !important;
        }

        .admin-messages .avatar-parent {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #0b1933;
            color: #ffc928;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
    </style>

    <div class="admin-messages">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-envelope-paper-fill text-warning me-2"></i>
                    Messages des parents
                </h2>

                <p class="text-muted mb-0">
                    Consultez les conversations et répondez aux parents.
                </p>
            </div>

            <span class="badge bg-primary rounded-pill px-3 py-2">
                {{ $conversations->total() }} conversation(s)
            </span>

        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                         style="width:55px;height:55px;font-size:24px;">
                        <i class="bi bi-chat-left-text-fill"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">Centre de communication</h5>
                        <p class="text-muted mb-0">
                            Gérez les demandes et les échanges avec les familles.
                        </p>
                    </div>

                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-transparent py-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-inboxes me-2"></i>
                    Liste des conversations
                </h5>
            </div>

            <div class="card-body p-0">

                @forelse($conversations as $conversation)

                    @php
                        $parent = $conversation->parent;
                        $nomParent = trim(($parent?->prenom ?? '') . ' ' . ($parent?->nom ?? ''));

                        if (!$nomParent) {
                            $nomParent = $parent?->user?->name ?? 'Parent';
                        }

                        $dernierMessage = $conversation->dernierMessage;
                    @endphp

                    <a href="{{ route('admin.messagerie.show', $conversation->id) }}"
                       class="text-decoration-none text-reset">

                        <div class="conversation-card border-bottom p-3">

                            <div class="d-flex align-items-center gap-3">

                                <div class="avatar-parent">
                                    <i class="bi bi-person-fill"></i>
                                </div>

                                <div class="flex-grow-1 overflow-hidden">

                                    <div class="d-flex justify-content-between flex-wrap gap-2">

                                        <h6 class="fw-bold mb-1">
                                            {{ $nomParent }}
                                        </h6>

                                        <small class="text-muted">
                                            {{ $conversation->last_message_at?->format('d/m/Y H:i') ?? $conversation->created_at->format('d/m/Y') }}
                                        </small>

                                    </div>

                                    <p class="text-muted mb-0 text-truncate">
                                        @if($dernierMessage)
                                            {{ $dernierMessage->contenu }}
                                        @else
                                            Aucun message pour le moment.
                                        @endif
                                    </p>

                                </div>

                                <div class="text-end">

                                    @if($conversation->messages_non_lus > 0)
                                        <span class="badge bg-danger rounded-pill">
                                            {{ $conversation->messages_non_lus }} non lu(s)
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                            <i class="bi bi-check2-all"></i>
                                            Lu
                                        </span>
                                    @endif

                                    <div class="mt-2">
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </a>

                @empty

                    <div class="text-center py-5">

                        <i class="bi bi-inbox text-secondary"
                           style="font-size: 55px;"></i>

                        <h5 class="fw-bold mt-3">Aucune conversation</h5>

                        <p class="text-muted mb-0">
                            Les messages envoyés par les parents apparaîtront ici.
                        </p>

                    </div>

                @endforelse

            </div>

            @if($conversations->hasPages())
                <div class="card-footer bg-transparent">
                    {{ $conversations->links() }}
                </div>
            @endif

        </div>

    </div>

</div>
<style>

/* ==========================================
   ADAPTATION AUX 5 THEMES EDUMANAGE
========================================== */

/* MODE SOMBRE */
html[data-app-theme="dark"] .admin-messages {
    color: #e2e8f0;
}

html[data-app-theme="dark"] .admin-messages .card {
    background: #111827 !important;
    color: #e2e8f0 !important;
    border-color: #263449 !important;
}

html[data-app-theme="dark"] .admin-messages .card-header,
html[data-app-theme="dark"] .admin-messages .card-footer {
    background: #162036 !important;
    color: #f1f5f9 !important;
    border-color: #263449 !important;
}

html[data-app-theme="dark"] .admin-messages .conversation-card {
    border-color: #263449 !important;
}

html[data-app-theme="dark"] .admin-messages .conversation-card:hover {
    background: #1a2940;
}

html[data-app-theme="dark"] .admin-messages h2,
html[data-app-theme="dark"] .admin-messages h5,
html[data-app-theme="dark"] .admin-messages h6 {
    color: #f8fafc !important;
}

html[data-app-theme="dark"] .admin-messages .text-muted {
    color: #aab8cc !important;
}

/* ULTRA PRO */
html[data-app-theme="ultra-pro"] .admin-messages .card {
    background: rgba(255,255,255,.96);
    border: 1px solid rgba(37,99,235,.09) !important;
    box-shadow: 0 8px 25px rgba(15,23,42,.05) !important;
}

html[data-app-theme="ultra-pro"] .admin-messages .conversation-card:hover {
    background: #f1f5fb;
}

/* EMERAUDE */
html[data-app-theme="emerald"] .admin-messages .card {
    background: #f8fcfa;
    border: 1px solid #d1e7dd !important;
}

html[data-app-theme="emerald"] .admin-messages .conversation-card:hover {
    background: #eaf4ef;
}

/* CREME PRESTIGE */
html[data-app-theme="warm"] .admin-messages .card {
    background: #fffdf9;
    border: 1px solid #e7e0d5 !important;
}

html[data-app-theme="warm"] .admin-messages .conversation-card:hover {
    background: #f5efe5;
}

/* TRANSITIONS */
.admin-messages .conversation-card {
    transition: background .2s ease, transform .2s ease;
}
</style>

@endsection
