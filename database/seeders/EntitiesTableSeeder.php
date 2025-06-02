<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entities')->insert([
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
            ['id' => 4],
            ['id' => 5],
            ['id' => 6],
            ['id' => 7],
            ['id' => 8],
        ]);

        DB::table('entity_translations')->insert([
            ['id' => 1, 'name' => 'Persona', 'locale' => 'es-ES', 'entity_id' => 1],
            ['id' => 2, 'name' => 'Centro de investigación/ enseñanza', 'locale' => 'es-ES', 'entity_id' => 2],
            ['id' => 3, 'name' => 'Empresa', 'locale' => 'es-ES', 'entity_id' => 3],
            ['id' => 4, 'name' => 'Comunidad que gobierna comunales', 'locale' => 'es-ES', 'entity_id' => 4],
            ['id' => 5, 'name' => 'Asociación o federación de comunidades que gobiernan comunales', 'locale' => 'es-ES', 'entity_id' => 5],
            ['id' => 6, 'name' => 'ONG que no representa comunidades', 'locale' => 'es-ES', 'entity_id' => 6],
            ['id' => 7, 'name' => 'Otra entidad', 'locale' => 'es-ES', 'entity_id' => 7],
            ['id' => 22, 'name' => 'Pueblos indígenas', 'locale' => 'es-ES', 'entity_id' => 8],

            ['id' => 8, 'name' => 'Person', 'locale' => 'en', 'entity_id' => 1],
            ['id' => 9, 'name' => 'Research / Teaching Centre', 'locale' => 'en', 'entity_id' => 2],
            ['id' => 10, 'name' => 'Company', 'locale' => 'en', 'entity_id' => 3],
            ['id' => 11, 'name' => 'Community governing commons', 'locale' => 'en', 'entity_id' => 4],
            ['id' => 12, 'name' => 'Association or federation of communities governing commons', 'locale' => 'en', 'entity_id' => 5],
            ['id' => 13, 'name' => 'NGO not representing a community', 'locale' => 'en', 'entity_id' => 6],
            ['id' => 14, 'name' => 'Other entity', 'locale' => 'en', 'entity_id' => 7],
            ['id' => 23, 'name' => 'Indigenous peoples', 'locale' => 'en', 'entity_id' => 8],

            ['id' => 15, 'name' => 'Personne', 'locale' => 'fr', 'entity_id' => 1],
            ['id' => 16, 'name' => 'Centre de recherche/ enseignement', 'locale' => 'fr', 'entity_id' => 2],
            ['id' => 17, 'name' => 'Entreprise', 'locale' => 'fr', 'entity_id' => 3],
            ['id' => 18, 'name' => 'Communauté gouvernant terres/eaux communales', 'locale' => 'fr', 'entity_id' => 4],
            ['id' => 19, 'name' => 'Association et fédération de communautés gouvernant terres/eaux communales', 'locale' => 'fr', 'entity_id' => 5],
            ['id' => 20, 'name' => 'ONG ne représentant pas de communautés', 'locale' => 'fr', 'entity_id' => 6],
            ['id' => 21, 'name' => 'Autre entité', 'locale' => 'fr', 'entity_id' => 7],
            ['id' => 24, 'name' => 'Peuples autochtones', 'locale' => 'fr', 'entity_id' => 8],
        ]);
    }
}
