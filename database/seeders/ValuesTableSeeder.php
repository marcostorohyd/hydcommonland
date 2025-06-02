<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('values')->insert([
            ['id' => 1, 'color' => 'aad2ca'],
            ['id' => 2, 'color' => '67742e'],
            ['id' => 3, 'color' => '174271'],
            ['id' => 4, 'color' => 'eda357'],
            ['id' => 5, 'color' => 'e45a4d'],
            ['id' => 6, 'color' => 'a23d34'],
            ['id' => 7, 'color' => 'f5c799'],
            ['id' => 8, 'color' => 'f09e8c'],
            ['id' => 9, 'color' => 'a9a064'],
            ['id' => 10, 'color' => '7c7c7b'],
        ]);

        DB::table('value_translations')->insert([
            ['id' => 1, 'name' => '1. Derechos de tenencia seguros', 'locale' => 'es-ES', 'value_id' => 1],
            ['id' => 2, 'name' => '2. Sistemas agrícolas en pequeña escala sólidos', 'locale' => 'es-ES', 'value_id' => 2],
            ['id' => 3, 'name' => '3. Diversidad en los sistemas de tenencia', 'locale' => 'es-ES', 'value_id' => 3],
            ['id' => 4, 'name' => '4. Igualdad en los derechos a la tierra para las mujeres', 'locale' => 'es-ES', 'value_id' => 4],
            ['id' => 5, 'name' => '5. Derechos territoriales seguros para los pueblos indígenas', 'locale' => 'es-ES', 'value_id' => 5],
            ['id' => 6, 'name' => '6. Ordenación local de los ecosistemas', 'locale' => 'es-ES', 'value_id' => 6],
            ['id' => 7, 'name' => '7. Toma de decisiones inclusiva', 'locale' => 'es-ES', 'value_id' => 7],
            ['id' => 8, 'name' => '8. Información y rendición de cuentas transparentes', 'locale' => 'es-ES', 'value_id' => 8],
            ['id' => 9, 'name' => '9. Medidas eficaces contra el acaparamiento de tierras', 'locale' => 'es-ES', 'value_id' => 9],
            ['id' => 10, 'name' => '10. Protección de los defensores de los derechos a la tierra', 'locale' => 'es-ES', 'value_id' => 10],

            ['id' => 11, 'name' => '1. Secure tenure rights', 'locale' => 'en', 'value_id' => 1],
            ['id' => 12, 'name' => '2. Strong small‑scale farming systems', 'locale' => 'en', 'value_id' => 2],
            ['id' => 13, 'name' => '3. Diverse tenure systems', 'locale' => 'en', 'value_id' => 3],
            ['id' => 14, 'name' => '4. Equal land rights for women', 'locale' => 'en', 'value_id' => 4],
            ['id' => 15, 'name' => '5. Secure territorial rights for indigenous peoples', 'locale' => 'en', 'value_id' => 5],
            ['id' => 16, 'name' => '6. Locally managed ecosystems', 'locale' => 'en', 'value_id' => 6],
            ['id' => 17, 'name' => '7. Inclusive decision‑making', 'locale' => 'en', 'value_id' => 7],
            ['id' => 18, 'name' => '8. Transparent and accountable information', 'locale' => 'en', 'value_id' => 8],
            ['id' => 19, 'name' => '9. Effective actions against land grabbing', 'locale' => 'en', 'value_id' => 9],
            ['id' => 20, 'name' => '10. Protected land rights defenders', 'locale' => 'en', 'value_id' => 10],

            ['id' => 21, 'name' => '1. Sécurité des droits fonciers', 'locale' => 'fr', 'value_id' => 1],
            ['id' => 22, 'name' => '2. Renforcer les systèmes agricoles de petite échelle', 'locale' => 'fr', 'value_id' => 2],
            ['id' => 23, 'name' => '3. Diversité des systèmes fonciers', 'locale' => 'fr', 'value_id' => 3],
            ['id' => 24, 'name' => '4. Egalité des droits fonciers pour les femmes', 'locale' => 'fr', 'value_id' => 4],
            ['id' => 25, 'name' => '5. Sécuriser les droits fonciers territoriaux pour les peuples autochtones', 'locale' => 'fr', 'value_id' => 5],
            ['id' => 26, 'name' => '6. Ecosystèmes gérés localement', 'locale' => 'fr', 'value_id' => 6],
            ['id' => 27, 'name' => '7. Prise de décision inclusive', 'locale' => 'fr', 'value_id' => 7],
            ['id' => 28, 'name' => '8. Informer de manière transparente et rendre des comptes', 'locale' => 'fr', 'value_id' => 8],
            ['id' => 29, 'name' => '9. Agir efficacement contre l’accaparement des terres', 'locale' => 'fr', 'value_id' => 9],
            ['id' => 30, 'name' => '10. La protection des défenseurs des droits fonciers', 'locale' => 'fr', 'value_id' => 10],
        ]);
    }
}
