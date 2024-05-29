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
        Schema::create('grade_wise_salary_masters', function (Blueprint $table) {
            $table->id();
            $table->string('head_title')->nullable();
            $table->string('amount')->nullable();
            $table->string('method')->nullable();
            $table->string('formula')->nullable();
            $table->string('grade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_wise_salarymaster');
    }
};
