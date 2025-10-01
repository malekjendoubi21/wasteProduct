<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
    $query = Commande::with(['utilisateur','product']);
        if ($request->filled('user_id')) {
            $query->where('id_utilisateur', $request->integer('user_id'));
        }
        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->date('to'));
        }

        $commandes = $query->orderByDesc('date')->paginate(15);
        $users = User::orderBy('name')->get(['id','name']);
        return view('BackOffice.orders.index', compact('commandes', 'users'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get(['id','name']);
        return view('BackOffice.orders.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_utilisateur' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $validator->validate();

        // Compute montant = product price * quantity + 10% TVA
        $product = \App\Models\Product::findOrFail($request->product_id);
        $montantHT = (float) $product->prix_base * (int) $request->quantity;
        $montant = round($montantHT * 1.10, 2); // 10% TVA

        $commande = Commande::create([
            'montant' => $montant,
            'id_utilisateur' => $request->id_utilisateur,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('orders.show', $commande)->with('success', 'Commande créée.');
    }

    public function show(Commande $order)
    {
        $order->load('utilisateur', 'product', 'livraisons.trajet.vehicule');
        return view('BackOffice.orders.show', ['commande' => $order]);
    }

    public function edit(Commande $order)
    {
        $users = User::orderBy('name')->get(['id','name']);
        return view('BackOffice.orders.edit', ['commande' => $order, 'users' => $users]);
    }

    public function update(Request $request, Commande $order)
    {
        $validator = Validator::make($request->all(), [
            'id_utilisateur' => 'required|exists:users,id',
            'product_id' => 'sometimes|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
        ]);
        $validator->validate();

        // Determine effective product and quantity for calculation
        $productId = $request->input('product_id', $order->product_id);
        $quantity = (int) $request->input('quantity', $order->quantity);
        $product = \App\Models\Product::findOrFail($productId);
        $montantHT = (float) $product->prix_base * $quantity;
        $montant = round($montantHT * 1.10, 2);

        $order->update([
            'id_utilisateur' => $request->id_utilisateur,
            'product_id' => $productId,
            'quantity' => $quantity,
            'montant' => $montant,
        ]);
        return redirect()->route('orders.show', $order)->with('success', 'Commande mise à jour.');
    }

    public function destroy(Commande $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Commande supprimée.');
    }
}
