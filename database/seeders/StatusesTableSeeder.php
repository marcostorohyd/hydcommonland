<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            ['id' => 1, 'color' => 'f6993f', 'order' => 1],
            ['id' => 2, 'color' => '757e3c', 'order' => 4],
            ['id' => 3, 'color' => 'cc6457', 'order' => 3],
            ['id' => 4, 'color' => 'bba9a7', 'order' => 2],
        ]);

        DB::table('status_translations')->insert([
            ['id' => 1, 'name' => 'Pendiente', 'locale' => 'es-ES', 'status_id' => 1],
            ['id' => 2, 'name' => 'Aceptado', 'locale' => 'es-ES', 'status_id' => 2],
            ['id' => 3, 'name' => 'Rechazado', 'locale' => 'es-ES', 'status_id' => 3],

            ['id' => 4, 'name' => 'Pending', 'locale' => 'en', 'status_id' => 1],
            ['id' => 5, 'name' => 'Accepted', 'locale' => 'en', 'status_id' => 2],
            ['id' => 6, 'name' => 'Rejected', 'locale' => 'en', 'status_id' => 3],

            ['id' => 7, 'name' => 'En cours', 'locale' => 'fr', 'status_id' => 1],
            ['id' => 8, 'name' => 'Accepté', 'locale' => 'fr', 'status_id' => 2],
            ['id' => 9, 'name' => 'Refusé', 'locale' => 'fr', 'status_id' => 3],

            ['id' => 10, 'name' => 'Solicitud de cambios', 'locale' => 'es-ES', 'status_id' => 4],
            ['id' => 11, 'name' => 'Change request', 'locale' => 'en', 'status_id' => 4],
            ['id' => 12, 'name' => 'Demande de changement', 'locale' => 'fr', 'status_id' => 4],
        ]);
    }
}
