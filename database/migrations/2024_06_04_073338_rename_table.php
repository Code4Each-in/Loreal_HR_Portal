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
        Schema::rename('delete_salaryhead_ids', 'dependent_salary_head');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
