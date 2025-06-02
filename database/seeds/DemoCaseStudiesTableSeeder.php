<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DemoCaseStudiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demos = \App\DemoCaseStudy::factory()->count(50)->create();

        $locales = locales();
        $faker = Faker::create();
        foreach ($demos as $demo) {
            // Tranlations
            $array = [];
            foreach ($locales as $lang) {
                $array["description:{$lang}"] = $faker->paragraph(40);
            }

            $demo->fill($array)->save();

            // Sectors
            $ids = $faker->randomElements(range(1, 6), rand(1, 6));
            $demo->sectors()->sync($ids);

            // Values
            $ids = $faker->randomElements(range(1, 10), rand(1, 10));
            $demo->values()->sync($ids);
        }
    }
}
