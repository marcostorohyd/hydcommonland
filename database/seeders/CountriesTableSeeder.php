<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $countries = [];
        for ($i = 1; $i < 75; $i++) {
            $countries[] = ['id' => $i, 'contact_id' => $faker->numberBetween(1, 50)];
        }

        DB::table('countries')->insert($countries);

        $countries = [
            'Albania',
            'Alemania',
            'Andorra ',
            'Armenia ',
            'Austria ',
            'Azerbaiyán ',
            'Bélgica ',
            'Bielorrusia ',
            'Bosnia y Herzegovina',
            'Bulgaria ',
            'Chipre ',
            'Ciudad del Vaticano ',
            'Croacia ',
            'Dinamarca ',
            'Eslovaquia ',
            'Eslovenia ',
            'España ',
            'Estonia ',
            'Finlandia ',
            'Francia ',
            'Georgia',
            'Grecia ',
            'Hungría',
            'Irlanda',
            'Islandia ',
            'Italia ',
            'Kazajistán ',
            'Letonia ',
            'Liechtenstein ',
            'Lituania ',
            'Luxemburgo ',
            'Malta ',
            'Moldavia ',
            'Mónaco ',
            'Montenegro',
            'Noruega ',
            'Países Bajos ',
            'Polonia ',
            'Portugal ',
            'Reino Unido ',
            'República Checa',
            'República de Macedonia ',
            'Rumania',
            'Rusia ',
            'San Marino ',
            'Serbia ',
            'Suecia ',
            'Suiza ',
            'Ucrania',
            'Arabia Saudita',
            'Baréin',
            'Emiratos Árabes Unidos',
            'Irak',
            'Irán',
            'Israel',
            'Jordania',
            'Kuwait',
            'Líbano',
            'Libia',
            'Omán',
            'Catar',
            'Siria',
            'Sudán',
            'Yemen',
            'Turquía',
            'Estado Palestino (Franja de Gaza y Cisjordania)',
            'Chipre',
            'Egipto',
            'Argelia',
            'Egipto',
            'Libia',
            'Marruecos',
            'Sudán',
            'Túnez',
        ];

        $offset = 0;
        $countries_translations = [];
        for ($i = 1; $i < 75; $i++) {
            $countries_translations[] = ['id' => $i, 'name' => $countries[$i - 1], 'locale' => 'es-ES', 'country_id' => $i];
        }
        $offset = $i - 1;

        DB::table('country_translations')->insert($countries_translations);

        $countries = [
            'Albania',
            'Germany',
            'Andorra',
            'Armenia',
            'Austria',
            'Azerbaijan',
            'Belgium',
            'Belarus',
            'Bosnia and Herzegovina',
            'Bulgaria',
            'Cyprus',
            'Vatican City',
            'Croatia',
            'Denmark',
            'Slovakia',
            'Slovenia',
            'Spain',
            'Estonia',
            'Finland',
            'France',
            'Georgia',
            'Greece',
            'Hungary',
            'Ireland',
            'Iceland',
            'Italy',
            'Kazakhstan',
            'Latvia',
            'Liechtenstein',
            'Lithuania',
            'Luxembourg',
            'Malta',
            'Moldova',
            'Monaco',
            'Montenegro',
            'Norway',
            'Netherlands',
            'Poland',
            'Portugal',
            'United Kingdom',
            'Czech Republic',
            'Republic of Macedonia',
            'Romania',
            'Russia',
            'San Marino',
            'Serbia',
            'Sweden',
            'Switzerland',
            'Ukraine',
            'Saudi Arabia',
            'Bahrain',
            'United Arab Emirates',
            'Iraq',
            'Iran',
            'Israel',
            'Jordan',
            'Kuwait',
            'Lebanon',
            'Libya',
            'Oman',
            'Taste',
            'Syria',
            'Sudan',
            'Yemen',
            'Turkey',
            'Palestinian State (Gaza Strip and West Bank)',
            'Cyprus',
            'Egypt',
            'Algeria',
            'Egypt',
            'Libya',
            'Morocco',
            'Sudan',
            'Tunisia',
        ];

        $countries_translations = [];
        for ($i = 1; $i < 75; $i++) {
            $countries_translations[] = ['id' => $i + $offset, 'name' => $countries[$i - 1], 'locale' => 'en', 'country_id' => $i];
        }
        $offset += $i - 1;

        DB::table('country_translations')->insert($countries_translations);

        $countries = [
            'Albanie',
            'Allemagne',
            'Andorre',
            'Arménie',
            'Autriche',
            'Azerbaïdjan',
            'Belgique',
            'Biélorussie',
            'Bosnie-Herzégovine',
            'Bulgarie',
            'Chypre',
            'Vatican',
            'Croatie',
            'Danemark',
            'Slovaquie',
            'Slovénie',
            'Espagne',
            'Estonie',
            'Finlande',
            'France',
            'Géorgie',
            'Grèce',
            'Hongrie',
            'Irlande',
            'Islande',
            'Italie',
            'Kazakhstan',
            'Lettonie',
            'Liechtenstein',
            'Lituanie',
            'Luxembourg',
            'Malte',
            'Moldavie',
            'Monaco',
            'Monténégro',
            'Norvège',
            'Pays Bas',
            'Pologne',
            'Portugal',
            'Royaume-Uni',
            'République Tchèque',
            'République de Macédoine',
            'Roumanie',
            'Russie',
            'Saint-Marin',
            'Serbie',
            'Suède',
            'Suisse',
            'Ukraine',
            'Arabie Saoudite',
            'Bahreïn',
            'Émirats Arabes Unis',
            'Irak',
            'Iran',
            'Israël',
            'Jordanie',
            'Koweït',
            'Liban',
            'Libye',
            'Oman',
            'Qatar',
            'Syrie',
            'Soudan',
            'Yémen',
            'Turquie',
            'État de Palestine (bande de Gaza et Cisjordanie)',
            'Chypre',
            'Egypte',
            'Algérie',
            'Egypte',
            'Libye',
            'Maroc',
            'Soudan',
            'Tunisie',
        ];

        $countries_translations = [];
        for ($i = 1; $i < 75; $i++) {
            $countries_translations[] = ['id' => $i + $offset, 'name' => $countries[$i - 1], 'locale' => 'fr', 'country_id' => $i];
        }

        DB::table('country_translations')->insert($countries_translations);
    }
}
