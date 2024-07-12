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
        Schema::create('business_references', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_company')->nullable();
            $table->string('name_of_the_contact_person')->nullable();
            $table->string('email_address')->nullable();
            $table->bigInteger('telephone_number')->nullable();
            $table->bigInteger('mobile_number')->nullable();
            $table->string('year_relationship')->nullable();
            $table->foreignId('company_types_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_references');
    }
};
