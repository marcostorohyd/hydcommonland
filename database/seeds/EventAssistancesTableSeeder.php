<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventAssistancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_assistances')->insert([
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ]);

        DB::table('event_assistance_translations')->insert([
            ['id' => 1, 'name' => 'Inscripción', 'locale' => 'es-ES', 'event_assistance_id' => 1],
            ['id' => 2, 'name' => 'Invitación', 'locale' => 'es-ES', 'event_assistance_id' => 2],
            ['id' => 3, 'name' => 'Entrada libre', 'locale' => 'es-ES', 'event_assistance_id' => 3],

            ['id' => 4, 'name' => 'Registration', 'locale' => 'en', 'event_assistance_id' => 1],
            ['id' => 5, 'name' => 'Accepted', 'locale' => 'en', 'event_assistance_id' => 2],
            ['id' => 6, 'name' => 'Invitation', 'locale' => 'en', 'event_assistance_id' => 3],

            ['id' => 7, 'name' => 'Inscription', 'locale' => 'fr', 'event_assistance_id' => 1],
            ['id' => 8, 'name' => 'Invitation', 'locale' => 'fr', 'event_assistance_id' => 2],
            ['id' => 9, 'name' => 'Entrée libre', 'locale' => 'fr', 'event_assistance_id' => 3],
        ]);
    }
}
