<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(EntitiesTableSeeder::class);
        $this->call(SectorsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(EventAssistancesTableSeeder::class);
        $this->call(EventTypesTableSeeder::class);
        $this->call(ValuesTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(FormatsTableSeeder::class);
        $this->call(TagsTableSeeder::class);

        // Factory
        // $this->call(DirectoriesTableSeeder::class);
        // $this->call(EventsTableSeeder::class);
        // $this->call(NewsTableSeeder::class);
        // $this->call(DemoCaseStudiesTableSeeder::class);
        // $this->call(MediaLibrariesTableSeeder::class);
    }
}
