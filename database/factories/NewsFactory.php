<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(6),
        'date' => $faker->dateTimeThisYear(),
        'country_id' => $faker->numberBetween(1, 74),
        'email' => $faker->unique()->companyEmail,
        'link' => $faker->numberBetween(0, 1) ? $faker->url : null,
        'image' => '',
        'status_id' => $faker->numberBetween(1, 3),
    ];
});
