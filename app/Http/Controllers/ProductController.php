<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Catégorie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Affiche la liste des produits.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Product::with('categorie');

        // Filtrage par type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filtrage par catégorie
        if ($request->filled('categorie_id')) {
            $query->byCategorie($request->categorie_id);
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->byNom($request->search);
        }

        // Filtrage par stock
        if ($request->filled('stock') && $request->stock === 'available') {
            $query->inStock();
        }

        $products = $query->orderBy('date_ajout', 'desc')->paginate(15);
        $categories = Catégorie::orderBy('label')->get();
        $types = Product::getTypes();

        return view('BackOffice.products.index', compact('products', 'categories', 'types'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau produit.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Catégorie::orderBy('label')->get();
        $types = Product::getTypes();

        return view('BackOffice.products.create', compact('categories', 'types'));
    }

    /**
     * Enregistre un nouveau produit.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_base' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'type' => ['required', Rule::in([Product::TYPE_RECYCLE, Product::TYPE_ALIMENTAIRE, Product::TYPE_NON_RECYCLE])],
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'prix_base.required' => 'Le prix est obligatoire.',
            'prix_base.numeric' => 'Le prix doit être un nombre.',
            'prix_base.min' => 'Le prix ne peut pas être négatif.',
            'stock.required' => 'Le stock est obligatoire.',
            'stock.integer' => 'Le stock doit être un nombre entier.',
            'stock.min' => 'Le stock ne peut pas être négatif.',
            'type.required' => 'Le type est obligatoire.',
            'type.in' => 'Le type sélectionné est invalide.',
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'image.max' => 'L\'image ne peut pas dépasser 2MB.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['nom', 'description', 'prix_base', 'stock', 'type', 'categorie_id']);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product = Product::create($data);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Produit créé avec succès.');
    }

    /**
     * Affiche un produit spécifique.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        $product->load('categorie');
        
        return view('BackOffice.products.show', compact('product'));
    }

    /**
     * Affiche le formulaire d'édition d'un produit.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $categories = Catégorie::orderBy('label')->get();
        $types = Product::getTypes();

        return view('BackOffice.products.edit', compact('product', 'categories', 'types'));
    }

    /**
     * Met à jour un produit.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_base' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'type' => ['required', Rule::in([Product::TYPE_RECYCLE, Product::TYPE_ALIMENTAIRE, Product::TYPE_NON_RECYCLE])],
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'prix_base.required' => 'Le prix est obligatoire.',
            'prix_base.numeric' => 'Le prix doit être un nombre.',
            'prix_base.min' => 'Le prix ne peut pas être négatif.',
            'stock.required' => 'Le stock est obligatoire.',
            'stock.integer' => 'Le stock doit être un nombre entier.',
            'stock.min' => 'Le stock ne peut pas être négatif.',
            'type.required' => 'Le type est obligatoire.',
            'type.in' => 'Le type sélectionné est invalide.',
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'image.max' => 'L\'image ne peut pas dépasser 2MB.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['nom', 'description', 'prix_base', 'stock', 'type', 'categorie_id']);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprime un produit.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Supprimer l'image si elle existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    /**
     * API - Retourne tous les produits.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $query = Product::with('categorie');

        // Filtres API
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('categorie_id')) {
            $query->byCategorie($request->categorie_id);
        }

        if ($request->filled('search')) {
            $query->byNom($request->search);
        }

        if ($request->filled('in_stock') && $request->boolean('in_stock')) {
            $query->inStock();
        }

        $products = $query->orderBy('date_ajout', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * API - Retourne un produit spécifique.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function apiShow(Product $product): JsonResponse
    {
        $product->load('categorie');

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * API - Crée un nouveau produit.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function apiStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_base' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'type' => ['required', Rule::in([Product::TYPE_RECYCLE, Product::TYPE_ALIMENTAIRE, Product::TYPE_NON_RECYCLE])],
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreurs de validation.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only(['nom', 'description', 'prix_base', 'stock', 'type', 'categorie_id']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product = Product::create($data);
        $product->load('categorie');

        return response()->json([
            'success' => true,
            'message' => 'Produit créé avec succès.',
            'data' => $product,
        ], 201);
    }

    /**
     * Recherche de produits.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        $products = Product::byNom($query)
            ->with('categorie')
            ->orderBy('nom')
            ->paginate(15);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $products,
            ]);
        }

        $categories = Catégorie::orderBy('label')->get();
        $types = Product::getTypes();

        return view('BackOffice.products.index', compact('products', 'categories', 'types', 'query'));
    }

    /**
     * Met à jour le stock d'un produit.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function updateStock(Request $request, Product $product): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreurs de validation.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $product->update(['stock' => $request->stock]);

        return response()->json([
            'success' => true,
            'message' => 'Stock mis à jour avec succès.',
            'data' => $product,
        ]);
    }

    /**
     * FRONT OFFICE - Affiche les produits pour le public.
     *
     * @param Request $request
     * @return View
     */
    public function frontIndex(Request $request): View
    {
        $query = Product::with('categorie')->inStock();

        // Filtrage par type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filtrage par catégorie
        if ($request->filled('categorie_id')) {
            $query->byCategorie($request->categorie_id);
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->byNom($request->search);
        }

        $products = $query->orderBy('date_ajout', 'desc')->paginate(12);
        $categories = Catégorie::withCount('produits')->orderBy('label')->get();
        $types = Product::getTypes();

        return view('FrontOffice.products.index', compact('products', 'categories', 'types'));
    }

    /**
     * FRONT OFFICE - Affiche un produit spécifique.
     *
     * @param Product $product
     * @return View
     */
    public function frontShow(Product $product): View
    {
        $product->load('categorie');
        
        // Produits similaires dans la même catégorie
        $relatedProducts = Product::with('categorie')
            ->where('categorie_id', $product->categorie_id)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->limit(4)
            ->get();

        return view('FrontOffice.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * FRONT OFFICE - Affiche les produits d'une catégorie.
     *
     * @param Catégorie $categorie
     * @param Request $request
     * @return View
     */
    public function frontByCategory(Catégorie $categorie, Request $request): View
    {
        $query = $categorie->produits()->with('categorie')->inStock();

        // Filtrage par type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->byNom($request->search);
        }

        $products = $query->orderBy('date_ajout', 'desc')->paginate(12);
        $categories = Catégorie::withCount('produits')->orderBy('label')->get();
        $types = Product::getTypes();

        return view('FrontOffice.products.category', compact('products', 'categories', 'types', 'categorie'));
    }
}