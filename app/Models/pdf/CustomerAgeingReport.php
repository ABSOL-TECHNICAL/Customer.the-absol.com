<?php

namespace App\Models\pdf;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAgeingReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'trx_date',
        'transaction_type',
        'trx_number',
        'purchase_order',
        'ship_to_site',
        'due_date',
        'due_days',
        'pdc_amount',
        'credited_amount',
        'balance'
    ];
}
