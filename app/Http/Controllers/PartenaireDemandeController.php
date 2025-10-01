<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandePartenariat;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;
use App\Mail\DemandePartenariatStatusMail;
use App\Models\User;

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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'upload du logo
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = Str::slug($request->nom_organisation) . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Créer le répertoire images s'il n'existe pas
            $directory = public_path('images');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $path = $file->move($directory, $filename);

            if ($path) {
                $validated['logo'] = 'images/' . $filename; // Chemin relatif à public/
                \Log::info('Logo uploaded successfully to ' . $path);
            } else {
                \Log::error('Failed to upload logo for ' . $request->nom_organisation . '. Check permissions.');
                return redirect()->back()->with('error', 'Erreur lors du téléchargement du logo. Vérifiez les permissions.');
            }
        }

        // Création de l'enregistrement
        $demande = DemandePartenariat::create($validated);
        \Log::info('Données enregistrées : ', $validated);

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
    // public function updateStatus(Request $request, $id)
    // {
    //     $demande = DemandePartenariat::findOrFail($id);

    //     if (in_array($request->statut, ['accepte', 'refuse'])) {
    //         $demande->statut = $request->statut;
    //         $demande->save();

    //         // Si accepté, tu peux créer automatiquement le compte partenaire
    //         if ($request->statut === 'accepte') {
    //             // Code pour créer l'utilisateur avec role 'partenaire'
    //         }

    //         return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    //     }

    //     return redirect()->back()->with('error', 'Statut invalide.');
    // }

   
    // Mettre à jour le statut
    public function updateStatus(Request $request, $id)
    {
        $demande = DemandePartenariat::findOrFail($id);

        if (!in_array($request->statut, ['accepte', 'refuse'])) {
            return redirect()->back()->with('error', 'Statut invalide.');
        }

        $demande->statut = $request->statut;
        $demande->save();

        $password = null;
        $user = null;

        try {
            if ($request->statut === 'accepte') {
                $password = $request->input('custom_password'); // Récupérer le mot de passe personnalisé
                if (!$password) {
                    return redirect()->back()->with('error', 'Veuillez entrer un mot de passe.');
                }
                $user = User::create([
                    'name' => $demande->nom_organisation,
                    'email' => $demande->email_contact,
                    'password' => bcrypt($password), // Utiliser le mot de passe fourni
                    'role' => 'partenaire',
                ]);
            }

            Mail::to($demande->email_contact)->send(
                new DemandePartenariatStatusMail($demande, $request->statut, $password)
            );

            return redirect()->back()->with('success', 'Statut mis à jour et mail envoyé avec succès.');
        } catch (\Exception $e) {
            if ($user && $request->statut === 'accepte') {
                $user->delete();
                $demande->statut = 'en_attente';
                $demande->save();
            }

            \Log::error('Erreur d\'envoi de mail : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Statut mis à jour, mais erreur lors de l\'envoi du mail : ' . $e->getMessage());
        }
    }

    // Méthode pour tester l'envoi de mail
    public function sendTestEmail(Request $request, $id)
    {
        $demande = DemandePartenariat::findOrFail($id);

        $testStatus = 'test';
        $testPassword = 'Ayouta@14661458?!'; // Mot de passe fictif fixe pour le test

        try {
            Mail::to($demande->email_contact)->send(
                new DemandePartenariatStatusMail($demande, $testStatus, $testPassword)
            );

            return redirect()->back()->with('success', 'Email de test envoyé avec succès à ' . $demande->email_contact);
        } catch (\Exception $e) {
            \Log::error('Erreur d\'envoi de mail de test : ' . $e->getMessage() . ' - Détails : ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Erreur lors de l\'envoi de l\'email de test : ' . $e->getMessage());
        }
    }

}