<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 7),
            'room_id' => $this->faker->numberBetween(1, 7),
            'content' => $this->faker->sentence(),
        ];
    }
}
