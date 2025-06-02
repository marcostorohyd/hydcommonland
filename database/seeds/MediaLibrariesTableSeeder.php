<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MediaLibrariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $libraries = \App\MediaLibrary::factory()->count(50)->create();

        $faker = Faker::create();
        foreach ($libraries as $library) {
            // Sectors
            $ids = $faker->randomElements(range(1, 6), rand(1, 6));
            $library->sectors()->sync($ids);

            // Tags
            $ids = $faker->randomElements(range(1, 5), rand(1, 5));
            $library->tags()->sync($ids);
        }
    }
}
