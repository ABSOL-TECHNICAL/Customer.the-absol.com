<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTerms extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_term_name',
        'payment_term_description',
        'payment_term_status',
        'payment_term_end_date',
    ];

    protected $casts = [
        'payment_term_end_date'=> 'date',
    ];
}