<?php

namespace App\Imports;

use App\Models\chambermembership;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportChambermemberships implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ChamberMembership ([
            // 'id'=> $row['0'],
            'chamber_memberships'=> $row[0],
        ]);
    }
}
