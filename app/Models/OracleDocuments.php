<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OracleDocuments extends Model
{
    use HasFactory;

    protected $fillable=[
        'coi_file_name',
        'other_documents_type',
        'other_documents_file_name',
        'bank_statement_type',
        'bank_statement_file_name',
        'pin_reg_cert_type',
        'pin_reg_cert_file_name',
        'buisness_permit_type',
        'buisness_permit_file_name',
        'cr12_Documents_type',
        'cr12_Documents_file_name',
        'coi_file_type',
        'passport_ceo_file_name',
        'passport_ceo_type',
        'passport_photo_ceo_file_name',
        'passport_photo_ceo_type',
        'statement_file_name',
        'statement_type',
    ];
}
