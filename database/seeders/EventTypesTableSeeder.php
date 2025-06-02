<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_types')->insert([
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
            ['id' => 4],
            ['id' => 5],
        ]);

        DB::table('event_type_translations')->insert([
            ['id' => 1, 'name' => 'Taller', 'locale' => 'es-ES', 'event_type_id' => 1],
            ['id' => 2, 'name' => 'Reunión', 'locale' => 'es-ES', 'event_type_id' => 2],
            ['id' => 3, 'name' => 'Formación', 'locale' => 'es-ES', 'event_type_id' => 3],
            ['id' => 4, 'name' => 'Conferencia', 'locale' => 'es-ES', 'event_type_id' => 4],
            ['id' => 5, 'name' => 'Turístico cultural', 'locale' => 'es-ES', 'event_type_id' => 5],

            ['id' => 6, 'name' => 'Workshop', 'locale' => 'en', 'event_type_id' => 1],
            ['id' => 7, 'name' => 'Meeting', 'locale' => 'en', 'event_type_id' => 2],
            ['id' => 8, 'name' => 'Training', 'locale' => 'en', 'event_type_id' => 3],
            ['id' => 9, 'name' => 'Conference', 'locale' => 'en', 'event_type_id' => 4],
            ['id' => 10, 'name' => 'Tourist & Cultural', 'locale' => 'en', 'event_type_id' => 5],

            ['id' => 11, 'name' => 'Atelier', 'locale' => 'fr', 'event_type_id' => 1],
            ['id' => 12, 'name' => 'Réunion', 'locale' => 'fr', 'event_type_id' => 2],
            ['id' => 13, 'name' => 'Formation', 'locale' => 'fr', 'event_type_id' => 3],
            ['id' => 14, 'name' => 'Congrès', 'locale' => 'fr', 'event_type_id' => 4],
            ['id' => 15, 'name' => 'Touristico-culturel', 'locale' => 'fr', 'event_type_id' => 5],
        ]);
    }
}
