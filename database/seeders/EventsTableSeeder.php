<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = \App\Event::factory()->count(50)->create();

        $locales = locales();
        $faker = Faker::create();
        foreach ($events as $event) {
            // Tranlations
            $array = [];
            foreach ($locales as $lang) {
                $array["description:{$lang}"] = $faker->paragraph(40);
            }

            $event->fill($array)->save();

            // Sectors
            $ids = $faker->randomElements(range(1, 6), rand(1, 6));
            $event->sectors()->sync($ids);
        }
    }
}
