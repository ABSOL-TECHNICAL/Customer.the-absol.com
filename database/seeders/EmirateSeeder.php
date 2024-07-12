<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmirateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('kenya_cities')->delete();
        $kenya_cities = [
            ["id" => 1, "city" => "ELDORET", "status" => 1],
    ["id" => 2, "city" => "EMBU", "status" => 1],
    ["id" => 3, "city" => "GARISSA", "status" => 1],
    ["id" => 4, "city" => "KAKAMEGA", "status" => 1],
    ["id" => 5, "city" => "KISUMU", "status" => 1],
    ["id" => 6, "city" => "LAMU", "status" => 1],
    ["id" => 7, "city" => "MERU", "status" => 1],
    ["id" => 8, "city" => "MOMBASA", "status" => 1],
    ["id" => 9, "city" => "NAIROBI", "status" => 1],
    ["id" => 10, "city" => "NAKURU", "status" => 1],
    ["id" => 11, "city" => "NYERI", "status" => 1],
    ["id" => 12, "city" => "THIKA", "status" => 1]
    ];
    DB::table('kenya_cities')->insert($kenya_cities);
    }
}
