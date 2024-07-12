<?php

use App\Models\Address;
use App\Models\BankInformations;
use App\Models\BusinessReferences;
use App\Models\Financials;
use App\Models\KeyManagements;
use App\Models\LegalInformations;
use App\Models\OtherDocuments;
use App\Models\PhysicalInformations;
use App\Models\Customer;
use App\Models\Documents;
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
        Schema::create('customer_sites', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BankInformations::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Address::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Financials::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PhysicalInformations::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(KeyManagements::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(LegalInformations::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(BusinessReferences::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(OtherDocuments::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Documents::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->tinyInteger('update_type')->default(0);
            $table->tinyInteger('customer_oracle_sync_site')->default(0);
            $table->string('customer_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_sites');
    }
};
