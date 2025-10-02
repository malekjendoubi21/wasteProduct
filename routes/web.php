<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartenaireDemandeController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\FrontOffice\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssociationController; 
use App\Http\Controllers\DonationController; 
use App\Http\Controllers\EvenementFrontController; 


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Page d'accueil front office (alias)
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// Route de fallback pour les images de partenaires
Route::get('/storage/logos/{filename}', function($filename) {
    $path = storage_path('app/public/logos/' . $filename);
    
    if (file_exists($path)) {
        return response()->file($path);
    }
    
    // Retourner l'image par défaut si le fichier n'existe pas
    return response()->file(public_path('images/carr.png'));
})->where('filename', '.*');

// Route de fallback générale pour storage
Route::get('/storage/{path}', function($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (file_exists($fullPath)) {
        return response()->file($fullPath);
    }
    
    // Retourner l'image par défaut
    return response()->file(public_path('images/carr.png'));
})->where('path', '.*');

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


// ✅ Routes publiques pour les événements
Route::get('/evenement', [EvenementFrontController::class, 'listes'])->name('evenement.listes');
Route::get('/evenement/{evenement}', [EvenementFrontController::class, 'show'])->name('evenement.show');


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

    
  Route::post('/evenements/{evenement}/participate', [EvenementFrontController::class, 'participate'])->name('evenements.participate');
    });

// Routes protégées pour les admins uniquement
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('BackOffice.dashboard.dashboard');
    })->name('admin.dashboard');

    // BackOffice donation routes
    Route::get('/admin/donations', [DonationController::class, 'adminIndex'])->name('admin.donations.index');
    Route::get('/admin/donations/{donation}', [DonationController::class, 'show'])->name('admin.donations.show');
    
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
Route::get('/demande', [PartenaireDemandeController::class, 'index'])->name('demande.index');



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
  // Routes pour édition, mise à jour et suppression
Route::get('/evenements/{evenement}/edit', [EvenementController::class, 'edit'])->name('evenements.edit');
Route::put('/evenements/{evenement}', [EvenementController::class, 'update'])->name('evenements.update');
Route::delete('/evenements/{evenement}', [EvenementController::class, 'destroy'])->name('evenements.destroy');
  
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

    // Notifications: mark all as read
    Route::post('/notifications/read-all', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        return back();
    })->name('notifications.readAll');

    // Notifications pages
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');

    // Création d'une commande par un partenaire (FrontOffice)
    // Le contrôle d'accès (role=partenaire) est géré dans le contrôleur
    Route::get('/commander', [\App\Http\Controllers\FrontOrderController::class, 'create'])->name('front.orders.create');
    Route::post('/commander', [\App\Http\Controllers\FrontOrderController::class, 'store'])->name('front.orders.store');

});

// Routes FrontOffice pour l'affichage des produits
Route::get('/produits', [\App\Http\Controllers\ProductController::class, 'frontIndex'])->name('produits.index');
Route::get('/produits/{product}', [\App\Http\Controllers\ProductController::class, 'frontShow'])->name('produits.show');
Route::get('/produits/categorie/{categorie}', [\App\Http\Controllers\ProductController::class, 'frontByCategory'])->name('produits.category');

// Route pour servir les images directement (fallback)
Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    
    if (!file_exists($file)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($file);
    return response()->file($file, ['Content-Type' => $mimeType]);
})->where('path', '.*')->name('storage.serve');


// Route publique pour envoyer la demande de partenariat
    Route::post('/demande-partenariat', [PartenaireDemandeController::class, 'store'])
    ->name('demande.partenariat.store');

Route::post('/demande/{id}/send-test-email', [PartenaireDemandeController::class, 'sendTestEmail'])->name('demande.sendTestEmail');
// Routes auth (login, register, password, etc.)
require __DIR__.'/auth.php';
