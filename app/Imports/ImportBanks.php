<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\Branch;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportBanks implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Bank([
            
        'bank_code'=>$row[0],
        'bank_name'=> $row[1],
        'bank_status'=> $row[2],

        ]);
    }
}
