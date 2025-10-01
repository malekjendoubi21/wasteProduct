<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\PanierProduitController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\ContratController;
use Illuminate\Support\Facades\Route;

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
});

// Routes protégées pour les admins uniquement (préfixées par /admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('BackOffice.dashboard.dashboard');
    })->name('admin.dashboard');
    
    // BackOffice Users page (placeholder)
    Route::get('/users', function () {
        return view('BackOffice.users.index');
    })->name('users.index');

    // BackOffice Reports page (placeholder)
    Route::get('/reports', function () {
        return view('BackOffice.reports.index');
    })->name('reports.index');

    // BackOffice Settings page (placeholder)
    Route::get('/settings', function () {
        return view('BackOffice.settings.index');
    })->name('settings.index');
    
    // Admin resources
    Route::resources([
        'produits' => ProduitController::class,
        'categories' => CategorieController::class,
        'commandes' => CommandeController::class,
        'paniers' => PanierController::class,
        'panier-items' => PanierProduitController::class,
        'donations' => DonationController::class,
        'associations' => AssociationController::class,
        'evenements' => EvenementController::class,
        'participations' => ParticipationController::class,
        'vehicules' => VehiculeController::class,
        'trajets' => TrajetController::class,
        'stocks' => StockController::class,
        'taches' => TacheController::class,
        'livraisons' => LivraisonController::class,
        'contrats' => ContratController::class,
    ]);
});

// Routes auth (login, register, password, etc.)
require __DIR__.'/auth.php';

// Front browse routes
Route::get('/catalogue', [ProduitController::class, 'index'])->name('catalogue');
Route::get('/produits/{produit}', [ProduitController::class, 'show'])->name('produits.show.public');
Route::get('/events', [EvenementController::class, 'index'])->name('events');
Route::get('/events/{evenement}', [EvenementController::class, 'show'])->name('events.show');
