<?php

namespace App\Imports;

use App\Models\OrderType;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportOrdertypes implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new OrderType([
            
        'order_type'=>$row[0],
        'order_status'=> $row[1],

        ]);
    }
}
