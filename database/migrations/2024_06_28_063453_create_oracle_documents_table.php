<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('oracle_documents', function (Blueprint $table) {
            $table->id();
            $table->string('other_documents_type')->nullable()->max(100);
            $table->string('other_documents_file_name')->nullable()->max(250);
            $table->string('bank_statement_type')->nullable()->max(100);
            $table->string('bank_statement_file_name')->nullable()->max(250);
            $table->string('pin_reg_cert_type')->nullable()->max(100);
            $table->string('pin_reg_cert_file_name')->nullable()->max(250);
            $table->string('buisness_permit_type')->nullable()->max(100);
            $table->string('buisness_permit_file_name')->nullable()->max(250);
            $table->string('cr12_Documents_type')->nullable()->max(100);
            $table->string('cr12_Documents_file_name')->nullable()->max(250);
            $table->string('coi_file_type')->nullable()->max(100);
            $table->string('coi_file_name')->nullable()->max(250);
            $table->string('passport_ceo_type')->nullable()->max(100);
            $table->string('passport_ceo_file_name')->nullable()->max(250);
            $table->string('passport_photo_ceo_type')->nullable()->max(100);
            $table->string('passport_photo_ceo_file_name')->nullable()->max(250);
            $table->string('statement_type')->nullable()->max(100);
            $table->string('statement_file_name')->nullable()->max(250);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oracle_documents');
    }
};
