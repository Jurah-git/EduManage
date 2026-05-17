<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CahierTexteController extends Controller
{
    public function index()
    {
        return view('cahier.index');
    }

    public function create()
    {
        return view('cahier.create');
    }
}