<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinistriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('ministries')->count();
        if ($count == 0) {
            $faker = Factory::create();

            for ($j = 0; $j < 1; $j++) {
                $ministries = [];
                for ($i = 0; $i < 100; $i++) {
                    $ministries[] = [
                        'type_id' => $faker->numberBetween(1, 8),
                        'when' => $faker->dateTime(),
                        'user_id' => $faker->numberBetween(1, 2),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
                DB::table('ministries')->insert($ministries);
            }
        }
    }
}
