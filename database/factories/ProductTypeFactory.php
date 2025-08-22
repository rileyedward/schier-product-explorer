<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductType>
 */
class ProductTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $key = fake()->unique()->slug(2);

        return [
            'object' => 'product-type',
            'url' => '/product-types/'.$key,
            'name' => fake()->words(2, true),
            'key' => $key,
            'active' => fake()->boolean(80),
            'image' => fake()->optional(0.3)->imageUrl(),
            'created' => fake()->date('m/d/Y'),
            'last_updated' => fake()->date('m/d/Y'),
            'parent_id' => null,
            'types' => json_encode([]),
        ];
    }
}
