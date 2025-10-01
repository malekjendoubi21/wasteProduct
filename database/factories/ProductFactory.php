<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Catégorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(3),
            'prix_base' => $this->faker->randomFloat(2, 5, 500),
            'stock' => $this->faker->numberBetween(0, 100),
            'type' => $this->faker->randomElement([
                Product::TYPE_RECYCLE,
                Product::TYPE_ALIMENTAIRE,
                Product::TYPE_NON_RECYCLE
            ]),
            'image' => null, // Vous pouvez ajouter des images factices si nécessaire
            'categorie_id' => Catégorie::factory(),
        ];
    }

    /**
     * Indicate that the product is recycled.
     */
    public function recycled(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Product::TYPE_RECYCLE,
        ]);
    }

    /**
     * Indicate that the product is food-related.
     */
    public function food(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Product::TYPE_ALIMENTAIRE,
        ]);
    }

    /**
     * Indicate that the product is not recycled.
     */
    public function nonRecycled(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Product::TYPE_NON_RECYCLE,
        ]);
    }

    /**
     * Indicate that the product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }

    /**
     * Indicate that the product has a specific category.
     */
    public function withCategory(Catégorie $category): static
    {
        return $this->state(fn (array $attributes) => [
            'categorie_id' => $category->id,
        ]);
    }
}