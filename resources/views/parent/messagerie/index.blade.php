
@extends('layouts.app')

@section('content')

<style>
    /* ==========================================
       STYLE GENERAL
    ========================================== */

    .messagerie-parent {
        --msg-accent: #d69e20;
    }

    .messagerie-parent .chat-card {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
    }

    .messagerie-parent .chat-header {
        background: linear-gradient(135deg, #0b1933, #172c50);
        color: white;
        padding: 22px;
    }

    .messagerie-parent .chat-body {
        background: #f4f6fa;
        padding: 25px;
        min-height: 420px;
        max-height: 560px;
        overflow-y: auto;
    }

    .messagerie-parent .message {
        max-width: 75%;
        padding: 13px 17px;
        border-radius: 16px;
        margin-bottom: 16px;
        overflow-wrap: anywhere;
    }

    /* Messages du parent */
    .messagerie-parent .message-parent {
        margin-left: auto;
        background: #0b1933;
        color: white;
        border-bottom-right-radius: 4px;
    }

    /* Messages de l'administration */
    .messagerie-parent .message-admin {
        margin-right: auto;
        background: white;
        color: #26344b;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }

    .messagerie-parent .message-date {
        display: block;
        font-size: 11px;
        margin-top: 7px;
        opacity: .7;
    }

    /* Pied de discussion */
    .messagerie-parent .chat-footer {
        background: white;
        padding: 20px;
    }

    .messagerie-parent .message-input {
        width: 100%;
        border-radius: 13px;
        min-height: 52px;
        transition: .2s ease;
    }

    .messagerie-parent .message-input:focus {
        box-shadow: 0 0 0 .2rem rgba(214,158,32,.16);
        border-color: #d69e20;
    }

    /* ==========================================
       THEME 1 : CLAIR CLASSIQUE
    ========================================== */

    html[data-app-theme="default"] .messagerie-parent .chat-card {
        background: #ffffff;
    }

    html[data-app-theme="default"] .messagerie-parent .chat-body {
        background: #f4f6fa;
    }

    /* ==========================================
       THEME 2 : MODE SOMBRE
    ========================================== */

    html[data-app-theme="dark"] .messagerie-parent {
        color: #e2e8f0;
    }

    html[data-app-theme="dark"] .messagerie-parent .chat-card,
    html[data-app-theme="dark"] .messagerie-parent .chat-footer {
        background: #111827 !important;
        color: #e2e8f0 !important;
        border-color: #263449 !important;
    }

    html[data-app-theme="dark"] .messagerie-parent .chat-body {
        background: #0b1220 !important;
    }

    html[data-app-theme="dark"] .messagerie-parent .message-admin {
        background: #1e293b !important;
        color: #f1f5f9 !important;
        border: 1px solid #334155;
    }

    html[data-app-theme="dark"] .messagerie-parent .message-date {
        color: #cbd5e1;
    }

    html[data-app-theme="dark"] .messagerie-parent .message-input {
        background: #0f172a !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    html[data-app-theme="dark"] .messagerie-parent .message-input::placeholder {
        color: #94a3b8;
    }

    html[data-app-theme="dark"] .messagerie-parent .text-muted {
        color: #aab8cc !important;
    }

    html[data-app-theme="dark"] .messagerie-parent h2,
    html[data-app-theme="dark"] .messagerie-parent h5 {
        color: #f8fafc;
    }

    /* ==========================================
       THEME 3 : ULTRA PRO
    ========================================== */

    html[data-app-theme="ultra-pro"] .messagerie-parent .chat-card {
        background: rgba(255,255,255,.95);
        border: 1px solid rgba(37,99,235,.10);
        box-shadow: 0 10px 30px rgba(15,23,42,.07) !important;
    }

    html[data-app-theme="ultra-pro"] .messagerie-parent .chat-body {
        background: #eef3fa;
    }

    html[data-app-theme="ultra-pro"] .messagerie-parent .chat-footer {
        background: #ffffff;
    }

    /* ==========================================
       THEME 4 : EMERAUDE
    ========================================== */

    html[data-app-theme="emerald"] .messagerie-parent .chat-card,
    html[data-app-theme="emerald"] .messagerie-parent .chat-footer {
        background: #f8fcfa;
        border-color: #d1e7dd;
    }

    html[data-app-theme="emerald"] .messagerie-parent .chat-body {
        background: #eaf4ef;
    }

    html[data-app-theme="emerald"] .messagerie-parent .message-admin {
        background: #ffffff;
        color: #174536;
        border: 1px solid #d1e7dd;
    }

    html[data-app-theme="emerald"] .messagerie-parent .message-input {
        border-color: #c6ded2;
    }

    /* ==========================================
       THEME 5 : CREME PRESTIGE
    ========================================== */

    html[data-app-theme="warm"] .messagerie-parent .chat-card,
    html[data-app-theme="warm"] .messagerie-parent .chat-footer {
        background: #fffdf9;
        border-color: #e7e0d5;
    }

    html[data-app-theme="warm"] .messagerie-parent .chat-body {
        background: #f5efe5;
    }

    html[data-app-theme="warm"] .messagerie-parent .message-admin {
        background: #fffdf9;
        color: #51402d;
        border: 1px solid #e7e0d5;
    }

    html[data-app-theme="warm"] .messagerie-parent .message-input {
        border-color: #e7e0d5;
    }

    /* ==========================================
       RESPONSIVE MOBILE
    ========================================== */

    @media(max-width: 576px) {
        .messagerie-parent .message {
            max-width: 90%;
        }

        .messagerie-parent .chat-body {
            padding: 15px;
        }

        .messagerie-parent .chat-header {
            padding: 16px;
        }

        .messagerie-parent .chat-footer {
            padding: 15px;
        }
    }
</style>

<div class="container-fluid py-4 messagerie-parent">

    {{-- TITRE --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-chat-dots-fill text-warning me-2"></i>
                Contacter l'administration
            </h2>

            <p class="text-muted mb-0">
                Échangez directement avec l'administration de l'établissement.
            </p>
        </div>

        <span class="badge rounded-pill bg-success px-3 py-2">
            <i class="bi bi-shield-check me-1"></i>
            Discussion privée
        </span>

    </div>

    {{-- CONFIRMATION --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ERREURS --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- CARTE DE MESSAGERIE --}}
    <div class="card shadow-sm chat-card">

        {{-- EN-TETE --}}
        <div class="chat-header d-flex align-items-center gap-3">

            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center"
                 style="width:50px;height:50px;font-size:22px;">
                <i class="bi bi-headset"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">
                    Administration EduManage
                </h5>

                <small class="text-white-50">
                    Service de communication avec les parents
                </small>
            </div>

        </div>

        {{-- HISTORIQUE --}}
        <div class="chat-body" id="chatMessages">

            @forelse($messages as $message)

                @php
                    $estParent = (int) $message->sender_id === (int) auth()->id();
                @endphp

                <div class="d-flex flex-column {{ $estParent ? 'align-items-end' : 'align-items-start' }}">

                    <div class="message {{ $estParent ? 'message-parent' : 'message-admin' }}">

                        <div class="small fw-bold mb-1">
                            {{ $estParent ? 'Vous' : 'Administration' }}
                        </div>

                        <div style="white-space: pre-wrap;">{{ $message->contenu }}</div>

                        <span class="message-date">
                            {{ $message->created_at->format('d/m/Y à H:i') }}

                            @if($estParent)
                                @if($message->read_at)
                                    <i class="bi bi-check2-all ms-1 text-success"
                                       title="Lu par l'administration"></i>
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
                        Bienvenue dans votre messagerie
                    </h5>

                    <p class="text-muted">
                        Vous n'avez pas encore de message.
                        Envoyez votre première demande à l'administration.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- FORMULAIRE D'ENVOI --}}
        <div class="chat-footer">

            <form action="{{ route('parent.messagerie.envoyer') }}"
                  method="POST">

                @csrf

                <div class="d-flex gap-2 align-items-end">

                    <div class="flex-grow-1">

                        <textarea
                            name="contenu"
                            class="form-control message-input"
                            rows="2"
                            maxlength="3000"
                            placeholder="Écrivez votre message à l'administration..."
                            required>{{ old('contenu') }}</textarea>

                        <small class="text-muted">
                            Maximum 3000 caractères.
                        </small>

                    </div>

                    <button type="submit"
                            class="btn btn-primary px-4 py-3 rounded-3">

                        <i class="bi bi-send-fill me-1"></i>
                        Envoyer

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- DEFILEMENT AUTOMATIQUE --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const chat = document.getElementById('chatMessages');

    if (chat) {
        chat.scrollTop = chat.scrollHeight;
    }

});
</script>

@endsection
