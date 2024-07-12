<?php

namespace App\Imports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCountrys implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Country([
            //
        'country_name'=>$row[0],
        'country_code'=>$row[1],
        'country_phone_code'=>$row[2],
        'country_status'=>$row[3],
        
        ]);
    }
}
