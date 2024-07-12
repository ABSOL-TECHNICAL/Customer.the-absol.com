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
            $table->integer('approval_flow')
                ->default('incompleted')
                ->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_sites', function (Blueprint $table) {
            $table->dropColumn('approval_flow');
        });
    }
};
