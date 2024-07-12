<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessApprovalFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'action',
        'order',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
