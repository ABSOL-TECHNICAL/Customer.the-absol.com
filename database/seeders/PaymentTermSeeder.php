<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('payment_terms')->delete();
$payment_terms = [
    ["id" => "1", "payment_term_name" => "1 Day", "payment_term_description" => "1 Day", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "2", "payment_term_name" => "10 Days PDC", "payment_term_description" => "10 Days PDC", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "3", "payment_term_name" => "14 Days Net", "payment_term_description" => "14 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "4", "payment_term_name" => "14 Days PDC", "payment_term_description" => "14 Days PDC", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "5", "payment_term_name" => "21 Days Net", "payment_term_description" => "21 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    
    ["id" => "6", "payment_term_name" => "21 Days PDC", "payment_term_description" => "21 Days PDC", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "7", "payment_term_name" => "3 Days Net", "payment_term_description" => "3 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "8", "payment_term_name" => "3 Days PDC", "payment_term_description" => "3 Days PDC", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "9", "payment_term_name" => "30 Days Net", "payment_term_description" => "30 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "10", "payment_term_name" => "30 Days PDC", "payment_term_description" => "30 Days PDC", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],

    ["id" => "11", "payment_term_name" => "35 Days Net", "payment_term_description" => "35 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "12", "payment_term_name" => "45 Days Net", "payment_term_description" => "45 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "13", "payment_term_name" => "5 Days PDC", "payment_term_description" => "5 Days PDC", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "14", "payment_term_name" => "60 Days Net", "payment_term_description" => "60 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "15", "payment_term_name" => "7 Days Net", "payment_term_description" => "7 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],

    ["id" => "16", "payment_term_name" => "7 Days PDC", "payment_term_description" => "7 Days PDC", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "17", "payment_term_name" => "9 Days Net", "payment_term_description" => "9 Days Net", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "18", "payment_term_name" => "Immediate", "payment_term_description" => "Immediate", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "19", "payment_term_name" => "LC - 30 Days", "payment_term_description" => "LC - 30 Days", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "20", "payment_term_name" => "LC - 45 Days", "payment_term_description" => "LC - 45 Days", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],

    ["id" => "21", "payment_term_name" => "LC - 60 Days", "payment_term_description" => "LC - 60 Days", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
    ["id" => "22", "payment_term_name" => "LC - 90 Days", "payment_term_description" => "LC - 90 Days", "payment_term_status" => "1", "payment_term_end_date" => "2021-01-25 10:05:53"],
];
DB::table('payment_terms')->insert($payment_terms);
    }
}





















