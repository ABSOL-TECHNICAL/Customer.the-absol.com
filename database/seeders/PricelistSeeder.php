<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricelistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('price_lists')->delete();
        $price_lists = [
            ["id" => 1, "price_list_name" => "Winter Price List", "Status" => 1],
            ["id" => 2, "price_list_name" => "Summer Price List", "Status" => 1],
            ["id" => 3, "price_list_name" => "VSM MDC", "Status" => 1],
            ["id" => 4, "price_list_name" => "Tawakal", "Status" => 1],
            ["id" => 5, "price_list_name" => "TruFoods Purchasing Pricelist", "Status" => 1],
            ["id" => 6, "price_list_name" => "HUB N Eastern", "Status" => 1],
            ["id" => 7, "price_list_name" => "CC N Eastern", "Status" => 1],
            ["id" => 8, "price_list_name" => "Maguna-Andu Wholesalers (K) LTD", "Status" => 1],
            ["id" => 9, "price_list_name" => "Kanini Haraka Ent LTD", "Status" => 1],
            ["id" => 10, "price_list_name" => "Ouru Superstore", "Status" => 1],
            ["id" => 11, "price_list_name" => "Criss Cross", "Status" => 1],
            ["id" => 12, "price_list_name" => "Distribution HUB", "Status" => 1],
            ["id" => 13, "price_list_name" => "New Pramukh", "Status" => 1],
            ["id" => 14, "price_list_name" => "Jambo Pay Price List", "Status" => 1],
            ["id" => 15, "price_list_name" => "FO NDC", "Status" => 1],
            ["id" => 16, "price_list_name" => "Contract Van Sales", "Status" => 1],
            ["id" => 17, "price_list_name" => "Uchumi", "Status" => 1],
            ["id" => 18, "price_list_name" => "Ongujo", "Status" => 1],
            ["id" => 19, "price_list_name" => "Malawi", "Status" => 1],
            ["id" => 20, "price_list_name" => "Moses Junior Distributors", "Status" => 1],
            ["id" => 21, "price_list_name" => "Mega Wholesalers", "Status" => 1],
            ["id" => 22, "price_list_name" => "ISO Price List", "Status" => 1],
            ["id" => 23, "price_list_name" => "Tridah Wholesalers Ltd", "Status" => 1],
            ["id" => 24, "price_list_name" => "Shake Distributors Ltd", "Status" => 1],
            ["id" => 25, "price_list_name" => "EEDI", "Status" => 1],
            ["id" => 26, "price_list_name" => "Distribution CC", "Status" => 1],
            ["id" => 27, "price_list_name" => "Peter Mulei & Sons LTD - Wholesale", "Status" => 1],
            ["id" => 28, "price_list_name" => "Mt.Kenya", "Status" => 1],
            ["id" => 29, "price_list_name" => "CC - Loitoktok", "Status" => 1],
            ["id" => 30, "price_list_name" => "Mahitaji", "Status" => 1],
            ["id" => 31, "price_list_name" => "Tuskys", "Status" => 1],
            ["id" => 32, "price_list_name" => "Hub Eastern", "Status" => 1],
            ["id" => 33, "price_list_name" => "Hub Rift Valley", "Status" => 1],
            ["id" => 34, "price_list_name" => "Chutzpah Limited", "Status" => 1],
            ["id" => 35, "price_list_name" => "Linco Stores Ltd", "Status" => 1],
            ["id" => 36, "price_list_name" => "CC Nyanza & Western", "Status" => 1],
            ["id" => 37, "price_list_name" => "HUB -GNB", "Status" => 1],
            ["id" => 38, "price_list_name" => "HUB Coast", "Status" => 1],
            ["id" => 39, "price_list_name" => "Bus Bul Trading Co. Limited", "Status" => 1],
            ["id" => 40, "price_list_name" => "Sojpar Ltd Price List", "Status" => 1],
            ["id" => 41, "price_list_name" => "Kisii Matt", "Status" => 1],
            ["id" => 42, "price_list_name" => "Khetia Drapers Limited", "Status" => 1],
            ["id" => 43, "price_list_name" => "Pramukh", "Status" => 1],
            ["id" => 44, "price_list_name" => "Raisons Distributors Ltd", "Status" => 1],
            ["id" => 45, "price_list_name" => "Mesora Supermarket LTD", "Status" => 1],
            ["id" => 46, "price_list_name" => "Kavrink Distributors Ltd", "Status" => 1],
            ["id" => 47, "price_list_name" => "Distribution CC1", "Status" => 1],
            ["id" => 48, "price_list_name" => "Shariff", "Status" => 1],
            ["id" => 49, "price_list_name" => "Top Line Ltd", "Status" => 1]
        ];
        DB::table('price_lists')->insert($price_lists);
    
    }
}
