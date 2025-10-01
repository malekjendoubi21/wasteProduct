<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::with('user')
            ->orderByDesc('id')
            ->paginate(10);

        return view('BackOffice.orders.index', compact('commandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = \App\Models\Produit::orderBy('nom')->get(['id','nom','prix_base','stock']);
        return view('BackOffice.orders.create', compact('produits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'date' => ['nullable', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.produit_id' => ['required', 'exists:produits,id'],
            'items.*.quantite' => ['required', 'integer', 'min:1'],
        ]);

        $data['date'] = $data['date'] ?? now();

        // Build liste_produits and compute montant from items
        $liste = [];
        $total = 0;
        $produits = \App\Models\Produit::whereIn('id', collect($data['items'])->pluck('produit_id'))->get(['id','prix_base']);
        foreach ($data['items'] as $it) {
            $p = $produits->firstWhere('id', (int)$it['produit_id']);
            if (!$p) continue;
            $qte = (int)$it['quantite'];
            $ligne = [
                'produit_id' => (int)$p->id,
                'quantite' => $qte,
                'prix_unitaire' => (float)$p->prix_base,
                'total' => (float)($p->prix_base * $qte),
            ];
            $total += $ligne['total'];
            $liste[] = $ligne;
        }

        $commande = Commande::create([
            'user_id' => $data['user_id'],
            'date' => $data['date'],
            'montant' => $total,
            'liste_produits' => $liste,
        ]);
        return redirect()->route('commandes.edit', $commande)->with('status', 'Order created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        return view('BackOffice.orders.show', compact('commande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        $produits = \App\Models\Produit::orderBy('nom')->get(['id','nom','prix_base','stock']);
        return view('BackOffice.orders.edit', compact('commande','produits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        $data = $request->validate([
            'date' => ['nullable', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.produit_id' => ['required', 'exists:produits,id'],
            'items.*.quantite' => ['required', 'integer', 'min:1'],
        ]);

        $data['date'] = $data['date'] ?? $commande->date ?? now();

        $liste = [];
        $total = 0;
        $produits = \App\Models\Produit::whereIn('id', collect($data['items'])->pluck('produit_id'))->get(['id','prix_base']);
        foreach ($data['items'] as $it) {
            $p = $produits->firstWhere('id', (int)$it['produit_id']);
            if (!$p) continue;
            $qte = (int)$it['quantite'];
            $ligne = [
                'produit_id' => (int)$p->id,
                'quantite' => $qte,
                'prix_unitaire' => (float)$p->prix_base,
                'total' => (float)($p->prix_base * $qte),
            ];
            $total += $ligne['total'];
            $liste[] = $ligne;
        }

        $commande->update([
            'date' => $data['date'],
            'montant' => $total,
            'liste_produits' => $liste,
        ]);
        return redirect()->route('commandes.index')->with('status', 'Order updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        $commande->delete();
        return redirect()->route('commandes.index')->with('status', 'Order deleted');
    }
}
