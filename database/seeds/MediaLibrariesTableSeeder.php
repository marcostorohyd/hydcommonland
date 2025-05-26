<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MediaLibrariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $libraries = factory(App\MediaLibrary::class, 50)->create();

        $faker = Faker::create();
        foreach ($libraries as $library) {
            // Sectors
            $ids = $faker->randomElements(range(1, 6), rand(1, 6));
            $library->sectors()->sync($ids);

            // Tags
            $ids = $faker->randomElements(range(1, 5), rand(1, 5));
            $library->tags()->sync($ids);
        };
    }
}
