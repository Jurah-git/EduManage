<?php
namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEleves      = Eleve::count();
        $totalClasses     = Classe::count();
        $totalUsers       = User::count();
        $totalEnseignants = Enseignant::count();

        return view('dashboard', compact(
            'totalEleves',
            'totalClasses',
            'totalUsers',
            'totalEnseignants'
        ));
    }
}