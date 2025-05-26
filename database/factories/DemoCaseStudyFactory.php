<?php

use Faker\Generator as Faker;

$factory->define(App\DemoCaseStudy::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(6),
        'date' => $faker->date(),
        'address' => $faker->address,
        'country_id' => $faker->numberBetween(1, 74),
        'link' => $faker->numberBetween(0, 1) ? $faker->url : null,
        'email' => $faker->unique()->companyEmail,
        'image' => '',
        'status_id' => $faker->numberBetween(1, 3),
    ];
});
