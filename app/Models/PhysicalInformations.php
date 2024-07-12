<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhysicalInformations extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'name_of_the_company',
        'group_company_of',
        'website',
        'customer_id',
    ];
}
