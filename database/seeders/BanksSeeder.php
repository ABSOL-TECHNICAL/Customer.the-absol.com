<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('banks')->delete();
$bank = array(
    array('id' => 5, 'bank_code' => '1', 'bank_name' => 'Kenya Commercial Bank Limited', 'bank_status' => '1'),
    array('id' => 6, 'bank_code' => '2', 'bank_name' => 'Standard Chartered Bank Kenya Limited', 'bank_status' => '1'),
    array('id' => 7, 'bank_code' => '3', 'bank_name' => 'Absa Bank Kenya PLC', 'bank_status' => '1'),
    array('id' => 8, 'bank_code' => '5', 'bank_name' => 'Bank of India', 'bank_status' => '1'),
    array('id' => 9, 'bank_code' => '6', 'bank_name' => 'Bank of Baroda (Kenya Limited)', 'bank_status' => '1'),
    array('id' => 10, 'bank_code' => '7', 'bank_name' => 'NCBA Bank Kenya PLC', 'bank_status' => '1'),
    array('id' => 11, 'bank_code' => '9', 'bank_name' => 'Central Bank of Kenya', 'bank_status' => '1'),
    array('id' => 12, 'bank_code' => '10', 'bank_name' => 'Prime Bank Limited', 'bank_status' => '1'),
    array('id' => 13, 'bank_code' => '11', 'bank_name' => 'Co-operative Bank of Kenya Limited', 'bank_status' => '1'),
    array('id' => 14, 'bank_code' => '12', 'bank_name' => 'National Bank of Kenya Limited', 'bank_status' => '1'),
    array('id' => 15, 'bank_code' => '14', 'bank_name' => 'M-Oriental Bank Limited', 'bank_status' => '1'),
    array('id' => 16, 'bank_code' => '16', 'bank_name' => 'Citibank N A', 'bank_status' => '1'),
    array('id' => 17, 'bank_code' => '17', 'bank_name' => 'Habib Bank A G Zurich', 'bank_status' => '1'),
    array('id' => 18, 'bank_code' => '18', 'bank_name' => 'Middle East Bank Kenya Limited', 'bank_status' => '1'),
    array('id' => 19, 'bank_code' => '19', 'bank_name' => 'Bank of Africa Kenya Limited', 'bank_status' => '1'),
    array('id' => 20, 'bank_code' => '23', 'bank_name' => 'Consolidated Bank of Kenya Limited', 'bank_status' => '1'),
    array('id' => 21, 'bank_code' => '25', 'bank_name' => 'Credit Bank Limited', 'bank_status' => '1'),
    array('id' => 22, 'bank_code' => '26', 'bank_name' => 'Trans-National Bank Limited', 'bank_status' => '1'),
    array('id' => 23, 'bank_code' => '30', 'bank_name' => 'Chase Bank Limited', 'bank_status' => '1'),
    array('id' => 24, 'bank_code' => '31', 'bank_name' => 'Stanbic Bank Kenya Limited', 'bank_status' => '1'),
    array('id' => 25, 'bank_code' => '35', 'bank_name' => 'African Banking Corp. Bank Ltd', 'bank_status' => '1'),
    array('id' => 26, 'bank_code' => '41', 'bank_name' => 'NIC Bank Limited', 'bank_status' => '1'),
    array('id' => 27, 'bank_code' => '43', 'bank_name' => 'ECO Bank Limited', 'bank_status' => '1'),
    array('id' => 28, 'bank_code' => '49', 'bank_name' => 'Spire Bank Ltd', 'bank_status' => '1'),
    array('id' => 29, 'bank_code' => '50', 'bank_name' => 'Paramount Universal Bank Limited', 'bank_status' => '1'),
    array('id' => 30, 'bank_code' => '51', 'bank_name' => 'Jamii Bora Bank', 'bank_status' => '1'),
    array('id' => 31, 'bank_code' => '53', 'bank_name' => 'Guaranty Trust Bank ( Kenya) Ltd.', 'bank_status' => '1'),
    array('id' => 32, 'bank_code' => '54', 'bank_name' => 'Victoria Commercial Bank Limited', 'bank_status' => '1'),
    array('id' => 33, 'bank_code' => '55', 'bank_name' => 'Guardian Bank Limited', 'bank_status' => '1'),
    array('id' => 34, 'bank_code' => '57', 'bank_name' => 'I&M Bank Limited', 'bank_status' => '1'),
    array('id' => 35, 'bank_code' => '59', 'bank_name' => 'Development Bank of Kenya Limited', 'bank_status' => '1'),
    array('id' => 36, 'bank_code' => '60', 'bank_name' => 'SBM Bank Kenya Limited', 'bank_status' => '1'),
    array('id' => 37, 'bank_code' => '61', 'bank_name' => 'Housing Finance Bank', 'bank_status' => '1'),
    array('id' => 38, 'bank_code' => '62', 'bank_name' => 'Kenya Post Office Savings Bank', 'bank_status' => '1'),
    array('id' => 39, 'bank_code' => '63', 'bank_name' => 'Diamond Trust Bank Limited', 'bank_status' => '1'),
    array('id' => 40, 'bank_code' => '65', 'bank_name' => 'Mayfair Bank Limited', 'bank_status' => '1'),
    array('id' => 41, 'bank_code' => '66', 'bank_name' => 'Sidian Bank Limited', 'bank_status' => '1'),
    array('id' => 42, 'bank_code' => '68', 'bank_name' => 'Equity Bank Limited', 'bank_status' => '1'),
    array('id' => 43, 'bank_code' => '70', 'bank_name' => 'Family Bank Ltd', 'bank_status' => '1'),
    array('id' => 44, 'bank_code' => '72', 'bank_name' => 'Gulf African Bank Ltd', 'bank_status' => '1'),
    array('id' => 45, 'bank_code' => '74', 'bank_name' => 'First Community Bank', 'bank_status' => '1'),
    array('id' => 46, 'bank_code' => '75', 'bank_name' => 'DIB Bank Kenya Limited', 'bank_status' => '1'),
    array('id' => 47, 'bank_code' => '76', 'bank_name' => 'UBA Kenya Bank Ltd', 'bank_status' => '1'),
    array('id' => 48, 'bank_code' => '77', 'bank_name' => 'Kenya Women Microfinance Bank PLC', 'bank_status' => '1'),
    array('id' => 49, 'bank_code' => '79', 'bank_name' => 'Faulu Microfinance Bank Ltd', 'bank_status' => '1')
);

DB::table('banks')->insert($bank);
    }
}
