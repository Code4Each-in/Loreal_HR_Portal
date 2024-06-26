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
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('grade')->nullable();
            $table->string('base_pay')->nullable();
            $table->string('basic_percentage')->nullable();
            $table->string('incentive')->nullable();
            $table->string('vpp_percentage')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_slips');
    }
};
