<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::orderBy('date_debut', 'desc')->get();
        return view('periodes.index', compact('periodes'));
    }

    public function create()
    {
        return view('periodes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        Periode::create($request->all());

        return redirect()->route('periodes.index')
            ->with('success', 'Période ajoutée avec succès');
    }

    public function edit(Periode $periode)
    {
        return view('periodes.edit', compact('periode'));
    }

    public function update(Request $request, Periode $periode)
    {
        $request->validate([
            'nom' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $periode->update($request->all());

        return redirect()->route('periodes.index')
            ->with('success', 'Période modifiée');
    }

    public function destroy(Periode $periode)
    {
        $periode->delete();

        return redirect()->route('periodes.index')
            ->with('success', 'Période supprimée');
    }
}