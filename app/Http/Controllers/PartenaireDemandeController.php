<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandePartenariat;
use Illuminate\Support\Str;
class PartenaireDemandeController extends Controller
{
    //
    // Afficher le formulaire (si tu veux une page dédiée)
    public function create()
    {
        return view('partenaires.demande'); // À créer si nécessaire
    }

    // Enregistrer la demande
    public function store(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'nom_organisation' => 'required|string|max:255',
            'type_organisation' => 'required|string|max:255',
            'secteur_activite' => 'required|string|max:255',
            'email_contact' => 'required|email|max:255',
            'telephone_contact' => 'required|string|max:20',
            'site_web' => 'nullable|string|max:255',
            'adresse' => 'required|string|max:255',
            'message' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validation du logo
        ]);
   // Gestion de l'upload du logo et mise à jour du tableau validé
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = Str::slug($request->nom_organisation) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('logos', $filename, 'public'); // Stocke dans storage/app/public/logos/
        $validated['logo'] = 'storage/logos/' . $filename; // Assigne le chemin relatif
        }
      
        //DemandePartenariat::create($validated);
        // Création de l'enregistrement avec débogage
        $demande = DemandePartenariat::create($validated);
        \Log::info('Données enregistrées : ', $validated); // Ajout pour débogage
        // Redirection avec message succès
        return redirect()->back()->with('success', 'Votre demande a été envoyée avec succès !');
    }

    // Liste des demandes
    public function index()
    {
        $demandes = DemandePartenariat::orderBy('created_at', 'asc')->get();
        return view('BackOffice.DemandePartenaria.liste', compact('demandes'));
    }


    // Voir une demande spécifique
    public function show($id)
    {
        $demande = DemandePartenariat::findOrFail($id);
        return view('BackOffice.DemandePartenaria.show', compact('demande'));
    }

    // Mettre à jour le statut
    public function updateStatus(Request $request, $id)
    {
        $demande = DemandePartenariat::findOrFail($id);

        if (in_array($request->statut, ['accepte', 'refuse'])) {
            $demande->statut = $request->statut;
            $demande->save();

            // Si accepté, tu peux créer automatiquement le compte partenaire
            if ($request->statut === 'accepte') {
                // Code pour créer l'utilisateur avec role 'partenaire'
            }

            return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
        }

        return redirect()->back()->with('error', 'Statut invalide.');
    }

}
