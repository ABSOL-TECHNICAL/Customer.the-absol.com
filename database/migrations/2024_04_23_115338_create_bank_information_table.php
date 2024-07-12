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
        Schema::create('bank_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained()->cascadeOnDelete();
            $table->text('bank_account_number');
            $table->string('bank_holder_name');
            $table->string('bank_code');
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('has_banking_facilities');
            $table->text('banking_facilities_details')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('bank_swift')->nullable();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('bank_preferred');
            $table->string('bank_details')->nullable();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_information');
    }
};
