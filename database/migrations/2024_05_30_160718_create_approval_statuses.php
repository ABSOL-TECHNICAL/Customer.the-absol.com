<?php

use App\Models\CustomerSites;
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
        Schema::create('approval_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CustomerSites::class)
                ->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(User::class)
                ->constrained()
                ->onDelete('cascade');
            $table->enum('status', ['processing', 'approved', 'rejected'])
                ->default('processing');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_statuses');
    }
};
