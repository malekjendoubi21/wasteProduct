<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categorie;
use App\Models\Produit;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create partner user
        $partner = User::factory()->create([
            'name' => 'Partner User',
            'email' => 'partner@example.com',
            'role' => 'partenaire',
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        // Create a category and a product for smoke testing
        $cat = Categorie::create([
            'libelle' => 'Plastique',
            'date_creation' => now(),
        ]);

        Produit::create([
            'nom' => 'Bouteilles plastiques recyc',
            'description' => 'Lot de bouteilles recyclées',
            'stock' => 120,
            'prix_base' => 2.50,
            'type' => 'recycle',
            'categorie_id' => $cat->id,
            'user_id' => $partner->id,
        ]);

        // Create some extra users
        User::factory(3)->create();
    }
}
