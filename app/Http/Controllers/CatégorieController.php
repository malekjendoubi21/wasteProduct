<?php

namespace App\Http\Controllers;

use App\Models\Catégorie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class CatégorieController extends Controller
{
    /**
     * Affiche la liste des catégories.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = Catégorie::withCount('produits')
            ->orderBy('date_creation', 'desc')
            ->paginate(15);

        return view('BackOffice.categories.index', compact('categories'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle catégorie.
     *
     * @return View
     */
    public function create(): View
    {
        return view('BackOffice.categories.create');
    }

    /**
     * Enregistre une nouvelle catégorie.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255|unique:categories,label',
        ], [
            'label.required' => 'Le libellé est obligatoire.',
            'label.string' => 'Le libellé doit être une chaîne de caractères.',
            'label.max' => 'Le libellé ne peut pas dépasser 255 caractères.',
            'label.unique' => 'Ce libellé existe déjà.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $categorie = Catégorie::create([
            'label' => $request->label,
        ]);

        return redirect()
            ->route('categories.show', $categorie)
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Affiche une catégorie spécifique.
     *
     * @param Catégorie $categorie
     * @return View
     */
    public function show(Catégorie $categorie): View
    {
        $categorie->load('produits');
        
        return view('BackOffice.categories.show', compact('categorie'));
    }

    /**
     * Affiche le formulaire d'édition d'une catégorie.
     *
     * @param Catégorie $categorie
     * @return View
     */
    public function edit(Catégorie $categorie): View
    {
        return view('BackOffice.categories.edit', compact('categorie'));
    }

    /**
     * Met à jour une catégorie.
     *
     * @param Request $request
     * @param Catégorie $categorie
     * @return RedirectResponse
     */
    public function update(Request $request, Catégorie $categorie): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255|unique:categories,label,' . $categorie->id,
        ], [
            'label.required' => 'Le libellé est obligatoire.',
            'label.string' => 'Le libellé doit être une chaîne de caractères.',
            'label.max' => 'Le libellé ne peut pas dépasser 255 caractères.',
            'label.unique' => 'Ce libellé existe déjà.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $categorie->update([
            'label' => $request->label,
        ]);

        return redirect()
            ->route('categories.show', $categorie)
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Supprime une catégorie.
     *
     * @param Catégorie $categorie
     * @return RedirectResponse
     */
    public function destroy(Catégorie $categorie): RedirectResponse
    {
        // Vérifier s'il y a des produits associés
        if ($categorie->produits()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette catégorie car elle contient des produits.');
        }

        $categorie->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    /**
     * API - Retourne toutes les catégories.
     *
     * @return JsonResponse
     */
    public function apiIndex(): JsonResponse
    {
        $categories = Catégorie::withCount('produits')
            ->orderBy('label')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * API - Retourne une catégorie spécifique.
     *
     * @param Catégorie $categorie
     * @return JsonResponse
     */
    public function apiShow(Catégorie $categorie): JsonResponse
    {
        $categorie->load('produits');

        return response()->json([
            'success' => true,
            'data' => $categorie,
        ]);
    }

    /**
     * API - Crée une nouvelle catégorie.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function apiStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255|unique:categories,label',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreurs de validation.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $categorie = Catégorie::create([
            'label' => $request->label,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catégorie créée avec succès.',
            'data' => $categorie,
        ], 201);
    }

    /**
     * Recherche de catégories.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        $categories = Catégorie::byLabel($query)
            ->with('produits')
            ->orderBy('label')
            ->paginate(15);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $categories,
            ]);
        }

        return view('BackOffice.categories.index', compact('categories', 'query'));
    }
}