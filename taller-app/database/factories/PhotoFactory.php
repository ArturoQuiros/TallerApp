<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Workorder;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $workorder_id = Workorder::pluck('id');

        return [

            'workorder_id' => $this->faker->randomElement($workorder_id),
            'link' => $this->faker-> text(),

        ];
    }
}
