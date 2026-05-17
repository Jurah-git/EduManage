<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmploiTempsController extends Controller
{
    public function index()
    {
        return view('emploi.index');
    }

    public function create()
    {
        return view('emploi.create');
    }
}