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
            $table->text('type');
            $table->text('name');
            $table->text('char_one');
            $table->text('char_two');
            $table->text('char_three');
            $table->text('price_nds');
            $table->text('price_no_nds');
            $table->text('min_hour');
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
