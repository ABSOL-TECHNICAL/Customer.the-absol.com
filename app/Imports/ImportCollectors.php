<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Collector;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCollectors implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Collector([
            
        'collector_name'=>$row[0],
        'collector_status'=> $row[1],

        ]);
    }
}
