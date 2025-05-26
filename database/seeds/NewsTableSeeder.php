<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $news = factory(App\News::class, 50)->create();

        $locales = locales();
        $faker = Faker::create();
        foreach ($news as $item) {
            // Tranlations
            $array = [];
            foreach ($locales as $lang) {
                $array["description:{$lang}"] = $faker->paragraph(40);
            }

            $item->fill($array)->save();

            // Sectors
            $ids = $faker->randomElements(range(1, 6), rand(1, 6));
            $item->sectors()->sync($ids);
        };
    }
}
