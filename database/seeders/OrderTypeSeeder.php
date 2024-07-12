<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('order_types')->delete();
        $order_types = [

            ["id" => 1, "order_type" => "BIO Industrial - KES", "order_status" => 1],
            ["id" => 2, "order_type" => "BIO Industrial - USD", "order_status" => 1],
            ["id" => 3, "order_type" => "Central DC Domestic Sales", "order_status" => 1],
            ["id" => 4, "order_type" => "Domestic Freight", "order_status" => 1],
            ["id" => 5, "order_type" => "EOL Exports Freight", "order_status" => 1],
            
            ["id" => 6, "order_type" => "FO CTS Sales", "order_status" => 1],
            ["id" => 7, "order_type" => "FO Duka Sales", "order_status" => 1],
            ["id" => 8, "order_type" => "FO Sales", "order_status" => 1],
            ["id" => 9, "order_type" => "FO Scrap Sales", "order_status" => 1],
            ["id" => 10, "order_type" => "NDC Domestic Ind - KES", "order_status" => 1],

            ["id" => 11, "order_type" => "NDC Domestic Sales", "order_status" => 1],
            ["id" => 12, "order_type" => "NDC Exports Sales - USD", "order_status" => 1],
            ["id" => 13, "order_type" => "Pwani Domestic Ind - KES", "order_status" => 1],
            ["id" => 14, "order_type" => "Pwani Domestic Ind - USD", "order_status" => 1],
            ["id" => 15, "order_type" => "Pwani Domestic Sales", "order_status" => 1],

            ["id" => 16, "order_type" => "Pwani Exports Freight", "order_status" => 1],
            ["id" => 17, "order_type" => "Pwani Exports Sales", "order_status" => 1],
            ["id" => 18, "order_type" => "Pwani Ind Exports", "order_status" => 1],
            ["id" => 19, "order_type" => "RDC Domestic Sales", "order_status" => 1],
            ["id" => 20, "order_type" => "Sub Dist Sales", "order_status" => 1],

            ["id" => 21, "order_type" => "Ukunda DC Domestic Sales", "order_status" => 1],
            ["id" => 22, "order_type" => "VSM CC", "order_status" => 1],
            ["id" => 23, "order_type" => "VSM MDC", "order_status" => 1],
            ["id" => 24, "order_type" => "VSM NDC", "order_status" => 1],
            ["id" => 25, "order_type" => "WDC Domestic Sales", "order_status" => 1],
        ];
        DB::table('order_types')->insert($order_types);
    }
}


























