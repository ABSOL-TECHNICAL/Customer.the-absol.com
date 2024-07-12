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
        Schema::create('key_managements', function (Blueprint $table) {
            $table->id();
            $table->string('owner_contact_name')->nullable();
            $table->string('owner_contact_email_address')->nullable();
            $table->bigInteger('owner_contact_phone_number')->nullable();
            $table->string('ceo_contact_name')->nullable();
            $table->string('ceo_contact_email_address')->nullable();
            $table->bigInteger('ceo_contact_phone_number')->nullable();
            $table->string('cfo_contact_name')->nullable();
            $table->string('cfo_contact_email_address')->nullable();
            $table->bigInteger('cfo_contact_phone_number')->nullable();
            $table->string('payment_contact_name')->nullable();
            $table->string('payment_contact_email_address')->nullable();
            $table->bigInteger('payment_contact_phone_number')->nullable();
            $table->string('authorized_contact_name')->nullable();
            $table->string('authorized_contact_email_address')->nullable();
            $table->bigInteger('authorized_contact_phone_number')->nullable();
            $table->string('any_other_remarks')->nullable();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_management');
    }
};
