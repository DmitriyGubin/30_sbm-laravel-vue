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
        Schema::create('provider_teches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('provider_id') -> nullable() -> unsigned();
            $table->foreign('provider_id')->references('id')->on('users') -> nullOnDelete();

            $table->bigInteger('tech_id') -> nullable() -> unsigned();
            $table->foreign('tech_id')->references('id')->on('technics') -> nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_teches');
    }
};
