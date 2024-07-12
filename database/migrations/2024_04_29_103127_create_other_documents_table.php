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
        Schema::create('other_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_types_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('document')->nullable();
            $table->string('document_path')->nullable(); 
            $table->string('description')->nullable();
            $table->string('terms')->nullable();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_documents');
    }
};
