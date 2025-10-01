<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use App\Models\Commande;
use App\Models\Trajet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LivraisonController extends Controller
{
    public function index(Request $request)
    {
        $query = Livraison::with(['commande.utilisateur', 'trajet.vehicule', 'employe']);
        if ($request->filled('statut')) {
            $query->where('statut', $request->get('statut'));
        }
        $livraisons = $query->orderByDesc('created_at')->paginate(15);
        return view('BackOffice.livraisons.index', compact('livraisons'));
    }

    public function create()
    {
        $commandes = Commande::orderByDesc('date')->get();
        $trajets = Trajet::orderByDesc('date')->get();
        $employes = User::where('role', 'employer')->orderBy('name')->get();
        return view('BackOffice.livraisons.create', compact('commandes','trajets','employes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_commande' => 'required|exists:commandes,id',
            'adresse_livraison' => 'required|string|max:255',
            'date_livraison' => 'nullable|date',
            'statut' => 'required|string|max:50',
            'id_trajet' => 'nullable|exists:trajets,id',
            'id_utilisateur' => 'nullable|exists:users,id',
        ]);
        $validator->validate();

        $livraison = Livraison::create($request->only([
            'id_commande','adresse_livraison','date_livraison','statut','id_trajet','id_utilisateur'
        ]));
        return redirect()->route('livraisons.show', $livraison)->with('success','Livraison créée.');
    }

    public function show(Livraison $livraison)
    {
        $livraison->load(['commande.utilisateur', 'trajet.vehicule', 'employe']);
        return view('BackOffice.livraisons.show', compact('livraison'));
    }

    public function edit(Livraison $livraison)
    {
        $commandes = Commande::orderByDesc('date')->get();
        $trajets = Trajet::orderByDesc('date')->get();
        $employes = User::where('role', 'employer')->orderBy('name')->get();
        return view('BackOffice.livraisons.edit', compact('livraison','commandes','trajets','employes'));
    }

    public function update(Request $request, Livraison $livraison)
    {
        $validator = Validator::make($request->all(), [
            'adresse_livraison' => 'required|string|max:255',
            'date_livraison' => 'nullable|date',
            'statut' => 'required|string|max:50',
            'id_trajet' => 'nullable|exists:trajets,id',
            'id_utilisateur' => 'nullable|exists:users,id',
        ]);
        $validator->validate();

        $livraison->update($request->only(['adresse_livraison','date_livraison','statut','id_trajet','id_utilisateur']));
        return redirect()->route('livraisons.show', $livraison)->with('success','Livraison mise à jour.');
    }

    public function destroy(Livraison $livraison)
    {
        $livraison->delete();
        return redirect()->route('livraisons.index')->with('success','Livraison supprimée.');
    }
}
