<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoworkersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        DB::table('coworkers')->truncate();


        for ($j = 0; $j < 1; $j++) {
            $coworkers = [];
            for ($i = 0; $i < 100; $i++) {
                $coworkers[] = [
                    'surname' => $faker->lastName(),
                    'name' => $faker->firstName(),
                    'active' => $faker->numberBetween(0, 1),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            DB::table('coworkers')->insert($coworkers);
        }
    }
}
