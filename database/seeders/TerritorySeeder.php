<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TerritorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('territories')->delete();
        $territories = [
            ["id" => 1, "territory" => "SOUTH EAST", "status" => 1, "country_id" => 110],
            ["id" => 2, "territory" => "Western", "status" => 1, "country_id" => 110],
            ["id" => 3, "territory" => "South Rift", "status" => 1, "country_id" => 110],
            ["id" => 4, "territory" => "Nyanza", "status" => 1, "country_id" => 110],
            ["id" => 5, "territory" => "North Rift", "status" => 1, "country_id" => 110],
            ["id" => 6, "territory" => "North Eastern", "status" => 1, "country_id" => 110],
            ["id" => 7, "territory" => "Nairobi", "status" => 1, "country_id" => 110],
            ["id" => 8, "territory" => "Eastern", "status" => 1, "country_id" => 110],
            ["id" => 9, "territory" => "Coast", "status" => 1, "country_id" => 110],
            ["id" => 10, "territory" => "Central", "status" => 1, "country_id" => 110],
     ];
    DB::table('territories')->insert($territories);
    }
}
