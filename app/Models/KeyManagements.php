<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyManagements extends Model
{
    use HasFactory;
    protected $fillable =[
       'owner_contact_name',
        'owner_contact_email_address',
        'owner_contact_phone_number',
        'ceo_contact_name',
        'ceo_contact_email_address',
        'ceo_contact_phone_number',
        'cfo_contact_name',
        'cfo_contact_email_address',
        'cfo_contact_phone_number',
        'payment_contact_name',
        'payment_contact_email_address',
        'payment_contact_phone_number',
        'authorized_contact_name',
        'authorized_contact_email_address',
        'authorized_contact_phone_number',     
        'any_other_remarks',
        'customer_id',
    ];
}