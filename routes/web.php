<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartenaireDemandeController;
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
    
    Route::get('/categories', function () {
        return view('BackOffice.categories.index');
    })->name('categories.index');
    
    Route::get('/orders', function () {
        return view('BackOffice.orders.index');
    })->name('orders.index');
    
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

});


// Route publique pour envoyer la demande de partenariat
    Route::post('/demande-partenariat', [PartenaireDemandeController::class, 'store'])
    ->name('demande.partenariat.store');

Route::post('/demande/{id}/send-test-email', [PartenaireDemandeController::class, 'sendTestEmail'])->name('demande.sendTestEmail');
// Routes auth (login, register, password, etc.)
require __DIR__.'/auth.php';
