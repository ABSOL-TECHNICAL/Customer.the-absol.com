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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            
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
        Schema::dropIfExists('documents');
    }
};
