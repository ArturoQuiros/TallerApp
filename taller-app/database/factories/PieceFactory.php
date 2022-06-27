<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Piece>
 */
class PieceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->faker->firstName(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'cost' => $this->faker->numberBetween(100, 10000),
            'is_active' => true,
        ];
    }
}
