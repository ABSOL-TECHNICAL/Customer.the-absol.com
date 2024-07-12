<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use HasFactory;

    protected $fillable=[
        'bank_id',
        'branch_code',
        'branch_name',
        'branch_status',
    ];

    public function bank():BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
