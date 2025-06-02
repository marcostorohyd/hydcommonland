<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaLibraryFactory extends Factory
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
            'author' => $this->faker->name(),
            'email' => $this->faker->unique()->companyEmail(),
            'image' => '',
            'format_id' => $this->faker->numberBetween(1, 5),
            'external' => 1,
            'link' => $this->faker->url(),
            'length' => $this->faker->numberBetween(1, 500),
            'status_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
