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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('tech');
            $table->string('date', 50);
            $table->string('time', 20);
            $table->text('interval');
            $table->text('where');
            $table->text('job');
            $table->text('money');
            $table->text('photo_name')->nullable();
            $table->text('details')->nullable();
            $table->string('phone', 50);
            $table->bigInteger('user_id') -> nullable() -> unsigned();
            $table->foreign('user_id')->references('id')->on('users') -> nullOnDelete();
            $table->bigInteger('status_id') -> nullable() -> unsigned();
            $table->foreign('status_id')->references('id')->on('statuses') -> nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
