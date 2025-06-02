<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
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
            'date' => $this->faker->dateTimeThisYear(),
            'country_id' => $this->faker->numberBetween(1, 74),
            'email' => $this->faker->unique()->companyEmail(),
            'link' => $this->faker->numberBetween(0, 1) ? $this->faker->url() : null,
            'image' => '',
            'status_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
