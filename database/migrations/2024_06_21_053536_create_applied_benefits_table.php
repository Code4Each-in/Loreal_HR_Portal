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
        Schema::create('applied_benefits', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('benefit_id')->nullable();
            $table->string('detail')->nullable();
            $table->string('status')->nullable()->comment('1=approved, 2=pending, 3=rejected');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applied_benefits');
    }
};
