<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(6),
            'email' => $this->faker->unique()->companyEmail,
            'start' => $this->faker->dateTimeThisYear(),
            'end' => $this->faker->dateTimeThisYear(),
            'register_url' => $this->faker->numberBetween(0, 1) ? $this->faker->url : null,
            'assistance' => $this->faker->numberBetween(0, 3),
            'type' => $this->faker->numberBetween(1, 5),
            'language' => $this->faker->locale,
            'venue_name' => $this->faker->sentence(4),
            'venue_address' => $this->faker->address,
            'country_id' => $this->faker->numberBetween(1, 74),
            'image' => '',
            'status_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
