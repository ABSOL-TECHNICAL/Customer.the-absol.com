<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Collector;
use App\Models\KenyaCities;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportKenyacities implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new KenyaCities([
            
        'city'=>$row[0],
        'status'=> $row[1],

        ]);
    }
}
