<?php

use App\Models\Customer;
use App\Models\CustomerSites;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('location_name')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->string('address_4')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('location_type')->nullable();
            $table->string('site_name')->nullable();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kenya_cities_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('territory_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('nearest_landmark')->nullable();
            $table->string('companylandline_number')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('payment_mode')->nullable();
            $table->tinyInteger('customer_site_synced')->default(0);
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
