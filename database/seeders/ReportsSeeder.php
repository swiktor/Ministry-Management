<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($j = 0; $j < 1; $j++) {
            $reports = [];
            for ($i = 0; $i < 100; $i++) {
                $reports[] = [
                    'ministry_id' => $faker->unique()->numberBetween(1, 100),
                    'hours' => $faker->time(),
                    'placements' => $faker->numberBetween(1, 10),
                    'videos' => $faker->numberBetween(1, 10),
                    'returns' => $faker->numberBetween(1, 10),
                    'studies' => $faker->numberBetween(1, 10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            DB::table('reports')->insert($reports);
    }
    }
}
