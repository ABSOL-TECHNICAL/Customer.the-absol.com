<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'country_name',
        'country_code',
        'country_phone_code',
        'country_status',
        // 'Region',
        // 'territory_id',
    ];
    // public function Territory():BelongsTo{
    //     return $this->belongsTo(territory::class);
    // }

}