<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\WorkorderState;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workorder>
 */
class WorkorderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $client_ids = Client::pluck('id');
        $state_ids = WorkorderState::pluck('id');
        $user_ids = User::pluck('id');

        return [
            'client_id' => $this->faker->randomElement($client_ids),
            'state_id' => $this->faker->randomElement($state_ids),
            'user_id' => $this->faker->randomElement($user_ids),
            'car_initial_state' => $this->faker-> text(),
            'car_initial_date' => $this->faker-> dateTime(),
            'car_final_state' => $this->faker-> text(),
            'car_final_date' => $this->faker-> dateTime(),
            'car_workorder_price' => $this->faker-> numberBetween(100, 1000000),
            'client_sign' => $this->faker-> text(),
        ];
    }
}
