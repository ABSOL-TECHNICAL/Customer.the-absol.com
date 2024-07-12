<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('currencies')->delete();
        DB::table('currencies')->insert([
            ['id' => '1', 'currency_code' =>'AED' , 'currency_name' => 'AED', 'currency_symbol' => 'د.إ', 'currency_status' => '1'],
            ['id' => '2', 'currency_code' =>'GBP' , 'currency_name' => 'GBP', 'currency_symbol' => '£', 'currency_status' => '1'],
            ['id' => '3', 'currency_code' =>'EUR' , 'currency_name' => 'EUR', 'currency_symbol' => '(Є)', 'currency_status' => '1'],
            ['id' => '4', 'currency_code' =>'USD' , 'currency_name' => 'USD', 'currency_symbol' => '$', 'currency_status' => '1'],
            ['id' => '5', 'currency_code' =>'KES' , 'currency_name' => 'KES', 'currency_symbol' => '/-', 'currency_status' => '1'],
            ['id' => '6', 'currency_code' =>'INR' , 'currency_name' => 'INR', 'currency_symbol' => '₹', 'currency_status' => '1'],
            ['id' => '7', 'currency_code' =>'TZS' , 'currency_name' => 'TZS', 'currency_symbol' => 'TSh', 'currency_status' => '1'],
            ['id' => '8', 'currency_code' => 'ZAR', 'currency_name' => 'ZAR', 'currency_symbol' => 'R', 'currency_status' => '1'],
        ]);

    }
}
