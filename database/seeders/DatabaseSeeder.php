<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        // Create additional test users
        User::factory(5)->create();

        // Create categories
        $categories = [
            'Électronique',
            'Alimentation',
            'Vêtements',
            'Mobilier',
            'Jardin',
            'Sport',
            'Livres',
            'Jouets',
            'Décoration',
            'Automobile',
        ];

        foreach ($categories as $categoryName) {
            \App\Models\Catégorie::create([
                'label' => $categoryName,
            ]);
        }

        // Create products for each category
        $categoriesCreated = \App\Models\Catégorie::all();
        
        foreach ($categoriesCreated as $category) {
            \App\Models\Product::factory(rand(3, 8))
                ->withCategory($category)
                ->create();
        }
    }
}
