<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Status;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'info@antytec.com',
                'password' => bcrypt('password'),
                'is_admin' => 1,
                'approved_at' => now()
            ], [
                'email' => 'hola@colectivoverbena.info',
                'password' => bcrypt('hola18'),
                'is_admin' => 1,
                'approved_at' => now()
            ], [
                'email' => 'info@commonlandsnet.org',
                'password' => bcrypt('common18'),
                'is_admin' => 1,
                'approved_at' => now()
            ]
        ]);

        factory(App\User::class, 50)->create()->each(function ($user) {
            $user->directory()->save(factory(App\Directory::class)->make());
        });

        $locales = locales();
        $faker = Faker::create();
        $directories = \App\Directory::withoutGlobalScopes()->get();
        foreach ($directories as $directory) {
            // Tranlations
            $array = [];
            foreach ($locales as $lang) {
                $array["description:{$lang}"] = $faker->paragraph(40);
            }

            $directory->status_id = ($directory->user->approved_at) ? Status::APPROVED : $directory->status_id;
            $directory->fill($array)->save();

            // Sectors
            $ids = $faker->randomElements(range(1, 6), rand(1, 6));
            $directory->sectors()->sync($ids);
        };
    }
}
