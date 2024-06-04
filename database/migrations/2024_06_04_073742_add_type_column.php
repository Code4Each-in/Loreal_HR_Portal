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
            $table->string('type')->nullable()->comment('1=>salary head, 2=>grade salary master')->after('involve_head_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dependent_salary_head', function (Blueprint $table) {
            if (Schema::hasColumn('dependent_salary_head', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
