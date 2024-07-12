<?php

use App\Models\Customer;
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
        Schema::create('legal_informations', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_of_incorporation')->nullable();
            $table->date('certificate_of_incorporation_issue_date')->nullable();
            $table->date('business_permit_issue_expiry_date')->nullable();
            $table->string('business_permit_number')->nullable();
            $table->string('pin_number')->nullable();
            $table->string('years_in_business')->nullable();
            $table->text('certificate_of_incorporation_copy')->nullable();
             $table->text('passport_ceo')->nullable();
             $table->text('passport_photo_ceo')->nullable();
            $table->text('pin_certificate_copy')->nullable();
            $table->text('business_permit_copy')->nullable();
            $table->text('cr12_documents')->nullable();
            $table->text('statement')->nullable();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_informations');
    }
};
