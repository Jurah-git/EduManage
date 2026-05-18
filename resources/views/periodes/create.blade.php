@extends('layouts.app')

@section('content')

<div class="container">

    <div style="background:white; padding:25px; border-radius:15px; max-width:600px; margin:auto;">

        <h2>➕ Ajouter période</h2>

        <form method="POST" action="{{ route('periodes.store') }}">
            @csrf

            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>

            <label>Date début</label>
            <input type="date" name="date_debut" class="form-control" required>

            <label>Date fin</label>
            <input type="date" name="date_fin" class="form-control" required>

            <br>

            <button style="width:100%; background:#2563eb; color:white; padding:10px; border:none; border-radius:10px;">
                💾 Enregistrer
            </button>

        </form>

    </div>

</div>

@endsection