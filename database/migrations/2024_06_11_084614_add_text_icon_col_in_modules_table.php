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
        Schema::table('modules', function (Blueprint $table) {
              $table->string('text')->nullable()->after('route_name');
              $table->string('icon')->nullable()->after('text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            if (Schema::hasColumn('modules', 'text')) {
                $table->dropColumn('text');
            }
            if (Schema::hasColumn('modules', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
};
