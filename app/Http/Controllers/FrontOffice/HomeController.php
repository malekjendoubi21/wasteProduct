<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\DemandePartenariat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer tous les partenaires acceptés avec leur logo
        $partenaires = DemandePartenariat::accepte()
                                       ->avecLogo()
                                       ->get();

        return view('FrontOffice.home.home', compact('partenaires'));
    }
}
