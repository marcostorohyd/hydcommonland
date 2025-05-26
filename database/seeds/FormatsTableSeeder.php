<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('formats')->insert([
            ['id' => 1, 'color' => 'c8e2dc', 'media_collection' => 'video'],
            ['id' => 2, 'color' => 'f8d2aa', 'media_collection' => 'gallery'],
            ['id' => 3, 'color' => 'e1beb3', 'media_collection' => 'presentation'],
            ['id' => 4, 'color' => 'aeb086', 'media_collection' => 'document'],
            ['id' => 5, 'color' => 'a7adc7', 'media_collection' => 'audio'],
        ]);

        DB::table('format_translations')->insert([
            ['id' => 1, 'name' => 'Vídeos', 'locale' => 'es-ES', 'format_id' => 1],
            ['id' => 2, 'name' => 'Fotografias', 'locale' => 'es-ES', 'format_id' => 2],
            ['id' => 3, 'name' => 'Presentaciones', 'locale' => 'es-ES', 'format_id' => 3],
            ['id' => 4, 'name' => 'Documentos', 'locale' => 'es-ES', 'format_id' => 4],
            ['id' => 5, 'name' => 'Audios', 'locale' => 'es-ES', 'format_id' => 5],

            ['id' => 6, 'name' => 'Videos', 'locale' => 'en', 'format_id' => 1],
            ['id' => 7, 'name' => 'Photographs', 'locale' => 'en', 'format_id' => 2],
            ['id' => 8, 'name' => 'Presentations', 'locale' => 'en', 'format_id' => 3],
            ['id' => 9, 'name' => 'Documents', 'locale' => 'en', 'format_id' => 4],
            ['id' => 10, 'name' => 'Audios', 'locale' => 'en', 'format_id' => 5],

            ['id' => 11, 'name' => 'Vidéos', 'locale' => 'fr', 'format_id' => 1],
            ['id' => 12, 'name' => 'Photographies', 'locale' => 'fr', 'format_id' => 2],
            ['id' => 13, 'name' => 'Présentations', 'locale' => 'fr', 'format_id' => 3],
            ['id' => 14, 'name' => 'Documents', 'locale' => 'fr', 'format_id' => 4],
            ['id' => 15, 'name' => 'Audios', 'locale' => 'fr', 'format_id' => 5],
        ]);
    }
}
