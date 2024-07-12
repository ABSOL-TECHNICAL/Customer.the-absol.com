<?php

namespace App\Models;

use App\Enums\ApprovelStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_sites_id',
        'user_id',
        'status',
        'comment',
    ];

    protected $casts = [
        'status' => ApprovelStatus::class,
    ];

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
