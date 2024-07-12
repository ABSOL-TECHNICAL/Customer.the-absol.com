<?php

namespace App\Imports;

use App\Models\Branch;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportBranches implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Branch([
            
        'bank_id'=>$row[0],
        'branch_code'=> $row[1],
        'branch_name'=> $row[2],
        'branch_status'=> $row[3],

        ]);
    }
}
