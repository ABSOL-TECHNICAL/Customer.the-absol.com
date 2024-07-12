<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTypes extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_type_name'
        ,
        'legal_information_restriction',
        ];
}