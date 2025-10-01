<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EvenementController extends Controller
{
    // Liste des événements
    public function index()
    {
        $evenements = Evenement::orderBy('created_at', 'desc')->get();
        return view('BackOffice.evenements.index', compact('evenements'));
    }

    // Formulaire de création
    public function create()
    {
        return view('BackOffice.evenements.create');
    }

    // Stockage d'un nouvel événement
    public function store(Request $request)
{
    // Validation des champs
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'lieu' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Champ image pour l'événement
    ]);

    // Gestion de l'upload de l'image
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = Str::slug($request->titre) . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Créer le répertoire images/événements s'il n'existe pas
        $directory = public_path('images/evenements');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $file->move($directory, $filename);

        if ($path) {
            $validated['image'] = 'images/evenements/' . $filename; // Chemin relatif à public/
            \Log::info('Image événement uploadée avec succès : ' . $path);
        } else {
            \Log::error('Échec de l\'upload de l\'image pour ' . $request->titre);
            return redirect()->back()->with('error', 'Erreur lors du téléchargement de l\'image. Vérifiez les permissions.');
        }
    }

    // Ajouter l'utilisateur qui crée l'événement et son statut
    $validated['created_by'] = auth()->id();
    $validated['status'] = auth()->user()->role === 'partenaire' ? 'en_attente' : 'accepte';

    // Création de l'événement
    $evenement = Evenement::create($validated);

    return redirect()->route('evenements.index')->with('success', 'Événement créé avec succès !');
}

    // Affichage d'un événement
    public function show(Evenement $evenement)
    {
        return view('BackOffice.evenements.show', compact('evenement'));
    }
}
