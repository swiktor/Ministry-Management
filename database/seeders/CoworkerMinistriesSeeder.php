<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoworkerMinistriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('coworkers_ministries')->count();
        if ($count == 0) {
            $faker = Factory::create();

            for ($j = 0; $j < 10; $j++) {
                $coworkers_ministries = [];
                for ($i = 0; $i < 100; $i++) {
                    $coworkers_ministries[] = [
                        'coworker_id' => $faker->numberBetween(1, 100),
                        'ministry_id' => $faker->numberBetween(1, 100),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
                DB::table('coworkers_ministries')->insert($coworkers_ministries);
            }
        }
    }
}
