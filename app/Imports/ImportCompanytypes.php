<?php

namespace App\Imports;


use App\Models\CompanyTypes;

use Maatwebsite\Excel\Concerns\ToModel;

class ImportCompanytypes implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CompanyTypes([
            
        'company_type_name'=>$row[0],
        'legal_information_restriction'=> $row[1],

        ]);
    }
}
