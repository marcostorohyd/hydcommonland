<?php

use Faker\Generator as Faker;

$factory->define(App\MediaLibrary::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(6),
        'date' => $faker->dateTimeThisYear(),
        'country_id' => $faker->numberBetween(1, 74),
        'author' => $faker->name,
        'email' => $faker->unique()->companyEmail,
        'image' => '',
        'format_id' => $faker->numberBetween(1, 5),
        'external' => 1,
        'link' => $faker->url,
        'length' => $faker->numberBetween(1, 500),
        'status_id' => $faker->numberBetween(1, 3),
    ];
});
