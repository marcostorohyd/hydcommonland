<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

class DirectoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $entity_id = $this->faker->numberBetween(1, 7);

        return [
            'name' => ($entity_id == 1) ? $this->faker->name : $this->faker->company,
            'email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'web' => $this->faker->url,
            'address' => $this->faker->streetAddress,
            'zipcode' => $this->faker->numberBetween(1500, 25000),
            'city' => $this->faker->city,
            'country_id' => $this->faker->numberBetween(1, 74),
            'entity_id' => $entity_id,
            'contact_name' => ($entity_id == 1) ? null : $this->faker->name,
            'contact_email' => ($entity_id == 1) ? null : $this->faker->safeEmail,
            'contact_phone' => ($entity_id == 1) ? null : $this->faker->phoneNumber,
            'partners' => ($entity_id == 1) ? null : $this->faker->numberBetween(1, 50),
            'members' => ($entity_id == 1) ? null : $this->faker->numberBetween(1, 200),
            'represented' => ($entity_id == 1) ? null : $this->faker->numberBetween(1, 200),
            'surface' => ($entity_id == 5) ? $this->faker->numberBetween(1, 1000) : null,
            'image' => '',
            'facebook' => $this->faker->url,
            'linkedin' => $this->faker->url,
            'research_gate' => $this->faker->url,
            'instagram' => $this->faker->url,
            'twitter' => $this->faker->url,
            'youtube' => $this->faker->url,
            'vimeo' => $this->faker->url,
            'tiktok' => $this->faker->url,
            'whatsapp' => $this->faker->url,
            'telegram' => $this->faker->url,
            'orcid' => $this->faker->url,
            'academia_edu' => $this->faker->url,
            'status_id' => $this->faker->numberBetween(1, 3),
            'latitude' => $this->faker->latitude(35, 70),
            'longitude' => $this->faker->longitude(-30, 40),
        ];
    }
}
