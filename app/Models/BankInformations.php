<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BankInformations extends Model
{
    use HasFactory;

    protected $fillable=[
        'bank_id',
        'bank_account_number',
        'bank_holder_name',
        'bank_code',
        'branch_id',
        'has_banking_facilities',
        'banking_facilities_details',
        'bank_iban',
        'bank_swift',
        'country_id',
        'currency_id',
        'bank_preferred',
        'bank_details',
        'customer_id',
    ];

    public function bank():BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
