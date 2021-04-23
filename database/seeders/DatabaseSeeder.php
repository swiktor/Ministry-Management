<?php

namespace Database\Seeders;

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
        $this->call([
            CoworkersSeeder::class,
            GoalsSeeder::class,
            TypesSeeder::class,
            MinistriesSeeder::class,
            CoworkerMinistriesSeeder::class,
            ReportsSeeder::class,
            ]);
    }
}
