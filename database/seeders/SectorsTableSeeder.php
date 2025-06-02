<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sectors')->insert([
            ['id' => 1, 'color' => 'c7e1dc'],
            ['id' => 2, 'color' => 'f3cda6'],
            ['id' => 3, 'color' => 'e0beb3'],
            ['id' => 4, 'color' => 'c5c5a7'],
            ['id' => 5, 'color' => 'c7e1dc'],
            ['id' => 6, 'color' => 'f3cda6'],
            ['id' => 7, 'color' => '888888'],
            ['id' => 8, 'color' => '666666'],
        ]);

        DB::table('sector_translations')->insert([
            ['id' => 1, 'name' => 'Pastoril - Ganadero', 'locale' => 'es-ES', 'sector_id' => 1],
            ['id' => 2, 'name' => 'Cinegético - Caza', 'locale' => 'es-ES', 'sector_id' => 2],
            ['id' => 3, 'name' => 'Pesca - Marisqueo', 'locale' => 'es-ES', 'sector_id' => 3],
            ['id' => 4, 'name' => 'Riego', 'locale' => 'es-ES', 'sector_id' => 4],
            ['id' => 5, 'name' => 'Agrícola', 'locale' => 'es-ES', 'sector_id' => 5],
            ['id' => 6, 'name' => 'Espiritual - Sagrado', 'locale' => 'es-ES', 'sector_id' => 6],
            ['id' => 7, 'name' => 'Forestal', 'locale' => 'es-ES', 'sector_id' => 7],
            ['id' => 8, 'name' => 'ICCA - Territorios de vida', 'locale' => 'es-ES', 'sector_id' => 8],

            ['id' => 9, 'name' => 'Pastoralism', 'locale' => 'en', 'sector_id' => 1],
            ['id' => 10, 'name' => 'Hunting', 'locale' => 'en', 'sector_id' => 2],
            ['id' => 11, 'name' => 'Fishing - Shellfishing', 'locale' => 'en', 'sector_id' => 3],
            ['id' => 12, 'name' => 'Irrigation', 'locale' => 'en', 'sector_id' => 4],
            ['id' => 13, 'name' => 'Agricultural', 'locale' => 'en', 'sector_id' => 5],
            ['id' => 14, 'name' => 'Spiritual - Sacred', 'locale' => 'en', 'sector_id' => 6],
            ['id' => 15, 'name' => 'Forestry', 'locale' => 'en', 'sector_id' => 7],
            ['id' => 16, 'name' => 'ICCA - Territories of life', 'locale' => 'en', 'sector_id' => 8],

            ['id' => 17, 'name' => 'Pastoral - Élevage', 'locale' => 'fr', 'sector_id' => 1],
            ['id' => 18, 'name' => 'Cynégétique - Chasse', 'locale' => 'fr', 'sector_id' => 2],
            ['id' => 19, 'name' => 'Pêche - Pêche de coquillages et crustacés', 'locale' => 'fr', 'sector_id' => 3],
            ['id' => 20, 'name' => 'Irrigation', 'locale' => 'fr', 'sector_id' => 4],
            ['id' => 21, 'name' => 'Agricole', 'locale' => 'fr', 'sector_id' => 5],
            ['id' => 22, 'name' => 'Spirituel-Sacré', 'locale' => 'fr', 'sector_id' => 6],
            ['id' => 23, 'name' => 'Sylviculture', 'locale' => 'fr', 'sector_id' => 7],
            ['id' => 24, 'name' => 'APAC - Territoires de vie', 'locale' => 'fr', 'sector_id' => 8],
        ]);
    }
}
