<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config')->insert([
            ['name' => 'contact_name', 'value' => 'Nombre Apellidos'],
            ['name' => 'contact_email', 'value' => 'correo@commonlandsnet.org'],
            ['name' => 'contact_phone', 'value' => '+34 000000000'],
        ]);
    }
}
