<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table("company_types")->delete();
        $companyTypes = [
            [
                'id' => '1',
                'company_type_name' => 'Supplier',
                'legal_information_restriction' => '1',
            ],
            [
                'id' => '2',
                'company_type_name' => 'Customer',
                'legal_information_restriction' => '1',
            ],
           
        ];

        // Insert data into the database
        DB::table('company_types')->insert($companyTypes);
    }
}
