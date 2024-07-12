<?php

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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('country_name');
            $table->string('country_code');
            $table->string('country_phone_code');
            $table->string('country_status');
            // $table->string('Region')->default(0);
            // $table->foreignId('territory_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
  }
};