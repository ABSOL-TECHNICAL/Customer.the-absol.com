<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessReferences extends Model
{
    use HasFactory;

    protected $fillable=[
        'name_of_company',
        'name_of_the_contact_person',
        'email_address',
        'telephone_number',
        'mobile_number',
        'company_types_id',
        'year_relationship',
        'customer_id',
        
    ];

    // public function companyTypes():BelongsTo{
    //     return $this->belongsTo(CompanyTypes::class);
    // }

}
