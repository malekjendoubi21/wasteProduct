<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartenaireDemandeController;
use App\Http\Controllers\EvenementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssociationController; 
use App\Http\Controllers\DonationController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil publique
Route::get('/', function () {
    return view('FrontOffice.home.home');
})->name('home');

// Page d'accueil front office (alias)
Route::get('/home', function () {
    return view('FrontOffice.home.home');
})->name('home.index');

// Page about front office
Route::get('/about', function () {
    return view('FrontOffice.home.about');
})->name('about');

// Services page
Route::get('/services', function () {
    return view('FrontOffice.services.index');
})->name('services');

// Contact page
Route::get('/contact', function () {
    return view('FrontOffice.contact.index');
})->name('contact');



// Routes protégées pour les utilisateurs connectés
Route::middleware(['auth'])->group(function () {
    // Dashboard pour tous les utilisateurs connectés
    Route::get('/dashboard', function () {
        return view('BackOffice.dashboard.dashboard');
    })->name('dashboard');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');

 
 
    
    // Password update route
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    
   // Routes pour les dons (FrontOffice)
    Route::get('/dons', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/dons/creer/{product}', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/dons', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/dons/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
    Route::patch('/dons/{donation}', [DonationController::class, 'update'])->name('donations.update');
    Route::delete('/dons/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
  

});

// Routes protégées pour les admins uniquement
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('BackOffice.dashboard.dashboard');
    })->name('admin.dashboard');
    
    // Admin resource routes - using simple closures for now
    Route::get('/users', function () {
        return view('BackOffice.users.index');
    })->name('users.index');
    
    Route::get('/products', function () {
        return view('BackOffice.products.index');
    })->name('products.index');

   
    
    
 
     // Routes CRUD pour les associations (BackOffice) - UNIQUEMENT resource pour éviter conflits
    Route::resource('associations', AssociationController::class);
    // Route de recherche pour associations
    Route::get('/associations/search', [AssociationController::class, 'search'])->name('associations.search');
 });
    Route::get('/categories', function () {
        return view('BackOffice.categories.index');
    })->name('categories.index');
    
    // Orders routes managed by CommandeController below
    
    Route::get('/reports', function () {
        return view('BackOffice.reports.index');
    })->name('reports.index');
    
    Route::get('/settings', function () {
        return view('BackOffice.settings.index');
    })->name('settings.index');

    // Listes des Demandes de partenariat
    Route::get('/demandes-partenariat', [PartenaireDemandeController::class, 'index'])->name('demandeListes.index');
    // Afficher le détail d'une demande
    Route::get('/demande-partenariat/{id}', [PartenaireDemandeController::class, 'show'])->name('demande.show');
    // Mettre à jour le statut (Accepter / Refuser)
    Route::patch('/demande-partenariat/{id}/status', [PartenaireDemandeController::class, 'updateStatus'])->name('demande.updateStatus');

    // Routes CRUD pour les Catégories (BackOffice)
    Route::resource('categories', \App\Http\Controllers\CatégorieController::class);
    Route::get('/categories/search', [\App\Http\Controllers\CatégorieController::class, 'search'])->name('categories.search');

    // Routes CRUD pour les Produits (BackOffice) 
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::get('/products/search', [\App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
    Route::patch('/products/{product}/stock', [\App\Http\Controllers\ProductController::class, 'updateStock'])->name('products.updateStock');
//Routes CRUD pour les Événements (BackOffice)
    Route::get('/evenements', [EvenementController::class, 'index'])->name('evenements.index');
    Route::get('/evenements/create', [EvenementController::class, 'create'])->name('evenements.create');
    Route::post('/evenements', [EvenementController::class, 'store'])->name('evenements.store');
    Route::get('/evenements/{evenement}', [EvenementController::class, 'show'])->name('evenements.show');
  
  
    // Commandes, Livraisons, Véhicules, Trajets (BackOffice CRUD)
    Route::resource('orders', \App\Http\Controllers\CommandeController::class)->parameters([
        'orders' => 'order'
    ]);
    Route::resource('livraisons', \App\Http\Controllers\LivraisonController::class);
    Route::resource('vehicules', \App\Http\Controllers\VehiculeController::class);
    Route::resource('trajets', \App\Http\Controllers\TrajetController::class);



// Routes FrontOffice pour l'affichage des produits
Route::get('/produits', [\App\Http\Controllers\ProductController::class, 'frontIndex'])->name('produits.index');
Route::get('/produits/{product}', [\App\Http\Controllers\ProductController::class, 'frontShow'])->name('produits.show');
Route::get('/produits/categorie/{categorie}', [\App\Http\Controllers\ProductController::class, 'frontByCategory'])->name('produits.category');

// Routes FrontOffice pour les commandes (client)
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-commandes', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        $commandes = \App\Models\Commande::where('id_utilisateur', $user->id)->orderByDesc('date')->paginate(10);
        return view('FrontOffice.orders.index', compact('commandes'));
    })->name('front.orders.index');

    Route::get('/mes-commandes/{commande}', function (\App\Models\Commande $commande) {
        $userId = \Illuminate\Support\Facades\Auth::id();
        abort_unless($commande->id_utilisateur === $userId, 403);
        $commande->load('product', 'livraisons.trajet.vehicule');
        return view('FrontOffice.orders.show', compact('commande'));
    })->name('front.orders.show');

    // Création d'une commande par un partenaire (FrontOffice)
    // Le contrôle d'accès (role=partenaire) est géré dans le contrôleur
    Route::get('/commander', [\App\Http\Controllers\FrontOrderController::class, 'create'])->name('front.orders.create');
    Route::post('/commander', [\App\Http\Controllers\FrontOrderController::class, 'store'])->name('front.orders.store');

});

// Routes FrontOffice pour l'affichage des produits
Route::get('/produits', [\App\Http\Controllers\ProductController::class, 'frontIndex'])->name('produits.index');
Route::get('/produits/{product}', [\App\Http\Controllers\ProductController::class, 'frontShow'])->name('produits.show');
Route::get('/produits/categorie/{categorie}', [\App\Http\Controllers\ProductController::class, 'frontByCategory'])->name('produits.category');


// Route publique pour envoyer la demande de partenariat
    Route::post('/demande-partenariat', [PartenaireDemandeController::class, 'store'])
    ->name('demande.partenariat.store');

Route::post('/demande/{id}/send-test-email', [PartenaireDemandeController::class, 'sendTestEmail'])->name('demande.sendTestEmail');
// Routes auth (login, register, password, etc.)
require __DIR__.'/auth.php';
