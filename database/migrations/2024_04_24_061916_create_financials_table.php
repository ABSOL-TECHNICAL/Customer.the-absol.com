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
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('approx_turnover_for_last_year');
            $table->string('name_of_auditor')->nullable();
            $table->string('finance_contact_person')->nullable();
            $table->string('finance_email_address')->nullable();
            $table->bigInteger('finance_telephone_number')->nullable();
            $table->bigInteger('finance_mobile_number')->nullable();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financials');
    }
};
