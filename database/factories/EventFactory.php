<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(6),
        'email' => $faker->unique()->companyEmail,
        'start' => $faker->dateTimeThisYear(),
        'end' => $faker->dateTimeThisYear(),
        'register_url' => $faker->numberBetween(0, 1) ? $faker->url : null,
        'assistance' => $faker->numberBetween(0, 3),
        'type' => $faker->numberBetween(1, 5),
        'language' => $faker->locale,
        'venue_name' => $faker->sentence(4),
        'venue_address' => $faker->address,
        'country_id' => $faker->numberBetween(1, 74),
        'image' => '',
        'status_id' => $faker->numberBetween(1, 3),
    ];
});
