@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card" style="background: white; padding: 20px; border-radius: 15px;">

            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h2>📆 Liste des périodes</h2>

                <a href="{{ route('periodes.create') }}"
                    style="background:#2563eb; color:white; padding:10px 15px; border-radius:10px; text-decoration:none;">
                    ➕ Ajouter
                </a>
            </div>

            @if (session('success'))
                <div style="margin-top:10px; padding:10px; background:#dcfce7; color:#166534; border-radius:10px;">
                    {{ session('success') }}
                </div>
            @endif

            <table style="width:100%; margin-top:20px; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th style="padding:10px;">Nom</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($periodes as $periode)
                        <tr>
                            <td style="padding:10px;">{{ $periode->nom }}</td>
                            <td>{{ $periode->date_debut }}</td>
                            <td>{{ $periode->date_fin }}</td>
                            <td>

                                <a href="{{ route('periodes.edit', $periode->id) }}" class="btn btn-warning btn-sm">

                                    Modifier
                                </a>

                                <form action="{{ route('periodes.destroy', $periode->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Supprimer cet période ?')" class="btn btn-danger btn-sm">

                                        Supprimer

                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
@endsection
