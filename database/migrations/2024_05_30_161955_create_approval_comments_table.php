<?php

use App\Models\AccountType;
use App\Models\Address;
use App\Models\ApprovalStatus;
use App\Models\Collector;
use App\Models\CustomerCategories;
use App\Models\FreightTerms;
use App\Models\OrderType;
use App\Models\PaymentTerms;
use App\Models\PriceList;
use App\Models\CustomerSites;
use App\Models\SalesRepresentative;
use App\Models\SalesTerritory;
use App\Models\User;
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
        Schema::create('approval_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ApprovalStatus::class)
                ->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(User::class)
                ->constrained()
                ->onDelete('cascade');
                $table->foreignIdFor(CustomerSites::class)->constrained()->cascadeOnDelete();
            $table->text('comment');
            $table->string('request_credit_value')->nullable()->constrained()->cascadeOnDelete();
            $table->string('approved_credit_value')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PaymentTerms::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(FreightTerms::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(OrderType::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(AccountType::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(SalesTerritory::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(SalesRepresentative::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Collector::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(CustomerCategories::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(PriceList::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Address::class)->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_comments');
    }
};
