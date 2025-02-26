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
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('comp_name')->nullable();
            $table->text('inn')->nullable();
            $table->text('kpp')->nullable();
            $table->text('bik')->nullable();
            $table->text('check')->nullable();
            $table->text('bank_name')->nullable();
            $table->text('file_name')->nullable();
            $table->bigInteger('user_id') -> nullable() -> unsigned();
            $table->foreign('user_id')->references('id')->on('users') -> nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details');
    }
};
