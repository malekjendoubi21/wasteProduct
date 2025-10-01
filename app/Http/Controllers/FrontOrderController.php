<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FrontOrderController extends Controller
{
    public function create()
    {
    $user = Auth::user();
    abort_unless($user && $user->role === 'partenaire', 403);
        $products = Product::orderBy('nom')->get(['id','nom','prix_base']);
        return view('FrontOffice.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
    $user = Auth::user();
    abort_unless($user && $user->role === 'partenaire', 403);

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $validator->validate();

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;
        $montantHT = (float) $product->prix_base * $quantity;
        $montant = round($montantHT * 1.10, 2); // 10% TVA

        $commande = Commande::create([
            'id_utilisateur' => $user->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'montant' => $montant,
        ]);

        return redirect()->route('front.orders.show', $commande)->with('success', 'Commande créée avec succès.');
    }
}
