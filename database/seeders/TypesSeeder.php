<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('types')->count();
        if ($count == 0) {

            DB::table('types')->insert([
                [
                    'id' => '1',
                    'name' => 'PL',
                    'duration' => '02:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => '2',
                    'name' => 'PJM',
                    'duration' => '02:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => '3',
                    'name' => 'PL/PJM',
                    'duration' => '02:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => '4',
                    'name' => 'Wózek',
                    'duration' => '01:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => '5',
                    'name' => 'Listy',
                    'duration' => '01:30:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => '6',
                    'name' => 'Wyszukiwanie',
                    'duration' => '01:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => '7',
                    'name' => 'Zbiórka',
                    'duration' => '01:30:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => '8',
                    'name' => 'Grupowo',
                    'duration' => '00:00:00',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
        }
    }
}
