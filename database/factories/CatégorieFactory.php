<?php

namespace Database\Factories;

use App\Models\Catégorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catégorie>
 */
class CatégorieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Catégorie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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

        return [
            'label' => $this->faker->unique()->randomElement($categories),
        ];
    }
}