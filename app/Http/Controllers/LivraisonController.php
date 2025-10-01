<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use App\Models\Commande;
use App\Models\Trajet;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livraisons = Livraison::with(['commande','trajet','employe'])
            ->orderByDesc('id')
            ->paginate(12);
        return view('BackOffice.deliveries.index', compact('livraisons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $commandes = Commande::orderByDesc('id')->get(['id']);
        $trajets = Trajet::orderByDesc('id')->get(['id','point_depart','point_arrivee','date']);
        $employes = User::where('role', 'employe')->orderBy('name')->get(['id','name']);
        return view('BackOffice.deliveries.create', compact('commandes','trajets','employes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'commande_id' => ['required', 'exists:commandes,id'],
            'adresse_livraison' => ['required', 'string', 'max:255'],
            'date_livraison' => ['nullable', 'date'],
            'statut' => ['required', 'in:en_preparation,en_cours,livree,annulee'],
            'trajet_id' => ['required', 'exists:trajets,id'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $livraison = Livraison::create($data);
        return redirect()->route('livraisons.show', $livraison)->with('status', 'Livraison créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Livraison $livraison)
    {
        $livraison->load(['commande','trajet','employe']);
        return view('BackOffice.deliveries.show', compact('livraison'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livraison $livraison)
    {
        $commandes = Commande::orderByDesc('id')->get(['id']);
        $trajets = Trajet::orderByDesc('id')->get(['id','point_depart','point_arrivee','date']);
        $employes = User::where('role', 'employe')->orderBy('name')->get(['id','name']);
        return view('BackOffice.deliveries.edit', compact('livraison','commandes','trajets','employes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livraison $livraison)
    {
        $data = $request->validate([
            'commande_id' => ['required', 'exists:commandes,id'],
            'adresse_livraison' => ['required', 'string', 'max:255'],
            'date_livraison' => ['nullable', 'date'],
            'statut' => ['required', 'in:en_preparation,en_cours,livree,annulee'],
            'trajet_id' => ['required', 'exists:trajets,id'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);
        $livraison->update($data);
        return redirect()->route('livraisons.show', $livraison)->with('status', 'Livraison mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livraison $livraison)
    {
        $livraison->delete();
        return redirect()->route('livraisons.index')->with('status', 'Livraison supprimée');
    }
}
