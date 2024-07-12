<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documents extends Model
{
    use HasFactory;
    protected $fillable = [
        'certificate_of_incorporation_copy',
        'pin_certificate_copy',
        'business_permit_copy',
        'cr12_documents',
        'passport_ceo',
        'passport_photo_ceo',
        'statement',
        'customer_id'
    ];
    public function PhysicalInformations(): BelongsTo
    {
        return $this->belongsTo(PhysicalInformations::class, 'id');
    }

    public function LegalInformations():BelongsTo
    {
        return $this->BelongTo(LegalInformations::class, 'id');
    }
    public function otherDocuments():HasMany
    {
        return $this->hasMany(OtherDocuments::class, 'id');
    }
    public function bankInformations():HasMany
    {
        return $this->hasMany(BankInformations::class, 'id');
    }
}

