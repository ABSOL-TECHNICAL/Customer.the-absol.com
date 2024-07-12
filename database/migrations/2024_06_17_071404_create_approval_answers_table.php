<?php

use App\Models\BusinessReferences;
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
        Schema::create('approval_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BusinessReferences::class)->constrained()->cascadeOnDelete();
            $table->string('answers_name')->nullable();
            $table->string('answers_email')->nullable();
            $table->string('answers_mobile')->nullable();
            $table->date('call_date_time')->nullable();
            $table->string('questionnaire_remarks')->nullable();
            $table->string('year_relationship_supplier')->nullable();
            $table->string('year_relationship_customer')->nullable();
            $table->string('payments')->nullable();
            $table->string('volume_business')->nullable();
            $table->string('credit_period')->nullable();
            $table->foreignIdFor(CustomerSites::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_answers');
    }
};
