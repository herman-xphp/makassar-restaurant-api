<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Restaurant',
            'description' => fake()->sentence(),
            'address' => fake()->address(),
            'latitude' => fake()->latitude(-5.2, -5.1),
            'longitude' => fake()->longitude(119.3, 119.5),
            'phone' => fake()->phoneNumber(),
            'cuisine_type' => fake()->randomElement(['Indonesian', 'Seafood', 'Chinese', 'Western', 'Japanese']),
            'rating' => fake()->randomFloat(2, 1, 5),
            'review_count' => fake()->numberBetween(0, 500),
            'image_url' => fake()->imageUrl(640, 480, 'food'),
        ];
    }
}
