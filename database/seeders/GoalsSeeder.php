<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('goals')->insert([
            [
                'id' => '1',
                'name' => 'Głosiciel',
                'quantum' => '00:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '2',
                'name' => 'Betelczyk',
                'quantum' => '00:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '3',
                'name' => 'Pionier pomocniczy',
                'quantum' => '30:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '4',
                'name' => 'Pionier pomocniczy',
                'quantum' => '50:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '5',
                'name' => 'Pionier stały',
                'quantum' => '70:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '6',
                'name' => 'Pionier specjalny',
                'quantum' => '120:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '7',
                'name' => 'Pionier specjalny',
                'quantum' => '130:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '8',
                'name' => 'Nadzorca obwodu',
                'quantum' => '68:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '9',
                'name' => 'Misjonarz',
                'quantum' => '120:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '10',
                'name' => 'Misjonarz',
                'quantum' => '130:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);

    }
}
