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
        Schema::create('provider_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('user_id') -> nullable() -> unsigned();
            $table->foreign('user_id')->references('id')->on('users') -> nullOnDelete();

            $table->bigInteger('order_id') -> nullable() -> unsigned();
            $table->foreign('order_id')->references('id')->on('orders') -> nullOnDelete();

            $table->bigInteger('status_id') -> nullable() -> unsigned();
            $table->foreign('status_id')->references('id')->on('statuses') -> nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_orders');
    }
};
