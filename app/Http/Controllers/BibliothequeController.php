<?php

namespace App\Http\Controllers;

class BibliothequeController extends Controller
{
    public function index()
    {
        return view('biblio.index');
    }

    public function emprunt()
    {
        return view('biblio.emprunt');
    }
}