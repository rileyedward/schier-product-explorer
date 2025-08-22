<?php

namespace Database\Factories;

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
            'api_id' => fake()->unique()->numberBetween(1, 1000),
            'name' => fake()->word(),
            'short_name' => fake()->word(),
            'part_number' => fake()->unique()->regexify('[A-Z0-9]{4}-[A-Z0-9]{3}-[A-Z0-9]{2}'),
            'store_id' => fake()->optional()->numerify('###'),
            'shipping_group' => fake()->optional()->randomElement(['Small', 'Medium', 'Large', 'Accessory']),
            'active' => fake()->boolean(),
            'visible_on_store' => fake()->boolean(),
            'description' => fake()->optional()->paragraph(),
            'short_description' => fake()->optional()->sentence(),
            'website_url' => fake()->optional()->url(),
            'types' => json_encode([fake()->word(), fake()->word()]),
            'images' => json_encode([
                'object' => 'product-image-library',
                'primary' => [
                    'object' => 'image-library',
                    'orig' => fake()->imageUrl(),
                    'lg' => fake()->imageUrl(),
                    'md' => fake()->imageUrl(),
                    'sm' => fake()->imageUrl(),
                ],
                'dimension' => [
                    'object' => 'image-library',
                    'orig' => fake()->imageUrl(),
                    'lg' => fake()->imageUrl(),
                    'md' => fake()->imageUrl(),
                    'sm' => fake()->imageUrl(),
                ],
            ]),
            'price' => json_encode([
                'object' => 'product-price',
                'list' => fake()->randomFloat(2, 10, 1000),
                'retail' => [
                    'object' => 'price',
                    'price' => fake()->randomFloat(2, 10, 1000),
                    'multiplier' => 0.65,
                ],
                'wholesale' => [
                    'object' => 'price',
                    'price' => fake()->randomFloat(2, 10, 1000),
                    'multiplier' => 0.55,
                ],
                'stocking_wholesale' => [
                    'object' => 'price',
                    'price' => fake()->randomFloat(2, 10, 1000),
                    'multiplier' => 0.44,
                ],
            ]),
            'base_dimensions' => json_encode([
                'object' => 'dimension-set',
                'standard' => [
                    'object' => 'dimensions',
                    'length' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'in',
                    ],
                    'width' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'in',
                    ],
                    'height' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'in',
                    ],
                    'weight' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'lbs',
                    ],
                ],
                'metric' => [
                    'object' => 'dimensions',
                    'length' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'cm',
                    ],
                    'width' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'cm',
                    ],
                    'height' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'cm',
                    ],
                    'weight' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'kg',
                    ],
                ],
            ]),
            'shipping_dimensions' => json_encode([
                'object' => 'dimension-set',
                'standard' => [
                    'object' => 'dimensions',
                    'length' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'in',
                    ],
                    'width' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'in',
                    ],
                    'height' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'in',
                    ],
                    'weight' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'lbs',
                    ],
                ],
                'metric' => [
                    'object' => 'dimensions',
                    'length' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'cm',
                    ],
                    'width' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'cm',
                    ],
                    'height' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'cm',
                    ],
                    'weight' => [
                        'object' => 'measurement',
                        'value' => fake()->randomFloat(2, 1, 100),
                        'unit' => 'kg',
                    ],
                ],
            ]),
            'created' => fake()->date(),
            'updated' => fake()->date(),
        ];
    }
}
