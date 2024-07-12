<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Carbon;
use Carbon\Carbon;

class LegalInformations extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_of_incorporation',
        'certificate_of_incorporation_issue_date',
        'business_permit_issue_expiry_date',
        'business_permit_number',
        'pin_number',
        'certificate_of_incorporation_copy',
        'years_in_business',
        'pin_certificate_copy',
        'business_permit_copy',
        'cr12_documents',
        'passport_ceo',
        'passport_photo_ceo',
        'statement',
        'customer_id'
    ];



}
