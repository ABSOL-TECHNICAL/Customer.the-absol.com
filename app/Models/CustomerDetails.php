<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerDetails extends Model
{
    use HasFactory;
    public function PhysicalInformations()
    {
        return $this->hasMany(PhysicalInformations::class, 'id');
    }
    public function CustomerSites()
    {
        return $this->hasMany(CustomerSites::class, 'id');
    }
    public function keyManagements()
    {
        return $this->hasMany(KeyManagements::class, 'id');
    }
    public function LegalInformations()
    {
        return $this->hasMany(LegalInformations::class, 'id');
    }
    public function OtherDocuments()
    {
        return $this->hasMany(OtherDocuments::class, 'id');
    }
    public function Financials()
    {
        return $this->hasMany(Financials::class, 'id');
    }
    public function BankInformations()
    {
        return $this->hasMany(BankInformations::class, 'id');
    }
    public function BusinessReferences()
    {
        return $this->hasMany(BusinessReferences::class, 'id');
    }
    public function Address()
    {
        return $this->hasMany(Address::class, 'id');
    }
    public function bank():BelongsTo
    {
        return $this->belongsTo(Bank::class, 'id');
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
