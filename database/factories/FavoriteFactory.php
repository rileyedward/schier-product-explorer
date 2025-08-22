<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_sku' => fake()->numberBetween(1, 10),
            'product_name' => fake()->sentence(),
            'product_price' => fake()->numberBetween(1, 10),
            'image_url' => fake()->imageUrl(),
        ];
    }
}
