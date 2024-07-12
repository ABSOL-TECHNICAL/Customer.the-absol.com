<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Collector;
use App\Models\Currency;
use App\Models\KenyaCities;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCurrencies implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Currency([
            
        'currency_name'=>$row[0],
        'currency_code'=> $row[1],
        'currency_symbol'=> $row[2],
        'currency_status'=> $row[3],

        ]);
    }
}
