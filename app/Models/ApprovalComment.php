<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalComment extends Model
{
    
    use HasFactory;
    
    
    protected $fillable = [
        'approval_status_id',
        'user_id',
        'comment',
        'customer_sites_id',
        'request_credit_value',
        'approved_credit_value',
        'payment_terms_id',
        'freight_terms_id',
        'account_type_id',
        'collector_id',
        'order_type_id',
        'price_list_id',
        'sales_representative_id',
        'sales_territory_id',
        'customer_categories_id',
        'address_id',
    ];
}
