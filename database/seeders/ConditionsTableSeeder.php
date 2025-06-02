<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conditions')->insert([
            ['id' => 1],
            ['id' => 2],
        ]);

        DB::table('condition_translations')->insert([
            ['id' => 1, 'name' => 'Ninguno', 'locale' => 'es-ES', 'condition_id' => 1],
            ['id' => 2, 'name' => 'ICCA - Territorios de vida', 'locale' => 'es-ES', 'condition_id' => 2],

            ['id' => 3, 'name' => 'None', 'locale' => 'en', 'condition_id' => 1],
            ['id' => 4, 'name' => 'ICCA - Territories of life', 'locale' => 'en', 'condition_id' => 2],

            ['id' => 5, 'name' => 'Aucun', 'locale' => 'fr', 'condition_id' => 1],
            ['id' => 6, 'name' => 'APAC - Territoires de vie', 'locale' => 'fr', 'condition_id' => 2],
        ]);
    }
}
