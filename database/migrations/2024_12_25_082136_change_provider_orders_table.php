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
        //
        Schema::table('provider_orders', function (Blueprint $table) {
			$table->bigInteger('manager_id') -> nullable() -> unsigned();
            $table->foreign('manager_id')->references('id')->on('users') -> nullOnDelete();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
