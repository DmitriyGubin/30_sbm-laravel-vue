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
        Schema::create('techs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('type')->nullable();
            $table->text('name')->nullable();
            $table->text('char_one')->nullable();
            $table->text('char_two')->nullable();
            $table->text('char_three')->nullable();
            $table->text('price_nds')->nullable();
            $table->text('price_no_nds')->nullable();
            $table->text('min_hour')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('techs');
    }
};
