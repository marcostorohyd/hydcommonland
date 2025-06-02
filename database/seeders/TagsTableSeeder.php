<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
            ['id' => 4],
            ['id' => 5],
            ['id' => 6],
            ['id' => 7],
            ['id' => 8],
        ]);

        DB::table('tag_translations')->insert([
            ['id' => 1, 'name' => 'Paisajes', 'locale' => 'es-ES', 'tag_id' => 1],
            ['id' => 2, 'name' => 'Personas', 'locale' => 'es-ES', 'tag_id' => 2],
            ['id' => 3, 'name' => 'Patrimonio', 'locale' => 'es-ES', 'tag_id' => 3],
            ['id' => 4, 'name' => 'Actividades', 'locale' => 'es-ES', 'tag_id' => 4],
            ['id' => 5, 'name' => 'Eventos', 'locale' => 'es-ES', 'tag_id' => 5],
            ['id' => 6, 'name' => 'Especies', 'locale' => 'es-ES', 'tag_id' => 6],
            ['id' => 7, 'name' => 'Amenazas', 'locale' => 'es-ES', 'tag_id' => 7],
            ['id' => 8, 'name' => 'Gobernanza', 'locale' => 'es-ES', 'tag_id' => 8],

            ['id' => 9, 'name' => 'Landscapes', 'locale' => 'en', 'tag_id' => 1],
            ['id' => 10, 'name' => 'People', 'locale' => 'en', 'tag_id' => 2],
            ['id' => 11, 'name' => 'Heritage', 'locale' => 'en', 'tag_id' => 3],
            ['id' => 12, 'name' => 'Traditional activities and livelihoods', 'locale' => 'en', 'tag_id' => 4],
            ['id' => 13, 'name' => 'Events and initiatives', 'locale' => 'en', 'tag_id' => 5],
            ['id' => 14, 'name' => 'Species', 'locale' => 'en', 'tag_id' => 6],
            ['id' => 15, 'name' => 'Threats', 'locale' => 'en', 'tag_id' => 7],
            ['id' => 16, 'name' => 'Governance', 'locale' => 'en', 'tag_id' => 8],

            ['id' => 17, 'name' => 'Paysages', 'locale' => 'fr', 'tag_id' => 1],
            ['id' => 18, 'name' => 'Personnes', 'locale' => 'fr', 'tag_id' => 2],
            ['id' => 19, 'name' => 'Patrimoine', 'locale' => 'fr', 'tag_id' => 3],
            ['id' => 20, 'name' => 'Activités traditionnelles et moyens de subsistance', 'locale' => 'fr', 'tag_id' => 4],
            ['id' => 21, 'name' => 'Évènements et iniciatives', 'locale' => 'fr', 'tag_id' => 5],
            ['id' => 22, 'name' => 'Espèces', 'locale' => 'fr', 'tag_id' => 6],
            ['id' => 23, 'name' => 'Menaces', 'locale' => 'fr', 'tag_id' => 7],
            ['id' => 24, 'name' => 'Gouvernance', 'locale' => 'fr', 'tag_id' => 8],
        ]);
    }
}
