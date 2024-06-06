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
        Schema::table('dependent_salary_head', function (Blueprint $table) {
            $table->string('grade')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dependent_salary_head', function (Blueprint $table) {
            if (Schema::hasColumn('dependent_salary_head', 'grade')) {
                $table->dropColumn('grade');
            }
        });
    }
};
