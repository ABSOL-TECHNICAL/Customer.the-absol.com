<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAgeingReportsTable extends Migration
{
    public function up()
    {
        Schema::create('customer_ageing_reports', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('customer_name');
            $table->string('customer_number');
            $table->decimal('open_bucket', 10, 2);
            $table->decimal('current_bucket', 10, 2);
            $table->decimal('bucket_1_30_days', 10, 2);
            $table->decimal('bucket_31_60_days', 10, 2);
            $table->decimal('bucket_61_90_days', 10, 2);
            $table->decimal('bucket_91_120_days', 10, 2);
            $table->decimal('bucket121_180_days', 10, 2);
            $table->decimal('bucket_181_365_days', 10, 2);
            $table->decimal('bucket_1_2_years', 10, 2);
            $table->decimal('bucket_2_3_years', 10, 2);
            $table->decimal('above_3_years', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_ageing_reports');
    }
}
