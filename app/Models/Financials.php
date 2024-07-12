<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financials extends Model
{
    use HasFactory;
    protected $fillable = [
        'approx_turnover_for_last_year',
        'name_of_auditor',
        'finance_contact_person',
        'finance_email_address',
        'finance_telephone_number',
        'finance_mobile_number',
        'customer_id',
    ];
}
