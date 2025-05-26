<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Value;

class DemoCaseStudiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demos = factory(App\DemoCaseStudy::class, 50)->create();

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
        };
    }
}
