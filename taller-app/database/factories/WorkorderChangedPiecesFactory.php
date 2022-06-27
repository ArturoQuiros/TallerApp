<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Workorder;
use App\Models\Piece;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkorderChangedPieces>
 */
class WorkorderChangedPiecesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $workorder_ids = Workorder::pluck('id');
        $piece_ids = Piece::pluck('id');

        return [
            'workorder_id' => $this->faker->randomElement($workorder_ids),
            'piece_id' => $this->faker->randomElement($piece_ids),
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
