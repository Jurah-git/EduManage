<?php

namespace App\Http\Controllers;

class BulletinController extends Controller
{
    public function index()
    {
        return view('bulletin.index');
    }

    public function saisie()
    {
        return view('bulletin.saisie');
    }

    public function validation()
    {
        return view('bulletin.validation');
    }

    public function generer()
    {
        return view('bulletin.generer');
    }
}