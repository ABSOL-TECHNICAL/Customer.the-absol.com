<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherDocuments extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'document_types_id',
        'document',
        'document_path',
        'description',
        'customer_id',
        'terms'
    ];

}
