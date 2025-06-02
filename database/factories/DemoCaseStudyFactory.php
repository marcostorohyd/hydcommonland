<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DemoCaseStudyFactory extends Factory
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
            'date' => $this->faker->date(),
            'address' => $this->faker->address(),
            'country_id' => $this->faker->numberBetween(1, 74),
            'link' => $this->faker->numberBetween(0, 1) ? $this->faker->url() : null,
            'email' => $this->faker->unique()->companyEmail(),
            'image' => '',
            'status_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
