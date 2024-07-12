<?php

use App\Models\Role;
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
        Schema::create('process_approval_flows', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Role::class)->required()->constrained()->cascadeOnDelete();
            $table->enum('action', ['approve', 'verify', 'check'])->default('approve');
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_approval_flows');
    }
};
