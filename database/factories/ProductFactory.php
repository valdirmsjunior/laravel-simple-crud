<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'image' => $this->faker->imageUrl(640, 480, 'products', true, 'Faker', true),
        ];
    }
}
