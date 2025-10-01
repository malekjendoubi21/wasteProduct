<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catégorie;
use App\Models\Product;

class CategoriesAndProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les catégories
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

        $createdCategories = [];
        foreach ($categories as $categoryName) {
            $category = Catégorie::firstOrCreate([
                'label' => $categoryName,
            ]);
            $createdCategories[] = $category;
        }

        // Créer des produits pour chaque catégorie
        $products = [
            'Électronique' => [
                ['nom' => 'Smartphone reconditionné', 'description' => 'Smartphone Samsung Galaxy remis à neuf, parfait état de fonctionnement', 'prix_base' => 299.99, 'stock' => 5, 'type' => 'recyclé'],
                ['nom' => 'Ordinateur portable recyclé', 'description' => 'PC portable Dell reconditionné, idéal pour le bureau', 'prix_base' => 449.99, 'stock' => 3, 'type' => 'recyclé'],
                ['nom' => 'Tablette rénovée', 'description' => 'iPad reconditionné avec écran neuf', 'prix_base' => 199.99, 'stock' => 8, 'type' => 'recyclé'],
            ],
            'Alimentation' => [
                ['nom' => 'Légumes bio locaux', 'description' => 'Assortiment de légumes frais de saison cultivés localement', 'prix_base' => 12.50, 'stock' => 20, 'type' => 'alimentaire'],
                ['nom' => 'Fruits de saison', 'description' => 'Paniers de fruits frais cueillis à maturité', 'prix_base' => 15.99, 'stock' => 15, 'type' => 'alimentaire'],
                ['nom' => 'Produits laitiers fermiers', 'description' => 'Fromages et yaourts artisanaux de producteurs locaux', 'prix_base' => 8.99, 'stock' => 12, 'type' => 'alimentaire'],
            ],
            'Vêtements' => [
                ['nom' => 'Jean vintage recyclé', 'description' => 'Jean Levi\'s vintage restauré et personnalisé', 'prix_base' => 45.00, 'stock' => 6, 'type' => 'recyclé'],
                ['nom' => 'T-shirt bio', 'description' => 'T-shirt en coton biologique, teinture naturelle', 'prix_base' => 25.00, 'stock' => 10, 'type' => 'recyclé'],
                ['nom' => 'Veste recyclée', 'description' => 'Veste en cuir véritable restaurée', 'prix_base' => 89.99, 'stock' => 4, 'type' => 'recyclé'],
            ],
            'Mobilier' => [
                ['nom' => 'Table en bois recyclé', 'description' => 'Table artisanale fabriquée à partir de palettes recyclées', 'prix_base' => 199.00, 'stock' => 2, 'type' => 'recyclé'],
                ['nom' => 'Chaise vintage restaurée', 'description' => 'Chaise des années 70 entièrement restaurée', 'prix_base' => 75.00, 'stock' => 8, 'type' => 'recyclé'],
                ['nom' => 'Étagère upcyclée', 'description' => 'Étagère créée à partir de matériaux de récupération', 'prix_base' => 120.00, 'stock' => 5, 'type' => 'recyclé'],
            ],
            'Jardin' => [
                ['nom' => 'Composteur maison', 'description' => 'Composteur fabriqué à partir de matériaux recyclés', 'prix_base' => 65.00, 'stock' => 7, 'type' => 'recyclé'],
                ['nom' => 'Jardinières recyclées', 'description' => 'Jardinières créées à partir de pneus usagés', 'prix_base' => 35.00, 'stock' => 12, 'type' => 'recyclé'],
                ['nom' => 'Outils de jardinage restaurés', 'description' => 'Set d\'outils de jardinage vintage remis à neuf', 'prix_base' => 55.00, 'stock' => 6, 'type' => 'recyclé'],
            ],
        ];

        foreach ($createdCategories as $category) {
            if (isset($products[$category->label])) {
                foreach ($products[$category->label] as $productData) {
                    Product::firstOrCreate([
                        'nom' => $productData['nom'],
                        'categorie_id' => $category->id,
                    ], [
                        'description' => $productData['description'],
                        'prix_base' => $productData['prix_base'],
                        'stock' => $productData['stock'],
                        'type' => $productData['type'],
                    ]);
                }
            }
        }

        $this->command->info('Catégories et produits créés avec succès!');
    }
}
