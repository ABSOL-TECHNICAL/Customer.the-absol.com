<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Territory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'territory',
        'status',
        'country_id',
    ];
    public function country():BelongsTo{
        return $this->belongsTo(Country::class);
    }
}