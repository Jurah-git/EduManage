<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LivreController extends Controller
{
    public function index()
    {
        return view('livres.index');
    }

    public function create()
    {
        return view('livres.create');
    }
}