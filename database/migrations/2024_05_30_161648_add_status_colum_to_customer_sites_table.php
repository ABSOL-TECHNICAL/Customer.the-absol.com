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
        Schema::table('customer_sites', function (Blueprint $table) {
            $table->enum('status', ['incompleted', 'submited', 'approved', 'rejected', 'resubmitted'])
                ->default('incompleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_sites', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
