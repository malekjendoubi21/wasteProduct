<?php

namespace App\Http\Controllers;
use App\Models\Evenement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Participation;
class EvenementFrontController extends Controller
{
    //
    // Liste des événements pour le front
    public function listes()
    {
        $evenements = Evenement::where('status', 'accepte')
            ->orderBy('date_debut', 'asc')
            ->get();

        return view('FrontOffice.evenements.listes', compact('evenements'));
    }

    // Détails d’un événement
    public function show(Evenement $evenement)
    {
        return view('FrontOffice.evenements.show', compact('evenement'));
    }

    public function participate(Request $request, Evenement $evenement)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour participer à un événement.');
    }

    if ($evenement->status !== 'accepte') {
        return redirect()->back()->with('error', 'Cet événement n\'est pas disponible pour participation.');
    }

    $user = Auth::user();

    try {
        Participation::create([
            'user_id' => $user->id,
            'evenement_id' => $evenement->id,
        ]);
        return redirect()->back()->with('success', 'Vous participez maintenant à cet événement !');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->errorInfo[1] == 1062) { // MySQL duplicate entry error
            return redirect()->back()->with('error', 'Vous participez déjà à cet événement.');
        }
        return redirect()->back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
    }
}
}
