
@extends('layouts.app')

@section('content')

<style>
    /* ==========================================
       STYLE GENERAL
    ========================================== */

    .admin-chat {
        --chat-accent: #d69e20;
    }

    .admin-chat .chat-card {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
    }

    .admin-chat .chat-header {
        background: linear-gradient(135deg, #0b1933, #172c50);
        color: white;
        padding: 22px;
    }

    .admin-chat .chat-body {
        background: #f4f6fa;
        padding: 25px;
        min-height: 420px;
        max-height: 560px;
        overflow-y: auto;
    }

    .admin-chat .message {
        max-width: 75%;
        padding: 13px 17px;
        border-radius: 16px;
        margin-bottom: 16px;
        overflow-wrap: anywhere;
    }

    /* Messages envoyés par l'administration */
    .admin-chat .message-admin {
        margin-left: auto;
        background: #0b1933;
        color: white;
        border-bottom-right-radius: 4px;
    }

    /* Messages envoyés par le parent */
    .admin-chat .message-parent {
        margin-right: auto;
        background: white;
        color: #26344b;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }

    .admin-chat .message-date {
        display: block;
        font-size: 11px;
        margin-top: 7px;
        opacity: .7;
    }

    /* Zone de réponse */
    .admin-chat .chat-footer {
        background: white;
        padding: 20px;
    }

    .admin-chat textarea {
        border-radius: 13px;
        min-height: 52px;
        transition: .2s ease;
    }

    .admin-chat textarea:focus {
        border-color: #d69e20;
        box-shadow: 0 0 0 .2rem rgba(214,158,32,.16);
    }

    /* ==========================================
       THEME 1 : CLAIR CLASSIQUE
    ========================================== */

    html[data-app-theme="default"] .admin-chat .chat-card {
        background: #ffffff;
    }

    html[data-app-theme="default"] .admin-chat .chat-body {
        background: #f4f6fa;
    }

    /* ==========================================
       THEME 2 : MODE SOMBRE
    ========================================== */

    html[data-app-theme="dark"] .admin-chat {
        color: #e2e8f0;
    }

    html[data-app-theme="dark"] .admin-chat .chat-card {
        background: #111827 !important;
        color: #e2e8f0 !important;
        border: 1px solid #263449;
    }

    html[data-app-theme="dark"] .admin-chat .chat-body {
        background: #0b1220 !important;
    }

    html[data-app-theme="dark"] .admin-chat .chat-footer {
        background: #111827 !important;
        color: #e2e8f0 !important;
        border-top: 1px solid #263449;
    }

    html[data-app-theme="dark"] .admin-chat .chat-card > .bg-white {
        background: #111827 !important;
        color: #e2e8f0 !important;
        border-color: #263449 !important;
    }

    html[data-app-theme="dark"] .admin-chat .message-parent {
        background: #1e293b !important;
        color: #f1f5f9 !important;
        border: 1px solid #334155;
    }

    html[data-app-theme="dark"] .admin-chat .message-date {
        color: #cbd5e1;
    }

    html[data-app-theme="dark"] .admin-chat textarea {
        background: #0f172a !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    html[data-app-theme="dark"] .admin-chat textarea::placeholder {
        color: #94a3b8;
    }

    html[data-app-theme="dark"] .admin-chat .text-muted {
        color: #aab8cc !important;
    }

    html[data-app-theme="dark"] .admin-chat h2,
    html[data-app-theme="dark"] .admin-chat h5,
    html[data-app-theme="dark"] .admin-chat h6 {
        color: #f8fafc;
    }

    /* ==========================================
       THEME 3 : ULTRA PRO
    ========================================== */

    html[data-app-theme="ultra-pro"] .admin-chat .chat-card {
        background: rgba(255,255,255,.96);
        border: 1px solid rgba(37,99,235,.10);
        box-shadow: 0 10px 30px rgba(15,23,42,.07) !important;
    }

    html[data-app-theme="ultra-pro"] .admin-chat .chat-body {
        background: #eef3fa;
    }

    html[data-app-theme="ultra-pro"] .admin-chat .chat-footer {
        background: #ffffff;
    }

    /* ==========================================
       THEME 4 : EMERAUDE
    ========================================== */

    html[data-app-theme="emerald"] .admin-chat .chat-card {
        background: #f8fcfa;
        border: 1px solid #d1e7dd;
    }

    html[data-app-theme="emerald"] .admin-chat .chat-body {
        background: #eaf4ef;
    }

    html[data-app-theme="emerald"] .admin-chat .chat-footer {
        background: #f8fcfa;
        border-top: 1px solid #d1e7dd;
    }

    html[data-app-theme="emerald"] .admin-chat .message-parent {
        background: #ffffff;
        color: #174536;
        border: 1px solid #d1e7dd;
    }

    html[data-app-theme="emerald"] .admin-chat textarea {
        border-color: #c6ded2;
    }

    /* ==========================================
       THEME 5 : CREME PRESTIGE
    ========================================== */

    html[data-app-theme="warm"] .admin-chat .chat-card {
        background: #fffdf9;
        border: 1px solid #e7e0d5;
    }

    html[data-app-theme="warm"] .admin-chat .chat-body {
        background: #f5efe5;
    }

    html[data-app-theme="warm"] .admin-chat .chat-footer {
        background: #fffdf9;
        border-top: 1px solid #e7e0d5;
    }

    html[data-app-theme="warm"] .admin-chat .message-parent {
        background: #fffdf9;
        color: #51402d;
        border: 1px solid #e7e0d5;
    }

    html[data-app-theme="warm"] .admin-chat textarea {
        border-color: #e7e0d5;
    }

    /* ==========================================
       RESPONSIVE MOBILE
    ========================================== */

    @media(max-width:576px) {
        .admin-chat .message {
            max-width: 90%;
        }

        .admin-chat .chat-body {
            padding: 15px;
        }

        .admin-chat .chat-header {
            padding: 16px;
        }

        .admin-chat .chat-footer {
            padding: 15px;
        }
    }
</style>

<div class="container-fluid py-4 admin-chat">

    @php
        $parent = $conversation->parent;

        $nomParent = trim(
            ($parent?->prenom ?? '') . ' ' . ($parent?->nom ?? '')
        );

        if (!$nomParent) {
            $nomParent = $parent?->user?->name ?? 'Parent';
        }
    @endphp

    {{-- EN-TETE DE LA DISCUSSION --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-chat-dots-fill text-warning me-2"></i>
                Discussion avec {{ $nomParent }}
            </h2>

            <p class="text-muted mb-0">
                Répondez directement à ce parent.
            </p>
        </div>

        <a href="{{ route('admin.messagerie.index') }}"
           class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>
            Retour aux messages
        </a>

    </div>

    {{-- MESSAGE DE CONFIRMATION --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ERREURS DE VALIDATION --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- CARTE DE DISCUSSION --}}
    <div class="card shadow-sm chat-card">

        {{-- IDENTITE DU PARENT --}}
        <div class="chat-header d-flex align-items-center gap-3">

            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center"
                 style="width:50px;height:50px;font-size:22px;">
                <i class="bi bi-person-fill"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">{{ $nomParent }}</h5>

                <small class="text-white-50">
                    {{ $parent?->email ?? $parent?->user?->email ?? 'Parent EduManage' }}
                </small>
            </div>

        </div>

        {{-- HISTORIQUE DES MESSAGES --}}
        <div class="chat-body" id="chatMessages">

            @forelse($messages as $message)

                @php
                    $estAdmin = (int) $message->sender_id === (int) auth()->id();
                @endphp

                <div class="d-flex flex-column {{ $estAdmin ? 'align-items-end' : 'align-items-start' }}">

                    <div class="message {{ $estAdmin ? 'message-admin' : 'message-parent' }}">

                        <div class="small fw-bold mb-1">
                            {{ $estAdmin ? 'Administration' : $nomParent }}
                        </div>

                        <div style="white-space: pre-wrap;">{{ $message->contenu }}</div>

                        <span class="message-date">
                            {{ $message->created_at->format('d/m/Y à H:i') }}

                            @if($estAdmin)
                                @if($message->read_at)
                                    <i class="bi bi-check2-all ms-1 text-success"
                                       title="Lu par le parent"></i>
                                @else
                                    <i class="bi bi-check2 ms-1 text-muted"
                                       title="Envoyé, non lu"></i>
                                @endif
                            @endif
                        </span>

                    </div>

                </div>

            @empty

                <div class="text-center py-5">

                    <i class="bi bi-chat-square-text text-secondary"
                       style="font-size:55px;"></i>

                    <h5 class="fw-bold mt-3">
                        Début de la conversation
                    </h5>

                    <p class="text-muted">
                        Envoyez votre premier message à ce parent.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- FORMULAIRE DE REPONSE --}}
        <div class="chat-footer">

            <form action="{{ route('admin.messagerie.repondre', $conversation->id) }}"
                  method="POST">

                @csrf

                <div class="d-flex gap-2 align-items-end">

                    <div class="flex-grow-1">

                        <textarea
                            name="contenu"
                            class="form-control rounded-3"
                            rows="2"
                            maxlength="3000"
                            placeholder="Écrire une réponse au parent..."
                            required>{{ old('contenu') }}</textarea>

                        <small class="text-muted">
                            Maximum 3000 caractères.
                        </small>

                    </div>

                    <button type="submit"
                            class="btn btn-primary rounded-3 px-4 py-3">

                        <i class="bi bi-send-fill me-1"></i>
                        Répondre

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- DEFILEMENT AUTOMATIQUE VERS LE DERNIER MESSAGE --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const chat = document.getElementById('chatMessages');

    if (chat) {
        chat.scrollTop = chat.scrollHeight;
    }

});
</script>

@endsection
