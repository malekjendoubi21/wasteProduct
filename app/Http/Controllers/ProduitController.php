<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produits = Produit::with(['categorie', 'partenaire'])->latest()->paginate(12);
        if ($request->query('format') === 'json') {
            return response()->json($produits);
        }
        return view('BackOffice.products.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::orderBy('libelle')->pluck('libelle', 'id');
        return view('BackOffice.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'stock' => 'required|integer|min:0',
            'prix_base' => 'required|numeric|min:0',
            'type' => 'required|in:recycle,non_recycle',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/produits', 'public');
            $validated['image'] = $path;
        }

        $produit = Produit::create($validated);
        return redirect()->route('produits.show', $produit)->with('success', 'Produit créé');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        $produit->load('categorie', 'partenaire', 'annonce');
        return view('BackOffice.products.show', compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        $categories = Categorie::orderBy('libelle')->pluck('libelle', 'id');
        return view('BackOffice.products.edit', compact('produit', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'stock' => 'required|integer|min:0',
            'prix_base' => 'required|numeric|min:0',
            'type' => 'required|in:recycle,non_recycle',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/produits', 'public');
            $validated['image'] = $path;
        }

        $produit->update($validated);
        return redirect()->route('produits.show', $produit)->with('success', 'Produit mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé');
    }
}
