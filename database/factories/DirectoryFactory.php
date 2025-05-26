<?php

use Faker\Generator as Faker;

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

$factory->define(App\Directory::class, function (Faker $faker) {
    $entity_id = $faker->numberBetween(1, 7);

    return [
        'name' => (1 == $entity_id) ? $faker->name : $faker->company,
        'email' => $faker->unique()->companyEmail,
        'phone' => $faker->phoneNumber,
        'web' => $faker->url,
        'address' => $faker->streetAddress,
        'zipcode' => $faker->numberBetween(1500, 25000),
        'city' => $faker->city,
        'country_id' => $faker->numberBetween(1, 74),
        'entity_id' => $entity_id,
        'contact_name' => (1 == $entity_id) ? null : $faker->name,
        'contact_email' => (1 == $entity_id) ? null : $faker->safeEmail,
        'contact_phone'=> (1 == $entity_id) ? null : $faker->phoneNumber,
        'partners' => (1 == $entity_id) ? null : $faker->numberBetween(1, 50),
        'members' => (1 == $entity_id) ? null : $faker->numberBetween(1, 200),
        'represented' => (1 == $entity_id) ? null : $faker->numberBetween(1, 200),
        'surface' => (5 == $entity_id) ? $faker->numberBetween(1, 1000) : null,
        'image' => '',
        'facebook' => $faker->url,
        'linkedin' => $faker->url,
        'research_gate' => $faker->url,
        'instagram' => $faker->url,
        'twitter' => $faker->url,
        'youtube' => $faker->url,
        'vimeo' => $faker->url,
        'tiktok' => $faker->url,
        'whatsapp' => $faker->url,
        'telegram' => $faker->url,
        'orcid' => $faker->url,
        'academia_edu' => $faker->url,
        'status_id' => $faker->numberBetween(1, 3),
        'latitude' => $faker->latitude(35, 70),
        'longitude' => $faker->longitude(-30, 40)
    ];
});
