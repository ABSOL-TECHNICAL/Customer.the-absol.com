<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalAnswers extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_references_id',
        'answers_name',
        'answers_email',
        'answers_mobile',
        'call_date_time',
        'questionnaire_remarks',
        'year_relationship_supplier',
        'year_relationship_customer',
        'payments',
        'volume_business',
        'credit_period',
        'customer_sites_id',
    ];


    public function BusinessReferences(): BelongsTo
    {
        return $this->belongsTo(BusinessReferences::class);
    }
}
