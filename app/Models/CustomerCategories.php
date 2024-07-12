<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCategories extends Model
{
    use HasFactory;
    protected $fillable = [
    'customer_categories_name',
    'customer_categories_status',
    ];
}
