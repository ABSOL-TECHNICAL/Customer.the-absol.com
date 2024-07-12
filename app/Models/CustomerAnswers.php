<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAnswers extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
       'customer_questionnaire_datetime',
        'customer_questionnaire_remarks',
        'is_saved_as_draft',
        'business_references_id',
   ];
   public function BusinessReferences():BelongsTo{
    return $this->belongsTo(BusinessReferences::class);

}
}